'use strict';

let dataTableMisChats, dataTableBuscarUsuarios;
let SegundoColor = localStorage.getItem("SegundoColor");
let SegundoColorLetra = localStorage.getItem("SegundoColorLetra");
let TercerColor = localStorage.getItem("TercerColor");
let TercerColorLetra = localStorage.getItem("TercerColorLetra");
let PrimerColor = localStorage.getItem("PrimerColor");
let PrimerColorLetra = localStorage.getItem("PrimerColorLetra");
let BaseURL = window.location.origin;

let assetsChatsRoute = document.getElementById("assets-chats").value;
let assetsUsuariosRoute = document.getElementById("assets-usuarios").value;
let IdChat = document.getElementById("id-chat").value;
let IdUsuarioEmisor = document.getElementById("id-usuario-emisor").value;
