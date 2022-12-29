document.addEventListener('DOMContentLoaded', function() {
    document.getElementById("preloader").hidden = true;
    Colorear();
}, false);

function Colorear(){
    let primerColor = sessionStorage.getItem("PrimerColor");
    let tercerColor = sessionStorage.getItem("TercerColor");

    let fondo = "linear-gradient(to top, rgba(".concat(primerColor, ",1), rgba(",tercerColor,",1))");
    document.getElementById("contenido").style.background = fondo;

    let colorLetra = primerColor[0] >= 127 ? "#000000" : "#FFFFFF";
    let elementos = document.getElementsByClassName("primer-color-letra");

    for(let elemento of elementos){
        elemento.style.color = colorLetra;
    }

    colorLetra = tercerColor[0] >= 127 ? "0,0,0" : "255,255,255";
    elementos = document.getElementsByClassName("tercer-color-letra");

    for(let elemento of elementos){
        elemento.style.color = colorLetra;
    }

    elementos = document.getElementsByClassName("tercer-color-boton");

    for(let elemento of elementos){
        elemento.style.background = "rgba(".concat(tercerColor, ",1)");
    }
}

document.getElementById("imagen").addEventListener("change", (e) => {

    let preloader = document.getElementById('preloader');
    preloader.hidden = false;

    try{
        if(e.target.files.length > 0){
            let selectedFile = e.target.files[0];

            let reader = new FileReader();

            let imagen = document.getElementById("imagen-seleccionada");
            imagen.title = selectedFile.name;

            reader.addEventListener("load", (e) => {
                imagen.src = e.target.result;
            });

            reader.readAsDataURL(selectedFile);

        }else{
            document.getElementById("imagen-seleccionada").src = "https://mdbootstrap.com/img/Photos/Others/placeholder-avatar.jpg";
        }
        preloader.hidden = true;
    } catch(ex){
        document.getElementById("imagen-seleccionada").src = "https://mdbootstrap.com/img/Photos/Others/placeholder-avatar.jpg";

        preloader.hidden = true;

        SweetAlert.fire({
            title: '¡Error!',
            html: ex,
            imageUrl: baseURL.concat("/assets/templates/SadOwl.png"),
            imageWidth: 100,
            imageHeight: 123,
            background: '#000000',
            color: '#FFFFFF',
            imageAlt: 'Error Image'
        });

    }
});
