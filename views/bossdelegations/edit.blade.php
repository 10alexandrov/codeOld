@extends('plantilla.plantilla')
@section('titulo', 'Usuario')
@section('contenido')
    <div class="container">
        <div class="col-8 offset-2 isla-list p-4 mt-5">
            <div class="ttl text-center mb-4">
                <h1>Editar {{ $user->name }}</h1>
            </div>
            <form action="{{ route('bossDelegations.update', $user->id) }}" method="POST">
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
                <div>
                    <p class="d-inline-flex gap-1 mb-3">
                        <a data-bs-toggle="collapse" href="#collapseUpdate" role="button" aria-expanded="false"
                            aria-controls="collapseUpdate">
                            Modificar contraseña
                        </a>
                    </p>
                    <div class="collapse mb-3" id="collapseUpdate">
                        <div class="card card-body p-0">
                            <div class="form-floating">
                                <input value="" type="password" name="passUserUpdate" class="form-control"
                                    id="floatingPassword" placeholder="Password">
                                <label for="floatingPassword">Nueva contraseña</label>
                                @if ($errors->has('passUserUpdate'))
                                    <div class="text-danger" style="color: red"> {{ $errors->first('passUserUpdate') }}
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">¿Delegaciones asociadas?</label>
                        <div class="form-check-group p-3 rounded" style="background-color: white">
                            <!-- Ahi que comparar las delegaciones con las delegaciones del usuario para que se queden marcadas  -->
                            @foreach ($delegations as $delegation)
                                <div class="form-check">
                                    @if (in_array($delegation->id, $idDelegationsUser->pluck('id')->toArray()))
                                        <input checked class="form-check-input" type="checkbox"
                                            value="{{ $delegation->id }}" name="Delegations[]" id="{{ $delegation->id }}">
                                    @else
                                        <input class="form-check-input" type="checkbox" value="{{ $delegation->id }}"
                                            name="Delegations[]" id="{{ $delegation->id }}">
                                    @endif
                                    <label class="form-check-label"
                                        for="{{ $delegation->id }}">{{ $delegation->name }}</label>
                                </div>
                            @endforeach
                        </div>
                        @if ($errors->has('Delegations'))
                            <div class="text-danger">{{ $errors->first('Delegations') }}</div>
                        @endif
                    </div>
                </div>
                <input type='hidden' name="idDelegation" value="{{ $user->delegation_id }}">
                <div class="text-end">
                    <a href="{{route('delegations.index')}}" class="btn btn-danger mt-4" >Cancelar</a>
                    <input type="submit" class="btn btn-success mt-4" value="Editar">
                </div>
            </form>
        </div>
    </div>
@endsection
