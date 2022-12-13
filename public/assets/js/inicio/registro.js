document.addEventListener('DOMContentLoaded', function() {
    document.getElementById("preloader").hidden = true;
}, false);


document.getElementById("form-registro").addEventListener("submit", (e) => {

    e.preventDefault();

    let imagen_input = document.getElementById("imagen");

    if(imagen_input.files.length > 0){

        let preloader = document.getElementById("preloader");
        preloader.hidden = false;

        let files = imagen_input.files;

        // Pass the file to the blob, not the input[0].
        let fileData = new Blob([files[0]]);

        // Pass getBuffer to promise.
        let promise = new Promise(getBuffer(fileData));

        // Wait for promise to be resolved, or log error.
        promise.then((bytes) => {

            preloader.hidden = true;
            Registrar(bytes);
        }).catch((ex) => {

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
        });
    } else{
        Registrar(null);
    }

});

function Registrar(imagen){

    let preloader = document.getElementById("preloader");
    preloader.hidden = false;

    const csrfToken = document.head.querySelector("[name~=csrf-token][content]").content;
    let baseURL = window.location.origin;

    let nombre = document.getElementById("nombre").value;
    let paterno = document.getElementById("paterno").value;
    let materno = document.getElementById("materno").value;
    let genero = document.getElementById("genero").value;
    let fecha_nacimiento = document.getElementById("fecha-nacimiento").value;
    let localidad = document.getElementById("localidad").text;
    let correo_electronico = document.getElementById("correo-electronico").value;
    let tipo_usuario = document.getElementById("tipo-usuario").text;
    let contrasena = document.getElementById("contrasena").value;
    let repetir_contrasena = document.getElementById("repetir-contrasena").value;
    let descripcion = document.getElementById("descripcion").value;


    if(contrasena !== repetir_contrasena){
        preloader.hidden = true;
        SweetAlert.fire({
            title: '¡Alerta!',
            text: "Las contraseñas no coinciden",
            imageUrl: baseURL.concat("/assets/templates/IndiferentOwl.png"),
            imageWidth: 100,
            imageHeight: 123,
            imageAlt: 'Alert Image'
        });

        return;
    }

    fetch(baseURL.concat('/registrar'), {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': csrfToken
        },
        body: JSON.stringify({
            "Nombre": AvailableStringValue(nombre),
            "Paterno": AvailableStringValue(paterno),
            "Materno": AvailableStringValue(materno),
            "Genero": AvailableStringValue(genero),
            "FechaNacimiento": fecha_nacimiento,
            "IdLocalidad": parseInt(localidad),
            "CorreoElectronico": AvailableStringValue(correo_electronico),
            "IdTipoUsuario": parseInt(tipo_usuario),
            "Contrasena": Buffer.from(contrasena).toString('base64'),
            "descripcion": AvailableStringValue(descripcion),
            "Imagen": imagen
        })
    }).then((response) => response.json())
    .then((result) => {

        preloader.hidden = true;

         if (result.code === 200) {
            let data = result.data;

        } else {
            SweetAlert.fire({
                title: '¡Alerta!',
                text: result.data,
                imageUrl: baseURL.concat("/assets/templates/IndiferentOwl.png"),
                imageWidth: 100,
                imageHeight: 123,
                imageAlt: 'Alert Image'
            });
        }
    }).catch((ex) => {

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
    });
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


document.getElementById("imagen-seleccionada").addEventListener('load', function() {
    try {

        if(this.src !== 'https://mdbootstrap.com/img/Photos/Others/placeholder-avatar.jpg'){

            const colorThief = new ColorThief();
            let palette = colorThief.getPalette(this, 2,400);

            let fondo = "radial-gradient(ellipse at right, rgba(".concat(palette[0], ",1), rgba(", palette[1],",0.1)");

            document.getElementById("card1").style.background = fondo;

            let colorLetra = palette[0][0] >= 127 ? "#000000" : "#FFFFFF";

            let elementos = document.getElementsByTagName("label");
            for(let elemento of elementos){
                elemento.style.color = colorLetra;
            }

            elementos = document.getElementsByClassName("letrado");
            for(let elemento of elementos){
                elemento.style.color = colorLetra;
            }
        }
        else{
            let fondo = "radial-gradient(ellipse at right, rgba(104,194,232,1), rgba(14,30,64,0.1))";

            document.getElementById("card1").style.background = fondo;

            let elementos = document.getElementsByTagName("label");
            for(let elemento of elementos){
                elemento.style.color = "rgba(0,0,0,1)";
            }

            elementos = document.getElementsByClassName("letrado");
            for(let elemento of elementos){
                elemento.style.color = "rgba(0,0,0,1)";
            }
        }


    } catch (e) {
        let fondo = "radial-gradient(ellipse at right, rgba(104,194,232,1), rgba(14,30,64,0.1))";

        document.getElementById("card1").style.background = fondo;

        let elementos = document.getElementsByTagName("label");
        for(let elemento of elementos){
            elemento.style.color = "rgba(0,0,0,1)";
        }

        elementos = document.getElementsByClassName("letrado");
        for(let elemento of elementos){
            elemento.style.color = "rgba(0,0,0,1)";
        }
    }
});


function getBuffer(fileData) {
    return function(resolve) {
      let reader = new FileReader();
      reader.readAsArrayBuffer(fileData);
      reader.addEventListener("load", function() {
        let arrayBuffer = reader.result
        let bytes = new Uint8Array(arrayBuffer);
        resolve(bytes);
      });
  }
}
