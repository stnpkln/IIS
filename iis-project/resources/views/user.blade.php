@extends('layout')
@section('content')
<div class="container">
	<h1>Profil</h1>
	<div class="card mb-3">
		<div class="card-body">
			<h5 class="card-title">{{ $user->username }}</h5>
			<p class="card-text">{{ $user->first_name }} {{ $user->last_name }}</p>
			@if ($isAdmin)
			<p class="card-text">{{ $user->email }}</p>
			<p class="card-text">{{ $user->is_public ? 'Veřejný profil' : 'Soukromý profil' }}</p>
			@endif
		</div>
	</div>
	{{-- TODO pridat user bio do db --}}
</div>
@endsection