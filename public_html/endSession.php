<?php
    session_start();
    $_SESSION = array();
    session_destroy(); // Distrugge la sessione sul server
    header("Location: index.php"); // Reindirizza alla pagina di login
    exit;
?>
