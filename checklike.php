<?php
require_once 'auth.php';
require_once 'dbconfig.php';

header('Content-Type: application/json');

// Ottieni username dalla sessione
$username = checkAuth(); 
if (!$username) {
    echo json_encode(["liked" => false]);
    exit;
}

// Ottieni ID del film dalla query string
$filmid = isset($_GET['id']) ? $_GET['id'] : null;
if (!$filmid) {
    echo json_encode(["liked" => false]);
    exit;
}

// Connessione al database
$conn = mysqli_connect($dbconfig['host'], $dbconfig['user'], $dbconfig['password'], $dbconfig['name']);
if (!$conn) {
    echo json_encode(["liked" => false]);
    exit;
}

// Recupera l'ID numerico dell'utente
$username = mysqli_real_escape_string($conn, $username);
$query = "SELECT id FROM users WHERE username = '$username'";
$res = mysqli_query($conn, $query);
if (!$res || mysqli_num_rows($res) === 0) {
    echo json_encode(["liked" => false]);
    exit;
}

$row = mysqli_fetch_assoc($res);
$user_id = $row['id'];

// Verifica se esiste già quel film salvato per quell'utente
$filmid = mysqli_real_escape_string($conn, $filmid);
$checkQuery = "SELECT * FROM wishlist WHERE user_id = $user_id AND film_id = '$filmid'";
$checkRes = mysqli_query($conn, $checkQuery);

if ($checkRes && mysqli_num_rows($checkRes) > 0) {
    echo json_encode(["liked" => true]);
} else {
    echo json_encode(["liked" => false]);
}

mysqli_close($conn);
?>
