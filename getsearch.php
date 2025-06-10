<?php
header('Content-Type: application/json');


$TMDB_API_KEY = 'secret';

$query = isset($_GET['query']) ? $_GET['query'] : '';
if (empty($query)) {
    echo json_encode(['error' => 'Specificare un termine di ricerca']);
    exit;
}

// URL di ricerca su TMDb
$tmdb_url = 'https://api.themoviedb.org/3/search/movie?api_key=' . $TMDB_API_KEY .
            '&language=it-IT&query=' . urlencode($query);


$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $tmdb_url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

$response = curl_exec($ch);

curl_close($ch);


$data = json_decode($response, true);

$results = [];
if (isset($data['results'])) {
    $count = 0;
    foreach ($data['results'] as $item) {
        if ($count >= 10) break;
        $results[] = [
            'id' => $item['id'],
            'titolo' => $item['title'],
            'anno' => isset($item['release_date']) ? substr($item['release_date'], 0, 4) : 'N/D',
            'copertina' => isset($item['poster_path']) && $item['poster_path'] 
                ? 'https://image.tmdb.org/t/p/w200' . $item['poster_path'] 
                : null
        ];
        $count++;
    }
}

echo json_encode($results);
?>
