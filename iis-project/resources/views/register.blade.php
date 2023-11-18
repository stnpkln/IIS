@extends('layout')
@section('content')
<div class="container">
	<h1>Registrace</h1>
	<form method="post" action="{{ route('register.post') }}" accept-charset="UTF-8">
		@csrf
		<div class="mb-3">
			<label for="first_name" class="form-label">Jméno *</label>
			<input type="text" class="form-control" id="first_name" name="first_name" required>
		</div>
		<div class="mb-3">
			<label for="last_name" class="form-label">Přijmení *</label>
			<input type="text" class="form-control" id="last_name" name="last_name" required>
		</div>
		<div class="mb-3">
			<label for="email" class="form-label">Email *</label>
			<input type="email" class="form-control" id="email" name="email" required>
		</div>
		<div class="mb-3">
			<label for="username" class="form-label">Uživatelské jméno</label>
			<input type="text" class="form-control" id="username" name="username">
		</div>
		<div class="mb-3">
			<label for="password" class="form-label">Heslo *</label>
			<input type="password" class="form-control" id="password" name="password" required>
		</div>
		<div class="form-check mb-3">
			<input class="form-check-input" type="checkbox" value="true" id="is_public" name="us_public">
			<label class="form-check-label" for="is_public">
			  Chci aby můj účet byl veřejný *
			</label>
		</div>
		<button type="submit" class="btn btn-primary">Zaregistrovat se</button>
	</form>
</div>
@endsection