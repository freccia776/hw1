<?php

include 'auth.php';
    if (checkAuth()) {
        header('Location: index.php');
        exit;
    }

if(!empty($_POST["email"]) && !empty($_POST["password"])){

    $conn = mysqli_connect($dbconfig['host'], $dbconfig['user'], $dbconfig['password'], $dbconfig['name']) or die(mysqli_connect_error());

    $email = mysqli_real_escape_string($conn, $_POST["email"]);
    
    $query = "SELECT * FROM users WHERE email = '".$email."'";
    $res = mysqli_query($conn, $query) or die(mysqli_error($conn));

    $num_rows = mysqli_num_rows($res); 
    if (mysqli_num_rows($res) > 0) {
           
            $entry = mysqli_fetch_assoc($res);
            if (password_verify($_POST['password'], $entry['password'])) {

                

                $_SESSION["email"] = $entry['email'];
                $_SESSION["username"] = $entry['username']; 
                

                header("Location: index.php");
                mysqli_free_result($res);
                mysqli_close($conn);
                exit;
            }
        }
        
        $error = "Email e/o password errati.";
        mysqli_close($conn); // DA CONTROLLARE PER EVENTUALI ERRORI
}
 else if (isset($_POST["email"]) || isset($_POST["password"])) {
        
        $error = "Inserisci email e password.";
    }



?>

<!DOCTYPE html>
<html lang = "it">

<head>
    <meta charset="utf-8">
    <title>Chili: Login</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="login.css" />

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,100..900;1,100..900&display=swap" rel="stylesheet">
    <script src="login.js" defer></script>
    
</head>

<body>

  
    <header>
        <nav class="navbar">
       
          <a href="index.php">
            <img class="logo" src="./icon/logobianco.svg" />
          </a>
        
        </nav>
    
    </header>  
    
    <div id="intro-text">
            <h1>PRIME VISIONI, MIGLIAIA DI FILM E CANALI</h1>
        <div>

       
        <main class="login">
            
            <div class= 'switch'>
                <a class = "reg" href= "registration.php">REGISTRATI</a>
                <a class ="log" href= "login.php">ACCEDI</a>
            </div>

            <div id="error-container">
                <div id = 'error'>
                    <?php
                        if (isset($error)) {
                            if (is_array($error)) {
                                foreach ($error as $err) {
                                    echo "<p class='error'>$err</p>";
                                }
                            } else {
                                echo "<p class='error'>$error</p>";
                            }
                        }
                    ?>  
                </div>
             </div>
                

                

                
                <form id = 'form-login' name='login' method='post'>
                   
                    <div class= "riga">
                        <div class="email data">
                            <label for='email'>Email</label>
                            <input type='email' name='email' <?php if(isset($_POST["email"])){echo "value=".$_POST["email"];} ?>>
                            <span>Campo obbligatorio*</span>
                        </div>
                        <div class="password data">
                            <label for='password'>Password</label>
                            <input type='password' name='password'>
                            <span>Campo obbligatorio*</span>
                        </div>

                    </div>
                    
                    <div id="submit">
                        <button type="submit" class="accedi">ACCEDI</button>
                    </div>
                    
                </form>
             
          
        </main>
               

</body>

</html>