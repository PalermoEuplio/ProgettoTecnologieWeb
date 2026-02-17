//              ----- Script necessario al funzionamento della pagina -----

window.onload = function() {
        async function send_post() {    // Funzione d'invio del post rapido

                const textElement = document.getElementById('fastmsg'); // Prendo il riferimento all'area di testo ed elimino eventuali spazi superflui
                const message = textElement.value.trim();

                if (message === "") return; // Termino l'esecuzione se il testo è vuoto

                let send_confirm = confirm("Sei sicuro di voler postare il messaggio ?");        // Richiesta di conferma per l'utente mediante confirm del browser

                if (send_confirm) {     // Verifico l'ok dell'utente

                        const formData = new FormData();        // Preparo il messaggio per inviare la descrizione del post con id f_description
                        formData.append('f_description', message);

                        try {
                                
                                const response = await fetch('post-manager.php', {      // Invio i dati al post-manager
                                        method: 'POST',
                                        body: formData
                                });

                                const result = await response.json();   // Aspetto la risposta dal post-manager

                                if (result.success) {
                                        
                                        window.location.reload();       // Se il server dice OK, aggiorno la pagina per vedere i post

                                } else {

                                        alert("Errore durante il salvataggio: " + result.error);

                                }
                        } catch (error) {
                                console.error("Errore di rete:", error);
                                alert("Errore di connessione al server.");
                        }
                }

        }


        async function send_comment(btn) {      // Funzione necessaria all'invio di nuovi commenti. Prende in ingresso il riferimento al bottone

                const btn_div = btn.closest('.container-post'); // Prendo il riferimento al bottone specifico del commento che è stato premuto e all'id del relativo post
                const idpost = btn_div.dataset.idPost;

                const textElement = btn_div.querySelector('.textcomment');      // Prendo il riferimento al testo del commento da postare
                const message = textElement.value.trim();

                if (message === "") return; // Termino l'esecuzione se il testo è vuoto

                let send_confirm = confirm("Sei sicuro di voler postare il Commento?"); // Richiesta di conferma per l'utente mediante confirm del browser

                if (send_confirm) {     // Verifico l'ok dell'utente

                        const formData = new FormData();        // Preparo il messaggio per inviare il commento e l'id del post con relativi id comment e id_post
                        formData.append('comment', message);
                        formData.append('id_post', idpost);

                        try {
                                
                                const response = await fetch('post-manager.php', {      // Invio i dati al post-manager
                                        method: 'POST',
                                        body: formData
                                });

                                const result = await response.json();   // Aspetto la risposta dal post-manager

                                if (result.success) {
                                        
                                        window.location.reload();       // Se il server dice OK, aggiorno la pagina per vedere il post aggiornato

                                } else {
                                        alert("Errore durante il salvataggio: " + result.error);
                                }
                        } catch (error) {
                                console.error("Errore di rete:", error);
                                alert("Errore di connessione al server.");
                        }
                }

        }


        async function deletefunction(idpost) { // Funzione che specifica il comportamento del bottone elimina. Prende come ingresso l'id del post da eliminare


                let send_confirm = confirm("Sei sicuro di voler eliminare il post?");   // Richiesta di conferma per l'utente mediante confirm del browser

                if(send_confirm){       // Verifico l'ok dell'utente

                        
                        const formData = new FormData();        // Preparo il messaggio per inviare l'id del post e la flag per l'eliminazione con relativi id id_post e delete
                        formData.append('id_post', idpost);
                        formData.append('delete', idpost);

                        try {
                                
                                const response = await fetch('post-manager.php', {      // Invio i dati al post-manager
                                        method: 'POST',
                                        body: formData
                                });

                                const result = await response.json();   // Aspetto la risposta dal post-manager

                                if (result.success) {
                                        
                                        window.location.reload();       // Se il server dice OK, aggiorno la pagina per vedere la lista aggiornata dei post

                                } else {
                                        alert("Errore durante il salvataggio: " + result.error);
                                }
                        } catch (error) {
                                console.error("Errore di rete:", error);
                                alert("Errore di connessione al server.");
                        }
                }
        }
}
