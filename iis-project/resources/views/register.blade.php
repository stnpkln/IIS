@extends('layout')
@section('content')
<div class="container">
	<h1>Registrace</h1>
	<form method="post" action="{{ route('register.post') }}" accept-charset="UTF-8">
		@csrf
		<div class="mb-3">
			<label for="first_name" class="form-label">Jméno *</label>
			<input type="text" class="form-control" id="first_name" name="first_name" maxlength="50" required>
		</div>
		<div class="mb-3">
			<label for="last_name" class="form-label">Přijmení *</label>
			<input type="text" class="form-control" id="last_name" name="last_name" maxlength="50" required>
		</div>
		<div class="mb-3">
			<label for="email" class="form-label">Email *</label>
			<input type="email" class="form-control" id="email" name="email" maxlength="255" required>
		</div>
		<div class="mb-3">
			<label for="username" class="form-label">Uživatelské jméno</label>
			<input type="text" class="form-control" id="username" name="username" maxlength="50">
		</div>
		<div class="mb-3">
			<label for="password" class="form-label">Heslo *</label>
			<input type="password" class="form-control" id="password" name="password" maxlength="50" required>
		</div>
		<div class="mb-3">
			<label for="description" class="form-label">Bio</label>
			<textarea type="text" class="form-control" id="description" name="description" maxlength="500"></textarea>
		</div>
		<select class="form-select mb-3" name="visibility" required>
			<option value="all" selected>Profil vidí všichni</option>
			<option value="registered">Profil vidí pouze registrovaní</option>
			<option value="hidden">Soukromý profil</option>
		</select>
		<button type="submit" class="btn btn-primary">Zaregistrovat se</button>
	</form>
</div>
@endsection