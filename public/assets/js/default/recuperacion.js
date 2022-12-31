'use strict';

document.getElementById("form-recuperacion").addEventListener('submit', function () {

    preloader.hidden = false;

    let correoElectronico = AvailableStringValue(document.getElementById("correo-electronico").value);

    let baseURL = window.location.origin;

    fetch(baseURL.concat('/default/recuperacion'), {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.head.querySelector("[name~=csrf-token][content]").content
        },
        body: JSON.stringify({
            "CorreoElectronico": correoElectronico
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
            html: ex.data,
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
