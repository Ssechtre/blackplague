<div class="sidebar" data-color="purple" data-background-color="white" data-image="{{ asset('img/sidebar-1.jpg') }}">
  <!--
    Tip 1: You can change the color of the sidebar using: data-color="purple | azure | green | orange | danger"

    Tip 2: you can also add an image using data-image tag
	-->
	<div class="logo">
		<a href="http://www.creative-tim.com" class="simple-text logo-normal">
		  YOUR LOGO
		</a>
	</div>
	
	<div class="sidebar-wrapper">
		<ul class="nav">
			<li class="nav-item active">
				<a class="nav-link" href="{{ route('home') }}">
				  <i class="material-icons">dashboard</i>
				  <p>Dashboard</p>
				</a>
			</li>
			@if(Auth::check() && Auth::user()->user_type == 'Admin')
			<li class="nav-item">
				<a class="nav-link" href="{{ route('user.index') }}">
				  <i class="material-icons">person</i>
				  <p>User</p>
				</a>
			</li>
			<li class="nav-item">
				<a class="nav-link" href="{{ route('customer.index') }}">
				  <i class="material-icons">person</i>
				  <p>Customer</p>
				</a>
			</li>
			@endif
			{{-- <li class="nav-item ">
				<a class="nav-link" href="{{ route('product.index') }}">
				  <i class="material-icons">content_paste</i>
				  <p>Sales</p>
				</a>
			</li> --}}
			<li class="nav-item ">
				<a class="nav-link" href="{{ route('product.index') }}">
				  <i class="material-icons">content_paste</i>
				  <p>Product</p>
				</a>
			</li>
			@if(Auth::check() && Auth::user()->user_type == 'Admin')
			<li class="nav-item ">
				<a class="nav-link" href="{{ route('code.index') }}">
				  <i class="material-icons">library_books</i>
				  <p>Codes</p>
				</a>
			</li>
			@endif
			<li class="nav-item ">
				<a class="nav-link" href="./icons.html">
				  <i class="material-icons">bubble_chart</i>
				  <p>Icons</p>
				</a>
			</li>
			<li class="nav-item ">
				<a class="nav-link" href="./map.html">
				  <i class="material-icons">location_ons</i>
				  <p>Maps</p>
				</a>
			</li>
			<li class="nav-item ">
				<a class="nav-link" href="./notifications.html">
				  <i class="material-icons">notifications</i>
				  <p>Notifications</p>
				</a>
			</li>
			<li class="nav-item ">
				<a class="nav-link" href="./rtl.html">
				  <i class="material-icons">language</i>
				  <p>RTL Support</p>
				</a>
			</li>
			<li class="nav-item ">
				<a class="nav-link" href="{{ route('vue.index') }}">
				  <i class="material-icons">language</i>
				  <p>Vue JS</p>
				</a>
			</li>
			<li class="nav-item active-pro ">
				<a class="nav-link" href="./upgrade.html">
				  <i class="material-icons">unarchive</i>
				  <p>{{ date('M d, Y') }}</p>
				</a>
			</li>
		</ul>
	</div>
</div>