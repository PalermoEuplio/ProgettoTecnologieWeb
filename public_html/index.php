<?php 
        // Php centrale del sito che contiene il reindirizzamento all'interfaccia principale e ai relativi css
        
        include 'db.php';       // Inclusa connessione al database

        $sql = "SELECT username FROM utente";   // Prendo la colonna degli username che servirà come identificativo per il nome della Sessione
        
?>
<html>
        <head>
                <title>Homepage</title>
                <meta encoding="utf-8">
                <link rel="stylesheet" type="text/css" href="interface.css">
                <link rel="stylesheet" type="text/css" href="footer.css">
                <script type="text/javascript" src="homepage.js"></script>
                        <link rel="preconnect" href="https://fonts.googleapis.com">
                        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
                        <link href="https://fonts.googleapis.com/css2?family=Funnel+Display:wght@300..800&family=Jersey+10&family=Jersey+15&family=Jersey+25&display=swap" rel="stylesheet">
                        <link href="https://fonts.googleapis.com/css2?family=Jersey+10&family=Press+Start+2P&display=swap" rel="stylesheet">
        </head>
        <body>
                <?php include 'interface.php'?>
                <!--                            Inizio della parte centrale del sito                           -->


                <div class="main <?php echo isset($_SESSION['username']) ? 'loggato' : ''; ?>"> <!-- Contenitore della zona centrale dei post (content) e del footer -->

                        <div id="content">      <!-- Contenitore dei post presenti nel database -->
                                <?php include 'posts.php'; ?>
                        </div>

                        <aside>
                                <!-- Inizio della sezione di lato della pagina -->
                        </aside>

                        <?php include 'footer.php'; ?>  <!-- Inclusione del footer -->
                </div>
        </body>
</html>

