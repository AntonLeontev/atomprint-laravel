<div class="cartridges position-relative"
	x-data="cartridges" x-init="initialize" @list-change.window="applyChanges" 
	@sort-change.window="applySort" @reset.window="reset"
>

    <x-cartridges.head. />

    <template x-for="cartridge in cartridges.data" :key="cartridge.id">
        <form 
			class="form-cartridge" :data-id="cartridge.id"
			:action="'cartridges/' + cartridge.id + '/update'" method="post" 
			@change="saveCartridge">
            <div class="row text-center">
				<div class="no-mark col d-flex flex-column px-0 py-1" x-text="cartridge.vendor_title"></div>

                <div class="col d-flex flex-column px-0" data-column="title">
                    <span class="h-100 py-1" @dblclick="edit" x-show="! edited.title[cartridge.id]"
                        x-text="cartridge.title"></span>
                    <input class="border-0" name="title" type="text" x-show="edited.title[cartridge.id]"
                        @blur="blur" @keyUp.enter.prevent="blur" x-model="cartridge.title">
                </div>

                <div class="col d-flex flex-column px-0" data-column="price_1">
                    <span 
						class="no-mark h-100 py-1" 
						@dblclick="edit" x-show="! edited.price_1[cartridge.id]"
                        x-text="cartridge.price_1.value"></span>
                    <input 
						class="border-0" name="price_1" type="text" 
						x-show="edited.price_1[cartridge.id]"
                        @blur="blur" @keyUp.enter.prevent="blur" x-model="cartridge.price_1.value">
                </div>

				<div class="col d-flex flex-column px-0" data-column="price_2">
                    <span 
						class="no-mark h-100 py-1 px-2" 
						@dblclick="edit" x-show="! edited.price_2[cartridge.id]"
                        x-text="cartridge.price_2.value"></span>
                    <input 
						class="border-0" name="price_2" type="text" 
						x-show="edited.price_2[cartridge.id]"
                        @blur="blur" @keyUp.enter.prevent="blur" x-model="cartridge.price_2.value">
                </div>

				<div class="col d-flex flex-column px-0" data-column="price_5">
                    <span 
						class="no-mark h-100 py-1 px-2" 
						@dblclick="edit" x-show="! edited.price_5[cartridge.id]"
                        x-text="cartridge.price_5.value"></span>
                    <input 
						class="border-0" name="price_5" type="text" 
						x-show="edited.price_5[cartridge.id]"
                        @blur="blur" @keyUp.enter.prevent="blur" x-model="cartridge.price_5.value">
                </div>

				<div class="col d-flex flex-column px-0" data-column="price_office">
                    <span 
						class="no-mark h-100 py-1 px-2" 
						@dblclick="edit" x-show="! edited.price_office[cartridge.id]"
                        x-text="cartridge.price_office.value"></span>
                    <input 
						class="border-0" name="price_office" type="text" 
						x-show="edited.price_office[cartridge.id]"
                        @blur="blur" @keyUp.enter.prevent="blur" x-model="cartridge.price_office.value">
                </div>

                <div class="col d-flex flex-column px-0" data-column="color">
                    <span 
						class="no-mark h-100 py-1 px-2" 
						@dblclick="edit" x-show="! edited.color[cartridge.id]"
                        x-text="cartridge.color_title"></span>
                    <select 
						class="h-100 border-0" name="color_title" 
						x-show="edited.color[cartridge.id]" @blur="blur" x-model="cartridge.color_title"
					>
                        <template x-for="color in colors">
                            <option x-text="color.title" :value="color.title"
                                :selected="color.title === cartridge.color_title">
                            </option>
                        </template>
                    </select>
                </div>
            </div>

			<hr class="my-0 mx-5">

			<div class="row text-left mx-0" data-column="printers" :data-id="cartridge.id">
				<span 
					class="h-100 py-1 px-2 text-pre-line"
					x-show="! edited.printers[cartridge.id]" x-text="cartridge.printers" @dblclick="edit">
				</span>
				<textarea 
					name="printers" cols="30" rows="4"
					x-model="cartridge.printers"
					x-show="edited.printers[cartridge.id]" @blur="blur"
				></textarea>
			</div>
        </form>
    </template>
	<template x-if="cartridges.data?.length === 0">
		<div class="min-vh-100 d-flex justify-content-center align-items-center">
			Ничего не найдено
		</div>
	</template>
	<div class="row mt-2">
		<x-pagination />
	</div>

</div>

<script>
    document.addEventListener('alpine:init', () => {
        Alpine.data('cartridges', () => ({
            edited: {
                title: [],
                price_1: [],
                price_2: [],
                price_5: [],
                price_office: [],
                printers: [],
                color: []
            },
            initialize() {
				params = new URLSearchParams(location.search);
                this.getCartridges('{{ route('cartridges.index') }}', params);

                this.loadColors();
            },
			applyChanges: async function(event){
				params = event.detail.params;

				this.state[event.detail.type] = params;

				this.changeUrl();

				await this.getCartridges('{{ route('cartridges.index') }}');

				this.mark();
			},
			changeUrl(){
				const url = new URL(window.location);
				let params = this.createParams().toString();
				window.history.pushState({}, '', url.origin + '?' + params);
			},
			createParams: function(){
				let params = new URLSearchParams();

				for(key in this.state){
					this.appendParams(params, this.state[key]);
				}

				return params;
			},
			appendParams: function(params1, params2){
				if(_.isNull(params2)) return;

				for (let [key, val] of params2.entries()) {
					params1.append(key, val);
				}
			},
            getCartridges: async function(url, params = null) {
				this.$dispatch('request-start');

				if(_.isNull(params)) {
					params = this.createParams();
				}

				await axios.get(url, {
					params: params
				})
					.then(response => {
						this.cartridges = response.data;
						this.$dispatch('request-finish');
					})
					.catch((error) => {
						this.$dispatch('toast-error', { message: error.code })
						this.$dispatch('request-finish');
					});
            },
            loadColors: async function() {
                axios.get('/colors')
                    .then(response => {
                        this.colors = response.data;
                    })
                    .catch((error) => {
                        this.$dispatch('toast-error', { message: error.code })
                    });
            },
            edit: function(event) {
                let column = event.target.closest('[data-column]').dataset.column;
                let id = event.target.closest('[data-id]').dataset.id;

                this.edited[column][id] = true;

                element = event.target.closest('[data-column]').querySelector('input');

                if (!element) {
                    element = event.target.closest('[data-column]').querySelector('select');
                }
				if (!element) {
                    element = event.target.closest('[data-column]').querySelector('textarea');
                }

                if (element) {
                    this.$nextTick(() => {
                        element.focus()
                    })
                }
            },
            blur: function() {
                let column = event.target.closest('[data-column]').dataset.column;
                let id = event.target.closest('[data-id]').dataset.id;

                this.edited[column][id] = false;
            },
            changePage: async function(event) {
				await this.getCartridges(event.target.dataset.link);

				this.mark();
            },
            saveCartridge: async function(event) {
                response = await submitForm(event);

                if (_.isUndefined(response)) return;

                this.$dispatch('toast-success', {
                    message: 'Сохранено',
                });
            },
			mark(){
				if (_.isNil(this.state.search)) return;

				let context = document.querySelector('.cartridges');
				let mark = new Mark(context);
				mark.mark(this.state.search.get('search'), {"exclude": [".no-mark"]});
			},
			reset(){
				if(_.isEmpty(this.state)) return;

				this.state = {};

				this.getCartridges('{{ route('cartridges.index') }}');
				
				window.history.pushState({}, '', location.origin);
			},
        }))
    })
</script>
