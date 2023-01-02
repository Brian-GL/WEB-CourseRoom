'use strict';

document.getElementById("form-registro").addEventListener("submit", (e) => {

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
            Registrar(bytes);
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
        Registrar(null);
    }

});

function Registrar(imagen){

    preloader.hidden = false;

    let nombre = AvailableStringValue(document.getElementById("nombre").value);
    let paterno = AvailableStringValue(document.getElementById("paterno").value);
    let materno = AvailableStringValue(document.getElementById("materno").value);
    let genero = AvailableStringValue(document.getElementById("genero").value);
    let fecha_nacimiento = document.getElementById("fecha-nacimiento").value;
    let localidad = document.getElementById("localidad").text;
    let correo_electronico = AvailableStringValue(document.getElementById("correo-electronico").value);
    let tipo_usuario = document.getElementById("tipo-usuario").text;
    let contrasena = document.getElementById("contrasena").value;
    let repetir_contrasena = document.getElementById("repetir-contrasena").value;
    let descripcion = AvailableStringValue(document.getElementById("descripcion").value);

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

    let baseURL = window.location.origin;

    fetch(baseURL.concat('/default/registrar'), {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.head.querySelector("[name~=csrf-token][content]").content
        },
        body: JSON.stringify({
            "Nombre": nombre,
            "Paterno": paterno,
            "Materno": materno,
            "Genero": genero,
            "FechaNacimiento": fecha_nacimiento,
            "IdLocalidad": parseInt(localidad),
            "CorreoElectronico": correo_electronico,
            "IdTipoUsuario": parseInt(tipo_usuario),
            "Contrasena": b64EncodeUnicode(contrasena),
            "Descripcion": descripcion,
            "Imagen": imagen
        })
    }).then((response) => response.json())
    .then((result) => {

        preloader.hidden = true;

         if (result.code === 200) {
            let data = result.data;

        } else {
            Swal.fire({
                title: '¡Alerta!',
                text: result.data,
                imageUrl: baseURL.concat("/assets/templates/IndiferentOwl.png"),
                imageWidth: 100,
                imageHeight: 123,
                imageAlt: 'Alert Image',
                background: '#000000',
                color: '#FFFFFF'
            });
        }
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
}

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

function getBuffer(fileData) {
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

function AvailableStringValue(value){return value === '' || value === null || value === undefined ? null : value.trim();}

function b64EncodeUnicode(str) {return btoa(encodeURIComponent(str));}

function UnicodeDecodeB64(str) {return decodeURIComponent(atob(str));}
