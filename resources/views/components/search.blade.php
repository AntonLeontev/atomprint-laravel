<form class="row border  position-relative" 
	x-data="search" @submit.prevent="submit"
>
	<div class="col">
		<input 
			type="search" name="search" class="w-100 my-1 pe-4" placeholder="Картридж" 
			x-ref='search' @input="showClearButton"
		>
		<div @click="clear" x-show="clearButton">
			<button type="button"
				class="btn position-absolute top-50 end-0 translate-middle p-0 d-flex align-items-center me-2 z-1 bg-white"
			>
				<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-x-circle" viewBox="0 0 16 16">
					<path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14zm0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16z"/>
					<path d="M4.646 4.646a.5.5 0 0 1 .708 0L8 7.293l2.646-2.647a.5.5 0 0 1 .708.708L8.707 8l2.647 2.646a.5.5 0 0 1-.708.708L8 8.707l-2.646 2.647a.5.5 0 0 1-.708-.708L7.293 8 4.646 5.354a.5.5 0 0 1 0-.708z"/>
				</svg>
			</button>
		</div>
	</div>
</form>

<script>
	document.addEventListener('alpine:init', () => {
		Alpine.data('search', () => ({
			clearButton: false,
			submit(event){
				let formData = new FormData(event.target.closest('form'));

				this.$dispatch('list-change', {
					params: new URLSearchParams(formData),
					type: 'search',
				})
			},
			clear(event){
				this.$refs.search.value = '';

				this.submit(event);
			},
			showClearButton(event){
				if (this.$el.value === '') {
					this.clearButton = false;
					return;
				}

				this.clearButton = true;
			},
		}))
	})
</script>
