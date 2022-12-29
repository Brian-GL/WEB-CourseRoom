let dataTableMisPreguntas, dataTableBuscarPreguntas;

document.addEventListener('DOMContentLoaded', function() {
    document.getElementById('preloader').hidden = true;

    let PrimerColor = sessionStorage.getItem("PrimerColor");
    let TercerColor = sessionStorage.getItem("TercerColor");
    let fondo = "linear-gradient(to top, rgba(".concat(PrimerColor, ",1), rgba(",TercerColor,",1))");
    document.getElementById("contenido").style.background = fondo;

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

    Colorear();

});

function Colorear(){

    let PrimerColor = sessionStorage.getItem("PrimerColor");
    let SegundoColor = sessionStorage.getItem("SegundoColor");
    let TercerColor = sessionStorage.getItem("TercerColor");

    let elementos = document.querySelectorAll('input[type="search"]');

    //SegundoColor color
    let esNegro = SegundoColor[0] >= 127;
    let colorLetra = esNegro ? "0,0,0" : "255,255,255";

    for(let elemento of elementos){
        elemento.style.cssText = "background-color: rgb(".concat(SegundoColor, "); color: rgb(",colorLetra,");");
        elemento.classList.remove("form-control-sm");
        elemento.classList.add("fuenteNormal", "form-control", esNegro ? "black-placeholder" : "white-placeholder");
    }

    elementos = document.getElementsByClassName("encabezado");
    for(let elemento of elementos){
        elemento.style.cssText = "color: rgb(".concat(colorLetra,");");
    }

    let PrimerColorLetra =  PrimerColor[0] >= 127 ? "0,0,0" : "255,255,255";
    let SegundoColorLetra =  SegundoColor[0] >= 127 ? "0,0,0" : "255,255,255";

    elementos = document.getElementsByClassName("nav-link");

    for(let elemento of elementos){
        if(elemento.classList.contains("active")){
            elemento.style.cssText = "background-color: rgb(".concat(SegundoColor, "); color: rgb(",SegundoColorLetra,") !important;");
        }else{
            elemento.style.cssText = "background-color: rgb(".concat(PrimerColor, "); color: rgb(",PrimerColorLetra,") !important;");
        }
    }

    elementos = document.getElementsByClassName("page-link");
    colorLetra = TercerColor[0] >= 127 ? "0,0,0" : "255,255,255";

    for(let elemento of elementos){
        elemento.style.cssText = "background-color: rgb(".concat(TercerColor, "); color: rgb(",colorLetra,"); important;");
    }

    document.getElementById("agregar-pregunta").style.cssText = "background-color: rgb(".concat(TercerColor, "); color: rgb(",colorLetra,"); important;");
}

$(".nav-link").on("click", () => {
    let PrimerColor = sessionStorage.getItem("PrimerColor");
    let SegundoColor = sessionStorage.getItem("SegundoColor");

    let PrimerColorLetra =  PrimerColor[0] >= 127 ? "0,0,0" : "255,255,255";
    let SegundoColorLetra =  SegundoColor[0] >= 127 ? "0,0,0" : "255,255,255";

    let elementos = document.getElementsByClassName("nav-link");

    for(let elemento of elementos){
        if(elemento.classList.contains("active")){
            elemento.style.cssText = "background-color: rgb(".concat(SegundoColor, "); color: rgb(",SegundoColorLetra,") !important;");
        }else{
            elemento.style.cssText = "background-color: rgb(".concat(PrimerColor, "); color: rgb(",PrimerColorLetra,") !important;");
        }
    }
});

document.getElementById("agregar-pregunta").addEventListener("click", function(){



});
