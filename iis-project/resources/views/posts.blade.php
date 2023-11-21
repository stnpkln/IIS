@extends('layout')
@section('content')
<div class="container">
	<div class="d-flex flex-row justify-content-between">
		<h1>Vlákno: {{ $thread->topic }}</h1>
		<div class="d-flex flex-row gap-3">
			@if ($canDelete)
			<div>
				<form method="post" action="{{ route('thread.delete', ['id' => $thread->id]) }}">
					@csrf
					<button type="submit" class="btn btn-danger">Smazat Vlákno</button>
				</form>
			</div>
			@endif
			<div>
				<a href="{{ route('post.create', ['id' => $thread->id]) }}" class="btn btn-success">Přidat příspěvek</a>
			</div>
		</div>
	</div>

	@foreach ($posts as $post)
		<div class="card mb-3">
			<div class="card-body">
				<div class="d-flex flex-row justify-content-between">
					<div>
						<a href="{{ route('user', ['id' => $post->user_id]) }}">{{ $post->username }}</a>
						<h5 class="card-title mt-3">{{ $post->title }}</h5>
					</div>
					@if ($canDelete || $post->user_id === $userId)
						<form method="post" action="{{ route('post.delete', ['id' => $post->id]) }}">
							@csrf
							<button type="submit" class="btn btn-danger">Smazat příspěvek</button>
						</form>
					@endif
				</div>
				<p class="card-text">{{ $post->content }}</p>
				<div class="w-100 d-flex flex-row justify-content-between h-min">
					<p style="font-size: 2rem" class="m-0 {{ $post->rating >= 0 ? 'text-success' : 'text-danger' }}">{{ $post->rating }}</p>
					<div class="d-flex flex-row gap-5">
						<form method="post" action="{{ route('dislike', ['id' => $post->id]) }}">
							@csrf
							<button type="submit" class="btn {{ $post->rating_type === 'dislike' ? 'btn-dark' : 'btn-outline-dark' }} {{ $post->rating_type ? 'disabled' : ''  }}" style="font-size: 1.25rem">dislike 👎</button>
						</form>
						<form method="post" action="{{ route('like', ['id' => $post->id]) }}">
							@csrf
							<button type="submit" class="btn {{ $post->rating_type === 'like' ? 'btn-dark' : 'btn-outline-dark' }} {{ $post->rating_type ? 'disabled' : ''  }}" style="font-size: 1.25rem">like 👍</button>
						</form>
					</div>
				</div>
			</div>
		</div>
	@endforeach
</div>
@endsection