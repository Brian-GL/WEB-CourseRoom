//Desempeño curso:

let dataTableCursoDesempeno;
dataTableCursoDesempeno = $("#table-curso-desempeno").DataTable({
    pagingType: 'full_numbers',
    dom: 'rtp',
    language: {
        search: "_INPUT_",
        searchPlaceholder: "Buscar algún registro...",
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
        { title: "IdUsuario"},
        { title: "Estudiante"},
        { title: "Imagen"},
        { title: "IdTarea"},
        { title: "Tarea"},
        { title: "Calificación"},
        { title: "Promedio de calificación"},
        { title: "Predicción de calificación"},
        { title: "Puntualidad"},
        { title: "Promedio de puntualidad"},
        { title: "Fecha de registro"},
    ],
    columnDefs:[
        {className: "text-center fuenteNormal segundo-color-letra", targets: "_all"},
    ],
    rowCallback: function(row, data, index){
        $(row).css('color', SegundoColorLetra);
    }
});

dataTableCursoDesempeno.column(0).visible(false);
dataTableCursoDesempeno.column(2).visible(false);
dataTableCursoDesempeno.column(3).visible(false);

dataTableCursoDesempeno = $("#table-curso-desempeno").DataTable({
    pagingType: 'full_numbers',
    dom: 'rtp',
    language: {
        search: "_INPUT_",
        searchPlaceholder: "Buscar algún registro...",
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
        { data: "idUsuario", title: "IdUsuario"},
        { data: "nombreCompleto", title: "Estudiante"},
        { data: "imagen", title: "Imagen"},
        { data: "idTarea", title: "IdTarea"},
        { data: "tarea", title: "Tarea"},
        { data: "calificacion", title: "Calificación"},
        { data: "promedioCalificacionCurso", title: "Promedio de calificación"},
        { data: "prediccionCalificacionCurso", title: "Predicción de calificación"},
        { data: "puntualidad", title: "Puntualidad"},
        { data: "promedioPuntualidadCurso", title: "Promedio de puntualidad"},
        { data: "fechaRegistro", title: "Fecha de registro"},
    ],
    columnDefs:[
        {className: "text-center fuenteNormal segundo-color-letra", defaultContent: "-", targets: "_all"},
        {className: "fechaRegistro", target: 10},
        {className: "info-usuario", target: 1},
    ],
    data: filas,
    createdRow: (row, data) => {
        $('.segundo-color-letra',row).css('color', SegundoColorLetra);
        $('.info-usuario', row).html('<div class="container"><div class="row"><div class="col-5"><img class="img-fluid" alt="Imagen del usuario" src="'.concat(assetsRouteUsuarios,'/',data.imagen,'"/></div><div class="col-7 p-0"><p class="fuenteNormal">',data.nombreCompleto,'</p></div></div></div>'));        
        let fechaRegistro = data.fechaRegistro.substring(0, data.fechaRegistro.length -1 );
        $('.fechaRegistro', row).text(dayjs(fechaRegistro).format('dddd DD MMM YYYY h:mm A'));
    }
});

dataTableCursoDesempeno.column(0).visible(false);
dataTableCursoDesempeno.column(2).visible(false);
dataTableCursoDesempeno.column(3).visible(false);

// Grupos curso:

let dataTableGruposCurso;
dataTableGruposCurso = $("#table-grupos-curso").DataTable({
    pagingType: 'full_numbers',
    dom: 'rtp',
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
        { title: "IdGrupo"},
        { title: "Nombre"},
        { title: "Imagen"},
        { title: "Numero de integrantes"},
        { title: "Fecha de registro"},
    ],
    columnDefs:[
        {className: "text-center fuenteNormal segundo-color-letra", targets: "_all"},
    ],
    rowCallback: function(row, data, index){
        $(row).css('color', SegundoColorLetra);
    }
});

dataTableGruposCurso.column(0).visible(false);
dataTableGruposCurso.column(2).visible(false);

