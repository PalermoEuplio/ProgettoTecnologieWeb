<header>
        <div id="logo">
                <h1>「 ✦ MEMELANDIA ✦ 」</h1>      <!-- Nome Sito DA CAMBIAREEEEEEEEEEEEEEEE!!!!!!!!!!!!-->
        </div>

        <div id="searchbar">    <!-- Sezione della barra di ricerca in alto -->

                <button id="searchicon">        <!-- Bottone per cercare -->
                        <svg width="35" height="35" xmlns="http://www.w3.org/2000/svg">
                                <image width="35" height="35" href="images/searchicon.svg"/>
                        </svg>
                </button>

                <input type="text" autocomplete="off" id="searchvalue" placeholder="Cerca per tag e nome profilo..."/> <!-- Area di testo per la ricerca -->
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
<?php
        if(isset($_SESSION['username'])) {      // Controllo necessario alla visualizzazione della barra sopra ai post relativa all'utente
                include "userbar.php";
        }
?>
