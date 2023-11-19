@extends('layout')
@section('content')
<div class="container">
	<h1>Vytvořit skupinu</h1>
	<form method="post" action="{{ route('group.create.post') }}" accept-charset="UTF-8">
		@csrf
		<div class="mb-3">
			<label for="name" class="form-label">Název *</label>
			<input type="text" class="form-control" id="name" name="name" maxlength="50" required>
		</div>
		<div class="mb-3">
			<label for="description" class="form-label">Popis</label>
			<textarea type="text" class="form-control" id="description" name="description" maxlength="500"></textarea>
		</div>
		<select class="form-select mb-3" name="visibility" required>
			<option value="all" selected>členy vidí všichni</option>
			<option value="registered">členy vidí pouze registrovaní</option>
			<option value="hidden">členy vidí jen ostatní členové</option>
		</select>
		<button type="submit" class="btn btn-primary">Vytvořit skupinu</button>
	</form>
</div>
@endsection