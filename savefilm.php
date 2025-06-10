<?php
require_once 'dbconfig.php';
require_once 'auth.php';

$userid = checkAuth(); // username
if (!$userid) exit;


$filmid = isset($_GET['id']) ? $_GET['id'] : null;
if (!$filmid) exit;


$api_key = "secret";
function getApiJson($url) {
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    $result = curl_exec($ch);
    curl_close($ch);
    return json_decode($result, true);
}

$url = "https://api.themoviedb.org/3/movie/" . $filmid . "?api_key=" . $api_key . "&language=it-IT";
$filmData = getApiJson($url);
if (!$filmData || !isset($filmData['id'])) exit;


$filmJson = json_encode([
    'id' => $filmData['id'],
    'titolo' => $filmData['title'],
    'copertina' => isset($filmData['poster_path']) ? "https://image.tmdb.org/t/p/w400" . $filmData['poster_path'] : ""
]);


$conn = mysqli_connect($dbconfig['host'], $dbconfig['user'], $dbconfig['password'], $dbconfig['name']);
if (!$conn) exit;

// Escape username
$username = mysqli_real_escape_string($conn, $userid);

//ID da username
$query = "SELECT id FROM users WHERE username = '$username'";
$res = mysqli_query($conn, $query);
if (!$res || mysqli_num_rows($res) === 0) exit;

$row = mysqli_fetch_assoc($res);
$user_id_numeric = $row['id'];

// Inserisci nella tabella wishlist
$query = "INSERT INTO wishlist (user_id, film_id, content) VALUES ($user_id_numeric, '$filmid', '$filmJson')";
mysqli_query($conn, $query);

mysqli_close($conn);

echo json_encode(["ok" => true]);
?>
