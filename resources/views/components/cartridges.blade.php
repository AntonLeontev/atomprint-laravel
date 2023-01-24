<div x-data="cartridges" x-init="loadData" @list-change.window="applyChanges" 
	@sort-change.window="applySort">
    <x-cartridges.head />
    <template x-for="cartridge in cartridges.data" :key="cartridge.id">
        <form :action="'cartridge/' + cartridge.id + '/update'" method="post" @change="saveCartridge">
            <div class="row text-center">
                <div class="col-3 d-flex flex-column px-0" data-column="title" :data-id="cartridge.id">
                    <span class="h-100 py-1 px-2" @dblclick="edit" x-show="! edited.title[cartridge.id]"
                        x-text="cartridge.title"></span>
                    <input class="border-0" name="title" type="text" x-show="edited.title[cartridge.id]"
                        @blur="blur" @keyUp.enter.prevent="blur" x-model="cartridge.title">
                </div>
                <div class="col-2 d-flex flex-column px-0" data-column="price" :data-id="cartridge.id">
                    <span class="h-100 py-1 px-2" @dblclick="edit" x-show="! edited.price[cartridge.id]"
                        x-text="cartridge.price.raw"></span>
                    <input class="border-0" name="price" type="text" x-show="edited.price[cartridge.id]"
                        @blur="blur" @keyUp.enter.prevent="blur" x-model="cartridge.price.raw">
                </div>
                <div class="col-2 d-flex flex-column px-0" data-column="color" :data-id="cartridge.id">
                    <span class="h-100 py-1 px-2" @dblclick="edit" x-show="! edited.color[cartridge.id]"
                        x-text="cartridge.color.title"></span>
                    <select class="h-100 border-0" name="color_title" x-show="edited.color[cartridge.id]" @blur="blur"
                        x-model="cartridge.color.title">
                        <template x-for="color in colors">
                            <option x-text="color.title" :value="color.title"
                                :selected="color.id === cartridge.color.id">
                            </option>
                        </template>
                    </select>
                </div>
            </div>
        </form>
    </template>
    <x-pagination />
</div>

<script>
    document.addEventListener('alpine:init', () => {
        Alpine.data('cartridges', () => ({
            cartridges: [],
            colors: [],
            edited: {
                title: [],
                price: [],
                color: []
            },
			state: {
				filter: null,
				sort: null,
				search: null,
			},
            loadData: function() {
                this.loadCartridges();
                this.getColors();
            },
			loadCartridges: function(){
				this.getCartridges('{{ route('cartridges.index') }}');
			},
			applyChanges: function(event){
				console.log('apply');
				params = event.detail.params;

				this.state[event.detail.type] = params;

				this.getCartridges('{{ route('cartridges.index') }}');
			},
			createParams: function(){
				let params = new URLSearchParams();

				for(key in this.state){
					this.appendParams(params, this.state[key]);
				}

				return params;
			},
			appendParams: function(params1, params2){
				if(params2 === null) return;

				for (let [key, val] of params2.entries()) {
					params1.append(key, val);
				}
			},
            getCartridges: async function(url, formData = null) {
				axios.get(url, {
					params: this.createParams()
				})
					.then(response => {
						this.cartridges = response.data;
					})
					.catch((error) => {
						this.$dispatch('toast-error', { message: error.code })
					});
            },
            getColors: async function() {
                axios.get('/colors')
                    .then(response => {
                        this.colors = response.data;
                    })
                    .catch((error) => {
                        this.$dispatch('toast-error', { message: error.code })
                    });
            },
            edit: function(event) {
                let parent = event.target.parentNode;
                let column = parent.dataset.column;
                let id = parent.dataset.id;

                this.edited[column][id] = true;

                element = parent.querySelector('input');
                if (!element) {
                    element = parent.querySelector('select');
                }

                if (element) {
                    this.$nextTick(() => {
                        element.focus()
                    })
                }
            },
            blur: function() {
                let parent = event.target.parentNode;
                let column = parent.dataset.column;
                let id = parent.dataset.id;

                this.edited[column][id] = false;
            },
            changePage: async function(event) {
				this.getCartridges(event.target.dataset.link);
            },
            saveCartridge: async function(event) {
                response = await submitForm(event);

                if (_.isUndefined(response)) return;

                this.$dispatch('toast-success', {
                    message: 'Сохранено',
                });
            },
        }))
    })
</script>
