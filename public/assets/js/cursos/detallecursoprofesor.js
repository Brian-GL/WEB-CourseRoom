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
let IdProfesor = document.getElementById("id-profesor").value;

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

let dataTableCursoDesempeno;
dataTableCursoDesempeno = $("#table-curso-desempeno").DataTable({
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
        { title: "IdUsuario"},
        { title: "Estudiante"},
        { title: "Imagen"},
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

dataTableCursoDesempeno.column(0).visible(false);
dataTableCursoDesempeno.column(2).visible(false);
dataTableCursoDesempeno.column(3).visible(false);

// Grupos curso:

let dataTableGruposCurso;
dataTableGruposCurso = $("#table-grupos-curso").DataTable({
    pagingType: 'full_numbers',
    dom: 'rtp',
    language: {
        search: "_INPUT_",
        searchPlaceholder: "Buscar algún grupo...",
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
        { title: "IdGrupo"},
        { title: "Nombre"},
        { title: "Imagen"},
        { title: "Numero de integrantes"},
        { title: "Fecha de registro"},
    ],
    columnDefs:[
        {className: "text-center fuenteNormal segundo-color-letra", targets: "_all"},
    ],
    rowCallback: function(row, data, index){
        $(row).css('color', SegundoColorLetra);
    }
});

dataTableGruposCurso.column(0).visible(false);
dataTableGruposCurso.column(2).visible(false);

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

//Curso miembros profesor:

let dataTableCursoMiembrosProfesor;
dataTableCursoMiembrosProfesor = $("#table-miembros-profesor").DataTable({
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
        { title: "Expulsar ❌"},
    ],
    columnDefs:[
        {className: "text-center fuenteNormal segundo-color-letra", defaultContent: "-", targets: "_all"},
    ],
    rowCallback: (row) => {
        $(row).css('color', SegundoColorLetra);
    }
});

dataTableCursoMiembrosProfesor.column(0).visible(false);
dataTableCursoMiembrosProfesor.column(2).visible(false);

// Tareas curso profesor:

let dataTableTareasProfesorCurso;
dataTableTareasProfesorCurso = $("#table-tareas-profesor-curso").DataTable({
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
        { title: "Tarea"},
        { title: "Fecha de registro"},
        { title: "Fecha de entrega"},
        { title: "Estatus para entrega"},
        { title: "Detalle"},
    ],
    columnDefs:[
        {className: "text-center fuenteNormal segundo-color-letra", targets: "_all"},
    ],
    rowCallback: function(row, data, index){
        $(row).css('color', SegundoColorLetra);
    }
});

dataTableTareasProfesorCurso.column(0).visible(false);

//#region Methods

document.addEventListener('DOMContentLoaded',  ObtenerInformacionInicial, false);

