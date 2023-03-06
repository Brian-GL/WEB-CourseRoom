'use strict';

let SegundoColor = localStorage.getItem("SegundoColor");
let SegundoColorLetra = localStorage.getItem("SegundoColorLetra");
let TercerColor = localStorage.getItem("TercerColor");
let TercerColorLetra = localStorage.getItem("TercerColorLetra");
let PrimerColor = localStorage.getItem("PrimerColor");
let PrimerColorLetra = localStorage.getItem("PrimerColorLetra");
let BaseURL = window.location.origin;

let assestRouteCursos = document.getElementById("assets-cursos").value;
let assetsRouteUsuarios = document.getElementById("assets-usuarios").value;

let IdCurso = document.getElementById("id-curso").value;
let IdUsuario = document.getElementById("id-usuario").value;
let Finalizado = document.getElementById("estatus-curso").value;

let elementos = document.querySelectorAll('input[type="search"]');
for(let elemento of elementos){
    elemento.style.setProperty('color',PrimerColorLetra,'important');
    elemento.style.setProperty('background-color',PrimerColorLetra,'important');
    elemento.classList.add(PrimerColorLetra === 'rgb(0,0,0)' ? "white-placeholder" : "black-placeholder");
}

elementos = document.querySelectorAll('.paginate_button a');
for(let elemento of elementos){
    elemento.style.setProperty('color',SegundoColorLetra,'important');
    elemento.style.setProperty('background-color',SegundoColor,'important');
}

//#region Events

$(".nav-link").on("click",  (e) => {

    let elementos = document.getElementsByClassName("nav-link");

    for(let elemento of elementos){
        if(elemento.id !== e.target.id){
            elemento.style.setProperty('color',TercerColorLetra,'important');
            elemento.style.setProperty('background-color',TercerColor,'important');
        }else{
            elemento.style.setProperty('color',PrimerColorLetra,'important');
            elemento.style.setProperty('background-color',PrimerColor,'important');
        }
    }
});

//#endregion

//Cursos materiales:

let dataTableCursoMateriales;
dataTableCursoMateriales = $("#table-materiales").DataTable({
    pagingType: 'full_numbers',
    dom: 'frtp',
    search: {
        return: true,
    },
    scrollX: false,
    language: {
        search: "_INPUT_",
        searchPlaceholder: "Buscar algún material..",
        paginate: {
            "first":      "Primero",
            "last":       "Último",
            "next":       "Siguiente",
            "previous":   "Anterior"
        },
        zeroRecords: "Sin resultados encontrados",
        emptyTable: "Sin datos en la tabla",
        infoEmpty: "Sin entradas",
        loadingRecords: "Cargando..."
    },
    columns: [
        { title: "IdMaterialSubido"},
        { title: "Nombre del archivo"},
        { title: "Archivo"},
        { title: "IdUsuarioEmisor"},
        { title: "Subido por"},
        { title: "Fecha de registro"},
        { title: "Descargar 📥" }
    ],
    columnDefs:[
        {className: "text-center fuenteNormal segundo-color-letra", defaultContent: "-", targets: "_all"},
    ],
    rowCallback: (row) => {
        $(row).css('color', SegundoColorLetra);
    }
});

dataTableCursoMateriales.column(0).visible(false);
dataTableCursoMateriales.column(2).visible(false);
dataTableCursoMateriales.column(3).visible(false);

//Curso miembros estudiante:

let dataTableCursoMiembrosEstudiante;
dataTableCursoMiembrosEstudiante = $("#table-miembros-estudiante").DataTable({
    pagingType: 'full_numbers',
    dom: 'frtp',
    search: {
        return: true,
    },
    scrollX: false,
    language: {
        search: "_INPUT_",
        searchPlaceholder: "Buscar algún integrante...",
        paginate: {
            "first":      "Primero",
            "last":       "Último",
            "next":       "Siguiente",
            "previous":   "Anterior"
        },
        zeroRecords: "Sin resultados encontrados",
        emptyTable: "Sin datos en la tabla",
        infoEmpty: "Sin entradas",
        loadingRecords: "Cargando..."
    },
    columns: [
        { title: "IdUsuario"},
        { title: "Integrante"},
        { title: "Imagen"},
        { title: "Fecha de incorporación"},
        { title: "Fecha de actualización"},
        { title: "Estatus"},
    ],
    columnDefs:[
        {className: "text-center fuenteNormal segundo-color-letra", defaultContent: "-", targets: "_all"},
    ],
    rowCallback: (row) => {
        $(row).css('color', SegundoColorLetra);
    }
});

dataTableCursoMiembrosEstudiante.column(0).visible(false);
dataTableCursoMiembrosEstudiante.column(2).visible(false);

//Tareas estudiante curso:

