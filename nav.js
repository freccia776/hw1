//VARIABILE GLOBALE per memorizzare il menu originale in menuClick()
let originalMenu = null;  

//LOGGED SIDEBAR
function loggedSidebar() {
    const sidebar = document.querySelector('.infoprofile-desktop');
    sidebar.classList.toggle('hidden');
}

function closeSidebar() {
    const sidebar = document.querySelector('.infoprofile-desktop');
    sidebar.classList.add('hidden');
}


const loggedprofile = document.querySelector('.loggedprofile');
if (loggedprofile) {
    loggedprofile.addEventListener('click', loggedSidebar);
}

const closeloggedIcon = document.querySelector('.close-loggedsidebar');
if (closeloggedIcon) {
    closeloggedIcon.addEventListener('click', closeSidebar);
}



// TMDB API PER LA BARRA DI RICERCA DEI FILM



//ONJSON TMDB
function onJson(json) {
    console.log("JSON ricevuto:", json);
   
    const risultati = document.querySelector("#risultati");
    risultati.innerHTML = ""; 

    if (!json || json.length === 0) {
        const noResultsText = document.createElement("p");
        noResultsText.textContent = "Nessun Risultato trovato.";
        noResultsText.classList.add("bianco"); 
        risultati.appendChild(noResultsText);
        return; 
    }

    for (let i = 0; i < json.length; i++) {
        const movie = json[i];
        const title = movie.titolo;
        const id = movie.id;
        const poster_url = movie.copertina ? movie.copertina : "./copertine/placeholder.jpg";

        const film = document.createElement("div");
        film.classList.add("film");

        const link = document.createElement("a");
        link.href = `content.php?id=${id}`;

        const img = document.createElement("img");
        img.src = poster_url;

        const caption = document.createElement("span");
        caption.textContent = title;

        link.appendChild(img);
        link.appendChild(caption);
        film.appendChild(link);
        risultati.appendChild(film);
    }
}


//ONRESPONSE TMDB
function onResponse(response) {
    console.log("Risposta ricevuta");
    return response.json();
  }
  

//SEARCH TMDB
function search(event)
{
  
     event.preventDefault();
     

 
  //form attuale
  const form = event.currentTarget;
 
  const primapagina = document.querySelector("#sliderpage");
  const main = document.querySelector("#main");
  const ricerca = document.querySelector(".ricerca");

    
  //aggiungo e rimuovo hidden  
  if(primapagina){
     primapagina.classList.add("hidden"); 
  }
 
  main.classList.add("hidden");
  ricerca.classList.remove("hidden");
   


 //utilizzo il form attuale per utilizzare il suo input value 
  const input = form.querySelector(".search-input");
  
  //modifico il testo
  const text = document.querySelector(".ricerca h1 span");
  text.textContent = input.value;
  //encodeURIComponent 
  const input_value = encodeURIComponent(input.value);
  console.log("Eseguo ricerca: " + input_value);

  //richiesta:
  /* 
 rest_url = "/getsearch.php?query=" + input_value;
 console.log("URL: " + rest_url); */
  
 //fetch
 fetch(`getsearch.php?query=${input_value}`).then(onResponse).then(onJson);
  
}

const form1 = document.querySelector("#form1"); //uno è quello normale e l'altro è per smartphone
const form2 = document.querySelector("#form2");
form1.addEventListener("submit", search)
form2.addEventListener("submit", search)




