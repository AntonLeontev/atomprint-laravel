<div 
	class="row fw-bold text-center"
	x-data="cartridgesHead"
>
	<div class="col-3" @click="sort('title')">
		Название
		<span x-show="state.sort === 'title'" x-cloak>
			<svg x-show="state.order === 'DESC'" 
			xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" viewBox="0 0 16 16">
				<path d="M7.247 11.14 2.451 5.658C1.885 5.013 2.345 4 3.204 4h9.592a1 1 0 0 1 .753 1.659l-4.796 5.48a1 1 0 0 1-1.506 0z"/>
			</svg>
			<svg x-show="state.order === 'ASC'"
			xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-caret-up-fill" viewBox="0 0 16 16">
				<path d="m7.247 4.86-4.796 5.481c-.566.647-.106 1.659.753 1.659h9.592a1 1 0 0 0 .753-1.659l-4.796-5.48a1 1 0 0 0-1.506 0z"/>
			</svg>
		</span>
	</div>
	<div class="col-2" @click="sort('price')">
		Цена
		<span x-show="state.sort === 'price'" x-cloak>
			<svg x-show="state.order === 'DESC'" 
			xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" viewBox="0 0 16 16">
				<path d="M7.247 11.14 2.451 5.658C1.885 5.013 2.345 4 3.204 4h9.592a1 1 0 0 1 .753 1.659l-4.796 5.48a1 1 0 0 1-1.506 0z"/>
			</svg>
			<svg x-show="state.order === 'ASC'"
			xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-caret-up-fill" viewBox="0 0 16 16">
				<path d="m7.247 4.86-4.796 5.481c-.566.647-.106 1.659.753 1.659h9.592a1 1 0 0 0 .753-1.659l-4.796-5.48a1 1 0 0 0-1.506 0z"/>
			</svg>
		</span>
	</div>
	<div class="col-2" @click="sort('color_id')">
		Цвет
		<span x-show="state.sort === 'color_id'" x-cloak>
			<svg x-show="state.order === 'DESC'" 
			xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" viewBox="0 0 16 16">
				<path d="M7.247 11.14 2.451 5.658C1.885 5.013 2.345 4 3.204 4h9.592a1 1 0 0 1 .753 1.659l-4.796 5.48a1 1 0 0 1-1.506 0z"/>
			</svg>
			<svg x-show="state.order === 'ASC'"
			xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-caret-up-fill" viewBox="0 0 16 16">
				<path d="m7.247 4.86-4.796 5.481c-.566.647-.106 1.659.753 1.659h9.592a1 1 0 0 0 .753-1.659l-4.796-5.48a1 1 0 0 0-1.506 0z"/>
			</svg>
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
