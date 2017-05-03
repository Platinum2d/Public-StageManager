$(document).ready(function(){
	checkStatusButton ();
	$("textarea.answer").on("keyup",function (e) {
		checkStatusButton ();
	});
});

function checkStatusButton () {
	if (checkEmptyFields ([".answer"])) {
		$("#action").attr ("disabled", "");
	}
	else {
		$("#action").removeAttr ("disabled");
	}
}

function getJsonAnswers () {
	var risposte = new Array ();
	var i = 0;
	$(".answer").each (function () {
		var td = $(this).parent ("td");
		var libera = 0;
		if ($(this).prop("tagName").toLowerCase () == "textarea") {
			libera = 1;
		}
		var risposta = {
			'libera' : libera,
			'id_col' : td.data ("idc"),
			'id_rig' : td.data ("idr"),
			'risposta' : $(this).val ()
		}
		risposte.push (risposta);
	});
	return JSON.stringify(risposte);
}

function updateAnswers () {
	var risposte = getJsonAnswers ();
	$.ajax({
        type : 'POST',
        url : 'ajaxOps/aggiorna-risposte.php',
        data : {data : risposte},
        cache : false,
        success : function (msg)
        {
            if (msg == "ok") {
            	printSuccess ("Richiesta riuscita", "Invio della compilazione della valutazione riuscito con successo.");
            }
            else {
            	printError ("Errore", "Errore nell'esecuzione della richiesta. Se il problema persiste, contattare l'aministratore.");
            }
        },
        error : function ()
        {
            printError ("Errore", "Problema nell'invio della richiesta.");
        }
    });
}

function addAnswers () {
	var risposte = getJsonAnswers ();
	$.ajax({
        type : 'POST',
        url : 'ajaxOps/aggiungi-risposte.php',
        data : {data : risposte},
        cache : false,
        success : function (msg)
        {
            if (msg == "ok") {
            	printSuccess ("Richiesta riuscita", "Invio della compilazione della valutazione riuscito con successo.");
            	
            	$("#action").removeClass ("btn-success")
            	.addClass ("btn-info")
            	.html ("<span class='glyphicon glyphicon-edit'></span> Modifica")
            	.attr ("onclick", "updateAnswers();");
            }
            else {
            	printError ("Errore", "Errore nell'esecuzione della richiesta. Se il problema persiste, contattare l'aministratore.");
            }
        },
        error : function ()
        {
            printError ("Errore", "Problema nell'invio della richiesta.");
        }
    });
}