let dataTableTareasEstudianteCurso;
dataTableTareasEstudianteCurso = $("#table-tareas-estudiante-curso").DataTable({
    pagingType: 'full_numbers',
    dom: 'rtp',
    language: {
        search: "_INPUT_",
        searchPlaceholder: "Buscar alguna tarea...",
        paginate: {
            "first":      "Primero",
            "last":       "Último",
            "next":       "Siguiente",
            "previous":   "Anterior"
        },
        zeroRecords: "Sin resultados encontrados",
        emptyTable: "Sin datos en la tabla",
        infoEmpty: "Sin entradas",
        loadingRecords: "Cargando..."
    },
    columns: [
        { title: "IdTarea"},
        { title: "Nombre"},
        { title: "Fecha de registro"},
        { title: "Fecha de entrega"},
        { title: "Entregada el"},
        { title: "Calificada el"},
        { title: "Calificación"},
        { title: "Puntualidad"},
        { title: "Estatus"},
        { title: "Detalle"},
    ],
    columnDefs:[
        {className: "text-center fuenteNormal segundo-color-letra", targets: "_all"},
    ],
    rowCallback: function(row, data, index){
        $(row).css('color', SegundoColorLetra);
    }
});

dataTableTareasEstudianteCurso.column(0).visible(false);

//Curso estudiante desempeño:

let dataTableCursoEstudianteDesempeno;
dataTableCursoEstudianteDesempeno = $("#table-curso-estudiante-desempeno").DataTable({
    pagingType: 'full_numbers',
    dom: 'rtp',
    language: {
        search: "_INPUT_",
        searchPlaceholder: "Buscar algún registro...",
        paginate: {
            "first":      "Primero",
            "last":       "Último",
            "next":       "Siguiente",
            "previous":   "Anterior"
        },
        zeroRecords: "Sin resultados encontrados",
        emptyTable: "Sin datos en la tabla",
        infoEmpty: "Sin entradas",
        loadingRecords: "Cargando..."
    },
    columns: [
        { title: "IdTarea"},
        { title: "Tarea"},
        { title: "Calificación"},
        { title: "Promedio de calificación"},
        { title: "Predicción de calificación"},
        { title: "Puntualidad"},
        { title: "Promedio de puntualidad"},
        { title: "Fecha de registro"},
    ],
    columnDefs:[
        {className: "text-center fuenteNormal segundo-color-letra", targets: "_all"},
    ],
    rowCallback: function(row, data, index){
        $(row).css('color', SegundoColorLetra);
    }
});

dataTableCursoEstudianteDesempeno.column(0).visible(false);

//#region Methods

document.addEventListener('DOMContentLoaded',  ObtenerInformacionInicial, false);

async function ObtenerInformacionInicial(){
    ObtenerMateriales();
    ObtenerMiembros();
    ObtenerTareas();
    ObtenerDesempeno();
}

async function ObtenerMateriales(){
    try{

        ShowPreloader();

        let response = await axios({
            url: '/cursos/materialesobtener',
            baseURL: BaseURL,
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': document.head.querySelector("[name~=csrf-token][content]").content
            },
            data: {
                "IdCurso": IdCurso
            }
        });

        HidePreloader();

        let result = response.data;

        switch (result.code) {
            case 200:{
                let filas = result.data;

                dataTableCursoMateriales = $("#table-materiales").DataTable({
                    pagingType: 'full_numbers',
                    dom: 'frtp',
                    search: {
                        return: true,
                    },
                    scrollX: false,
                    language: {
                        search: "_INPUT_",
                        searchPlaceholder: "Buscar algún material...",
                        paginate: {
                            "first":      "Primero",
                            "last":       "Último",
                            "next":       "Siguiente",
                            "previous":   "Anterior"
                        },
                        zeroRecords: "Sin resultados encontrados",
                        emptyTable: "Sin datos en la tabla",
                        infoEmpty: "Sin entradas",
                        loadingRecords: "Cargando..."
                    },
                    columns: [
                        { data: "idMaterialSubido", title: "IdMaterialSubido"},
                        { data: "nombre", title: "Nombre del archivo"},
                        { data: "archivo", title: "Archivo"},
                        { data: "idUsuarioEmisor", title: "IdUsuarioEmisor"},
                        { data: "nombreUsuarioEmisor", title: "Subido por"},
                        { data: "fechaRegistro", title: "Fecha de registro"},
                        { data: "", title: "Descargar 📥" }
                    ],
                    columnDefs:[
                        {className: "text-center fuenteNormal segundo-color-letra", defaultContent: "-", targets: "_all"},
                        {className: "span-detalle", target: 6},
                        {className: "fechaRegistro", target: 5},
                    ],
                    data: filas,
                    createdRow: (row, data) => {
                        $('.segundo-color-letra',row).css('color', SegundoColorLetra);
                        $('.span-detalle', row).html('<a class="fuenteNormal span-detalle text-center text-decoration-underline" href="'.concat(assetsRouteCursos,'/',data.archivo,'">Descargar archivo</a>'));
                        let fechaRegistro = data.fechaRegistro.substring(0, data.fechaRegistro.length -1 );
                        $('.fechaRegistro', row).text(dayjs(fechaRegistro).format('dddd DD MMM YYYY h:mm A'));
                    }
                });
                
                dataTableCursoMateriales.column(0).visible(false);
                dataTableCursoMateriales.column(2).visible(false);
                dataTableCursoMateriales.column(3).visible(false);
            }
            break;
            case 500:{
                dataTableCursoMateriales.clear().draw();
                Swal.fire({
                    title: '¡Error!',
                    text: result.data,
                    imageUrl: BaseURL.concat("/assets/templates/SadOwl.png"),
                    imageWidth: 100,
                    imageHeight: 123,
                    background: '#000000',
                    color: '#FFFFFF',
                    imageAlt: 'Error Image'
                });
            }
            break;
            default:{
                dataTableCursoMateriales.clear().draw();
                Swal.fire({
                    title: '¡Alerta!',
                    text: result.data,
                    imageUrl: BaseURL.concat("/assets/templates/IndiferentOwl.png"),
                    imageWidth: 100,
                    imageHeight: 123,
                    imageAlt: 'Alert Image',
                    background: '#000000',
                    color: '#FFFFFF'
                });
            }
            break;
        }
    }
    catch(ex){

        HidePreloader();
        dataTableCursoMateriales.clear().draw();
        Swal.fire({
            title: '¡Error!',
            text: ex,
            imageUrl: BaseURL.concat("/assets/templates/SadOwl.png"),
            imageWidth: 100,
            imageHeight: 123,
            background: '#000000',
            color: '#FFFFFF',
            imageAlt: 'Error Image'
        });
    }
}

