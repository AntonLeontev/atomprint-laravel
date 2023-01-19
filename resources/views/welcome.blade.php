<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="token" content="{{ csrf_token() }}">

    <title>Laravel</title>

    @vite(['resources/sass/app.scss', 'resources/js/app.js'])

</head>

<body>
    <div class="container" x-data="cartridges" x-init="loadData">
        <div class="row fw-bold text-center">
            <div class="col-3"></div>
            <div class="col-3">title</div>
            <div class="col-2">price</div>
            <div class="col-1">color</div>
        </div>
        <template x-for="cartridge in cartridges.data" :key="cartridge.id">
            <form :action="'cartridge/' + cartridge.id + '/update'" method="post" @change="saveCartridge">
                <div class="row text-center">
                    <div class="col-3"></div>
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
                        <select class="h-100 border-0" name="color_title" x-show="show.color[cartridge.id]"
                            @blur="blur" x-model="cartridge.color.title">
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
        <div class="row" x-show="cartridges.prev_page_url || cartridges.next_page_url">
            <div class="col-3"></div>
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
		<div @click="$dispatch('toast', {message: 'test toast'})" class="btn btn-success">Toast</div>
    </div>
	<x-toast/>
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
                    this.getCartridges();
                    this.getColors();
                },
                getCartridges: async function() {
                    axios.get('/cartridges')
                        .then(response => {
                            this.cartridges = response.data;
                        })
                        .catch((error) => {
                            console.log(error.code)
                        });
                },
                getColors: async function() {
                    axios.get('/colors')
                        .then(response => {
                            this.colors = response.data;
                        })
                        .catch((error) => {
                            console.log(error.code)
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
                        setTimeout(() => {
                            element.focus();
                        }, 100);
                    }
                },
                blur: function() {
                    let parent = event.target.parentNode;
                    let column = parent.dataset.column;
                    let id = parent.dataset.id;

                    this.show[column][id] = false;
                },
                updatePage: async function(event) {
                    axios.get(event.target.dataset.link)
                        .then(response => {
                            this.cartridges = response.data;
                        })
                        .catch((error) => {
                            console.log(error.code)
                        });
                },
				saveCartridge: async function(event) {
					response = submitForm(event);
					console.log(response);
					if (response) {
						this.$dispatch('toast', {
							message: 'Сохранено',
							type: 'success',
						});
					}
				},
            }))


        })
    </script>
</body>

</html>
