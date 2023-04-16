'use strict';

let SegundoColor = localStorage.getItem("SegundoColor");
let SegundoColorLetra = localStorage.getItem("SegundoColorLetra");
let TercerColor = localStorage.getItem("TercerColor");
let TercerColorLetra = localStorage.getItem("TercerColorLetra");
let PrimerColor = localStorage.getItem("PrimerColor");
let PrimerColorLetra = localStorage.getItem("PrimerColorLetra");
let BaseURL = window.location.origin;
let IdTarea = document.getElementById("id-tarea").value;

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

//#region methods

document.addEventListener('DOMContentLoaded',  ObtenerInformacionInicial, false);

async function ObtenerInformacionInicial(){
    document.ObtenerArchivosAdjuntos();
}

document.ObtenerArchivosAdjuntos = async function (){
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
                        $('.span-detalle', row).html('<a class="fuenteNormal span-detalle text-center text-decoration-underline" href="'.concat(data.archivo,'" download="',data.nombre,'" target="_blank">Descargar archivo</a>'));
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
                    imageUrl: window.SadOwl,
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
                    imageUrl: window.IndifferentOwl,
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
            imageUrl: window.SadOwl,
            imageWidth: 100,
            imageHeight: 123,
            background: '#000000',
            color: '#FFFFFF',
            imageAlt: 'Error Image'
        });
    }
}


async function SubirArchivoAdjunto(filename, base64, file) {

    try {

        ShowPreloader();
        let formData = new FormData();
        formData.append("IdTarea", IdTarea);
        formData.append("NombreArchivo", filename);
        formData.append("Base64Archivo", base64);
        formData.append("Archivo", file);

        let response = await axios({
            url: '/tareas/archivoadjuntoregistrar',
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
                    title: 'Subir archivo adjunto',
                    text: resultado.data.mensaje,
                    imageUrl: window.HappyOwl,
                    imageWidth: 100,
                    imageHeight: 123,
                    imageAlt: 'Ok Image',
                    background: '#000000',
                    color: '#FFFFFF'
                }).then(() => {
                    document.ObtenerArchivosAdjuntos();
                });
            }
            break;
            case 500: {
                Swal.fire({
                    title: '¡Error!',
                    text: resultado.data,
                    imageUrl: window.SadOwl,
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
                    imageUrl: window.IndifferentOwl,
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
            imageUrl: window.SadOwl,
            imageWidth: 100,
            imageHeight: 123,
            background: '#000000',
            color: '#FFFFFF',
            imageAlt: 'Error Image'
        });
    }
}

//#endregion

//#region events

$("#actualizar-tarea").on("click", async () => {
    try {

        ShowPreloader();

        let formData = new FormData();

        formData.append('IdTarea', IdTarea);
        formData.append('Nombre', document.getElementById("nombre-tarea").innerText);
        formData.append('Descripcion', document.getElementById("descripcion-tarea").innerText);

        let response = await axios({
            url: '/tareas/actualizar',
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
                    title: 'Actualizar tarea',
                    text: result.data,
                    imageUrl: window.HappyOwl,
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
                    imageUrl: window.SadOwl,
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
                    imageUrl: window.IndifferentOwl,
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
            imageUrl: window.SadOwl,
            imageWidth: 100,
            imageHeight: 123,
            background: '#000000',
            color: '#FFFFFF',
            imageAlt: 'Error Image'
        });
    }
});


$("#subir-archivo-adjunto").on("click", async () => {
    try {

        const { value: file } = await Swal.fire({
            title: 'Subir archivo adjunto',
            text: "Selecciona un archivo para adjuntar en la tarea",
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

                    SubirArchivoAdjunto(filename, base64, file);
                }
                reader.readAsDataURL(file);
            } else {
                Swal.fire({
                    title: '¡Alerta!',
                    text: 'El archivo supera el tamaño máximo permitido 😐',
                    imageUrl: window.IndifferentOwl,
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
                imageUrl: window.IndifferentOwl,
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
            imageUrl: window.SadOwl,
            imageWidth: 100,
            imageHeight: 123,
            background: '#000000',
            color: '#FFFFFF',
            imageAlt: 'Error Image'
        });
    }
});


//#endregion