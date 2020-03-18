<div class="sidebar" data-color="purple" data-background-color="white" data-image="{{ asset('img/sidebar-1.jpg') }}">
  <!--
    Tip 1: You can change the color of the sidebar using: data-color="purple | azure | green | orange | danger"

    Tip 2: you can also add an image using data-image tag
	-->
	<div class="logo">
		<a href="{{ route('home') }}" class="simple-text logo-normal">
		  Health Patrol Lifestyle
		</a>
	</div>
	
	<div class="sidebar-wrapper">
		<ul class="nav">
			@if(Auth::check() && Auth::user()->user_type == 'admin')
				<li class="nav-item {{ Request::is('home') ? 'active' : null }}">
					<a class="nav-link" href="{{ route('home') }}">
					  <i class="material-icons">dashboard</i>
					  <p>Dashboard</p>
					</a>
				</li>
				<li class="nav-item {{ (Request::is('users') || Request::is('users/create') || Request::is('users/*')) ? 'active' : null }}">
					<a class="nav-link" href="{{ route('users.index') }}">
					  <i class="material-icons">supervised_user_circle</i>
					  <p>Users</p>
					</a>
				</li>
				<li class="nav-item {{ (Request::is('products') || Request::is('products/create') || Request::is('products/*')) ? 'active' : null }}">
					<a class="nav-link" href="{{ route('products.index') }}">
					  <i class="material-icons">content_paste</i>
					  <p>Products</p>
					</a>
				</li>
				<li class="nav-item {{ (Request::is('codes') || Request::is('products/codes') || Request::is('codes/*')) ? 'active' : null }}">
					<a class="nav-link" href="{{ route('codes.index') }}">
					  <i class="material-icons">library_books</i>
					  <p>Codes</p>
					</a>
				</li>
				<li class="nav-item {{ (Request::is('customer_networks') || Request::is('customer_networks/*')) ? 'active' : null }}">
					<a class="nav-link" href="{{ route('customer_networks.index') }}">
					  <i class="material-icons">supervisor_account</i>
					  <p>Referral Management</p>
					</a>
				</li>
				<li class="nav-item {{ (Request::is('payouts') || Request::is('payouts/*')) ? 'active' : null }}">
					<a class="nav-link" href="{{ route('payouts') }}">
					  <i class="material-icons">monetization_on</i>
					  <p>Monthly Payouts</p>
					</a>
				</li>
				<li class="nav-item {{ (Request::is('reports') || Request::is('reports/*')) ? 'active' : null }}">
					<a class="nav-link" href="{{ route('reports.app') }}">
					  <i class="material-icons">timeline</i>
					  <p>Reports</p>
					</a>
				</li>

				<li class="nav-item {{ (Request::is('pos') || Request::is('pos/*')) ? 'active' : null }}">
					<a class="nav-link" href="{{ route('point_of_sales.app') }}">
					  <i class="material-icons">apps</i>
					  <p>Point of Sale</p>
					</a>
				</li>
			@endif

			@if(Auth::check() && Auth::user()->user_type == 'staff')
				<li class="nav-item {{ (Request::is('customer_networks') || Request::is('customer_networks/*')) ? 'active' : null }}">
					<a class="nav-link" href="{{ route('customer_networks.staff') }}">
					  <i class="material-icons">supervisor_account</i>
					  <p>Referral Management</p>
					</a>
				</li>
				<li class="nav-item {{ (Request::is('staff_pos') || Request::is('staff_pos/*')) ? 'active' : null }}">
					<a class="nav-link" href="{{ route('point_of_sales.staff') }}">
					  <i class="material-icons">apps</i>
					  <p>Point of Sale</p>
					</a>
				</li>
			@endif

			@if(Auth::check() && Auth::user()->user_type == 'customer')
				<li class="nav-item {{ Request::is('privileges') ? 'active' : null }}">
					<a class="nav-link" href="{{ route('customer.home') }}">
					  <i class="material-icons">dashboard</i>
					  <p>Privileges</p>
					</a>
				</li>
				<li class="nav-item {{ Request::is('commisions') ? 'active' : null }}">
					<a class="nav-link" href="{{ route('user.commissions') }}">
					  <i class="material-icons">monetization_on</i>
					  <p>Commisions</p>
					</a>
				</li>

				<li class="nav-item {{ (Request::is('pos') || Request::is('pos/*')) ? 'active' : null }}">
					<a class="nav-link" href="{{ route('pos.app') }}">
					  <i class="material-icons">apps</i>
					  <p>Point of Sale</p>
					</a>
				</li>
			@endif

			
{{-- 			<li class="nav-item ">
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
			<li class="nav-item active-pro ">
				<a class="nav-link" href="./upgrade.html">
				  <i class="material-icons">unarchive</i>
				  <p>{{ date('M d, Y') }}</p>
				</a>
			</li> --}}
		</ul>
	</div>
</div>