function menuClick(event) {

    const menu = event.currentTarget;
    const sidebar = document.querySelector(".sidebar");
    const menuoverlay = document.querySelector("#menuoverlay");
    const logo = document.querySelector(".sinistra .logo");
    const body = document.querySelector("body");

    if(sidebar.dataset.open === "false") { //quando la apro

        if(!originalMenu){
            originalMenu = menu.innerHTML; // Salvo il menu originale
        }

        const closeIcon  =  document.createElement("img");
        closeIcon.src = "icon/close-icon.svg";
        closeIcon.classList.add("closeicon");
        //DISABILITO SCROLL
        body.classList.add("noscroll"); 
        sidebar.classList.remove("hidden");

        //MODIFICO GLI ZINDEX
        menu.classList.add("sopraside"); 
        logo.classList.add("sopraside"); 
        menuoverlay.classList.remove("hidden");

        menu.innerHTML = "";
        menu.appendChild(closeIcon);

        sidebar.dataset.open = "true"
    }
    else{  //quando la chiudo

        sidebar.classList.add("hidden");
        //ABILITO SCROLL
        body.classList.remove("noscroll");
        //MODIFICO ZINDEX
        menu.classList.remove("sopraside");
        logo.classList.remove("sopraside"); 

        menuoverlay.classList.add("hidden");

         //RIPRISTINO IL MENU ORIGINALE
        menu.innerHTML = originalMenu;

          sidebar.dataset.open = "false";
    }
}


//FUNZIONE PER POPOLARE IL MENU SIDEBAR
function populateSidebar(){

    const links = document.querySelectorAll("#links li a");
    const sidebar = document.querySelector(".sidebar");  
    const ul = document.createElement("ul");

    for(let i = 0; i< links.length; i++){

        const link = links[i];

        const li = document.createElement("li");
        const a = document.createElement("a");

        a.href = link.href;
        a.textContent = link.textContent;
        li.appendChild(a);
        ul.appendChild(li);
    }

    sidebar.innerHTML = ""; 
    sidebar.appendChild(ul);

}


// BIG SEARCH


function closeClick(event){
   
    const bigsearch = document.querySelector(".bigsearch");
    const navbar = document.querySelector(".navbar");

    bigsearch.classList.add("hidden");
    navbar.classList.remove("hidden");

    bigsearch.dataset.open = "false";

    event.currentTarget.removeEventListener("click", closeClick); 
}

function searchClick(){
   
   const bigsearch = document.querySelector(".bigsearch");
   const navbar = document.querySelector(".navbar");
   const closebtn = document.querySelector(".close-btn");

   bigsearch.classList.remove("hidden"); 
   navbar.classList.add("hidden"); 

   bigsearch.dataset.open = "true";

   closebtn.addEventListener("click", closeClick); 
   
   
    
}

function profileClick(event){
    const profilebar = document.querySelector(".profilebar");
    const overlay = document.querySelector("#menuoverlay");
    const img = document.querySelector(".profilo img");
    const logo = document.querySelector(".sinistra .logo");
    const menu = document.querySelector(".menu");
    const profilo = event.currentTarget;
    const body  = document.querySelector("body");

    if(profilebar.dataset.open === "false") {
        console.log("Apro il profilo");
        profilebar.classList.remove("hidden");
        overlay.classList.remove("hidden"); 
        //DISABILITO SCROLL
        body.classList.add("noscroll"); 

        //MODIFICO GLI ZINDEX
        menu.classList.add("sottoside"); 
        logo.classList.add("sottoside"); 
        profilo.classList.add("sopraside"); 

        img.src = "icon/close-icon.svg"; 
        img.classList.add("closeicon");
        profilebar.dataset.open = "true";
        
    }

    else{
        profilebar.classList.add("hidden");
        overlay.classList.add("hidden"); 
        //ABILITO SCROLL
        body.classList.remove("noscroll");
        //MODIFICO ZINDEX
        logo.classList.remove("sottoside"); 
        menu.classList.remove("sottoside"); 
        profilo.classList.remove("sopraside"); 


        img.src = "icon/profilo.svg"; 
        img.classList.remove("closeicon");
        profilebar.dataset.open = "false";
    }
   

}

//PROFILE BAR
const profilo = document.querySelector(".profilo");
profilo.addEventListener("click", profileClick);



//SEARCH
const search_btn = document.querySelector("#search_btn");
search_btn.addEventListener("click", searchClick);

//POPOLA MENU ALL'AVVIO
populateSidebar();

//EVENTO MENU
const menu = document.querySelector(".menu");
menu.addEventListener("click", menuClick);
