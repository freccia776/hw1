function onJsonWishlist(json) {
    const container = document.querySelector('.liked-wrap');
    container.innerHTML = '';

    if (json.length === 0) {
        container.textContent = "Nessun film nella wishlist.";
        return;
    }

    for (let film of json) {
        const filmBox = document.createElement('div');
        filmBox.classList.add('film-box');

        // Copertina
        const img = document.createElement('img');
        img.src = film.copertina;
        img.alt = "Copertina di " + film.titolo;

        // Titolo
        const titolo = document.createElement('p');
        titolo.textContent = film.titolo;

        // Link al film
        const link = document.createElement('a');
        link.href = "content.php?id=" + film.id;
        link.appendChild(img);
        link.appendChild(titolo);

        filmBox.appendChild(link);
        container.appendChild(filmBox);
    }
}

function onResponseWishlist(response) {
    return response.json();
}

fetch("getwishlist.php")
    .then(onResponseWishlist)
    .then(onJsonWishlist);