async function ObtenerInformacionInicial(){
    ObtenerMateriales();
    ObtenerMiembros();
    ObtenerTareas();
    ObtenerDesempeno();
    ObtenerGrupos();
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

                dataTableCursoMiembrosProfesor = $("#table-miembros-profesor").DataTable({
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
                        { data: "", title: "Expulsar ❌"},
                    ],
                    columnDefs:[
                        {className: "text-center fuenteNormal segundo-color-letra", defaultContent: "-", targets: "_all"},
                        {className: "fechaRegistro", target: 3},
                        {className: "info-usuario", target: 1},
                        {className: "span-detalle", target: 6},
                    ],
                    data: filas,
                    createdRow: (row, data) => {
                        $('.segundo-color-letra',row).css('color', SegundoColorLetra);
                        $('.span-detalle', row).html('<span class="fuenteNormal span-detalle text-center text-decoration-underline" onclick="ExpulsarEstudiante('.concat(data.idUsuario,')">Expulsar💔</span>'));
                        $('.info-usuario', row).html('<div class="container"><div class="row"><div class="col-5"><img class="img-fluid" alt="Imagen del usuario" src="'.concat(assetsRouteUsuarios,'/',data.imagen,'"/></div><div class="col-7 p-0"><p class="fuenteNormal">',data.nombreCompleto,'</p></div></div></div>'));
                        let fechaRegistro = data.fechaRegistro.substring(0, data.fechaRegistro.length -1 );
                        $('.fechaRegistro', row).text(dayjs(fechaRegistro).format('dddd DD MMM YYYY h:mm A'));
                    }
                });
                
                dataTableCursoMiembrosProfesor.column(0).visible(false);
                dataTableCursoMiembrosProfesor.column(2).visible(false);
            }
            break;
            case 500:{
                dataTableCursoMiembrosProfesor.clear().draw();
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
                dataTableCursoMiembrosProfesor.clear().draw();
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
        dataTableCursoMiembrosProfesor.clear().draw();
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
            url: '/cursos/profesortareasobtener',
            baseURL: BaseURL,
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': document.head.querySelector("[name~=csrf-token][content]").content
            },
            data: {
                "IdCurso": IdCurso,
            }
        });

        HidePreloader();

        let result = response.data;

        switch (result.code) {
            case 200:{
                let filas = result.data;

                dataTableTareasProfesorCurso = $("#table-tareas-profesor-curso").DataTable({
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
                        { data: "tarea", title: "Tarea"},
                        { data: "fechaRegistro", title: "Fecha de registro"},
                        { data: "fechaEntrega", title: "Fecha de entrega"},
                        { data: "estatusEntrega", title: "Estatus para entrega"},
                        { data: "", title: "Detalle"},
                    ],
                    columnDefs:[
                        {className: "text-center fuenteNormal segundo-color-letra", defaultContent: "-", targets: "_all"},
                        {className: "fechaRegistro", target: 2},
                        {className: "fechaEntrega", target: 3},
                        {className: "span-detalle", target: 5},
                    ],
                    data: filas,
                    createdRow: (row, data) => {
                        $('.segundo-color-letra',row).css('color', SegundoColorLetra);
                        $('.span-detalle', row).html('<span class="fuenteNormal span-detalle text-center text-decoration-underline" onclick="DetalleTarea('.concat(data.idTarea,')">Ver detalle</span>'));
                        let fechaRegistro = data.fechaRegistro.substring(0, data.fechaRegistro.length -1 );
                        $('.fechaRegistro', row).text(dayjs(fechaRegistro).format('dddd DD MMM YYYY h:mm A'));
                        let fechaEntrega = data.fechaEntrega.substring(0, data.fechaEntrega.length -1 );
                        $('.fechaEntrega', row).text(dayjs(fechaEntrega).format('dddd DD MMM YYYY h:mm A'));
                    }
                });
                
                dataTableTareasProfesorCurso.column(0).visible(false);
            }
            break;
            case 500:{
                dataTableTareasProfesorCurso.clear().draw();
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
                dataTableTareasProfesorCurso.clear().draw();
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
        dataTableTareasProfesorCurso.clear().draw();
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
            url: '/cursos/desempenoobtener',
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

                dataTableCursoDesempeno = $("#table-curso-desempeno").DataTable({
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
                        { data: "idUsuario", title: "IdUsuario"},
                        { data: "nombreCompleto", title: "Estudiante"},
                        { data: "imagen", title: "Imagen"},
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
                        {className: "fechaRegistro", target: 10},
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
                
                dataTableCursoDesempeno.column(0).visible(false);
                dataTableCursoDesempeno.column(2).visible(false);
                dataTableCursoDesempeno.column(3).visible(false);
            }
            break;
            case 500:{
                dataTableCursoDesempeno.clear().draw();
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
                dataTableCursoDesempeno.clear().draw();
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
        dataTableCursoDesempeno.clear().draw();
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

async function ObtenerGrupos(){
    try{

        ShowPreloader();

        let response = await axios({
            url: '/cursos/grupos',
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

                dataTableGruposCurso = $("#table-grupos-curso").DataTable({
                    pagingType: 'full_numbers',
                    dom: 'rtp',
                    language: {
                        search: "_INPUT_",
                        searchPlaceholder: "Buscar algún grupo...",
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
                        { data: "idGrupo", title: "IdGrupo"},
                        { data: "nombre", title: "Nombre"},
                        { data: "imagen", title: "Imagen"},
                        { data: "numeroIntegrantes", title: "Numero de integrantes"},
                        { data: "fechaRegistro", title: "Fecha de registro"},
                    ],
                    columnDefs:[
                        {className: "text-center fuenteNormal segundo-color-letra", defaultContent: "-", targets: "_all"},
                        {className: "fechaRegistro", target: 4},
                        {className: "info-grupo", target: 1},
                    ],
                    data: filas,
                    createdRow: (row, data) => {
                        $('.segundo-color-letra',row).css('color', SegundoColorLetra);
                        $('.info-grupo', row).html('<div class="container"><div class="row"><div class="col-5"><img class="img-fluid" alt="Imagen del usuario" src="'.concat(assetsRouteCursos,'/',data.imagen,'"/></div><div class="col-7 p-0"><p class="fuenteNormal">',data.nombre,'</p></div></div></div>'));        
                        let fechaRegistro = data.fechaRegistro.substring(0, data.fechaRegistro.length -1 );
                        $('.fechaRegistro', row).text(dayjs(fechaRegistro).format('dddd DD MMM YYYY h:mm A'));
                    }
                });
                
                dataTableGruposCurso.column(0).visible(false);
                dataTableGruposCurso.column(2).visible(false);
            }
            break;
            case 500:{
                dataTableGruposCurso.clear().draw();
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
                dataTableGruposCurso.clear().draw();
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
        dataTableGruposCurso.clear().draw();
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

async function FinalizarCurso(){
    try {

        ShowPreloader();

        let formData = new FormData();

        formData.append('IdCurso', IdCurso);
        formData.append('IdProfesor', IdProfesor);

        let response = await axios({
            url: '/cursos/finalizaractualizar',
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
                    title: 'Finalizar tarea',
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

async function RegistrarMiembroGrupo(){
    try {

        ShowPreloader();

        let formData = new FormData();

        let IdGrupo = document.getElementById("id-grupo").value;
        formData.append('IdGrupo', IdGrupo);
        formData.append('IdProfesor', IdProfesor);
        formData.append('IdCurso', IdCurso);

        let response = await axios({
            url: '/grupos/miembroregistrar',
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
                    title: 'Registrar miembro grupo',
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

async function RegistrarGrupos(){
    try {

        ShowPreloader();

        let formData = new FormData();

        formData.append('IdCurso', IdCurso);
        formData.append('Nombre', document.getElementById("nombre-grupo").value);
        formData.append('Descripcion', document.getElementById("descripcion-grupo").value);

        let response = await axios({
            url: '/grupos/registrar',
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
                    title: 'Registrar grupos',
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

//#endregion