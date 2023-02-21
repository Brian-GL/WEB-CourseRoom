
//Archivos adjuntos:

let dataTableTareaArchivosAdjuntos;
dataTableTareaArchivosAdjuntos = $("#table-archivos-adjuntos").DataTable({
    pagingType: 'full_numbers',
    dom: 'frtp',
    search: {
        return: true,
    },
    scrollX: false,
    language: {
        search: "_INPUT_",
        searchPlaceholder: "Buscar algún archivo adjunto...",
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
        { title: "IdArchivoAdjunto"},
        { title: "Nombre del archivo"},
        { title: "Archivo"},
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

dataTableTareaArchivosAdjuntos.column(0).visible(false);
dataTableTareaArchivosAdjuntos.column(2).visible(false);

dataTableTareaArchivosAdjuntos = $("#table-archivos-adjuntos").DataTable({
    pagingType: 'full_numbers',
    dom: 'frtp',
    search: {
        return: true,
    },
    scrollX: false,
    language: {
        search: "_INPUT_",
        searchPlaceholder: "Buscar algún archivo adjunto...",
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
        { data: "idArchivoAdjunto", title: "IdArchivoAdjunto"},
        { data: "nombre", title: "Nombre del archivo"},
        { data: "archivo", title: "Archivo"},
        { data: "fechaRegistro", title: "Fecha de registro"},
        { data: "", title: "Descargar 📥" }
    ],
    columnDefs:[
        {className: "text-center fuenteNormal segundo-color-letra", defaultContent: "-", targets: "_all"},
        {className: "span-detalle", target: 4},
        {className: "fechaRegistro", target: 3},
    ],
    data: filas,
    createdRow: (row, data) => {
        $('.segundo-color-letra',row).css('color', SegundoColorLetra);
        $('.span-detalle', row).html('<a class="fuenteNormal span-detalle text-center text-decoration-underline" href="'.concat(assetsRouteTareas,'/',data.archivo,'">Descargar archivo</a>'));
        let fechaRegistro = data.fechaRegistro.substring(0, data.fechaRegistro.length -1 );
        $('.fechaRegistro', row).text(dayjs(fechaRegistro).format('dddd DD MMM YYYY h:mm A'));
    }
});

dataTableTareaArchivosAdjuntos.column(0).visible(false);
dataTableTareaArchivosAdjuntos.column(2).visible(false);

//Archivos entregados estudiante:

let dataTableTareaArchivosEntregadosEstudiante;
dataTableTareaArchivosEntregadosEstudiante = $("#table-archivos-entregados-estudiante").DataTable({
    pagingType: 'full_numbers',
    dom: 'frtp',
    search: {
        return: true,
    },
    scrollX: false,
    language: {
        search: "_INPUT_",
        searchPlaceholder: "Buscar algún archivo entregado...",
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
        { title: "IdArchivoEntregado"},
        { title: "Nombre del archivo"},
        { title: "Archivo"},
        { title: "Fecha de registro"},
        { title: "Descargar 📥" },
        { title: "Remover ❌" }
    ],
    columnDefs:[
        {className: "text-center fuenteNormal segundo-color-letra", defaultContent: "-", targets: "_all"},
    ],
    rowCallback: (row) => {
        $(row).css('color', SegundoColorLetra);
    }
});

dataTableTareaArchivosEntregadosEstudiante.column(0).visible(false);
dataTableTareaArchivosEntregadosEstudiante.column(2).visible(false);

dataTableTareaArchivosEntregadosEstudiante = $("#table-archivos-entregados-estudiante").DataTable({
    pagingType: 'full_numbers',
    dom: 'frtp',
    search: {
        return: true,
    },
    scrollX: false,
    language: {
        search: "_INPUT_",
        searchPlaceholder: "Buscar algún archivo adjunto...",
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
        { data: "idArchivoEntregado", title: "IdArchivoEntregado"},
        { data: "nombre", title: "Nombre del archivo"},
        { data: "archivo", title: "Archivo"},
        { data: "fechaRegistro", title: "Fecha de registro"},
        { data: "", title: "Descargar 📥" },
        { data: "", title: "Remover ❌" },
    ],
    columnDefs:[
        {className: "text-center fuenteNormal segundo-color-letra", defaultContent: "-", targets: "_all"},
        {className: "span-detalle", target: 4},
        {className: "span-remover", target: 5},
        {className: "fechaRegistro", target: 3},
    ],
    data: filas,
    createdRow: (row, data) => {
        $('.segundo-color-letra',row).css('color', SegundoColorLetra);
        $('.span-remover', row).html('<span class="fuenteNormal span-detalle text-center text-decoration-underline" onclick="RemoverArchivoEntregado('.concat(data.idArchivoEntregado,')">¿Remover archivo?</span>'));
        $('.span-detalle', row).html('<a class="fuenteNormal span-detalle text-center text-decoration-underline" href="'.concat(assetsRouteTareas,'/',data.archivo,'">Descargar archivo</a>'));
        let fechaRegistro = data.fechaRegistro.substring(0, data.fechaRegistro.length -1 );
        $('.fechaRegistro', row).text(dayjs(fechaRegistro).format('dddd DD MMM YYYY h:mm A'));
    }
});

dataTableTareaArchivosEntregadosEstudiante.column(0).visible(false);
dataTableTareaArchivosEntregadosEstudiante.column(2).visible(false);

//Archivos entregados profesor:

let dataTableTareaArchivosEntregadosProfesor;
dataTableTareaArchivosEntregadosProfesor = $("#table-archivos-entregados-profesor").DataTable({
    pagingType: 'full_numbers',
    dom: 'frtp',
    search: {
        return: true,
    },
    scrollX: false,
    language: {
        search: "_INPUT_",
        searchPlaceholder: "Buscar algún archivo entregado...",
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
        { title: "IdArchivoEntregado"},
        { title: "Nombre del archivo"},
        { title: "Archivo"},
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

dataTableTareaArchivosEntregadosProfesor.column(0).visible(false);
dataTableTareaArchivosEntregadosProfesor.column(2).visible(false);

dataTableTareaArchivosEntregadosProfesor = $("#table-archivos-entregados-profesor").DataTable({
    pagingType: 'full_numbers',
    dom: 'frtp',
    search: {
        return: true,
    },
    scrollX: false,
    language: {
        search: "_INPUT_",
        searchPlaceholder: "Buscar algún archivo adjunto...",
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
        { data: "idArchivoEntregado", title: "IdArchivoEntregado"},
        { data: "nombre", title: "Nombre del archivo"},
        { data: "archivo", title: "Archivo"},
        { data: "fechaRegistro", title: "Fecha de registro"},
        { data: "", title: "Descargar 📥" },
    ],
    columnDefs:[
        {className: "text-center fuenteNormal segundo-color-letra", defaultContent: "-", targets: "_all"},
        {className: "span-detalle", target: 4},
        {className: "fechaRegistro", target: 3},
    ],
    data: filas,
    createdRow: (row, data) => {
        $('.segundo-color-letra',row).css('color', SegundoColorLetra);
        $('.span-detalle', row).html('<a class="fuenteNormal span-detalle text-center text-decoration-underline" href="'.concat(assetsRouteTareas,'/',data.archivo,'">Descargar archivo</a>'));
        let fechaRegistro = data.fechaRegistro.substring(0, data.fechaRegistro.length -1 );
        $('.fechaRegistro', row).text(dayjs(fechaRegistro).format('dddd DD MMM YYYY h:mm A'));
    }
});

dataTableTareaArchivosEntregadosProfesor.column(0).visible(false);
dataTableTareaArchivosEntregadosProfesor.column(2).visible(false);


//Retroalimentaciones:

let dataTableTareaRetroalimentaciones;
dataTableTareaRetroalimentaciones = $("#table-retroalimentaciones").DataTable({
    pagingType: 'full_numbers',
    dom: 'frtp',
    search: {
        return: true,
    },
    scrollX: false,
    language: {
        search: "_INPUT_",
        searchPlaceholder: "Buscar alguna retroalimentación...",
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
        { title: "IdRetroalimentacion"},
        { title: "Retroalimentación"},
        { title: "Descripción"},
        { title: "Fecha de registro"},
        { title: "Detalle" }
    ],
    columnDefs:[
        {className: "text-center fuenteNormal segundo-color-letra", defaultContent: "-", targets: "_all"},
    ],
    rowCallback: (row) => {
        $(row).css('color', SegundoColorLetra);
    }
});

dataTableTareaRetroalimentaciones.column(0).visible(false);

dataTableTareaRetroalimentaciones = $("#table-retroalimentaciones").DataTable({
    pagingType: 'full_numbers',
    dom: 'frtp',
    search: {
        return: true,
    },
    scrollX: false,
    language: {
        search: "_INPUT_",
        searchPlaceholder: "Buscar alguna retroalimentación...",
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
        { data: "idRetroalimentacion", title: "IdRetroalimentacion"},
        { data: "nombre", title: "Retroalimentación"},
        { data: "retroalimentacion", title: "Descripción"},
        { data: "fechaRegistro", title: "Fecha de registro"},
        { data: "", title: "Detalle" },
    ],
    columnDefs:[
        {className: "text-center fuenteNormal segundo-color-letra", defaultContent: "-", targets: "_all"},
        {className: "span-detalle", target: 4},
        {className: "fechaRegistro", target: 3},
    ],
    data: filas,
    createdRow: (row, data) => {
        $('.segundo-color-letra',row).css('color', SegundoColorLetra);
        $('.span-detalle', row).html('<span class="fuenteNormal span-detalle text-center text-decoration-underline" onclick="DetalleRetroalimentación('.concat(data.idRetroalimentacion,')">Ver detalle</span>'));
        let fechaRegistro = data.fechaRegistro.substring(0, data.fechaRegistro.length -1 );
        $('.fechaRegistro', row).text(dayjs(fechaRegistro).format('dddd DD MMM YYYY h:mm A'));
    }
});

dataTableTareaRetroalimentaciones.column(0).visible(false);