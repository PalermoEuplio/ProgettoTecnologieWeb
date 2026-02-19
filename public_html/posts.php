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
                <?php // Ottengo l'immagine di profilo dal database
                        $escaped_creator = addslashes($row['creator']);
                        $pfp = pg_fetch_result(pg_query($db, "SELECT pfp FROM utente WHERE username='$escaped_creator' LIMIT 1;"), 0, 0);
                ?>
                <div class="container-post" data-id-post="<?php echo $row['id_post']; ?>">      <!-- Container dei singoli post (Viene creato Iterativamente)-->

                        <div class="autore">    <!-- Autore del post -->
                                <img class="pfp" src="<?=$pfp?>"></img>
                                <p><?=$row['creator'] ?></p>
                        </div>

                        <div class="description <?php echo !$hasImage ? 'long' : ''; ?>">       <!-- Container della descrizione che cambia css in base a se il post ha immagine o meno 
                                                                                                (Se non c'è immagine occupa due colonne della griglia di container-post, altrimenti una)-->

                                <p><?php echo $row['description']; ?></p>  <!-- Caricamento della descrizione dal database -->

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
                                        if(isset($_SESSION['username'])):      // Verifico di trovarmi in una sessione con utente loggato

                                ?>
                                        <div id="fastcomment">  <!-- Contenitore degli elementi necessari all'aggiunta del nuovo commento -->

                                                <!-- Area per il testo -->
                                                <textarea class="textcomment" class="barstyle" type="text" autocomplete="off" placeholder="Commenta.."></textarea>

                                                <button id="sendComment" onclick="send_comment(this)">  <!-- Bottone per l'invio del commento -->

                                                        <svg width="27" height="34" viewBox="0 0 27 27">
                                                                <image width="27" height="27" href="images/sendMessageIcon.svg"/>       <!-- Immagine Bottone: Freccia di invio -->
                                                        </svg>

                                                </button>
                                        </div>

                                <?php
                                        endif;
                                ?>
                        </div>
                </div>

                                <!-- Sezione necessaria all'eliminazione del post da parte dell'utente che lo ha creato 
                                        (Viene Inserito a prescindere ad ogni iterazione e non fa parte della griglia di container-post) -->
                <?php
                        // Verifico di avere un utente loggato e che questo sia il creatore del post
                        if(isset($_SESSION['username']) && $_SESSION['username'] == $row['creator']) {
                ?>

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
