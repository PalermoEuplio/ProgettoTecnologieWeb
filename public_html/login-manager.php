<?php
// 1. La sessione va iniziata all'inizio, prima di ogni output HTML
include 'db.php';

// Funzione spostata sopra o inclusa correttamente
function get_pwd($user, $db){
    $sql = "SELECT password FROM utente WHERE username=$1;";
    $prep = pg_prepare($db, "sqlPassword", $sql); 
    $ret = pg_execute($db, "sqlPassword", array($user));
    if(!$ret) {
        return false; 
    }
    else{
        if ($row = pg_fetch_assoc($ret)){ 
            return $row['password'];
        }
        else{
            return false;
        }
    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Pagina di Login</title>
</head>
<body>
    <?php
        // 2. CORREZIONE: Usiamo isset() per verificare se i dati sono stati inviati
        if(isset($_POST['username']) && isset($_POST['password'])){
            
            $user = $_POST['username'];
            $pass = $_POST['password'];

            $hash = get_pwd($user, $db);

            if(!$hash){
                echo "<p> L'utente $user non esiste. <a href=\"login.html\">Riprova</a></p>";
            }
            else{
                if(password_verify($pass, $hash)){
                    // 3. Salviamo in sessione
                    $_SESSION['username'] = $user;
                    echo "<p>Login Eseguito con successo</p>";
                    echo "<p><a href=\"reserved.php\">Accedi</a> al contenuto riservato</p>";
                }
                else{
                    echo '<p>Username o password errati. <a href="login.html">Riprova</a></p>';
                }
            }
        }
        else {
            // Se qualcuno prova ad accedere alla pagina senza passare dal form
            echo "<p>ERRORE: Accesso non consentito. <a href=\"login.html\">Torna al login</a></p>";
        }
    ?>
</body>
</html>