<html>
        <head>
                <meta encoding="utf-8"/>
                <title>Fai un Post</title>
                <link rel="stylesheet" type="text/css" href="style.css"/>
                <link rel="stylesheet" type="text/css" href="addPhoto.css"/>
        </head>
        <body>
                <div>
                    <div id="post" class="panel">
                            <form id="postform">
                                    <h1>Condividi i tuoi Meme</h1>
                                    

                                    <div id="input">
                                        <p>Aggiungi una foto: </p>
                                        <p>Descrizione: </p>

                                        <div id="dropzone">
                                                <svg width="43" height="35" viewBox="0 0 32 32">
                                                        <image width="32" height="32" href="images/dragAndDropIcon.svg" style="opacity: 0.5;"/>
                                                </svg>
                                            <input id="fileInput" type="file" multiple style="display: none;" accept="image/*"></input> 
                                        </div>
                                        <textarea id="text" ></textarea>
                                        
                                    </div>
                                    
                                    
                                    <button>Carica Foto</button>
                            </form>
                    </div>
                </div>
                <script>
                        const dropArea = document.getElementById("dropzone");
                        const fileInput = document.getElementById("fileInput");

                        dropArea.addEventListener("click", () => {
                        fileInput.click();
                        });

                        fileInput.addEventListener("change", () => {
                        const files = fileInput.files;
                        console.log("File selezionati:", files);
                        // qui puoi fare quello che vuoi con i file
                        });
                </script>
        </body>
</html>