async function ObtenerMiembros(){
    try{

        ShowPreloader();

        let response = await axios({
            url: '/cursos/estudianteobtener',
            baseURL: BaseURL,
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': document.head.querySelector("[name~=csrf-token][content]").content
            },
            data: {
                "IdCurso": IdCurso
            }
        });

        HidePreloader();

        let result = response.data;

        switch (result.code) {
            case 200:{
                let filas = result.data;

                dataTableCursoMiembrosEstudiante = $("#table-miembros-estudiante").DataTable({
                    pagingType: 'full_numbers',
                    dom: 'frtp',
                    search: {
                        return: true,
                    },
                    scrollX: false,
                    language: {
                        search: "_INPUT_",
                        searchPlaceholder: "Buscar algún integrante...",
                        paginate: {
                            "first":      "Primero",
                            "last":       "Último",
                            "next":       "Siguiente",
                            "previous":   "Anterior"
                        },
                        zeroRecords: "Sin resultados encontrados",
                        emptyTable: "Sin datos en la tabla",
                        infoEmpty: "Sin entradas",
                        loadingRecords: "Cargando..."
                    },
                    columns: [
                        { data: "idUsuario", title: "IdUsuario"},
                        { data: "nombreCompleto", title: "Integrante"},
                        { data: "imagen", title: "Imagen"},
                        { data: "fechaRegistro", title: "Fecha de incorporación"},
                        { data: "fechaActualizacion", title: "Fecha de actualización"},
                        { data: "estatus", title: "Estatus"},
                    ],
                    columnDefs:[
                        {className: "text-center fuenteNormal segundo-color-letra", defaultContent: "-", targets: "_all"},
                        {className: "fechaRegistro", target: 3},
                        {className: "info-usuario", target: 1},
                    ],
                    data: filas,
                    createdRow: (row, data) => {
                        $('.segundo-color-letra',row).css('color', SegundoColorLetra);
                        $('.info-usuario', row).html('<div class="container"><div class="row"><div class="col-5"><img class="img-fluid" alt="Imagen del usuario" src="'.concat(assetsRouteUsuarios,'/',data.imagen,'"/></div><div class="col-7 p-0"><p class="fuenteNormal">',data.nombreCompleto,'</p></div></div></div>'));
                        let fechaRegistro = data.fechaRegistro.substring(0, data.fechaRegistro.length -1 );
                        $('.fechaRegistro', row).text(dayjs(fechaRegistro).format('dddd DD MMM YYYY h:mm A'));
                    }
                });
                
                dataTableCursoMiembrosEstudiante.column(0).visible(false);
                dataTableCursoMiembrosEstudiante.column(2).visible(false);
            }
            break;
            case 500:{
                dataTableCursoMiembrosEstudiante.clear().draw();
                Swal.fire({
                    title: '¡Error!',
                    text: result.data,
                    imageUrl: BaseURL.concat("/assets/templates/SadOwl.png"),
                    imageWidth: 100,
                    imageHeight: 123,
                    background: '#000000',
                    color: '#FFFFFF',
                    imageAlt: 'Error Image'
                });
            }
            break;
            default:{
                dataTableCursoMiembrosEstudiante.clear().draw();
                Swal.fire({
                    title: '¡Alerta!',
                    text: result.data,
                    imageUrl: BaseURL.concat("/assets/templates/IndiferentOwl.png"),
                    imageWidth: 100,
                    imageHeight: 123,
                    imageAlt: 'Alert Image',
                    background: '#000000',
                    color: '#FFFFFF'
                });
            }
            break;
        }
    }
    catch(ex){

        HidePreloader();
        dataTableCursoMiembrosEstudiante.clear().draw();
        Swal.fire({
            title: '¡Error!',
            text: ex,
            imageUrl: BaseURL.concat("/assets/templates/SadOwl.png"),
            imageWidth: 100,
            imageHeight: 123,
            background: '#000000',
            color: '#FFFFFF',
            imageAlt: 'Error Image'
        });
    }
}

