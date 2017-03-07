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
	data = {
			'id' : $("input[name=id]").val(),
			'password' : $("input[name=password]").val()
		};
	$.ajax({
        type : 'POST',
        url : 'ajaxOps/replacepassword.php',
        cache : false,
        data : data,
        success : function (msg)
        {
            if (msg === '0') {
            	printSuccess ("Recupero concluso", "Password reimpostata con successo.", backToHome);
            }
            else if (msg === '1') {
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