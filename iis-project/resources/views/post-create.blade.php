@extends('layout')
@section('content')
<div class="container">
	<h1>Vytvořit příspěvek</h1>
	<form method="post" action="{{ route('post.create.post', ['id' => $thread->id]) }}" accept-charset="UTF-8">
		@csrf
		<div class="mb-3">
			<label for="title" class="form-label">Nadpis</label>
			<input type="text" class="form-control" id="title" name="title" maxlength="50">
		</div>
		<div class="mb-3">
			<label for="content" class="form-label">Obsah</label>
			<textarea type="text" class="form-control" id="content" name="content" maxlength="500"></textarea>
		</div>
		<button type="submit" class="btn btn-primary">Vytvořit příspěvek</button>
	</form>
</div>
@endsection