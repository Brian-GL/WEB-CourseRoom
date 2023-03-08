'use strict';

let SegundoColor = localStorage.getItem("SegundoColor");
let SegundoColorLetra = localStorage.getItem("SegundoColorLetra");
let TercerColor = localStorage.getItem("TercerColor");
let TercerColorLetra = localStorage.getItem("TercerColorLetra");
let PrimerColor = localStorage.getItem("PrimerColor");
let PrimerColorLetra = localStorage.getItem("PrimerColorLetra");
let BaseURL = window.location.origin;

let assetsRouteGrupos = document.getElementById("assets-grupos").value;
let assetsRouteUsuarios = document.getElementById("assets-usuarios").value;
let IdGrupo = document.getElementById("id-grupo").value;

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

//Archivos compartidos:

let dataTableGrupoArchivosCompartidos;
dataTableGrupoArchivosCompartidos = $("#table-archivos-compartidos").DataTable({
    pagingType: 'full_numbers',
    dom: 'frtp',
    search: {
        return: true,
    },
    scrollX: false,
    language: {
        search: "_INPUT_",
        searchPlaceholder: "Buscar algún archivo compartido...",
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
        { title: "IdArchivoCompartido"},
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

dataTableGrupoArchivosCompartidos.column(0).visible(false);
dataTableGrupoArchivosCompartidos.column(2).visible(false);
dataTableGrupoArchivosCompartidos.column(3).visible(false);

//Miembros:

let dataTableGrupoMiembros;
dataTableGrupoMiembros = $("#table-miembros").DataTable({
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
        { title: "Miembro"},
        { title: "Imagen"},
        { title: "Fecha de incorporación"},
        { title: "FechaActualizacion"}
    ],
    columnDefs:[
        {className: "text-center fuenteNormal segundo-color-letra", defaultContent: "-", targets: "_all"},
    ],
    rowCallback: (row) => {
        $(row).css('color', SegundoColorLetra);
    }
});

dataTableGrupoMiembros.column(0).visible(false);
dataTableGrupoMiembros.column(2).visible(false);
dataTableGrupoMiembros.column(4).visible(false);

//Tareas pendientes:

let dataTableGrupoTareasPendientes;
dataTableGrupoTareasPendientes = $("#table-tareas-pendientes").DataTable({
    pagingType: 'full_numbers',
    dom: 'rtp',
    language: {
        search: "_INPUT_",
        searchPlaceholder: "Buscar alguna tarea pendiente...",
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
        {title: "IdTareaPendiente"},
        {title: "Nombre"},
        {title: "IdUsuarioCreador"},
        {title: "Creada por"},
        {title: "ImagenUsuarioCreador"},
        {title: "IdUsuarioResponsable"},
        {title: "Responsable"},
        {title: "ImagenUsuarioResponsable"},
        {title: "Fecha de registro"},
        {title: "Fecha de finalización"},
        {title: "Estatus"},
        {title: "Detalle" }
    ],
    columnDefs:[
        {className: "text-center fuenteNormal segundo-color-letra", targets: "_all"},
        {className: "span-detalle", target: 11},
    ],
    rowCallback: function(row, data, index){
        $(row).css('color', SegundoColorLetra);
    }
});

dataTableGrupoTareasPendientes.column(0).visible(false);
dataTableGrupoTareasPendientes.column(2).visible(false);
dataTableGrupoTareasPendientes.column(4).visible(false);
dataTableGrupoTareasPendientes.column(5).visible(false);
dataTableGrupoTareasPendientes.column(7).visible(false);

//#region Methods

document.addEventListener('DOMContentLoaded',  ObtenerInformacionInicial, false);

async function ObtenerInformacionInicial(){
    ObtenerArchivosCompartidos();
    ObtenerMiembros();
    ObtenerTareasPendientes();
}

async function ObtenerArchivosCompartidos(){
    try{

        ShowPreloader();

        let response = await axios({
            url: '/grupos/archivoscompartidos',
            baseURL: BaseURL,
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': document.head.querySelector("[name~=csrf-token][content]").content
            },
            data: {
                "IdGrupo": IdGrupo
            }
        });

        HidePreloader();

        let result = response.data;

        switch (result.code) {
            case 200:{
                let filas = result.data;

                dataTableGrupoArchivosCompartidos.destroy();

                dataTableGrupoArchivosCompartidos = $("#table-archivos-compartidos").DataTable({
                    pagingType: 'full_numbers',
                    dom: 'frtp',
                    search: {
                        return: true,
                    },
                    scrollX: false,
                    language: {
                        search: "_INPUT_",
                        searchPlaceholder: "Buscar algún archivo compartido...",
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
                        { data: "idArchivoCompartido", title: "IdArchivoCompartido"},
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
                        $('.span-detalle', row).html('<a class="fuenteNormal span-detalle text-center text-decoration-underline" href="'.concat(assetsRouteGrupos,'/',data.archivo,'">Descargar archivo</a>'));
                        let fechaRegistro = data.fechaRegistro.substring(0, data.fechaRegistro.length -1 );
                        $('.fechaRegistro', row).text(dayjs(fechaRegistro).format('dddd DD MMM YYYY h:mm A'));
                    }
                });
                
                dataTableGrupoArchivosCompartidos.column(0).visible(false);
                dataTableGrupoArchivosCompartidos.column(2).visible(false);
                dataTableGrupoArchivosCompartidos.column(3).visible(false);
            }
            break;
            case 500:{
                dataTableGrupoArchivosCompartidos.clear().draw();
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
                dataTableGrupoArchivosCompartidos.clear().draw();
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
        dataTableGrupoArchivosCompartidos.clear().draw();
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
            url: '/grupos/miembros',
            baseURL: BaseURL,
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': document.head.querySelector("[name~=csrf-token][content]").content
            },
            data: {
                "IdGrupo": IdGrupo
            }
        });

        HidePreloader();

        let result = response.data;

        switch (result.code) {
            case 200:{
                let filas = result.data;

                dataTableGrupoArchivosCompartidos.destroy();

                dataTableGrupoMiembros = $("#table-miembros").DataTable({
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
                        { data: "nombreCompleto", title: "Miembro"},
                        { data: "imagen", title: "Imagen"},
                        { data: "fechaRegistro", title: "Fecha de incorporación"},
                        { data: "fechaActualizacion", title: "FechaActualizacion"}
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
                        $("#miembro-a-cargo-tarea-pendiente").append($('<option>', {
                            value: data.idUsuario,
                            text: data.nombreCompleto
                        }));
                    }
                });
                
                dataTableGrupoMiembros.column(0).visible(false);
                dataTableGrupoMiembros.column(2).visible(false);
                dataTableGrupoMiembros.column(4).visible(false);
            }
            break;
            case 500:{
                dataTableGrupoArchivosCompartidos.clear().draw();
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
                dataTableGrupoArchivosCompartidos.clear().draw();
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
        dataTableGrupoArchivosCompartidos.clear().draw();
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

async function ObtenerTareasPendientes(){
    try{

        ShowPreloader();

        let response = await axios({
            url: '/grupos/tareaspendientes',
            baseURL: BaseURL,
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': document.head.querySelector("[name~=csrf-token][content]").content
            },
            data: {
                "IdGrupo": IdGrupo
            }
        });

        HidePreloader();

        let result = response.data;

        switch (result.code) {
            case 200:{
                let filas = result.data;

                dataTableGrupoTareasPendientes.destroy();

                dataTableGrupoTareasPendientes = $("#table-tareas-pendientes").DataTable({
                    pagingType: 'full_numbers',
                    dom: 'rtp',
                    language: {
                        search: "_INPUT_",
                        searchPlaceholder: "Buscar alguna tarea pendiente...",
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
                        {data: "idTareaPendiente", title: "IdTareaPendiente"},
                        {data: "nombre", title: "Nombre"},
                        {data: "idUsuarioCreador", title: "IdUsuarioCreador"},
                        {data: "nombreUsuarioCreador", title: "Creada por"},
                        {data: "imagenUsuarioCreador", title: "ImagenUsuarioCreador"},
                        {data: "idUsuarioResponsable", title: "IdUsuarioResponsable"},
                        {data: "nombreUsuarioResponsable", title: "Responsable"},
                        {data: "imagenUsuarioResponsable", title: "ImagenUsuarioResponsable"},
                        {data: "fechaRegistro", title: "Fecha de registro"},
                        {data: "fechaFinalizacion", title: "Fecha de finalización"},
                        {data: "estatus", title: "Estatus"},
                        {data: "",title: "Detalle" }
                    ],
                    columnDefs:[
                        {className: "text-center fuenteNormal segundo-color-letra", defaultContent: "-", targets: "_all"},
                        {className: "span-detalle", target: 11},
                        {className: "fechaRegistro", target: 8},
                        {className: "fechaFinalizacion", target: 9},
                        {className: "info-usuario-emisor", target: 3},
                        {className: "info-usuario-receptor", target: 6},
                    ],
                    data: filas,
                    createdRow: (row, data) => {
                        $('.segundo-color-letra',row).css('color', SegundoColorLetra);
                        $('.span-detalle', row).html('<span class="fuenteNormal span-detalle text-center text-decoration-underline" onclick="DetalleTareaPendiente('.concat(data.idTareaPendiente,')">Ver detalle</span>'));
                        let fechaRegistro = data.fechaRegistro.substring(0, data.fechaRegistro.length -1 );
                        $('.fechaRegistro', row).text(dayjs(fechaRegistro).format('dddd DD MMM YYYY h:mm A'));
                
                        let fechaFinalizacion = dayjs(data.fechaFinalizacion?.substring(0,data.fechaFinalizacion?.length-1));
                        if(fechaFinalizacion.isValid()){
                            $('.fechaFinalizacion', row).text(fechaFinalizacion.format('LLLL'));
                        }
                
                        $('.info-usuario-emisor', row).html('<div class="container"><div class="row"><div class="col-5"><img class="img-fluid" alt="Imagen del usuario" src="'.concat(assetsRouteUsuarios,'/',data.imagenUsuarioCreador,'"/></div><div class="col-7 p-0"><p class="fuenteNormal">',data.nombreUsuarioCreador,'</p></div></div></div>'));
                        $('.info-usuario-receptor', row).html('<div class="container"><div class="row"><div class="col-5"><img class="img-fluid" alt="Imagen del usuario" src="'.concat(assetsRouteUsuarios,'/',data.imagenUsuarioResponsable,'"/></div><div class="col-7 p-0"><p class="fuenteNormal">',data.nombreUsuarioResponsable,'</p></div></div></div>'));
                    }
                });
                
                dataTableGrupoTareasPendientes.column(0).visible(false);
                dataTableGrupoTareasPendientes.column(2).visible(false);
                dataTableGrupoTareasPendientes.column(4).visible(false);
                dataTableGrupoTareasPendientes.column(5).visible(false);
                dataTableGrupoTareasPendientes.column(7).visible(false);
            }
            break;
            case 500:{
                dataTableGrupoTareasPendientes.clear().draw();
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
                dataTableGrupoTareasPendientes.clear().draw();
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
        dataTableGrupoTareasPendientes.clear().draw();
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

document.ActualizarGrupo = async function (){

    try{

        ShowPreloader();

        let formData = new FormData();

        formData.append("IdGrupo", IdGrupo);
        formData.append("Nombre", document.getElementById("nombre-value").innerText);
        formData.append("Descripcion", document.getElementById("descripcion-value").innerText);

        let imagen_file = document.getElementById("imagen");
        let imagen_element = document.getElementById("imagen-grupo");
        let base64 = await GetBase64FromUrl(imagen_element.src);
        let imagen = null;
        
        if(imagen_file.files.length > 0){
            imagen = imagen_file.files[0];
        }

        formData.append("ImagenAnterior", document.getElementById("imagen-anterior").value);
        formData.append("Imagen", imagen);
        formData.append("Base64Image", base64);

        let response = await axios({
            url: '/grupos/actualizar',
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
                    title: 'Actualización de grupo',
                    text: resultado.data,
                    imageUrl: BaseURL.concat("/assets/templates/HappyOwl.png"),
                    imageWidth: 100,
                    imageHeight: 123,
                    imageAlt: 'Ok Image',
                    background: '#000000',
                    color: '#FFFFFF'
                }).then(() => {
                    window.location.href = "/mis-grupos";
                });
            }
            break;
            case 500:{
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
            default:{
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
        formData.append("IdGrupo", IdGrupo);
        formData.append("Mensaje", mensaje);
        formData.append("Base64Archivo", base64Archivo);
        formData.append("Archivo", archivo);

        let response = await axios({
            url: '/grupos/mensajeregistrar',
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
            `<div class="col-md-12 d-flex justify-content-start"><div class="d-flex justify-content-start mb-4"><img src="${assetsUsuariosRoute}${imagenEmisor}" alt="avatar" class="rounded-circle d-flex align-self-start ms-3 shadow-1-strong" width="60"><div class="card mask-custom"><div class="card-header d-flex justify-content-between p-3"style="border-bottom: 1px solid rgba(255,255,255,.3);"><div class="row"><div class="col-md-6 text-center text-wrap"><p class="fw-bold mb-0">${nombreUsuarioEmisor}</p></div><div class="col-md-6 text-center text-wrap"><p class="text-light small mb-0"><i class="far fa-clock"></i> ${fechaRegistro}</p></div></div></div><div class="card-body"><a href="${assetsRouteGrupos}${nombreArchivo}" target="_blank"><i class="fa-solid fa-file-lines"></i>&nbsp;${mensaje}'</a></div></div></div></div>`;
    }

    $("#mensajes").append(elemento);

}

async function EnviarArchivoCompartido(filename, base64, file) {

    try {

        ShowPreloader();
        let formData = new FormData();
        formData.append("IdGrupo", IdGrupo);
        formData.append("NombreArchivo", filename);
        formData.append("Base64Archivo", base64);
        formData.append("Archivo", file);

        let response = await axios({
            url: '/grupos/archivocompartidoregistrar',
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
                    title: 'Compartir archivo',
                    text: resultado.data.mensaje,
                    imageUrl: BaseURL.concat("/assets/templates/HappyOwl.png"),
                    imageWidth: 100,
                    imageHeight: 123,
                    imageAlt: 'Ok Image',
                    background: '#000000',
                    color: '#FFFFFF'
                }).then(() => {
                    ObtenerArchivosCompartidos();
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

document.DetalleTareaPendiente = async function(IdTareaPendiente){

    try{

        ShowPreloader();

        let formData = new FormData();

        formData.append("IdTareaPendiente", IdTareaPendiente);

        let response = await axios({
            url: '/grupos/tareapendientedetalle',
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
                let tarea_pendiente = resultado.data;

                //Obtener estatus tareas pendientes:

                response = await axios({
                    url: '/catalogos/estatustareapendiente',
                    baseURL: BaseURL,
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': document.head.querySelector("[name~=csrf-token][content]").content
                    },
                    data: null
                });

                resultado = response.data;

                if(resultado.code == 200){
                    let catalogoestatus = resultado.data;

                    for(let estatus of catalogoestatus){
                        $("#estatus-detalle-tarea-pendiente").append($('<option>', {
                            value: estatus.idEstatus,
                            text: estatus.estatus
                        }));
                    }
                }

                //Llenar info de detalle tarea pendiente modal:

                document.getElementById("id-tarea-pendiente").value = IdTareaPendiente;

                document.getElementById("nombre-detalle-tarea-pendiente").value = tarea_pendiente.nombre;
                document.getElementById("descripcion-detalle-tarea-pendiente").value = tarea_pendiente.descripcion;
                document.getElementById("fecha-finalizacion-detalle-tarea-pendiente").value = tarea_pendiente.fechaFinalizacion;
                document.getElementById("miembro-creador-detalle-tarea-pendiente").value = tarea_pendiente.nombreUsuarioCreador;
                document.getElementById("miembro-a-cargo-detalle-tarea-pendiente").value = tarea_pendiente.nombreUsuarioResponsable;
                document.getElementById("fecha-registro-detalle-tarea-pendiente").value = tarea_pendiente.fechaRegistro;

                $("#estatus-detalle-tarea-pendiente option:contains('".concat(tarea_pendiente.estatus,"')")).prop("selected", true);

                $("#detalle-tarea-pendiente-modal").show();

            }
            break;
            case 500:{
                document.getElementById("id-tarea-pendiente").value = "";
                document.getElementById("nombre-detalle-tarea-pendiente").value = "";
                document.getElementById("descripcion-detalle-tarea-pendiente").value = "";
                document.getElementById("fecha-finalizacion-detalle-tarea-pendiente").value = "";
                document.getElementById("miembro-creador-detalle-tarea-pendiente").value = "";
                document.getElementById("miembro-a-cargo-detalle-tarea-pendiente").value = "";
                document.getElementById("fecha-registro-detalle-tarea-pendiente").value = "";

                $("#estatus-detalle-tarea-pendiente").empty();

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
            default:{
                document.getElementById("id-tarea-pendiente").value = "";
                document.getElementById("nombre-detalle-tarea-pendiente").value = "";
                document.getElementById("descripcion-detalle-tarea-pendiente").value = "";
                document.getElementById("fecha-finalizacion-detalle-tarea-pendiente").value = "";
                document.getElementById("miembro-creador-detalle-tarea-pendiente").value = "";
                document.getElementById("miembro-a-cargo-detalle-tarea-pendiente").value = "";
                document.getElementById("fecha-registro-detalle-tarea-pendiente").value = "";

                $("#estatus-detalle-tarea-pendiente").empty();

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
    catch(ex){

        HidePreloader();
        document.getElementById("id-tarea-pendiente").value = "";
        document.getElementById("nombre-detalle-tarea-pendiente").value = "";
        document.getElementById("descripcion-detalle-tarea-pendiente").value = "";
        document.getElementById("fecha-finalizacion-detalle-tarea-pendiente").value = "";
        document.getElementById("miembro-creador-detalle-tarea-pendiente").value = "";
        document.getElementById("miembro-a-cargo-detalle-tarea-pendiente").value = "";
        document.getElementById("fecha-registro-detalle-tarea-pendiente").value = "";

        $("#estatus-detalle-tarea-pendiente").empty();

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


document.getElementById("imagen").addEventListener("change", (e) => {

    ShowPreloader();

    try{
        if(e.target.files.length > 0){
            let selectedFile = e.target.files[0];

            let reader = new FileReader();

            let imagen = document.getElementById("imagen-grupo");
            imagen.title = selectedFile.name;

            reader.addEventListener("load", (e) => {
                imagen.src = e.target.result;
            });

            reader.readAsDataURL(selectedFile);

        }else{
            document.getElementById("imagen-grupo").src = "https://storage.needpix.com/thumbs/blank-profile-picture-973460_1280.png";
        }
        HidePreloader();
    } catch(ex){

        document.getElementById("imagen-grupo").src = "https://storage.needpix.com/thumbs/blank-profile-picture-973460_1280.png";

        HidePreloader();

        Swal.fire({
            title: '¡Error!',
            html: ex,
            imageUrl: BaseURL.concat("/assets/templates/SadOwl.png"),
            imageWidth: 100,
            imageHeight: 123,
            background: '#000000',
            color: '#FFFFFF',
            imageAlt: 'Error Image'
        });

    }
});

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

document.getElementById("subir-archivo-compartido").addEventListener('click', async () => {
    try {

        const { value: file } = await Swal.fire({
            title: 'Subir archivo para compartir',
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

                    EnviarArchivoCompartido(filename, base64, file);
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

document.getElementById("form-agregar-tarea-pendiente").addEventListener("submit", async (e) => {

    e.preventDefault();

    try {

        ShowPreloader();
        let formData = new FormData();
        formData.append("IdGrupo", IdGrupo);
        formData.append("IdUsuarioReceptor", $( "#miembro-a-cargo-tarea-pendiente option:selected" ).val());
        formData.append("Nombre", document.getElementById("nombre-tarea-pendiente").value);
        formData.append("Descripcion", document.getElementById("descripcion-tarea-pendiente").value);
        formData.append("FechaFinalizacion", document.getElementById("fecha-finalizacion-tarea-pendiente").value);

        let response = await axios({
            url: '/grupos/tareapendienteregistrar',
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
                    title: 'Crear tarea pendiente',
                    text: resultado.data.mensaje,
                    imageUrl: BaseURL.concat("/assets/templates/HappyOwl.png"),
                    imageWidth: 100,
                    imageHeight: 123,
                    imageAlt: 'Ok Image',
                    background: '#000000',
                    color: '#FFFFFF'
                }).then(() => {
                    ObtenerTareasPendientes();
                    $("#agregar-tarea-pendiente-modal").hide();
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
   
});

document.getElementById("form-detalle-tarea-pendiente").addEventListener("submit", async () => {
    e.preventDefault();

    try{

        ShowPreloader();

        let formData = new FormData();

        formData.append("IdGrupo", IdGrupo);
        formData.append("IdTareaPendiente", document.getElementById("id-tarea-pendiente").value);
        formData.append("IdEstatusTareaPendiente", $("#estatus-detalle-tarea-pendiente").val());

        let response = await axios({
            url: '/grupos/tareapendienteestatus',
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
                    title: 'Actualización de tarea pendiente',
                    text: resultado.data,
                    imageUrl: BaseURL.concat("/assets/templates/HappyOwl.png"),
                    imageWidth: 100,
                    imageHeight: 123,
                    imageAlt: 'Ok Image',
                    background: '#000000',
                    color: '#FFFFFF'
                }).then(() => {
                    ObtenerTareasPendientes();
                });
            }
            break;
            case 500:{
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
            default:{
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


});

//#endregion