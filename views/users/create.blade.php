@extends('plantilla.plantilla')
@section('titulo', 'Usuario')
@section('contenido')
    <div class="container">
        <div class="col-8 offset-2 isla-list p-4 mt-5">
            <div class="ttl text-center mb-4">
                <h1>Crear usuario</h1>
            </div>
            <form action="{{ route('users.store') }}" method="POST">
                @csrf
                <div class="form-floating mb-3">
                    <input value="{{ old('nameUser') }}" type="name" name="nameUser" class="form-control" id="floatingInput"
                        placeholder="nombre">
                    <label for="floatingInput">Nombre</label>
                    @if ($errors->has('nameUser'))
                        <div class="text-danger" style="color: red"> {{ $errors->first('nameUser') }} </div>
                    @endif
                </div>
                <div class="form-floating mb-3">
                    <input value="{{ old('emailUser') }}" type="email" name="emailUser" class="form-control"
                        id="floatingInput" placeholder="name@example.com">
                    <label for="floatingInput">Correo electrónico</label>
                    @if ($errors->has('emailUser'))
                        <div class="text-danger" style="color: red"> {{ $errors->first('emailUser') }} </div>
                    @endif
                </div>
                <div class="form-floating">
                    <input type="password" name="passUser" class="form-control" id="floatingPassword"
                        placeholder="Password">
                    <label for="floatingPassword">Contraseña</label>
                    @if ($errors->has('passUser'))
                        <div class="text-danger" style="color: red"> {{ $errors->first('passUser') }} </div>
                    @endif
                </div>
                <input type='hidden' name="idDelegation" value="{{ $delegation->id }}">
                <div class="text-end">
                    <a href="{{route('delegations.show', $delegation->id)}}" class="btn btn-danger mt-4" >Cancelar</a>
                    <input type="submit" class="btn btn-success mt-4" value="Crear usuario">
                </div>
            </form>

            @if ($errors->has(''))
                <div class="text-danger" style="color: red"> {{ $errors->first('nameZone') }} </div>
            @endif
        </div>
    </div>
@endsection
