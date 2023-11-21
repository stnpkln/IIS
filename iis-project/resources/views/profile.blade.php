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
			<label for="username" class="form-label">Uživatelské jméno</label>
			<input type="text" class="form-control" id="username" name="username" value="{{ $user->username }}">
		</div>
		<div class="mb-3">
			<label for="description" class="form-label">Bio</label>
			<textarea type="text" class="form-control" id="description" name="description" maxlength="500">{{ $user->description }}</textarea>
		</div>
		<select class="form-select mb-3" name="visibility" required>
			<option value="all" {{ $user->visibility === 'all' ? 'selected' : '' }}>Profil vidí všichni</option>
			<option value="registered" {{ $user->visibility === 'registered' ? 'selected' : '' }}>Profil vidí pouze registrovaní</option>
			<option value="hidden" {{ $user->visibility === 'hidden' ? 'selected' : '' }}>Soukromý profil</option>
		</select>
		<button type="submit" class="btn btn-primary">Upravit</button>
	</form>
</div>
@endsection