async function ObtenerTareas(){
    try{

        ShowPreloader();

        let response = await axios({
            url: '/cursos/tareasestudianteobtener',
            baseURL: BaseURL,
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': document.head.querySelector("[name~=csrf-token][content]").content
            },
            data: {
                "IdCurso": IdCurso,
                "IdUsuario": IdUsuario
            }
        });

        HidePreloader();

        let result = response.data;

        switch (result.code) {
            case 200:{
                let filas = result.data;

                dataTableTareasEstudianteCurso = $("#table-tareas-estudiante-curso").DataTable({
                    pagingType: 'full_numbers',
                    dom: 'rtp',
                    language: {
                        search: "_INPUT_",
                        searchPlaceholder: "Buscar alguna tarea...",
                        paginate: {
                            "first":      "Primero",
                            "last":       "Último",
                            "next":       "Siguiente",
                            "previous":   "Anterior"
                        },
                        zeroRecords: "Sin resultados encontrados",
                        emptyTable: "Sin datos en la tabla",
                        infoEmpty: "Sin entradas",
                        loadingRecords: "Cargando..."
                    },
                    columns: [
                        { data: "idTarea", title: "IdTarea"},
                        { data: "nombre", title: "Nombre"},
                        { data: "fechaRegistro", title: "Fecha de registro"},
                        { data: "fechaEntrega", title: "Fecha de entrega"},
                        { data: "fechaEntregada", title: "Entregada el"},
                        { data: "fechaCalificacion", title: "Calificada el"},
                        { data: "calificacion", title: "Calificación"},
                        { data: "puntualidad", title: "Puntualidad"},
                        { data: "estatus", title: "Estatus"},
                        { data: "", title: "Detalle"},
                    ],
                    columnDefs:[
                        {className: "text-center fuenteNormal segundo-color-letra", defaultContent: "-", targets: "_all"},
                        {className: "fechaRegistro", target: 2},
                        {className: "fechaEntrega", target: 3},
                        {className: "fechaEntregada", target: 4},
                        {className: "fechaCalificacion", target: 5},
                        {className: "span-detalle", target: 9},
                    ],
                    data: filas,
                    createdRow: (row, data) => {
                        $('.segundo-color-letra',row).css('color', SegundoColorLetra);
                        $('.span-detalle', row).html('<span class="fuenteNormal span-detalle text-center text-decoration-underline" onclick="DetalleTarea('.concat(data.idTarea,')">Ver detalle</span>'));
                        let fechaRegistro = data.fechaRegistro.substring(0, data.fechaRegistro.length -1 );
                        $('.fechaRegistro', row).text(dayjs(fechaRegistro).format('dddd DD MMM YYYY h:mm A'));
                
                        let fechaEntrega = data.fechaEntrega.substring(0, data.fechaEntrega.length -1 );
                        $('.fechaEntrega', row).text(dayjs(fechaEntrega).format('dddd DD MMM YYYY h:mm A'));
                
                        let fechaEntregada = dayjs(data.fechaEntregada?.substring(0,data.fechaEntregada?.length-1));
                        if(fechaEntregada.isValid()){
                            $('.fechaEntregada', row).text(fechaEntregada.format('LLLL'));
                        }
                
                        let fechaCalificacion = dayjs(data.fechaCalificacion?.substring(0,data.fechaCalificacion?.length-1));
                        if(fechaCalificacion.isValid()){
                            $('.fechaCalificacion', row).text(fechaCalificacion.format('LLLL'));
                        }
                
                    }
                });
                
                dataTableTareasEstudianteCurso.column(0).visible(false);
            }
            break;
            case 500:{
                dataTableTareasEstudianteCurso.clear().draw();
                Swal.fire({
                    title: '¡Error!',
                    text: result.data,
                    imageUrl: BaseURL.concat("/assets/templates/SadOwl.png"),
                    imageWidth: 100,
                    imageHeight: 123,
                    background: '#000000',
                    color: '#FFFFFF',
                    imageAlt: 'Error Image'
                });
            }
            break;
            default:{
                dataTableTareasEstudianteCurso.clear().draw();
                Swal.fire({
                    title: '¡Alerta!',
                    text: result.data,
                    imageUrl: BaseURL.concat("/assets/templates/IndiferentOwl.png"),
                    imageWidth: 100,
                    imageHeight: 123,
                    imageAlt: 'Alert Image',
                    background: '#000000',
                    color: '#FFFFFF'
                });
            }
            break;
        }
    }
    catch(ex){

        HidePreloader();
        dataTableTareasEstudianteCurso.clear().draw();
        Swal.fire({
            title: '¡Error!',
            text: ex,
            imageUrl: BaseURL.concat("/assets/templates/SadOwl.png"),
            imageWidth: 100,
            imageHeight: 123,
            background: '#000000',
            color: '#FFFFFF',
            imageAlt: 'Error Image'
        });
    }
}

