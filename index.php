<?php
session_start();
?>

<html lang="it">

<head>

  <meta charset="utf-8">
  <title>CHILI: REPLICA</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="homepage.css" /> 
  <link rel="stylesheet" href="nav.css"/>
  <link rel="stylesheet" href="footer.css"> 
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,100..900;1,100..900&display=swap"
    rel="stylesheet">
  <script src="homepage.js" defer></script>
   <script src="nav.js" defer></script>
</head>

<body>
  <header>



 <!-- NAV BAR -->
  <?php include 'nav.php'; ?>
   
    


    <div class="img-primapagina" id="sliderpage">

      <div id="overlay"></div>
      <img class="image"/>
      <img class="smartimage"/> <!-- nascosta inizialmete su modalità desktop-->
      <div class="contenuto">
        <a>NOVITÀ</a>
        <h1>Nuovi film disponibili</h1>
        <p>Guardali subito</p>
      </div>

      <button class="prev-btn">&#10094;</button>
      <button class="next-btn">&#10095;</button>

    </div>


  </header>


  <!-- CATEGORIE -->
  <div id="main">
    <div class="sezioni-contenitore">
      <!-- SINGOLA SEZIONE -->
      <section class="sezione">

        <div class="titolo-sezione">
          <h2>Ultimi Aggiunti</h2>
          <button>&#10095;</button>
        </div>

        <div class="mini-slider" id= "film-slider-nuovi">
           <!-- QUI VERRANNO AGGIUNTI I FILM -->
        
          <div class="mini-slide">
          </div>
            

          

        </div>

      </section>


      <section class="sezione">

        <div class="titolo-sezione">
          <h2>Più Votati</h2>
          <button>&#10095;</button>
        </div>

        <div class="mini-slider" id = "film-slider-piu-votati">

          

        </div>

      </section>

   
  

    

    </div>
  </div>

  <!-- SEZIONE DI RICERCA -->

  <section class="ricerca info-container hidden">
    <h1>Risultati di ricerca: <span></span></h1>
    <div id="risultati"></div>
  </section>


  <!--FOOTER-->
     <?php include 'footer.php'; ?> 
  
</body>

</html>