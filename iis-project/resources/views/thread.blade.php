@extends('layout')
@section('content')
<div class="container">
	<div class="d-flex flex-row justify-content-between">
		<h1>Vlákno: {{ $thread->topic }}</h1>
		@if ($canDelete)
			<div>
				<form method="post" action="{{ route('thread.delete', ['id' => $thread->id]) }}">
					@csrf
					<button type="submit" class="btn btn-danger">Smazat Vlákno</button>
				</form>
			</div>
		@endif
	</div>
</div>
@endsection