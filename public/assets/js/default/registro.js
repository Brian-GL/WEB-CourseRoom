'use strict';

let BaseURL = window.location.origin;

//#region Methods

async function Registrar(imagenBytes, file){

    try{

        ShowPreloader();

        let contrasena = document.getElementById("contrasena").value;
        let repetir_contrasena = document.getElementById("repetir-contrasena").value;

        if(contrasena !== repetir_contrasena){
            HidePreloader();
            Swal.fire({
                title: '¡Alerta!',
                text: "Las contraseñas no coinciden",
                imageUrl: BaseURL.concat("/assets/templates/IndiferentOwl.png"),
                imageWidth: 100,
                imageHeight: 123,
                imageAlt: 'Alert Image',
                background: '#000000',
                color: '#FFFFFF'
            });

            return;
        }

        let tipoUsuario = document.getElementById("tipo-usuario");
        let dataListUsuario = document.getElementById(tipoUsuario.getAttribute("list"));
        let optionUsuario = dataListUsuario.querySelector(`[value="${tipoUsuario.value}"]`);

        let localidad = document.getElementById("localidad");
        let dataListlocalidad = document.getElementById(localidad.getAttribute("list"));
        let optionlocalidad = dataListlocalidad.querySelector(`[value="${localidad.value}"]`);

        let formData = new FormData();

        formData.append("Nombre", document.getElementById("nombre").value);
        formData.append("Paterno", document.getElementById("paterno").value);
        formData.append("Materno", document.getElementById("materno").value);
        formData.append("Genero", document.getElementById("genero").value);
        formData.append("FechaNacimiento", dayjs(document.getElementById("fecha-nacimiento").value));
        formData.append("IdLocalidad", parseInt(optionlocalidad.text ?? '0'));
        formData.append("CorreoElectronico", document.getElementById("correo-electronico").value);
        formData.append("IdTipoUsuario", parseInt(optionUsuario.text ?? '0'));
        formData.append("Contrasena", Base64.encode(contrasena));
        formData.append("Descripcion", document.getElementById("descripcion").value);
        formData.append("Imagen", file);
        formData.append("ImagenBytes", imagenBytes);
        formData.append('Dispositivo', platform.os.family);
        formData.append('Fabricante', platform.manufacturer);
        formData.append('Navegador', platform.name);

        let response = await axios({
            url: '/default/registrar',
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
                    title: 'Registro de nueva cuenta',
                    text: result.data,
                    imageUrl: BaseURL.concat("/assets/templates/HappyOwl.png"),
                    imageWidth: 100,
                    imageHeight: 123,
                    imageAlt: 'Alert Image',
                    background: '#000000',
                    color: '#FFFFFF'
                }).then((result) => {
                    if (result.isConfirmed) {
                        window.location.href = "/inicio";
                    }
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
            Registrar(bytes, files[0]);
        }).catch((ex) => {

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
        });
    } else{
        Registrar(null, null);
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
            document.getElementById("imagen-seleccionada").src = "https://storage.needpix.com/thumbs/blank-profile-picture-973460_1280.png";
        }
        HidePreloader();
    } catch(ex){

        document.getElementById("imagen-seleccionada").src = "https://storage.needpix.com/thumbs/blank-profile-picture-973460_1280.png";

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
