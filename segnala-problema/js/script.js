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
               $.ajax({
                   url : 'ajaxOps/ajaxSendMail.php',
                   type: 'POST',
                   data : consiglio,
                   cache : false
                });
               printSuccess("Segnalazione di un problema", "Segnalazione avvenuta con successo.");
               freeFields();
           }
           else  {
        	   printError("Segnalazione di un problema", "Segnalazione non avvenuta con successo.");
           }
       },
       error : function () {
    	   printError("Segnalazione di un problema", "Segnalazione non avvenuta con successo.");
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