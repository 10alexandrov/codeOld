@extends('plantilla.plantilla')
@section('titulo', 'Local')
@section('contenido')

    <div class="container d-none d-md-block">
        <div class="row">
            <div class="col-12 text-center d-flex justify-content-center mt-3 mb-3" id="headerAll">
                <div class="w-50 ttl">
                    <h1>Bar {{ $local->name }}</h1>
                </div>
            </div>
            <div class="col-6 offset-3">
                <div class="row">
                    <div class="col-10 offset-1 isla-list">
                        <div class="p-4">
                            <div class="row p-2">
                                <div class="col-12">
                                    <a class="btn btn-primary w-100 btn-ttl">Cargas para las máquinas</a>
                                </div>
                            </div>

                            <!-- Mostrar las máquinas del local -->
                            <div class="row p-2">
                                <div class="col-12">
                                    <ul class="list-unstyled">
                                        @foreach ($local->machines as $machine)
                                            <li class="p-2">
                                                @if ($machine->local_id !== null)
                                                    <a href="{{ route('loads.showLocal', [$machine->local_id, $machine->id]) }}"
                                                        class="btn btn-primary w-100 btn-inf">
                                                        {{ $machine->name }} (Local)
                                                    </a>
                                                @elseif ($machine->bar_id !== null)
                                                    <a href="{{ route('loads.showBar', [$machine->bar_id, $machine->id]) }}"
                                                        class="btn btn-primary w-100 btn-inf">
                                                        {{ $machine->name }} (Bar)
                                                    </a>
                                                @endif
                                            </li>
                                        @endforeach
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="container d-block d-md-none text-center pt-5">
        <div class="ttl d-flex align-items-center p-2">
            <div>
                <a href="{{ route('zones.show', $local->zone_id) }}" class="titleLink">
                    <i style="font-size: 30pt" class="bi bi-arrow-bar-left"></i>
                </a>
            </div>
            <div>
                <h1>Local {{ $local->name }}</h1>
            </div>
        </div>

        <div class="mt-5 p-3 isla-list">

            <!-- Mostrar las máquinas del local -->
            <div class="mt-3">
                <ul class="list-unstyled">
                    @foreach ($local->machines as $machine)
                        <li class="p-2">
                            @if ($machine->local_id !== null)
                                <a href="{{ route('loads.showLocal', [$machine->local_id, $machine->id]) }}"
                                    class="btn btn-primary w-100 btn-inf">
                                    {{ $machine->name }} (Local)
                                </a>
                            @elseif ($machine->bar_id !== null)
                                <a href="{{ route('loads.showBar', [$machine->bar_id, $machine->id]) }}"
                                    class="btn btn-primary w-100 btn-inf">
                                    {{ $machine->name }} (Bar)
                                </a>
                            @endif
                        </li>
                    @endforeach
                </ul>
            </div>
        </div>
    </div>

@endsection
