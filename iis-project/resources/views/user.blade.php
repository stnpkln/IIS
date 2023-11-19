@extends('layout')
@section('content')
<div class="container">
	<h1>Profil</h1>
	<div class="card mb-3 d-flex flex-row">
		<div class="card-body">
			<h5 class="card-title">{{ $user->username }}</h5>
			<p class="card-text">{{ $user->first_name }} {{ $user->last_name }}</p>
			<p class="card-text">{{ $user->description }}</p>
			@if ($isAdmin)
			<p class="card-text">{{ $user->email }}</p>
			<p class="card-text">{{ $user->is_public ? 'Veřejný profil' : 'Soukromý profil' }}</p>
			@endif
		</div>
		@if ($isAdmin && $user->email !== session('user'))
		<div class="d-flex justify-content-end p-2">
			<form method="post" action="{{ route('user.delete', ['id' => $user->id]) }}">
				@csrf
				<button type="submit" class="btn btn-danger">Smazat profil</button>
			</form>
		</div>
		@endif
	</div>
</div>
@endsection