dataTableGruposCurso = $("#table-grupos-curso").DataTable({
    pagingType: 'full_numbers',
    dom: 'rtp',
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
        { data: "idGrupo", title: "IdGrupo"},
        { data: "nombre", title: "Nombre"},
        { data: "imagen", title: "Imagen"},
        { data: "numeroIntegrantes", title: "Numero de integrantes"},
        { data: "fechaRegistro", title: "Fecha de registro"},
    ],
    columnDefs:[
        {className: "text-center fuenteNormal segundo-color-letra", defaultContent: "-", targets: "_all"},
        {className: "fechaRegistro", target: 4},
        {className: "info-grupo", target: 1},
    ],
    data: filas,
    createdRow: (row, data) => {
        $('.segundo-color-letra',row).css('color', SegundoColorLetra);
        $('.info-grupo', row).html('<div class="container"><div class="row"><div class="col-5"><img class="img-fluid" alt="Imagen del usuario" src="'.concat(assetsRouteCursos,'/',data.imagen,'"/></div><div class="col-7 p-0"><p class="fuenteNormal">',data.nombre,'</p></div></div></div>'));        
        let fechaRegistro = data.fechaRegistro.substring(0, data.fechaRegistro.length -1 );
        $('.fechaRegistro', row).text(dayjs(fechaRegistro).format('dddd DD MMM YYYY h:mm A'));
    }
});

dataTableGruposCurso.column(0).visible(false);
dataTableGruposCurso.column(2).visible(false);

//Cursos materiales:

let dataTableCursoMateriales;
dataTableCursoMateriales = $("#table-materiales").DataTable({
    pagingType: 'full_numbers',
    dom: 'frtp',
    search: {
        return: true,
    },
    scrollX: false,
    language: {
        search: "_INPUT_",
        searchPlaceholder: "Buscar algún material..",
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
        { title: "IdMaterialSubido"},
        { title: "Nombre del archivo"},
        { title: "Archivo"},
        { title: "IdUsuarioEmisor"},
        { title: "Subido por"},
        { title: "Fecha de registro"},
        { title: "Descargar 📥" }
    ],
    columnDefs:[
        {className: "text-center fuenteNormal segundo-color-letra", defaultContent: "-", targets: "_all"},
    ],
    rowCallback: (row) => {
        $(row).css('color', SegundoColorLetra);
    }
});

dataTableCursoMateriales.column(0).visible(false);
dataTableCursoMateriales.column(2).visible(false);
dataTableCursoMateriales.column(3).visible(false);

dataTableCursoMateriales = $("#table-materiales").DataTable({
    pagingType: 'full_numbers',
    dom: 'frtp',
    search: {
        return: true,
    },
    scrollX: false,
    language: {
        search: "_INPUT_",
        searchPlaceholder: "Buscar algún material...",
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
        { data: "idMaterialSubido", title: "IdMaterialSubido"},
        { data: "nombre", title: "Nombre del archivo"},
        { data: "archivo", title: "Archivo"},
        { data: "idUsuarioEmisor", title: "IdUsuarioEmisor"},
        { data: "nombreUsuarioEmisor", title: "Subido por"},
        { data: "fechaRegistro", title: "Fecha de registro"},
        { data: "", title: "Descargar 📥" }
    ],
    columnDefs:[
        {className: "text-center fuenteNormal segundo-color-letra", defaultContent: "-", targets: "_all"},
        {className: "span-detalle", target: 6},
        {className: "fechaRegistro", target: 5},
    ],
    data: filas,
    createdRow: (row, data) => {
        $('.segundo-color-letra',row).css('color', SegundoColorLetra);
        $('.span-detalle', row).html('<a class="fuenteNormal span-detalle text-center text-decoration-underline" href="'.concat(assetsRouteCursos,'/',data.archivo,'">Descargar archivo</a>'));
        let fechaRegistro = data.fechaRegistro.substring(0, data.fechaRegistro.length -1 );
        $('.fechaRegistro', row).text(dayjs(fechaRegistro).format('dddd DD MMM YYYY h:mm A'));
    }
});

dataTableCursoMateriales.column(0).visible(false);
dataTableCursoMateriales.column(2).visible(false);
dataTableCursoMateriales.column(3).visible(false);

//Curso miembros estudiante:

let dataTableCursoMiembrosEstudiante;
dataTableCursoMiembrosEstudiante = $("#table-miembros-estudiante").DataTable({
    pagingType: 'full_numbers',
    dom: 'frtp',
    search: {
        return: true,
    },
    scrollX: false,
    language: {
        search: "_INPUT_",
        searchPlaceholder: "Buscar algún integrante...",
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
        { title: "IdUsuario"},
        { title: "Integrante"},
        { title: "Imagen"},
        { title: "Fecha de incorporación"},
        { title: "Fecha de actualización"},
        { title: "Estatus"},
    ],
    columnDefs:[
        {className: "text-center fuenteNormal segundo-color-letra", defaultContent: "-", targets: "_all"},
    ],
    rowCallback: (row) => {
        $(row).css('color', SegundoColorLetra);
    }
});

