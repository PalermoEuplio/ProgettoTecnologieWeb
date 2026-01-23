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
                                            <input id="fileInput" type="file" style="display: none;" accept="image/*"></input> 
                                        </div>
                                        <textarea id="text" ></textarea>
                                    </div>
                                    
                                    <button>Carica Foto</button>
                            </form>
                    </div>
                </div>


                <script>
                        const droparea = document.getElementById("dropzone");
                        const fileInput = document.getElementById("fileInput");

                        droparea.addEventListener("click", () => {
                                fileInput.click();
                        });

                        fileInput.addEventListener("change", (e) => {
                                displayImages(e.target.files);
                        });
                       

                        droparea.addEventListener("drop", dropHandler);

                        window.addEventListener("drop", (e) => {
                                e.preventDefault();
                        });
                        droparea.addEventListener("dragover", (e) => {
                                const fileItems = [...e.dataTransfer.items].filter(
                                        (item) => item.kind === "file",
                                );
                                if (fileItems.length > 0) {
                                        e.preventDefault();
                                if (fileItems.some((item) => item.type.startsWith("image/"))) {
                                        e.dataTransfer.dropEffect = "copy";
                                } else {
                                        e.dataTransfer.dropEffect = "none";
                                }
                                }
                        });

                        window.addEventListener("dragover", (e) => {
                                const fileItems = [...e.dataTransfer.items].filter(
                                        (item) => item.kind === "file",
                                );
                                if (fileItems.length > 0) {
                                        e.preventDefault();
                                        if (!droparea.contains(e.target)) {
                                                e.dataTransfer.dropEffect = "none";
                                        }
                                }
                        });

                        const preview = document.getElementById("dropzone");

                        function displayImages(files) {
                                const file = files[0];
                                if (file.type.startsWith("image/")) {
                                        preview.innerHTML = "";
                                        const img = document.createElement("img");
                                        img.src = URL.createObjectURL(file);
                                        img.alt = file.name;
                                        img.classList.add("preview-image");
                                        preview.appendChild(img);
                                }
                                
                        }

                        function dropHandler(ev) {
                                ev.preventDefault();
                                const files = [...ev.dataTransfer.items]
                                .map((item) => item.getAsFile())
                                .filter((file) => file);
                                displayImages(files);
                        }



                </script>

                <?php include 'footer.php'; ?>
        </body>
</html>