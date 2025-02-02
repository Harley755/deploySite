@extends('base')

@section('content') 
    <p>Nom de la boutique : {{ $shop->name }}</p>
    {{-- <p>Email : {{ $user->email }}</p>
    <p>Âge : {{ $user->age }}</p> --}}
@endsection
