<?php

require_once 'auth.php';
$userid = checkAuth(); // Ottiene l'ID se loggato, altrimenti false/null



if (!isset($_GET['id'])) {
  echo "<p>ID film mancante.</p>";
  exit;
}

//prendo id da url tramite get
$id = $_GET['id'];

    
?>

<!DOCTYPE html>
<html lang="it">
<head>
  <meta charset="utf-8">
  <title>Chili: Content</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="nav.css">
  <link rel="stylesheet" href="film.css">
  <link rel="stylesheet" href="footer.css"> 
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin> 
  <link href="https://fonts.googleapis.com/css2?family=Roboto&display=swap" rel="stylesheet">
  <script src="content.js" defer></script>
  <script src="nav.js" defer></script>
  <script src="footer.js" defer></script>
  
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
  <main id = "main">
    
    <div class="film-container" data-id="<?= $id ?>">
        <section class="film-info">
                <div class="film-poster">
                  
                
                </div>

                <div class= "smartphone-title">
                    <h1></h1>
                </div>

                <div class = "film-details">
                    <h1></h1>
                    <p></p>
                    <p></p> 
                    <p></p>    
                </div>

               <?php if ($userid): ?>
                  <div class="film-play">
                    <img id="notliked" src="./icon/notliked-icon.svg" />
                    <img id="liked" src="./icon/liked-icon.svg" />
                  </div>
              <?php endif; ?>

        </section>

        <section class= "film-description">
               <!--  TRAMA E CAST -->               
            <p></p>
            <p></p>
         
        </section>
        
        <section class="film-trailer">
           
        </section>
    </div> 
  </main>

  <?php include 'footer.php'; ?> 
</body>
</html>