dataTableCursoMiembrosEstudiante.column(0).visible(false);
dataTableCursoMiembrosEstudiante.column(2).visible(false);

dataTableCursoMiembrosEstudiante = $("#table-miembros-estudiante").DataTable({
    pagingType: 'full_numbers',
    dom: 'frtp',
    search: {
        return: true,
    },
    scrollX: false,
    language: {
        search: "_INPUT_",
        searchPlaceholder: "Buscar algún integrante...",
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
        { data: "idUsuario", title: "IdUsuario"},
        { data: "nombreCompleto", title: "Integrante"},
        { data: "imagen", title: "Imagen"},
        { data: "fechaRegistro", title: "Fecha de incorporación"},
        { data: "fechaActualizacion", title: "Fecha de actualización"},
        { data: "estatus", title: "Estatus"},
    ],
    columnDefs:[
        {className: "text-center fuenteNormal segundo-color-letra", defaultContent: "-", targets: "_all"},
        {className: "fechaRegistro", target: 3},
        {className: "info-usuario", target: 1},
    ],
    data: filas,
    createdRow: (row, data) => {
        $('.segundo-color-letra',row).css('color', SegundoColorLetra);
        $('.info-usuario', row).html('<div class="container"><div class="row"><div class="col-5"><img class="img-fluid" alt="Imagen del usuario" src="'.concat(assetsRouteUsuarios,'/',data.imagen,'"/></div><div class="col-7 p-0"><p class="fuenteNormal">',data.nombreCompleto,'</p></div></div></div>'));
        let fechaRegistro = data.fechaRegistro.substring(0, data.fechaRegistro.length -1 );
        $('.fechaRegistro', row).text(dayjs(fechaRegistro).format('dddd DD MMM YYYY h:mm A'));
    }
});

dataTableCursoMiembrosEstudiante.column(0).visible(false);
dataTableCursoMiembrosEstudiante.column(2).visible(false);

//Curso miembros profesor:

let dataTableCursoMiembrosProfesor;
dataTableCursoMiembrosProfesor = $("#table-miembros-profesor").DataTable({
    pagingType: 'full_numbers',
    dom: 'frtp',
    search: {
        return: true,
    },
    scrollX: false,
    language: {
        search: "_INPUT_",
        searchPlaceholder: "Buscar algún integrante...",
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
        { title: "IdUsuario"},
        { title: "Integrante"},
        { title: "Imagen"},
        { title: "Fecha de incorporación"},
        { title: "Fecha de actualización"},
        { title: "Estatus"},
        { title: "Expulsar ❌"},
    ],
    columnDefs:[
        {className: "text-center fuenteNormal segundo-color-letra", defaultContent: "-", targets: "_all"},
    ],
    rowCallback: (row) => {
        $(row).css('color', SegundoColorLetra);
    }
});

dataTableCursoMiembrosProfesor.column(0).visible(false);
dataTableCursoMiembrosProfesor.column(2).visible(false);

dataTableCursoMiembrosProfesor = $("#table-miembros-profesor").DataTable({
    pagingType: 'full_numbers',
    dom: 'frtp',
    search: {
        return: true,
    },
    scrollX: false,
    language: {
        search: "_INPUT_",
        searchPlaceholder: "Buscar algún integrante...",
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
        { data: "idUsuario", title: "IdUsuario"},
        { data: "nombreCompleto", title: "Integrante"},
        { data: "imagen", title: "Imagen"},
        { data: "fechaRegistro", title: "Fecha de incorporación"},
        { data: "fechaActualizacion", title: "Fecha de actualización"},
        { data: "estatus", title: "Estatus"},
        { data: "", title: "Expulsar ❌"},
    ],
    columnDefs:[
        {className: "text-center fuenteNormal segundo-color-letra", defaultContent: "-", targets: "_all"},
        {className: "fechaRegistro", target: 3},
        {className: "info-usuario", target: 1},
        {className: "span-detalle", target: 6},
    ],
    data: filas,
    createdRow: (row, data) => {
        $('.segundo-color-letra',row).css('color', SegundoColorLetra);
        $('.span-detalle', row).html('<span class="fuenteNormal span-detalle text-center text-decoration-underline" onclick="ExpulsarEstudiante('.concat(data.idUsuario,')">Expulsar💔</span>'));
        $('.info-usuario', row).html('<div class="container"><div class="row"><div class="col-5"><img class="img-fluid" alt="Imagen del usuario" src="'.concat(assetsRouteUsuarios,'/',data.imagen,'"/></div><div class="col-7 p-0"><p class="fuenteNormal">',data.nombreCompleto,'</p></div></div></div>'));
        let fechaRegistro = data.fechaRegistro.substring(0, data.fechaRegistro.length -1 );
        $('.fechaRegistro', row).text(dayjs(fechaRegistro).format('dddd DD MMM YYYY h:mm A'));
    }
});

