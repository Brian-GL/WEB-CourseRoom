document.addEventListener('DOMContentLoaded', function() {

    document.getElementById("preloader").hidden = true;

    let elemento_imagen = document.getElementById("imagen-usuario");
    elemento_imagen.src = "https://colorlib.com/etc/bootstrap-sidebar/sidebar-01/images/logo.jpg";

    $('.alphabetic').on("keyup blur keypress", function(e){

        let value = $(this).val();

        $(this).val(value.replace(/^\s+/, ''));

        if((e.which < 65 && e.which != 32) && (e.which < 65 && e.which != 16) ||
        (e.which > 90 && e.which < 97) || (e.which > 122 && !Acentuacion(e.which))){
            e.preventDefault();
        }

    });

    $('.numeric').on("keyup blur keypress", function(e){

        let value = $(this).val();

        $(this).val(value.replace(/^\s+/, ''));

        if(e.which < 48 && e.which > 57){
            e.preventDefault();
        }

    });

}, false);

function Acentuacion(value){
    return [241, 209, 192, 239, 180, 186, 211, 201, 193, 205, 218, 225, 233, 237, 243, 250].includes(value);
}

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

        for(var elemento of document.getElementsByClassName("primer-color-letra")){
            elemento.style.color = colorLetra;
        }

        let colorFondo = "rgba(".concat(tercerColor, ",1)");

        for(var elemento of document.getElementsByClassName("primer-color-fondo")){
            elemento.style.background = colorFondo;
        }

        //Segundo color
        colorLetra = segundoColor[0] >= 127 ? "#000000" : "#FFFFFF";

        for(var elemento of document.getElementsByClassName("segundo-color-letra")){
            elemento.style.color = colorLetra;
        }

        //Tercer color
        colorLetra = tercerColor[0] >= 127 ? "#000000" : "#FFFFFF";

        for(var elemento of document.getElementsByClassName("tercer-color-letra")){
            elemento.style.color = colorLetra;
        }

        colorFondo = "rgba(".concat(primerColor, ",1)");

        for(var elemento of document.getElementsByClassName("tercer-color-fondo")){
            elemento.style.background = colorFondo;
        }

        document.getElementById("barra-navegacion").style.background = "rgba(".concat(segundoColor, ",1)");

        //Inicio:
        fondo = "linear-gradient(to top, rgba(".concat(primerColor, ",1), rgba(",sessionStorage.getItem("TercerColor"),",1))");
        document.getElementById("contenido").style.background = fondo;

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
