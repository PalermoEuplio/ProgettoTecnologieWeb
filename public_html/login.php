<?php
        $error_msg = "";
        if(isset($_GET['err'])){
                switch($_GET['err']){
                case 1:
                        $error_msg = "*L'utente non esiste.";
                        break;
                case 2:
                        $error_msg = "*Password errata. Riprova.";
                        break;
                default:
                        $error_msg = "*Errore durante l'accesso.";
                        break;
                }
        }

?>
<html>
        <head>
                <meta encoding="utf-8"/>
                <title>Login</title>
                <link rel="stylesheet" type="text/css" href="style.css"/>
                <link rel="stylesheet" type="text/css" href="login.css"/>
        </head>
        <body>
                <div>
                        <div id="login" class="panel">
                                <div id="welcome">
                                        <h1>Bentornato!</h1>
                                        <p>Non vediamo l'ora di tornare a vedere i tuoi memini...(¬‿¬)</p>
                                        <img src="images/ranalogin.jpg" height="200" width="200" id="immagine"/>
                                </div>         
                                <form id="loginform" action="login-manager.php" method="POST">
                                        <h1>Accedi</h1>
                                        <p>* Username: </p>
                                        <label for="username">
                                                <input type="text" name="username" id="username" required></input>
                                        </label>
                                        <p>* Password: </p>
                                        <label for="password">
                                                <input type="password" name="password" id="password" required></input>
                                        </label>
                                        <input type="submit" name="Accedi" value="Login"/>
                                        <p id="errmsg" style="color: red; margin-top:2em; <?php echo empty($error_msg) ? 'display:none;' : ''; ?>">
                                                <?php echo $error_msg; ?>
                                        </p>



                                </form>
                                <form action="registration.php">
                                                <input type="submit" name="Registrati" value="Registrati"/>
                                </form>
                        </div>
                </div>
                <?php include 'footer.php'; ?>
        </body>
</html>
