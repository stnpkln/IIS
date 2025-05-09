@extends('layout')
@section('content')
<div class="container">
	<div class="d-flex justify-content-between">
		<h1>Skupiny</h1>
		@if (session('user'))
		<div>
			<a href="{{ route('group.create') }}" class="btn btn-success">Vytvořit skupinu</a>
		</div>
		@endif
	</div>
	<div class="mt-5">
		@foreach ($groups as $group)
		<div class="card mb-3">
			<div class="card-body">
				<h5 class="card-title">{{ $group->name }}</h5>
				<div class="pt-3">
					<a href="{{ route('group', ['id' => $group->id]) }}" class="btn btn-primary">Zobrazit skupinu</a>
				</div>
			</div>
		</div>
		@endforeach
	</div>
</div>
@endsection