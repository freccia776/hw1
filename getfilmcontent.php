<?php

header('Content-Type: application/json');

$id = isset($_GET['id']) ? $_GET['id'] : null;

$api_key = "secret";

function getApiJson($url) {
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    
    $result = curl_exec($ch);
    curl_close($ch);
    return json_decode($result, true);
}

$contentList = array();

// Info film
$url = "https://api.themoviedb.org/3/movie/$id?api_key=$api_key&language=it-IT";
$film = getApiJson($url);

// Cast
$credits_url = "https://api.themoviedb.org/3/movie/$id/credits?api_key=$api_key&language=it-IT";
$credits = getApiJson($credits_url);

if (!$film || !isset($film['title'])) {
    echo json_encode(array("error" => "Film non trovato."));
    exit;
}

$titolo = $film['title'];
$anno = isset($film['release_date']) ? substr($film['release_date'], 0, 4) : 'N/D';
$rate = isset($film['vote_average']) ? $film['vote_average'] . "/10" : 'N/D';
$trama = isset($film['overview']) ? $film['overview'] : 'Trama non disponibile';
$genere = isset($film['genres'][0]['name']) ? $film['genres'][0]['name'] : 'N/D';

$copertina = isset($film['poster_path']) ? "https://image.tmdb.org/t/p/w400" . $film['poster_path'] : "";

$cast = array();
if (isset($credits['cast'])) {
    foreach (array_slice($credits['cast'], 0, 5) as $attore) {
        $cast[] = $attore['name'];
    }
}

// Trailer
$videos_url = "https://api.themoviedb.org/3/movie/$id/videos?api_key=$api_key&language=it-IT";
$videos = getApiJson($videos_url);

$trailer_key = null;
if (isset($videos['results'])) {
    foreach ($videos['results'] as $video) {
        if ($video['type'] === 'Trailer' && $video['site'] === 'YouTube') {
            $trailer_key = $video['key'];
            break;
        }
    }
}

$contentList = [
    'filmid' => $id,
    'titolo' => $titolo,
    'anno' => $anno,
    'rate' => $rate,
    'trama' => $trama,
    'genere' => $genere,
    'copertina' => $copertina,
    'cast' => $cast,
    'trailer' => $trailer_key
];

echo json_encode($contentList);
?>