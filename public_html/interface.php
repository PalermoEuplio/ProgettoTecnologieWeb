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
<head>
        <link rel="stylesheet" type="text/css" href="interface.css"/>
</head>
<body>
        <div id="user">
                <?php   
                        include "db.php";

                        

                        function get_img($user, $db){
                                $sql = "SELECT pfp FROM utente WHERE username=$1";
                                $ret = pg_query_params($db, $sql, array($user));
                                if($ret && $row = pg_fetch_assoc($ret)){
                                        if(empty($row['pfp'])) {
                                                return images/anonymusUserIcon.svg; 
                                        }
                                return $row['pfp'];
                                }
                        }
                        
                        $user = $_SESSION['username'] ?? 'Ospite';
                        $pfp = get_img($user,$db);


                ?>
                <div id="userform" onmouseover="comparsa('userinfo');" onmouseout="scomparsa('userinfo');">
                        <img id="userIcon" src="<?= htmlspecialchars($pfp) ?>"/>

                        <div id="userinfo">
                                <form action="endSession.php">
                                        <button style="cursor: pointer;">Logout</button>
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
