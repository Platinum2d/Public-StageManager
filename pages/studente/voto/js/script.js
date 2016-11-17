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
            alert(msg);
        }
    });
}