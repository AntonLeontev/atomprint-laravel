@extends('layouts.app')

@section('title', 'Картриджи')

@section('content')
<div class="container" x-data="page">
	<div class="row">
		<x-sidebar class="col-2">
			<x-sidebar.block>
				<x-sidebar.search />
				<hr class="my-0">
				<x-sidebar.filters :$vendors :$colors />
				<hr class="my-0">
				<x-sidebar.reset-button />
			</x-sidebar.block>
			<x-sidebar.block>
				<x-sidebar.files />
			</x-sidebar.block>
		</x-sidebar>
		<div class="col-10">
			<x-cartridges />
		</div>
	</div>
</div>
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
    