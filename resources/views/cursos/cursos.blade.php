@extends('layouts.home')

@section('title', 'Cursos')

@push('styles')
<link rel="stylesheet" href="{{ asset ('build/assets/cursos.9aba15cb.css')}}">
@endpush

@section('content')

<input type="hidden" value="{{ asset('cursos/')}}" id="assets-cursos"/>
<input type="hidden" value="{{ asset('usuarios/')}}" id="assets-usuarios"/>
<input type="hidden" value="{{$IdTipoUsuario}}" id="id-tipo-usuario"/>


<div class="col-md-12">
    <div class="container">
        <div class="row">
            <div class="col-md-12">

                <h2 class="my-3 display-5 text-start fw-bolder primer-color-letra">Cursos</h2>

                @if ($IdTipoUsuario == 1)
                    <div class="row">
                        <ul class="nav nav-tabs my-0-5" role="tablist">
                            <li class="nav-item" role="presentation">
                                <button class="nav-link active fuenteNormal primer-color-letra primer-color-fondo" id="cursos-actuales-tab" data-bs-toggle="tab" data-bs-target="#cursos-actuales" type="button" role="tab" aria-controls="cursos-actuales" aria-selected="true">Cursos actuales</button>
                            </li>
                            <li class="nav-item" role="presentation">
                                <button class="nav-link fuenteNormal tercer-color-letra tercer-color-fondo" id="cursos-finalizados-tab" data-bs-toggle="tab" data-bs-target="#cursos-finalizados" type="button" role="tab" aria-controls="cursos-finalizados" aria-selected="false">Cursos finalizados</button>
                            </li>
                            <li class="nav-item" role="presentation">
                                <button class="nav-link fuenteNormal tercer-color-letra tercer-color-fondo" id="cursos-nuevos-tab" data-bs-toggle="tab" data-bs-target="#cursos-nuevos" type="button" role="tab" aria-controls="cursos-nuevos" aria-selected="false">Cursos nuevos</button>
                            </li>
                        </ul>
                    </div>
                @else

                    <div class="row">
                        <div class="col-md-10">
                            <ul class="nav nav-tabs my-0-5" role="tablist">
                                <li class="nav-item" role="presentation">
                                    <button class="nav-link active fuenteNormal primer-color-letra primer-color-fondo" id="cursos-actuales-tab" data-bs-toggle="tab" data-bs-target="#cursos-actuales" type="button" role="tab" aria-controls="cursos-actuales" aria-selected="true">Cursos actuales</button>
                                </li>
                                <li class="nav-item" role="presentation">
                                    <button class="nav-link fuenteNormal tercer-color-letra tercer-color-fondo" id="cursos-finalizados-tab" data-bs-toggle="tab" data-bs-target="#cursos-finalizados" type="button" role="tab" aria-controls="cursos-finalizados" aria-selected="false">Cursos finalizados</button>
                                </li>
                            </ul>
                        </div>
                        <div class="col-md-2 d-flex justify-content-end">
                            <button class="btn fuenteNormal my-1 text-wrap border border-2 tercer-color-letra tercer-color-fondo" type="button" id="agregar-curso" data-bs-toggle="modal" data-bs-target="#agregar-curso-modal" >
                                <i class="fa-solid fa-plus"></i> Agregar Curso
                            </button>
                        </div>
                    </div>
                @endif

                <div class="box row pt-1">

                    <div class="tab-content">

                        @if ($IdTipoUsuario == 1)

                            <div class="tab-pane fade show active" id="cursos-actuales" role="tabpanel" aria-labelledby="cursos-actuales-tab">
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="table-responsive mt-3">
                                            <table class="table table-striped display order-column hover nowrap" id="table-cursos-actuales-estudiante"> </table>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="tab-pane fade show" id="cursos-finalizados" role="tabpanel" aria-labelledby="cursos-finaizados-tab">
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="table-responsive mt-3">
                                            <table class="table table-striped display order-column hover nowrap" id="table-cursos-finalizados-estudiante"> </table>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="tab-pane fade show" id="cursos-nuevos" role="tabpanel" aria-labelledby="cursos-nuevos-tab">
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="table-responsive mt-3">
                                            <table class="table table-striped display order-column hover nowrap" id="table-cursos-nuevos"> </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @else
                            <div class="tab-pane fade show active" id="cursos-actuales" role="tabpanel" aria-labelledby="cursos-actuales-tab">
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="table-responsive mt-3">
                                            <table class="table table-striped display order-column hover nowrap" id="table-cursos-actuales-profesor"> </table>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="tab-pane fade show" id="cursos-finalizados" role="tabpanel" aria-labelledby="cursos-finalizados-tab">
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="table-responsive mt-3">
                                            <table class="table table-striped display order-column hover nowrap" id="table-cursos-finalizados-profesor"> </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


<!-- Modal -->
<div class="modal fade text-center" id="agregar-curso-modal" tabindex="-1" role="dialog" aria-labelledby="titulo-modal-agregar-curso" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content primer-color-letra primer-color-fondo">
            <div class="modal-header">
                <h5 class="modal-title" id="titulo-modal-agregar-curso">Agregar curso</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form method="HEAD" id="form-agregar-curso">
                <div class="modal-body">
                    <div class="container-fluid g-5">
                    
                        <div class="row mt-2">
                            <div class="col-md-12 form-group">
                                <label for="nombre-curso" class="form-label">Nombre del curso*</label>
                                <input type="text" class="form-control fuenteNormal" name="nombre-curso" id="nombre-curso" placeholder="Ingrese el nombre del curso" maxlength="250" minlength="3" required>
                            </div>
                        </div>

                        <div class="row mt-4">
                            <div class="col-md-12 form-group">
                                <label for="descripcion-curso" class="form-label">Descripción del curso*</label>
                                <textarea class="form-control fuenteNormal" name="descripcion-curso" cols="30" rows="10" id="descripcion-curso" placeholder="Ingrese la descripción del curso" maxlength="4000" required></textarea>
                            </div>
                        </div>

                        <div class="row mt-4">
                            <div class="col-md-12 form-group">
                                <div class="d-flex justify-content-center mb-4" id="seleccionar-imagen">
                                    <img id="imagen-seleccionada" class="img-fluid shadow-lg" src="https://static.vecteezy.com/system/resources/thumbnails/002/534/006/small/social-media-chatting-online-blank-profile-picture-head-and-body-icon-people-standing-icon-grey-background-free-vector.jpg" class="rounded img-fluid" alt="Imagen de curso"/>
                                </div>
                                <div class="d-flex justify-content-center">
                                    <div class="btn btn-rounded tercer-color-letra tercer-color-fondo">
                                        <label class="form-label m-1 fuenteNormal" for="imagen">Cambiar imagen</label>
                                        <input type="file" class="form-control d-none fuenteNormal" id="imagen" accept="image/png, imagejpg, image/jpeg"/>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn segundo-color-letra segundo-color-fondo" data-bs-dismiss="modal">❌ Cancelar</button>
                    <button type="submit" class="btn tercer-color-letra tercer-color-fondo" id="crear-curso">✅ Crear curso</button>
                </div>
            </form>
        </div>
    </div>
</div>


@stop


@push('scripts')
<script type="module" src="{{asset('build/assets/cursos.5a639861.js')}}"></script>

@endpush
