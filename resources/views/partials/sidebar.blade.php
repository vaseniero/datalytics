    <div class="sidebar-menu">
		<div class="sidebar-menu-inner">
			<header class="logo-env">
				<!-- logo -->
				<div class="logo">
					<a href="{{ url('/home') }}">
						<img src="{{ asset('assets/images/datalytics-logo4.png') }}" width="120" alt="DataLytics" />
					</a>
				</div>
				<!-- logo collapse icon -->
				<div class="sidebar-collapse">
					<a href="#" class="sidebar-collapse-icon with-animation"><!-- add class "with-animation" if you want sidebar to have animation during expanding/collapsing transition -->
						<i class="entypo-menu"></i>
					</a>
				</div>
				<!-- open/close menu icon (do not remove if you want to enable menu on mobile devices) -->
				<div class="sidebar-mobile-menu visible-xs">
					<a href="#" class="with-animation"><!-- add class "with-animation" to support animation -->
						<i class="entypo-menu"></i>
					</a>
				</div>
			</header>
			<ul id="main-menu" class="main-menu">
				<!-- add class "multiple-expanded" to allow multiple submenus to open -->
				<!-- class "auto-inherit-active-class" will automatically add "active" class for parent elements who are marked already with class "active" -->
				<li class="active opened active has-sub">
					<a href="{{ url('/home') }}">
						<i class="entypo-gauge"></i>
						<span class="title">Dashboard</span>
					</a>
					<ul class="visible">
						<li class="active">
							<a href="{{ url('/home') }}">
								<span class="title">Dashboard</span>
							</a>
						</li>
						<li>
							<a href="{{ url('/home/2') }}">
								<span class="title">Dashboard 2</span>
							</a>
						</li>
					</ul>
				</li>
			</ul>
		</div>
	</div>
