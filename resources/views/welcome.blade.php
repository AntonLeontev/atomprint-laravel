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
    <div class="container">
        <div class="row fw-bold text-center">
            <div class="col-3">title</div>
            <div class="col-2">price</div>
            <div class="col-1">color</div>
        </div>
		<template x-data="cartridges" x-init="loadData" 
			x-for="cartridge in cartridges" :key="cartridge.id"
			
		>
			<form action="" method="post">
				<div class="row text-center">
					<div class="col-3 d-flex flex-column px-0" data-column="title" :data-id="cartridge.id">
						<span 
							@dblclick="edit" x-show="! show.title[cartridge.id]"
							x-text="cartridge.title"
							class="py-1 px-2 h-100"
						></span>
						<input 
							x-show="show.title[cartridge.id]" @blur="blur" @keyUp.enter="blur" 
							x-model="cartridge.title"
							name="title" type="text" class="border-0">
					</div>
					<div class="col-2 d-flex flex-column px-0" data-column="price" :data-id="cartridge.id">
						<span
							@dblclick="edit" x-show="! show.price[cartridge.id]" 
							x-text="cartridge.price.raw"
							class="py-1 px-2 h-100"
						></span>
						<input 
							x-show="show.price[cartridge.id]" @blur="blur" @keyUp.enter="blur"
							x-model="cartridge.price.raw"
							class="border-0" name="price" type="text">
					</div>
					<div class="col-1 d-flex flex-column px-0" data-column="color" :data-id="cartridge.id">
						<span 
							@dblclick="edit" x-show="! show.color[cartridge.id]"
							x-text="cartridge.color.title"
							class="py-1 px-2 h-100"
						></span>
						<select 
							x-show="show.color[cartridge.id]" @blur="blur"
							x-model="cartridge.color.title" 
							class="border-0 h-100" name="color_title"
						>
							<template x-for="color in colors">
								<option 
									x-text="color.title" :value="color.title" 
									:selected="color.id === cartridge.color.id">
								</option>
							</template>
						</select>
					</div>
				</div>
				<div class="row">
				</div>
			</form>
		</template>
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
				edit: function(event){
					let parent = event.target.parentNode;
					let column = parent.dataset.column;
					let id = parent.dataset.id;

					this.show[column][id] = true;

					element = parent.querySelector('input');
					if(!element){
						element = parent.querySelector('select');
					}

					if(element) {
						setTimeout(() => {
							element.focus();
						}, 100);
					}
				},
				blur: function(){
					let parent = event.target.parentNode;
					let column = parent.dataset.column;
					let id = parent.dataset.id;

					this.show[column][id] = false;
				}
            }))

			
        })

    </script>
</body>

</html>
