<?php
session_start();
        $host = 'localhost';
        $port = '5432';
        $db='Gruppo36DB';
        $username='www';
        $password='www';

        $connection_string = "host=$host port=$port dbname=$db user=$username password=$password";
        $db = pg_connect($connection_string)
                or die('Impossibile connettersi al database: ' . pg_last_error());
?>