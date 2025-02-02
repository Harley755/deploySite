@extends('base')

@section('content')
    <form action="{{ route('doRegister') }}" method="post">
        @csrf

        <div>
            <label for="name">Nom</label>
            <input type="text" name="name" id="name" placeholder="Entrez votre nom">

            @if ($errors->has('name'))
                <p>{{ $errors->first('name') }}</p>
            @endif
        </div>

        <div>
            <label for="email">Email</label>
            <input type="email" name="email" id="email" placeholder="Entrez votre email">
              @if ($errors->has('email'))
                <p>{{ $errors->first('email') }}</p>
            @endif
        </div>

        <div>
            <label for="age">Age</label>
            <input type="number" name="age" id="age" placeholder="Entrez votre age">
              @if ($errors->has('age'))
                <p>{{ $errors->first('age') }}</p>
            @endif
        </div>

         <div>
            <label for="password">Mot de passe</label>
            <input type="password" name="password" id="password" required>
             @if ($errors->has('password'))
                <p>{{ $errors->first('password') }}</p>
            @endif
        </div>

        <div>
            <label for="password_confirmation">Confirmer le mot de passe</label>
            <input type="password" name="password_confirmation" id="password_confirmation" required>
        </div>


        <p>Vous avez déjà un compte ? <a href="{{ route('login') }}">Connectez-vous</a></p>

        <input type="submit" value="S'inscrire">
    </form>
@endsection