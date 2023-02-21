'use strict';

let idTipoUsuario = document.getElementById("id-tipo-usuario").value;
let SegundoColor = localStorage.getItem("SegundoColor");
let SegundoColorLetra = localStorage.getItem("SegundoColorLetra");
let TercerColor = localStorage.getItem("TercerColor");
let TercerColorLetra = localStorage.getItem("TercerColorLetra");
let PrimerColor = localStorage.getItem("PrimerColor");
let PrimerColorLetra = localStorage.getItem("PrimerColorLetra");
let BaseURL = window.location.origin;
let assetsRouteCursos = document.getElementById("assets-cursos").value;
let assetsRouteUsuarios = document.getElementById("assets-usuarios").value;

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
                            $('.info-curso', row).html('<div class="container"><div class="row"><div class="col-5"><img class="img-fluid" alt="Imagen del curso" src="'.concat(assetsRouteCursos,'/',data.imagenCurso,'"/></div><div class="col-7 p-0"><p class="fuenteNormal">',data.nombreCurso,'</p></div></div></div>'));
                            $('.info-profesor', row).html('<div class="container"><div class="row"><div class="col-5"><img class="img-fluid" alt="Imagen del profesor" src="'.concat(assetsRouteUsuarios,'/',data.imagenProfesor,'"/></div><div class="col-7 p-0"><p class="fuenteNormal">',data.profesor,'</p></div></div></div>'));
                            
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

                }
                break;
                case 500:{
                    dataTableCursosActualesEstudiante.clear().draw();
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
                    dataTableCursosActualesEstudiante.clear().draw();
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
            dataTableCursosActualesEstudiante.clear().draw();
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
                            $('.info-curso', row).html('<div class="container"><div class="row"><div class="col-5"><img class="img-fluid" alt="Imagen del curso" src="'.concat(assetsRouteCursos,'/',data.imagenCurso,'"/></div><div class="col-7 p-0"><p class="fuenteNormal">',data.nombreCurso,'</p></div></div></div>'));
                            $('.info-profesor', row).html('<div class="container"><div class="row"><div class="col-5"><img class="img-fluid" alt="Imagen del profesor" src="'.concat(assetsRouteUsuarios,'/',data.imagenProfesor,'"/></div><div class="col-7 p-0"><p class="fuenteNormal">',data.profesor,'</p></div></div></div>'));
                            
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

                }
                break;
                case 500:{
                    dataTableCursosFinalizadosEstudiante.clear().draw();
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
                    dataTableCursosFinalizadosEstudiante.clear().draw();
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
            dataTableCursosFinalizadosEstudiante.clear().draw();
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
                            $('.info-curso', row).html('<div class="container"><div class="row"><div class="col-5"><img class="img-fluid" alt="Imagen del curso" src="'.concat(assetsRouteCursos,'/',data.imagenCurso,'"/></div><div class="col-7 p-0"><p class="fuenteNormal">',data.nombreCurso,'</p></div></div></div>'));
                            $('.info-profesor', row).html('<div class="container"><div class="row"><div class="col-5"><img class="img-fluid" alt="Imagen del profesor" src="'.concat(assetsRouteUsuarios,'/',data.imagenProfesor,'"/></div><div class="col-7 p-0"><p class="fuenteNormal">',data.profesor,'</p></div></div></div>'));
                            
                            let fechaRegistro = data.fechaRegistro.substring(0, data.fechaRegistro.length -1 );
                            $('.fechaRegistro', row).text(dayjs(fechaRegistro).format('dddd DD MMM YYYY h:mm A'));

                        }
                    });
                
                    dataTableCursosNuevos.column(0).visible(false);
                    dataTableCursosNuevos.column(2).visible(false);
                    dataTableCursosNuevos.column(3).visible(false);
                    dataTableCursosNuevos.column(5).visible(false);

                }
                break;
                case 500:{
                    dataTableCursosNuevos.clear().draw();
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
                    dataTableCursosNuevos.clear().draw();
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
            dataTableCursosNuevos.clear().draw();
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

    document.DetalleCurso = async function(IdCurso, NuevoCurso){
        try{

            ShowPreloader();

            let formData = new FormData();

            formData.append('IdCurso', IdCurso);

            let response = await axios({
                url: '/tareas/detalle',
                baseURL: BaseURL,
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': document.head.querySelector("[name~=csrf-token][content]").content
                },
                data: formData
            });

            HidePreloader();

            let result = response.data;

            switch (result.code) {
                case 200:{
                
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
                            $('.info-curso', row).html('<div class="container"><div class="row"><div class="col-5"><img class="img-fluid" alt="Imagen del curso" src="'.concat(assetsRouteCursos,'/',data.imagenCurso,'"/></div><div class="col-7 p-0"><p class="fuenteNormal">',data.nombreCurso,'</p></div></div></div>'));
                            
                            
                            let fechaRegistro = data.fechaRegistro.substring(0, data.fechaRegistro.length -1 );
                            $('.fechaRegistro', row).text(dayjs(fechaRegistro).format('dddd DD MMM YYYY h:mm A'));
                        }
                    });
                
                    dataTableCursosActualesProfesor.column(0).visible(false);
                    dataTableCursosActualesProfesor.column(2).visible(false);

                }
                break;
                case 500:{
                    dataTableCursosActualesProfesor.clear().draw();
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
                    dataTableCursosActualesProfesor.clear().draw();
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
            dataTableCursosActualesProfesor.clear().draw();
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
                            $('.info-curso', row).html('<div class="container"><div class="row"><div class="col-5"><img class="img-fluid" alt="Imagen del curso" src="'.concat(assetsRouteCursos,'/',data.imagenCurso,'"/></div><div class="col-7 p-0"><p class="fuenteNormal">',data.nombreCurso,'</p></div></div></div>'));
                            
                            
                            let fechaRegistro = data.fechaRegistro.substring(0, data.fechaRegistro.length -1 );
                            $('.fechaRegistro', row).text(dayjs(fechaRegistro).format('dddd DD MMM YYYY h:mm A'));
                        }
                    });
                
                    dataTableCursosFinalizadosProfesor.column(0).visible(false);
                    dataTableCursosFinalizadosProfesor.column(2).visible(false);

                }
                break;
                case 500:{
                    dataTableCursosFinalizadosProfesor.clear().draw();
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
                    dataTableCursosFinalizadosProfesor.clear().draw();
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
            dataTableCursosFinalizadosProfesor.clear().draw();
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
  

    document.DetalleCursoProfesor = async function(IdCurso){
        try{

            ShowPreloader();

            let formData = new FormData();

            formData.append('IdCurso', IdCurso);

            let response = await axios({
                url: '/tareas/detalle',
                baseURL: BaseURL,
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': document.head.querySelector("[name~=csrf-token][content]").content
                },
                data: formData
            });

            HidePreloader();

            let result = response.data;

            switch (result.code) {
                case 200:{
                
                }
                break;
                case 500:{
                    dataTableCursosActualesEstudiante.clear().draw();
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
                    dataTableCursosActualesEstudiante.clear().draw();
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
            dataTableCursosActualesEstudiante.clear().draw();
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

    document.getElementById("crear-curso").addEventListener("click", async () => {

    });
}



//#endregion
