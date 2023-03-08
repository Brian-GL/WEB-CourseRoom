'use strict';

let SegundoColor = localStorage.getItem("SegundoColor");
let SegundoColorLetra = localStorage.getItem("SegundoColorLetra");
let TercerColor = localStorage.getItem("TercerColor");
let TercerColorLetra = localStorage.getItem("TercerColorLetra");
let PrimerColor = localStorage.getItem("PrimerColor");
let PrimerColorLetra = localStorage.getItem("PrimerColorLetra");
let BaseURL = window.location.origin;

let assetsRouteTareas = document.getElementById("assets-tareas").value;
let assetsRouteUsuarios = document.getElementById("assets-usuarios").value;

let IdTarea = document.getElementById("id-tarea").value;
let IdUsuario = document.getElementById("id-usuario").value;
let EstatusTarea = document.getElementById("estatus-tarea").value;

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

//Archivos adjuntos:

let dataTableTareaArchivosAdjuntos;
dataTableTareaArchivosAdjuntos = $("#table-archivos-adjuntos").DataTable({
    pagingType: 'full_numbers',
    dom: 'frtp',
    search: {
        return: true,
    },
    scrollX: false,
    language: {
        search: "_INPUT_",
        searchPlaceholder: "Buscar algún archivo adjunto...",
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
        { title: "IdArchivoAdjunto"},
        { title: "Nombre del archivo"},
        { title: "Archivo"},
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

dataTableTareaArchivosAdjuntos.column(0).visible(false);
dataTableTareaArchivosAdjuntos.column(2).visible(false);

//Archivos entregados estudiante:

let dataTableTareaArchivosEntregadosEstudiante;
dataTableTareaArchivosEntregadosEstudiante = $("#table-archivos-entregados-estudiante").DataTable({
    pagingType: 'full_numbers',
    dom: 'frtp',
    search: {
        return: true,
    },
    scrollX: false,
    language: {
        search: "_INPUT_",
        searchPlaceholder: "Buscar algún archivo entregado...",
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
        { title: "IdArchivoEntregado"},
        { title: "Nombre del archivo"},
        { title: "Archivo"},
        { title: "Fecha de registro"},
        { title: "Descargar 📥" },
        { title: "Remover ❌" }
    ],
    columnDefs:[
        {className: "text-center fuenteNormal segundo-color-letra", defaultContent: "-", targets: "_all"},
    ],
    rowCallback: (row) => {
        $(row).css('color', SegundoColorLetra);
    }
});

dataTableTareaArchivosEntregadosEstudiante.column(0).visible(false);
dataTableTareaArchivosEntregadosEstudiante.column(2).visible(false);

//Retroalimentaciones:

let dataTableTareaRetroalimentaciones;
dataTableTareaRetroalimentaciones = $("#table-retroalimentaciones").DataTable({
    pagingType: 'full_numbers',
    dom: 'frtp',
    search: {
        return: true,
    },
    scrollX: false,
    language: {
        search: "_INPUT_",
        searchPlaceholder: "Buscar alguna retroalimentación...",
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
        { title: "IdRetroalimentacion"},
        { title: "Retroalimentación"},
        { title: "Descripción"},
        { title: "Fecha de registro"},
        { title: "Detalle" }
    ],
    columnDefs:[
        {className: "text-center fuenteNormal segundo-color-letra", defaultContent: "-", targets: "_all"},
    ],
    rowCallback: (row) => {
        $(row).css('color', SegundoColorLetra);
    }
});

dataTableTareaRetroalimentaciones.column(0).visible(false);

//#region Methods

document.addEventListener('DOMContentLoaded',  ObtenerInformacionInicial, false);

async function ObtenerInformacionInicial(){
    ObtenerArchivosAdjuntos();
    ObtenerRetroalimentaciones();
    ObtenerArchivosEntregados();
}

async function ObtenerArchivosAdjuntos(){
    try{

        ShowPreloader();

        let response = await axios({
            url: '/tareas/archivosadjuntos',
            baseURL: BaseURL,
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': document.head.querySelector("[name~=csrf-token][content]").content
            },
            data: {
                "IdTarea": IdTarea
            }
        });

        HidePreloader();

        let result = response.data;

        switch (result.code) {
            case 200:{
                let filas = result.data;

                dataTableTareaArchivosAdjuntos.destroy();

                dataTableTareaArchivosAdjuntos = $("#table-archivos-adjuntos").DataTable({
                    pagingType: 'full_numbers',
                    dom: 'frtp',
                    search: {
                        return: true,
                    },
                    scrollX: false,
                    language: {
                        search: "_INPUT_",
                        searchPlaceholder: "Buscar algún archivo adjunto...",
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
                        { data: "idArchivoAdjunto", title: "IdArchivoAdjunto"},
                        { data: "nombre", title: "Nombre del archivo"},
                        { data: "archivo", title: "Archivo"},
                        { data: "fechaRegistro", title: "Fecha de registro"},
                        { data: "", title: "Descargar 📥" }
                    ],
                    columnDefs:[
                        {className: "text-center fuenteNormal segundo-color-letra", defaultContent: "-", targets: "_all"},
                        {className: "span-detalle", target: 4},
                        {className: "fechaRegistro", target: 3},
                    ],
                    data: filas,
                    createdRow: (row, data) => {
                        $('.segundo-color-letra',row).css('color', SegundoColorLetra);
                        $('.span-detalle', row).html('<a class="fuenteNormal span-detalle text-center text-decoration-underline" href="'.concat(assetsRouteTareas,'/',data.archivo,'">Descargar archivo</a>'));
                        let fechaRegistro = data.fechaRegistro.substring(0, data.fechaRegistro.length -1 );
                        $('.fechaRegistro', row).text(dayjs(fechaRegistro).format('dddd DD MMM YYYY h:mm A'));
                    }
                });
                
                dataTableTareaArchivosAdjuntos.column(0).visible(false);
                dataTableTareaArchivosAdjuntos.column(2).visible(false);
                
            }
            break;
            case 500:{
                dataTableTareaArchivosAdjuntos.clear().draw();
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
                dataTableTareaArchivosAdjuntos.clear().draw();
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
        dataTableTareaArchivosAdjuntos.clear().draw();
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

async function ObtenerRetroalimentaciones(){
    try{

        ShowPreloader();

        let response = await axios({
            url: '/tareas/retroalimentaciones',
            baseURL: BaseURL,
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': document.head.querySelector("[name~=csrf-token][content]").content
            },
            data: {
                "IdTarea": IdTarea,
                "IdUsuario": IdUsuario
            }
        });

        HidePreloader();

        let result = response.data;

        switch (result.code) {
            case 200:{
                let filas = result.data;

                dataTableTareaRetroalimentaciones = $("#table-retroalimentaciones").DataTable({
                    pagingType: 'full_numbers',
                    dom: 'frtp',
                    search: {
                        return: true,
                    },
                    scrollX: false,
                    language: {
                        search: "_INPUT_",
                        searchPlaceholder: "Buscar alguna retroalimentación...",
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
                        { data: "idRetroalimentacion", title: "IdRetroalimentacion"},
                        { data: "nombre", title: "Retroalimentación"},
                        { data: "retroalimentacion", title: "Descripción"},
                        { data: "fechaRegistro", title: "Fecha de registro"},
                        { data: "", title: "Detalle" },
                    ],
                    columnDefs:[
                        {className: "text-center fuenteNormal segundo-color-letra", defaultContent: "-", targets: "_all"},
                        {className: "span-detalle", target: 4},
                        {className: "fechaRegistro", target: 3},
                    ],
                    data: filas,
                    createdRow: (row, data) => {
                        $('.segundo-color-letra',row).css('color', SegundoColorLetra);
                        $('.span-detalle', row).html('<span class="fuenteNormal span-detalle text-center text-decoration-underline" onclick="DetalleRetroalimentacion('.concat(data.idRetroalimentacion,')">Ver detalle</span>'));
                        let fechaRegistro = data.fechaRegistro.substring(0, data.fechaRegistro.length -1 );
                        $('.fechaRegistro', row).text(dayjs(fechaRegistro).format('dddd DD MMM YYYY h:mm A'));
                    }
                });

                dataTableTareaRetroalimentaciones.column(0).visible(false);
                
            }
            break;
            case 500:{
                dataTableTareaRetroalimentaciones.clear().draw();
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
                dataTableTareaRetroalimentaciones.clear().draw();
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
        dataTableTareaRetroalimentaciones.clear().draw();
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

async function ObtenerArchivosEntregados(){
    try{

        ShowPreloader();

        let response = await axios({
            url: '/tareas/archivosentregados',
            baseURL: BaseURL,
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': document.head.querySelector("[name~=csrf-token][content]").content
            },
            data: {
                "IdTarea": IdTarea,
                "IdUsuario": IdUsuario
            }
        });

        HidePreloader();

        let result = response.data;

        switch (result.code) {
            case 200:{
                let filas = result.data;

                dataTableTareaArchivosEntregadosEstudiante = $("#table-archivos-entregados-estudiante").DataTable({
                    pagingType: 'full_numbers',
                    dom: 'frtp',
                    search: {
                        return: true,
                    },
                    scrollX: false,
                    language: {
                        search: "_INPUT_",
                        searchPlaceholder: "Buscar algún archivo adjunto...",
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
                        { data: "idArchivoEntregado", title: "IdArchivoEntregado"},
                        { data: "nombre", title: "Nombre del archivo"},
                        { data: "archivo", title: "Archivo"},
                        { data: "fechaRegistro", title: "Fecha de registro"},
                        { data: "", title: "Descargar 📥" },
                        { data: "", title: "Remover ❌" },
                    ],
                    columnDefs:[
                        {className: "text-center fuenteNormal segundo-color-letra", defaultContent: "-", targets: "_all"},
                        {className: "span-detalle", target: 4},
                        {className: "span-remover", target: 5},
                        {className: "fechaRegistro", target: 3},
                    ],
                    data: filas,
                    createdRow: (row, data) => {
                        $('.segundo-color-letra',row).css('color', SegundoColorLetra);
                        if(EstatusTarea != "Calificada"){
                            $('.span-remover', row).html('<span class="fuenteNormal span-detalle text-center text-decoration-underline" onclick="RemoverArchivoEntregado('.concat(data.idArchivoEntregado,')">¿Remover archivo?</span>'));
                        }
                        else{
                            $('.span-remover', row).html('<span class="fuenteNormal span-detalle text-center text-decoration-underline">⛔ No Permisible</span>');
                        }

                        $('.span-detalle', row).html('<a class="fuenteNormal span-detalle text-center text-decoration-underline" href="'.concat(assetsRouteTareas,'/',data.archivo,'">Descargar archivo</a>'));
                        let fechaRegistro = data.fechaRegistro.substring(0, data.fechaRegistro.length -1 );
                        $('.fechaRegistro', row).text(dayjs(fechaRegistro).format('dddd DD MMM YYYY h:mm A'));
                    }
                });
                
                dataTableTareaArchivosEntregadosEstudiante.column(0).visible(false);
                dataTableTareaArchivosEntregadosEstudiante.column(2).visible(false);
                
            }
            break;
            case 500:{
                dataTableTareaArchivosEntregadosEstudiante.clear().draw();
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
                dataTableTareaArchivosEntregadosEstudiante.clear().draw();
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
        dataTableTareaArchivosEntregadosEstudiante.clear().draw();
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

async function EnviarArchivoEntregado(filename, base64, file) {

    try {

        ShowPreloader();
        let formData = new FormData();
        formData.append("IdTarea", IdTarea);
        formData.append("NombreArchivo", filename);
        formData.append("Base64Archivo", base64);
        formData.append("Archivo", file);

        let response = await axios({
            url: '/tareas/archivoentregado',
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
                    title: 'Entregar archivo',
                    text: resultado.data.mensaje,
                    imageUrl: BaseURL.concat("/assets/templates/HappyOwl.png"),
                    imageWidth: 100,
                    imageHeight: 123,
                    imageAlt: 'Ok Image',
                    background: '#000000',
                    color: '#FFFFFF'
                }).then(() => {
                    ObtenerArchivosEntregados();
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

document.RemoverArchivoEntregado = async function(IdArchivoEntregado){
    try {

        ShowPreloader();
        
        let formData = new FormData();
        formData.append("IdArchivoEntregado", IdArchivoEntregado);
        formData.append("IdTarea", IdTarea);
        formData.append("IdUsuario", IdUsuario);

        let response = await axios({
            url: '/tareas/archivoentregadoremover',
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
                    title: 'Remover archivo entregado',
                    text: resultado.data,
                    imageUrl: BaseURL.concat("/assets/templates/HappyOwl.png"),
                    imageWidth: 100,
                    imageHeight: 123,
                    imageAlt: 'Ok Image',
                    background: '#000000',
                    color: '#FFFFFF'
                }).then(() => {
                    ObtenerArchivosEntregados();
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

document.DetalleRetroalimentacion = async function(IdRetroalimentacion){
    try {

        ShowPreloader();
        let formData = new FormData();
        formData.append("IdRetroalimentacion", IdRetroalimentacion);

        let response = await axios({
            url: '/tareas/retroalimentaciondetalle',
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
               let retroalimentacion = resultado.data;

               //Llenar info de detalle retroalimentacion modal:

               document.getElementById("nombre-detalle-retroalimentacion").value = retroalimentacion.nombre;
               document.getElementById("descripcion-detalle-retroalimentacion").value = retroalimentacion.retroalimentacion;
               document.getElementById("archivo-detalle-retroalimentacion").value = retroalimentacion.nombreArchivo;
               document.getElementById("descargar-archivo-detalle-retroalimentacion").href =  assetsRouteTareas.concat("/",retroalimentacion.archivo);
               document.getElementById("fecha-registro-detalle-retroalimentacion").value = retroalimentacion.fechaRegistro;

               $("#detalle-retroalimentacion-modal").show();

            }
            break;
            case 500: {

                document.getElementById("nombre-detalle-retroalimentacion").value = "";
                document.getElementById("descripcion-detalle-retroalimentacion").value = "";
                document.getElementById("archivo-detalle-retroalimentacion").value = "";
                document.getElementById("descargar-archivo-detalle-retroalimentacion").href =  "";
                document.getElementById("fecha-registro-detalle-retroalimentacion").value = "";

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

                document.getElementById("nombre-detalle-retroalimentacion").value = "";
                document.getElementById("descripcion-detalle-retroalimentacion").value = "";
                document.getElementById("archivo-detalle-retroalimentacion").value = "";
                document.getElementById("descargar-archivo-detalle-retroalimentacion").href =  "";
                document.getElementById("fecha-registro-detalle-retroalimentacion").value = "";

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

        document.getElementById("nombre-detalle-retroalimentacion").value = "";
        document.getElementById("descripcion-detalle-retroalimentacion").value = "";
        document.getElementById("archivo-detalle-retroalimentacion").value = "";
        document.getElementById("descargar-archivo-detalle-retroalimentacion").href =  "";
        document.getElementById("fecha-registro-detalle-retroalimentacion").value = "";

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

$("#subir-archivo-entregado").on('click', async () => {
    try {

        const { value: file } = await Swal.fire({
            title: 'Subir archivo para entrega',
            text: "Selecciona un archivo para entregar",
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

                    EnviarArchivoEntregado(filename, base64, file);
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

$("#entregar-tarea").on('click', async () => {
    try {

        Swal.fire({
            title: 'Entregar tarea',
            text: '¿Está segur@ de entregar los archivos para calificación? (Esta acción no puede cambiarse)',
            imageUrl: BaseURL.concat("/assets/templates/SadOwl.png"),
            imageWidth: 100,
            imageHeight: 123,
            background: '#000000',
            color: '#FFFFFF',
            imageAlt: 'Alert Image',
            showCloseButton: true,
            showDenyButton: true,
            showCancelButton: false,
            confirmButtonText: 'Sí 😎',
            denyButtonText: 'Por el momento no 😓 '
        }).then(async (result) => {
            if(result.isConfirmed){

                ShowPreloader();
        
                let formData = new FormData();
                formData.append("IdTarea", IdTarea);
                formData.append("IdUsuario", IdUsuario);

                let response = await axios({
                    url: '/tareas/entregar',
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
                            title: 'Entregar tarea',
                            text: resultado.data,
                            imageUrl: BaseURL.concat("/assets/templates/HappyOwl.png"),
                            imageWidth: 100,
                            imageHeight: 123,
                            imageAlt: 'Ok Image',
                            background: '#000000',
                            color: '#FFFFFF'
                        }).then(() => {
                            window.location.href = "/mis-tareas";
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
        });

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