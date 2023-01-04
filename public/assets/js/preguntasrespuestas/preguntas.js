'use strict';

let dataTableMisPreguntas, dataTableBuscarPreguntas;
let SegundoColor = localStorage.getItem("SegundoColor");
let SegundoColorLetra = localStorage.getItem("SegundoColorLetra");
let TercerColor = localStorage.getItem("TercerColor");
let TercerColorLetra = localStorage.getItem("TercerColorLetra");
let PrimerColor = localStorage.getItem("PrimerColor");
let PrimerColorLetra = localStorage.getItem("PrimerColorLetra");
let BaseURL = window.location.origin;

dataTableMisPreguntas = $("#table-mis-preguntas").DataTable({
    pagingType: 'full_numbers',
    dom: 'frtp',
    search: {
        return: true,
    },
    scrollX: false,
    language: {
        search: "_INPUT_",
        searchPlaceholder: "Buscar alguna de mis preguntas...",
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
        { title: "Id Pregunta" },
        { title: "Pregunta" },
        { title: "Fecha de registro" },
        { title: "Estatus" },
        { title: "Detalle" }
    ],
    columnDefs:[
        {className: "text-center fuenteNormal segundo-color-fuente", targets: "_all"},
        {className: "btn-detalle", targets: "4"}
    ],
    rowCallback: function(row, data, index){
        $(row).css('color', SegundoColorLetra);
    }
});

dataTableMisPreguntas.column(0).visible(false);

dataTableBuscarPreguntas = $("#table-buscar-preguntas").DataTable({
    pagingType: 'full_numbers',
    dom: 'rtp',
    language: {
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
        { title: "IdPregunta" },
        { title: "Pregunta" },
        { title: "Preguntador" },
        { title: "Fecha de registro" },
        { title: "Estatus" },
        { title: "Detalle" }
    ],
    columnDefs:[
        {className: "text-center fuenteNormal segundo-color-fuente", targets: "_all"},
    ],
    rowCallback: function(row, data, index){
        $(row).css('color', SegundoColorLetra);
    }
});

dataTableBuscarPreguntas.column(0).visible(false);

let elementos = document.querySelectorAll('input[type="search"]');
for(let elemento of elementos){
    elemento.style.setProperty('color',PrimerColorLetra,'important');
    elemento.style.setProperty('background-color',PrimerColorLetra,'important');
    elemento.classList.add(PrimerColorLetra === 'rgb(0,0,0)' ? "black-placeholder" : "white-placeholder");
}

elementos = document.querySelectorAll('.paginate_button a');
for(let elemento of elementos){
    elemento.style.setProperty('color',SegundoColorLetra,'important');
    elemento.style.setProperty('background-color',SegundoColor,'important');
}

document.addEventListener('DOMContentLoaded',  ObtenerMisPreguntas, false);

//#region Methods

