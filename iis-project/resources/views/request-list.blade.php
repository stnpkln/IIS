@extends('layout')
@section('content')
<div class="container">
	<h2>Požadavky na přijetí do skupiny</h1>
	@if ($joinRequests == null || count($joinRequests) == 0)
		<p>Žádné požadavky</p>
		@else
		@foreach ($joinRequests as $joinRequest)
	<div class="card mb-3">
		<div class="card-body d-flex flex-row justify-content-between">
			<div>
				<h5 class="card-title">Uživatel: {{ $joinRequest->username }}</h5>
				<p class="card-text">Skupina: {{ $joinRequest->name }}</p>
			</div>
			<div>
				<form method="post" action="{{ route('group.join.approve', ['groupId' => $joinRequest->group_id, 'userId' => $joinRequest->requester_id]) }}" class="mb-3">
					@csrf
					<button type="submit" class="btn btn-success">Schválit</button>
				</form>
				<form method="post" action="{{ route('group.join.decline', ['groupId' => $joinRequest->group_id, 'userId' => $joinRequest->requester_id]) }}"> 
					@csrf
					<button type="submit" class="btn btn-danger">Zamítnout</button>
				</form>
			</div>
		</div>
	</div>
	@endforeach
	@endif
	<h2>Požadavky na role</h1>
	@if ($joinRequests == null || count($joinRequests) == 0)
	<p>Žádné požadavky</p>
	@endif
</div>
@endsection