<?php
require_once 'dbconfig.php';
require_once 'auth.php';

$userid = checkAuth(); // userid è username
if (!$userid) exit;

$filmid = isset($_GET['id']) ? $_GET['id'] : null;
if (!$filmid) exit;

// Connessione al database
$conn = mysqli_connect($dbconfig['host'], $dbconfig['user'], $dbconfig['password'], $dbconfig['name']);
if (!$conn) exit;

// Escapa lo username per sicurezza
$username = mysqli_real_escape_string($conn, $userid);

//ID numerico dell'utente
$query = "SELECT id FROM users WHERE username = '$username'";
$res = mysqli_query($conn, $query);
if (!$res || mysqli_num_rows($res) === 0) exit;

$row = mysqli_fetch_assoc($res);
$user_id_numeric = $row['id'];

// Rimuovi il film dalla wishlist
$query = "DELETE FROM wishlist WHERE user_id = $user_id_numeric AND film_id = '$filmid'";
mysqli_query($conn, $query);

mysqli_close($conn);

echo json_encode(["ok" => true]);
?>
