'use strict';

let dataTableMisChats, dataTableBuscarUsuarios;
let SegundoColor = localStorage.getItem("SegundoColor");
let SegundoColorLetra = localStorage.getItem("SegundoColorLetra");
let TercerColor = localStorage.getItem("TercerColor");
let TercerColorLetra = localStorage.getItem("TercerColorLetra");
let PrimerColor = localStorage.getItem("PrimerColor");
let PrimerColorLetra = localStorage.getItem("PrimerColorLetra");
let BaseURL = window.location.origin;

dataTableMisChats = $("#table-mis-chats").DataTable({
    pagingType: 'full_numbers',
    dom: 'frtp',
    search: {
        return: true,
    },
    scrollX: false,
    language: {
        search: "_INPUT_",
        searchPlaceholder: "Buscar algún chat...",
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
        { title: "Id Chat"},
        { title: "Id Usuario Receptor"},
        { title: "Receptor"},
        { title: "Imagen Receptor"},
        { title: "Fecha de registro"},
        { title: "Último Mensaje"},
        { title: "Fecha de envio"},
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

dataTableMisChats.column(0).visible(false);
dataTableMisChats.column(1).visible(false);
dataTableMisChats.column(3).visible(false);

dataTableBuscarUsuarios = $("#table-buscar-usuarios").DataTable({
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
        { title: "Id Usuario"},
        { title: "Nombre Completo"},
        { title: "Imagen"},
        { title: "Correo Electronico"},
        { title: "Tipo de usuario"},
        { title: "Acción"},
    ],
    columnDefs:[
        {className: "text-center fuenteNormal segundo-color-letra", targets: "_all"},
    ],
    rowCallback: function(row, data, index){
        $(row).css('color', SegundoColorLetra);
    }
});

dataTableBuscarUsuarios.column(0).visible(false);
dataTableBuscarUsuarios.column(2).visible(false);

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

document.addEventListener('DOMContentLoaded',  ObtenerMisChats, false);

//#region Methods

async function ObtenerMisChats(){
    try{

        ShowPreloader();

        let response = await axios({
            url: '/chats/obtener',
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

                dataTableMisChats.destroy();

                dataTableMisChats = $("#table-mis-chats").DataTable({
                    pagingType: 'full_numbers',
                    dom: 'frtp',
                    search: {
                        return: true,
                    },
                    scrollX: false,
                    language: {
                        search: "_INPUT_",
                        searchPlaceholder: "Buscar algún chat...",
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
                        { data: "idChat", title: "Id Chat"},
                        { data: "idUsuarioReceptor", title: "Id Usuario Receptor"},
                        { data: "receptor", title: "Receptor"},
                        { data: "imagenReceptor", title: "Imagen Receptor"},
                        { data: "fechaRegistro", title: "Fecha de registro"},
                        { data: "mensaje", title: "Último Mensaje"},
                        { data: "fechaEnvio", title: "Fecha de envio"},
                        { data: "", title: "Detalle"}
                    ],
                    columnDefs:[
                        {className: "text-center fuenteNormal segundo-color-letra", defaultContent: "-", targets: "_all"},
                        {className: "span-detalle", target: 7},
                        {className: "info-usuario", target: 2},
                        {className: "fechaRegistro", target: 4},
                        {className: "fechaEnvio", target: 6},
                    ],
                    data: filas,
                    createdRow: (row, data) => {
                        $('.segundo-color-letra',row).css('color', SegundoColorLetra);
                        $('.span-detalle', row).html('<span class="fuenteNormal span-detalle text-center text-decoration-underline" onclick="DetalleChat('.concat(data.idChat,',',data.idUsuarioReceptor,')">Ver detalle</span>'));
                        $('.info-usuario', row).html('<div class="container"><div class="row"><div class="col-5"><img class="img-fluid" alt="Imagen del usuario" src="'.concat(data.imagenReceptor,'"/></div><div class="col-7 p-0"><p class="fuenteNormal">',data.receptor,'</p></div></div></div>'));
                        let fechaRegistro = data.fechaRegistro.substring(0, data.fechaRegistro.length -1 );
                        $('.fechaRegistro', row).text(dayjs(fechaRegistro).format('dddd DD MMM YYYY h:mm A'));
                        let fechaEnvio = dayjs(data.fechaEnvio?.substring(0,data.fechaEnvio?.length-1));
                        if(fechaEnvio.isValid()){
                            $('.fechaEnvio', row).text(fechaEnvio.format('LLLL'));
                        }
                    }
                });

                dataTableMisChats.column(0).visible(false);
                dataTableMisChats.column(1).visible(false);
                dataTableMisChats.column(3).visible(false);

            }
            break;
            case 500:{
                dataTableMisChats.clear().draw();
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
                dataTableMisChats.clear().draw();
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
        dataTableMisChats.clear().draw();
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

document.DetalleChat = async function(IdChat, IdUsuarioReceptor){
    try{

        ShowPreloader();

        $('<form/>', { action: '/chats/conversacion', method: 'POST' }).append(
            $('<input>', {type: 'hidden', id: '_token', name: '_token', value: document.head.querySelector("[name~=csrf-token][content]").content}),
            $('<input>', {type: 'hidden', id: 'IdChat', name: 'IdChat', value: IdChat}),
            $('<input>', {type: 'hidden', id: 'IdUsuarioReceptor', name: 'IdUsuarioReceptor', value: IdUsuarioReceptor}),
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


document.Chatear = async function(IdUsuario){

    try{

        Swal.fire({
            title: 'Chatear con usuario',
            text: '¿Está segur@ de querer iniciar una conservación con tal usuario?',
            imageUrl: window.IndifferentOwl,
            imageWidth: 100,
            imageHeight: 123,
            background: '#000000',
            color: '#FFFFFF',
            imageAlt: 'Alert Image',
            showCloseButton: true,
            showDenyButton: true,
            showCancelButton: true,
            confirmButtonText: 'Sí 😎',
            denyButtonText: 'No 😅',
            cancelButtonText: 'Me equivoque de botón 😥'
        }).then(async (result) => {
            if(result.isConfirmed){
                
                ShowPreloader();

                let formData = new FormData();

                formData.append('IdUsuarioReceptor', IdUsuario);

                let response = await axios({
                    url: '/chats/registrar',
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
                       
                        Swal.fire({
                            title: 'Registro de nuevo chat',
                            text: result.data.mensaje,
                            imageUrl: window.HappyOwl,
                            imageWidth: 100,
                            imageHeight: 123,
                            imageAlt: 'Ok Image',
                            background: '#000000',
                            color: '#FFFFFF',
                            showCloseButton: false,
                            showDenyButton: false,
                            showCancelButton: false,
                        }).then(() => {
                            document.DetalleChat(result.data.codigo, IdUsuario);
                        });
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
                            text: result.data.mensaje,
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
        });
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

document.getElementById("button-buscar-usuarios").addEventListener('click', async (e) => {

    try{

        ShowPreloader();

        let formData = new FormData();

        formData.append('Nombre', document.getElementById("input-nombre-usuario").value);
        formData.append('Paterno', document.getElementById("input-paterno-usuario").value);
        formData.append('Materno', document.getElementById("input-materno-usuario").value);

        let response = await axios({
            url: '/usuarios/buscar',
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
                let filas = result.data;
                dataTableBuscarUsuarios.destroy();

                dataTableBuscarUsuarios = $("#table-buscar-usuarios").DataTable({
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
                        { data: "idUsuario", title: "Id Usuario"},
                        { data: "nombreCompleto", title: "Usuario"},
                        { data: "imagen", title: "Imagen"},
                        { data: "correoElectronico", title: "Correo Electronico"},
                        { data: "tipoUsuario", title: "Tipo de usuario"},
                        { data: "", title : "Acción"},
                    ],
                    columnDefs:[
                        {className: "text-center fuenteNormal segundo-color-letra", defaultContent: "-", targets: "_all"},
                        {className: "info-usuario", target: 1},
                        {className: "span-detalle", target: 5},
                    ],
                    createdRow: (row, data) => {
                        $('.segundo-color-letra',row).css('color', SegundoColorLetra);
                        $('.info-usuario', row).html('<div class="container"><div class="row"><div class="col-5"><img class="img-fluid" alt="Imagen del usuario" src="'.concat(data.imagen,'"/></div><div class="col-7 p-0"><p class="fuenteNormal">',data.nombreCompleto,'</p></div></div></div>'));
                        $('.span-detalle', row).html('<span class="fuenteNormal fw-bolder text-decoration-underline" onclick="Chatear('.concat(data.idUsuario,')">¿Chatear?</span>'));
                    },
                    data: filas
                });

                dataTableBuscarUsuarios.column(0).visible(false);
                dataTableBuscarUsuarios.column(2).visible(false);
            }
            break;
            case 500:{
                dataTableBuscarUsuarios.clear().draw();
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
                dataTableBuscarUsuarios.clear().draw();
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
        dataTableBuscarUsuarios.clear().draw();
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

});


//#endregion