dataTableCursoMiembrosProfesor.column(0).visible(false);
dataTableCursoMiembrosProfesor.column(2).visible(false);

// Tareas curso profesor:

let dataTableTareasProfesorCurso;
dataTableTareasProfesorCurso = $("#table-tareas-profesor-curso").DataTable({
    pagingType: 'full_numbers',
    dom: 'rtp',
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
        { title: "Tarea"},
        { title: "Fecha de registro"},
        { title: "Fecha de entrega"},
        { title: "Estatus para entrega"},
        { title: "Detalle"},
    ],
    columnDefs:[
        {className: "text-center fuenteNormal segundo-color-letra", targets: "_all"},
    ],
    rowCallback: function(row, data, index){
        $(row).css('color', SegundoColorLetra);
    }
});

dataTableTareasProfesorCurso.column(0).visible(false);

dataTableTareasProfesorCurso = $("#table-tareas-profesor-curso").DataTable({
    pagingType: 'full_numbers',
    dom: 'rtp',
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
        { data: "tarea", title: "Tarea"},
        { data: "fechaRegistro", title: "Fecha de registro"},
        { data: "fechaEntrega", title: "Fecha de entrega"},
        { data: "estatusEntrega", title: "Estatus para entrega"},
        { data: "", title: "Detalle"},
    ],
    columnDefs:[
        {className: "text-center fuenteNormal segundo-color-letra", defaultContent: "-", targets: "_all"},
        {className: "fechaRegistro", target: 2},
        {className: "fechaEntrega", target: 3},
        {className: "span-detalle", target: 5},
    ],
    data: filas,
    createdRow: (row, data) => {
        $('.segundo-color-letra',row).css('color', SegundoColorLetra);
        $('.span-detalle', row).html('<span class="fuenteNormal span-detalle text-center text-decoration-underline" onclick="DetalleTarea('.concat(data.idTarea,')">Ver detalle</span>'));
        let fechaRegistro = data.fechaRegistro.substring(0, data.fechaRegistro.length -1 );
        $('.fechaRegistro', row).text(dayjs(fechaRegistro).format('dddd DD MMM YYYY h:mm A'));
        let fechaEntrega = data.fechaEntrega.substring(0, data.fechaEntrega.length -1 );
        $('.fechaEntrega', row).text(dayjs(fechaEntrega).format('dddd DD MMM YYYY h:mm A'));
    }
});

dataTableTareasProfesorCurso.column(0).visible(false);

//Tareas estudiante curso:

let dataTableTareasEstudianteCurso;
dataTableTareasEstudianteCurso = $("#table-tareas-estudiante-curso").DataTable({
    pagingType: 'full_numbers',
    dom: 'rtp',
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
        { title: "Fecha de registro"},
        { title: "Fecha de entrega"},
        { title: "Entregada el"},
        { title: "Calificada el"},
        { title: "Calificación"},
        { title: "Puntualidad"},
        { title: "Estatus"},
        { title: "Detalle"},
    ],
    columnDefs:[
        {className: "text-center fuenteNormal segundo-color-letra", targets: "_all"},
    ],
    rowCallback: function(row, data, index){
        $(row).css('color', SegundoColorLetra);
    }
});

dataTableTareasEstudianteCurso.column(0).visible(false);

