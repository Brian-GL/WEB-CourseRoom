var curr_track;
var track_index;
var isPlaying;
var updateTimer;
var music_list;


document.addEventListener('DOMContentLoaded', async function() {
    document.getElementById('preloader').hidden = true;

    document.getElementById('slider').disabled =  true;
    document.getElementById('anterior').disabled =  true;
    document.getElementById('play-pause').disabled =  true;
    document.getElementById('siguiente').disabled =  true;

    curr_track = document.createElement('audio');
    track_index = 0;
    isPlaying = false;
    music_list = [];

}, false);


async function ObtenerMetadatos(nombreArchivo) {

    const csrfToken = document.head.querySelector("[name~=csrf-token][content]").content;
    let baseURL = window.location.origin;

    fetch(baseURL.concat('/herramientas/metadatos'), {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': csrfToken
        },
        body: JSON.stringify({
            "Busqueda": nombreArchivo
        })
    }).then((response) => response.json())
    .then((result) => {

        switch(result.code){
            case 200:
                {
                    let data = result.data;

                    ObtenerVideo(data.Titulo, data.Artista);

                    document.getElementById('caratula').src = data.Caratula;
                    document.getElementById('informacion-cancion').innerText = data.Titulo;
                    document.getElementById('nombre-artista').innerText = 'By '.concat(data.Artista);
                    document.getElementById('deezer').href = data.DeezerURL;

                }
                break;
            case 500:
                {
                    SweetAlert.fire({
                        title: '¡Error!',
                        html: result.data,
                        imageUrl: baseURL.concat("/assets/templates/SadOwl.png"),
                        imageWidth: 100,
                        imageHeight: 123,
                        background: '#000000',
                        color: '#FFFFFF',
                        imageAlt: 'Error Image'
                    });

                    document.getElementById('caratula').src =  "";
                    document.getElementById('informacion-cancion').innerText = nombreArchivo;
                    document.getElementById('nombre-artista').innerText = "Desconocido";
                    document.getElementById('deezer').href = "https://www.deezer.com";
                    document.getElementById("video-frame").src = "";
                }
            break;
            default:
                {
                    document.getElementById('caratula').src =  "";
                    document.getElementById('informacion-cancion').innerText = nombreArchivo;
                    document.getElementById('nombre-artista').innerText = "Desconocido";
                    document.getElementById('deezer').href = "https://www.deezer.com";
                    document.getElementById("video-frame").src = "";
                }
                break;
        }

    }).catch((ex) => {
        SweetAlert.fire({
            title: '¡Error!',
            html: ex,
            imageUrl: baseURL.concat("/assets/templates/SadOwl.png"),
            imageWidth: 100,
            imageHeight: 123,
            background: '#000000',
            color: '#FFFFFF',
            imageAlt: 'Error Image'
        });
        document.getElementById("video-frame").src = "";
    });
}

async function ObtenerVideo(titulo, artista){

    let busqueda = artista.concat(" - ",titulo);
    const csrfToken = document.head.querySelector("[name~=csrf-token][content]").content;
    let baseURL = window.location.origin;

    fetch(baseURL.concat('/herramientas/multimedia'), {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': csrfToken
        },
        body: JSON.stringify({
            "Busqueda": busqueda,
            "Artista": artista
        })
    }).then((response) => response.json())
    .then((result) => {

        switch(result.code){
            case 200:
                {
                    document.getElementById("video-frame").src = "https://www.youtube.com/embed/".concat(result.data.Id,"?controls=0&rel=0&autoplay=1&mute=1&disablekb=1&loop=1&modestbranding=1&showinfo=0");
                }
                break;
            case 500:
                {
                    SweetAlert.fire({
                        title: '¡Error!',
                        html: result.data,
                        imageUrl: baseURL.concat("/assets/templates/SadOwl.png"),
                        imageWidth: 100,
                        imageHeight: 123,
                        background: '#000000',
                        color: '#FFFFFF',
                        imageAlt: 'Error Image'
                    });

                    document.getElementById("video-frame").src = "";
                }
            break;
            default:
                {
                    document.getElementById("video-frame").src = "";
                }
                break;
        }

    }).catch((ex) => {
        SweetAlert.fire({
            title: '¡Error!',
            html: ex,
            imageUrl: baseURL.concat("/assets/templates/SadOwl.png"),
            imageWidth: 100,
            imageHeight: 123,
            background: '#000000',
            color: '#FFFFFF',
            imageAlt: 'Error Image'
        });
        document.getElementById("video-frame").src = "";
    });
}

