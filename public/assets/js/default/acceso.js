'use strict';

let BaseURL = window.location.origin;

document.getElementById("form-acceso").addEventListener("submit", async (e) => {

    e.preventDefault();

    try{

        ShowPreloader();

        let formData = new FormData();

        formData.append("CorreoElectronico", AvailableString(document.getElementById("correo-electronico").value));
        formData.append("Contrasena", Base64.encode(document.getElementById("contrasena").value));
        formData.append('Dispositivo', platform.os.family);
        formData.append('Fabricante', platform.manufacturer);
        formData.append('Navegador', platform.name);

        let response = await axios({
            url: '/default/acceder',
            baseURL: BaseURL,
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': document.head.querySelector("[name~=csrf-token][content]").content
            },
            data:formData
        });

        HidePreloader();

        let result = response.data;

        switch (result.code) {
            case 200:{
                window.location.href = BaseURL.concat('/inicio');
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
});
