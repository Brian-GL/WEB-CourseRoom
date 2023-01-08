'use strict';

let dataTableMisChats;
let SegundoColor = localStorage.getItem("SegundoColor");
let SegundoColorLetra = localStorage.getItem("SegundoColorLetra");
let TercerColor = localStorage.getItem("TercerColor");
let TercerColorLetra = localStorage.getItem("TercerColorLetra");
let PrimerColor = localStorage.getItem("PrimerColor");
let PrimerColorLetra = localStorage.getItem("PrimerColorLetra");
let BaseURL = window.location.origin;

dataTableMisChats = $("#table-mis-chats").DataTable({
    pagingType: 'full_numbers',
    dom: 'frtp',
    search: {
        return: true,
    },
    scrollX: false,
    language: {
        search: "_INPUT_",
        searchPlaceholder: "Buscar alguno de mis chats...",
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
        { title: "Id Chat" },
        { title: "Id Usuario Receptor" },
        { title: "Receptor" },
        { title: "Imagen del receptor" },
        { title: "Fecha de registro" },
        { title: "Último mensaje" },
        { title: "Fecha de envío" },
        { title: "Mostrar" },
    ],
    columnDefs:[
        {className: "text-center fuenteNormal segundo-color-fuente", targets: "_all"},
        {className: "btn-detalle span-detalle", targets: "7"},
        {className: "receptor", targets: "2"},
        {visible: false, targets: [0,1,3]}
    ],
    rowCallback: function(row, data, index){
        $(row).css('color', SegundoColorLetra);
    }
});


let elementos = document.querySelectorAll('input[type="search"]');
for(let elemento of elementos){
    elemento.style.setProperty('color',PrimerColorLetra,'important');
    elemento.style.setProperty('background-color',PrimerColorLetra,'important');
    elemento.classList.add(PrimerColorLetra === 'rgb(0,0,0)' ? "white-placeholder" : "black-placeholder");
}

elementos = document.querySelectorAll('.paginate_button a');
for(let elemento of elementos){
    elemento.style.setProperty('color',SegundoColorLetra,'important');
    elemento.style.setProperty('background-color',SegundoColor,'important');
}

document.addEventListener('DOMContentLoaded',  ObtenerMisChats, false);

//#region Methods

async function ObtenerMisChats(){
    try{

        ShowPreloader();

        let response = await axios({
            url: '/chats/obtener',
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

                dataTableMisChats.destroy();

                dataTableMisChats = $("#table-mis-chats").DataTable({
                    pagingType: 'full_numbers',
                    dom: 'frtp',
                    search: {
                        return: true,
                    },
                    scrollX: false,
                    language: {
                        search: "_INPUT_",
                        searchPlaceholder: "Buscar alguno de mis chats...",
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
                        { title: "Id Chat" },
                        { title: "Id Usuario Receptor" },
                        { title: "Receptor" },
                        { title: "Imagen del receptor" },
                        { title: "Fecha de registro" },
                        { title: "Último mensaje" },
                        { title: "Fecha de envío" },
                        { title: "Mostrar" },
                    ],
                    columnDefs:[
                        {className: "text-center fuenteNormal segundo-color-fuente", targets: "_all"},
                        {className: "btn-detalle span-detalle", targets: "7"},
                        {visible: false, targets: "[0,1,3]"}
                    ],
                    rowCallback: function(row, data, index){
                        $(row).css('color', SegundoColorLetra);
                    },
                    data: filas,
                    createdRow: function(row, data, index){
                        $('.receptor', row).html('<img class="img-fluid" src="'.concat(data.ImagenReceptor,'"><span class="fuenteNormal">',data.Receptor,'</span>'));
                        $('.btn-detalle', row).html('<span class="span-detalle text-center" onclick="DetalleChat('.concat(data.IdChat,')">Ver chat</span>'));
                    }
                });

                dataTableMisChats.column(0).visible(false);

            }
            break;
            case 500:{
                dataTableMisChats.clear().draw();
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
                dataTableMisChats.clear().draw();
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
        dataTableMisChats.clear().draw();
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


document.getElementById("agregar-chat").addEventListener("click", function(){

    Swal.fire({
        icon: 'question',
        title: 'Crear nuevo chat',
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

//#endregion
