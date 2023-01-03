"use strict";

let SpacesRegex = /^\s+/;
let DigitsRegex = /[^\d].+/;
let AsciiAccents = [241, 209, 192, 239, 180, 186, 211, 201, 193, 205, 218, 225, 233, 237, 243, 250];
let Preloader;
let BaseURL = window.location.origin;
let IconoNotificaciones;

//Events

document.addEventListener('DOMContentLoaded', () => {

    Preloader = document.getElementById("preloader");
    Preloader.hidden = true;

    IconoNotificaciones = document.getElementById("icono-notificaciones");

    let elemento_imagen = document.getElementById("imagen-usuario");
    elemento_imagen.src = "https://colorlib.com/etc/bootstrap-sidebar/sidebar-01/images/logo.jpg";

    NotificationsThread();

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

document.getElementById("imagen-usuario").addEventListener("load", function(){

    try {

        const colorThief = new ColorThief();
        let palette = colorThief.getPalette(this, 10);

        let primerColor = palette[0];
        let segundoColor = palette[RandomInt(1,5)];
        let tercerColor = palette[RandomInt(5,10)];

        sessionStorage.setItem('PrimerColor', primerColor);
        sessionStorage.setItem('SegundoColor', segundoColor);
        sessionStorage.setItem('TercerColor', tercerColor);

        let fondo = "linear-gradient(to bottom, rgba(".concat(primerColor, ",1), rgba(",segundoColor,",1), rgba(",tercerColor,",1))");
        document.getElementById("inicio-offcanvas").style.background = fondo;

        //Primer color
        let colorLetra = primerColor[0] >= 127 ? "#000000" : "#FFFFFF";
        let elementos = document.getElementsByClassName("primer-color-letra");
        for(var elemento of elementos){
            elemento.style.color = colorLetra;
        }

        let colorFondo = "rgba(".concat(tercerColor, ",1)");
        elementos = document.getElementsByClassName("primer-color-fondo");
        for(var elemento of elementos){
            elemento.style.background = colorFondo;
        }

        //Segundo color
        colorLetra = segundoColor[0] >= 127 ? "#000000" : "#FFFFFF";
        elementos = document.getElementsByClassName("segundo-color-letra");
        for(var elemento of elementos){
            elemento.style.color = colorLetra;
        }

        //Tercer color
        colorLetra = tercerColor[0] >= 127 ? "#000000" : "#FFFFFF";
        elementos = document.getElementsByClassName("tercer-color-letra");
        for(var elemento of elementos){
            elemento.style.color = colorLetra;
        }

        colorFondo = "rgba(".concat(primerColor, ",1)");
        elementos = document.getElementsByClassName("tercer-color-fondo");
        for(var elemento of elementos){
            elemento.style.background = colorFondo;
        }

        document.getElementById("barra-navegacion").style.background = "rgba(".concat(segundoColor, ",1)");

        //Inicio:
        fondo = "linear-gradient(to top, rgba(".concat(primerColor, ",1), rgba(",sessionStorage.getItem("TercerColor"),",1))");
        document.getElementById("fondo").style.background = fondo;

        //Primer color
        colorLetra = primerColor[0] >= 127 ? "#000000" : "#FFFFFF";
        $("#titulo").css("color", colorLetra);

    } catch (e) {
        console.error(e);
    }
});

//Methods

async function ValidarNotificaciones(){

    try {

        let response = await axios({
            url: '/avisos/validar',
            baseURL: BaseURL,
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': document.head.querySelector("[name~=csrf-token][content]").content
            },
            data: {
                "IdUsuario": 0,
            }
        });

        let result = response.data;

        if(result.code === 200){
            IconoNotificaciones.classList.replace("fa-envelope-open","fa-envelope-open-text");
        } else{
            IconoNotificaciones.classList.replace("fa-envelope-open-text","fa-envelope-open");
        }

    } catch (error) {
        console.error(error);
    }
}

//#region Functions

window.ShowPreloader = function(){
    Preloader.hidden = false;
}

window.HidePreloader = function(){
    Preloader.hidden = true;
}

window.AvailableString = function(value){
    return value === '' || value === null || value === undefined ? null : value.trim();
}

window.MostrarNotificacion = function(titulo, mensaje){
    toastr.info(titulo, mensaje, {
        "closeButton": false,
        "debug": false,
        "newestOnTop": true,
        "progressBar": true,
        "positionClass": "toast-top-center",
        "preventDuplicates": false,
        "showDuration": "300",
        "hideDuration": "1000",
        "timeOut": "5000",
        "extendedTimeOut": "1000",
        "showEasing": "swing",
        "hideEasing": "linear",
        "showMethod": "fadeIn",
        "hideMethod": "fadeOut"
      });
}

async function NotificationsThread(){
    let flag = false;
    let timer = 0;
    while(true){
        if(flag){
            while(timer < 10){
                await Sleep(1000);
                timer = timer + 1;
            }
        }
        flag = true;
        timer = 0;
        ValidarNotificaciones();
    }
}

async function Sleep(msec){
    return new Promise(resolve => setTimeout(resolve, msec));
}

function RandomInt(min, max) {
    min = Math.ceil(min);
    max = Math.floor(max);
    return Math.floor(Math.random() * (max - min) + min); // The maximum is exclusive and the minimum is inclusive
}

//#endregion







