'use strict';

let idTipoUsuario = document.getElementById("id-tipo-usuario").value;
let SegundoColor = localStorage.getItem("SegundoColor");
let SegundoColorLetra = localStorage.getItem("SegundoColorLetra");
let TercerColor = localStorage.getItem("TercerColor");
let TercerColorLetra = localStorage.getItem("TercerColorLetra");
let PrimerColor = localStorage.getItem("PrimerColor");
let PrimerColorLetra = localStorage.getItem("PrimerColorLetra");
let BaseURL = window.location.origin;

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


//Si eres estudiante
if(idTipoUsuario == 1){

    let dataTableCursosActualesEstudiante;

    dataTableCursosActualesEstudiante = $("#table-cursos-actuales-estudiante").DataTable({
        pagingType: 'full_numbers',
        dom: 'frtp',
        search: {
            return: true,
        },
        scrollX: false,
        language: {
            search: "_INPUT_",
            searchPlaceholder: "Buscar algún curso...",
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
            { title: "IdCurso"},
            { title: "Curso"},
            { title: "ImagenCurso"},
            { title: "IdProfesor"},
            { title: "Profesor"},
            { title: "ImagenProfesor"},
            { title: "Temáticas"},
            { title: "Fecha de registro"},
            { title: "Puntaje"},
            { title: "Fecha de ingreso"},
            { title: "Estatus"},
            { title: "Detalle"}
        ],
        columnDefs:[
            {className: "text-center fuenteNormal segundo-color-letra", targets: "_all"},
            {className: "span-detalle", target: 11}
        ],
        rowCallback: function(row, data, index){
            $(row).css('color', SegundoColorLetra);
        }
    });

    dataTableCursosActualesEstudiante.column(0).visible(false);
    dataTableCursosActualesEstudiante.column(2).visible(false);
    dataTableCursosActualesEstudiante.column(3).visible(false);
    dataTableCursosActualesEstudiante.column(5).visible(false);
    dataTableCursosActualesEstudiante.column(6).visible(false);

    let dataTableCursosFinalizadosEstudiante;

    dataTableCursosFinalizadosEstudiante = $("#table-cursos-finalizados-estudiante").DataTable({
        pagingType: 'full_numbers',
        dom: 'frtp',
        search: {
            return: true,
        },
        scrollX: false,
        language: {
            search: "_INPUT_",
            searchPlaceholder: "Buscar algún curso...",
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
            { title: "IdCurso"},
            { title: "Curso"},
            { title: "ImagenCurso"},
            { title: "IdProfesor"},
            { title: "Profesor"},
            { title: "ImagenProfesor"},
            { title: "Temáticas"},
            { title: "Fecha de registro"},
            { title: "Puntaje"},
            { title: "Fecha de ingreso"},
            { title: "Estatus"},
            { title: "Detalle"}
        ],
        columnDefs:[
            {className: "text-center fuenteNormal segundo-color-letra", targets: "_all"},
            {className: "span-detalle", target: 11}
        ],
        rowCallback: function(row, data, index){
            $(row).css('color', SegundoColorLetra);
        }
    });

    dataTableCursosFinalizadosEstudiante.column(0).visible(false);
    dataTableCursosFinalizadosEstudiante.column(2).visible(false);
    dataTableCursosFinalizadosEstudiante.column(3).visible(false);
    dataTableCursosFinalizadosEstudiante.column(5).visible(false);
    dataTableCursosFinalizadosEstudiante.column(6).visible(false);

    let dataTableCursosNuevos;

    dataTableCursosNuevos = $("#table-cursos-nuevos").DataTable({
        pagingType: 'full_numbers',
        dom: 'frtp',
        search: {
            return: true,
        },
        scrollX: false,
        language: {
            search: "_INPUT_",
            searchPlaceholder: "Buscar algún curso...",
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
            { title: "IdCurso"},
            { title: "Curso"},
            { title: "ImagenCurso"},
            { title: "IdProfesor"},
            { title: "Profesor"},
            { title: "ImagenProfesor"},
            { title: "Temáticas"},
            { title: "Fecha de registro"},
            { title: "Puntaje"},
            { title: "Detalle"}
        ],
        columnDefs:[
            {className: "text-center fuenteNormal segundo-color-letra", targets: "_all"},
            {className: "span-detalle", target: 9}
        ],
        rowCallback: function(row, data, index){
            $(row).css('color', SegundoColorLetra);
        }
    });

    dataTableCursosNuevos.column(0).visible(false);
    dataTableCursosNuevos.column(2).visible(false);
    dataTableCursosNuevos.column(3).visible(false);
    dataTableCursosNuevos.column(5).visible(false);
    dataTableCursosNuevos.column(6).visible(false);

    document.addEventListener('DOMContentLoaded',  ObtenerInformacionInicial, false);

    async function ObtenerInformacionInicial(){
        ObtenerCursosActuales();
        ObtenerCursosFinalizados();
        ObtenerCursosNuevos();
    }

    //#region Methods

    async function ObtenerCursosActuales(){
        try{

            ShowPreloader();

            let response = await axios({
                url: '/cursos/obtener',
                baseURL: BaseURL,
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': document.head.querySelector("[name~=csrf-token][content]").content
                },
                data: {
                    "IdEstatusUsuario": 1
                }
            });

            HidePreloader();

            let result = response.data;

            switch (result.code) {
                case 200:{
                    let filas = result.data;

                    dataTableCursosActualesEstudiante.destroy();

                    dataTableCursosActualesEstudiante = $("#table-cursos-actuales-estudiante").DataTable({
                        pagingType: 'full_numbers',
                        dom: 'frtp',
                        search: {
                            return: true,
                        },
                        scrollX: false,
                        language: {
                            search: "_INPUT_",
                            searchPlaceholder: "Buscar algún curso...",
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
                            { data: "idCurso", title: "IdCurso"},
                            { data: "curso", title: "Curso"},
                            { data: "imagenCurso", title: "ImagenCurso"},
                            { data: "idProfesor", title: "IdProfesor"},
                            { data: "profesor", title: "Profesor"},
                            { data: "imagenProfesor", title: "ImagenProfesor"},
                            { data: "listaTematicas", title: "Temáticas"},
                            { data: "fechaRegistro", title: "Fecha de registro"},
                            { data: "puntaje", title: "Puntaje"},
                            { data: "fechaIngreso", title: "Fecha de ingreso"},
                            { data: "estatus", title: "Estatus"},
                            { data: "", title: "Detalle"}
                        ],
                        columnDefs:[
                            {className: "text-center fuenteNormal segundo-color-letra", defaultContent: "-", targets: "_all"},
                            {className: "span-detalle", target: 11},
                            {className: "info-curso", target: 1},
                            {className: "info-profesor", target: 4},
                            {className: "fechaRegistro", target: 7},
                            {className: "fechaIngreso", target: 9},
                        ],
                        data: filas,
                        createdRow: (row, data) => {
                            $('.segundo-color-letra',row).css('color', SegundoColorLetra);
                            $('.span-detalle', row).html('<span class="fuenteNormal span-detalle text-center text-decoration-underline" onclick="DetalleCurso('.concat(data.idCurso,',',false,')">Ver detalle</span>'));
                            $('.info-curso', row).html('<div class="container"><div class="row"><div class="col-5"><img class="img-fluid" alt="Imagen del curso" src="'.concat(data.imagenCurso,'"/></div><div class="col-7 p-0"><p class="fuenteNormal">',data.nombreCurso,'</p></div></div></div>'));
                            $('.info-profesor', row).html('<div class="container"><div class="row"><div class="col-5"><img class="img-fluid" alt="Imagen del profesor" src="'.concat(data.imagenProfesor,'"/></div><div class="col-7 p-0"><p class="fuenteNormal">',data.profesor,'</p></div></div></div>'));
                            
                            let fechaRegistro = data.fechaRegistro.substring(0, data.fechaRegistro.length -1 );
                            $('.fechaRegistro', row).text(dayjs(fechaRegistro).format('dddd DD MMM YYYY h:mm A'));

                            let fechaIngreso = dayjs(data.fechaIngreso?.substring(0,data.fechaIngreso?.length-1));
                            if(fechaIngreso.isValid()){
                                $('.fechaIngreso', row).text(fechaIngreso.format('LLLL'));
                            }
                        }
                    });
                
                    dataTableCursosActualesEstudiante.column(0).visible(false);
                    dataTableCursosActualesEstudiante.column(2).visible(false);
                    dataTableCursosActualesEstudiante.column(3).visible(false);
                    dataTableCursosActualesEstudiante.column(5).visible(false);
                    dataTableCursosActualesEstudiante.column(6).visible(false);

                }
                break;
                case 500:{
                    dataTableCursosActualesEstudiante.clear().draw();
                    Swal.fire({
                        title: '¡Error!',
                        text: result.data,
                        imageUrl: window.SadOwl,
                        imageWidth: 100,
                        imageHeight: 123,
                        background: '#000000',
                        color: '#FFFFFF',
                        imageAlt: 'Error Image'
                    });
                }
                break;
                default:{
                    dataTableCursosActualesEstudiante.clear().draw();
                    Swal.fire({
                        title: '¡Alerta!',
                        text: result.data,
                        imageUrl: window.IndifferentOwl,
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
            dataTableCursosActualesEstudiante.clear().draw();
            Swal.fire({
                title: '¡Error!',
                text: ex,
                imageUrl: window.SadOwl,
                imageWidth: 100,
                imageHeight: 123,
                background: '#000000',
                color: '#FFFFFF',
                imageAlt: 'Error Image'
            });
        }
    }

    async function ObtenerCursosFinalizados(){
        try{

            ShowPreloader();

            let response = await axios({
                url: '/cursos/obtener',
                baseURL: BaseURL,
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': document.head.querySelector("[name~=csrf-token][content]").content
                },
                data: {
                    "IdEstatusUsuario": 2
                }
            });

            HidePreloader();

            let result = response.data;

            switch (result.code) {
                case 200:{
                    let filas = result.data;

                    dataTableCursosFinalizadosEstudiante.destroy();

                    dataTableCursosFinalizadosEstudiante = $("#table-cursos-finalizados-estudiante").DataTable({
                        pagingType: 'full_numbers',
                        dom: 'frtp',
                        search: {
                            return: true,
                        },
                        scrollX: false,
                        language: {
                            search: "_INPUT_",
                            searchPlaceholder: "Buscar algún curso...",
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
                            { data: "idCurso", title: "IdCurso"},
                            { data: "curso", title: "Curso"},
                            { data: "imagenCurso", title: "ImagenCurso"},
                            { data: "idProfesor", title: "IdProfesor"},
                            { data: "profesor", title: "Profesor"},
                            { data: "imagenProfesor", title: "ImagenProfesor"},
                            { data: "listaTematicas", title: "Temáticas"},
                            { data: "fechaRegistro", title: "Fecha de registro"},
                            { data: "puntaje", title: "Puntaje"},
                            { data: "fechaIngreso", title: "Fecha de ingreso"},
                            { data: "estatus", title: "Estatus"},
                            { data: "", title: "Detalle"}
                        ],
                        columnDefs:[
                            {className: "text-center fuenteNormal segundo-color-letra", defaultContent: "-", targets: "_all"},
                            {className: "span-detalle", target: 11},
                            {className: "info-curso", target: 1},
                            {className: "info-profesor", target: 4},
                            {className: "fechaRegistro", target: 7},
                            {className: "fechaIngreso", target: 9},
                        ],
                        data: filas,
                        createdRow: (row, data) => {
                            $('.segundo-color-letra',row).css('color', SegundoColorLetra);
                            $('.span-detalle', row).html('<span class="fuenteNormal span-detalle text-center text-decoration-underline" onclick="DetalleCurso('.concat(data.idCurso,',',false,')">Ver detalle</span>'));
                            $('.info-curso', row).html('<div class="container"><div class="row"><div class="col-5"><img class="img-fluid" alt="Imagen del curso" src="'.concat(data.imagenCurso,'"/></div><div class="col-7 p-0"><p class="fuenteNormal">',data.nombreCurso,'</p></div></div></div>'));
                            $('.info-profesor', row).html('<div class="container"><div class="row"><div class="col-5"><img class="img-fluid" alt="Imagen del profesor" src="'.concat(data.imagenProfesor,'"/></div><div class="col-7 p-0"><p class="fuenteNormal">',data.profesor,'</p></div></div></div>'));
                            
                            let fechaRegistro = data.fechaRegistro.substring(0, data.fechaRegistro.length -1 );
                            $('.fechaRegistro', row).text(dayjs(fechaRegistro).format('dddd DD MMM YYYY h:mm A'));

                            let fechaIngreso = dayjs(data.fechaIngreso?.substring(0,data.fechaIngreso?.length-1));
                            if(fechaIngreso.isValid()){
                                $('.fechaIngreso', row).text(fechaIngreso.format('LLLL'));
                            }
                        }
                    });
                
                    dataTableCursosFinalizadosEstudiante.column(0).visible(false);
                    dataTableCursosFinalizadosEstudiante.column(2).visible(false);
                    dataTableCursosFinalizadosEstudiante.column(3).visible(false);
                    dataTableCursosFinalizadosEstudiante.column(5).visible(false);
                    dataTableCursosFinalizadosEstudiante.column(6).visible(false);

                }
                break;
                case 500:{
                    dataTableCursosFinalizadosEstudiante.clear().draw();
                    Swal.fire({
                        title: '¡Error!',
                        text: result.data,
                        imageUrl: window.SadOwl,
                        imageWidth: 100,
                        imageHeight: 123,
                        background: '#000000',
                        color: '#FFFFFF',
                        imageAlt: 'Error Image'
                    });
                }
                break;
                default:{
                    dataTableCursosFinalizadosEstudiante.clear().draw();
                    Swal.fire({
                        title: '¡Alerta!',
                        text: result.data,
                        imageUrl: window.IndifferentOwl,
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
            dataTableCursosFinalizadosEstudiante.clear().draw();
            Swal.fire({
                title: '¡Error!',
                text: ex,
                imageUrl: window.SadOwl,
                imageWidth: 100,
                imageHeight: 123,
                background: '#000000',
                color: '#FFFFFF',
                imageAlt: 'Error Image'
            });
        }
    }
  
    async function ObtenerCursosNuevos(){
        try{

            ShowPreloader();

            let response = await axios({
                url: '/cursos/nuevoobtener',
                baseURL: BaseURL,
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': document.head.querySelector("[name~=csrf-token][content]").content
                },
                data: {
                    "NumeroResultados": 999
                }
            });

            HidePreloader();

            let result = response.data;

            switch (result.code) {
                case 200:{
                    let filas = result.data;

                    dataTableCursosNuevos.destroy();

                    dataTableCursosNuevos = $("#table-cursos-nuevos").DataTable({
                        pagingType: 'full_numbers',
                        dom: 'frtp',
                        search: {
                            return: true,
                        },
                        scrollX: false,
                        language: {
                            search: "_INPUT_",
                            searchPlaceholder: "Buscar algún curso...",
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
                            { data: "idCurso", title: "IdCurso"},
                            { data: "curso", title: "Curso"},
                            { data: "imagenCurso", title: "ImagenCurso"},
                            { data: "idProfesor", title: "IdProfesor"},
                            { data: "profesor", title: "Profesor"},
                            { data: "imagenProfesor", title: "ImagenProfesor"},
                            { data: "listaTematicas", title: "Temáticas"},
                            { data: "fechaRegistro", title: "Fecha de registro"},
                            { data: "puntaje", title: "Puntaje"},
                            { data: "", title: "Detalle"}
                        ],
                        columnDefs:[
                            {className: "text-center fuenteNormal segundo-color-letra", defaultContent: "-", targets: "_all"},
                            {className: "span-detalle", target: 9},
                            {className: "info-curso", target: 1},
                            {className: "info-profesor", target: 4},
                            {className: "fechaRegistro", target: 7},
                        ],
                        data: filas,
                        createdRow: (row, data) => {
                            $('.segundo-color-letra',row).css('color', SegundoColorLetra);
                            $('.span-detalle', row).html('<span class="fuenteNormal span-detalle text-center text-decoration-underline" onclick="DetalleCurso('.concat(data.idCurso,',',true,')">Ver detalle</span>'));
                            $('.info-curso', row).html('<div class="container"><div class="row"><div class="col-5"><img class="img-fluid" alt="Imagen del curso" src="'.concat(data.imagenCurso,'"/></div><div class="col-7 p-0"><p class="fuenteNormal">',data.nombreCurso,'</p></div></div></div>'));
                            $('.info-profesor', row).html('<div class="container"><div class="row"><div class="col-5"><img class="img-fluid" alt="Imagen del profesor" src="'.concat(data.imagenProfesor,'"/></div><div class="col-7 p-0"><p class="fuenteNormal">',data.profesor,'</p></div></div></div>'));
                            
                            let fechaRegistro = data.fechaRegistro.substring(0, data.fechaRegistro.length -1 );
                            $('.fechaRegistro', row).text(dayjs(fechaRegistro).format('dddd DD MMM YYYY h:mm A'));

                        }
                    });
                
                    dataTableCursosNuevos.column(0).visible(false);
                    dataTableCursosNuevos.column(2).visible(false);
                    dataTableCursosNuevos.column(3).visible(false);
                    dataTableCursosNuevos.column(5).visible(false);
                    dataTableCursosNuevos.column(6).visible(false);

                }
                break;
                case 500:{
                    dataTableCursosNuevos.clear().draw();
                    Swal.fire({
                        title: '¡Error!',
                        text: result.data,
                        imageUrl: window.SadOwl,
                        imageWidth: 100,
                        imageHeight: 123,
                        background: '#000000',
                        color: '#FFFFFF',
                        imageAlt: 'Error Image'
                    });
                }
                break;
                default:{
                    dataTableCursosNuevos.clear().draw();
                    Swal.fire({
                        title: '¡Alerta!',
                        text: result.data,
                        imageUrl: window.IndifferentOwl,
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
            dataTableCursosNuevos.clear().draw();
            Swal.fire({
                title: '¡Error!',
                text: ex,
                imageUrl: window.SadOwl,
                imageWidth: 100,
                imageHeight: 123,
                background: '#000000',
                color: '#FFFFFF',
                imageAlt: 'Error Image'
            });
        }
    }

    document.DetalleCurso = async function(IdCurso, NuevoCurso){
       
        ShowPreloader();

        if(NuevoCurso){

            $('<form/>', { action: '/cursos/detalle', method: 'POST' }).append(
                $('<input>', {type: 'hidden', id: '_token', name: '_token', value: document.head.querySelector("[name~=csrf-token][content]").content}),
                $('<input>', {type: 'hidden', id: 'IdCurso', name: 'IdCurso', value: IdCurso})
            ).appendTo('body').submit();
                
            HidePreloader();

        }else{

            $('<form/>', { action: '/cursos/detalleestudiante', method: 'POST' }).append(
                $('<input>', {type: 'hidden', id: '_token', name: '_token', value: document.head.querySelector("[name~=csrf-token][content]").content}),
                $('<input>', {type: 'hidden', id: 'IdCurso', name: 'IdCurso', value: IdCurso})
            ).appendTo('body').submit();
                
            HidePreloader();
        }
           

    }

}else{
    
    let dataTableCursosActualesProfesor;

    dataTableCursosActualesProfesor = $("#table-cursos-actuales-profesor").DataTable({
        pagingType: 'full_numbers',
        dom: 'frtp',
        search: {
            return: true,
        },
        scrollX: false,
        language: {
            search: "_INPUT_",
            searchPlaceholder: "Buscar algún curso...",
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
            { title: "IdCurso"},
            { title: "Curso"},
            { title: "ImagenCurso"},
            { title: "Temáticas"},
            { title: "Estatus"},
            { title: "Fecha de registro"},
            { title: "Puntaje"},
            { title: "Detalle"}
        ],
        columnDefs:[
            {className: "text-center fuenteNormal segundo-color-letra", targets: "_all"},
            {className: "span-detalle", target: 7}
        ],
        rowCallback: function(row, data, index){
            $(row).css('color', SegundoColorLetra);
        }
    });

    dataTableCursosActualesProfesor.column(0).visible(false);
    dataTableCursosActualesProfesor.column(2).visible(false);
    dataTableCursosActualesProfesor.column(3).visible(false);


    let dataTableCursosFinalizadosProfesor;

    dataTableCursosFinalizadosProfesor = $("#table-cursos-finalizados-profesor").DataTable({
        pagingType: 'full_numbers',
        dom: 'frtp',
        search: {
            return: true,
        },
        scrollX: false,
        language: {
            search: "_INPUT_",
            searchPlaceholder: "Buscar algún curso...",
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
            { title: "IdCurso"},
            { title: "Curso"},
            { title: "ImagenCurso"},
            { title: "Temáticas"},
            { title: "Estatus"},
            { title: "Fecha de registro"},
            { title: "Puntaje"},
            { title: "Detalle"}
        ],
        columnDefs:[
            {className: "text-center fuenteNormal segundo-color-letra", targets: "_all"},
            {className: "span-detalle", target: 7}
        ],
        rowCallback: function(row, data, index){
            $(row).css('color', SegundoColorLetra);
        }
    });

    dataTableCursosFinalizadosProfesor.column(0).visible(false);
    dataTableCursosFinalizadosProfesor.column(2).visible(false);
    dataTableCursosFinalizadosProfesor.column(3).visible(false);

    document.addEventListener('DOMContentLoaded',  ObtenerInformacionInicialProfesor, false);

    async function ObtenerInformacionInicialProfesor(){
        ObtenerCursosActualesProfesor();
        ObtenerCursosFinalizadosProfesor();
    }

    //#region Methods

    async function ObtenerCursosActualesProfesor(){
        try{

            ShowPreloader();

            let response = await axios({
                url: '/cursos/profesorobtener',
                baseURL: BaseURL,
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': document.head.querySelector("[name~=csrf-token][content]").content
                },
                data: {
                    "Finalizado": false
                }
            });

            HidePreloader();

            let result = response.data;

            switch (result.code) {
                case 200:{
                    let filas = result.data;

                    dataTableCursosActualesProfesor.destroy();

                    dataTableCursosActualesProfesor = $("#table-cursos-actuales-profesor").DataTable({
                        pagingType: 'full_numbers',
                        dom: 'frtp',
                        search: {
                            return: true,
                        },
                        scrollX: false,
                        language: {
                            search: "_INPUT_",
                            searchPlaceholder: "Buscar algún curso...",
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
                            { data: "idCurso", title: "IdCurso"},
                            { data: "curso", title: "Curso"},
                            { data: "imagenCurso", title: "ImagenCurso"},
                            { data: "listaTematicas", title: "Temáticas"},
                            { data: "estatus", title: "Estatus"},
                            { data: "fechaRegistro", title: "Fecha de registro"},
                            { data: "puntaje", title: "Puntaje"},
                            { data: "", title: "Detalle"}
                        ],
                        columnDefs:[
                            {className: "text-center fuenteNormal segundo-color-letra", defaultContent: "-", targets: "_all"},
                            {className: "span-detalle", target: 7},
                            {className: "info-curso", target: 1},
                            {className: "fechaRegistro", target: 5},
                        ],
                        data: filas,
                        createdRow: (row, data) => {
                            $('.segundo-color-letra',row).css('color', SegundoColorLetra);
                            $('.span-detalle', row).html('<span class="fuenteNormal span-detalle text-center text-decoration-underline" onclick="DetalleCursoProfesor('.concat(data.idCurso,')">Ver detalle</span>'));
                            $('.info-curso', row).html('<div class="container"><div class="row"><div class="col-5"><img class="img-fluid" alt="Imagen del curso" src="'.concat(data.imagenCurso,'"/></div><div class="col-7 p-0"><p class="fuenteNormal">',data.nombreCurso,'</p></div></div></div>'));
                            
                            
                            let fechaRegistro = data.fechaRegistro.substring(0, data.fechaRegistro.length -1 );
                            $('.fechaRegistro', row).text(dayjs(fechaRegistro).format('dddd DD MMM YYYY h:mm A'));
                        }
                    });
                
                    dataTableCursosActualesProfesor.column(0).visible(false);
                    dataTableCursosActualesProfesor.column(2).visible(false);
                    dataTableCursosActualesProfesor.column(3).visible(false);

                }
                break;
                case 500:{
                    dataTableCursosActualesProfesor.clear().draw();
                    Swal.fire({
                        title: '¡Error!',
                        text: result.data,
                        imageUrl: window.SadOwl,
                        imageWidth: 100,
                        imageHeight: 123,
                        background: '#000000',
                        color: '#FFFFFF',
                        imageAlt: 'Error Image'
                    });
                }
                break;
                default:{
                    dataTableCursosActualesProfesor.clear().draw();
                    Swal.fire({
                        title: '¡Alerta!',
                        text: result.data,
                        imageUrl: window.IndifferentOwl,
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
            dataTableCursosActualesProfesor.clear().draw();
            Swal.fire({
                title: '¡Error!',
                text: ex,
                imageUrl: window.SadOwl,
                imageWidth: 100,
                imageHeight: 123,
                background: '#000000',
                color: '#FFFFFF',
                imageAlt: 'Error Image'
            });
        }
    }

    async function ObtenerCursosFinalizadosProfesor(){
        try{

            ShowPreloader();

            let response = await axios({
                url: '/cursos/profesorobtener',
                baseURL: BaseURL,
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': document.head.querySelector("[name~=csrf-token][content]").content
                },
                data: {
                    "Finalizado": true
                }
            });

            HidePreloader();

            let result = response.data;

            switch (result.code) {
                case 200:{
                    let filas = result.data;

                    dataTableCursosFinalizadosProfesor.destroy();

                    dataTableCursosFinalizadosProfesor = $("#table-cursos-finalizados-profesor").DataTable({
                        pagingType: 'full_numbers',
                        dom: 'frtp',
                        search: {
                            return: true,
                        },
                        scrollX: false,
                        language: {
                            search: "_INPUT_",
                            searchPlaceholder: "Buscar algún curso...",
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
                            { data: "idCurso", title: "IdCurso"},
                            { data: "curso", title: "Curso"},
                            { data: "imagenCurso", title: "ImagenCurso"},
                            { data: "listaTematicas", title: "Temáticas"},
                            { data: "estatus", title: "Estatus"},
                            { data: "fechaRegistro", title: "Fecha de registro"},
                            { data: "puntaje", title: "Puntaje"},
                            { data: "", title: "Detalle"}
                        ],
                        columnDefs:[
                            {className: "text-center fuenteNormal segundo-color-letra", defaultContent: "-", targets: "_all"},
                            {className: "span-detalle", target: 7},
                            {className: "info-curso", target: 1},
                            {className: "fechaRegistro", target: 5},
                        ],
                        data: filas,
                        createdRow: (row, data) => {
                            $('.segundo-color-letra',row).css('color', SegundoColorLetra);
                            $('.span-detalle', row).html('<span class="fuenteNormal span-detalle text-center text-decoration-underline" onclick="DetalleCursoProfesor('.concat(data.idCurso,')">Ver detalle</span>'));
                            $('.info-curso', row).html('<div class="container"><div class="row"><div class="col-5"><img class="img-fluid" alt="Imagen del curso" src="'.concat(data.imagenCurso,'"/></div><div class="col-7 p-0"><p class="fuenteNormal">',data.nombreCurso,'</p></div></div></div>'));
                            
                            
                            let fechaRegistro = data.fechaRegistro.substring(0, data.fechaRegistro.length -1 );
                            $('.fechaRegistro', row).text(dayjs(fechaRegistro).format('dddd DD MMM YYYY h:mm A'));
                        }
                    });
                
                    dataTableCursosFinalizadosProfesor.column(0).visible(false);
                    dataTableCursosFinalizadosProfesor.column(2).visible(false);
                    dataTableCursosFinalizadosProfesor.column(3).visible(false);

                }
                break;
                case 500:{
                    dataTableCursosFinalizadosProfesor.clear().draw();
                    Swal.fire({
                        title: '¡Error!',
                        text: result.data,
                        imageUrl: window.SadOwl,
                        imageWidth: 100,
                        imageHeight: 123,
                        background: '#000000',
                        color: '#FFFFFF',
                        imageAlt: 'Error Image'
                    });
                }
                break;
                default:{
                    dataTableCursosFinalizadosProfesor.clear().draw();
                    Swal.fire({
                        title: '¡Alerta!',
                        text: result.data,
                        imageUrl: window.IndifferentOwl,
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
            dataTableCursosFinalizadosProfesor.clear().draw();
            Swal.fire({
                title: '¡Error!',
                text: ex,
                imageUrl: window.SadOwl,
                imageWidth: 100,
                imageHeight: 123,
                background: '#000000',
                color: '#FFFFFF',
                imageAlt: 'Error Image'
            });
        }
    }
  

    document.DetalleCursoProfesor = async function(IdCurso){
        try{

            ShowPreloader();

            $('<form/>', { action: '/cursos/detalleprofesor', method: 'POST' }).append(
                $('<input>', {type: 'hidden', id: '_token', name: '_token', value: document.head.querySelector("[name~=csrf-token][content]").content}),
                $('<input>', {type: 'hidden', id: 'IdCurso', name: 'IdCurso', value: IdCurso})
            ).appendTo('body').submit();
            
            HidePreloader();

        }
        catch(ex){

            HidePreloader();
            Swal.fire({
                title: '¡Error!',
                text: ex,
                imageUrl: window.SadOwl,
                imageWidth: 100,
                imageHeight: 123,
                background: '#000000',
                color: '#FFFFFF',
                imageAlt: 'Error Image'
            });
        }
    }

    async function RegistrarCurso(base64Image, file){

        try{
    
            ShowPreloader();
    
            let formData = new FormData();
    
            formData.append("Nombre", document.getElementById("nombre-curso").value);
            formData.append("Descripcion", document.getElementById("descripcion-curso").value);
            formData.append("Imagen", file);
            formData.append("Base64Image", base64Image);
    
            let response = await axios({
                url: '/cursos/registrar',
                baseURL: BaseURL,
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': document.head.querySelector("[name~=csrf-token][content]").content
                },
                data: formData
            });
    
            HidePreloader();
    
            let resultado = response.data;
            
            switch (resultado.code) {
                case 200:{
                    Swal.fire({
                        title: 'Creación de curso',
                        text: resultado.data.mensaje,
                        imageUrl: window.HappyOwl,
                        imageWidth: 100,
                        imageHeight: 123,
                        imageAlt: 'Ok Image',
                        background: '#000000',
                        color: '#FFFFFF'
                    }).then(() => {
                        DetalleCursoProfesor(resultado.data.codigo);
                    });
                }
                break;
                case 500:{
                    Swal.fire({
                        title: '¡Error!',
                        text: resultado.data,
                        imageUrl: window.SadOwl,
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
                        imageUrl: window.IndifferentOwl,
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
                 imageUrl: window.SadOwl,
                 imageWidth: 100,
                 imageHeight: 123,
                 background: '#000000',
                 color: '#FFFFFF',
                 imageAlt: 'Error Image'
             });
         }
     }
    

    document.getElementById("form-agregar-curso").addEventListener("submit", async (e) => {

        e.preventDefault();

        let imagen_file = document.getElementById("imagen");
        let imagen_element = document.getElementById("imagen-seleccionada");
        let base64 = await GetBase64FromUrl(imagen_element.src);
        
        if(imagen_file.files.length > 0){
            RegistrarCurso(base64, imagen_file.files[0]);
        } else{
            RegistrarCurso(base64, null);
        }
    });

    document.getElementById("imagen").addEventListener("change", (e) => {

        ShowPreloader();
    
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
                document.getElementById("imagen-seleccionada").src = "https://storage.needpix.com/thumbs/blank-profile-picture-973460_1280.png";
            }
            HidePreloader();
        } catch(ex){
    
            document.getElementById("imagen-seleccionada").src = "https://storage.needpix.com/thumbs/blank-profile-picture-973460_1280.png";
    
            HidePreloader();
    
            Swal.fire({
                title: '¡Error!',
                html: ex,
                imageUrl: window.SadOwl,
                imageWidth: 100,
                imageHeight: 123,
                background: '#000000',
                color: '#FFFFFF',
                imageAlt: 'Error Image'
            });
    
        }
    });

}



//#endregion
