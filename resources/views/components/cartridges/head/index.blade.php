<div 
	class="row fw-bold text-center"
	x-data="cartridgesHead" @reset.window="reset" x-init="init"
>
	<x-cartridges.head.heading :title="'Бренд'"    :column="'vendor_title'" />
	<x-cartridges.head.heading :title="'Название'" :column="'title'" />
	<x-cartridges.head.heading :title="'Цена-1'"   :column="'price_1'" />
	<x-cartridges.head.heading :title="'Цена-2'"   :column="'price_2'" />
	<x-cartridges.head.heading :title="'Цена-5'"   :column="'price_5'" />
	<x-cartridges.head.heading :title="'Офис'"     :column="'price_office'" />
	<x-cartridges.head.heading :title="'Цвет'"     :column="'color_title'" />
</div>

<script>
	document.addEventListener('alpine:init', () => {
		Alpine.data('cartridgesHead', () => ({
			status: {
				sort: null,
				order: 'ASC'
			},
			init(){
				this.reset();
				this.setStatus();

			},
			setStatus(){
				const query = new URLSearchParams(location.search);

				if (query.has('order')) {
					this.status.order = query.get('order');
				}
				
				if (query.has('sort')) {
					this.status.sort = query.get('sort');
					this.state.sort = this.prepareParams();
				}
			},
			sort: function(column){
				this.changeStatus(column);

				let params = this.prepareParams();

				this.$dispatch('list-change', {
					params,
					type: 'sort',
				})
			},
			changeStatus(column){
				if(this.status.sort === column) {
					this.changeOrder();
				} else {
					this.status.sort = column;
					this.status.order = 'ASC';
				}
			},
			changeOrder(){
				if(this.status.order === 'ASC') {
					this.status.order = 'DESC';
					return;
				}
				
				this.status.order = 'ASC';
			},
			prepareParams(){
				let params = new URLSearchParams();

				for (const key in this.status) {
					if (Object.hasOwnProperty.call(this.status, key)) {
						params.append(key, this.status[key]);
					}
				}

				return params;
			},
			reset(){
				this.status.sort = null;
				this.status.order = 'ASC';
			},
		}))
	})
</script>
