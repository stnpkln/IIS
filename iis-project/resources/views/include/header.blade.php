<ul class="nav nav-underline justify-content-center">
	<li class="nav-item">
	  <a class="nav-link {{ Request::is('/') ? 'active' : '' }}" aria-current="page" href="{{ route('homepage') }}">Hlavní stránka</a>
	</li>
	<li class="nav-item">
	  <a class="nav-link {{ Request::is('login', 'register') ? 'active' : '' }}" href="{{ route('login') }}">Přihlásit se</a>
	</li>
  </ul>