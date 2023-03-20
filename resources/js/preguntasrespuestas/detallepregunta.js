'use strict';

let dataTableMisChats, dataTableBuscarUsuarios;
let SegundoColor = localStorage.getItem("SegundoColor");
let SegundoColorLetra = localStorage.getItem("SegundoColorLetra");
let TercerColor = localStorage.getItem("TercerColor");
let TercerColorLetra = localStorage.getItem("TercerColorLetra");
let PrimerColor = localStorage.getItem("PrimerColor");
let PrimerColorLetra = localStorage.getItem("PrimerColorLetra");
let BaseURL = window.location.origin;

let IdPregunta = document.getElementById("id-pregunta").value;

//#region Methods


async function EnviarMensaje(mensaje, archivo, base64Archivo) {

    try {

        ShowPreloader();
        let formData = new FormData();
        formData.append("IdPreguntaRespuesta", IdPregunta);
        formData.append("Mensaje", mensaje);
        formData.append("Base64Archivo", base64Archivo);
        formData.append("Archivo", archivo);

        let response = await axios({
            url: '/preguntas/mensajeregistrar',
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
                GenerarRespuesta(fechaRegistroFormat,mensaje, result.nombreArchivo, document.getElementById("nombre-usuario").innerHTML, result.imagenEmisor);
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

//#region Functions

function GenerarRespuesta(fechaRegistro, mensaje, nombreArchivo, nombreUsuarioEmisor, imagenEmisor) {

    let elemento;

    if (nombreArchivo === undefined || nombreArchivo === null || nombreArchivo === '') {
        elemento =
            `<div class="col-md-12 d-flex justify-content-start"><div class="d-flex justify-content-start mb-4"><img src="${imagenEmisor}" alt="avatar" class="rounded-circle d-flex align-self-start ms-3 shadow-1-strong" width="60"><div class="card mask-custom"><div class="card-header d-flex justify-content-between p-3"style="border-bottom: 1px solid rgba(255,255,255,.3);"><div class="row"><div class="col-md-6 text-center text-wrap"><p class="fw-bold mb-0">${nombreUsuarioEmisor}</p></div><div class="col-md-6 text-center text-wrap"><p class="text-light small mb-0"><i class="far fa-clock"></i> ${fechaRegistro}</p></div></div></div><div class="card-body"><p class="mb-0">${mensaje}</p></div></div></div></div>`;
    } else {
        elemento =
            `<div class="col-md-12 d-flex justify-content-start"><div class="d-flex justify-content-start mb-4"><img src="${imagenEmisor}" alt="avatar" class="rounded-circle d-flex align-self-start ms-3 shadow-1-strong" width="60"><div class="card mask-custom"><div class="card-header d-flex justify-content-between p-3"style="border-bottom: 1px solid rgba(255,255,255,.3);"><div class="row"><div class="col-md-6 text-center text-wrap"><p class="fw-bold mb-0">${nombreUsuarioEmisor}</p></div><div class="col-md-6 text-center text-wrap"><p class="text-light small mb-0"><i class="far fa-clock"></i> ${fechaRegistro}</p></div></div></div><div class="card-body"><a href="${nombreArchivo}" target="_blank"><i class="fa-solid fa-file-lines"></i>&nbsp;${mensaje}'</a></div></div></div></div>`;
    }

    $("#mensajes").append(elemento);

}

document.ActualizarPregunta = async function (){

    try{

        ShowPreloader();

        let formData = new FormData();

        formData.append("IdPreguntaRespuesta", IdPregunta);
        formData.append("Pregunta", document.getElementById("pregunta-value").innerText);
        formData.append("Descripcion", document.getElementById("descripcion-value").innerText);

        let response = await axios({
            url: '/preguntas/actualizar',
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
                    title: 'Actualización de pregunta',
                    text: resultado.data,
                    imageUrl: window.HappyOwl,
                    imageWidth: 100,
                    imageHeight: 123,
                    imageAlt: 'Ok Image',
                    background: '#000000',
                    color: '#FFFFFF'
                });
            }
            break;
            case 500:{
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
            default:{
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
    catch(ex){

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

document.SolucionarPregunta = async function (){

    try{

        ShowPreloader();

        let formData = new FormData();

        formData.append("IdPreguntaRespuesta", IdPregunta);
        formData.append("IdEstatusPregunta", 2);

        let response = await axios({
            url: '/preguntas/estatusactualizar',
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
                    title: 'Actualización de pregunta',
                    text: resultado.data,
                    imageUrl: window.HappyOwl,
                    imageWidth: 100,
                    imageHeight: 123,
                    imageAlt: 'Ok Image',
                    background: '#000000',
                    color: '#FFFFFF'
                }).then(() => {
                    window.location.href = "/preguntas-y-respuestas";
                });
                
            }
            break;
            case 500:{
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
            default:{
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
    catch(ex){

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
