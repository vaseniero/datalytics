<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
	@include('partials.head')
</head>
<body class="page-body page-fade">
<div class="page-container sidebar-collapsed"><!-- add class "sidebar-collapsed" to close sidebar by default, "chat-visible" to make chat appear always -->	
	@include('partials.sidebar')
	<div class="main-content">
		@section('menu-head')
		@show
		<hr />
		@yield('content')
	</div>
</div>
@include('partials.modal-dialog')
@include('partials.footer')
</body>
</html>