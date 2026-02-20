<?php

    // File Php Contenente la logica applicativa legata al login
    

    include 'db.php';   // Connessione al database
?>
<body>
    <?php

        if(isset($_POST['username']) && isset($_POST['password'])){ //Verifico che la username e la pasword siano state settate correttamente
            
            $user = $_POST['username']; // Salvo username e password
            $pass = $_POST['password'];


            $hash = get_pwd($user, $db);    // Carico l'hash della password relativa all'username inviato per farne il controllo

            if($hash == false){     //Caso Utente non registrato in database

                header("Location: login.php?err=1");    // Ritorno a login.php con id errore 1
                exit();

            }
            else{
                if(password_verify($pass, $hash)){  // Caso di password corretta

                    $_SESSION['username'] = $user;  // Aggiorno la sessione e reindirizzo alla pagina principale
                    echo "<meta http-equiv='Refresh' content='0; URL=index.php'>";

                }
                else{   //Caso Password Errata

                    header("Location: login.php?err=2");    // Ritorno a login.php con id errore 2
                    exit();

                }
            }
        }
        else {
            exit(); //Accesso non consentito
        }


        function get_pwd($user, $db){   // Funzione che consente di ottenere la password a partire dall'utente

            $sql = "SELECT password FROM utente WHERE username=$1;";    // Query per ricavare la password
            $prep = pg_prepare($db, "sqlPassword", $sql); 
            $ret = pg_execute($db, "sqlPassword", array($user));

            if(!$ret) { // Verifico se il valore tornato dalla query esiste (return password) o meno (return false)

                return false; 

            }
            else{
                if ($row = pg_fetch_assoc($ret)){ 
                    return $row['password'];    // Ritorno della password salvata nel database
                }
                else{
                    return false;
                }
            }
        }
    ?>
</body>
