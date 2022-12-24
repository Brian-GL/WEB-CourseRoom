document.addEventListener('DOMContentLoaded', function() {

    document.getElementById("preloader").hidden = true;

    let elemento_imagen = document.getElementById("imagen-usuario");
    elemento_imagen.src = "https://colorlib.com/etc/bootstrap-sidebar/sidebar-01/images/logo.jpg";

}, false);

document.getElementById("imagen-usuario").addEventListener("load", function(){

    try {
        const colorThief = new ColorThief();
        let palette = colorThief.getPalette(this, 10, 400);

        let fondo = "linear-gradient(to top, rgba(".concat(palette[0], ",1) 0%, rgba(",palette[getRandomInt(1,5)],",1) 50%, rgba(",palette[getRandomInt(5,10)],",1) 100%)");

        document.getElementById("inicio-offcanvas").style.background = fondo;

        let colorLetra = palette[0][0] >= 127 ? "#000000" : "#FFFFFF";

        for(var elemento of document.getElementsByClassName("letra")){
            elemento.style.color = colorLetra;
        }

        let colorFondo = "rgba(".concat(palette[1], ",1)");

        for(var elemento of document.getElementsByClassName("fondo-boton")){
            elemento.style.color = colorFondo;
        }


    } catch (e) {
        document.getElementById("inicio-offcanvas").style.background = "linear-gradient (to right, rgb(0,0,0),rgb(0,0,0))";
        console.error(e);
    }
});


function getRandomInt(min, max) {
    min = Math.ceil(min);
    max = Math.floor(max);
    return Math.floor(Math.random() * (max - min) + min); // The maximum is exclusive and the minimum is inclusive
}
