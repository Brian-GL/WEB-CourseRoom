'use strict';

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


//Curso estudiante desempeño:

let dataTableEstudianteDesempeno;
dataTableEstudianteDesempeno = $("#table-mi-desempeno").DataTable({
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
        { title: "IdCurso"},
        { title: "Curso"},
        { title: "ImagenCurso"},
        { title: "IdTarea"},
        { title: "Tarea"},
        { title: "Calificación"},
        { title: "Promedio de calificacion"},
        { title: "Mediana de calificación"},
        { title: "Resultado de calificación"},
        { title: "Prediccion de calificación"},
        { title: "Puntualidad"},
        { title: "Promedio de puntualidad"},
        { title: "Mediana de puntualidad"},
        { title: "Resultado de puntualidad"},
        { title: "Fecha de registro"},
    ],
    columnDefs:[
        {className: "text-center fuenteNormal segundo-color-letra", targets: "_all"},
    ],
    rowCallback: function(row, data, index){
        $(row).css('color', SegundoColorLetra);
    }
});

dataTableEstudianteDesempeno.column(0).visible(false);
dataTableEstudianteDesempeno.column(2).visible(false);
dataTableEstudianteDesempeno.column(3).visible(false);

document.addEventListener('DOMContentLoaded',  ObtenerInformacionInicial, false);

async function ObtenerInformacionInicial(){
    ObtenerDesempeno();
    GenerarGraficaDesempeno();
}

async function ObtenerDesempeno(){
    try{

        ShowPreloader();

        let response = await axios({
            url: '/usuarios/desempeno',
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

                let calificaciones = [];
                let indice = 1;

                for(let data of filas){
                    calificaciones.push({
                        'Indice': indice,
                        'Calificacion': data.calificacion
                    });
                    indice = indice + 1 ;
                }

                dataTableEstudianteDesempeno.destroy();

                dataTableEstudianteDesempeno = $("#table-mi-desempeno").DataTable({
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
                        { data: "idCurso", title: "IdCurso"},
                        { data: "curso", title: "Curso referente"},
                        { data: "imagenCurso", title: "ImagenCurso"},
                        { data: "idTarea", title: "IdTarea"},
                        { data: "tarea", title: "Tarea calificada"},
                        { data: "calificacion", title: "Calificación"},
                        { data: "promedioCalificacionCurso", title: "Promedio de calificacion"},
                        { data: "medianaCalificacionCurso", title: "Mediana de calificación"},
                        { data: "resultadoCalificacionCurso", title: "Resultado de calificación"},
                        { data: "prediccionCalificacionCurso", title: "Prediccion de calificación"},
                        { data: "puntualidad", title: "Puntualidad"},
                        { data: "promedioPuntualidadCurso", title: "Promedio de puntualidad"},
                        { data: "medianaPuntualidadCurso", title: "Mediana de puntualidad"},
                        { data: "resultadoPuntualidadCurso", title: "Resultado de puntualidad"},
                        { data: "fechaRegistro", title: "Fecha de registro"},
                    ],
                    columnDefs:[
                        {className: "text-center fuenteNormal segundo-color-letra", defaultContent: "-", targets: "_all"},
                        {className: "fechaRegistro", target: 14},
                        {className: "info-curso", target: 1},

                    ],
                    data: filas,
                    createdRow: (row, data) => {
                        $('.segundo-color-letra',row).css('color', SegundoColorLetra);
                        
                        $('.info-curso', row).html('<div class="container"><div class="row"><div class="col-5"><img class="img-fluid" alt="Imagen del curso" src="'.concat(data.imagenCurso,'"/></div><div class="col-7 p-0"><p class="fuenteNormal">',data.curso,'</p></div></div></div>'));

                        let fechaRegistro = data.fechaRegistro.substring(0, data.fechaRegistro.length -1 );
                        $('.fechaRegistro', row).text(dayjs(fechaRegistro).format('dddd DD MMM YYYY h:mm A'));

                        
                    }
                });
                
                dataTableEstudianteDesempeno.column(0).visible(false);
                dataTableEstudianteDesempeno.column(2).visible(false);
                dataTableEstudianteDesempeno.column(3).visible(false);

                //Calificaciones:
                new window.Chart(
                    document.getElementById('canvas-calificaciones'),
                    {
                        type: 'line',
                        options: {
                            responsive: true,
                            plugins: {
                                legend: {
                                    labels: {
                                        usePointStyle: true,
                                    },
                                }
                            },
                        },
                        data: {
                            labels: calificaciones.map(row => row.Indice),
                            datasets: [
                                {
                                    label: 'Calificaciones',
                                    data: calificaciones.map(row => row.Calificacion),
                                    pointRadius: 8
                                }
                            ]
                        }
                    }
                );

            }
            break;
            case 500:{
                dataTableEstudianteDesempeno.clear().draw();
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
                dataTableEstudianteDesempeno.clear().draw();
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
        dataTableEstudianteDesempeno.clear().draw();
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

async function GenerarGraficaDesempeno()
{

    try{

        ShowPreloader();

        let response = await axios({
            url: '/usuarios/informacioncalculator',
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
                const data = result.data;

                let desempeno = [];
                let predicciones = [];

                for(let prediccion of data)
                {
                    if(prediccion.Prediccion != null && prediccion.Prediccion != undefined){
                        predicciones.push({
                            'Indice': prediccion.Indice,
                            'Prediccion': prediccion.Prediccion
                        });
                    }

                    desempeno.push({
                        'Indice': prediccion.Indice,
                        'Resultado': prediccion.Resultado
                    });
                }

                window.Chart.defaults.borderColor = TercerColorLetra;
                window.Chart.defaults.color = TercerColorLetra;

                //Desempeno:
                new window.Chart(
                    document.getElementById('canvas-desempeno'),
                    {
                        type: 'line',
                        options: {
                            responsive: true,
                            plugins: {
                                legend: {
                                    labels: {
                                        usePointStyle: true,
                                    },
                                }
                            },
                            parsing: {
                                xAxisKey: 'Indice',
                                yAxisKey: 'Resultado'
                            }
                        },
                        data: {
                            labels: desempeno.map(row => row.Indice),
                            datasets: [
                                {
                                    label: 'Resultados de calificaciones',
                                    data: desempeno.map(row => row.Resultado),
                                    pointRadius: 8
                                },
                                {
                                    label: 'Predicciones',
                                    data: predicciones.map(row => row.Prediccion),
                                    pointRadius: 8,
                                }
                            ]
                        }
                    }
                );
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
            default:{
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