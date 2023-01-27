<div 
	class="position-absolute top-0 end-0 me-0 mt-1" 
	x-data="spinner" x-show="show" @toggle-spinner.window="toggle" x-transition x-cloak>
	<div class="spinner-border spinner-border-sm" role="status">
		<span class="visually-hidden">Loading...</span>
	</div>
</div>

<script>
	document.addEventListener('alpine:init', () => {
		Alpine.data('spinner', () => ({
			show: false,
			toggle(){
				this.show = ! this.show
			},
		}))
	})
</script>
