<?php 
        include 'db.php';
        $sql = "SELECT username FROM utente"; 

        if(isset($_SESSION['username'])) {
                include("interface.php");
        } else {
                include("interfacenonloggato.php");
        }

?>
<html>
        <head>
                
                <meta encoding="utf-8"/>
                <title>HomePage</title>
                <link rel="stylesheet" type="text/css" href="interfacenonloggato.css"/>
        </head>
        <body>
                <section>
                </section>
        </body>
</html>
