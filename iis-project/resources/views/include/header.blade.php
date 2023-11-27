<ul class="nav nav-underline justify-content-between px-5 py-3 shadow-sm">
	<div class="d-flex gap-3">
		@if (session('user') === null)
			<li class="nav-item">
				<a class="nav-link {{ Request::is('/') ? 'active' : '' }}" href="{{ route('homepage') }}">Hlavní stránka</a>
			</li>
		@else
			<li class="nav-item">
				<a class="nav-link {{ Request::is('my-groups', 'thread*', 'post*') ? 'active' : '' }}" href="{{ route('groups.me') }}">Moje skupiny</a>
			</li>
		@endif
		<li class="nav-item">
			<a class="nav-link {{ Request::is('user*') ? 'active' : '' }}" href="{{ route('users') }}">Uživatelé</a>
		</li>
		<li class="nav-item">
			<a class="nav-link {{ Request::is('group*') ? 'active' : '' }}" href="{{ route('groups') }}">Hledat skupiny</a>
		</li>
	</div>
	<div class="d-flex gap-3">
	@if (session('user'))
		<li class="nav-item">
			<a class="nav-link {{ Request::is('request-list') ? 'active' : '' }}" href="{{ route('request.list') }}">Žádosti</a>
		</li>
		<li class="nav-item">
			<a class="nav-link {{ Request::is('profile') ? 'active' : '' }}" href="{{ route('profile') }}">Profil</a>
		</li>
		<li class="nav-item">
			<a class="btn btn-outline-primary" href="{{ route('logout') }}">Odhlásit se</a>
		</li>
	@else
		<li class="nav-item">
		<a class="nav-link {{ Request::is('login', 'register') ? 'active' : '' }}" href="{{ route('login') }}">Přihlásit se</a>
		</li>
	@endif
	</div>
  </ul>