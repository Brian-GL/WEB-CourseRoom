'use strict';

let SegundoColor = localStorage.getItem("SegundoColor");
let SegundoColorLetra = localStorage.getItem("SegundoColorLetra");
let TercerColor = localStorage.getItem("TercerColor");
let TercerColorLetra = localStorage.getItem("TercerColorLetra");
let PrimerColor = localStorage.getItem("PrimerColor");
let PrimerColorLetra = localStorage.getItem("PrimerColorLetra");
let BaseURL = window.location.origin;

let IdCurso = document.getElementById("id-curso").value;

//#region Events

$("#enrolar-curso").on("click", async () => {
    Swal.fire({
        title: 'Enrolarse al curso',
        text: '¿Está segur@ de querer enrolarte al curso "'.concat($("#nombre-curso").text(),'"?'),
        imageUrl: window.SadOwl,
        imageWidth: 100,
        imageHeight: 123,
        background: '#000000',
        color: '#FFFFFF',
        imageAlt: 'Alert Image',
        showCloseButton: true,
        showDenyButton: true,
        showCancelButton: false,
        confirmButtonText: 'Sí, quiero inscribirme 👩🏽‍🏫',
        denyButtonText: 'No por el momento 🙅🏽‍♀️'
    }).then(async (result) => {
        if(result.isConfirmed){
            try{
                ShowPreloader();

                let formData = new FormData();

                formData.append("IdCurso", IdCurso);

                let response = await axios({
                    url: '/cursos/estudianteregistrar',
                    baseURL: BaseURL,
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': document.head.querySelector("[name~=csrf-token][content]").content
                    },
                    data: formData
                });
        
                HidePreloader();
        
                let resultado = response.data;
        
                switch (resultado.code) {
                    case 200:{
                        Swal.fire({
                            title: 'Enrolarse a curso',
                            text: resultado.data.mensaje,
                            imageUrl: window.HappyOwl,
                            imageWidth: 100,
                            imageHeight: 123,
                            imageAlt: 'Ok Image',
                            background: '#000000',
                            color: '#FFFFFF'
                        }).then(() => {
                            window.href = "/mis-cursos";
                        });
                    }
                    break;
                    case 500:{
                        Swal.fire({
                            title: '¡Error!',
                            text: resultado.data,
                            imageUrl: window.SadOwl,
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
                            text: resultado.data,
                            imageUrl: window.IndifferentOwl,
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
                    imageUrl: window.SadOwl,
                    imageWidth: 100,
                    imageHeight: 123,
                    background: '#000000',
                    color: '#FFFFFF',
                    imageAlt: 'Error Image'
                });
            }
        } 
    });
    
});

//#endregion