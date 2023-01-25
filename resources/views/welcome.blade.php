<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="token" content="{{ csrf_token() }}">

    <title>Laravel</title>

    @vite(['resources/sass/app.scss', 'resources/js/app.js'])

</head>

<body>
    <div class="container">
		<div class="row">
			<div class="col-2">
				<div class="position-sticky top-0">
					<x-search />
					<x-filters :$vendors :$colors />
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
    
</body>

</html>
