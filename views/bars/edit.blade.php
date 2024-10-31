@extends('plantilla.plantilla')
@section('titulo', 'Local')
@section('contenido')
    <div class="container">
        <div class="col-8 offset-2 isla-list p-4 mt-5">
            <div class="ttl text-center mb-4">
                <h1>Añadir bar</h1>
            </div>
            <form action="{{ route('bars.update', $bar->id) }}" method="POST" autocomplete="off">
                @csrf
                @method('PUT')

                <input type="hidden" name="zone" value="{{$bar->zone_id}}">
                <!-- Nombre -->
                <div class="form-floating mb-3">
                    <input type="text" name="name" class="form-control @error('name') is-invalid @enderror"
                        id="floatingName" placeholder="Nombre máquina" value="{{ old('name', $bar->name) }}">
                    <label for="floatingName">Nombre</label>
                    @error('name')
                        <div class="invalid-feedback"> {{ $message }} </div>
                    @enderror
                </div>

                <!-- Holder -->
                <div class="form-floating mb-3">
                    <input type="text" name="holder" class="form-control @error('holder') is-invalid @enderror"
                        id="floatingHolder" placeholder="holder máquina" value="{{ old('holder', $bar->holder) }}">
                    <label for="floatingHolder">Titular</label>
                    @error('holder')
                        <div class="invalid-feedback"> {{ $message }} </div>
                    @enderror
                </div>

                <!-- cif -->
                <div class="form-floating mb-3">
                    <input type="text" name="cif" class="form-control @error('cif') is-invalid @enderror"
                        id="floatingCif" placeholder="cif" value="{{ old('cif',$bar->dni_cif) }}">
                    <label for="floatingCif">DNI - CIF</label>
                    @error('cif')
                        <div class="invalid-feedback"> {{ $message }} </div>
                    @enderror
                </div>

                <!-- Dirección -->
                <div class="form-floating mb-3">
                    <input type="text" name="direccion" class="form-control @error('direccion') is-invalid @enderror"
                        id="floatingDireccion" placeholder="Dirección" value="{{ old('direccion',$bar->address) }}">
                    <label for="floatingDireccion">Dirección</label>
                    @error('direccion')
                        <div class="invalid-feedback"> {{ $message }} </div>
                    @enderror
                </div>

                <!-- Población -->
                <div class="form-floating mb-3">
                    <input type="text" name="poblacion" class="form-control @error('poblacion') is-invalid @enderror"
                        id="floatingPoblacion" placeholder="Número" value="{{ old('poblacion', $bar->town) }}">
                    <label for="floatingPoblacion">Población</label>
                    @error('poblacion')
                        <div class="invalid-feedback"> {{ $message }} </div>
                    @enderror
                </div>

                <!-- Botón de Enviar -->
                <div class="form-group mt-3 text-end">
                    <button type="submit" class="btn btn-primary">Editar</button>
                    <button type="reset" class="btn btn-danger">Limpiar</button>
                </div>
            </form>
        </div>
    </div>
@endsection