async function ObtenerDesempeno(){
    try{

        ShowPreloader();

        let response = await axios({
            url: '/cursos/estudiantedesempenoobtener',
            baseURL: BaseURL,
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': document.head.querySelector("[name~=csrf-token][content]").content
            },
            data: {
                "IdCurso": IdCurso,
                "IdUsuario": IdUsuario
            }
        });

        HidePreloader();

        let result = response.data;

        switch (result.code) {
            case 200:{
                let filas = result.data;

                dataTableCursoEstudianteDesempeno = $("#table-curso-estudiante-desempeno").DataTable({
                    pagingType: 'full_numbers',
                    dom: 'rtp',
                    language: {
                        search: "_INPUT_",
                        searchPlaceholder: "Buscar algún registro...",
                        paginate: {
                            "first":      "Primero",
                            "last":       "Último",
                            "next":       "Siguiente",
                            "previous":   "Anterior"
                        },
                        zeroRecords: "Sin resultados encontrados",
                        emptyTable: "Sin datos en la tabla",
                        infoEmpty: "Sin entradas",
                        loadingRecords: "Cargando..."
                    },
                    columns: [
                        { data: "idTarea", title: "IdTarea"},
                        { data: "tarea", title: "Tarea"},
                        { data: "calificacion", title: "Calificación"},
                        { data: "promedioCalificacionCurso", title: "Promedio de calificación"},
                        { data: "prediccionCalificacionCurso", title: "Predicción de calificación"},
                        { data: "puntualidad", title: "Puntualidad"},
                        { data: "promedioPuntualidadCurso", title: "Promedio de puntualidad"},
                        { data: "fechaRegistro", title: "Fecha de registro"},
                    ],
                    columnDefs:[
                        {className: "text-center fuenteNormal segundo-color-letra", defaultContent: "-", targets: "_all"},
                        {className: "fechaRegistro", target: 7},
                    ],
                    data: filas,
                    createdRow: (row, data) => {
                        $('.segundo-color-letra',row).css('color', SegundoColorLetra);
                        
                        let fechaRegistro = data.fechaRegistro.substring(0, data.fechaRegistro.length -1 );
                        $('.fechaRegistro', row).text(dayjs(fechaRegistro).format('dddd DD MMM YYYY h:mm A'));
                    }
                });
                
                dataTableCursoEstudianteDesempeno.column(0).visible(false);
            }
            break;
            case 500:{
                dataTableCursoEstudianteDesempeno.clear().draw();
                Swal.fire({
                    title: '¡Error!',
                    text: result.data,
                    imageUrl: BaseURL.concat("/assets/templates/SadOwl.png"),
                    imageWidth: 100,
                    imageHeight: 123,
                    background: '#000000',
                    color: '#FFFFFF',
                    imageAlt: 'Error Image'
                });
            }
            break;
            default:{
                dataTableCursoEstudianteDesempeno.clear().draw();
                Swal.fire({
                    title: '¡Alerta!',
                    text: result.data,
                    imageUrl: BaseURL.concat("/assets/templates/IndiferentOwl.png"),
                    imageWidth: 100,
                    imageHeight: 123,
                    imageAlt: 'Alert Image',
                    background: '#000000',
                    color: '#FFFFFF'
                });
            }
            break;
        }
    }
    catch(ex){

        HidePreloader();
        dataTableCursoEstudianteDesempeno.clear().draw();
        Swal.fire({
            title: '¡Error!',
            text: ex,
            imageUrl: BaseURL.concat("/assets/templates/SadOwl.png"),
            imageWidth: 100,
            imageHeight: 123,
            background: '#000000',
            color: '#FFFFFF',
            imageAlt: 'Error Image'
        });
    }
}

async function RegistrarMaterialCurso(){
    try {

        ShowPreloader();

        let formData = new FormData();

        formData.append('IdCurso', IdCurso);
        formData.append('IdUsuario', IdUsuario);
        formData.append('NombreArchivo', document.getElementById("nombre-material").value);

        let response = await axios({
            url: '/cursos/materialregistrar',
            baseURL: BaseURL,
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': document.head.querySelector("[name~=csrf-token][content]").content
            },
            data: formData
        });

        HidePreloader();

        let result = response.data;

        switch (result.code) {
            case 200:{
               
                Swal.fire({
                    title: 'Registrar material curso',
                    text: result.data,
                    imageUrl: BaseURL.concat("/assets/templates/HappyOwl.png"),
                    imageWidth: 100,
                    imageHeight: 123,
                    imageAlt: 'Ok Image',
                    background: '#000000',
                    color: '#FFFFFF'
                });
            }
            break;
            case 500: {
                Swal.fire({
                    title: '¡Error!',
                    text: result.data,
                    imageUrl: BaseURL.concat("/assets/templates/SadOwl.png"),
                    imageWidth: 100,
                    imageHeight: 123,
                    background: '#000000',
                    color: '#FFFFFF',
                    imageAlt: 'Error Image'
                });
            }
                break;
            default: {
                Swal.fire({
                    title: '¡Alerta!',
                    text: result.data,
                    imageUrl: BaseURL.concat("/assets/templates/IndiferentOwl.png"),
                    imageWidth: 100,
                    imageHeight: 123,
                    imageAlt: 'Alert Image',
                    background: '#000000',
                    color: '#FFFFFF'
                });
            }
                break;
        }
    }
    catch (ex) {
        HidePreloader();
        Swal.fire({
            title: '¡Error!',
            text: ex,
            imageUrl: BaseURL.concat("/assets/templates/SadOwl.png"),
            imageWidth: 100,
            imageHeight: 123,
            background: '#000000',
            color: '#FFFFFF',
            imageAlt: 'Error Image'
        });
    }
}

