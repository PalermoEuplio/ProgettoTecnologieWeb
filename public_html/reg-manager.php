<?php

    include "validate_img.php";

    // File Php Contenente la logica applicativa legata alla registrazione

    session_start(); 

	if(isset($_POST['username']) && isset($_POST['password']) && isset($_POST['repassword'])){  // Verifico che tutti i campi siano settati correttamente

        $user = $_POST['username']; // Preparo le variabili
        $pass = $_POST['password'];
        $repassword = $_POST['repassword'];

        $pfp_path = "images/anonymusUserIcon.svg";  // Immagine che verrà inserita di default come pfp

        if(isset($_FILES['pfp']) && $_FILES['pfp']['error']== UPLOAD_ERR_OK){   /* Verifico se l'utente ha inserito una sua immagine o meno; 
                                                                                    in caso positivo questa dovrà essere spostata nella directory dedicata*/

                if(is_file_img($_FILES['pfp'])) {

                        $profilepicture = $_FILES['pfp'];
                        $target_dir = "profilepictures/";   //Seleziono la target directory

                        if (!is_dir($target_dir)) {     //Creo la cartella se non esiste
                            mkdir($target_dir, 0777, true);
                        }

                        $ext = pathinfo($profilepicture["name"], PATHINFO_EXTENSION);   // Unisco l'immagine e la target directory per formare quello che sarà il nome dell'immagine (Compreso d'estenzione) 
                        $filename = uniqid("pfp_", true) . "." . $ext;
                        $pfp_path = $target_dir . $filename;

                        if (!move_uploaded_file($profilepicture["tmp_name"], $pfp_path)) {  // Sposto l'immagine e aggiorno la variabile con il relativo path
                                $pfp_path = "images/anonymusUserIcon.svg"; // Fallback in caso di errore move

                        }
                }
                else {
                        unlink($_FILES['pfp']['tmp_name']);
                        $pfp_path = "images/anonymusUserIcon.svg"; // Fallback in caso di file non supportato
                }
        }

        if (!empty($pass)){ // Controllo l'inserimento della password

            if($pass!=$repassword){ // Verifico che la password e la conferma passsword corrispondano; in caso negativo torno alla pagina chiamante con id errore=2
                if(isset($_SESSION['username'])){
                    header("Location: modificadati.php?err=2");
                    exit();
                }else {
                    header("Location: registration.php?err=2");    
                    exit();
                }

            }else{

                if(isset($_SESSION['username'])){   // Controllo per capire quale pagina ha chiamato il manager (tra modificadati e registration)

                    if($_SESSION['username']!= $user && username_exist($user)){ // Verifico che se l'utente vuole cambiare username questo non sia già presente nel database; in caso negativo torno alla pagina chiamante con id errore=1
                        header("Location: modificadati.php?err=1");
                        exit();
                }else {

                        $old_user = $_SESSION['username'];
                        if(update_utente($old_user, $user, password_hash($pass, PASSWORD_BCRYPT),$pfp_path)){
                            $_SESSION['username']=$user;    // Se tutto è andato a buon fine aggiorno il nome utente della sessione e reinderizzo alla pagina principale
                            echo "<meta http-equiv='Refresh' content='0; URL=index.php'>";
                        }else exit();
                }

            }else
            
                if(username_exist($user)){  // Verifico che l'utente che si vuole registrare non sia già presente nel database; in caso negativo torno alla pagina chiamante con id errore=1
                    header("Location: registration.php?err=1");    
                    exit();

                }else{

                    if(insert_utente($user, password_hash($pass, PASSWORD_BCRYPT),$pfp_path)){  // Chiamo la funzione d'inserimento utente nel database e ne verifico il valore di ritorno

                        $_SESSION['username']=$user;    // Se tutto è andato a buon fine faccio l'accesso cambiano il username della sessione e reinderizzo alla pagina principale
                        echo "<meta http-equiv='Refresh' content='0; URL=index.php'>";


                    }else{
                        exit();     //Errore durante la registrazione
                    }
                }
            }
        }
    }else {
            exit();     //Errore generico per l'inserimento dei dati
        }
    

    function username_exist($user){ // Funzione per il controllo dell'esistenza dell'utente nel database

        require "./db.php"; // Richiede accesso alle variabili di db.php

        $sql = "SELECT username FROM utente WHERE username=$1"; // Inizio la query per la ricerca dell'utente per username
        $prep = pg_prepare($db, "sqlUsername", $sql); 
        $ret = pg_execute($db, "sqlUsername", array($user));

        if(!$ret) { // Verifico il valore di ritorno della query
            echo "ERRORE QUERY: " . pg_last_error($db);
            return false; 
        }
        else{
            if ($row = pg_fetch_assoc($ret)){   // Verifico la presenza di dati nella riga tornata dalla query
                return true;
            }else
                return false;
        }
    }

    function insert_utente($user, $pass, $pfp_path){    // Funzione per l'inserimento del nuovo utente nel database

        require "./db.php"; // Richiede accesso alle variabili di db.php

        $sql = "INSERT INTO utente(username, password, pfp) VALUES($1, $2, $3)";    // Inizio la query per l'inserimento dell'utente
        $prep = pg_prepare($db, "insertUser", $sql); 
        $ret = pg_execute($db, "insertUser", array($user, $pass, $pfp_path));

        if(!$ret) { // Verifico il valore di ritorno della query
            echo "ERRORE QUERY: " . pg_last_error($db);
            return false; 
        }
        else{
            return true;
        }
    }

    function update_utente($old_user, $new_user, $pass, $pfp_path){    // Funzione per l'aggiornamento dei dati dell'utente nel database

        require "./db.php"; // Richiede accesso alle variabili di db.php

        $sql = "UPDATE utente SET username=$1, password=$2, pfp=$3 WHERE username=$4";  // Inizio la query per l'aggiornamento dell'utente
        $prep = pg_prepare($db, "updateUser", $sql); 
        $ret = pg_execute($db, "updateUser", array($new_user, $pass, $pfp_path, $old_user));

        if(!$ret) { // Verifico il valore di ritorno della query
            echo "ERRORE QUERY: " . pg_last_error($db);
            return false; 
        }
        else{
            if(update_posts_creator($old_user, $new_user)){   // Se l'aggiornamento dell'utente è andato a buon fine aggiorno anche il nome del creatore nei post vecchi
                return true;
            }
            return false;
        }
    }

    function update_posts_creator($old_user, $new_user) {
        require "./db.php";

        if($old_user == $new_user) {   // Se il nome utente non è stato cambiato non c'è bisogno di aggiornare i post
            return true;
        }else{
            
            $sql = "UPDATE post SET creator = $1 WHERE creator = $2";   // Query per aggiornare il nome del creatore in tutti i post vecchi
            $prep = pg_prepare($db, "updatePostCreator", $sql);
            $ret = pg_execute($db, "updatePostCreator", array($new_user, $old_user));

            if (!$ret) {    // Verifico il valore di ritorno della query
                error_log("Errore aggiornamento creator post: " . pg_last_error($db));
                return false;
            }
            return true;
        }
    }
?>