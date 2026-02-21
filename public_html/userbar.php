<!-- Barra opzioni utente -->
<div id="user"> <!-- Contenitore delle operazioni accessibili dall'utente -->
        
        <div id="fastmsgform">  <!-- Contenitore della barra per il post rapido -->

                <textarea id="fastmsg" class="barstyle" type="text" autocomplete="off" placeholder="A Cosa stai Pensando?..."></textarea>       <!-- TextArea contenente la descirizione del post -->
                        
                <button id="sendMessege" onclick="send_post()" title="Pubblica messaggio"> <!-- Bottone necessario all'invio del post rapido -->

                        <svg width="25" height="25">
                                <image width="25" height="25" href="images/sendMessageIcon.svg"/>       <!-- Immagine Bottone: Freccia di invio -->
                        </svg>

                </button>

        </div>
        <form id="photoform"action="addPhoto.php">      <!-- Contenitore del bottone di aggiunta post completo -->

                <button id="addPhoto" title="Pubblica un post">

                        <svg width="25" height="25" >
                                <image width="25" height="25" href="images/addPictureIcon.svg"/>        <!-- Immagine Bottone: +Foto -->
                        </svg>

                </button>

        </form>
</div>
