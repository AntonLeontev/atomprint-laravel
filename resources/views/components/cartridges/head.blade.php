<div 
	class="row fw-bold text-center"
	x-data="cartridgesHead"
>
	<div class="col hstack justify-content-center" @click="sort('vendor_title')">
		Бренд
		<span x-show="state.sort === 'vendor_title'" x-cloak>
			<x-cartridges.sort-image/>
		</span>
	</div>
	<div class="col hstack justify-content-center" @click="sort('title')">
		Название
		<span x-show="state.sort === 'title'" x-cloak>
			<x-cartridges.sort-image/>
		</span>
	</div>
	<div class="col hstack justify-content-center" @click="sort('price_1')">
		Цена-1
		<span x-show="state.sort === 'price_1'" x-cloak>
			<x-cartridges.sort-image/>
		</span>
	</div>
	<div class="col hstack justify-content-center" @click="sort('price_2')">
		Цена-2
		<span x-show="state.sort === 'price_2'" x-cloak>
			<x-cartridges.sort-image/>
		</span>
	</div>
	<div class="col hstack justify-content-center" @click="sort('price_5')">
		Цена-5
		<span x-show="state.sort === 'price_5'" x-cloak>
			<x-cartridges.sort-image/>
		</span>
	</div>
	<div class="col hstack justify-content-center" @click="sort('price_office')">
		Офис
		<span x-show="state.sort === 'price_office'" x-cloak>
			<x-cartridges.sort-image/>
		</span>
	</div>
	<div class="col hstack justify-content-center" @click="sort('color_title')">
		Цвет
		<span x-show="state.sort === 'color_title'" x-cloak>
			<x-cartridges.sort-image/>
		</span>
	</div>
</div>

<script>
	document.addEventListener('alpine:init', () => {
		Alpine.data('cartridgesHead', () => ({
			state: {
				sort: null,
				order: 'ASC'
			},
			sort: function(column){
				this.changeState(column);

				let params = this.prepareParams();

				this.$dispatch('list-change', {
					params,
					type: 'sort',
				})
			},
			changeState(column){
				if(this.state.sort === column) {
					this.changeOrder();
				} else {
					this.state.sort = column;
					this.state.order = 'ASC';
				}
			},
			changeOrder(){
				if(this.state.order === 'ASC') {
					this.state.order = 'DESC';
					return;
				}
				
				this.state.order = 'ASC';
			},
			prepareParams(){
				let params = new URLSearchParams();

				for (const key in this.state) {
					if (Object.hasOwnProperty.call(this.state, key)) {
						params.append(key, this.state[key]);
					}
				}

				return params;
			},
		}))
	})
</script>
