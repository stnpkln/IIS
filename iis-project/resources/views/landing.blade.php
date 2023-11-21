@extends('layout')
@section('content')
@if (session('user'))
	<h1>Vítejte {{ session('user') }}</h1>
@else
	<h1>Vítejte na naší sociální síti!</h1>
	<p> Pokud se přejete produkt používat, tak se musíte nejdřív <a href="{{ route('login') }}">přihlásit</a></p>
@endif 
@endsection