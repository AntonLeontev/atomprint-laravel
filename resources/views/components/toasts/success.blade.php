<div 
	x-data="toastSuccess" @toast-success.window="fire"
	class="toast align-items-center border-0 text-bg-success toast-success" role="alert" aria-live="assertive" 
	aria-atomic="true" data-bs-delay="700" id="">
	<div class="d-flex">
		<div class="toast-body" x-text="message">79565</div>
		<button class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast" type="button"
			aria-label="Close"></button>
	</div>
</div>


<script>
	document.addEventListener('alpine:init', () => {
		Alpine.data('toastSuccess', () => ({
			toast: new bootstrap.Toast(document.querySelector('.toast-success')),
			message: '',
			fire: function(event) {
				this.message = event.detail.message;
				this.$nextTick(() => { this.toast.show() })
			},
		}))
	})
</script>
