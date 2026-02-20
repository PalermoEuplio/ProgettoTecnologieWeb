<?php   

        //      Sezione per la gestione del messaggio d'errore

        $error_msg = "";
        if(isset($_GET['err'])){
                switch($_GET['err']){
                case 1:
                        $error_msg = "*Descrizione non Inserita";
                        break;
                case 2:
                        $error_msg = "*Tag non Inseriti";
                        break;
                case 3:
                        $err_msg = "*Tag non inseriti correttamente";
                        break;
                default:
                        $error_msg = "*Errore durante il caricamento";
                        break;
                }
        }

?>
<html>
        <head>
                <meta encoding="utf-8"/>
                <title>Creazione Post</title>
                <link rel="stylesheet" type="text/css" href="style.css"/>
                <link rel="stylesheet" type="text/css" href="addPhoto.css"/>
                <link rel="preconnect" href="https://fonts.googleapis.com">
                <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
                <link href="https://fonts.googleapis.com/css2?family=Funnel+Display:wght@300..800&family=Jersey+10&family=Jersey+15&family=Jersey+25&display=swap" rel="stylesheet">
                <link href="https://fonts.googleapis.com/css2?family=Jersey+10&family=Press+Start+2P&display=swap" rel="stylesheet">
        </head>
        <body>
                <div>
                    <div id="post" class="panel">       <!-- Div centrale della pagina -->
                            <form id="postform" action="post-manager.php" method="POST" enctype="multipart/form-data">  <!-- Form d'inserimento dei dati -->

                                    <h1>Condividi il tuo meme</h1>  

                                    <div id="input">
                                        <p2>Aggiungi una foto</p2>
                                        <p2>*Descrizione</p2>

                                        <div id="dropzone">     <!-- Sezione per il Dropzone -->
                                                <div id="preview-container">    <!-- Container che serve per la visualizzazione dell'anteprima dell'immagine -->
                                                        <svg width="43" height="35" viewBox="0 0 32 32">
                                                                <image width="32" height="32" href="images/dragAndDropIcon.svg" style="opacity: 0.5;"/> <!-- Icona Standard -->
                                                        </svg>
                                                </div>

                                                <input id="fileInput" type="file" style="display: none;" name="image_post" accept="image/*"></input>    <!-- Input per permettere di cliccare per aggiungere la foto-->
                                        </div>

                                        <textarea id="description" name="description" ></textarea>      <!-- Text Area Descrizione -->

                                        <p3>*Aggiungi dei tag (separati da virgola)</p3>
                                        <textarea id="tag" name="tag"></textarea>       <!-- Text Area Tag-->

                                        <p id="errmsg" style="color: red; <?php echo empty($error_msg) ? 'display:none;' : ''; ?>"> <!-- Messaggio d'errore che compare e cambia testo in base al valore di $error_msg passato nell'header -->
                                                <?php echo $error_msg; ?>
                                        </p>
                                    </div>
                                    
                                    <button id="caricapost">Carica Post</button>        <!-- Pulsante d'invio del form -->
                            </form>
                    </div>
                </div>

                        <!--    Inizio della sezione di script per funzionamento della pagina      -->

                <script>

                                //      Inizio sezione per la gestione del D&D
                                
                                
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

                        document.getElementById('tag').addEventListener('blur', function(e) {   // Listner che si assicura che il formato dei tag venga rispettato (#'nome_tag1', #'nome_tag2'...)
                                                                                                // Le modifiche vengono apportate nel momento l'utente esce dall'area di testo

                                let value = e.target.value;     // Prelevo il testo

                                if (value.length > 0) { // Verifico che il testo non sia nullo

                                        let tags = value.split(',').map(tag => { // Listner che divide i tag in base alla ,

                                        tag = tag.trim();       // Elimino spazi superflui prima e dopo i tag

                                        if (tag.length > 0 && !tag.startsWith('#')) {   // Inserisco # dove necessario
                                                return '#' + tag;
                                        }
                                        return tag;
                                        });

                                        e.target.value = tags.join(', ');    // Reinserisco la , fra i vari tag   
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

                                ev.preventDefault();    // Prevengo il comportamento di default del browser

                                const files = ev.dataTransfer.files;    // Salvo il file rilasciato

                                if(files.length>0){     // Se non è nullo lo passo alla funzione displayImages
                                        fileInput.files=files;
                                        displayImages(files);
                                }
                        }

                </script>

                <?php include 'footer.php'; ?>  <!-- Inclusione del footer -->
        </body>
</html>