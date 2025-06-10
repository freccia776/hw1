


//SLIDER PRIMA PAGINA
let images = [];
let smartimages = [];
let currentIndex = 0; 

const imgprimapagina = document.querySelector(".image");
const imgsmart = document.querySelector(".smartimage");
const prevbtn = document.querySelector(".prev-btn");
const nextbtn = document.querySelector(".next-btn");


function updateImage(){

    imgsmart.src = smartimages[currentIndex]; 
    imgprimapagina.src = images[currentIndex];
}


function fetchSliderImages() {
    fetch("nuovifilmdisponibili.php")
        .then(function(response) {
            return response.json();
        })
        .then(function(json) {
            images = json.desktop;
            smartimages = json.smart;
            updateImage(); // inizializza con la prima immagine
        });
}


prevbtn.addEventListener("click", function(){

    currentIndex = (currentIndex - 1 + images.length) % images.length; 
    updateImage();
});


nextbtn.addEventListener("click", function(){

    currentIndex = (currentIndex + 1) % images.length;
    updateImage();
});

fetchSliderImages();






//FETCH ASINCRONA CARICAMENTO FILM SLIDER

function createFilmElement(film) {
  
  const slide = document.createElement('div');
  slide.className = 'mini-slide';

  
  const link = document.createElement('a');
  link.href = `content.php?id=${film.id}`;
  link.className = 'slide-content'; 

  
  const img = document.createElement('img');
  img.src = film.img;
  img.alt = film.titolo;

  
  const info = document.createElement('div');
  info.className = 'info';

  
  const title = document.createElement('h4');
  title.textContent = film.titolo;

  

  
  info.appendChild(title);
 
  link.appendChild(img);
  link.appendChild(info);
  slide.appendChild(link); 

  return slide;
}


function renderFilmsSection(films, containerId) {
  const container = document.getElementById(containerId);
  if (!container) return;

  container.innerHTML = '';
  for (let i = 0; i < films.length; i++) {
    const filmElement = createFilmElement(films[i]);
    container.appendChild(filmElement);
  }
}


function handleServerResponse(res) {
  if (!res.ok) {
    console.error('Errore HTTP', res.status);
    return null;
  }
  return res.json();
}


function processFilmData(data, containerId) {
  if (!data) return;
  renderFilmsSection(data, containerId);
}

function loadFilmSlider(sliderType, containerId) {
  fetch(`getfilmslider.php?type=${sliderType}`)


    .then(handleServerResponse)
    .then(function(data) {
      processFilmData(data, containerId);
    })
    
}


loadFilmSlider("nuovi", "film-slider-nuovi");
loadFilmSlider("top_rated", "film-slider-piu-votati");

