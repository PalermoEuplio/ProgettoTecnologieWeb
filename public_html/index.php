<?php session_start();
        $host = 'localhost';
        $port = '5432';
        $db='Gruppo36DB';
        $username='www';
        $password='www';

        $connection_string = "host=$host port=$port dbname=$db user=$username password=$password";
        $db = pg_connect($connection_string)
                or die('Impossibile connettersi al database: ' . pg_last_error());
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
                <title>Sito web</title>
                <link rel="stylesheet" type="text/css" href="style.css"/>
                <link rel="stylesheet" type="text/css" href="interfacenonloggato.css"/>
        </head>
        <body>
                <section>
                </section>
        </body>
</html>
