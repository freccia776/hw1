const filmc = document.querySelector('.film-container');
const filmId = filmc.dataset.id;



function onJsonContent(json) {
    if (json.error) {
        document.getElementById('main').textContent = "Film non trovato.";
        return;
    }
    
    const film = json;

    // Selettori
    const filmContainer = document.querySelector('.film-container');
    const posterDiv = filmContainer.querySelector('.film-poster');
    const smartphoneTitle = filmContainer.querySelector('.smartphone-title h1');
    const detailsDiv = filmContainer.querySelector('.film-details');
    const descriptionDiv = filmContainer.querySelector('.film-description');
    const trailerSection = filmContainer.querySelector('.film-trailer');

    // Copertina
    posterDiv.innerHTML = '';
    if (film.copertina) {
        const img = document.createElement('img');
        img.src = film.copertina;
        img.alt = "Copertina di " + film.titolo;
        posterDiv.appendChild(img);
    }

    // Titolo (smartphone e desktop)
    smartphoneTitle.textContent = film.titolo;
    detailsDiv.querySelector('h1').textContent = film.titolo;

    // Dettagli film
    const details = detailsDiv.querySelectorAll('p');
    // Genere
    details[0].textContent = "Genere: " + film.genere;
    // Anno
    details[1].textContent = "Anno: " + film.anno;
    // Voto
    details[2].textContent = "Voto: " + film.rate;

    // Trama e Cast
    const descP = descriptionDiv.querySelectorAll('p');
    descP[0].textContent = "Trama: " + film.trama;

    // Cast senza join e senza innerHTML
    let castString = "Cast: ";
    for (let i = 0; i < film.cast.length; i++) {
        castString += film.cast[i];
        if (i < film.cast.length - 1) {
            castString += ", ";
        }
    }
    descP[1].textContent = castString;

    // Trailer
    trailerSection.innerHTML = '';
    if (film.trailer) {
        const iframe = document.createElement('iframe');
        iframe.src = "https://www.youtube.com/embed/" + film.trailer;
        iframe.setAttribute('frameborder', '0');
        iframe.setAttribute('allowfullscreen', '');
        trailerSection.appendChild(iframe);
    } else {
        const nondisponibile =  document.createElement('p');
        nondisponibile.textContent = "Trailer non disponibile.";
        trailerSection.appendChild(nondisponibile);
    }
}


function onResponseContent(response){
    return response.json();
}


function getFilmContent() {
    fetch("getfilmcontent.php?id=" + filmId)
        .then(onResponseContent)
        .then(onJsonContent);
}





getFilmContent();


function onJsonCheckLike(json){
    const likedicon = document.getElementById("liked");
    const notlikedicon = document.getElementById("notliked"); 

    
    
   if (json.liked) {
      console.log("è liked");
      likedicon.classList.remove("hidden");
      notlikedicon.classList.add("hidden");
    } else {
        console.log("non è liked");
      likedicon.classList.add("hidden");
      notlikedicon.classList.remove("hidden");
    }
}

function onResponseCheckLike(response){
    return response.json();
}

function checkLike(){
      fetch("checklike.php?id=" + filmId)
        .then(onResponseCheckLike)
        .then(onJsonCheckLike);
}

checkLike();



function onJsonSave(json){
 if(json.ok){
        console.log("Film salvato nella wishlist!" + filmId);
        checkLike();
    }
}


function onResponseSave(response){
     return response.json();

}




function saveFilm(){

    fetch("savefilm.php?id=" + filmId)
    .then(onResponseSave)
    .then(onJsonSave);
}



const notliked = document.getElementById("notliked");
notliked.addEventListener("click", saveFilm);


function removeFilm() {
  fetch("removefilm.php?id=" + filmId)
    .then(onResponseSave)
    .then(onJsonRemove);
}

function onJsonRemove(json){
  if(json.ok){
    console.log("Film rimosso dalla wishlist: " + filmId);
    checkLike(); // aggiorna icone
  }
}

const liked = document.getElementById("liked");
liked.addEventListener("click", removeFilm);





