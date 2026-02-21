<header>
        <div id="logo">
                <h1>MEMELANDIA</h1>      <!-- Nome Sito DA CAMBIAREEEEEEEEEEEEEEEE!!!!!!!!!!!!-->
        </div>

        <div id="searchbar">    <!-- Sezione della barra di ricerca in alto -->

                <button id="searchicon">        <!-- Bottone per cercare -->
                        <svg width="35" height="35" xmlns="http://www.w3.org/2000/svg">
                                <image width="35" height="35" href="images/searchicon.svg"/>
                        </svg>
                </button>

                <input type="text" autocomplete="off" id="searchvalue" placeholder="Cerca per tag e nome profilo..."/> <!-- Area di testo per la ricerca -->
        </div>

        <?php
                function get_img($user, $db){   // Funzione necessaria al caricamento della pfp

                        $sql = "SELECT pfp FROM utente WHERE username=$1";      // Inizio la query per il caricamento della pfp a partire dallo username utente
                        $ret = pg_query_params($db, $sql, array($user));

                        if($ret && $row = pg_fetch_assoc($ret)){        // Verifico che la query sia andata a buon fine 

                                if(empty($row['pfp'])) {        // Se l'utente non ha pfp ne carico una anonima di default
                                        return images/anonymusUserIcon.svg; 
                                }

                                return $row['pfp'];     // Restituisco il riferimento alla pfp
                        }
                }

                $user = $_SESSION['username'] ?? 'Ospite';      // Salvo username dell'utente loggato oppure un identificativo Ospite

                $pfp = get_img($user,$db);      // Salvo il riferimento alla pfp richiamando la funzione get_img

        ?>
        <?php
                if(isset($_SESSION['username']))  {      // Controllo necessario alla visualizzazione della barra sopra ai post relativa all'utente
                        ?>
                        <div id="userform" onmouseover="comparsa('userinfo');" onmouseout="scomparsa('userinfo');">     <!-- Sezione legata all'immagine dell'utente e che compare al passare del mouse su di essa -->

                        <img id="userIcon" src="<?= htmlspecialchars($pfp) ?>"/>        <!-- Immagine utente -->

                        <div id="userinfo">     <!-- Div contentente alcune funzioni accessibili dall'utente, come il logout -->

                        <form action="endSession.php">  <!-- Richiamo il file per chiudere la sessione se l'utente clicca sul logout -->
                                <button style="cursor: pointer;">Logout</button>
                        </form>

                        </div>

                        <script>
                        // Script necessario all'apparizione e alla scomparsa della sezione userform

                        function comparsa(x) {
                                document.getElementById(x).style.display = "block";     // Cambio di valore dell'attributo display in block
                        }

                        function scomparsa(x) { 
                                document.getElementById(x).style.display = "none";      // Cambio di valore dell'attributo display in none
                        }

                </script>
        </div>
        <?php
                }
        ?>

        

        <?php 

                if(!isset($_SESSION['username'])) {     // Controllo che permette la visualizzazione o meno del bottone per il login
                        ?>
                                <form id="registrazione" action="login.php">    <!-- Form di reindirizzamneto alla pagina di login -->
                                        <button id="bg">ACCEDI</button>
                                </form>
                        <?php
                }

        ?>

</header>
<?php
        if(isset($_SESSION['username'])) {      // Controllo necessario alla visualizzazione della barra sopra ai post relativa all'utente
                include "userbar.php";
        }
?>
