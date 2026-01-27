<?php 
        include 'db.php';
        $sql = "SELECT id_utente FROM utente";
        $res = pg_query($db, $sql);
        


        if(isset($_SESSION['user_id'])) {
                include("interface.php");
        } else {
                include("interfacenonloggato.php");
        }

?>
<html>
        <head>
                
                <meta encoding="utf-8"/>
                <title>HomePage</title>
                <link rel="stylesheet" type="text/css"/>
                <link rel="stylesheet" type="text/css" href="interfacenonloggato.css"/>
        </head>
        <body>
                <section>
                </section>
        </body>
</html>
