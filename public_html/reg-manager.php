<?php

	if(isset($_POST['username']) && isset($_POST['password']) && isset($_POST['repassword'])){

        $user = $_POST['username'];
        $pass = $_POST['password'];
        $repassword = $_POST['repassword'];

        $pfp_path = "images/anonymusUserIcon.svg";
        if(isset($_FILES['pfp']) && $_FILES['pfp']['error']== UPLOAD_ERR_OK){
            $profilepicture = $_FILES['pfp'];
            $target_dir = "profilepictures/";   //Seleziono la Directory

            if (!is_dir($target_dir)) {     //Creo la cartella se non esiste
                mkdir($target_dir, 0777, true);
            }

            $ext = pathinfo($profilepicture["name"], PATHINFO_EXTENSION);
            $filename = uniqid("pfp_", true) . "." . $ext;
            $pfp_path = $target_dir . $filename;

            if (!move_uploaded_file($profilepicture["tmp_name"], $pfp_path)) {
                $pfp_path = "images/anonymusUserIcon.svg"; // Fallback in caso di errore move
            }
        } 


        //CHECK PASSWORD
        if (!empty($pass)){
            if($pass!=$repassword){
                header("Location: registration.php?err=2");    //Caso Password non Corrispondenti
                exit();
            }else{
                //CONTROLLO SE L'UTENTE GIA' ESISTE
                if(username_exist($user)){
                    header("Location: registration.php?err=1");    //Caso Utente già Registrato
                    exit();
                }else{
                    //Inserimento nel Database
                    if(insert_utente($user, $pass,$pfp_path)){
                        echo "<p> Utente registrato con successo.";
                        $_SESSION['username']=$user;
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


function username_exist($user){
    require "./db.php";
	$sql = "SELECT username FROM utente WHERE username=$1";
	$prep = pg_prepare($db, "sqlUsername", $sql); 
	$ret = pg_execute($db, "sqlUsername", array($user));
	if(!$ret) {
		echo "ERRORE QUERY: " . pg_last_error($db);
		return false; 
	}
	else{
		if ($row = pg_fetch_assoc($ret)){
			return true;
        }else
			return false;
	}
}

function insert_utente($user, $pass, $pfp_path){
    require "./db.php";

	$sql = "INSERT INTO utente(username, password, pfp) VALUES($1, $2, $3)";
	$prep = pg_prepare($db, "insertUser", $sql); 
	$ret = pg_execute($db, "insertUser", array($user, $pass, $pfp_path));
	if(!$ret) {
		echo "ERRORE QUERY: " . pg_last_error($db);
		return false; 
	}
	else{
		return true;
	}
}
?>