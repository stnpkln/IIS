@extends('layout')
@section('content')
<div class="container">
	<div class="d-flex flex-row justify-content-between">
		<h1>{{ $group->name }}</h1>
		@if ($isUserInGroup)
			<div class="d-flex flex-row gap-3">
				@if ($userRole === 'owner')
					<form method="post" action="{{ route('group.delete', ['id' => $group->id]) }}">
						@csrf
						<button type="submit" class="btn btn-danger">Smazat skupinu</button>
					</form>
					<div>
						<a href="{{ route('group.edit', ['id' => $group->id]) }}" class="btn btn-warning">Upravit Skupinu</a>
					</div>
				@else
					<form method="post" action="{{ route('group.leave', ['id' => $group->id]) }}">
						@csrf
						<button type="submit" class="btn btn-danger">Opustit skupinu</button>
					</form>
				@if ($userRole === 'regular')
					<form method="post" action="{{ route('group.role.request', ['id' => $group->id]) }}">
						@csrf
						<button type="submit" class="btn btn-warning" {{ $roleRequestSent ? 'disabled': '' }}>Požádat o navýšení role</button>
					</form>
				@endif
			@endif
			<div>
				<a href="{{ route('group.threads', ['id' => $group->id]) }}" class="btn btn-success">Zobrazit vlákna</a>
			</div>
		</div>
		@elseif ($joinRequestSent)
		<p>již máte odeslanou žádost</p>
		@elseif (session('user') !== null)
		<div>
			<form method="post" action="{{ route('group.join.request', ['id' => $group->id]) }}">
				@csrf
				<button type="submit" class="btn btn-success">Požádat o přístup</button>
			</form>
		</div>
		@endif
	</div>
	<div class="card mb-3 d-flex flex-row">
		<div class="card-body">
			<p class="card-text">{{ $group->description }}</p>
		</div>
	</div>

	@if ($isUserInGroup || (session('user') !== null && $group->visibility === 'registered') || $group->visibility === 'all')
	<h2>Členové</h2>
	@foreach ($members as $member)
	<div class="card mb-3 d-flex flex-row">
		<div class="card-body d-flex flex-row justify-content-between">
			<div>
				<p class="card-text">{{ $member->username }}</p>
				<p class="card-text">role: {{ $member->role }}</p>
				<a href="{{ route('user', ['id' => $member->id]) }}" class="btn btn-primary">Zobrazit profil</a>
			</div>
			@if (($userRole === 'owner' && $member->role !== 'owner'))
			<div>
				<form method="post" action="{{ route('group.kick', ['groupId' => $group->id, 'userId' => $member->id]) }}">
					@csrf
					<button type="submit" class="btn btn-danger">Vyhodit ze skupiny</button>
				</form>
				@if ($member->role === 'moderator')
					<form class="mt-3" method="post" action="{{ route('group.role.derank', ['groupId' => $group->id, 'userId' => $member->id]) }}">
						@csrf
						<button type="submit" class="btn btn-warning">Odebrat roli moderátora</button>
					</form>
				@endif
			</div>
			@endif
		</div>
	</div>
	@endforeach
	@endif
</div>
@endsection