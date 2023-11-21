@extends('layout')
@section('content')
<div class="container">
	<h1>Vytvořit vlákno</h1>
	<form method="post" action="{{ route('thread.create.post', ['groupId' => $groupId]) }}" accept-charset="UTF-8">
		@csrf
		<div class="mb-3">
			<label for="topic" class="form-label">Téma vlákna</label>
			<textarea type="text" class="form-control" id="topic" name="topic" maxlength="255"></textarea>
		</div>
		<button type="submit" class="btn btn-primary">Vytvořit vlákno</button>
	</form>
</div>
@endsection