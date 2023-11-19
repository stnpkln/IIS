@extends('layout')
@section('content')
<div class="container">
	<h1>Uživatelé</h1>
	@foreach ($users as $user)
		<div class="card mb-3">
			<div class="card-body">
				<h5 class="card-title">{{ $user->username }}</h5>
				@if (($isAdmin || $user->visibility == 'all') || ($user->visibility == 'registered' && session('user') !== null))
				<p class="card-text">{{ $user->first_name }} {{ $user->last_name }}</p>
				<a href="{{ route('user', ['id' => $user->id]) }}" class="btn btn-primary">Zobrazit profil</a>
				@endif
			</div>
		</div>
	@endforeach
</div>
@endsection