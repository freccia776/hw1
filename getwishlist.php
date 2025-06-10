<?php
require_once 'dbconfig.php';
require_once 'auth.php';

$userid = checkAuth();
if (!$userid) {
    echo json_encode(["error" => "Not authorized"]);
    exit;
}

// Connessione
$conn = mysqli_connect($dbconfig['host'], $dbconfig['user'], $dbconfig['password'], $dbconfig['name']);
if (!$conn) {
    echo json_encode(["error" => "DB connection error"]);
    exit;
}

$username = mysqli_real_escape_string($conn, $userid);

// Ottieni ID numerico
$query = "SELECT id FROM users WHERE username = '$username'";
$res = mysqli_query($conn, $query);
if (!$res || mysqli_num_rows($res) === 0) {
    echo json_encode(["error" => "User not found"]);
    exit;
}
$row = mysqli_fetch_assoc($res);
$user_id_numeric = $row['id'];

// Recupera film dalla wishlist
$query = "SELECT content FROM wishlist WHERE user_id = $user_id_numeric ORDER BY id DESC";
$res = mysqli_query($conn, $query);
$films = [];

while ($row = mysqli_fetch_assoc($res)) {
    $films[] = json_decode($row['content'], true); // decodifica il JSON salvato
}

echo json_encode($films);

mysqli_close($conn);
?>
