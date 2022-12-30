"use strict";

const spacesRegex = /^\s+/;
const digitsRegex = /[^\d].+/;

let preloader;

document.addEventListener('DOMContentLoaded', () => {
    preloader = document.getElementById("preloader");
    preloader.hidden = true;
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


