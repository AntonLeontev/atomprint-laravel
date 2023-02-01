<form 
	class="position-relative"
	x-data="filters" @change="filter" @reset.window="reset" x-init="initialize">
    <div class="row py-2">
        <h6>Vendor</h6>
        @foreach ($vendors as $vendor)
            <label>
                <input name="vendor[]" type="checkbox" value="{{ $vendor->id }}">
                {{ $vendor->title }}
            </label>
        @endforeach
    </div>
	<div class="row py-2">
        <h6>Color</h6>
        @foreach ($colors as $color)
            <label>
                <input name="color[]" type="checkbox" value="{{ $color->id }}">
                {{ $color->title }}
            </label>
        @endforeach
    </div>
	<x-sidebar.spinner />
</form>

<script>
	document.addEventListener('alpine:init', () => {
		Alpine.data('filters', () => ({
			initialize(){
				this.reset();
				this.setState();

				this.state.filter = new URLSearchParams(new FormData(this.$root));
			},
			setState(){
				const checkboxes = this.$root.querySelectorAll('[type="checkbox"]');
				let query = new URLSearchParams(location.search);
				
				for (const checkbox of checkboxes) {
					if (! query.has(checkbox.getAttribute('name'))) continue;

					let values = query.getAll(checkbox.getAttribute('name'));

					for (const value of values) {
						if (checkbox.getAttribute('value') === value) {
							checkbox.checked = true;
						}
					}
				}
			},
			filter: function(event){
				let form = event.target.closest('form');
				let params = new URLSearchParams(new FormData(form));
				
				this.$dispatch('list-change', {
					params,
					type: 'filter',
				})
			},
			reset(){
				let inputs = this.$root.querySelectorAll('input');

				for (const key in inputs) {
					if (Object.hasOwnProperty.call(inputs, key)) {
						const input = inputs[key];
						
						input.checked = false;
					}
				}
			},
		}))
	})
</script>
