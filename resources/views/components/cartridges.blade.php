<div x-data="cartridges" x-init="loadData" @filter-change.window="applyFilters">
    <div class="row fw-bold text-center">
        <div class="col-3">title</div>
        <div class="col-2">price</div>
        <div class="col-1">color</div>
    </div>
    <template x-for="cartridge in cartridges.data" :key="cartridge.id">
        <form :action="'cartridge/' + cartridge.id + '/update'" method="post" @change="saveCartridge">
            <div class="row text-center">
                <div class="col-3 d-flex flex-column px-0" data-column="title" :data-id="cartridge.id">
                    <span class="h-100 py-1 px-2" @dblclick="edit" x-show="! show.title[cartridge.id]"
                        x-text="cartridge.title"></span>
                    <input class="border-0" name="title" type="text" x-show="show.title[cartridge.id]"
                        @blur="blur" @keyUp.enter.prevent="blur" x-model="cartridge.title">
                </div>
                <div class="col-2 d-flex flex-column px-0" data-column="price" :data-id="cartridge.id">
                    <span class="h-100 py-1 px-2" @dblclick="edit" x-show="! show.price[cartridge.id]"
                        x-text="cartridge.price.raw"></span>
                    <input class="border-0" name="price" type="text" x-show="show.price[cartridge.id]"
                        @blur="blur" @keyUp.enter.prevent="blur" x-model="cartridge.price.raw">
                </div>
                <div class="col-1 d-flex flex-column px-0" data-column="color" :data-id="cartridge.id">
                    <span class="h-100 py-1 px-2" @dblclick="edit" x-show="! show.color[cartridge.id]"
                        x-text="cartridge.color.title"></span>
                    <select class="h-100 border-0" name="color_title" x-show="show.color[cartridge.id]" @blur="blur"
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
    <div class="row" x-show="cartridges.prev_page_url || cartridges.next_page_url" x-cloak>
        <div class="col-2 d-flex justify-content-end">
            <button class="btn btn-primary" :disabled="!cartridges.prev_page_url" @click="updatePage"
                :data-link="cartridges.prev_page_url">
                Prev
            </button>
        </div>
        <div class="col-2 text-center" x-text="cartridges.current_page"></div>
        <div class="col-2 d-flex justify-content-start">
            <button class="btn btn-primary" :disabled="!cartridges.next_page_url" @click="updatePage"
                :data-link="cartridges.next_page_url">
                Next
            </button>
        </div>
    </div>
</div>

<script>
    document.addEventListener('alpine:init', () => {
        Alpine.data('cartridges', () => ({
            cartridges: [],
            colors: [],
            show: {
                title: [],
                price: [],
                color: []
            },
            loadData: function() {
                this.loadCartridges();
                this.getColors();
            },
			loadCartridges: function(){
				this.getCartridges('{{ route('cartridges.index') }}');
			},
			applyFilters: function(event){
				filters = event.detail.filters;
				this.getCartridges('{{ route('cartridges.index') }}', filters);
			},
            getCartridges: async function(url, formData = null) {
				axios.get(url, {
					params: new URLSearchParams(formData)
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

                this.show[column][id] = true;

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

                this.show[column][id] = false;
            },
            updatePage: async function(event) {
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
