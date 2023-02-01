<div 
	x-data="toastError" @toast-error.window="fire"
	class="toast align-items-center border-0 text-bg-danger" role="alert" aria-live="assertive" 
	aria-atomic="true" data-bs-autohide="false" id="toast-error">
	<div class="d-flex">
		<div class="toast-body" x-text="message"></div>
		<button class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast" type="button"
			aria-label="Close"></button>
	</div>
</div>

<script>
	document.addEventListener('alpine:init', () => {
		Alpine.data('toastError', () => ({
			toast: new bootstrap.Toast(document.querySelector('#toast-error')),
			message: '',
			fire: function(event) {
				this.message = event.detail.message;
				this.$nextTick(() => { this.toast.show() })
			},
		}))
	})
</script>
