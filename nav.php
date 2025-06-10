
<?php
$benvenuto = '';

if(isset($_SESSION["username"])){
    
    $nav = '<div class="wishlist">
                <a href="wishlist.php" class="wishlist-link">
                    
                  <img src="./icon/notliked-icon.svg" />
                </a>
            </div>
    
            <div class="loggedprofile">
                <img src="./icon/profilo.svg" />
                
            </div>

          
            
            ';

    
 $smartphonenav = '<div class="profilebar hidden" data-open="false">
                        <div class="infoprofile">
                            <ul>
                                <li>
                                    <h2>Ciao, '.$_SESSION["username"].'</h2>
                                </li>

                                <li>
                                    <a href="wishlist.php">PREFERITI</a>
                                </li>
                                
                                <li>
                                    <a href="logout.php">LOGOUT</a>
                                </li>
                                
                            </ul>
                        </div>
                   </div>';

  $benvenuto = '<div class="infoprofile-desktop hidden">
                      <div class="closeinfoprofile">  
                        <img src="./icon/close-icon.svg" alt="Chiudi" class="close-loggedsidebar" />
                      </div>
                      <ul>
                        
                          <li> 
                              <h2>Ciao, '.$_SESSION["username"].'</h2>
                          </li>
                          <li>
                              <div class="logout">
                                  <a href=\'logout.php\' class=\'button\'>LOGOUT</a>
                              </div>
                          </li>
                      </ul>
                </div>';
                        
}else{

   

   


    $nav = '<div class="autenticazione">
                <ul class="auth">
                    <li>
                        <a href="registration.php" class="registrati" data-text="Registrati">Registrati</a>
                    </li>
                    <li>
                        <a href="login.php" class="accedi" data-text="Accedi">Accedi</a>
                    </li>
                </ul>
            </div>';


           

     $smartphonenav = '<div class="profilebar hidden" data-open="false">
                            <div class="authbar">
                                <ul class="auth">
                                    <li>
                                        <a href="registration.php" class="registrati" data-text="Registrati">Registrati</a>
                                    </li>
                                    <li>
                                        <a href="login.php" class="accedi" data-text="Accedi">Accedi</a>
                                    </li>
                                </ul>

                            </div>
                            <p class="pbar">Registrati e scopri migliaia di film e serie TV imperdibili, anche GRATIS.</p>
                            <p class="pbar">Qualunque sia il tuo film, su CHILI cè!</p>
                            <p id="codice">Hai un codice?</p>
                        </div>';      
            
}



echo '<nav class="navbar">
      <div class="sinistra">
        <div class="menu">
          <div class="linea"></div>
          <div class="linea"></div>
          <div class="linea"></div>
        </div>
        <div class="sidebar hidden" data-open="false"></div>
        <div id="menuoverlay" class="hidden"></div>
        <img class="logo" src="./icon/logobianco.svg" />
        <ul id="links">
          <li><a href="index.php">Home</a></li>
          <li><a href="#">Store</a></li>
          <li><a href="#">Gratis</a></li>
          <li><a href="#">Canali</a></li>
        </ul>
      </div>

      <div class="destra">
        <div class="search-container">
          <form id="form1">
            <input type="text" placeholder="Cerca..." name="search" class="search-input">
            <button type="submit"></button>
          </form>
        </div>


        <button id="search_btn"></button>

        '/*QUELLA PER SMARTPHONE*/.'
        '.$smartphonenav.'

        <div class="profilo"> '/*profilo nav smartphone*/.'
            <img src="./icon/profilo.svg" />
        </div>

            '.$nav.'
            '.$benvenuto.'
            

         
      </div>
    </nav>
    
    <div class="bigsearch hidden" data-open="false">

      <button class="close-btn"></button>
      <form id="form2">
        <input type="text" class="search-input" placeholder="Cerca">
        <button type="submit" class="search-btn"></button>
      </form>


    </div>';


    ?>