'use strict';

let dataTableMisChats, dataTableBuscarUsuarios;
let SegundoColor = localStorage.getItem("SegundoColor");
let SegundoColorLetra = localStorage.getItem("SegundoColorLetra");
let TercerColor = localStorage.getItem("TercerColor");
let TercerColorLetra = localStorage.getItem("TercerColorLetra");
let PrimerColor = localStorage.getItem("PrimerColor");
let PrimerColorLetra = localStorage.getItem("PrimerColorLetra");
let BaseURL = window.location.origin;

let assetsChatsRoute = document.getElementById("assets-chats").value;
let assetsUsuariosRoute = document.getElementById("assets-usuarios").value;
let IdChat = document.getElementById("id-chat").value;
let IdUsuarioEmisor = document.getElementById("id-usuario-emisor").value;

//#region Methods

async function ObtenerMensajes(){
    try{

        let formData;
        while(true){

            formData = new FormData();
            formData.append("IdChat", IdChat);

            let response = await axios({
                url: '/chats/mensajesobtener',
                baseURL: BaseURL,
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': document.head.querySelector("[name~=csrf-token][content]").content
                },
                data: formData
            });

            let result = response.data;
            if(result.code === 200){

                let mensajes = result.data;
                let fechaRegistroFormat;
                for(let mensaje of mensajes){
                    fechaRegistroFormat = dayjs(mensaje.fechaRegistro).format('DD/MM/YYYY h:mm A');
                    
                    if(mensaje.idUsuarioEmisor == IdUsuarioEmisor){
                        GenerarMensajeEmisor(fechaRegistroFormat, mensaje.mensaje, mensaje.archivo, mensaje.nombreUsuarioEmisor, mensaje.imagenEmisor);
                    }else{
                        GenerarMensajeReceptor(fechaRegistroFormat, mensaje.mensaje, mensaje.archivo, mensaje.nombreUsuarioEmisor, mensaje.imagenEmisor);
                    }
                }
            }else if(result.code === 500){
                console.error(result.data);
            }

            await Sleep(2000);
        }
    }
    catch(ex){

        console.error(ex);
    }
}

