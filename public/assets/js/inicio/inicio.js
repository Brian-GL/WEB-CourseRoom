document.addEventListener('DOMContentLoaded', function() {
    document.getElementById("preloader").hidden = true;

    window.Memes.fromReddit().then((meme)=>{
        document.getElementById("imagen-meme").src = meme.image;
    });

    let fondo = "linear-gradient(to top, rgba(".concat(sessionStorage.getItem("PrimerColor"), ",1), rgba(",sessionStorage.getItem("TercerColor"),",1))");

    document.getElementById("fondo-inicio").style.background = fondo;

}, false);

