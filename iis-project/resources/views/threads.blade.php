@extends('layout')
@section('content')
<div class="container">
	<div class="d-flex justify-content-between">
		<h1>Vlákna</h1>
		<div>
			<a href="{{ route('thread.create', ['groupId' =>$groupId]) }}" class="btn btn-success">Vytvořit vlákno</a>
		</div>
	</div>
	<div class="mt-5">
		@foreach ($threads as $thread)
		<a href="{{ route('thread', ['id' => $thread->id]) }}">
			<div class="card mb-3">
				<div class="card-body">
					<h5 class="card-title">{{ $thread->topic }}</h5>
				</div>
			</div>
		</a>
		@endforeach
	</div>
</div>
@endsection