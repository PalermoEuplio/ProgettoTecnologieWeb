<header>
        <div id="logo">
                <h1>PORCODDIO</h1>      <!-- Nome Sito DA CAMBIAREEEEEEEEEEEEEEEE!!!!!!!!!!!!-->
        </div>

        <div id="searchbar">    <!-- Sezione della barra di ricerca in alto -->

                <button id="searchicon">        <!-- Bottone per cercare -->
                        <svg width="40" height="40" xmlns="http://www.w3.org/2000/svg">
                                <image width="40" height="40" href="images/searchicon.svg"/>
                        </svg>
                </button>

                <input type="text" autocomplete="off" id="searchvalue" placeholder="Cerca..."/> <!-- Area di testo per la ricerca -->
        </div>

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

<body>
        <?php
                if(isset($_SESSION['username'])) {      // Controllo necessario alla visualizzazione della barra sopra ai post relativa all'utente
                        ?>
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
                                                        
                                                <button id="sendMessege" onclick="send_post()"> <!-- Bottone necessario all'invio del post rapido -->

                                                        <svg width="43" height="35" viewBox="0 0 32 32">
                                                                <image width="32" height="32" href="images/sendMessageIcon.svg"/>       <!-- Immagine Bottone: Freccia di invio -->
                                                        </svg>

                                                </button>

                                        </div>

                                        <form id="photoform"action="addPhoto.php">      <!-- Contenitore del bottone di aggiunta post completo -->

                                                <button id="addPhoto">

                                                        <svg width="43" height="35" viewBox="0 0 32 32">
                                                                <image width="32" height="32" href="images/addPictureIcon.svg"/>        <!-- Immagine Bottone: +Foto -->
                                                        </svg>

                                                </button>

                                        </form>
                                                
                                </div>
                        <?php
                }
        ?>

                <!--                            Inizio della parte centrale del sito                           -->

        <div id="main"> <!-- Contenitore della zona centrale dei post (content) e del footer -->

                <div id="content">      <!-- Contenitore dei post presenti nel database -->

                        <?php
                                // Php necessario al caricamento dei post dal database

                                include "db.php";       // Connessione al database

                                $sqlpost = "SELECT id_post, image, description, array_to_json(tag) as 
                                        tag_json, array_to_json(comments) as comments_json, creator FROM post ORDER BY id_post DESC;";  // Query necessaria al caricamento dei post
                                pg_prepare($db, "loadpost", $sqlpost);
                                $post = pg_execute($db, "loadpost", array());


                                while ($row = pg_fetch_assoc($post)) {  // Ciclo che scorre l'array di post preso dal database

                                        $hasImage = !empty($row['image']);      // Primo controllo necessario per capire se il post contiene un'immagine o meno
                                        ?>

                                                <div class="container-post" data-id-post="<?php echo $row['id_post']; ?>">      <!-- Container dei singoli post (Viene creato Iterativamente)-->

                                                        <div class="description <?php echo !$hasImage ? 'long' : ''; ?>">       <!-- Container della descrizione che cambia css in base a se il post ha immagine o meno 
                                                                                                                                        (Se non c'è immagine occupa due colonne della griglia di container-post, altrimenti una)-->

                                                                <?php echo "Descrizione:<br>", $row['description']; ?>  <!-- Caricamento della descrizione dal database -->

                                                        </div>

                                                        <?php if($hasImage): ?> <!-- Verifica della presenza dell'immagine per il suo caricamento -->

                                                                <div class="post">      <!-- Contenitore dell'imgaine del post-->

                                                                        <img src="<?= htmlspecialchars($row['image']) ?>">      <!-- Prendo il riferimento dalla colonna image del post -->

                                                                </div>

                                                        <?php endif; ?> <!-- Termine dell'if precedente -->

                                                        <div class="comment <?php echo !$hasImage ? 'short' : ''; ?>">  <!-- Contenitore dei commenti relativi al post -->

                                                                <strong style="position: absolute; left: 50%; transform: translateX(-50%); padding-top:4px;">Commenti</strong><br>      <!-- Intestazione -->

                                                                <?php

                                                                        $commenti = json_decode($row['comments_json']); // Carico la matrice dei commenti dal database 

                                                                        if (!empty($commenti)) {        // Verifico che vi siano dei commenti
                                                                                
                                                                                echo '<ul style="list-style-type: none; padding-left: 0px;">';  /* Necessario per la visuallizzazione in stile tabella
                                                                                                                                                        con gli username a sinistra e il contenuto del commento a destra */
                                                                                
                                                                                foreach ($commenti as $c) {     // Scorro i vari Commenti

                                                                                        $autore = htmlspecialchars($c[0]);      //Salvo autore del commento e relativo testo 
                                                                                        $testo = htmlspecialchars($c[1]);

                                                                                        echo "<li style='margin-bottom: 8px;'>";        // VIsualizzazione del contenuto dei commenti
                                                                                        echo "  <b style='color: #48e5c2;'>{$autore}:</b> ";
                                                                                        echo "  <span>{$testo}</span>";
                                                                                        echo "</li>";
                                                                                        
                                                                                }
                                                                                
                                                                                echo '</ul>';

                                                                        } else {

                                                                                echo "Nessun commento.";        // Messaggio di default se non vi sono commenti

                                                                        }
                                                                ?>

                                                                <?php
                                                                        // Sezione necessaria all'aggunta di nuovi commenti ai post

                                                                        if(isset($_SESSION['username'])) {      // Verifico di trovarmi in una sessione con utente loggato

                                                                                ?>
                                                                                <div id="fastcomment">  <!-- Contenitore degli elementi necessari all'aggiunta del nuovo commento -->

                                                                                        <textarea class="textcomment" class="barstyle" type="text" autocomplete="off" placeholder="Commenta.."></textarea>      <!-- Area per il testo -->      
                                                                                                
                                                                                        <button id="sendComment" onclick="send_comment(this)">  <!-- Bottone per l'invio del commento -->

                                                                                                <svg width="27" height="34" viewBox="0 0 27 27">
                                                                                                        <image width="27" height="27" href="images/sendMessageIcon.svg"/>       <!-- Immagine Bottone: Freccia di invio -->
                                                                                                </svg>

                                                                                        </button>
                                                                                </div>

                                                                                <?php

                                                                        }
                                                                ?>   
                                                        </div>
                                                </div>
                                        <?php
                                                /* Sezione necessaria all'eliminazione del post da parte dell'utente che lo ha creato 
                                                (Viene Inserito a prescindere ad ogni iterazione e non fa parte della griglia di container-post)*/

                                                if(isset($_SESSION['username']) && $_SESSION['username'] == $row['creator']) { ?>       <!-- Verifico di avere un utente loggato e che questo sia il creatore del post -->
                                                        
                                                        <button class="deletepost" onclick="deletefunction(<?php echo $row['id_post']; ?>)">    <!-- Bottone per l'eliminazione -->
                                                                <img src="images/trash-can.svg" alt="Icona" width="20"> <!-- Immagine Bottone: Cestino -->
                                                        </button>

                                                        <?php 
                                                }
                                        ?>
                                        <div class="post-separator"></div>      <!-- Separatore grafico fra i post -->

                                        <?php 
                                
                                } 
                        ?>

                </div>

                <?php include 'footer.php'; ?>  <!-- Inclusione del footer -->

        </div>

        <aside>
                <!-- Inizio della sezione di lato della pagina -->
        </aside> 
        
        <script>
                //              ----- Script necessario al funzionamento della pagina -----
                

                                async function send_post() {    // Funzione d'invio del post rapido

                                        const textElement = document.getElementById('fastmsg'); // Prendo il riferimento all'area di testo ed elimino eventuali spazi superflui
                                        const message = textElement.value.trim();

                                        if (message === "") return; // Termino l'esecuzione se il testo è vuoto

                                        let send_confirm = confirm("Sei sicuro di voler postare il messaggio ?");        // Richiesta di conferma per l'utente mediante confirm del browser

                                        if (send_confirm) {     // Verifico l'ok dell'utente

                                                const formData = new FormData();        // Preparo il messaggio per inviare la descrizione del post con id f_description
                                                formData.append('f_description', message);

                                                try {
                                                        
                                                        const response = await fetch('post-manager.php', {      // Invio i dati al post-manager
                                                                method: 'POST',
                                                                body: formData
                                                        });

                                                        const result = await response.json();   // Aspetto la risposta dal post-manager

                                                        if (result.success) {
                                                                
                                                                window.location.reload();       // Se il server dice OK, aggiorno la pagina per vedere i post

                                                        } else {

                                                                alert("Errore durante il salvataggio: " + result.error);

                                                        }
                                                } catch (error) {
                                                        console.error("Errore di rete:", error);
                                                        alert("Errore di connessione al server.");
                                                }
                                        }

                                }


                                async function send_comment(btn) {      // Funzione necessaria all'invio di nuovi commenti. Prende in ingresso il riferimento al bottone

                                        const btn_div = btn.closest('.container-post'); // Prendo il riferimento al bottone specifico del commento che è stato premuto e all'id del relativo post
                                        const idpost = btn_div.dataset.idPost;

                                        const textElement = btn_div.querySelector('.textcomment');      // Prendo il riferimento al testo del commento da postare
                                        const message = textElement.value.trim();

                                        if (message === "") return; // Termino l'esecuzione se il testo è vuoto

                                        let send_confirm = confirm("Sei sicuro di voler postare il Commento?"); // Richiesta di conferma per l'utente mediante confirm del browser

                                        if (send_confirm) {     // Verifico l'ok dell'utente

                                                const formData = new FormData();        // Preparo il messaggio per inviare il commento e l'id del post con relativi id comment e id_post
                                                formData.append('comment', message);
                                                formData.append('id_post', idpost);

                                                try {
                                                        
                                                        const response = await fetch('post-manager.php', {      // Invio i dati al post-manager
                                                                method: 'POST',
                                                                body: formData
                                                        });

                                                        const result = await response.json();   // Aspetto la risposta dal post-manager

                                                        if (result.success) {
                                                                
                                                                window.location.reload();       // Se il server dice OK, aggiorno la pagina per vedere il post aggiornato

                                                        } else {
                                                                alert("Errore durante il salvataggio: " + result.error);
                                                        }
                                                } catch (error) {
                                                        console.error("Errore di rete:", error);
                                                        alert("Errore di connessione al server.");
                                                }
                                        }

                                }


                                async function deletefunction(idpost) { // Funzione che specifica il comportamento del bottone elimina. Prende come ingresso l'id del post da eliminare


                                        let send_confirm = confirm("Sei sicuro di voler eliminare il post?");   // Richiesta di conferma per l'utente mediante confirm del browser

                                        if(send_confirm){       // Verifico l'ok dell'utente

                                                
                                                const formData = new FormData();        // Preparo il messaggio per inviare l'id del post e la flag per l'eliminazione con relativi id id_post e delete
                                                formData.append('id_post', idpost);
                                                formData.append('delete', idpost);

                                                try {
                                                        
                                                        const response = await fetch('post-manager.php', {      // Invio i dati al post-manager
                                                                method: 'POST',
                                                                body: formData
                                                        });

                                                        const result = await response.json();   // Aspetto la risposta dal post-manager

                                                        if (result.success) {
                                                                
                                                                window.location.reload();       // Se il server dice OK, aggiorno la pagina per vedere la lista aggiornata dei post

                                                        } else {
                                                                alert("Errore durante il salvataggio: " + result.error);
                                                        }
                                                } catch (error) {
                                                        console.error("Errore di rete:", error);
                                                        alert("Errore di connessione al server.");
                                                }
                                        }
                                }

                        </script>
</body>
