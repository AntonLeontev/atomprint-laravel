<div 
	class="position-absolute top-0 end-0 me-0 mt-1" 
	x-data="spinner" x-show="isShown" @request-start.window="show"
	@request-finish.window="hide" x-transition x-cloak>
	<div class="spinner-border spinner-border-sm" role="status">
		<span class="visually-hidden">Loading...</span>
	</div>
</div>

<script>
	document.addEventListener('alpine:init', () => {
		Alpine.data('spinner', () => ({
			isShown: false,
			show(){
				this.isShown = true;
			},
			hide(){
				this.isShown = false;
			},
			toggle(){
				this.isShown = ! this.isShown
			},
		}))
	})
</script>
