"use strict";

const spacesRegex = /^\s+/;
const digitsRegex = /[^\d].+/;

let preloader;

document.addEventListener('DOMContentLoaded', () => {

    preloader = document.getElementById("preloader");
    preloader.hidden = true;

    let elemento_imagen = document.getElementById("imagen-usuario");
    elemento_imagen.src = "https://colorlib.com/etc/bootstrap-sidebar/sidebar-01/images/logo.jpg";

}, false);

function Acentuacion(value){return [241, 209, 192, 239, 180, 186, 211, 201, 193, 205, 218, 225, 233, 237, 243, 250].includes(value);}

$('.alphabetic').on("keyup blur keypress", (e) =>  {

    if(spacesRegex.test(e.currentTarget.value)){
        e.currentTarget.value = e.currentTarget.value.trim();
    }

    if((e.which < 65 && e.which != 32) && (e.which < 65 && e.which != 16) ||
    (e.which > 90 && e.which < 97) || (e.which > 122 && !Acentuacion(e.which))){
        e.preventDefault();
    }
});

$('.replacing').on("keyup blur keypress", (e) => {
    if(spacesRegex.test(e.currentTarget.value)){
        e.currentTarget.value = e.currentTarget.value.trim();
    }
});

$('.numeric').on("keyup blur keypress", (e) => {
    if(digitsRegex.test(e.currentTarget.value)){
        e.currentTarget.value = e.currentTarget.value.trim();
    }

    if(e.which < 48 && e.which > 57){
        e.preventDefault();
    }
});


document.getElementById("imagen-usuario").addEventListener("load", function(){

    try {

        const colorThief = new ColorThief();
        let palette = colorThief.getPalette(this, 10);

        let primerColor = palette[0];
        let segundoColor = palette[getRandomInt(1,5)];
        let tercerColor = palette[getRandomInt(5,10)];

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

function getRandomInt(min, max) {
    min = Math.ceil(min);
    max = Math.floor(max);
    return Math.floor(Math.random() * (max - min) + min); // The maximum is exclusive and the minimum is inclusive
}