async function FinalizarCursoEstudiante(){
    try {

        ShowPreloader();

        let formData = new FormData();

        formData.append('IdCurso', IdCurso);
        formData.append('IdUsuario', IdUsuario);

        let response = await axios({
            url: '/cursos/estudiantefinalizaractualizar',
            baseURL: BaseURL,
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': document.head.querySelector("[name~=csrf-token][content]").content
            },
            data: formData
        });

        HidePreloader();

        let result = response.data;

        switch (result.code) {
            case 200:{
               
                Swal.fire({
                    title: 'Finalizar curso estudiante',
                    text: result.data,
                    imageUrl: BaseURL.concat("/assets/templates/HappyOwl.png"),
                    imageWidth: 100,
                    imageHeight: 123,
                    imageAlt: 'Ok Image',
                    background: '#000000',
                    color: '#FFFFFF'
                });
            }
            break;
            case 500: {
                Swal.fire({
                    title: '¡Error!',
                    text: result.data,
                    imageUrl: BaseURL.concat("/assets/templates/SadOwl.png"),
                    imageWidth: 100,
                    imageHeight: 123,
                    background: '#000000',
                    color: '#FFFFFF',
                    imageAlt: 'Error Image'
                });
            }
                break;
            default: {
                Swal.fire({
                    title: '¡Alerta!',
                    text: result.data,
                    imageUrl: BaseURL.concat("/assets/templates/IndiferentOwl.png"),
                    imageWidth: 100,
                    imageHeight: 123,
                    imageAlt: 'Alert Image',
                    background: '#000000',
                    color: '#FFFFFF'
                });
            }
                break;
        }
    }
    catch (ex) {
        HidePreloader();
        Swal.fire({
            title: '¡Error!',
            text: ex,
            imageUrl: BaseURL.concat("/assets/templates/SadOwl.png"),
            imageWidth: 100,
            imageHeight: 123,
            background: '#000000',
            color: '#FFFFFF',
            imageAlt: 'Error Image'
        });
    }
}

async function RegistrarRespuestaCuestionario(){
    try {

        ShowPreloader();

        let formData = new FormData();

        let IdPregunta = document.getElementById("id-pregunta").value;

        formData.append('IdCurso', IdCurso);
        formData.append('IdUsuario', IdUsuario);
        formData.append('IdPregunta', IdPregunta);
        formData.append('Puntaje', document.getElementById("puntaje-curso").value);

        let response = await axios({
            url: '/cursos/cuestionariorespuestaregistrar',
            baseURL: BaseURL,
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': document.head.querySelector("[name~=csrf-token][content]").content
            },
            data: formData
        });

        HidePreloader();

        let result = response.data;

        switch (result.code) {
            case 200:{
               
                Swal.fire({
                    title: 'Registrar respuesta cuestionario',
                    text: result.data,
                    imageUrl: BaseURL.concat("/assets/templates/HappyOwl.png"),
                    imageWidth: 100,
                    imageHeight: 123,
                    imageAlt: 'Ok Image',
                    background: '#000000',
                    color: '#FFFFFF'
                });
            }
            break;
            case 500: {
                Swal.fire({
                    title: '¡Error!',
                    text: result.data,
                    imageUrl: BaseURL.concat("/assets/templates/SadOwl.png"),
                    imageWidth: 100,
                    imageHeight: 123,
                    background: '#000000',
                    color: '#FFFFFF',
                    imageAlt: 'Error Image'
                });
            }
                break;
            default: {
                Swal.fire({
                    title: '¡Alerta!',
                    text: result.data,
                    imageUrl: BaseURL.concat("/assets/templates/IndiferentOwl.png"),
                    imageWidth: 100,
                    imageHeight: 123,
                    imageAlt: 'Alert Image',
                    background: '#000000',
                    color: '#FFFFFF'
                });
            }
                break;
        }
    }
    catch (ex) {
        HidePreloader();
        Swal.fire({
            title: '¡Error!',
            text: ex,
            imageUrl: BaseURL.concat("/assets/templates/SadOwl.png"),
            imageWidth: 100,
            imageHeight: 123,
            background: '#000000',
            color: '#FFFFFF',
            imageAlt: 'Error Image'
        });
    }
}

document.DetalleTarea = async function(IdTarea){

    try{

        ShowPreloader();

        $('<form/>', { action: '/tareas/estudiantedetalle', method: 'POST' }).append(
            $('<input>', {type: 'hidden', id: '_token', name: '_token', value: document.head.querySelector("[name~=csrf-token][content]").content}),
            $('<input>', {type: 'hidden', id: 'IdTarea', name: 'IdTarea', value: IdTarea})
        ).appendTo('body').submit();
            
        HidePreloader();
          
    }
    catch(ex){

        HidePreloader();
        Swal.fire({
            title: '¡Error!',
            text: ex,
            imageUrl: BaseURL.concat("/assets/templates/SadOwl.png"),
            imageWidth: 100,
            imageHeight: 123,
            background: '#000000',
            color: '#FFFFFF',
            imageAlt: 'Error Image'
        });
    }
}

