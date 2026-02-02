<?php
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


            $temp = get_pwd($user, $db);
            if(!$temp)
                $hash=false;
            else $hash = password_hash($temp,PASSWORD_DEFAULT);

            if($hash == false){     //Caso Utente non registrato in database
                header("Location: login.php?err=1");
                exit();
            }
            else{
                if(password_verify($pass, $hash)){
                    $_SESSION['username'] = $user;
                    echo "<meta http-equiv='Refresh' content='0; URL=index.php'>";
                }
                else{
                    header("Location: login.php?err=2");    //Caso Password Errata
                    exit();
                }
            }
        }
        else {
            exit(); //Accesso non consentito
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