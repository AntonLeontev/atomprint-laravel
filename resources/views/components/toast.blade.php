<div class="toast-container position-fixed bottom-0 end-0 p-3" 
	x-data="toast" 
	@toast.window="fire">
	<div 
		:class="type === 'success' && 'text-bg-success'"
		:class="type === 'error' && 'text-bg-error'"
		class="toast align-items-center border-0" role="alert" aria-live="assertive" 
		aria-atomic="true" data-bs-delay="700">
		<div class="d-flex">
			<div class="toast-body" x-text="message">
				Hello, world! This is a toast message.
			</div>
			<button class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast" type="button"
				aria-label="Close"></button>
		</div>
	</div>
</div>

<script>
	document.addEventListener('alpine:init', () => {
		Alpine.data('toast', () => ({
			toast: new bootstrap.Toast(document.querySelector('.toast')),
			message: 'Toast message',
			type: 'success',
			fire: function(event) {
				this.message = event.detail.message;
				this.type = event.detail.type;
				this.toast.show()
			},
		}))
	})
</script>
