@extends('plantilla.plantilla')
@section('titulo', 'Usuario')
@section('contenido')
    <div class="container">
        <div class="col-8 offset-2 isla-list p-4 mt-5">
            <div class="ttl text-center mb-4">
                <h1>Editar técnico {{ $user->name }}</h1>
            </div>
            <form action="{{ route('users.update', $user->id) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="form-floating mb-3">
                    <input value="{{ $user->name }}" type="name" name="nameUser" class="form-control" id="floatingInput"
                        placeholder="nombre">
                    <label for="floatingInput">Nombre</label>
                    @if ($errors->has('nameUser'))
                        <div class="text-danger" style="color: red"> {{ $errors->first('nameUser') }} </div>
                    @endif
                </div>
                <div class="form-floating mb-3">
                    <input value="{{ $user->email }}" type="email" name="emailUser" class="form-control"
                        id="floatingInput" placeholder="name@example.com">
                    <label for="floatingInput">Correo electrónico</label>
                    @if ($errors->has('emailUser'))
                        <div class="text-danger" style="color: red"> {{ $errors->first('emailUser') }} </div>
                    @endif
                </div>
                <div class="form-floating">
                    <input value="" type="password" name="passUser" class="form-control" id="floatingPassword"
                        placeholder="Password">
                    <label for="floatingPassword">Contraseña</label>
                    @if ($errors->has('passUser'))
                        <div class="text-danger" style="color: red"> {{ $errors->first('passUser') }} </div>
                    @endif
                </div>
                <div class="mb-3">
                    <p class="d-inline-flex gap-1">
                        <a data-bs-toggle="collapse" href="#collapseUpdate" role="button" aria-expanded="false"
                            aria-controls="collapseUpdate">
                            Modificar contraseña
                        </a>
                    </p>
                    <div class="collapse" id="collapseUpdate">
                        <div class="card card-body p-0">
                            <div class="form-floating">
                                <input value="" type="password" name="passUserUpdate" class="form-control"
                                    id="floatingPassword" placeholder="Password">
                                <label for="floatingPassword">Cambio de contraseña</label>
                                @if ($errors->has('passUserUpdate'))
                                    <div class="text-danger" style="color: red"> {{ $errors->first('passUserUpdate') }}
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
                <input type='hidden' name="idDelegation" value="{{ $user->delegation_id }}">
                <div class="text-end">
                    <a href="{{route('delegations.show', $user->delegation[0]->id)}}" class="btn btn-danger mt-4" >Cancelar</a>
                    <input type="submit" class="btn btn-success mt-4" value="Editar">
                </div>
            </form>
        </div>
    </div>
@endsection