async function ObtenerMisPreguntas(){
    try{

        ShowPreloader();

        let response = await axios({
            url: '/preguntasrespuestas/obtener',
            baseURL: BaseURL,
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': document.head.querySelector("[name~=csrf-token][content]").content
            },
            data: {
                "IdUsuario": null,
            }
        });

        HidePreloader();

        let result = response.data;

        switch (result.code) {
            case 200:{
                let filas = result.data;
                dataTableMisPreguntas.destroy();
                //dataTableMisPreguntas.clear().draw();
                dataTableMisPreguntas = $("#table-mis-preguntas").DataTable({
                    pagingType: 'full_numbers',
                    dom: 'frtp',
                    search: {
                        return: true,
                    },
                    scrollX: false,
                    language: {
                        search: "_INPUT_",
                        searchPlaceholder: "Buscar alguna de mis preguntas...",
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
                        { title: "IdPregunta" },
                        { title: "Pregunta" },
                        { title: "Fecha de registro" },
                        { title: "Estatus" },
                        { title: "Detalle" }
                    ],
                    columnDefs:[
                        {className: "text-center fuenteNormal segundo-color-fuente", targets: "_all"},
                        {className: "btn-detalle", targets: "4"}
                    ],
                    rowCallback: function(row, data, index){
                        $(row).css('color', SegundoColorLetra);
                    },
                    data: filas,
                    createdRow: function(row, data, index){
                        $('.btn-detalle', row).html('<span class="span-detalle text-center" onclick="DetallePregunta('.concat(data.IdPregunta,')">Ver detalle</span>'));
                    }
                });

                dataTableBuscarPreguntas.column(0).visible(false);

            }
            break;
            case 500:{
                Swal.fire({
                    title: '¡Error!',
                    text: result.data,
                    imageUrl: BaseURL.concat("/assets/templates/SadOwl.png"),
                    imageWidth: 100,
                    imageHeight: 123,
                    background: '#000000',
                    color: '#FFFFFF',
                    imageAlt: 'Error Image'
                });
            }
            break;
            default:{
                Swal.fire({
                    title: '¡Alerta!',
                    text: result.data,
                    imageUrl: BaseURL.concat("/assets/templates/IndiferentOwl.png"),
                    imageWidth: 100,
                    imageHeight: 123,
                    imageAlt: 'Alert Image',
                    background: '#000000',
                    color: '#FFFFFF'
                });
            }
            break;
        }
    }
    catch(ex){

        HidePreloader();

        Swal.fire({
            title: '¡Error!',
            text: ex,
            imageUrl: BaseURL.concat("/assets/templates/SadOwl.png"),
            imageWidth: 100,
            imageHeight: 123,
            background: '#000000',
            color: '#FFFFFF',
            imageAlt: 'Error Image'
        });
    }
}


//#endregion

//#region Events

$(".nav-link").on("click",  (e) => {

    let elementos = document.getElementsByClassName("nav-link");

    for(let elemento of elementos){
        if(elemento.id !== e.target.id){
            elemento.style.setProperty('color',TercerColorLetra,'important');
            elemento.style.setProperty('background-color',TercerColor,'important');
        }else{
            elemento.style.setProperty('color',PrimerColorLetra,'important');
            elemento.style.setProperty('background-color',PrimerColor,'important');
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
      }).then(async (result) => {
            if(result.isConfirmed){

                try{

                    ShowPreloader();

                    let response = await axios({
                        url: '/preguntasrespuestas/registrar',
                        baseURL: BaseURL,
                        method: 'POST',
                        headers: {
                            'X-CSRF-TOKEN': document.head.querySelector("[name~=csrf-token][content]").content
                        },
                        data: {
                            "IdUsuario": null,
                            "Pregunta": AvailableString(result.value.pregunta),
                            "Descripcion": AvailableString(result.value.descripcion)
                        }
                    });

                    HidePreloader();

                    let resultado = response.data;

                    switch (resultado.code) {
                        case 200:{
                           let data = resultado.data;
                        }
                        break;
                        case 500:{
                            Swal.fire({
                                title: '¡Error!',
                                text: resultado.data,
                                imageUrl: BaseURL.concat("/assets/templates/SadOwl.png"),
                                imageWidth: 100,
                                imageHeight: 123,
                                background: '#000000',
                                color: '#FFFFFF',
                                imageAlt: 'Error Image'
                            });
                        }
                        break;
                        default:{
                            Swal.fire({
                                title: '¡Alerta!',
                                text: resultado.data,
                                imageUrl: BaseURL.concat("/assets/templates/IndiferentOwl.png"),
                                imageWidth: 100,
                                imageHeight: 123,
                                imageAlt: 'Alert Image',
                                background: '#000000',
                                color: '#FFFFFF'
                            });
                        }
                        break;
                    }
                }
                catch(ex){

                    HidePreloader();

                    Swal.fire({
                        title: '¡Error!',
                        text: ex,
                        imageUrl: BaseURL.concat("/assets/templates/SadOwl.png"),
                        imageWidth: 100,
                        imageHeight: 123,
                        background: '#000000',
                        color: '#FFFFFF',
                        imageAlt: 'Error Image'
                    });
                }

            }
      })

});

document.getElementById("form-buscar-preguntas").addEventListener('submit', async (e) => {
    e.preventDefault();
});


//#endregion
