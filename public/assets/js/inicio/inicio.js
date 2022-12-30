document.addEventListener('DOMContentLoaded', function() {
    window.Memes.fromReddit().then((meme)=>{
        document.getElementById("imagen-meme").src = meme.image;
    });
}, false);
