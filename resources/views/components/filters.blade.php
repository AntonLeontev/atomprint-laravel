<form x-data="filters" @change="filter">
    <div class="row border">
        <h6>Vendor</h6>
        @foreach ($vendors as $vendor)
            <label>
                <input name="vendor[]" type="checkbox" value="{{ $vendor->id }}">
                {{ $vendor->title }}
            </label>
        @endforeach
    </div>
	<div class="row border">
        <h6>Color</h6>
        @foreach ($colors as $color)
            <label>
                <input name="color[]" type="checkbox" value="{{ $color->id }}">
                {{ $color->title }}
            </label>
        @endforeach
    </div>
</form>

<script>
	document.addEventListener('alpine:init', () => {
		Alpine.data('filters', () => ({
			filter: function(event){
				let form = event.target.closest('form');
				let params = new URLSearchParams(new FormData(form));
				
				this.$dispatch('list-change', {
					params,
					type: 'filter',
				})
			}
		}))
	})
</script>
