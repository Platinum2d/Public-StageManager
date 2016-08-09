function sendGrade()
{
    voto = $('#selectVoto').val();
    descrizione = $('#styled').val();
    
    $.ajax({
        type : 'POST',
        url : 'Invia.php',
        cache : false,
        data : 
        {
            'voto' : voto,
            'descrizione' : descrizione
        },
        success : function (msg)
        {
            alert(msg);
        }
    });
}

