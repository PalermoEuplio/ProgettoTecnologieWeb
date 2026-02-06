<?php 
        // Php centrale del sito che contiene il reindirizzamento all'interfaccia principale e ai relativi css
        
        include 'db.php';       // Inclusa connessione al database

        $sql = "SELECT username FROM utente";   // Prendo la colonna degli username che servirà come identificativo per il nome della Sessione

        include("interfacenonloggato.php");     // Carico la pagina centrale

?>
<html>
        <head>
                
                <meta encoding="utf-8"/>
                <title>HomePage</title>
                <?php
                        if(isset($_SESSION['username'])) {      // Controllo se ho una sessione con utente loggato o meno

                                ?><link rel="stylesheet" type="text/css" href="interface.css"/><?php    // Caricamento css per utente loggato

                        } else {

                                ?><link rel="stylesheet" type="text/css" href="interfacenonloggato.css"/><?php  // Caricamento css per utente anonimo
                                
                        }
                ?>
        </head>
        <body>
                <section>
                </section>
        </body>
</html>
