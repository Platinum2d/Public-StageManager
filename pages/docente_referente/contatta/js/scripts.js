$(document).ready (function () {
	hideSecondPart ();
	
	$("#receiverType").change (function () {
		var valore = $("#receiverType").val ();
		if (valore != '-1') {
			$.ajax({
		        type : 'POST',
		        url : 'ajaxOps/getReceivers.php',
		        cache : false,
		        data : {
		        	'type' : valore
	        	},
		        success : function (xml) {
		        	if ($(xml).find("status").text() == '1') {
		        		var select = $("#receiver");
		        		select.html("");
		        		select.append ("<option value='-1' selected>Seleziona un'opzione</option>");
		        		$(xml).find("destinatario").each ( function (index, element) {
		        			var nome = $(element).find("nome").text() + " " + $(element).find("cognome").text();
		        			var email = $(element).find("email").text();
		        			var nome_studente_node = $(element).find("nome_studente");
		        			var cognome_studente_node = $(element).find("cognome_studente");
		        			if (nome_studente_node.length !==0 && cognome_studente_node.length !==0) {
		        				var nome_studente = " (studente: " + nome_studente_node.text() + " " + cognome_studente_node.text() + ")";
		        			}
		        			else {
		        				var nome_studente = "";
		        			}
		        			if ($(element).find("nome_aziendale").length !==0) {
		        				var nome_aziendale = " (azienda: " + $(element).find("nome_aziendale").text() + ")";
		        			}
		        			else {
		        				var nome_aziendale = "";
		        			}
		        			select.append("<option value='"+email+"'>" +nome + nome_studente + nome_aziendale + "</option>");
		        		});
		        	}
	        		else {
	        			printError ("Errore", "Errore nella richiesta dei destinatari disponibili.");
	        		}
	        	},
	        	error : function () {
	        		printError ("Errore", "Errore nella richiesta.");
	        	},
	        	complete : function () {

	        		checkTheWhole ();
	        	}
	        });
			$("#receiver").removeAttr ("disabled");
			if ($("#receiver").val () != '-1') {
				showSecondPart ();
			}
		}
		else {
			$("#receiver").attr ("disabled", "disabled");
			hideSecondPart ();
		}
	});
	
	$("#receiver").change (function () {
		if ($("#receiver").val () != '-1') {
			showSecondPart ();
		}
		else {
			hideSecondPart ();
		}
		checkTheWhole ();
	});
	
	$("#message").on ("input", function () {
		checkTheWhole ();
	});
});

function hideSecondPart () {
	$("#objectRow").hide ();
	$("#messageRow").hide ();
	$("#copyRow").hide ();
	$("#sendButton").hide ();	
}

function showSecondPart () {
	$("#objectRow").show ();
	$("#messageRow").show ();
	$("#copyRow").show ();
	$("#sendButton").show ();	
}

function checkTheWhole () {
	if ($("#receiverType").val () != '-1' && $("#receiver").val () != '-1' && $("#message").val ().trim () != "") {
		$("#sendButton").removeAttr ("disabled");
	}
	else {
		$("#sendButton").attr ("disabled", "disabled");
	}
}

function sendMail () {
	var destinatario = $("#receiver").val ();
	var oggetto = $("#object").val ();
	var messaggio = $("#message").val ();
	var copia = $("#sendCopy").is(':checked');
	if (messaggio != "" && destinatario != "") {
		$.ajax({
	        type : 'POST',
	        url : 'ajaxOps/mail.php',
	        cache : false,
	        data : {
	        	'email' : destinatario,
	        	'object' : oggetto,
	        	'message' : messaggio
	    	},
	        success : function (msg) {
	        	if (msg == "ok") {
	        		$("#object"). val ("");
	        		$("#message").val ("");
		    		checkTheWhole ();
		    		
	        		printSuccess ("Invio riuscito", "Invio della email avvenuto con successo.");
	        	}
	    		else {
	    			alert (msg);
	    			printError ("Errore", "Errore nell'invio della email");
	    		}
	    	},
	    	error : function () {
	    		printError ("Errore", "Errore nella richiesta.");
	    	},
	    	complete : function () {
	    		if (copia) {
	    			messaggio = "Copia dell'email inviata a " + destinatario + " tramite https://stagemanage.it:\n-------------------------------------------------------------\n\n" + messaggio;
	    			$.ajax({
	    		        type : 'POST',
	    		        url : 'ajaxOps/mail.php',
	    		        cache : false,
	    		        data : {
	    		        	'object' : oggetto,
	    		        	'message' : messaggio
	    		    	},
	    		        success : function (msg) {
	    		        	if (msg != "ok") {
	    		    			printError ("Errore", "Errore nell'invio della copia della email al mittente.");
	    		    		}
	    		    	},
	    		    	error : function () {
	    		    		printError ("Errore", "Errore nella richiesta.");
	    		    	}
	    		    });
        		}
	    	}
	    });
	}
	else {
		printError ("Errore", "I campi destinatario e/o messaggio sono vuoti.");
	}
}