async function EnviarMensaje(mensaje, archivo, base64Archivo) {

    try {

        ShowPreloader();
        let formData = new FormData();
        formData.append("IdCurso", IdCurso);
        formData.append("Mensaje", mensaje);
        formData.append("Base64Archivo", base64Archivo);
        formData.append("Archivo", archivo);

        let response = await axios({
            url: '/cursos/mensajeregistrar',
            baseURL: BaseURL,
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': document.head.querySelector("[name~=csrf-token][content]").content
            },
            data: formData
        });

        HidePreloader();

        let result = response.data;

        switch (result.code) {
            case 200:{
                let fechaRegistroFormat = dayjs(result.fecha).format('DD/MM/YYYY h:mm A');
                GenerarMensaje(fechaRegistroFormat,mensaje, result.nombreArchivo, document.getElementById("nombre-usuario").innerHTML, result.imagenEmisor);
            }
            break;
            case 500: {
                Swal.fire({
                    title: '¡Error!',
                    text: result.data,
                    imageUrl: BaseURL.concat("/assets/templates/SadOwl.png"),
                    imageWidth: 100,
                    imageHeight: 123,
                    background: '#000000',
                    color: '#FFFFFF',
                    imageAlt: 'Error Image'
                });
            }
                break;
            default: {
                Swal.fire({
                    title: '¡Alerta!',
                    text: result.data,
                    imageUrl: BaseURL.concat("/assets/templates/IndiferentOwl.png"),
                    imageWidth: 100,
                    imageHeight: 123,
                    imageAlt: 'Alert Image',
                    background: '#000000',
                    color: '#FFFFFF'
                });
            }
                break;
        }
    }
    catch (ex) {
        HidePreloader();
        Swal.fire({
            title: '¡Error!',
            text: ex,
            imageUrl: BaseURL.concat("/assets/templates/SadOwl.png"),
            imageWidth: 100,
            imageHeight: 123,
            background: '#000000',
            color: '#FFFFFF',
            imageAlt: 'Error Image'
        });
    }
}

function GenerarMensaje(fechaRegistro, mensaje, nombreArchivo, nombreUsuarioEmisor, imagenEmisor) {

    let elemento;

    if (nombreArchivo === undefined || nombreArchivo === null || nombreArchivo === '') {
        elemento =
            `<div class="col-md-12 d-flex justify-content-start"><div class="d-flex justify-content-start mb-4"><img src="${assetsUsuariosRoute}${imagenEmisor}" alt="avatar" class="rounded-circle d-flex align-self-start ms-3 shadow-1-strong" width="60"><div class="card mask-custom"><div class="card-header d-flex justify-content-between p-3"style="border-bottom: 1px solid rgba(255,255,255,.3);"><div class="row"><div class="col-md-6 text-center text-wrap"><p class="fw-bold mb-0">${nombreUsuarioEmisor}</p></div><div class="col-md-6 text-center text-wrap"><p class="text-light small mb-0"><i class="far fa-clock"></i> ${fechaRegistro}</p></div></div></div><div class="card-body"><p class="mb-0">${mensaje}</p></div></div></div></div>`;
    } else {
        elemento =
            `<div class="col-md-12 d-flex justify-content-start"><div class="d-flex justify-content-start mb-4"><img src="${assetsUsuariosRoute}${imagenEmisor}" alt="avatar" class="rounded-circle d-flex align-self-start ms-3 shadow-1-strong" width="60"><div class="card mask-custom"><div class="card-header d-flex justify-content-between p-3"style="border-bottom: 1px solid rgba(255,255,255,.3);"><div class="row"><div class="col-md-6 text-center text-wrap"><p class="fw-bold mb-0">${nombreUsuarioEmisor}</p></div><div class="col-md-6 text-center text-wrap"><p class="text-light small mb-0"><i class="far fa-clock"></i> ${fechaRegistro}</p></div></div></div><div class="card-body"><a href="${assestRouteCursos}${nombreArchivo}" target="_blank"><i class="fa-solid fa-file-lines"></i>&nbsp;${mensaje}'</a></div></div></div></div>`;
    }

    $("#mensajes").append(elemento);

}

async function EnviarMaterial(filename, base64, file) {

    try {

        ShowPreloader();
        let formData = new FormData();
        formData.append("IdCurso", IdCurso);
        formData.append("NombreArchivo", filename);
        formData.append("Base64Archivo", base64);
        formData.append("Archivo", file);

        let response = await axios({
            url: '/cursos/materialregistrar',
            baseURL: BaseURL,
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': document.head.querySelector("[name~=csrf-token][content]").content
            },
            data: formData
        });

        HidePreloader();

        let resultado = response.data;

        switch (resultado.code) {
            case 200:{
                Swal.fire({
                    title: 'Compartir material',
                    text: resultado.data,
                    imageUrl: BaseURL.concat("/assets/templates/HappyOwl.png"),
                    imageWidth: 100,
                    imageHeight: 123,
                    imageAlt: 'Ok Image',
                    background: '#000000',
                    color: '#FFFFFF'
                }).then((result) => {
                    if (result.isConfirmed) {
                       ObtenerMateriales();
                    }
                });
            }
            break;
            case 500: {
                Swal.fire({
                    title: '¡Error!',
                    text: resultado.data,
                    imageUrl: BaseURL.concat("/assets/templates/SadOwl.png"),
                    imageWidth: 100,
                    imageHeight: 123,
                    background: '#000000',
                    color: '#FFFFFF',
                    imageAlt: 'Error Image'
                });
            }
                break;
            default: {
                Swal.fire({
                    title: '¡Alerta!',
                    text: resultado.data,
                    imageUrl: BaseURL.concat("/assets/templates/IndiferentOwl.png"),
                    imageWidth: 100,
                    imageHeight: 123,
                    imageAlt: 'Alert Image',
                    background: '#000000',
                    color: '#FFFFFF'
                });
            }
                break;
        }
    }
    catch (ex) {
        HidePreloader();
        Swal.fire({
            title: '¡Error!',
            text: ex,
            imageUrl: BaseURL.concat("/assets/templates/SadOwl.png"),
            imageWidth: 100,
            imageHeight: 123,
            background: '#000000',
            color: '#FFFFFF',
            imageAlt: 'Error Image'
        });
    }
}

