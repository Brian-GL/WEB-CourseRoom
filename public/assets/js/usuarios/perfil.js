'use strict';

let BaseURL = window.location.origin;

//#region Methods

async function Actualizar(imagen){

    try{

        ShowPreloader();

        let contrasena = document.getElementById("contrasena").value;
        let repetir_contrasena = document.getElementById("repetir-contrasena").value;

        if(contrasena !== repetir_contrasena){
            preloader.hidden = true;
            Swal.fire({
                title: '¡Alerta!',
                text: "Las contraseñas no coinciden",
                imageUrl: baseURL.concat("/assets/templates/IndiferentOwl.png"),
                imageWidth: 100,
                imageHeight: 123,
                imageAlt: 'Alert Image'
            });

            return;
        }

        let response = await axios({
            url: '/usuarios/actualizar',
            baseURL: BaseURL,
            method: 'PUT',
            headers: {
                'X-CSRF-TOKEN': document.head.querySelector("[name~=csrf-token][content]").content
            },
            data: {
                "IdUsuario": 0,
                "Nombre": AvailableString(document.getElementById("nombre").value),
                "Paterno": AvailableString(document.getElementById("paterno").value),
                "Materno": AvailableString(document.getElementById("materno").value),
                "Genero": AvailableString(document.getElementById("genero").value),
                "FechaNacimiento": AvailableString(document.getElementById("fecha-nacimiento").value),
                "IdLocalidad": parseInt(document.getElementById("localidad").text ?? '0'),
                "Descripcion": AvailableString(document.getElementById("descripcion").value)
            }
        });

        let result = response.data;

        switch (result.code) {
            case 200:{

                response = await axios({
                    url: '/usuarios/actualizar_cuenta',
                    baseURL: BaseURL,
                    method: 'PUT',
                    headers: {
                        'X-CSRF-TOKEN': document.head.querySelector("[name~=csrf-token][content]").content
                    },
                    data: {
                        "IdUsuario": 0,
                        "CorreoElectronico": AvailableString(document.getElementById("correo-electronico").value),
                        "Contrasena": Base64.encode(contrasena),
                        "Imagen": imagen,
                        "ChatsConmigo": document.getElementById("chats-conmigo").checked,
                        "AvisosActivo": document.getElementById("avisos-activo").checked
                    }
                });

                result = response.data;

                switch (result.code) {
                    case 200:{
                        Swal.fire({
                            title: 'Actualización de datos de la cuenta',
                            text: result.data,
                            imageUrl: BaseURL.concat("/assets/templates/HappyOwl.png"),
                            imageWidth: 100,
                            imageHeight: 123,
                            imageAlt: 'Alert Image',
                            background: '#000000',
                            color: '#FFFFFF'
                        });
                    }
                    break;
                    case 500:{
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
            break;
            case 500:{
                HidePreloader();
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
                HidePreloader();
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

document.getElementById("form-actualizacion").addEventListener("submit", (e) => {

    e.preventDefault();

    let imagen_input = document.getElementById("imagen");

    if(imagen_input.files.length > 0){

        preloader.hidden = false;

        let files = imagen_input.files;

        // Pass the file to the blob, not the input[0].
        let fileData = new Blob([files[0]]);

        // Pass getBuffer to promise.
        let promise = new Promise(getBuffer(fileData));

        // Wait for promise to be resolved, or log error.
        promise.then((bytes) => {

            preloader.hidden = true;
            Actualizar(bytes);
        }).catch((ex) => {

            preloader.hidden = true;

            Swal.fire({
                title: '¡Error!',
                html: ex,
                imageUrl: baseURL.concat("/assets/templates/SadOwl.png"),
                imageWidth: 100,
                imageHeight: 123,
                background: '#000000',
                color: '#FFFFFF',
                imageAlt: 'Error Image'
            });
        });
    } else{
        Actualizar(null);
    }

});

document.getElementById("imagen").addEventListener("change", (e) => {

    preloader.hidden = false;

    try{
        if(e.target.files.length > 0){
            let selectedFile = e.target.files[0];

            let reader = new FileReader();

            let imagen = document.getElementById("imagen-seleccionada");
            imagen.title = selectedFile.name;

            reader.addEventListener("load", (e) => {
                imagen.src = e.target.result;
            });

            reader.readAsDataURL(selectedFile);

        }else{
            document.getElementById("imagen-seleccionada").src = "https://mdbootstrap.com/img/Photos/Others/placeholder-avatar.jpg";
        }
        preloader.hidden = true;
    } catch(ex){
        document.getElementById("imagen-seleccionada").src = "https://mdbootstrap.com/img/Photos/Others/placeholder-avatar.jpg";

        preloader.hidden = true;

        Swal.fire({
            title: '¡Error!',
            html: ex,
            imageUrl: baseURL.concat("/assets/templates/SadOwl.png"),
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

function GetBuffer(fileData) {
    return function(resolve) {
      let reader = new FileReader();
      reader.readAsArrayBuffer(fileData);
      reader.addEventListener("load", function() {
        let arrayBuffer = reader.result
        let bytes = new Uint8Array(arrayBuffer);
        resolve(bytes);
      });
  }
}

//#endregion


