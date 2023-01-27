<form class="row position-relative mb-1" 
	x-data="search" @submit.prevent="submit" @reset.window="reset" x-init="initialize"
>
	<div class="col">
		<input 
			type="search" name="search" class="w-100 my-1 pe-4" placeholder="Поиск" autocomplete="off"
			x-ref='search' @input="showClearButton"
		>
		<div @click="clear" x-show="clearButton" x-cloak>
			<button type="button"
				class="btn position-absolute top-50 end-0 translate-middle p-0 d-flex align-items-center me-2 z-1 bg-white"
				
			>
				<svg width="16" height="16" fill="currentColor" viewBox="0 0 16 16">
					<path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14zm0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16z"/>
					<path d="M4.646 4.646a.5.5 0 0 1 .708 0L8 7.293l2.646-2.647a.5.5 0 0 1 .708.708L8.707 8l2.647 2.646a.5.5 0 0 1-.708.708L8 8.707l-2.646 2.647a.5.5 0 0 1-.708-.708L7.293 8 4.646 5.354a.5.5 0 0 1 0-.708z"/>
				</svg>
			</button>
		</div>
		<svg 
			class="position-absolute top-50 end-0 translate-middle me-2" width="16" height="16" fill="currentColor" 
			viewBox="0 0 16 16"
			x-show="! clearButton" 
		>
			<path d="M11.742 10.344a6.5 6.5 0 1 0-1.397 1.398h-.001c.03.04.062.078.098.115l3.85 3.85a1 1 0 0 0 1.415-1.414l-3.85-3.85a1.007 1.007 0 0 0-.115-.1zM12 6.5a5.5 5.5 0 1 1-11 0 5.5 5.5 0 0 1 11 0z"/>
		</svg>
	</div>
</form>

<script>
	document.addEventListener('alpine:init', () => {
		Alpine.data('search', () => ({
			clearButton: false,
			initialize(){
				this.reset();
				this.setState();

				this.state.search = new URLSearchParams(new FormData(this.$root));
			},
			setState(){
				const input = this.$refs.search;
				const query = new URLSearchParams(location.search);

				if (query.has('search')) {
					this.$refs.search.value = query.get('search');
				}
			},
			submit(event){
				let formData = new FormData(event.target.closest('form'));

				this.$dispatch('list-change', {
					params: new URLSearchParams(formData),
					type: 'search',
				})
			},
			clear(event){
				this.$refs.search.value = '';
				this.clearButton = false;

				this.submit(event);
			},
			showClearButton(event){
				if (this.$el.value === '') {
					this.clearButton = false;
					return;
				}

				this.clearButton = true;
			},
			reset(){
				this.$refs.search.value = '';
				this.clearButton = false;
			},
		}))
	})
</script>
