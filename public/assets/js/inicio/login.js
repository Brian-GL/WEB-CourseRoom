document.addEventListener('DOMContentLoaded', function() {document.getElementById("preloader").hidden = true; }, false);

document.getElementById("iniciarSesion").addEventListener('click', function () {

    document.getElementById("preloader").hidden = false;

    var correoElectronico = document.getElementById("CorreoElectronico").value;
    var contrasena = document.getElementById("Password").value;

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

         if (result.code === 200) {
            let data = result.data;


        } else {
            Swal.fire({
                title: '¡Alerta!',
                text: result.data,
                imageUrl: baseURL.concat("/assets/templates/IndiferentOwl.png"),
                imageWidth: 100,
                imageHeight: 123,
                imageAlt: 'Alert Image'
            });
        }
    }).catch((ex) => {
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

});
