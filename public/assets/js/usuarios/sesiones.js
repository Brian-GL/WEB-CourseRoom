'use strict';

let dataTableSesiones;
let SegundoColor = localStorage.getItem("SegundoColor");
let SegundoColorLetra = localStorage.getItem("SegundoColorLetra");
let TercerColor = localStorage.getItem("TercerColor");
let TercerColorLetra = localStorage.getItem("TercerColorLetra");
let PrimerColor = localStorage.getItem("PrimerColor");
let PrimerColorLetra = localStorage.getItem("PrimerColorLetra");
let BaseURL = window.location.origin;

dataTableSesiones = $("#table-sesiones").DataTable({
    pagingType: 'full_numbers',
    dom: 'frtp',
    ordering: true,
    scrollX: false,
    bFilter: true,
    language: {
        search: "_INPUT_",
        searchPlaceholder: "Buscar alguna de mis sesiones...",
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
        { title: "Id Sesión" },
        { title: "Dispositivo" },
        { title: "Fabricante" },
        { title: "IP" },
        { title: "MAC" },
        { title: "UserAgent" },
        { title: "Navegador" },
        { title: "Estatus" },
        { title: "Fecha de registro" },
        { title: "Actualizado" },
    ],
    columnDefs:[
        {className: "text-center fuenteNormal segundo-color-letra", targets: "_all"}
    ],
    rowCallback: function(row, data, index){
        $(row).css('color', SegundoColorLetra);
    }
});

dataTableSesiones.column(0).visible(false);

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

document.addEventListener('DOMContentLoaded',  ObtenerSesiones, false);

//#region Methods

async function ObtenerSesiones(){
    try{

        ShowPreloader();

        let response = await axios({
            url: '/usuarios/sesiones',
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

                dataTableSesiones.destroy();

                dataTableSesiones = $("#table-sesiones").DataTable({
                    pagingType: 'full_numbers',
                    dom: 'frtp',
                    ordering: true,
                    scrollX: false,
                    bFilter: true,
                    language: {
                        search: "_INPUT_",
                        searchPlaceholder: "Buscar alguna de mis sesiones...",
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
                        { data: "idSesion", title: "Id Sesión" },
                        { data: "dispositivo", title: "Dispositivo" },
                        { data: "fabricante", title: "Fabricante" },
                        { data: "direccionIP", title: "IP" },
                        { data: "direccionMAC", title: "MAC" },
                        { data: "userAgent", title: "UserAgent" },
                        { data: "navegador", title: "Navegador" },
                        { data: "estatus", title: "Estatus" },
                        { data: "fechaRegistro", title: "Fecha de registro" },
                        { data: "fechaActualizacion", title: "Actualizado" },
                    ],
                    columnDefs:[
                        {className: "text-center fuenteNormal segundo-color-letra", "defaultContent": "-", targets: "_all"},
                        { className: "fechaRegistro", targets: [8]},
                        { className: "fechaActualizacion", targets: [9]}
                    ],
                    createdRow: (row, data) => {

                        $(row).css('color', SegundoColorLetra);

                        $('.fechaRegistro', row).text(moment(data.fechaRegistro).format('LLLL'));
                        let fechaActualizacion = moment(data.fechaActualizacion);
                        if(fechaActualizacion.isValid()){
                            $('.fechaActualizacion', row).text(fechaActualizacion.format('LLLL'));
                        }
                    },
                    data: filas
                });

                dataTableSesiones.column(0).visible(false);
            }
            break;
            case 500:{
                dataTableSesiones.clear().draw();
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
                dataTableSesiones.clear().draw();
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
        dataTableSesiones.clear().draw();
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
