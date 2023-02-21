//#region tablas grupos

//Archivos compartidos:

let dataTableGrupoArchivosCompartidos;
dataTableGrupoArchivosCompartidos = $("#table-archivos-compartidos").DataTable({
    pagingType: 'full_numbers',
    dom: 'frtp',
    search: {
        return: true,
    },
    scrollX: false,
    language: {
        search: "_INPUT_",
        searchPlaceholder: "Buscar algún archivo compartido...",
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
        { title: "IdArchivoCompartido"},
        { title: "Nombre del archivo"},
        { title: "Archivo"},
        { title: "IdUsuarioEmisor"},
        { title: "Subido por"},
        { title: "Fecha de registro"},
        { title: "Descargar 📥" }
    ],
    columnDefs:[
        {className: "text-center fuenteNormal segundo-color-letra", defaultContent: "-", targets: "_all"},
        {className: "span-detalle", target: 6},
    ],
    rowCallback: (row) => {
        $(row).css('color', SegundoColorLetra);
    }
});

dataTableGrupoArchivosCompartidos.column(0).visible(false);
dataTableGrupoArchivosCompartidos.column(2).visible(false);
dataTableGrupoArchivosCompartidos.column(3).visible(false);

dataTableGrupoArchivosCompartidos = $("#table-archivos-compartidos").DataTable({
    pagingType: 'full_numbers',
    dom: 'frtp',
    search: {
        return: true,
    },
    scrollX: false,
    language: {
        search: "_INPUT_",
        searchPlaceholder: "Buscar algún archivo compartido...",
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
        { data: "idArchivoCompartido", title: "IdArchivoCompartido"},
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
        $('.span-detalle', row).html('<a class="fuenteNormal span-detalle text-center text-decoration-underline" href="'.concat(assetsRouteGrupos,'/',data.archivo,'">Descargar archivo</a>'));
        let fechaRegistro = data.fechaRegistro.substring(0, data.fechaRegistro.length -1 );
        $('.fechaRegistro', row).text(dayjs(fechaRegistro).format('dddd DD MMM YYYY h:mm A'));
    }
});

dataTableGrupoArchivosCompartidos.column(0).visible(false);
dataTableGrupoArchivosCompartidos.column(2).visible(false);
dataTableGrupoArchivosCompartidos.column(3).visible(false);

//Miembros:

let dataTableGrupoMiembros;
dataTableGrupoMiembros = $("#table-miembros").DataTable({
    pagingType: 'full_numbers',
    dom: 'frtp',
    search: {
        return: true,
    },
    scrollX: false,
    language: {
        search: "_INPUT_",
        searchPlaceholder: "Buscar algún archivo compartido...",
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
        { title: "Miembro"},
        { title: "Imagen"},
        { title: "Fecha de incorporación"},
        { title: "FechaActualizacion"}
    ],
    columnDefs:[
        {className: "text-center fuenteNormal segundo-color-letra", defaultContent: "-", targets: "_all"},
        {className: "fechaRegistro", target: 3},
    ],
    rowCallback: (row) => {
        $(row).css('color', SegundoColorLetra);
    }
});

dataTableGrupoMiembros.column(0).visible(false);
dataTableGrupoMiembros.column(2).visible(false);
dataTableGrupoMiembros.column(4).visible(false);

dataTableGrupoMiembros = $("#table-miembros").DataTable({
    pagingType: 'full_numbers',
    dom: 'frtp',
    search: {
        return: true,
    },
    scrollX: false,
    language: {
        search: "_INPUT_",
        searchPlaceholder: "Buscar algún archivo compartido...",
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
        { data: "nombreCompleto", title: "Miembro"},
        { data: "imagen", title: "Imagen"},
        { data: "fechaRegistro", title: "Fecha de incorporación"},
        { data: "fechaActualizacion", title: "FechaActualizacion"}
    ],
    columnDefs:[
        {className: "text-center fuenteNormal segundo-color-letra", defaultContent: "-", targets: "_all"},
        {className: "fechaRegistro", target: 3},
    ],
    data: filas,
    createdRow: (row, data) => {
        $('.segundo-color-letra',row).css('color', SegundoColorLetra);
        let fechaRegistro = data.fechaRegistro.substring(0, data.fechaRegistro.length -1 );
        $('.fechaRegistro', row).text(dayjs(fechaRegistro).format('dddd DD MMM YYYY h:mm A'));
    }
});

dataTableGrupoMiembros.column(0).visible(false);
dataTableGrupoMiembros.column(2).visible(false);
dataTableGrupoMiembros.column(4).visible(false);

//Tareas pendientes:

let dataTableGrupoTareasPendientes;
dataTableGrupoTareasPendientes = $("#table-tareas-pendientes").DataTable({
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
        {title: "IdTareaPendiente"},
        {title: "Nombre"},
        {title: "IdUsuarioCreador"},
        {title: "Creada por"},
        {title: "ImagenUsuarioCreador"},
        {title: "IdUsuarioResponsable"},
        {title: "Responsable"},
        {title: "ImagenUsuarioResponsable"},
        {title: "Fecha de registro"},
        {title: "Fecha de finalización"},
        {title: "Estatus"},
        {title: "Detalle" }
    ],
    columnDefs:[
        {className: "text-center fuenteNormal segundo-color-letra", targets: "_all"},
        {className: "span-detalle", target: 11},
    ],
    rowCallback: function(row, data, index){
        $(row).css('color', SegundoColorLetra);
    }
});

dataTableGrupoTareasPendientes.column(0).visible(false);
dataTableGrupoTareasPendientes.column(2).visible(false);
dataTableGrupoTareasPendientes.column(4).visible(false);
dataTableGrupoTareasPendientes.column(5).visible(false);
dataTableGrupoTareasPendientes.column(7).visible(false);

dataTableGrupoTareasPendientes = $("#table-tareas-pendientes").DataTable({
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
        {data: "idTareaPendiente", title: "IdTareaPendiente"},
        {data: "nombre", title: "Nombre"},
        {data: "idUsuarioCreador", title: "IdUsuarioCreador"},
        {data: "nombreUsuarioCreador", title: "Creada por"},
        {data: "imagenUsuarioCreador", title: "ImagenUsuarioCreador"},
        {data: "idUsuarioResponsable", title: "IdUsuarioResponsable"},
        {data: "nombreUsuarioResponsable", title: "Responsable"},
        {data: "imagenUsuarioResponsable", title: "ImagenUsuarioResponsable"},
        {data: "fechaRegistro", title: "Fecha de registro"},
        {data: "fechaFinalizacion", title: "Fecha de finalización"},
        {data: "estatus", title: "Estatus"},
        {data: "",title: "Detalle" }
    ],
    columnDefs:[
        {className: "text-center fuenteNormal segundo-color-letra", defaultContent: "-", targets: "_all"},
        {className: "span-detalle", target: 11},
        {className: "fechaRegistro", target: 8},
        {className: "fechaFinalizacion", target: 9},
        {className: "info-usuario-emisor", target: 3},
        {className: "info-usuario-receptor", target: 6},
    ],
    data: filas,
    createdRow: (row, data) => {
        $('.segundo-color-letra',row).css('color', SegundoColorLetra);
        $('.span-detalle', row).html('<span class="fuenteNormal span-detalle text-center text-decoration-underline" onclick="DetalleTareaPendiente('.concat(data.idTareaPendiente,')">Ver detalle</span>'));
        let fechaRegistro = data.fechaRegistro.substring(0, data.fechaRegistro.length -1 );
        $('.fechaRegistro', row).text(dayjs(fechaRegistro).format('dddd DD MMM YYYY h:mm A'));

        let fechaFinalizacion = dayjs(data.fechaFinalizacion?.substring(0,data.fechaFinalizacion?.length-1));
        if(fechaFinalizacion.isValid()){
            $('.fechaFinalizacion', row).text(fechaFinalizacion.format('LLLL'));
        }

        $('.info-usuario-emisor', row).html('<div class="container"><div class="row"><div class="col-5"><img class="img-fluid" alt="Imagen del usuario" src="'.concat(assetsRouteUsuarios,'/',data.imagenUsuarioCreador,'"/></div><div class="col-7 p-0"><p class="fuenteNormal">',data.nombreUsuarioCreador,'</p></div></div></div>'));
        $('.info-usuario-receptor', row).html('<div class="container"><div class="row"><div class="col-5"><img class="img-fluid" alt="Imagen del usuario" src="'.concat(assetsRouteUsuarios,'/',data.imagenUsuarioResponsable,'"/></div><div class="col-7 p-0"><p class="fuenteNormal">',data.nombreUsuarioResponsable,'</p></div></div></div>'));
    }
});

dataTableGrupoTareasPendientes.column(0).visible(false);
dataTableGrupoTareasPendientes.column(2).visible(false);
dataTableGrupoTareasPendientes.column(4).visible(false);
dataTableGrupoTareasPendientes.column(5).visible(false);
dataTableGrupoTareasPendientes.column(7).visible(false);


//#endregion

//#region tablas tareas



//#endregion


//#region tablas cursos


//#endregion