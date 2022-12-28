document.addEventListener('DOMContentLoaded', function() {
    document.getElementById('preloader').hidden = true;
    let PrimerColor = sessionStorage.getItem("PrimerColor");
    let TercerColor = sessionStorage.getItem("TercerColor");
    let fondo = "linear-gradient(to top, rgba(".concat(PrimerColor, ",1), rgba(",TercerColor,",1))");
    document.getElementById("contenido").style.background = fondo;

    $("#table-mis-preguntas").DataTable({
        pagingType: 'full_numbers',
        dom: 'frtp',
        search: {
            return: true,
        },
        language: {
            search: "_INPUT_",
            searchPlaceholder: "Buscar preguntas...",
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
            {className: "dt-body-center dt-head-center fuenteNormal", targets: "_all"},
        ]
    });

    let inputDatatable = $(".dataTables_filter input");
    inputDatatable.removeClass("form-control-sm");
    inputDatatable.addClass("fuenteNormal");

    let botones = document.getElementsByClassName("page-link");
    let colorLetra = TercerColor[0] >= 127 ? "#000000" : "#FFFFFF";

    for(let boton of botones){
        boton.style = "background: rgb(".concat(TercerColor, "); color: rgb(",colorLetra,");");
    }


});
