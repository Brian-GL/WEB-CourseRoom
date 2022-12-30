'use strict';

document.getElementById("form-acceso").addEventListener("submit", (e) => {

    e.preventDefault();

    preloader.hidden = false;

    let correoElectronico = AvailableStringValue(document.getElementById("correo-electronico").value);
    let contrasena = document.getElementById("contrasena").value;

    let baseURL = window.location.origin;

    fetch(baseURL.concat('/default/login'), {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.head.querySelector("[name~=csrf-token][content]").content
        },
        body: JSON.stringify({
            "CorreoElectronico": correoElectronico,
            "Contrasena": b64EncodeUnicode(contrasena)
        })
    }).then((response) => response.json())
    .then((result) => {
        preloader.hidden = true;

        if (result.code === 200) {
            let data = result.data;

        } else {
            SweetAlert.fire({
                title: '¡Alerta!',
                text: result.data,
                imageUrl: baseURL.concat("/assets/templates/IndiferentOwl.png"),
                imageWidth: 100,
                imageHeight: 123,
                imageAlt: 'Alert Image'
            });
        }
    }).catch((ex) => {

        preloader.hidden = true;
        SweetAlert.fire({
            title: '¡Error!',
            text: ex,
            imageUrl: baseURL.concat("/assets/templates/SadOwl.png"),
            imageWidth: 100,
            imageHeight: 123,
            background: '#000000',
            color: '#FFFFFF',
            imageAlt: 'Error Image'
        });
    });

});

function AvailableStringValue(value){return value === '' || value === null || value === undefined ? null : value.trim();}

function b64EncodeUnicode(str) {return btoa(encodeURIComponent(str));}

function UnicodeDecodeB64(str) {return decodeURIComponent(atob(str));}
