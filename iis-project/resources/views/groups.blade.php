@extends('layout')
@section('content')
<div class="container">
	<h1>Skupiny</h1>
	<a href="{{ route('group-create') }}" class="btn btn-primary">Vytvořit skupinu</a>
	@foreach ($groups as $group)
		<div class="card mb-3">
			<div class="card-body">
				<h5 class="card-title">{{ $group->name }}</h5>
				<p class="card-text">{{ $group->description }}</p>
			</div>
		</div>
	@endforeach
</div>
@endsection