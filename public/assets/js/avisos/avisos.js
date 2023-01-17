'use strict';

let dataTableAvisos;
let SegundoColor = localStorage.getItem("SegundoColor");
let SegundoColorLetra = localStorage.getItem("SegundoColorLetra");
let TercerColor = localStorage.getItem("TercerColor");
let TercerColorLetra = localStorage.getItem("TercerColorLetra");
let PrimerColor = localStorage.getItem("PrimerColor");
let PrimerColorLetra = localStorage.getItem("PrimerColorLetra");
let BaseURL = window.location.origin;

dataTableAvisos = $("#table-avisos").DataTable({
    pagingType: 'full_numbers',
    dom: 'frtp',
    ordering: true,
    scrollX: false,
    bFilter: true,
    language: {
        search: "_INPUT_",
        searchPlaceholder: "Buscar algún aviso...",
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
        { title: "Id Aviso" },
        { title: "Fecha de registro" },
        { title: "Aviso" },
        { title: "Estatus" },
        { title: "Tipo de aviso" },
        { title: "Detalle" },
    ],
    columnDefs:[
        {className: "text-center fuenteNormal segundo-color-letra", targets: "_all"}
    ],
    rowCallback: function(row, data, index){
        $(row).css('color', SegundoColorLetra);
    }
});

dataTableAvisos.column(0).visible(false);

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

document.addEventListener('DOMContentLoaded',  ObtenerAvisos, false);

//#region Methods

document.Detalle = async function(IdAviso, Estatus) {

    if(Estatus === 'No leído'){

        //Actualizar estatus a leído:
        try{

            ShowPreloader();
    
            let response = await axios({
                url: '/avisos/actualizar',
                baseURL: BaseURL,
                method: 'PUT',
                headers: {
                    'X-CSRF-TOKEN': document.head.querySelector("[name~=csrf-token][content]").content
                },
                data: {
                    "IdAviso": IdAviso
                }
            });
    
            HidePreloader();
    
            let result = response.data;
    
            switch (result.code) {
                case 200:{
                    MostrarDetalle(IdAviso);
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

    }else{
        MostrarDetalle(IdAviso);
    }
}

async function MostrarDetalle(IdAviso){

    try{

        ShowPreloader();

        let response = await axios({
            url: '/avisos/detalle',
            baseURL: BaseURL,
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': document.head.querySelector("[name~=csrf-token][content]").content
            },
            data: {
                "IdAviso": IdAviso
            }
        });

        HidePreloader();

        let result = response.data;

        switch (result.code) {
            case 200:{
               
                let aviso = result.data;
                console.log(aviso.fechaRegistro);
                let fechaRegistro = moment(aviso.fechaRegistro).format('LLLL');
                let fechaActualizacionMoment = moment(aviso.fechaActualizacion);
                let fechaActualizacion = fechaActualizacionMoment.isValid() ? fechaActualizacionMoment.format('LLLL') : 'N/D';

                Swal.fire({
                    title: '<strong>'.concat(aviso.aviso,'</strong>'),
                    imageUrl: "https://www.nicepng.com/png/full/38-385666_youtube-notifications-bell-png-freeuse-library-push-notifications.png",
                    imageWidth: 100,
                    imageHeight: 123,
                    background: '#000000',
                    color: '#FFFFFF',
                    html:
                      '<div><strong>Descripción: </strong><p class="text-wrap fuenteNormal">'.concat(aviso.descripcion,'</p></div>').
                        concat('<div><strong>Estatus: </strong><p class="text-wrap fuenteNormal">',aviso.estatus,'</p></div>').
                        concat('<div><strong>Tipo: </strong><p class="text-wrap fuenteNormal">',aviso.tipoAviso,'</p></div>').
                        concat('<div><strong>Registrado el : </strong><p class="text-wrap fuenteNormal">',fechaRegistro,'</p></div>').
                        concat('<div><strong>Actualizado el : </strong><p class="text-wrap fuenteNormal">',fechaActualizacion,'</p></div>'),
                    showCloseButton: true,
                    focusConfirm: false,
                    confirmButtonText: 'Aceptar',
                  });
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

async function ObtenerAvisos(){
    try{

        ShowPreloader();

        let response = await axios({
            url: '/avisos/obtener',
            baseURL: BaseURL,
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': document.head.querySelector("[name~=csrf-token][content]").content
            },
            data: null
        });

        HidePreloader();

        let result = response.data;

        switch (result.code) {
            case 200:{
                let filas = result.data;

                dataTableAvisos.destroy();

                dataTableAvisos = $("#table-avisos").DataTable({
                    pagingType: 'full_numbers',
                    dom: 'frtp',
                    ordering: true,
                    scrollX: false,
                    bFilter: true,
                    language: {
                        search: "_INPUT_",
                        searchPlaceholder: "Buscar algún aviso...",
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
                        { data: "idAviso", title: "Id Aviso" },
                        { data: "fechaRegistro", title: "Fecha de registro" },
                        { data: "aviso", title: "Aviso" },
                        { data: "estatus", title: "Estatus" },
                        { data: "tipoAviso", title: "Tipo de aviso" },
                        { data: "", title: "Detalle" },
                    ],
                    columnDefs:[
                        {className: "text-center fuenteNormal segundo-color-letra", "defaultContent": "-", targets: "_all"},
                        { className: "fechaRegistro", targets: [1]},
                        { className: "detalle", targets: [5]},
                    ],
                    createdRow: (row, data) => {
                        $(row).css('color', SegundoColorLetra);
                        $('.fechaRegistro', row).text(moment(data.fechaRegistro).format('LLLL'));
                        $('.detalle', row).html('<span class="fuenteNormal span-detalle fw-bolder text-decoration-underline" onclick="document.Detalle('.concat(data.idAviso,', \'',data.estatus,'\')">Ver detalle</span>'));
                    },
                    data: filas
                });

                dataTableAvisos.column(0).visible(false);
            }
            break;
            case 500:{
                dataTableAvisos.clear().draw();
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
                dataTableAvisos.clear().draw();
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
        dataTableAvisos.clear().draw();
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