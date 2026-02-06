<?php
        // Php necessario per la gestione del collegamento con il database e della Sessione attualmente in corso

        if(session_status()== PHP_SESSION_NONE) // Inizio la sessione se un utente fa l'accesso
                session_start();

        $host = 'localhost';    // Creo delle variabili necessarie al collegamento col database
        $port = '5432';
        $db='Gruppo36DB';
        $username='www';
        $password='www';

        $connection_string = "host=$host port=$port dbname=$db user=$username password=$password";      // Instauro la connessione vera e propria col database
        $db = pg_connect($connection_string)
                or die('Impossibile connettersi al database: ' . pg_last_error());
?>