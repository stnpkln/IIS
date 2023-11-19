@extends('layout')
@section('content')
<div class="container">
	<h1>Skupina {{ $group->name }}</h1>
	<div class="card mb-3 d-flex flex-row">
		<div class="card-body">
			<p class="card-text">{{ $group->description }}</p>
		</div>
	</div>

	<h2>Členové</h2>
	@foreach ($members as $member)
	<div class="card mb-3 d-flex flex-row">
		<div class="card-body">
			<p class="card-text">{{ $member->username }}</p>
			<p class="card-text">role: {{ $member->role }}</p>
			<a href="{{ route('user', ['id' => $member->id]) }}" class="btn btn-primary">Zobrazit profil</a>
		</div>
	</div>
	@endforeach
</div>
@endsection