'use strict';

let BaseURL = window.location.origin;

//#region Methods

async function Registrar(imagen){

    try{

         ShowPreloader();

         let contrasena = document.getElementById("contrasena").value;
         let repetir_contrasena = document.getElementById("repetir-contrasena").value;

         if(contrasena !== repetir_contrasena){
             HidePreloader();
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
             url: '/default/registrar',
             baseURL: BaseURL,
             method: 'POST',
             headers: {
                 'X-CSRF-TOKEN': document.head.querySelector("[name~=csrf-token][content]").content
             },
             data: {
                 "Nombre": AvailableString(document.getElementById("nombre").value),
                 "Paterno": AvailableString(document.getElementById("paterno").value),
                 "Materno": AvailableString(document.getElementById("materno").value),
                 "Genero": AvailableString(document.getElementById("genero").value),
                 "FechaNacimiento": AvailableString(document.getElementById("fecha-nacimiento").value),
                 "IdLocalidad": parseInt(document.getElementById("localidad").text),
                 "CorreoElectronico": AvailableString(document.getElementById("correo-electronico").value),
                 "IdTipoUsuario": parseInt(document.getElementById("tipo-usuario").text),
                 "Contrasena": Base64.encode(contrasena),
                 "Descripcion": AvailableString(document.getElementById("descripcion").value),
                 "Imagen": imagen
             }
         });

         HidePreloader();

         let result = response.data;

        switch (result.code) {
            case 200:{
                Swal.fire({
                    title: 'Registro de nueva cuenta',
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

document.getElementById("form-registro").addEventListener("submit", async (e) => {

    e.preventDefault();

    let imagen_input = document.getElementById("imagen");

    if(imagen_input.files.length > 0){

        ShowPreloader();

        let files = imagen_input.files;

        // Pass the file to the blob, not the input[0].
        let fileData = new Blob([files[0]]);

        // Pass getBuffer to promise.
        let promise = new Promise(GetBuffer(fileData));

        // Wait for promise to be resolved, or log error.
        promise.then((bytes) => {

            HidePreloader();
            Registrar(bytes);
        }).catch((ex) => {

            HidePreloader();

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
        Registrar(null);
    }

});

document.getElementById("imagen").addEventListener("change", (e) => {

    ShowPreloader();

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
        HidePreloader();
    } catch(ex){

        document.getElementById("imagen-seleccionada").src = "https://mdbootstrap.com/img/Photos/Others/placeholder-avatar.jpg";

        HidePreloader();

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
