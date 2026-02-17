<?php

        //      Sezione per la gestione del messaggio d'errore

        $error_msg = "";
        if(isset($_GET['err'])){
                switch($_GET['err']){
                case 1:
                        $error_msg = "*L'utente già registrato";
                        break;
                case 2:
                        $error_msg = "*Le Password non Corrispondono";
                        break;
                default:
                        $error_msg = "*Errore durante l'accesso";
                        break;
                }
        }

?>
<html>
        <head>
                <meta encoding="utf-8"/>
                <title>Login</title>
                <link rel="stylesheet" type="text/css" href="style.css"/>
                <link rel="stylesheet" type="text/css" href="registration.css"/>
        </head>
        <body>
                <div>
                        <form id="registration" action="reg-manager.php" method="POST" enctype="multipart/form-data">   <!-- Div centrale della pagina -->
                                
                                <div id="welcome">
                                        <h1>Benvenuto!</h1>

                                        <div id="dropzone">     <!-- Sezione per il Dropzone -->
                                                <div id="preview-container">    <!-- Container che serve per la visualizzazione dell'anteprima dell'immagine -->
                                                        
                                                        <svg width="43" height="35" viewBox="0 0 32 32">
                                                                <image width="32" height="32" href="images/dragAndDropIcon.svg" style="opacity: 0.5;"/> <!-- Icona Standard -->
                                                        </svg>
                                                        <p>Trascina qui la tua foto profilo!</p>

                                                </div>
                                                <input id="fileInput" type="file" name="pfp" style="display: none;" accept="image/*"></input>   <!-- Input per permettere di cliccare per aggiungere la foto--> 
                                                
                                        </div>

                                </div>

                                <div id="regform">      <!-- Form d'inserimento dei dati -->

                                        <h1>Inserisci Dati</h1>

                                        <p>* Username: </p>
                                        <label for="username">  <!-- Area Username -->
                                                <input type="text" name="username" required></input>    
                                        </label>

                                        <p>* Password: </p>
                                        <label for="password">  <!-- Area Password -->
                                                <input type="password" name="password" required></input>
                                        </label>

                                        <p>* Conferma Password: </p>
                                        <label for="password">  <!-- Area Conferma Password -->
                                                <input type="password" name="repassword" required></input>
                                        </label>

                                        <p id="errmsg" style="color: red; <?php echo empty($error_msg) ? 'display:none;' : ''; ?>">     <!-- Messaggio d'errore che compare e cambia testo in base al valore di $error_msg passato nell'header -->
                                                <?php echo $error_msg; ?>
                                        </p>

                                        <input type="submit" name="Accedi" value="Registrati"/>      <!-- Pulsante d'invio del form -->

                                </div>

                        </form>

                        <?php include 'footer.php'; ?>  <!-- Inclusione del footer -->
                        
                </div>
                
                


                <!--    Inizio della sezione di script per funzionamento della pagina      -->

                <script>
                        const droparea = document.getElementById("dropzone");   // Prendo i riferimenti per la sezione dropzone e il fileInput
                        const fileInput = document.getElementById("fileInput");

                        droparea.addEventListener("click", () => {      // Listner per il click del mouse
                                fileInput.click();
                        });

                        fileInput.addEventListener("change", (e) => {   // Listner per la chiamata della funzione displayImages
                                displayImages(e.target.files);
                        });
                       

                        droparea.addEventListener("drop", dropHandler); // Listner per la funzione del Drop

                        window.addEventListener("drop", (e) => {        // Listner alla finestra che impedisce di aprire l'immagine trascinata in un'altra scheda
                                e.preventDefault();
                        });

                        droparea.addEventListener("dragover", (e) => {  // Listner che impedisce di trascinare elementi che non siano immagini
                                const fileItems = [...e.dataTransfer.items].filter(     // Filtro elementi per file e li inserisco in un array
                                        (item) => item.kind === "file",
                                );
                                if (fileItems.length > 0) {
                                        e.preventDefault();
                                if (fileItems.some((item) => item.type.startsWith("image/"))) { // Se il file è un'immagine cambierà il cursore in copy altrimenti in un blocco
                                        e.dataTransfer.dropEffect = "copy";
                                } else {
                                        e.dataTransfer.dropEffect = "none";
                                }
                                }
                        });

                        window.addEventListener("dragover", (e) => {    // Listner per il comportamento della pagina fuori dal riquadro
                                const fileItems = [...e.dataTransfer.items].filter(     // Filtro elementi per file e li inserisco in un array
                                        (item) => item.kind === "file",
                                );
                                if (fileItems.length > 0) {
                                        e.preventDefault();
                                        if (!droparea.contains(e.target)) {     // Se l'immagine viene rilasciata fuori da un droparea non fa nulla
                                                e.dataTransfer.dropEffect = "none";
                                        }
                                }
                        });

                        
                        //      Sezione dello script necessaria per la visualizzazione dell'immagine nel D&D e dichiarazioni di funzioni chiamate in precedenza

                        const previewContainer = document.getElementById("preview-container");  // Prendo il riferimento al div per la preview dell'immagine

                        function displayImages(files) { // Funzione necessaria alla visualizzazione dell'immagine
                                const file = files[0];
                                if (file.type.startsWith("image/")) {   // Verifico ancora che il tipo dell'immagine sia corretto

                                        previewContainer.innerHTML = "";        // Svuoto il container preview

                                        const img = document.createElement("img");      // Creo una nuova immagine e ne cambio il riferimento all'immagine appena presa
                                        img.src = URL.createObjectURL(file);
                                        img.alt = file.name;    // Cambio anche il nome dell'immagine in quello corrispondente (Solo nell'html di questa pagina)

                                        img.classList.add("preview-image");     // Aggiungo l'immagine al previewContainer
                                        previewContainer.appendChild(img);

                                }
                                
                        }

                        function dropHandler(ev) {      // Funzione che gestisce l'evento del rilascio

                                ev.preventDefault();    // Funzione che gestisce l'evento del rilascio

                                const files = ev.dataTransfer.files;    // Salvo il file rilasciato

                                if(files.length>0){     // Se non è nullo lo passo alla funzione displayImages
                                        fileInput.files=files;
                                        displayImages(files);
                                }
                        }



                </script>
        </body>
</html>