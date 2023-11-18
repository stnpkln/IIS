@extends('layout')
@section('content')
<div class="container">
	<h1>Uživatelé</h1>
	@foreach ($users as $user)
		<div class="card mb-3">
			<div class="card-body">
				<h5 class="card-title">{{ $user->username }}</h5>
				<p class="card-text">{{ $user->first_name }} {{ $user->last_name }}</p>
				@if ($isAdmin)
				<p class="card-text">{{ $user->email }}</p>
				<p class="card-text">{{ $user->is_public ? 'Veřejný profil' : 'Soukromý profil' }}</p>
				@endif
				<a href="{{ route('user', ['id' => $user->id]) }}" class="btn btn-primary">Zobrazit profil</a>
			</div>
		</div>
	@endforeach
</div>
@endsection