function loadTrack(track_index) {

    if (music_list.length > 0) {
        clearInterval(updateTimer);
        reset();

        let cancion = music_list[track_index];

        curr_track.src = cancion.Ruta;

        //Obtener metadatos:
        ObtenerMetadatos(cancion.NombreArchivo);

        playTrack();

        document.getElementById("slider").setAttribute('min', 0);

        curr_track.addEventListener('ended', pistaSiguiente);
        updateTimer = setInterval(setUpdate, 1000);

        setTimeout(function () {
            let duracion = parseInt(curr_track.duration);
            document.getElementById("slider").setAttribute('max', duracion);
            let durationMinutes = parseInt(duracion / 60);
            let durationSeconds = parseInt(duracion - (durationMinutes * 60));

            durationSeconds = ("0".concat(durationSeconds)).slice(-2);
            durationMinutes = ("0".concat(durationMinutes)).slice(-2);
            document.getElementById("duracion").innerText = durationMinutes.concat(":", durationSeconds);


        }, 1000);
    }
}

/*Events*/

document.getElementById("fileUpload").addEventListener('change', (e) => {

    let preloader = document.getElementById('preloader');
    preloader.hidden = false;

    track_index = 0
    let blob = window.URL || window.webkitURL;
    if (!blob) {
        preloader.hidden = true;
        alert('Your browser does not support Blob URL!');
        return;
    }

    music_list.forEach(item => {
        URL.revokeObjectURL(item.Ruta);
    });

    music_list = [];

    document.getElementById("anterior").disabled = false;
    document.getElementById("play-pause").disabled = false;
    document.getElementById("siguiente").disabled = false;

    let element = document.getElementById("fileUpload");
    let files = element.files;

    let fileURL;
    let busqueda;

    Array.from(files).map(file => {
        fileURL = blob.createObjectURL(file);
        busqueda = file.name.replace(/\.[^/.]+$/, "");

        music_list.push({
            Ruta: fileURL,
            NombreArchivo: busqueda
        });

    });

    preloader.hidden = true;

    loadTrack(track_index);

});

document.getElementById('open-files').addEventListener('click', (e) => {
    document.getElementById('fileUpload').click();
});

document.getElementById("play-pause").addEventListener('click', (e) => {
    isPlaying ? pauseTrack() : playTrack();
});

document.getElementById("siguiente").addEventListener('click', (e) => {
    pistaSiguiente();
});

document.getElementById("anterior").addEventListener('click', (e) => {
    if(this.prop('disabled') === false) {
        if (track_index > 0) {
            track_index -= 1;
        } else {
            track_index = music_list.length - 1;
        }
        loadTrack(track_index);
    }
});

document.getElementById("slider").addEventListener('change', (e) => {
    let seekPosition = parseInt(document.getElementById("slider").value);
    let currentMinutes = parseInt(seekPosition / 60);
    let currentSeconds = parseInt(seekPosition - (currentMinutes * 60));

    currentSeconds = ("0".concat(currentSeconds)).slice(-2);
    currentMinutes = ("0".concat(currentMinutes)).slice(-2);

    document.getElementById("progreso").innerText = currentMinutes.concat(":", currentSeconds);

    curr_track.currentTime = seekPosition;
});

/*Functions*/

function reset() {
    document.getElementById("progreso").innerText = "00:00";
    document.getElementById("duracion").innerText = "00:00";
    document.getElementById("slider").value;
}

async function playTrack() {
    if(document.getElementById("play-pause").disabled === false) {
        await curr_track.play();
        isPlaying = true;
        document.getElementById("slider").disabled = false;
        document.getElementById("play-pause").classList.remove("fa-play-circle");
        document.getElementById("play-pause").classList.add("fa-pause-circle");
    }
}

async function pauseTrack() {
    if (document.getElementById("play-pause").disabled === false) {
        await curr_track.pause();
        isPlaying = false;
        document.getElementById("slider").disabled = true;
        document.getElementById("play-pause").classList.remove("fa-pause-circle");
        document.getElementById("play-pause").classList.add("fa-play-circle");
    }
}

function pistaSiguiente() {
    if (document.getElementById("siguiente").disabled === false) {
        if (track_index < music_list.length - 1) {
            track_index += 1;
        } else if (track_index < music_list.length - 1) {
            let random_index = Number.parseInt(Math.random() * music_list.length);
            track_index = random_index;
        } else {
            track_index = 0;
        }
        loadTrack(track_index);
    }
}

function setUpdate() {
    if (!isNaN(curr_track.duration)) {
        let seekPosition = parseInt(curr_track.currentTime);

        let currentMinutes = parseInt(seekPosition / 60);
        let currentSeconds = parseInt(seekPosition - (currentMinutes * 60));

        currentSeconds = ("0".concat(currentSeconds)).slice(-2);
        currentMinutes = ("0".concat(currentMinutes)).slice(-2);

        document.getElementById("progreso").innerText = currentMinutes.concat(":", currentSeconds);
        document.getElementById("slider").value = seekPosition;
    }
}
