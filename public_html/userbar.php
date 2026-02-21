<!-- Barra azioni dell'utente -->
<div id="user"> <!-- Contenitore delle operazioni accessibili dall'utente -->
        
        <div id="fastmsgform">  <!-- Contenitore della barra per il post rapido -->

                <textarea id="fastmsg" class="barstyle" type="text" autocomplete="off" placeholder="A cosa stai pensando...?"></textarea>       <!-- TextArea contenente la descirizione del post -->
                        
                
        </div>
        <button id="sendMessege" onclick="send_post()" title="Pubblica messaggio"> <!-- Bottone necessario all'invio del post rapido -->
                <svg width="50" height="40">
                        <image width="40" height="40" href="images/sendMessageIcon.svg"/>       <!-- Immagine Bottone: Freccia di invio -->
                </svg>
                Pubblica un messaggio

        </button>
        <form id="photoform"action="addPhoto.php">      <!-- Contenitore del bottone di aggiunta post completo -->

                <button id="addPhoto" title="Pubblica un post">

                        <svg width="50" height="40" >
                                <image width="40" height="40" href="images/addPictureIcon.svg"/>        <!-- Immagine Bottone: +Foto -->
                        </svg>
                        Pubblica una foto

                </button>

        </form>
</div>
