@extends('layout')
@section('content')
<div class="container">
	<h1>Přihlášení</h1>
	<form method="post" action="{{ route('login.post') }}" accept-charset="UTF-8"
	>
		@csrf
		<div class="mb-3">
			<label for="email" class="form-label">Emailová adresa</label>
			<input type="email" class="form-control" id="email" name="email">
		</div>
		<div class="mb-3">
			<label for="password" class="form-label">Heslo</label>
			<input type="password" class="form-control" id="password" name="password">
		</div>
		<button type="submit" class="btn btn-primary">Přihlásit se</button>
	</form>
	<p class="mt-3">Ještě nemáte účet? <a href="{{ route('register') }}">Zaregistrujte se</a></p>
</div>
@endsection