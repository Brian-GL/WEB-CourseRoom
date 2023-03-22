"use strict";

let SpacesRegex = /^\s+/;
let DigitsRegex = /[^\d].+/;
let ElementsRegex = /(INPUT|A)/;
let AsciiAccents = [241, 209, 192, 239, 180, 186, 211, 201, 193, 205, 218, 225, 233, 237, 243, 250];
let Preloader;
let BaseURL = window.location.origin;
let IconoNotificaciones;
let ElementoReloj;

//#region Methods

async function ValidarNotificaciones(){

    try {

        let response = await axios({
            url: '/avisos/validar',
            baseURL: BaseURL,
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': document.head.querySelector("[name~=csrf-token][content]").content
            },
            data: null
        });

        let result = response.data;
        if(result.code === 200){
            IconoNotificaciones.classList.replace("fa-envelope-open","fa-envelope-open-text");

            for(let aviso of result.data){
                MostrarNotificacion(aviso.tipoAviso, aviso.aviso, aviso.fechaRegistro);
            }

        } else{
            IconoNotificaciones.classList.replace("fa-envelope-open-text","fa-envelope-open");
        }

    } catch (error) {
        console.error(error);
    }
}

//#endregion

//#region Events

document.addEventListener('DOMContentLoaded', () => {

    Preloader = document.getElementById("preloader");
    Preloader.hidden = true;

    IconoNotificaciones = document.getElementById("icono-notificaciones");
    ElementoReloj = document.getElementById("reloj");
    NotificationsThread();
    ColorearWeb();

}, false);

$('.alphabetic').on("keyup keypress blur", function (e)  {

    //e.currentTarget.value = e.currentTarget.value?.replace(SpacesRegex,'');

    if((e.which < 65 && e.which != 32) && (e.which < 65 && e.which != 16) ||
        (e.which > 90 && e.which < 97) || (e.which > 122 && !AsciiAccents.includes(e.which))){
            e.preventDefault();
        }
});

$(".emailing").on("keyup keypress blur", (e) => {
    if(e.which === 32){
        e.preventDefault();
    }
});

$('.numeric').on("keyup keypress blur", (e) => {
    //e.currentTarget.value = e.currentTarget.value?.replace(DigitsRegex,'');

    if(e.which < 48 && e.which > 57){
        e.preventDefault();
    }
});

