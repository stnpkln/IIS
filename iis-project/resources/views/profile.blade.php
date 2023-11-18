@extends('layout')
@section('content')
<div class="container">
	<h1>Profil</h1>
	<form method="post" action="{{ route('profile.post') }}" accept-charset="UTF-8">
		@csrf
		<div class="mb-3">
			<label for="first_name" class="form-label">Jméno</label>
			<input type="text" class="form-control" id="first_name" name="first_name" value="{{ $user->first_name }}">
		</div>
		<div class="mb-3">
			<label for="last_name" class="form-label">Přijmení</label>
			<input type="text" class="form-control" id="last_name" name="last_name" value="{{ $user->last_name }}">
		</div>
		<div class="mb-3">
			<label for="email" class="form-label">Email</label>
			<input type="email" class="form-control" id="email" name="email" value="{{ $user->email }}">
		</div>
		<div class="mb-3">
			<label for="username" class="form-label">Uživatelské jméno</label>
			<input type="text" class="form-control" id="username" name="username" value="{{ $user->username }}">
		</div>
		<div class="form-check mb-3">
			<input class="form-check-input" type="checkbox" {{ $user->is_public ? 'checked' : '' }} value="true" id="is_public" name="is_public">
			<label class="form-check-label" for="is_public">
			  Veřejný profil
			</label>
		</div>
		<button type="submit" class="btn btn-primary">Upravit</button>
	</form>
</div>
@endsection