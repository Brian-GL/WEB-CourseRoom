"use strict";

let SpacesRegex = /^\s+/;
let DigitsRegex = /[^\d].+/;
let AsciiAccents = [241, 209, 192, 239, 180, 186, 211, 201, 193, 205, 218, 225, 233, 237, 243, 250];
let Preloader;

//#region Events

document.addEventListener('DOMContentLoaded', () => {
    Preloader = document.getElementById("preloader");
    Preloader.hidden = true;
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

window.ShowPreloader = function(){
    Preloader.hidden = false;
}

window.HidePreloader = function(){
    Preloader.hidden = true;
}

window.AvailableString = function(value){
    return value === '' || value === null || value === undefined ? undefined : value.trim();
}

window.GetBase64FromUrl = async (url) => {
    const data = await fetch(url);
    const blob = await data.blob();
    console.log(blob);
    return new Promise((resolve) => {
        const reader = new FileReader();
        reader.readAsDataURL(blob); 
        reader.onloadend = () => {
            const base64data = reader.result;   
            resolve(base64data);
        }
    });
}


//#endregion
