<header class="panel">
        <div id="logo">
                <h1>Nome sito</h1>
        </div>
        <div id="searchbar">
                <button id="searchicon">
                        <svg width="30" height="30" xmlns="http://www.w3.org/2000/svg">
                                <image width="30" height="30" href="images/searchicon.svg"/>
                        </svg>
                </button>
                <input type="text" autocomplete="off" id="searchvalue" placeholder="Cerca..."/>
        </div>

</header>
<body>
        <div id="user">
                <div id="userform" onmouseover="comparsa('userinfo');" onmouseout="scomparsa('userinfo');">
                        <svg id="userIcon" width="70" height="70" viewBox="0 0 31 31">
                                <image href="images/anonymusUserIcon.svg" width="31" height="31"/>
                        </svg>

                        <div id="userinfo">
                                <form action="login.php">
                                        <button id="login" style="cursor: pointer;">Login</button>
                                </form>
                        </div>
                        <script>
                                function comparsa(x) {
                                        document.getElementById(x).style.display = "block"; 
                                }

                                function scomparsa(x) { 
                                        document.getElementById(x).style.display = "none"; 
                                }
                        </script>
                        
                </div>
                              
                <form id="fastmsgform">
                        <input id="fastmsg" class="barstyle" type="text" autocomplete="off" id="searchvalue" placeholder="A Cosa stai Pensando?..."/>
                                
                        <button id="sendMessegeIcon">
                                <svg width="43" height="35" viewBox="0 0 32 32">
                                <image width="32" height="32" href="images/sendMessageIcon.svg"/>
                                </svg>
                        </button>
                   </form>

                 <form id="photoform"action="addPhoto.php">
                        <button id="addPhoto">
                                <svg width="43" height="35" viewBox="0 0 32 32">
                                        <image width="32" height="32" href="images/addPictureIcon.svg"/>
                                </svg>
                        </button>
                </form>
                        
        </div>

        <div id="main">
                <div id="content">
                                <h2>Benvenuto nel nostro sito!</h2>
                                <p>Questo è un esempio di interfaccia utente creata con HTML e CSS.</p>
<p>Questo è un esempio di interfaccia utente creata con HTML e CSS.</p>
<p>Questo è un esempio di interfaccia utente creata con HTML e CSS.</p>
<p>Questo è un esempio di interfaccia utente creata con HTML e CSS.</p>
<p>Questo è un esempio di interfaccia utente creata con HTML e CSS.</p>
<p>Questo è un esempio di interfaccia utente creata con HTML e CSS.</p>
<p>Questo è un esempio di interfaccia utente creata con HTML e CSS.</p>
<p>Questo è un esempio di interfaccia utente creata con HTML e CSS.</p>
<p>Questo è un esempio di interfaccia utente creata con HTML e CSS.</p>
<p>Questo è un esempio di interfaccia utente creata con HTML e CSS.</p>
<p>Questo è un esempio di interfaccia utente creata con HTML e CSS.</p>
<p>Questo è un esempio di interfaccia utente creata con HTML e CSS.</p>
<p>Questo è un esempio di interfaccia utente creata con HTML e CSS.</p>
<p>Questo è un esempio di interfaccia utente creata con HTML e CSS.</p>
<p>Questo è un esempio di interfaccia utente creata con HTML e CSS.</p>
<p>Questo è un esempio di interfaccia utente creata con HTML e CSS.</p>
<p>Questo è un esempio di interfaccia utente creata con HTML e CSS.</p>

<p>Questo è un esempio di interfaccia utente creata con HTML e CSS.</p><p>Questo è un esempio di interfaccia utente creata con HTML e CSS.</p>
<p>Questo è un esempio di interfaccia utente creata con HTML e CSS.</p>
<p>Questo è un esempio di interfaccia utente creata con HTML e CSS.</p>
<p>Questo è un esempio di interfaccia utente creata con HTML e CSS.</p>
<p>Questo è un esempio di interfaccia utente creata con HTML e CSS.</p>
<p>Questo è un esempio di interfaccia utente creata con HTML e CSS.</p>
<p>Questo è un esempio di interfaccia utente creata con HTML e CSS.</p>
<p>Questo è un esempio di interfaccia utente creata con HTML e CSS.</p>

                </div>
                <?php include 'footer.php'; ?>
        </div>

        <aside></aside> 
        
</body>
