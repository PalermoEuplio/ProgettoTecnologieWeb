<!-- Barra opzioni utente -->
<div id="user"> <!-- Contenitore delle operazioni accessibili dall'utente -->
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
        <div id="fastmsgform">  <!-- Contenitore della barra per il post rapido -->

                <textarea id="fastmsg" class="barstyle" type="text" autocomplete="off" placeholder="A Cosa stai Pensando?..."></textarea>       <!-- TextArea contenente la descirizione del post -->
                        
                <button id="sendMessege" onclick="send_post()" title="Pubblica messaggio"> <!-- Bottone necessario all'invio del post rapido -->

                        <svg width="30" height="30">
                                <image width="30" height="30" href="images/sendMessageIcon.svg"/>       <!-- Immagine Bottone: Freccia di invio -->
                        </svg>

                </button>

        </div>
        <form id="photoform"action="addPhoto.php">      <!-- Contenitore del bottone di aggiunta post completo -->

                <button id="addPhoto" title="Pubblica un post">

                        <svg width="30" height="30" >
                                <image width="30" height="30" href="images/addPictureIcon.svg"/>        <!-- Immagine Bottone: +Foto -->
                        </svg>

                </button>

        </form>
</div>
