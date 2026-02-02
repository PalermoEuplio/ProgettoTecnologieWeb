<?php
        $error_msg = "";
        if(isset($_GET['err'])){
                switch($_GET['err']){
                case 1:
                        $error_msg = "*L'utente già registrato.";
                        break;
                case 2:
                        $error_msg = "*Le Password non Corrispondono.";
                        break;
                default:
                        $error_msg = "*Errore durante l'accesso.";
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
                        <form id="registration" action="reg-manager.php" method="POST" enctype="multipart/form-data">
                                <div id="welcome">
                                        <h1>Benvenuto!</h1>
                                        <div id="dropzone">
                                                <div id="preview-container">
                                                        <svg width="43" height="35" viewBox="0 0 32 32">
                                                                <image width="32" height="32" href="images/dragAndDropIcon.svg" style="opacity: 0.5;"/>
                                                        </svg>
                                                </div>
                                            <input id="fileInput" type="file" name="pfp" style="display: none;" accept="image/*"></input> 
                                        </div>
                                </div>         
                                <div id="regform">
                                        <h1>Inserisci Dati</h1>
                                        <p>* Username: </p>
                                        <label for="username">
                                                <input type="text" name="username" required></input>
                                        </label>
                                        <p>* Password: </p>
                                        <label for="password">
                                                <input type="password" name="password" required></input>
                                        </label>
                                        <p>* Conferma Password: </p>
                                        <label for="password">
                                                <input type="password" name="repassword" required></input>
                                        </label>
                                        <p id="errmsg" style="color: red; <?php echo empty($error_msg) ? 'display:none;' : ''; ?>">
                                                <?php echo $error_msg; ?>
                                        </p>
                                        <input type="submit" name="Accedi" value="Login"/>
                                </div>
                        </form>
                        <form id="back" action="login.php">
                            <input type="submit" name="Registrati" value="Annulla"/>
                        </form>
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

                        const previewContainer = document.getElementById("preview-container");

                        function displayImages(files) {
                                const file = files[0];
                                if (file.type.startsWith("image/")) {
                                        previewContainer.innerHTML = "";
                                        const img = document.createElement("img");
                                        img.src = URL.createObjectURL(file);
                                        img.alt = file.name;
                                        img.classList.add("preview-image");
                                        previewContainer.appendChild(img);
                                }
                                
                        }

                        function dropHandler(ev) {
                                ev.preventDefault();
                                const files = ev.dataTransfer.files;

                                if(files.length>0){
                                        fileInput.files=files;
                                        displayImages(files);
                                }
                        }



                </script>

                <?php include 'footer.php'; ?>
        </body>
</html>