'use strict';

let BaseURL = window.location.origin;

document.getElementById("form-recuperacion").addEventListener('submit', async (e) => {

    e.preventDefault();

    try{

        ShowPreloader();

        let response = await axios({
            url: '/default/recuperacion',
            baseURL: BaseURL,
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': document.head.querySelector("[name~=csrf-token][content]").content
            },
            data: {
                "CorreoElectronico": AvailableString(document.getElementById("correo-electronico").value),
            }
        });

        HidePreloader();

        let result = response.data;

        if (result.code === 200) {

            Swal.fire({
                title: 'Recuperación de credenciales',
                text: result.data,
                imageUrl: BaseURL.concat("/assets/templates/HappyOwl.png"),
                imageWidth: 100,
                imageHeight: 123,
                imageAlt: 'Alert Image',
                background: '#000000',
                color: '#FFFFFF'
            });

        } else {
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
});
