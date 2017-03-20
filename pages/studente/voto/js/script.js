function sendGrade()
{
    voto = $('#selectVoto').val();
    descrizione = $('#styled').val();
    
    $.ajax({
        type : 'POST',
        url : 'ajaxOps/invia.php',
        cache : false,
        data : 
        {
            'voto' : voto,
            'descrizione' : descrizione
        },
        success : function (msg)
        {
            if (msg == 'ok') {
            	printSuccess ("Invio riuscito", "Votazione inviata con successo.");
            }
            else {
            	printErrorr ("Errore", "Problema nell'invio della votazione.");
            }
        }
    });
}