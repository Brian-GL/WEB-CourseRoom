document.addEventListener('DOMContentLoaded', function() {
    document.getElementById("preloader").hidden = true;
    window.Memes.fromReddit("es").then((meme)=>{
        document.getElementById("imagen-meme").src = meme.image;
    });
}, false);