dataTableTareasEstudianteCurso = $("#table-tareas-estudiante-curso").DataTable({
    pagingType: 'full_numbers',
    dom: 'rtp',
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
        { data: "fechaRegistro", title: "Fecha de registro"},
        { data: "fechaEntrega", title: "Fecha de entrega"},
        { data: "fechaEntregada", title: "Entregada el"},
        { data: "fechaCalificacion", title: "Calificada el"},
        { data: "calificacion", title: "Calificación"},
        { data: "puntualidad", title: "Puntualidad"},
        { data: "estatus", title: "Estatus"},
        { data: "", title: "Detalle"},
    ],
    columnDefs:[
        {className: "text-center fuenteNormal segundo-color-letra", defaultContent: "-", targets: "_all"},
        {className: "fechaRegistro", target: 2},
        {className: "fechaEntrega", target: 3},
        {className: "fechaEntregada", target: 4},
        {className: "fechaCalificacion", target: 5},
        {className: "span-detalle", target: 9},
    ],
    data: filas,
    createdRow: (row, data) => {
        $('.segundo-color-letra',row).css('color', SegundoColorLetra);
        $('.span-detalle', row).html('<span class="fuenteNormal span-detalle text-center text-decoration-underline" onclick="DetalleTarea('.concat(data.idTarea,')">Ver detalle</span>'));
        let fechaRegistro = data.fechaRegistro.substring(0, data.fechaRegistro.length -1 );
        $('.fechaRegistro', row).text(dayjs(fechaRegistro).format('dddd DD MMM YYYY h:mm A'));

        let fechaEntrega = data.fechaEntrega.substring(0, data.fechaEntrega.length -1 );
        $('.fechaEntrega', row).text(dayjs(fechaEntrega).format('dddd DD MMM YYYY h:mm A'));

        let fechaEntregada = dayjs(data.fechaEntregada?.substring(0,data.fechaEntregada?.length-1));
        if(fechaEntregada.isValid()){
            $('.fechaEntregada', row).text(fechaEntregada.format('LLLL'));
        }

        let fechaCalificacion = dayjs(data.fechaCalificacion?.substring(0,data.fechaCalificacion?.length-1));
        if(fechaCalificacion.isValid()){
            $('.fechaCalificacion', row).text(fechaCalificacion.format('LLLL'));
        }

    }
});

dataTableTareasEstudianteCurso.column(0).visible(false);

//Curso estudiante desempeño:

let dataTableCursoEstudianteDesempeno;
dataTableCursoEstudianteDesempeno = $("#table-curso-estudiante-desempeno").DataTable({
    pagingType: 'full_numbers',
    dom: 'rtp',
    language: {
        search: "_INPUT_",
        searchPlaceholder: "Buscar algún registro...",
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
        { title: "Tarea"},
        { title: "Calificación"},
        { title: "Promedio de calificación"},
        { title: "Predicción de calificación"},
        { title: "Puntualidad"},
        { title: "Promedio de puntualidad"},
        { title: "Fecha de registro"},
    ],
    columnDefs:[
        {className: "text-center fuenteNormal segundo-color-letra", targets: "_all"},
    ],
    rowCallback: function(row, data, index){
        $(row).css('color', SegundoColorLetra);
    }
});

dataTableCursoEstudianteDesempeno.column(0).visible(false);

dataTableCursoEstudianteDesempeno = $("#table-curso-estudiante-desempeno").DataTable({
    pagingType: 'full_numbers',
    dom: 'rtp',
    language: {
        search: "_INPUT_",
        searchPlaceholder: "Buscar algún registro...",
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
        { data: "tarea", title: "Tarea"},
        { data: "calificacion", title: "Calificación"},
        { data: "promedioCalificacionCurso", title: "Promedio de calificación"},
        { data: "prediccionCalificacionCurso", title: "Predicción de calificación"},
        { data: "puntualidad", title: "Puntualidad"},
        { data: "promedioPuntualidadCurso", title: "Promedio de puntualidad"},
        { data: "fechaRegistro", title: "Fecha de registro"},
    ],
    columnDefs:[
        {className: "text-center fuenteNormal segundo-color-letra", defaultContent: "-", targets: "_all"},
        {className: "fechaRegistro", target: 7},
    ],
    data: filas,
    createdRow: (row, data) => {
        $('.segundo-color-letra',row).css('color', SegundoColorLetra);
        
        let fechaRegistro = data.fechaRegistro.substring(0, data.fechaRegistro.length -1 );
        $('.fechaRegistro', row).text(dayjs(fechaRegistro).format('dddd DD MMM YYYY h:mm A'));
    }
});

dataTableCursoEstudianteDesempeno.column(0).visible(false);