@extends('layouts.app')

@section('title', 'Картриджи')

@section('content')
<div class="container" x-data="page">
	<div class="row">
		<div class="col-2">
			<div class="sidebar row position-sticky top-0 overflow-auto border rounded mt-1">
				<div class="col">
					<x-search />
					<hr class="my-0">
					<x-filters :$vendors :$colors />
					<hr class="my-0">
					<x-reset-button />
				</div>
			</div>
		</div>
		<div class="col-10">
			<x-cartridges />
		</div>
	</div>
</div>
<form action="{{ route('pricelists.load') }}" method="post" enctype="multipart/form-data">
	@csrf
	<input type="file" name="file">
	<input type="submit" value="Send">
</form>
<div class="toast-container position-fixed bottom-0 end-0 p-3">
	<x-toasts.success />
	<x-toasts.error />
</div>

<script>
	document.addEventListener('alpine:init', () => {
		Alpine.data('page', () => ({
			cartridges: [],
            colors: [],
			state: {},
		}))
	})
</script>
@endsection
    