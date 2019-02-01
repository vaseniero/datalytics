<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
	@include('partials.head')
</head>
<body class="page-body page-fade">
<div class="page-container sidebar-collapsed"><!-- add class "sidebar-collapsed" to close sidebar by default, "chat-visible" to make chat appear always -->	
	@include('partials.sidebar')
	<div class="main-content">
		@include('partials.menu-head', ['username' => $user->name])
		<hr />
		@yield('script-codes')
		@yield('charts')
		@yield('script-codes2')
		<div class="row">
			@yield('task')
			@yield('map')
		</div>
		@include('partials.footer')
	</div>
</div>
@include('partials.modal-dialog')
@include('partials.foot')
</body>
</html>