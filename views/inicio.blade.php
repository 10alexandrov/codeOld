<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Login</title>
    <link href="{{ asset('css/login.css') }}" rel="stylesheet">
    <link rel="icon" href="{{ asset('img/sin fondo - copia_favicon.png') }}" type="image/x-icon">
</head>

<body>
    <div id="caja">
        <img src="{{ asset('img/sin fondo - copia.png') }}">
        @if (!empty($error))
            <div class="text-danger" style="color: red">
                {{ $error }}
            </div>
        @endif
        <form class="mt-3" action="{{ route('login') }}" method="POST">
            @csrf
            <div class="form-floating mb-3">
                <input type="text" class="form-control" id="floatingInput" placeholder="Usuario" name="name"
                    value="{{ old('name') }}">
                <label for="floatingInput">Usuario</label>
                @if ($errors->has('name'))
                    <div class="text-danger"> {{ $errors->first('name') }} </div>
                @endif
            </div>
            <div class="form-floating">
                <input type="password" class="form-control" id="floatingPassword" placeholder="Contraseña"
                    name="password" value="{{ old('password') }}">
                <label for="floatingPassword">Contraseña</label>
                @if ($errors->has('password'))
                    <div class="text-danger"> {{ $errors->first('password') }} </div>
                @endif
            </div>
            <input type="submit" value="Acceder" class="mt-4">
        </form>
    </div>
</body>

</html>