document.getElementById("cerrar-sesion").addEventListener("click", async () => {

    try{

        Swal.fire({
            title: 'Cerrar Sesión',
            text: '¿Está segur@ de cerrar la sesión?',
            imageUrl: window.SadOwl,
            imageWidth: 100,
            imageHeight: 123,
            background: '#000000',
            color: '#FFFFFF',
            imageAlt: 'Alert Image',
            showCloseButton: true,
            showDenyButton: true,
            showCancelButton: false,
            confirmButtonText: 'Sí, ya estudié demasiado 😩',
            denyButtonText: 'No, me falta aprender ciertas cosas 😎'
        }).then(async (result) => {
            if(result.isConfirmed){
                
                ShowPreloader();

                let response = await axios({
                    url: '/usuarios/sesion',
                    baseURL: BaseURL,
                    method: 'PUT',
                    headers: {
                        'X-CSRF-TOKEN': document.head.querySelector("[name~=csrf-token][content]").content
                    },
                    data: null
                });
        
                HidePreloader();
        
                let result = response.data;
        
                switch (result.code) {
                    case 200:{
                       window.location.href = "/";
                    }
                    break;
                    case 500:{
                        Swal.fire({
                            title: '¡Error!',
                            text: result.data,
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
                            text: result.data,
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
        });
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

});

//#endregion

//#region Functions

function ColorearWeb(){
    try {

        let imagenElement = document.getElementById("imagen-usuario");

        if(imagenElement.src !== undefined && imagenElement.scr !== ''){

            const colorThief = new ColorThief();
            let palette = colorThief.getPalette(imagenElement, 15);

            let PrimerColor, SegundoColor, TercerColor, PrimerColorLetra, SegundoColorLetra, TercerColorLetra;

            let indice = 0, indiceSegundo = RandomInt(1,8), indiceTercero = RandomInt(8,15);

            if(palette !== undefined && palette !== null && palette.length > 0){
                for(let color of palette){
                    switch(indice){
                        case 0:
                            PrimerColor = "rgb(".concat(color,")");
                            PrimerColorLetra = color[1] >= 127 ? "rgb(0,0,0)" : "rgb(255,255,255)";
                            localStorage.setItem("PrimerColor", PrimerColor);
                            localStorage.setItem("PrimerColorLetra", PrimerColorLetra);
                        break;
                        case indiceSegundo:
                            SegundoColor = "rgb(".concat(color,")");
                            SegundoColorLetra = color[1] >= 127 ? "rgb(0,0,0)" : "rgb(255,255,255)";
                            localStorage.setItem("SegundoColor", SegundoColor);
                            localStorage.setItem("SegundoColorLetra", SegundoColorLetra);
                            break;
                        case indiceTercero:
                            TercerColor = "rgb(".concat(color,")");
                            TercerColorLetra = color[1] >= 127 ? "rgb(0,0,0)" : "rgb(255,255,255)";
                            localStorage.setItem("TercerColor", TercerColor);
                            localStorage.setItem("TercerColorLetra", TercerColorLetra);
                        break;
                    }
                    indice++;
                }

                let fondo = "linear-gradient(to bottom, ".concat(PrimerColor,", ",SegundoColor,",",TercerColor,")");
                document.getElementById("fondo").style.background = fondo;
                document.getElementById("inicio-offcanvas").style.background = fondo;

                //Primer color
                let elementos = document.getElementsByClassName("primer-color-letra");
                for(let elemento of elementos){
                    elemento.style.setProperty('color',PrimerColorLetra,'important');
                }

                elementos = document.getElementsByClassName("primer-color-fondo");
                for(let elemento of elementos){
                    elemento.style.setProperty('background-color',PrimerColor,'important');
                    if(ElementsRegex.test(elemento.tagName)){
                        elemento.classList.add(PrimerColorLetra === 'rgb(0,0,0)' ? "black-placeholder" : "white-placeholder");
                    }
                }

                //Segundo color
                elementos = document.getElementsByClassName("segundo-color-letra");
                for(let elemento of elementos){
                    elemento.style.setProperty('color',SegundoColorLetra,'important');
                }

                elementos = document.getElementsByClassName("segundo-color-fondo");
                for(let elemento of elementos){
                    elemento.style.setProperty('background-color',SegundoColor,'important');
                    if(ElementsRegex.test(elemento.tagName)){
                        elemento.classList.add(SegundoColorLetra === 'rgb(0,0,0)' ? "black-placeholder" : "white-placeholder");
                    }
                }

                //Tercer color
                elementos = document.getElementsByClassName("tercer-color-letra");
                for(var elemento of elementos){
                    elemento.style.setProperty('color',TercerColorLetra,'important');
                }

                elementos = document.getElementsByClassName("tercer-color-fondo");
                for(var elemento of elementos){
                    elemento.style.setProperty('background-color',TercerColor,'important');
                    if(ElementsRegex.test(elemento.tagName)){
                        elemento.classList.add(TercerColorLetra === 'rgb(0,0,0)' ? "black-placeholder" : "white-placeholder");
                    }
                }
                
            }
        }
    } catch (e) {
        console.error(e);
    }
}

window.ShowPreloader = function(){
    Preloader.hidden = false;
}

window.HidePreloader = function(){
    Preloader.hidden = true;
}

window.AvailableString = function(value){
    return value === '' || value === null || value === undefined ? null : value.trim();
}

window.MostrarNotificacion = function(tipoAviso, aviso, fechaRegistro){
    let fechaRegistroSubstring = fechaRegistro.substring(0, fechaRegistro.length -1 );
    let fechaRegistroFormat = dayjs(fechaRegistroSubstring).format('dddd DD MMM YYYY h:mm A');

    toastr.info('<span class="fuenteNormal fw-semibold d-block">'.concat('<i class="fa-regular fa-bell"></i>&nbsp; Aviso de ',tipoAviso,'</span><span class="fuenteNormal d-block">&nbsp;',aviso,'</span><span class="d-block text-end">',fechaRegistroFormat,'</span>'), {
        "closeButton": false,
        "debug": false,
        "newestOnTop": true,
        "progressBar": true,
        "positionClass": "toast-top-center",
        "preventDuplicates": false,
        "showDuration": "1000",
        "hideDuration": "1000",
        "timeOut": "5000",
        "extendedTimeOut": "1000",
        "showEasing": "swing",
        "hideEasing": "linear",
        "showMethod": "fadeIn",
        "hideMethod": "fadeOut"
      });
}

window.HappyOwl = document.getElementById("happy-owl").value;
window.IndifferentOwl = document.getElementById("indifferent-owl").value;
window.SadOwl = document.getElementById("sad-owl").value;

window.GetBase64FromUrl = async (url) => {
    const data = await fetch(url);
    const blob = await data.blob();
    return new Promise((resolve) => {
        const reader = new FileReader();
        reader.readAsDataURL(blob); 
        reader.onloadend = () => {
            const base64data = reader.result;   
            resolve(base64data);
        }
    });
}

async function NotificationsThread(){
    let flag = false;
    let timer = 0;
    const options = {
        year: "numeric",
        month: "long",
        day: "2-digit",
        hour: "2-digit",
        minute: "2-digit",
        second: "2-digit",
        hour12: true,
        timeZone: 'America/Panama'
    };

    while(true){
        if(flag){
            while(timer < 10){
                let date = new Date();
                ElementoReloj.innerText = date.toLocaleString('es-MX', options);
                await Sleep(1000);
                timer = timer + 1;
            }
        }
        flag = true;
        timer = 0;
        ValidarNotificaciones();
    }
}


window.Sleep = async function (msec){
    return new Promise(resolve => setTimeout(resolve, msec));
}

function RandomInt(min, max) {
    min = Math.ceil(min);
    max = Math.floor(max);
    return Math.floor(Math.random() * (max - min) + min); // The maximum is exclusive and the minimum is inclusive
}

//#endregion



