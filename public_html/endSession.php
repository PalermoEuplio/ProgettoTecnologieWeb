<?php
    // Php usato per la terminazione della sessione (Richiamato quando un'utente fa il logout)

    session_start();    // Necessario per identificare la sessione da distruggere

    $_SESSION = array();    // Azzero le variabili della sessione
    
    session_destroy(); // Distrugge la sessione sul server

    header("Location: index.php"); // Reindirizza alla pagina principale per utente anonimo
    exit;
?>
