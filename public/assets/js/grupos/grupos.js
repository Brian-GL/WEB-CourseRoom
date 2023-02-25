'use strict';

let dataTableMisgrupos, dataTableBuscarUsuarios;
let SegundoColor = localStorage.getItem("SegundoColor");
let SegundoColorLetra = localStorage.getItem("SegundoColorLetra");
let TercerColor = localStorage.getItem("TercerColor");
let TercerColorLetra = localStorage.getItem("TercerColorLetra");
let PrimerColor = localStorage.getItem("PrimerColor");
let PrimerColorLetra = localStorage.getItem("PrimerColorLetra");
let BaseURL = window.location.origin;

let assetsRouteGrupos = document.getElementById("assets-grupos").value;
let assetsRouteCursos = document.getElementById("assets-cursos").value;

dataTableMisgrupos = $("#table-mis-grupos").DataTable({
    pagingType: 'full_numbers',
    dom: 'frtp',
    search: {
        return: true,
    },
    scrollX: false,
    language: {
        search: "_INPUT_",
        searchPlaceholder: "Buscar algún grupo...",
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
        { title: "Id Grupo"},
        { title: "Grupo"},
        { title: "Imagen Grupo"},
        { title: "Id Curso"},
        { title: "Nombre Curso"},
        { title: "Imagen Curso"},
        { title: "Fecha de registro"},
        { title: "Detalle"}
    ],
    columnDefs:[
        {className: "text-center fuenteNormal segundo-color-letra", targets: "_all"},
        {className: "span-detalle", targets: "7"}
    ],
    rowCallback: function(row, data, index){
        $(row).css('color', SegundoColorLetra);
    }
});

dataTableMisgrupos.column(0).visible(false);
dataTableMisgrupos.column(2).visible(false);
dataTableMisgrupos.column(3).visible(false);
dataTableMisgrupos.column(5).visible(false);

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

document.addEventListener('DOMContentLoaded',  ObtenerMisGrupos, false);

//#region Methods

async function ObtenerMisGrupos(){
    try{

        ShowPreloader();

        let response = await axios({
            url: '/grupos/obtener',
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

                dataTableMisgrupos.destroy();

                dataTableMisgrupos = $("#table-mis-grupos").DataTable({
                    pagingType: 'full_numbers',
                    dom: 'frtp',
                    search: {
                        return: true,
                    },
                    scrollX: false,
                    language: {
                        search: "_INPUT_",
                        searchPlaceholder: "Buscar alguna de mis grupos...",
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
                        { data: "idGrupo", title: "Id Grupo"},
                        { data: "nombre", title: "Grupo"},
                        { data: "imagenGrupo", title: "Imagen Grupo"},
                        { data: "idCurso", title: "Id Curso"},
                        { data: "nombreCurso", title: "Nombre Curso"},
                        { data: "imagenCurso", title: "Imagen Curso"},
                        { data: "fechaRegistro", title: "Fecha de registro"},
                        { data: "", title: "Detalle"}
                    ],
                    columnDefs:[
                        {className: "text-center fuenteNormal segundo-color-letra", defaultContent: "-", targets: "_all"},
                        {className: "span-detalle", target: 7},
                        {className: "info-grupo", target: 1},
                        {className: "info-curso", target: 1},
                        {className: "fechaRegistro", target: 6},
                    ],
                    data: filas,
                    createdRow: (row, data) => {
                        $('.segundo-color-letra',row).css('color', SegundoColorLetra);
                        $('.span-detalle', row).html('<span class="fuenteNormal span-detalle text-center text-decoration-underline" onclick="DetalleGrupo('.concat(data.idGrupo,')">Ver detalle</span>'));
                        $('.info-grupo', row).html('<div class="container"><div class="row"><div class="col-5"><img class="img-fluid" alt="Imagen del grupo" src="'.concat(assetsRouteGrupos,'/',data.imagenGrupo,'"/></div><div class="col-7 p-0"><p class="fuenteNormal">',data.nombre,'</p></div></div></div>'));
                        $('.info-curso', row).html('<div class="container"><div class="row"><div class="col-5"><img class="img-fluid" alt="Imagen del curso" src="'.concat(assetsRouteCursos,'/',data.imagenCurso,'"/></div><div class="col-7 p-0"><p class="fuenteNormal">',data.nombreCurso,'</p></div></div></div>'));
                        let fechaRegistro = data.fechaRegistro.substring(0, data.fechaRegistro.length -1 );
                        $('.fechaRegistro', row).text(dayjs(fechaRegistro).format('dddd DD MMM YYYY h:mm A'));
                    }
                });

                dataTableMisgrupos.column(0).visible(false);
                dataTableMisgrupos.column(1).visible(false);
                dataTableMisgrupos.column(3).visible(false);

            }
            break;
            case 500:{
                dataTableMisgrupos.clear().draw();
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
                dataTableMisgrupos.clear().draw();
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
        dataTableMisgrupos.clear().draw();
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

document.DetalleGrupo = async function(IdGrupo){
    try{

        ShowPreloader();

        $('<form/>', { action: '/grupos/detalle', method: 'POST' }).append(
            $('<input>', {type: 'hidden', id: '_token', name: '_token', value: document.head.querySelector("[name~=csrf-token][content]").content}),
            $('<input>', {type: 'hidden', id: 'IdGrupo', name: 'IdGrupo', value: IdGrupo})
        ).appendTo('body').submit();

        HidePreloader();
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

//#endregion


