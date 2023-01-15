"use strict";

let SpacesRegex = /^\s+/;
let DigitsRegex = /[^\d].+/;
let ElementsRegex = /(INPUT|A)/;
let AsciiAccents = [241, 209, 192, 239, 180, 186, 211, 201, 193, 205, 218, 225, 233, 237, 243, 250];
let Preloader;
let BaseURL = window.location.origin;
let IconoNotificaciones;

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
            data: {
                "IdUsuario": 0,
            }
        });

        let result = response.data;

        if(result.code === 200){
            IconoNotificaciones.classList.replace("fa-envelope-open","fa-envelope-open-text");

            for(let aviso of result.data){
                MostrarNotificacion(aviso.TipoAviso, aviso.Aviso, aviso.FechaRegistro);
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

//#endregion

//#region Functions


function ColorearWeb(){
    try {
        const colorThief = new ColorThief();
        let palette = colorThief.getPalette(document.getElementById("imagen-usuario"), 15);

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

            let fondo = "linear-gradient(to bottom, ".concat(PrimerColor,", ",SegundoColor,", ",TercerColor,")");;
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
    toastr.info('<span class="fuenteNormal fw-semibold d-block">'.concat(tipoAviso,'</span><span class="fuenteNormal d-block">',aviso,'</span><span class="d-block text-end">',fechaRegistro,'</span>'), {
        "closeButton": false,
        "debug": false,
        "newestOnTop": true,
        "progressBar": true,
        //"escapeHtml": false,
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







