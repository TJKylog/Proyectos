@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row justify-content-center">
        @if (Auth::user()->hasRole('Student'))
            <div class="col-auto">
                <a class="btn btn-primary" href="/projects/new">
                    Crear projecto
                </a>
            </div>
        @endif

        @if(Auth::user()->hasRole('Admin'))
            <div class="col-10 mb-4">
                <div class="row">
                    <div class="col-6">
                        <form action="" method="get">
                            <div class="form-group">
                                <label>Buscar usuario</label>
                                <input class="form-control" type="text" name="user" required>
                            </div>
                            <button class="btn btn-primary">Buscar</button>
                        </form>
                    </div>
                    <div class="col-6">
                        <form action="" method="get">
                            <div class="form-group">
                                <label>Buscar proyecto</label>
                                <input class="form-control" type="text" name="project" required>
                            </div>
                            <button class="btn btn-primary">Buscar</button>
                        </form>
                    </div>
                </div>
            </div>
        @endif
        
        <div class="col-10">
            <div class="card">
                <div class="card-header">
                    @if (Auth::user()->hasRole('Student'))
                        Mis pryectos
                    @else
                        Proyectos
                    @endif
                </div>
                <div class="card-body">
                    <table class="table">
                        <thead>
                          <tr>
                            <th scope="col">#</th>
                            <th scope="col">Nombre</th>
                            <th scope="col">Fechas</th>
                            <th scope="col">Usuario</th>
                            <th scope="col">Tecnologías</th>
                            <th scope="col">Asignatura</th>
                            <th scope="col">Habilidades adquiridas</th>
                          </tr>
                        </thead>
                        <tbody>
                            @foreach ($projects as $item)
                                <tr>
                                    <td>{{$item->id}}</td>
                                    <td>{{$item->name}}</td>
                                    <td>{{$item->start_date}} - {{$item->end_date}} </td>
                                    <td>@isset($item->user[0])
                                        {{$item->user[0]->name}}
                                        @endisset
                                    </td>
                                    <td>
                                        <ul>
                                            @foreach ($item->technologies as $tech)
                                                <li>
                                                    {{$tech->name}}
                                                </li>
                                            @endforeach
                                        </ul>
                                    </td>
                                    <td>
                                        @foreach ($item->subjects as $subject)
                                            {{$subject->name}}
                                        @endforeach
                                    </td>
                                    <td>
                                        <ul>
                                            @foreach ($item->skills as $skill)
                                                <li>
                                                    {{$skill->name}}
                                                </li>
                                            @endforeach
                                        </ul>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                      </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
