<?php
 require_once 'auth.php';
    if (!$userid = checkAuth()) {
        header("Location: login.php");
        exit;
    }
 

?>

<!DOCTYPE html>
<html lang="it">
<head>
  <meta charset="utf-8">
  <title>Chili: Content</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="nav.css">
  <link rel="stylesheet" href="wishlist.css">
  <link rel="stylesheet" href="footer.css">
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin> 
  <link href="https://fonts.googleapis.com/css2?family=Roboto&display=swap" rel="stylesheet">
  <script src="nav.js" defer></script>
  <script src="footer.js" defer></script>
  <script src="wishlist.js" defer></script>
  
</head>

<body>
  <header>
    <?php include 'nav.php'; ?>
  </header>  

 

<!-- SEZIONE DI RICERCA -->
  <section class="ricerca info-container hidden">
    <h1>Risultati di ricerca: <span></span></h1>
    <div id="risultati"></div>
  </section>

  <!-- DETTAGLI FILM -->
  <main id= "main">
    <div class="liked">
        <h1>Film che mi piacciono:</h1>
        <div class= "liked-wrap"></div>
  
    </div>
  </main>

 <?php include 'footer.php'; ?> 
</body>
</html>
