@extends('plantilla.plantilla')
@section('titulo', 'Usuario')
@section('contenido')
    <div class="container-fluid">
        <table class="table table-striped">
            <tr>
                <th>ID</th>
                <th>Nombre</th>
                <th>Email</th>
                <th></th>
            </tr>
            @foreach ($users as $user)
                <tr>
                    <td>{{ $user->id }}</td>
                    <td>{{ $user->name }}</td>
                    <td>{{ $user->email }}</td>
                    <td>
                        <a href="/delegations/users/destroy/{{ $user->id }}" class="bi bi-trash"></a>
                        <a class="bi bi-pencil" data-bs-toggle="offcanvas" href="#offcanvasEditUser{{ $user->id }}" role="button"
                            aria-controls="offcanvasExample"></a>
                    </td>
                </tr>

                <!--OFFCANVAS PARA EDITAR USUARIO-->
                <div class="offcanvas offcanvas-start" tabindex="-1" id="offcanvasEditUser{{ $user->id }}"
                    aria-labelledby="offcanvasExampleLabel">
                    <div class="offcanvas-header">
                        <h5 class="offcanvas-title" id="offcanvasExampleLabel">Editar Usuario</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
                    </div>
                    <div class="offcanvas-body d-flex flex-column">
                        <form action="/delegations/users/update/{{$user->id}}" method="POST" class="d-flex flex-column">
                            @csrf
                            <input type="text" name="nameUser" value="{{ $user->name }}" placeholder="Nombre">
                            @if ($errors->has('nameUser'))
                                <div class="text-danger"> {{ $errors->first('nameUser') }} </div>
                            @endif

                            <input type="email" name="emailUser" value="{{ $user->email }}" placeholder="Email">
                            @if ($errors->has('emailUser'))
                                <div class="text-danger"> {{ $errors->first('emailUser') }} </div>
                            @endif

                            <input type="password" name="passUser" placeholder="Contraseña">
                            @if ($errors->has('passUser'))
                                <div class="text-danger"> {{ $errors->first('passUser') }} </div>
                            @endif

                            <input type='hidden' name="idDelegation" value="{{ $delegation->id }}">
                            <input type="submit" value="Editar Usuario">

                            <p class="d-inline-flex gap-1">
                                <a data-bs-toggle="collapse" href="#collapseExample" role="button" aria-expanded="false"
                                    aria-controls="collapseExample">
                                    Modificar contraseña
                                </a>
                            </p>
                            <div class="collapse" id="collapseExample">
                                <div class="card card-body">
                                    <input type="password" name="newPassUser" placeholder="Nueva Contraseña">
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            @endforeach
        </table>

        <button class="btn btn-warning" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasCreateUser"
            aria-controls="offcanvasExample">
            Crear Usuario
        </button>

        <!--OFFCANVAS PARA CREAR USUARIO-->
        <div class="offcanvas offcanvas-start" tabindex="-1" id="offcanvasCreateUser"
            aria-labelledby="offcanvasExampleLabel">
            <div class="offcanvas-header">
                <h5 class="offcanvas-title" id="offcanvasExampleLabel">Crear Usuario</h5>
                <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
            </div>
            <div class="offcanvas-body">
                <div>
                    <form action="/delegations/users/store" method="POST" class="d-flex flex-column">
                        @csrf
                        <input type="text" name="nameUser" value="{{ old('nameUser') }}" placeholder="Nombre">
                        @if ($errors->has('nameUser'))
                            <div class="text-danger"> {{ $errors->first('nameUser') }} </div>
                        @endif

                        <input type="email" name="emailUser" value="{{ old('emailUser') }}" placeholder="Email">
                        @if ($errors->has('emailUser'))
                            <div class="text-danger"> {{ $errors->first('emailUser') }} </div>
                        @endif

                        <input type="password" name="passUser" placeholder="Contraseña">
                        @if ($errors->has('passUser'))
                            <div class="text-danger"> {{ $errors->first('passUser') }} </div>
                        @endif

                        <input type='hidden' name="idDelegation" value="{{ $delegation->id }}">
                        <input type="submit" value="Crear Usuario">
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
