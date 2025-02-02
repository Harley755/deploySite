@extends('base')

@section('content')
    <form action="{{ route('doLogin') }}" method="post">
        @csrf
        @method('post')
        <div>
            <label for="email">Email</label>
            <input type="email" name="email" id="email" placeholder="Entrez votre email">
               @if ($errors->has('email'))
                <p>{{ $errors->first('email') }}</p>
            @endif
        </div>

        <div>
            <label for="password">Password</label>
            <input type="password" name="password" id="password" placeholder="Entrez votre password">
               @if ($errors->has('password'))
                <p>{{ $errors->first('password') }}</p>
            @endif
        </div>

        <p>Vous n'avez pas de compte ? <a href="{{ route('register') }}">Inscrivez-vous</a></p>


        <input type="submit" value="Se connecter">
    </form>
@endsection