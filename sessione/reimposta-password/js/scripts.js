function backToHome () {
	location.href = "../../index.php";
}

function checkEquals () {
    password = ""+$("input[name=password]").val();
    confermapassword = ""+$("input[name=confermapassword]").val();
    if (password !== confermapassword || !password.trim() || !confermapassword.trim()) {
    	document.getElementById("send").disabled = true;
    }
    else {
    	document.getElementById("send").disabled = false;
    }
}

function replacePassword () {
	data.password = $("input[name=password]").val();
	data.id = $("input[name=id]").val();
	$.ajax({
        type : 'POST',
        url : '../ajaxOps/replacepassword.php',
        cache : false,
        data : data,
        success : function (msg)
        {
            if (msg === 0) {
            	printSuccess ("E-mail corretta", "La richiesta di recupero password è avvenuta con successo." +
        						"<br>A breve riceverai, tramite mail, un link alla pagina dalla quale potrai reimpostare la tua password.");
            }
            else if (msg === 1) {
            	printError ("Errore", "Errore nella richiesta.");
            }
        },
        error : function () {
        	printError ("Errore", "Errore durante l'invio della richiesta richiesta.");
        }
     });
}

$(document).ready(function() {
	$("input[name=password]").keyup (checkEquals);
	$("input[name=confermapassword]").keyup (checkEquals);
});