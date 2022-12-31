document.getElementById("solucionar").addEventListener('click', function () {

    preloader.hidden = false;

    let baseURL = window.location.origin;

    let expresion = document.getElementById("expresion").value;
    let operacion = document.getElementById("tipo-operaciones").value;

    fetch(baseURL.concat('/herramientas/operador'), {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.head.querySelector("[name~=csrf-token][content]").content
        },
        body: JSON.stringify({
            "Expresion": expresion,
            "Operacion": operacion
        })
    }).then((response) => response.json())
    .then((result) => {

        preloader.hidden = true;

         if (result.code === 200) {

            let pretty = JSON.stringify(result.data, undefined, 4);
            document.getElementById("resultado").innerText = pretty;

        } else {
            document.getElementById("resultado").innerText = "";

            Swal.fire({
                title: '¡Alerta!',
                text: result.data,
                imageUrl:  baseURL.concat("/assets/templates/IndiferentOwl.png"),
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
});
