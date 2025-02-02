@extends('base')

@section('content')
    <form action="{{ route('logout') }}" method="post">
        @csrf
        <input type="submit" value="Se déconnecter">
    </form>

    <h1>Dashboard</h1>
   
    <form action="{{ route('shop.store') }}" method="post">
        @csrf
        @method('post')

        <div>
            <label for="name">Le nom de la boutique</label>
            <input type="text" name="name" id="name" placeholder="Entrez le nom de la boutique">
            @if ($errors->has('name'))
                <p>{{ $errors->first('name') }}</p>
            @endif
        </div>


        <input type="submit" value="Deployer">
    </form>
@endsection