
<?php

require_once 'dbconfig.php';
header('Content-Type: application/json');

$conn = mysqli_connect($dbconfig['host'], $dbconfig['user'], $dbconfig['password'], $dbconfig['name']);

$query = "SELECT type, url FROM slider_images ORDER BY id ASC";
$res = mysqli_query($conn, $query) or die(mysqli_error($conn));

$desktop = [];
$smart = [];

while ($row = mysqli_fetch_assoc($res)) {
    if ($row['type'] === 'desktop') {
        $desktop[] = $row['url'];
    } elseif ($row['type'] === 'smart') {
        $smart[] = $row['url'];
    }
}

echo json_encode([
    "desktop" => $desktop,
    "smart" => $smart
]);

mysqli_close($conn);
?>