async function EnviarMensaje(mensaje, archivo, base64Archivo) {

    try {

        let formData = new FormData();
        formData.append("IdChat", IdChat);
        formData.append("Mensaje", mensaje);
        formData.append("Base64Archivo", base64Archivo);
        formData.append("Archivo", archivo);

        let response = await axios({
            url: '/chats/mensajeregistrar',
            baseURL: BaseURL,
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': document.head.querySelector("[name~=csrf-token][content]").content
            },
            data: formData
        });
        let result = response.data;

        switch (result.code) {
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

document.addEventListener('DOMContentLoaded',  function() {setTimeout(ObtenerMensajes, 2000);}, false);

document.getElementById("enviar-mensaje").addEventListener("click", () => {

    let mensaje = document.getElementById("mensaje").value;

    if (mensaje !== null && mensaje !== undefined && mensaje !== '') {
        EnviarMensaje(mensaje, null, null);
        document.getElementById("mensaje").value = "";
    }

});

document.getElementById("mensaje").addEventListener("keypress", (e) => {

    if (e.code === 'Enter') {
        let mensaje = document.getElementById("mensaje").value;

        if (mensaje !== null && mensaje !== undefined && mensaje !== '') {
            EnviarMensaje(mensaje, null, null);
            document.getElementById("mensaje").value = "";
        }
    }

});

document.getElementById("enviar-archivo").addEventListener("click", async () => {

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

//#endregion

//#region Functions

function GenerarMensajeEmisor(fechaRegistro, mensaje, nombreArchivo, nombreUsuarioEmisor, imagenEmisor) {

    let elemento;

    if (nombreArchivo === undefined || nombreArchivo === null || nombreArchivo === '') {
        elemento =
            `<div class="col-md-12 d-flex justify-content-end"><div class="w-50"><div class="d-flex justify-content-end mb-4"><div class="card mask-custom"><div class="card-header d-flex justify-content-between p-3"style="border-bottom: 1px solid rgba(255,255,255,.3);"><div class="row"><div class="col-md-6 text-center text-wrap"><p class="fw-bold mb-0">${nombreUsuarioEmisor}</p></div><div class="col-md-6 text-center text-wrap"><p class="text-light small mb-0"><i class="far fa-clock"></i> ${fechaRegistro}</p></div></div></div><div class="card-body"><p class="mb-0">${mensaje}</p></div></div><img src="${assetsUsuariosRoute}${imagenEmisor}" alt="avatar" class="rounded-circle d-flex align-self-start ms-3 shadow-1-strong" width="60"></div></div></div>`;
    } else {
        elemento =
            `<div class="col-md-12 d-flex justify-content-end"><div class="w-50"><div class="d-flex justify-content-end mb-4"><div class="card mask-custom"><div class="card-header d-flex justify-content-between p-3"style="border-bottom: 1px solid rgba(255,255,255,.3);"><div class="row"><div class="col-md-6 text-center text-wrap"><p class="fw-bold mb-0">${nombreUsuarioEmisor}</p></div><div class="col-md-6 text-center text-wrap"><p class="text-light small mb-0"><i class="far fa-clock"></i> ${fechaRegistro}</p></div></div></div><div class="card-body"><a href="${assetsChatsRoute}${nombreArchivo}" target="_blank"><i class="fa-solid fa-file-lines"></i>&nbsp;${mensaje}'</a></div></div><img src="${assetsUsuariosRoute}${imagenEmisor}" alt="avatar" class="rounded-circle d-flex align-self-start ms-3 shadow-1-strong" width="60"></div></div></div>`;
    }
    
    $("#mensajes").append(elemento);

}

function GenerarMensajeReceptor(fechaRegistro, mensaje, nombreArchivo, nombreUsuarioEmisor, imagenEmisor) {

    let elemento;

    if (nombreArchivo === undefined || nombreArchivo === null || nombreArchivo === '') {
        elemento =
            `<div class="col-md-12 d-flex justify-content-start"><div class="w-50"><div class="d-flex justify-content-start mb-4"><img src="${assetsUsuariosRoute}${imagenEmisor}" alt="avatar" class="rounded-circle d-flex align-self-start ms-3 shadow-1-strong" width="60"><div class="card mask-custom"><div class="card-header d-flex justify-content-between p-3"style="border-bottom: 1px solid rgba(255,255,255,.3);"><div class="row"><div class="col-md-6 text-center text-wrap"><p class="fw-bold mb-0">${nombreUsuarioEmisor}</p></div><div class="col-md-6 text-center text-wrap"><p class="text-light small mb-0"><i class="far fa-clock"></i> ${fechaRegistro}</p></div></div></div><div class="card-body"><p class="mb-0">${mensaje}</p></div></div></div></div></div>`;
    } else {
        elemento =
            `<div class="col-md-12 d-flex justify-content-start"><div class="w-50"><div class="d-flex justify-content-start mb-4"><img src="${assetsUsuariosRoute}${imagenEmisor}" alt="avatar" class="rounded-circle d-flex align-self-start ms-3 shadow-1-strong" width="60"><div class="card mask-custom"><div class="card-header d-flex justify-content-between p-3"style="border-bottom: 1px solid rgba(255,255,255,.3);"><div class="row"><div class="col-md-6 text-center text-wrap"><p class="fw-bold mb-0">${nombreUsuarioEmisor}</p></div><div class="col-md-6 text-center text-wrap"><p class="text-light small mb-0"><i class="far fa-clock"></i> ${fechaRegistro}</p></div></div></div><div class="card-body"><a href="${assetsChatsRoute}${nombreArchivo}" target="_blank"><i class="fa-solid fa-file-lines"></i>&nbsp;${mensaje}'</a></div></div></div></div></div>`;
    }

    $("#mensajes").append(elemento);

}



//#endregion