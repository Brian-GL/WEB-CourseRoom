'use strict';

let dataTableMisPreguntas, dataTableBuscarPreguntas;

let PrimerColor = sessionStorage.getItem("PrimerColor");
let TercerColor = sessionStorage.getItem("TercerColor");
let SegundoColor = sessionStorage.getItem("SegundoColor");
let colorLetra = PrimerColor[0] >= 127 ? "0,0,0" : "255,255,255";

dataTableMisPreguntas = $("#table-mis-preguntas").DataTable({
    pagingType: 'full_numbers',
    dom: 'frtp',
    search: {
        return: true,
    },
    language: {
        search: "_INPUT_",
        searchPlaceholder: "Buscar mis preguntas...",
        paginate: {
            "first":      "Primero",
            "last":       "Último",
            "next":       "Siguiente",
            "previous":   "Anterior"
        },
        zeroRecords: "Sin resultados encontrados",
        emptyTable: "Sin datos en la tabla",
        infoEmpty: "Sin entradas",
        loadingRecords: "Cargando..."
    },
    columns: [
        { title: "Pregunta" },
        { title: "Preguntador" },
        { title: "Descripción" },
        { title: "Fecha de registro" },
        { title: "Estatus" }
    ],
    columnDefs:[
        {className: "text-center fuenteNormal encabezado", targets: "_all"},
    ],
    rowCallback: function(row, data, index){
        $(row).css('color', "rgb(".concat(colorLetra,")"));
    }
});

dataTableBuscarPreguntas = $("#table-buscar-preguntas").DataTable({
    pagingType: 'full_numbers',
    dom: 'frtp',
    search: {
        return: true,
    },
    language: {
        search: "_INPUT_",
        searchPlaceholder: "Buscar alguna pregunta...",
        paginate: {
            "first":      "Primero",
            "last":       "Último",
            "next":       "Siguiente",
            "previous":   "Anterior"
        },
        zeroRecords: "Sin resultados encontrados",
        emptyTable: "Sin datos en la tabla",
        infoEmpty: "Sin entradas",
        loadingRecords: "Cargando..."
    },
    columns: [
        { title: "Pregunta" },
        { title: "Preguntador" },
        { title: "Descripción" },
        { title: "Fecha de registro" },
        { title: "Estatus" }
    ],
    columnDefs:[
        {className: "text-center fuenteNormal encabezado", targets: "_all"},
    ],
    rowCallback: function(row, data, index){
        $(row).css('color', "rgb(".concat(colorLetra,")"));
    }
});

let elementos = document.querySelectorAll('input[type="search"]');

//SegundoColor
let esNegro = SegundoColor[0] <= 127;
colorLetra = esNegro ? "0,0,0" : "255,255,255";

for(let elemento of elementos){
    elemento.style.cssText = "background: rgb(".concat(SegundoColor, "); color: rgb(",colorLetra,");");
    elemento.classList.remove("form-control-sm");
    elemento.classList.add("fuenteNormal", "form-control", esNegro ? "black-placeholder" : "white-placeholder");
}

elementos = document.getElementsByClassName("encabezado");
for(let elemento of elementos){
    elemento.style.cssText = "color: rgb(".concat(colorLetra,");");
}

let PrimerColorLetra =  PrimerColor[0] <= 127 ? "0,0,0" : "255,255,255";
let SegundoColorLetra =  SegundoColor[0] <= 127 ? "0,0,0" : "255,255,255";

elementos = document.getElementsByClassName("nav-link");
for(let elemento of elementos){
    if(elemento.classList.contains("active")){
        elemento.style.cssText = "background: rgb(".concat(SegundoColor, "); color: rgb(",SegundoColorLetra,") !important;");
    }else{
        elemento.style.cssText = "background: rgb(".concat(PrimerColor, "); color: rgb(",PrimerColorLetra,") !important;");
    }
}

elementos = document.getElementsByClassName("page-link");
colorLetra = TercerColor[0] <= 127 ? "0,0,0" : "255,255,255";

for(let elemento of elementos){
    elemento.style.cssText = "background: rgb(".concat(TercerColor, "); color: rgb(",colorLetra,"); important;");
}

document.getElementById("agregar-pregunta").style.cssText = "background: rgb(".concat(TercerColor, "); color: rgb(",colorLetra,"); important;");


$(".nav-link").on("click", () => {


    let PrimerColorLetra =  PrimerColor[0] <= 127 ? "0,0,0" : "255,255,255";
    let SegundoColorLetra =  SegundoColor[0] <= 127 ? "0,0,0" : "255,255,255";

    let elementos = document.getElementsByClassName("nav-link");

    for(let elemento of elementos){
        if(elemento.classList.contains("active")){
            elemento.style.cssText = "background: rgb(".concat(SegundoColor, "); color: rgb(",SegundoColorLetra,") !important;");
        }else{
            elemento.style.cssText = "background: rgb(".concat(PrimerColor, "); color: rgb(",PrimerColorLetra,") !important;");
        }
    }
});

document.getElementById("agregar-pregunta").addEventListener("click", function(){

    Swal.fire({
        icon: 'question',
        title: 'Crear nueva pregunta',
        padding: '0.5em',
        background: '#000000',
        color: '#FFFFFF',
        width: 600,
        html: `<input type="text" id="pregunta" class="swal2-input" placeholder="Pregunta" minlenght="3"  maxlenght="150">
        <textarea  id="descripcion" class="swal2-input" placeholder="Descripción" maxlenght="1000">`,
        confirmButtonText: 'Registrar',
        showCancelButton: true,
        cancelButtonText: `Cancelar`,
        focusConfirm: false,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        preConfirm: () => {
          const pregunta = Swal.getPopup().querySelector('#pregunta').value;
          const descripcion	 = Swal.getPopup().querySelector('#descripcion').value;
          if (!pregunta || !descripcion) {
            Swal.showValidationMessage(`Por favor ingrese los valores con un formato adecuado`)
          }
          return { pregunta: pregunta, descripcion: descripcion }
        }
      }).then((result) => {
            if(result.isConfirmed){
                let pregunta = result.value.pregunta;
                let descripcion = result.value.descripcion;

                RegistrarPregunta(pregunta, descripcion);

            }
      })

});

function RegistrarPregunta(Pregunta, Descripcion){
    preloader.hidden = false;
    let baseURL = window.location.origin;

    fetch(baseURL.concat('/preguntasrespuestas/registrar'), {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.head.querySelector("[name~=csrf-token][content]").content
        },
        body: JSON.stringify({
            "IdUsuario": null,
            "Pregunta": AvailableStringValue(Pregunta),
            "Descripcion": AvailableStringValue(Descripcion)
        })
    }).then((response) => response.json())
    .then((result) => {
        preloader.hidden = true;

        if (result.code === 200) {
            let data = result.data;

        } else {
            Swal.fire({
                title: '¡Alerta!',
                text: result.data,
                imageUrl: baseURL.concat("/assets/templates/IndiferentOwl.png"),
                imageWidth: 100,
                imageHeight: 123,
                imageAlt: 'Alert Image',
                background: '#000000',
                color: '#FFFFFF'
            });
        }
    }).catch((ex) => {

        preloader.hidden = true;
        Swal.fire({
            title: '¡Error!',
            text: ex,
            imageUrl: baseURL.concat("/assets/templates/SadOwl.png"),
            imageWidth: 100,
            imageHeight: 123,
            background: '#000000',
            color: '#FFFFFF',
            imageAlt: 'Error Image'
        });
    });
}

function AvailableStringValue(value){return value === '' || value === null || value === undefined ? null : value.trim();}
