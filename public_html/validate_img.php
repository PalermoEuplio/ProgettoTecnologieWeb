<?php

        function is_file_img($file) {

                $allowed_extensions = array('jpg', 'jpeg', 'png', 'gif','bmp');

                $ext = strtolower(substr(strrchr($file['name'], "."), 1));

                // Se l'estensione non è supportata, il file non è un immagine
                if(!in_array($ext, $allowed_extensions)) return false;
                
                // Se l'estensione è giusta, controllo il contenuto
                $image_info = getimagesize($file['tmp_name']);

                // Se non ci sono informazioni, il file non è un immagine
                if(empty($image_info)) return false;

                if(empty($image_info['mime'])) return false;
                
                return true;

        }

?>
