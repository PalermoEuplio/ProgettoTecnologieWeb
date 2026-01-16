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
                                    <p>Aggiungi una foto: </p>
                                    <div id="input">
                                        <div id="dropzone">
                                            Trascina e rilascia qui
                                            <input type="file" multiple style="display: none;" accept="image/*"></input>
                                        </div>
                                        <input type="file" accept="image/*"></input>
                                    </div>
                                    <p>Descrizione: </p>
                                    <input type="text"></input>
                                    <button>Carica Foto</button>
                            </form>
                    </div>
                </div>
        </body>
</html>