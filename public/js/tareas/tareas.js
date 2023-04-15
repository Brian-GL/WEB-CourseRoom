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

    let dataTableMisTareas;

    dataTableMisTareas = $("#table-mis-tareas").DataTable({
        pagingType: 'full_numbers',
        dom: 'frtp',
        search: {
            return: true,
        },
        scrollX: false,
        language: {
            search: "_INPUT_",
            searchPlaceholder: "Buscar alguna tarea...",
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
            { title: "Id Tarea"},
            { title: "Nombre"},
            { title: "Id Curso"},
            { title: "Curso"},
            { title: "Imagen del curso"},
            { title: "Fecha de registro"},
            { title: "Fecha de entrega"},
            { title: "Fecha de entregada"},
            { title: "Puntualidad"},
            { title: "Calificación"},
            { title: "Fecha de calificación"},
            { title: "Estatus"},
            { title: "Detalle"}
        ],
        columnDefs:[
            {className: "text-center fuenteNormal segundo-color-letra", targets: "_all"},
            {className: "span-detalle", target: [12]}
        ],
        rowCallback: function(row, data, index){
            $(row).css('color', SegundoColorLetra);
        }
    });

    dataTableMisTareas.column(0).visible(false);
    dataTableMisTareas.column(2).visible(false);
    dataTableMisTareas.column(4).visible(false);

    document.addEventListener('DOMContentLoaded',  ObtenerInformacionInicial, false);

    async function ObtenerInformacionInicial(){
        ObtenerMisTareas();
        ObtenerTareasMes();
    }

    //#region Methods

    async function ObtenerMisTareas(){
        try{

            ShowPreloader();

            let response = await axios({
                url: '/tareas/estudiante',
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

                    dataTableMisTareas.destroy();

                    dataTableMisTareas = $("#table-mis-tareas").DataTable({
                        pagingType: 'full_numbers',
                        dom: 'frtp',
                        search: {
                            return: true,
                        },
                        scrollX: false,
                        language: {
                            search: "_INPUT_",
                            searchPlaceholder: "Buscar alguna tarea...",
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
                            { data: "idTarea", title: "Id Tarea"},
                            { data: "nombre", title: "Nombre"},
                            { data: "idCurso", title: "Id Curso"},
                            { data: "nombreCurso", title: "Curso"},
                            { data: "imagenCurso", title: "Imagen del curso"},
                            { data: "fechaRegistro", title: "Fecha de registro"},
                            { data: "fechaEntrega", title: "Fecha de entrega"},
                            { data: "fechaEntregada", title: "Fecha de entregada"},
                            { data: "puntualidad", title: "Puntualidad"},
                            { data: "calificacion", title: "Calificación"},
                            { data: "fechaCalificacion", title: "Fecha de calificación"},
                            { data: "estatus", title: "Estatus"},
                            { data: "", title: "Detalle"}
                        ],
                        columnDefs:[
                            {className: "text-center fuenteNormal segundo-color-letra", defaultContent: "-", targets: "_all"},
                            {className: "span-detalle", target: 12},
                            {className: "info-curso", target: 3},
                            {className: "fechaRegistro", target: 5},
                            {className: "fechaEntrega", target: 6},
                            {className: "fechaEntregada", target: 7},
                            {className: "fechaCalificacion", target: 10},
                        ],
                        data: filas,
                        createdRow: (row, data) => {
                            $('.segundo-color-letra',row).css('color', SegundoColorLetra);
                            $('.span-detalle', row).html('<span class="fuenteNormal span-detalle text-center text-decoration-underline" onclick="DetalleTareaEstudiante('.concat(data.idTarea,')">Ver detalle</span>'));
                            $('.info-curso', row).html('<div class="container"><div class="row"><div class="col-5"><img class="img-fluid" alt="Imagen del curso" src="'.concat(data.imagenCurso,'"/></div><div class="col-7 p-0"><p class="fuenteNormal">',data.nombreCurso,'</p></div></div></div>'));
                            
                            let fechaRegistro = data.fechaRegistro.substring(0, data.fechaRegistro.length -1 );
                            $('.fechaRegistro', row).text(dayjs(fechaRegistro).format('dddd DD MMM YYYY h:mm A'));

                            let fechaEntrega = dayjs(data.fechaEntrega?.substring(0,data.fechaEntrega?.length-1));
                            if(fechaEntrega.isValid()){
                                $('.fechaEntrega', row).text(fechaEntrega.format('LLLL'));
                            }

                            if(data.fechaEntregada != null){
                                let fechaEntregada = dayjs(data.fechaEntregada?.substring(0,data.fechaEntregada?.length-1));
                                if(fechaEntregada.isValid()){
                                    $('.fechaEntregada', row).text(fechaEntregada.format('LLLL'));
                                }
                            }

                            if(data.fechaCalificacion != null){
                                let fechaCalificacion = dayjs(data.fechaCalificacion?.substring(0,data.fechaCalificacion?.length-1));
                                if(fechaCalificacion.isValid()){
                                    $('.fechaCalificacion', row).text(fechaCalificacion.format('LLLL'));
                                }
                            }
                            
                        }
                    });

                    dataTableMisTareas.column(0).visible(false);
                    dataTableMisTareas.column(2).visible(false);
                    dataTableMisTareas.column(4).visible(false);

                }
                break;
                case 500:{
                    dataTableMisTareas.clear().draw();
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
                    dataTableMisTareas.clear().draw();
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
            dataTableMisTareas.clear().draw();
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

    async function ObtenerTareasMes(){
       
        try{

            ShowPreloader();

            let response = await axios({
                url: '/tareas/delmes',
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
                    let eventos = [];
                    let fechaEntregaEnd;
                    let fechaEntrega;

                    for(let data of filas)
                    {
                        if(data.fechaEntrega !== null && data.fechaEntrega !== undefined && data.fechaEntrega !== ''){
                            fechaEntrega = dayjs(data.fechaEntrega.substring(0, data.fechaEntrega.length -1 ));
                            fechaEntregaEnd = fechaEntrega.toDate();

                            eventos.push(
                                {
                                    id: data.idTarea,
                                    allDay: false,
                                    title: data.nombre,
                                    color: PrimerColor,
                                    backgroundColor: PrimerColor,
                                    editable: false,
                                    start:fechaEntregaEnd,
                                    end: fechaEntregaEnd
                                }
                            );
                        }
                    }

                    let calendar =  new window.Calendar({
                        target: document.getElementById('tareas-calendario'),
                        props: {
                            plugins: [window.DayGrid],
                            options: {
                                view: 'dayGridMonth',
                                events: eventos,
                                height: '90%',
                                eventClick: (event) => {
                                    document.DetalleTareaEstudiante(event.event.id);
                                },
                                eventMouseEnter: (eventInfo) => {
                                    eventInfo.el.style.setProperty('color',SegundoColorLetra,'important');
                                    eventInfo.el.style.setProperty('background-color',SegundoColor,'important');
                                    eventInfo.event.color = SegundoColor;
                                    eventInfo.event.backgroundColor = SegundoColor;
                                },
                                eventMouseLeave: (eventInfo) => {
                                    eventInfo.el.style.setProperty('color',PrimerColorLetra,'important');
                                    eventInfo.el.style.setProperty('background-color',PrimerColor,'important');
                                    eventInfo.event.color = PrimerColor;
                                    eventInfo.event.backgroundColor = PrimerColor;
                                }
                            }
                        }
                    });
    
                    let ec_heads = document.getElementsByClassName('ec-day-head');
                    for(let elemento of ec_heads){
                        elemento.style.setProperty('color',TercerColorLetra,'important');
                    }

                    ec_heads = document.getElementsByClassName('ec-title');
                    for(let elemento of ec_heads){
                        elemento.style.setProperty('color',TercerColorLetra,'important');
                    }
                }
                break;
                case 500:{
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
                default:
                    {
                        let calendar =  new window.Calendar({
                            target: document.getElementById('tareas-calendario'),
                            props: {
                                plugins: [window.DayGrid],
                                options: {
                                    view: 'dayGridMonth'
                                }
                            }
                        });

                        let ec_heads = document.getElementsByClassName('ec-day-head');
                        for(let elemento of ec_heads){
                            elemento.style.setProperty('color',TercerColorLetra,'important');
                        }
    
                        ec_heads = document.getElementsByClassName('ec-title');
                        for(let elemento of ec_heads){
                            elemento.style.setProperty('color',TercerColorLetra,'important');
                        }
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

    document.DetalleTareaEstudiante = async function(IdTarea){

        try{

            ShowPreloader();

            $('<form/>', { action: '/tareas/estudiantedetalle', method: 'POST' }).append(
                $('<input>', {type: 'hidden', id: '_token', name: '_token', value: document.head.querySelector("[name~=csrf-token][content]").content}),
                $('<input>', {type: 'hidden', id: 'IdTarea', name: 'IdTarea', value: IdTarea})
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

}else{
    //eres profesor

    let dataTableTareasCalificar, dataTableTareasCreadas;

    dataTableTareasCalificar = $("#table-tareas-calificar").DataTable({
        pagingType: 'full_numbers',
        dom: 'frtp',
        search: {
            return: true,
        },
        scrollX: false,
        language: {
            search: "_INPUT_",
            searchPlaceholder: "Buscar alguna tarea...",
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
            { title: "Id Tarea"},
            { title: "Nombre"},
            { title: "Id Curso"},
            { title: "Curso"},
            { title: "Imagen del curso"},
            { title: "Id Usuario"},
            { title: "Estudiante"},
            { title: "ImagenEstudiante"},
            { title: "Fecha de registro"},
            { title: "Fecha de entrega"},
            { title: "Entregada el día"},
            { title: "Estatus"},
            { title: "Detalle"}
        ],
        columnDefs:[
            {className: "text-center fuenteNormal segundo-color-letra", targets: "_all"},
            {className: "span-detalle", target: [12]}
        ],
        rowCallback: function(row, data, index){
            $(row).css('color', SegundoColorLetra);
        }
    });

    dataTableTareasCalificar.column(0).visible(false);
    dataTableTareasCalificar.column(2).visible(false);
    dataTableTareasCalificar.column(4).visible(false);
    dataTableTareasCalificar.column(5).visible(false);
    dataTableTareasCalificar.column(7).visible(false);

    dataTableTareasCreadas = $("#table-mis-tareas-creadas").DataTable({
        pagingType: 'full_numbers',
        dom: 'frtp',
        search: {
            return: true,
        },
        scrollX: false,
        language: {
            search: "_INPUT_",
            searchPlaceholder: "Buscar alguna tarea...",
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
            { title: "IdTarea"},
            { title: "Nombre"},
            { title: "IdCurso"},
            { title: "Curso"},
            { title: "ImagenCurso"},
            { title: "Fecha de registro"},
            { title: "Fecha de entrega"},
            { title: "Estatus"},
            { title: "Detalle"}
        ],
        columnDefs:[
            {className: "text-center fuenteNormal segundo-color-letra", targets: "_all"},
            {className: "span-detalle", target: 8}
        ],
        rowCallback: function(row, data, index){
            $(row).css('color', SegundoColorLetra);
        }
    });

    dataTableTareasCreadas.column(0).visible(false);
    dataTableTareasCreadas.column(2).visible(false);
    dataTableTareasCreadas.column(4).visible(false);

    document.addEventListener('DOMContentLoaded',  ObtenerInformacionInicial, false);

    async function ObtenerInformacionInicial(){
        ObtenerTareasCalificar();
        ObtenerTareasCreadas();
    }

    async function ObtenerTareasCalificar(){
        try{

            ShowPreloader();

            let response = await axios({
                url: 'tareas/calificarobtener',
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

                    dataTableTareasCalificar.destroy();

                    dataTableTareasCalificar = $("#table-tareas-calificar").DataTable({
                        pagingType: 'full_numbers',
                        dom: 'frtp',
                        search: {
                            return: true,
                        },
                        scrollX: false,
                        language: {
                            search: "_INPUT_",
                            searchPlaceholder: "Buscar alguna tarea...",
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
                            { data: "idTarea", title: "IdTarea"},
                            { data: "nombre", title: "Nombre"},
                            { data: "idCurso", title: "IdCurso"},
                            { data: "nombreCurso", title: "Curso"},
                            { data: "imagenCurso", title: "ImagenCurso"},
                            { data: "idUsuario", title: "IdUsuario"},
                            { data: "nombreEstudiante", title: "Estudiante"},
                            { data: "imagenEstudiante", title: "ImagenEstudiante"},
                            { data: "fechaRegistro", title: "Fecha de registro"},
                            { data: "fechaEntrega", title: "Fecha de entrega"},
                            { data: "fechaEntregada", title: "Entregada el día"},
                            { data: "estatus", title: "Estatus"},
                            { data: "", title: "Detalle"}
                        ],
                        columnDefs:[
                            {className: "text-center fuenteNormal segundo-color-letra", defaultContent: "-", targets: "_all"},
                            {className: "span-detalle", target: 12},
                            {className: "info-curso", target: 3},
                            {className: "info-usuario", target: 6},
                            {className: "fechaRegistro", target: 8},
                            {className: "fechaEntrega", target: 9},
                            {className: "fechaEntregada", target: 10},
                        ],
                        data: filas,
                        createdRow: (row, data) => {
                            $('.segundo-color-letra',row).css('color', SegundoColorLetra);
                            $('.span-detalle', row).html('<span class="fuenteNormal span-detalle text-center text-decoration-underline" onclick="DetalleTareaProfesor('.concat(data.idTarea,',',idUsuario,')">Ver detalle</span>'));
                            $('.info-curso', row).html('<div class="container"><div class="row"><div class="col-5"><img class="img-fluid" alt="Imagen del curso" src="'.concat(data.imagenCurso,'"/></div><div class="col-7 p-0"><p class="fuenteNormal">',data.nombreCurso,'</p></div></div></div>'));
                            $('.info-usuario', row).html('<div class="container"><div class="row"><div class="col-5"><img class="img-fluid" alt="Imagen del usuario" src="'.concat(data.imagenEstudiante,'"/></div><div class="col-7 p-0"><p class="fuenteNormal">',data.nombreEstudiante,'</p></div></div></div>'));
                            let fechaRegistro = data.fechaRegistro.substring(0, data.fechaRegistro.length -1 );
                            $('.fechaRegistro', row).text(dayjs(fechaRegistro).format('dddd DD MMM YYYY h:mm A'));

                            let fechaEntrega = dayjs(data.fechaEntrega?.substring(0,data.fechaEntrega?.length-1));
                            if(fechaEntrega.isValid()){
                                $('.fechaEntrega', row).text(fechaEntrega.format('LLLL'));
                            }

                            let fechaEntregada = dayjs(data.fechaEntregada?.substring(0,data.fechaEntregada?.length-1));
                            if(fechaEntregada.isValid()){
                                $('.fechaEntregada', row).text(fechaEntregada.format('LLLL'));
                            }
                        }
                    });

                    dataTableTareasCalificar.column(0).visible(false);
                    dataTableTareasCalificar.column(2).visible(false);
                    dataTableTareasCalificar.column(4).visible(false);
                    dataTableTareasCalificar.column(5).visible(false);
                    dataTableTareasCalificar.column(7).visible(false);
                }
                break;
                case 500:{
                    dataTableTareasCalificar.clear().draw();
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
                    dataTableTareasCalificar.clear().draw();
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
            dataTableTareasCalificar.clear().draw();
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

    async function ObtenerTareasCreadas(){
        try{

            ShowPreloader();

            let response = await axios({
                url: '/tareas/creadasprofesor',
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

                    dataTableTareasCreadas.destroy();

                    dataTableTareasCreadas = $("#table-mis-tareas-creadas").DataTable({
                        pagingType: 'full_numbers',
                        dom: 'frtp',
                        search: {
                            return: true,
                        },
                        scrollX: false,
                        language: {
                            search: "_INPUT_",
                            searchPlaceholder: "Buscar alguna tarea...",
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
                            { data: "idTarea", title: "IdTarea"},
                            { data: "nombre", title: "Nombre"},
                            { data: "idCurso", title: "IdCurso"},
                            { data: "nombreCurso", title: "NombreCurso"},
                            { data: "imagenCurso", title: "ImagenCurso"},
                            { data: "fechaRegistro", title: "FechaRegistro"},
                            { data: "fechaEntrega", title: "FechaEntrega"},
                            { data: "estatus", title: "Estatus"},
                            { data: "", title: "Detalle"}
                        ],
                        columnDefs:[
                            {className: "text-center fuenteNormal segundo-color-letra", defaultContent: "-", targets: "_all"},
                            {className: "span-detalle", target: 8},
                            {className: "info-curso", target: 3},
                            {className: "fechaRegistro", target: 5},
                            {className: "fechaEntrega", target: 6},
                        ],
                        data: filas,
                        createdRow: (row, data) => {
                            $('.segundo-color-letra',row).css('color', SegundoColorLetra);
                            $('.span-detalle', row).html('<span class="fuenteNormal span-detalle text-center text-decoration-underline" onclick="DetalleTareaCreadaProfesor('.concat(data.idTarea,')">Ver detalle</span>'));
                            $('.info-curso', row).html('<div class="container"><div class="row"><div class="col-5"><img class="img-fluid" alt="Imagen del curso" src="'.concat(data.imagenCurso,'"/></div><div class="col-7 p-0"><p class="fuenteNormal">',data.nombreCurso,'</p></div></div></div>'));
                           

                            let fechaRegistro = data.fechaRegistro.substring(0, data.fechaRegistro.length -1 );
                            $('.fechaRegistro', row).text(dayjs(fechaRegistro).format('dddd DD MMM YYYY h:mm A'));

                            let fechaEntrega = dayjs(data.fechaEntrega?.substring(0,data.fechaEntrega?.length-1));
                            if(fechaEntrega.isValid()){
                                $('.fechaEntrega', row).text(fechaEntrega.format('LLLL'));
                            }
                        }
                    });

                    dataTableTareasCreadas.column(0).visible(false);
                    dataTableTareasCreadas.column(2).visible(false);
                    dataTableTareasCreadas.column(4).visible(false);
                }
                break;
                case 500:{
                    dataTableTareasCreadas.clear().draw();
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
                    dataTableTareasCreadas.clear().draw();
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
            dataTableTareasCreadas.clear().draw();
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


    document.DetalleTareaProfesor = async function(IdTarea, IdUsuario){
        try{

            ShowPreloader();

            $('<form/>', { action: '/tareas/profesordetalle', method: 'POST' }).append(
                $('<input>', {type: 'hidden', id: '_token', name: '_token', value: document.head.querySelector("[name~=csrf-token][content]").content}),
                $('<input>', {type: 'hidden', id: 'IdTarea', name: 'IdTarea', value: IdTarea}),
                $('<input>', {type: 'hidden', id: 'IdUsuario', name: 'IdUsuario', value: IdUsuario})
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

    document.DetalleTareaCreadaProfesor = async function(IdTarea){
        try{

            ShowPreloader();

            $('<form/>', { action: '/tareas/detalle', method: 'POST' }).append(
                $('<input>', {type: 'hidden', id: '_token', name: '_token', value: document.head.querySelector("[name~=csrf-token][content]").content}),
                $('<input>', {type: 'hidden', id: 'IdTarea', name: 'IdTarea', value: IdTarea})
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

}



//#endregion

