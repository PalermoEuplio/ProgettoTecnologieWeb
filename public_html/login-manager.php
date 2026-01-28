<?php
// 1. La sessione va iniziata all'inizio, prima di ogni output HTML
include 'db.php';
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Pagina di Login</title>
</head>
<body>
    <?php
        if(isset($_POST['username']) && isset($_POST['password'])){
            
            $user = $_POST['username'];
            $pass = $_POST['password'];

            $hash = password_hash(get_pwd($user, $db),PASSWORD_DEFAULT);


            if(!$hash){
                echo "<p> L'utente $user non esiste. <a href=\"login.php\">Riprova</a></p>";
            }
            else{
                if(password_verify($pass, $hash)){
                    $_SESSION['username'] = $user;
                    echo "<meta http-equiv='Refresh' content='0; URL=interface.php'>";
                }
                else{
                    echo '<p>Username o password errati. <a href="login.php">Riprova</a></p>';
                }
            }
        }
        else {
            echo "<p>ERRORE: Accesso non consentito. <a href=\"login.php\">Torna al login</a></p>";
        }





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
</body>
</html>