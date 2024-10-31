@extends('plantilla.plantilla')
@section('titulo', 'Usuario')
@section('contenido')
    <div class="container">
        <div class="col-8 offset-2 isla-list p-4 mt-5">
            <!-- Form crear usuario-->
            <div class="ttl text-center mb-4">
                <h1>Crear Jefe Técnico</h1>
            </div>
            <form action="{{ route('bossDelegations.store') }}" method="POST">
                @csrf
                @method('POST')
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
                <div class="form-floating mb-3">
                    <input type="password" name="passUser" class="form-control" id="floatingPassword"
                        placeholder="Password">
                    <label for="floatingPassword">Contraseña</label>
                    @if ($errors->has('passUser'))
                        <div class="text-danger" style="color: red"> {{ $errors->first('passUser') }} </div>
                    @endif
                </div>

                <div class="mb-3">
                    <label class="form-label">¿Delegaciones asociadas?</label>
                    <div class="form-check-group p-3 rounded" style="background-color: white">
                        @foreach ($delegations as $delegation)
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" value="{{ $delegation->id }}" name="Delegations[]" id="delegation{{ $delegation->id }}">
                                <label class="form-check-label" for="delegation{{ $delegation->id }}">
                                    {{ $delegation->name }}
                                </label>
                            </div>
                        @endforeach
                    </div>
                    @if ($errors->has('Delegations'))
                        <div class="text-danger">{{ $errors->first('Delegations') }}</div>
                    @endif
                </div>

                <div class="text-end">
                    <a href="{{route('delegations.index')}}" class="btn btn-danger mt-4" >Cancelar</a>
                    <input type="submit" class="btn btn-warning mt-4" value="Crear">
                </div>
            </form>

            @if ($errors->has(''))
                <div class="text-danger" style="color: red"> {{ $errors->first('nameZone') }} </div>
            @endif
        </div>
    </div>


@endsection