//#endregion

//#region Events

$("#enviar-mensaje").on("click", () => {

    let mensaje = document.getElementById("mensaje").value;

    if (mensaje !== null && mensaje !== undefined && mensaje !== '') {
        EnviarMensaje(mensaje, null, null);
        document.getElementById("mensaje").value = "";
    }

});

$("#mensaje").on("keypress", (e) => {

    if (e.code === 'Enter') {
        let mensaje = document.getElementById("mensaje").value;

        if (mensaje !== null && mensaje !== undefined && mensaje !== '') {
            EnviarMensaje(mensaje, null, null);
            document.getElementById("mensaje").value = "";
        }
    }

});

$("#enviar-archivo").on("click", async () => {

    try {

        const { value: file } = await Swal.fire({
            title: 'Enviar archivo',
            text: "Selecciona un archivo para enviarlo",
            imageUrl: 'https://freesvg.org/img/file_server.png',
            imageWidth: 100,
            imageHeight: 123,
            background: '#000000',
            color: '#FFFFFF',
            imageAlt: 'File image',
            input: 'file',
            inputAttributes: {
                'class': 'form-control',
                'aria-label': 'Sube tu archivo',
            },
            showCloseButton: true,
            showConfirmButton: true,
            confirmButtonText: 'Subir Archivo 📄'
        });

        if (file) {

            if (file.size < 15000000) { //MAX 15 MB
                const reader = new FileReader();
                reader.onload = async (e) => {

                    let base64 = await GetBase64FromUrl(e.target.result);
                    let filename = file.name;

                    EnviarMensaje(filename, file, base64);
                }
                reader.readAsDataURL(file);
            } else {
                Swal.fire({
                    title: '¡Alerta!',
                    text: 'El archivo supera el tamaño máximo permitido 😐',
                    imageUrl: BaseURL.concat("/assets/templates/IndiferentOwl.png"),
                    imageWidth: 100,
                    imageHeight: 123,
                    imageAlt: 'Alert Image',
                    background: '#000000',
                    color: '#FFFFFF'
                });
            }
        } else {
            Swal.fire({
                title: '¡Alerta!',
                text: 'Es necesario subir archivo 😐',
                imageUrl: BaseURL.concat("/assets/templates/IndiferentOwl.png"),
                imageWidth: 100,
                imageHeight: 123,
                imageAlt: 'Alert Image',
                background: '#000000',
                color: '#FFFFFF'
            });
        }
    }
    catch (ex) {

        Swal.fire({
            title: '¡Error!',
            text: ex,
            imageUrl: BaseURL.concat("/assets/templates/SadOwl.png"),
            imageWidth: 100,
            imageHeight: 123,
            background: '#000000',
            color: '#FFFFFF',
            imageAlt: 'Error Image'
        });
    }

});

$("#subir-material").addEventListener('click', async () => {
    try {

        const { value: file } = await Swal.fire({
            title: 'Subir material para compartir',
            text: "Selecciona un archivo para compartir",
            imageUrl: 'https://freesvg.org/img/file_server.png',
            imageWidth: 100,
            imageHeight: 123,
            background: '#000000',
            color: '#FFFFFF',
            imageAlt: 'File image',
            input: 'file',
            inputAttributes: {
                'class': 'form-control',
                'aria-label': 'Sube tu archivo',
            },
            showCloseButton: true,
            showConfirmButton: true,
            confirmButtonText: 'Subir Archivo 📄'
        });

        if (file) {

            if (file.size < 15000000) { //MAX 15 MB
                const reader = new FileReader();
                reader.onload = async (e) => {

                    let base64 = await GetBase64FromUrl(e.target.result);
                    let filename = file.name;

                    EnviarMaterial(filename, base64, file);
                }
                reader.readAsDataURL(file);
            } else {
                Swal.fire({
                    title: '¡Alerta!',
                    text: 'El archivo supera el tamaño máximo permitido 😐',
                    imageUrl: BaseURL.concat("/assets/templates/IndiferentOwl.png"),
                    imageWidth: 100,
                    imageHeight: 123,
                    imageAlt: 'Alert Image',
                    background: '#000000',
                    color: '#FFFFFF'
                });
            }
        } else {
            Swal.fire({
                title: '¡Alerta!',
                text: 'Es necesario subir archivo 😐',
                imageUrl: BaseURL.concat("/assets/templates/IndiferentOwl.png"),
                imageWidth: 100,
                imageHeight: 123,
                imageAlt: 'Alert Image',
                background: '#000000',
                color: '#FFFFFF'
            });
        }
    }
    catch (ex) {

        Swal.fire({
            title: '¡Error!',
            text: ex,
            imageUrl: BaseURL.concat("/assets/templates/SadOwl.png"),
            imageWidth: 100,
            imageHeight: 123,
            background: '#000000',
            color: '#FFFFFF',
            imageAlt: 'Error Image'
        });
    }
});

//#endregion