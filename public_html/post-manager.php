<?php

    // File Php Contenente la logica applicativa legata ai post

    include "db.php";   // Connessione al database
    
    //      Serie di controlli per capire quale opzione si vuole fare

    if(isset($_POST['delete']) && isset($_POST['id_post'])){    // Primo controllo per l'eliminazione del post

        header('Content-Type: application/json');   // Prevedo il ritorno Ajax/json

        $sql = "DELETE FROM post WHERE id_post = $1";   // Query per eliminazione del post a partire dall'id
        $prep = pg_prepare($db, "delete_query", $sql);
        $ret = pg_execute($db, "delete_query", array($_POST['id_post']));

        if ($ret) {     // Verifico se l'eliminazione sia avvenuta con successo o meno e ritorno al chiamante della pagina
            echo json_encode(['success' => true]);
        } else {
            echo json_encode(['success' => false, 'error' => pg_last_error($db)]);
        }

    }

    else if(isset($_POST['comment']) && isset($_POST['id_post'])){     // Secondo controllo per aggiunta di commenti

        header('Content-Type: application/json');   // Prevedo il ritorno Ajax/json

        $text = $_POST['comment'];  // Preparo i diversi campi alla query
        $id_post = $_POST['id_post'];
        $user = $_SESSION['username'];
        $new_comment = '{{' . $user . ',' . $text . '}}';   // Compongo il campo del commento

        $sql = "UPDATE post SET comments = comments || $1::text[] WHERE id_post = $2";  // Query per l'aggiunta del commento
        $prep = pg_prepare($db, "comment_query", $sql);
        $ret = pg_execute($db, "comment_query", array($new_comment, $id_post));

        if ($ret) { // Verifico se l'eliminazione sia avvenuta con successo o meno e ritorno al chiamante della pagina
            echo json_encode(['success' => true]);
        } else {
            echo json_encode(['success' => false, 'error' => pg_last_error($db)]);
        }

    }

    else if(isset($_POST['action']) && $_POST['action'] === 'like' && isset($_POST['id_post'])) {

        header('Content-Type: application/json');

        if (!isset($_SESSION['username'])) {
            echo json_encode(['success' => false]);
            exit();
        }

        $id_post = $_POST['id_post'];
        $username = $_SESSION['username'];

        $check = pg_query_params(
            $db,
            "SELECT 1 FROM like_post WHERE id_post=$1 AND username=$2",
            array($id_post, $username)
        );

        if (pg_num_rows($check) == 0) {

            pg_query_params(
                $db,
                "INSERT INTO like_post (id_post, username) VALUES ($1,$2)",
                array($id_post, $username)
            );

        } else {

            pg_query_params(
                $db,
                "DELETE FROM like_post WHERE id_post=$1 AND username=$2",
                array($id_post, $username)
            );
        }

        $count = pg_query_params(
            $db,
            "SELECT COUNT(*) FROM like_post WHERE id_post=$1",
            array($id_post)
        );

        $like_total = pg_fetch_result($count, 0, 0);

        echo json_encode([
            'success' => true,
            'count' => $like_total
        ]);

        exit();
    }

    else if(isset($_POST['f_description'])){     // Terzo controllo per i post rapidi con sola descrizione

        $desc = $_POST['f_description'];    // Preparo la descrizione del post

        if (insert_post('', $desc, '{}', $_SESSION['username'])) {  // Effettuo l'inserimento del post mediante la funzione insert_post, riempendo solo i campi di descrizione e creator, e ne verifico il valore di ritorno
            echo json_encode(['success' => true]);
        } else {
            echo json_encode(['success' => false, 'error' => pg_last_error($db)]);
        }

    }
    
    else if(isset($_POST['description']) && isset($_POST['tag'])){  //Quarto controllo per i post completi

        $description = $_POST['description'];   // Preparo la descrizione

        if(empty($description)){    // Verifico che la descrizione non sia vuota; in caso negativo torno alla pagina chiamante con id errore=1
            header("Location: addPhoto.php?err=1"); 
            exit();
        }

        $tags_input = isset($_POST['tag']) ? trim($_POST['tag']) : '';  // Preparo i tag

        if(empty($tags_input)){ // Verifico che il campo dei tag non sia vuoto; in caso negativo torno alla pagina chiamante con id errore=2
            header("Location: addPhoto.php?err=2");
            exit();
        }
            

        // Converto i tag in formato leggibile da Postgre

        $temp_arr = explode(',',$tags_input);   // Mi genero un'array per ogni campo dei tag separato da ,

        $tag_final = [];    // Variabile temporanea per array tag

        foreach ($temp_arr as $t) { // Aggiusto la sintassi dei tag

            $t = trim($t);  //Rimuovo gli spazi
            if(empty($t))   continue;   //Salta il tag se è vuoto
            
            if(substr($t,0,1)!== '#'){  // Verifico di nuovo l'inserimento del #
                $t = '#' . $t;
            }

            $t = str_replace(' ', '_', $t); // Rimpiazzo gli spazi con underscore

            $tag_final[] = $t;  // Aggiorno il contenuto della variabile temp 

        }    
            
        if(empty($tag_final)){  // Verifico che il campo dei tag non sia vuoto a fine processo (Caso tag errati); in caso negativo torno alla pagina chiamante con id errore=3
            header("Location: addPhoto.php?err=3");
            exit();
        }

        $tag = '{' . implode(',', $tag_final) . '}';    //Conversione finale in tag utilizzabile

        $post_path = '';     // Preparo l'immagine; valore di default nullo se non c'è l'immagine

        if(isset($_FILES['image_post'])){   // Se vi è l'immagine devo sopstarla nella cartella dedicata alle immagini dei post e devo aggiornarne il riferimento

            $post_image = $_FILES['image_post'];    // Prelevo l'immagine
            $target_dir = "postimages/";    // Prelevo la target directory

            $ext = pathinfo($post_image["name"], PATHINFO_EXTENSION);   // Unisco l'immagine e la target directory per formare quello che sarà il nome dell'immagine (Compreso d'estenzione)
            $filename = uniqid("post_", true) . "." . $ext;
            $target_file = $target_dir . $filename;

            if (move_uploaded_file($post_image["tmp_name"], $target_file)) {    // Sposto l'immagine e aggiorno la variabile con il relativo path
                $post_path = $target_file;
            }

        }


        $creator = $_SESSION['username'];       // Salvo il creatore del post dalla sessione

        if(insert_post($post_path,$description,$tag,$creator)){ // Richiamo la funzione di inserimento del post e ne verifico il valore di ritorno
            
            header("Location: index.php");  // Reinderizzo alla pagina principale
            exit();

        }else{exit();}  //Errore generico per l'inserimento dei dati
        
    }

    

    function insert_post($image, $description, $tag, $creator){ // Funzione che gestisce l'inserimento dei post nel database
        
        require "./db.php"; // Richiede accesso alle variabili di db.php

        $reset_seq_sql = "SELECT setval(pg_get_serial_sequence('post', 'id_post'), COALESCE((SELECT MAX(id_post) FROM post), 0) + 1, false)";   // Aggiorno la variabile id_post altrimenti aumenta all'infinito anche se si eliminano i post
    
        
        if (!pg_query($db, $reset_seq_sql)) {   // Faccio la query che aggiorna l'id_post e ne verifico il valore di ritorno
            error_log("Errore reset sequenza: " . pg_last_error($db));
        }

        $sql = "INSERT INTO post(image, description, tag, comments, creator) VALUES($1, $2, $3, $4, $5)";   // Effettuo la query d'inserimento del post
        $prep = pg_prepare($db, "insertpost", $sql); 
        $ret = pg_execute($db, "insertpost", array($image, $description, $tag, '{}', $creator));

        if(!$ret) { // Verifico se la query sia andata a buon fine o meno
            echo "ERRORE QUERY: " . pg_last_error($db);
            return false; 
        }
        else{
            return true;
        }
    }

?>