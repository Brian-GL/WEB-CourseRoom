document.addEventListener('DOMContentLoaded', function() {
    Colorear();
}, false);

function Colorear(){
    let primerColor = sessionStorage.getItem("PrimerColor");
    let tercerColor = sessionStorage.getItem("TercerColor");

    //Primer color
    let colorLetra = primerColor[0] >= 127 ? "#000000" : "#FFFFFF";
    document.getElementById("titulo").style.color = colorLetra;

    //Tercer color
    colorLetra = tercerColor[0] >= 127 ? "#000000" : "#FFFFFF";
    document.getElementById("texto-acerca").style.color = colorLetra;
}
