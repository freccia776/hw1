<?php

  require_once 'auth.php';

    if (checkAuth()) {
        header("Location: index.php");
        exit;
    }   

    // Verifica l'esistenza di dati POST
    if (!empty($_POST["username"]) && !empty($_POST["password"]) && !empty($_POST["email"]) && !empty($_POST["nome"]) && 
        !empty($_POST["cognome"]) &&  !empty($_POST["gender"]) && !empty($_POST["confirm_password"]) && !empty($_POST["allow"]))
    {
        $error = array();
        $conn = mysqli_connect($dbconfig['host'], $dbconfig['user'], $dbconfig['password'], $dbconfig['name']) or die(mysqli_error($conn));

        
        # USERNAME
        // Controlla che l'username rispetti il pattern specificato
        if(!preg_match('/^[a-zA-Z0-9_]{1,15}$/', $_POST['username'])) {
            $error[] = "Username non valido";
        } else {
            $username = mysqli_real_escape_string($conn, $_POST['username']);
            // Cerco se l'username esiste già o se appartiene a una delle 3 parole chiave indicate
            $query = "SELECT username FROM users WHERE username = '$username'";
            $res = mysqli_query($conn, $query);
            if (mysqli_num_rows($res) > 0) {
                $error[] = "Username già utilizzato";
            }
        }

         # EMAIL
        if (!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
            $error[] = "Email non valida";
        } else {
            $email = mysqli_real_escape_string($conn, strtolower($_POST['email']));
            $res = mysqli_query($conn, "SELECT email FROM users WHERE email = '$email'");
            if (mysqli_num_rows($res) > 0) {
                $error[] = "Email già utilizzata";
            }
        }

        # PASSWORD
        if (strlen($_POST["password"]) < 8) {
            $error[] = "Caratteri password insufficienti";
        } 
        # CONFERMA PASSWORD
        if (strcmp($_POST["password"], $_POST["confirm_password"]) != 0) {
            $error[] = "Le password non coincidono";
        }
       


        # REGISTRAZIONE NEL DATABASE
        if (count($error) == 0) {
            $nome = mysqli_real_escape_string($conn, $_POST['nome']);
            $cognome = mysqli_real_escape_string($conn, $_POST['cognome']);
            $gender = mysqli_real_escape_string($conn, $_POST['gender']);
            $password = mysqli_real_escape_string($conn, $_POST['password']);
            $password = password_hash($password, PASSWORD_BCRYPT);

            $query = "INSERT INTO users(username, password, nome, cognome, email, gender) VALUES('$username', '$password', '$nome', '$cognome', '$email', '$gender')";
            
            if (mysqli_query($conn, $query)) {

                $_SESSION["username"] = $_POST["username"];
                $_SESSION["email"] = $_POST["email"];
                mysqli_close($conn);
                header("Location: index.php");
                exit;
            } else {
                $error[] = "Errore di connessione al Database";
            }
        }

        mysqli_close($conn); 
    }
    else if (isset($_POST["username"])) {
        $error = array("Riempi tutti i campi");
    }

?>



<!DOCTYPE html>
<html lang="it">
<head>
  <meta charset="utf-8">
  <title>Registrati</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="registration.css" />
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,100..900;1,100..900&display=swap"
    rel="stylesheet">
    <script src="registration.js" defer></script>
    
</head>

<body>
    ]
    <header>
        <nav class="navbar">
            <a href="index.php">
                <img class="logo" src="./icon/logobianco.svg" />
            </a>

        </nav>
    
    </header>  
    
    <div id="intro-text">
            <h1>Registrati a Chili</h1>
            <h3>Scopri migliaia di film e serie TV imperdibili GRATIS.</h3>
        <div>
    <main>

            <div class= 'switch'>
                <a class = "reg" href= "registration.php">REGISTRATI</a>
                <a class = "log" href= "login.php">ACCEDI</a>
            </div>
        

        <form id="form-reg" class="flex-box" method="post">

            
            <div class='riga inputriga'>
                <div class='nome data'>
                    <label>Nome*</label>
                    <input type="text" name='nome' <?php if(isset($_POST["nome"])){echo "value=".$_POST["nome"];} ?>>
                    <span>Devi inserire il nome</span>

                </div>
                <div class='cognome data'>
                    <label>Cognome*</label>
                    <input type="text"  name='cognome' <?php if(isset($_POST["cognome"])){echo "value=".$_POST["cognome"];} ?>>
                    <span>Devi inserire il cognome</span>
                </div> 
            </div> 
            
            <div class='riga inputriga'>
                <div class= 'username data'>
                    <label>username*</label>
                    <input type='text' name='username' <?php if(isset($_POST["username"])){echo "value=".$_POST["username"];} ?>>
                    <span></span>
                </div>
                <div class='email data'>
                    <label>email*</label>
                    <input type='email' name='email' <?php if(isset($_POST["email"])){echo "value=".$_POST["email"];} ?>>
                    <span></span>
                </div>
            </div>
            

            
            
            <div class= 'riga'>
                <div class="data">
                    <div class= "gender">
                        <label>Uomo<input type="radio" name="gender" value="uomo" <?php if(isset($_POST["gender"]) && $_POST["gender"]=="uomo") echo "checked"; ?>></label>
                        <label>Donna<input type="radio" name="gender" value="donna" <?php if(isset($_POST["gender"]) && $_POST["gender"]=="donna") echo "checked"; ?>></label>
                        <label>Preferisco non specificare<input type="radio" name="gender" value="preferisco non specificare" <?php if(isset($_POST["gender"]) && $_POST["gender"]=="preferisco non specificare") echo "checked"; ?>></label>
                    </div>
                    <span>Devi selezionare il genere</span>           
                </div>
            </div>

            <div class='riga inputriga'>
                <div class='password data'>
                    <label>password*</label>
                    <input type="password" name='password'>
                    <span>Inserisci almeno 8 caratteri</span>
                </div>

                <div class='confirm_password data'>
                    <label>conferma password*</label>
                    <input type="password" id='confermaPassword' name="confirm_password">
                    <span>Le password non coincidono</span>
                </div>
            </div>
            
            <div class='riga'>
                <div class="data">
                    <div class= "allow">
                        <input type='checkbox' name='allow' value="1" <?php if(isset($_POST["allow"])){echo $_POST["allow"] ? "checked" : "";} ?>>
                        <label for='allow'>Accetto i termini e condizioni d'uso di Chili.</label>
                    </div>      
                    <span>Devi accettare i termini e condizioni d'uso</span>
                </div>
            </div>


            <div id="error-container">
                <div id = 'error'>
                  
                    <?php
                        if (isset($error)) {
                            foreach ($error as $err) { 
                                echo "<p class='error'>$err</p>"; 
                            }
                        }
                    ?>
                </div>
             </div>
 
                      
                <div class="submit-button">
                        <button type="submit" class="registrati">REGISTRATI</button>
                </div>
           

        </form>
    </main>
</body>

</html>