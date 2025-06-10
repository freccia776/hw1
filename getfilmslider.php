<?php


header('Content-Type: application/json');
$api_key = "secret";


$tipo = 'nuovi';
if (isset($_GET['type']) && $_GET['type'] !== '') {
  $tipo = $_GET['type'];
}

// Costruzione URL in base al tipo
$url = '';

if ($tipo === 'nuovi') {
  $url = "https://api.themoviedb.org/3/movie/now_playing?api_key=$api_key";

} elseif ($tipo === 'top_rated') {
  $url = "https://api.themoviedb.org/3/movie/top_rated?api_key=$api_key";

} else {
  
  echo json_encode(["error" => "Tipo non valido"]);
  exit;
}

// Chiamata all'API esterna
$ch = curl_init($url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
$response = curl_exec($ch);
curl_close($ch);

$data = json_decode($response, true);
$filmList = [];

if (isset($data['results'])) {
  $maxFilms = 10;
  $results = array_slice($data['results'], 0, $maxFilms);

  foreach ($results as $film) {
    $titolo = 'Titolo sconosciuto';
    if (isset($film['title']) && $film['title'] !== '') {
      $titolo = $film['title'];
    }

    $img = '';
    if (isset($film['poster_path']) && $film['poster_path'] !== '') {
      $img = 'https://image.tmdb.org/t/p/w200' . $film['poster_path'];
    }

    $filmList[] = [
      'id' => $film['id'], 
      'titolo' => $titolo,
      'img' => $img,
      
    ];
  }
}

echo json_encode($filmList);
