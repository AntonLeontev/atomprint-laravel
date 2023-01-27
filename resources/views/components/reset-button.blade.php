<div class="vstack py-2" x-data='reset' @click="reset">
	<button class="btn btn-outline-danger" type="reset">Сброс фильтров</button>
</div>

<script>
	document.addEventListener('alpine:init', () => {
		Alpine.data('reset', () => ({
			reset(){
				this.$dispatch('reset');
			}
		}))
	})
</script>
