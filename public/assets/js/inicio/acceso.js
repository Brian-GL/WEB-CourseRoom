document.addEventListener('DOMContentLoaded', function() {document.getElementById("preloader").hidden = true; }, false);

document.getElementById("form-acceso").addEventListener("submit", (e) => {

    e.preventDefault();

    let preloader = document.getElementById("preloader");
    preloader.hidden = false;

    let correoElectronico = document.getElementById("correo-electronico").value;
    let contrasena = document.getElementById("contrasena").value;

    const csrfToken = document.head.querySelector("[name~=csrf-token][content]").content;
    let baseURL = window.location.origin;

    fetch(baseURL.concat('/login'), {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': csrfToken
        },
        body: JSON.stringify({
            "CorreoElectronico": correoElectronico,
            "Contrasena": contrasena
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
            html: ex,
            imageUrl: baseURL.concat("/assets/templates/SadOwl.png"),
            imageWidth: 100,
            imageHeight: 123,
            background: '#000000',
            color: '#FFFFFF',
            imageAlt: 'Error Image'
        });
    });

});
