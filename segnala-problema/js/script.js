consiglio = {
	'categoria': '',
    'oggetto': '',
    'messaggio' : ''
}

function sendAdvice()
{
    consiglio.categoria = $('#categoria').val();
    consiglio.oggetto = $('#oggetto').val();
    consiglio.messaggio = $('#messaggio').val();
    
    $.ajax({
       url : 'ajaxOps/ajaxSegnalaProblema.php',
       type: 'POST',
       data : consiglio,
       cache : false,
       success : function (msg)
       {
           if (msg == 0) {
               freeFields();
               $.ajax({
                   url : 'ajaxOps/ajaxSendMail.php',
                   type: 'POST',
                   data : consiglio,
                   cache : false
                });
               //modal
           }
       }
    });
}

function freeFields()
{
	consiglio.categoria = '';
	consiglio.oggetto = '';
	consiglio.messaggio = '';
    $('#oggetto').val(' ');
    $('#messaggio').val(' ');
}