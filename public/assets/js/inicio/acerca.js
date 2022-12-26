document.addEventListener('DOMContentLoaded', function() {
    document.getElementById("preloader").hidden = true;
    Colorear();
}, false);

function Colorear(){
    let primerColor = sessionStorage.getItem("PrimerColor");
    let tercerColor = sessionStorage.getItem("TercerColor");

    let fondo = "linear-gradient(to top, rgba(".concat(primerColor, ",1), rgba(",tercerColor,",1))");
    document.getElementById("contenido").style.background = fondo;

    //Primer color
    let colorLetra = primerColor[0] >= 127 ? "#000000" : "#FFFFFF";
    document.getElementById("titulo").style.color = colorLetra;

    //Tercer color
    colorLetra = tercerColor[0] >= 127 ? "#000000" : "#FFFFFF";
    document.getElementById("texto-acerca").style.color = colorLetra;
}
