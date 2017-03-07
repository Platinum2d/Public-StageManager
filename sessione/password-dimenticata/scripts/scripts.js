function checkEquals () {
    email = ""+$("input[name=mail]").val();
    confermamail = ""+$("input[name=confermamail]").val();
    if (email !== confermamail || !email.trim() || !confermamail.trim()) {
    	document.getElementById("sendEmail").disabled = true;
    }
    else {
    	document.getElementById("sendEmail").disabled = false;
    }
}

function emailRecovery () {
	data = {
		'mail' : $("input[name=mail]").val()
	};
	$.ajax({
        type : 'POST',
        url : 'ajaxOps/sendmail.php',
        cache : false,
        data : data,
        success : function (msg)
        {
            if (msg === '0') {
            	printSuccess ("E-mail corretta", "La richiesta di recupero password è avvenuta con successo." +
        						"<br>A breve riceverai, tramite mail, un link alla pagina dalla quale potrai reimpostare la tua password.");
            }
            else if (msg === '1') {
            	printError ("E-mail non corretta", "L'indirizzo e-mail inserito non corrisponde a nessun utente.");            	
            }
            else if (msg === '2') {
            	printError ("Errore", "Errore nella richiesta.");            	
            }
            else if (msg === '3') {
            	printError ("Errore", "Errore nell'invio della mail.<br>Contattare l'amministratore del servizio.");            	
            }
            else {
            	alert (msg);
            }
        },
        error : function () {
        	printError ("Errore", "Errore durante l'invio della richiesta richiesta.");
        }
        
     });
}

$(document).ready(function() {
	$("input[name=mail]").keyup (checkEquals);
	$("input[name=confermamail]").keyup (checkEquals);
});