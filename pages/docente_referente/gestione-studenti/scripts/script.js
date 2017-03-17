$(document).ready(function (){
	$(".docTutButton").click ( function () {
    	if ($(this).closest("tr").next(".doctut-row").length) {
    		$(this).closest("tr").next(".doctut-row").remove ();
    		return;
    	}
    	if ($(this).closest("tr").next(".azienda-row").length) {
    		$(this).closest("tr").next(".azienda-row").remove ();
    	}
    	var tr_click = $(this).parents("tr");
	    var id_docente = $(this).data("id");
	    var id_classe = $(tr_click).data("classe");
        var tutorContent = $("<tr class='doctut-row'>" +
			        		"<td colspan='3'>" +
			        			"<div class='row information-row'>" +
			        				"<div class='col col-sm-4'>" +
			        					"Docente tutor:" +
			        					"<br>" +
			        					"<select class='form-control titolo-non-selezionabile'>" +
			        						"<option value='-1'>Scegli un'opzione</option>" +
			        					"</select>" +
			        					"<br>" +
			        					"<button class='remove-docTut btn btn-danger'>Rimuovi assegnazione</button>" +
			        				"</div>" +
			        				"<div class='col col-sm-8 dati-docente'>" +
			        				"</div>" +
			        			"</div>" +
			        		"</td>" +
			        		"<td class='actions text-center'>" +
				        		"<button class='btn btn-danger close-doctut'>Annulla</button> " +
				        		"<button class='btn btn-success assign-doctut' disabled>Assegna</button>" +
			        		"</td>" +
			           "</tr>");
	    $.ajax({
	        type : 'POST',
	        url : 'ajaxOps/getDocenti.php',
	        cache : false,
	        data : {
	        	'id' : id_classe
        	},
	        success : function (xml) {
	        	if ($(xml).find("status").text() == '1') {
	        		var select = tutorContent.find ("select");
	        		select.data ("last", id_docente);
	        		if (id_docente == "-1") {
	        			tutorContent.find (".remove-docTut").attr("disabled","disabled");
	        			select.find ("option").attr ("selected", "selected");
	        		}
	        		$(xml).find("docente").each ( function (index, element) {
	        			var id = $(element).find("id").text();
	        			var nome = $(element).find("nome").text();
	        			var cognome = $(element).find("cognome").text();
	        			selected = "";
	        			if (id == id_docente) {
	        				selected = "selected";
	        			}
	        			select.append("<option value='"+id+"' "+selected+">" +nome + " " + cognome + "</option>");
	        		});
        			
        			select.change (function () {
        				showDatiDocente ($(this).parent("div").siblings(".dati-docente"), $(this).val());
        				if (select.data("last") != select.val()) {
        					$(this).closest("td").siblings(".actions").find (".assign-doctut").removeAttr ("disabled");
        				}
        			});
        			
        			tutorContent.find (".close-doctut").click (function () {
        	        	$(this).closest (".doctut-row").remove();
        	        });
        			
        			tutorContent.find (".assign-doctut").click (function () {
        				var pressed_button = this;
        				var new_id_docente = $(pressed_button).closest (".doctut-row").find("select").val();
        	        	if (new_id_docente != '-1') {
        	        		var id_shs = $(tr_click).data("shs");
	        	        	$.ajax({
	        	                type : 'POST',
	        	                url : 'ajaxOps/assignDocTutor.php',
	        	                cache : false,
	        	                data : {
	        	                	'id' : new_id_docente,
	        	                	'shs' : id_shs
	        	            	},
	        	                success : function (ret) {
	        	                	if (ret == 'ok') {
	        	                		var nome_docTut = $(pressed_button).closest ("tr").find("select option:selected").text();
	        	                		var docTutButton = $(pressed_button).closest ("tr").prev("tr").find(".docTutButton");
	        	        	        	$(docTutButton).html(nome_docTut + "&nbsp;&nbsp;<span class='glyphicon glyphicon-menu-down'></span>");
	        	        	        	$(docTutButton).data("id", new_id_docente);
	        	        	        	if ($(docTutButton).hasClass ("btn-danger")) {
	        	        	        		$(docTutButton).removeClass ("btn-danger").addClass ("btn-success");
	        	        	        	}
	        	                		$(pressed_button).closest ("tr").find(".remove-docTut").removeAttr("disabled");
	        	        	        	$(pressed_button).attr("disabled","disabled");
	        	        	        	select.data("last", new_id_docente);
	        	                	}
	        	            		else {
	        	            			printError ("Errore", "Si è verificato un problema in fase di assegnazione del docente tutor.");
	        	            		}
	        	            	},
	        	            	error : function () {
	        	            		printError ("Errore", "Errore nella richiesta.");
	        	            	}
	        	        	});
        				}
        	        	else {
        	        		printError ("Errore", "Docente tutor non valido.");
        	        	}
        	        });
        			
        			tutorContent.find (".remove-docTut").click (function () {
        				var pressed_button = this;
        				var id_shs = $(tr_click).data("shs");
        	        	$.ajax({
        	                type : 'POST',
        	                url : 'ajaxOps/removeDocTutor.php',
        	                cache : false,
        	                data : {
        	                	'shs' : id_shs
        	            	},
        	                success : function (ret) {
        	                	if (ret == 'ok') {
        	                		var docTutButton = $(pressed_button).closest ("tr").prev("tr").find(".docTutButton");
        	        	        	$(docTutButton).html("<i>Non assegnato</i>&nbsp;&nbsp;<span class='glyphicon glyphicon-menu-down'></span>");
        	        	        	$(docTutButton).data("id", "-1");
        	        	        	if ($(docTutButton).hasClass ("btn-success")) {
        	        	        		$(docTutButton).removeClass ("btn-success").addClass ("btn-danger");
        	        	        	}
        	        	        	$(pressed_button).attr("disabled","disabled");
        	        	        	if ($(pressed_button).siblings ("select").val() != "-1") {
        	        	        		$(pressed_button).closest ("tr").find(".assign-docTut").removeAttr("disabled");
        	        	        	}
        	                	}
        	            		else {
        	            			printError ("Errore", "Si è verificato un problema in fase di rimozione del docente tutor.");
        	            		}
        	            	},
        	            	error : function () {
        	            		printError ("Errore", "Errore nella richiesta.");
        	            	}
        	        	});
        	        });
        			
        			if (id_docente != "-1")  {
	        			showDatiDocente (tutorContent.find (".dati-docente"), id_docente);
        			}
	        		$(tr_click).after (tutorContent);
	        	}
        		else {
        			printError ("Errore", "Errore nella richiesta dei docenti tutor disponibili.");
        		}
        	},
        	error : function () {
        		printError ("Errore", "Errore nella richiesta.");
        	}
        });
    });
    
    $(".aziendaButton").click ( function () {
    	if ($(this).closest("tr").next(".azienda-row").length) {
    		$(this).closest("tr").next(".azienda-row").remove ();
    		return;
    	}
    	if ($(this).closest("tr").next(".docTut-row").length) {
    		$(this).closest("tr").next(".docTut-row").remove ();
    	}
    	var tr_click = $(this).parents("tr");
	    var id_azienda = $(this).data("id");
	    var id_classe = $(tr_click).data("classe");
        var aziendaContent = $("<tr class='azienda-row'>" +
				        		"<td colspan='3'>" +
				        			"<div class='row information-row'>" +
				        				"<div class='col col-sm-4'>" +
				        					"Azienda:" +
				        					"<br>" +
				        					"<select class='form-control titolo-non-selezionabile'>" +
				        						"<option value='-1'>Scegli un'opzione</option>" +
				        					"</select>" +
				        					"<br>" +
				        					"<button class='remove-azienda btn btn-danger'>Rimuovi assegnazione</button>" +
				        				"</div>" +
				        				"<div class='col col-sm-8 dati-azienda'>" +
				        				"</div>" +
				        			"</div>" +
				        		"</td>" +
				        		"<td class='actions text-center'>" +
					        		"<button class='btn btn-danger close-azienda'>Annulla</button> " +
					        		"<button class='btn btn-success assign-azienda' disabled>Assegna</button>" +
				        		"</td>" +
				           "</tr>");
	    $.ajax({
	        type : 'POST',
	        url : 'ajaxOps/getAziende.php',
	        cache : false,
	        data : {
	        	'id' : id_classe
	    	},
	        success : function (xml) {
	        	if ($(xml).find("status").text() == '1') {
	        		var select = aziendaContent.find ("select");
	        		select.data ("last", id_azienda);
	        		if (id_azienda == "-1") {
	        			aziendaContent.find (".remove-azienda").attr("disabled","disabled");
	        			select.find ("option").attr ("selected", "selected");
	        		}
	        		$(xml).find("azienda").each ( function (index, element) {
	        			var id = $(element).find("id").text();
	        			var nome = $(element).find("nome").text();
	        			selected = "";
	        			if (id == id_azienda) {
	        				selected = "selected";
	        			}
	        			select.append("<option value='"+id+"' "+selected+">" +nome + "</option>");
	        		});
        			
        			select.change (function () {
        				showDatiAzienda ($(this).parent("div").siblings(".dati-azienda"), $(this).val());
        				if (select.data("last") != select.val()) {
        					$(this).closest("td").siblings(".actions").find (".assign-azienda").removeAttr ("disabled");
        				}
        			});
        			
        			aziendaContent.find (".close-azienda").click (function () {
        	        	$(this).closest (".azienda-row").remove();
        	        });
        			
        			aziendaContent.find (".assign-azienda").click (function () {
        				var pressed_button = this;
        				var new_id_azienda = $(pressed_button).closest (".azienda-row").find("select").val();
        	        	if (new_id_azienda != '-1') {
        	        		var id_shs = $(tr_click).data("shs");
	        	        	$.ajax({
	        	                type : 'POST',
	        	                url : 'ajaxOps/assignAzienda.php',
	        	                cache : false,
	        	                data : {
	        	                	'id' : new_id_azienda,
	        	                	'shs' : id_shs
	        	            	},
	        	                success : function (ret) {
	        	                	if (ret == 'ok') {
	        	                		var nome_azienda = $(pressed_button).closest ("tr").find("select option:selected").text();
	        	                		var aziendaButton = $(pressed_button).closest ("tr").prev("tr").find(".aziendaButton");
	        	        	        	$(aziendaButton).html(nome_azienda + "&nbsp;&nbsp;<span class='glyphicon glyphicon-menu-down'></span>");
	        	        	        	$(aziendaButton).data("id", new_id_azienda);
	        	        	        	if ($(aziendaButton).hasClass ("btn-danger")) {
	        	        	        		$(aziendaButton).removeClass ("btn-danger").addClass ("btn-success");
	        	        	        	}
	        	                		$(pressed_button).closest ("tr").find(".remove-azienda").removeAttr("disabled");
	        	        	        	$(pressed_button).attr("disabled","disabled");
	        	        	        	select.data("last", new_id_azienda);
	        	                	}
	        	            		else {
	        	            			printError ("Errore", "Si è verificato un problema in fase di assegnazione dell'azienda.");
	        	            		}
	        	            	},
	        	            	error : function () {
	        	            		printError ("Errore", "Errore nella richiesta.");
	        	            	}
	        	        	});
        				}
        	        	else {
        	        		printError ("Errore", "Azienda non valida.");
        	        	}
        	        });
        			
        			aziendaContent.find (".remove-azienda").click (function () {
        				var pressed_button = this;
        				var id_shs = $(tr_click).data("shs");
        	        	$.ajax({
        	                type : 'POST',
        	                url : 'ajaxOps/removeAzienda.php',
        	                cache : false,
        	                data : {
        	                	'shs' : id_shs
        	            	},
        	                success : function (ret) {
        	                	if (ret == 'ok') {
        	                		var aziendaButton = $(pressed_button).closest ("tr").prev("tr").find(".aziendaButton");
        	        	        	$(aziendaButton).html("<i>Non assegnata</i>&nbsp;&nbsp;<span class='glyphicon glyphicon-menu-down'></span>");
        	        	        	$(aziendaButton).data("id", "-1");
        	        	        	if ($(aziendaButton).hasClass ("btn-success")) {
        	        	        		$(aziendaButton).removeClass ("btn-success").addClass ("btn-danger");
        	        	        	}
        	        	        	$(pressed_button).attr("disabled","disabled");
        	        	        	if ($(pressed_button).siblings ("select").val() != "-1") {
        	        	        		$(pressed_button).closest ("tr").find(".assign-azienda").removeAttr("disabled");
        	        	        	}
        	                	}
        	            		else {
        	            			printError ("Errore", "Si è verificato un problema in fase di rimozione dell'azienda.");
        	            		}
        	            	},
        	            	error : function () {
        	            		printError ("Errore", "Errore nella richiesta.");
        	            	}
        	        	});
        	        });
        			
        			if (id_azienda != "-1")  {
	        			showDatiAzienda (aziendaContent.find (".dati-azienda"), id_azienda);
        			}
	        		$(tr_click).after (aziendaContent);
	        	}
        		else {
        			printError ("Errore", "Errore nella richiesta delle aziende disponibili.");
        		}
        	},
        	error : function () {
        		printError ("Errore", "Errore nella richiesta.");
        	}
        });
    });
});

function showDatiDocente (father, id_docente) {
	$.ajax({
        type : 'POST',
        url : 'ajaxOps/getDocente.php',
        cache : false,
        data : {
        	'id' : id_docente
    	},
        success : function (xml2) {
        	if ($(xml2).find("status").text() == '1') {
        		var nome = $(xml2).find("nome").text();
        		var cognome = $(xml2).find("cognome").text();
        		var telefono = $(xml2).find("telefono").text();
        		var email = $(xml2).find("email").text();
        		father.append ("<table class='table table-responsive table-striped table-bordered'>" +
        							"<tbody>" +
		        						"<tr>" +
		        							"<td><b>Nome</b></td>" + 
		        							"<td>" + nome + "</td>" +
		        						"</tr>" +
		        						"<tr>" +
		        							"<td><b>Cognome</b></td>" + 
		        							"<td>" + cognome + "</td>" +
		        						"</tr>" +
		        						"<tr>" +
		        							"<td><b>Telefono</b></td>" + 
		        							"<td>" + telefono + "</td>" +
		        						"</tr>" +
		        						"<tr>" +
		        							"<td><b>Email</b></td>" + 
		        							"<td>" + email + "</td>" +
		        						"</tr>" +
        							"<tbody>" +
        						"</table>");
        	}
    		else {
    			printError ("Errore", "Errore nella richiesta delle informazioni del docente selezionato.");
    		}
    	},
    	error : function () {
    		printError ("Errore", "Errore nella richiesta.");
    	}
	});
}

function showDatiAzienda (father, id_azienda) {
	$.ajax({
        type : 'POST',
        url : 'ajaxOps/getAzienda.php',
        cache : false,
        data : {
        	'id' : id_azienda
    	},
        success : function (xml2) {
        	if ($(xml2).find("status").text() == '1') {
        		var nome = $(xml2).find("nome_aziendale").text();
        		var citta = $(xml2).find("citta").text();
        		var cap = $(xml2).find("cap").text();
        		var indirizzo = $(xml2).find("indirizzo").text();
        		var telefono_aziendale = $(xml2).find("telefono_aziendale").text();
        		var email_aziendale = $(xml2).find("email_aziendale").text();
        		var sito = $(xml2).find("sito").text();
        		var nome_responsabile = $(xml2).find("nome_responsabile").text();
        		var cognome_responsabile = $(xml2).find("cognome_responsabile").text();
        		var telefono_responsabile = $(xml2).find("telefono_responsabile").text();
        		var email_responsabile = $(xml2).find("email_responsabile").text();
        		father.append ("<table class='table table-responsive table-striped table-bordered'>" +
        							"<tbody>" +
		        						"<tr>" +
		        							"<td><b>Nome</b></td>" + 
		        							"<td>" + nome + "</td>" +
		        						"</tr>" +
		        						"<tr>" +
		        							"<td><b>Città</b></td>" + 
		        							"<td>" + citta + "</td>" +
		        						"</tr>" +
		        						"<tr>" +
		        							"<td><b>Indirizzo</b></td>" + 
		        							"<td>" + indirizzo + "</td>" +
		        						"</tr>" +
		        						"<tr>" +
		        							"<td><b>CAP</b></td>" + 
		        							"<td>" + cap + "</td>" +
		        						"</tr>" +
		        						"<tr>" +
		        							"<td><b>Tel. aziendale</b></td>" + 
		        							"<td>" + telefono_aziendale + "</td>" +
		        						"</tr>" +
		        						"<tr>" +
		        							"<td><b>E-mail aziendale</b></td>" + 
		        							"<td>" + email_aziendale + "</td>" +
		        						"</tr>" +
		        						"<tr>" +
		        							"<td><b>Sito web</b></td>" + 
		        							"<td>" + sito + "</td>" +
		        						"</tr>" +
		        						"<tr>" +
		        							"<td><b>Responsabile</b></td>" + 
		        							"<td>" + nome_responsabile + " " + cognome_responsabile + "</td>" +
		        						"</tr>" +
		        						"<tr>" +
		        							"<td><b>Tel. responsabile</b></td>" + 
		        							"<td>" + telefono_responsabile + "</td>" +
		        						"</tr>" +
		        						"<tr>" +
		        							"<td><b>E-mail responsabile</b></td>" + 
		        							"<td>" + email_responsabile + "</td>" +
		        						"</tr>" +
        							"<tbody>" +
        						"</table>");
        	}
    		else {
    			alert (xml2);
    			printError ("Errore", "Errore nella richiesta delle informazioni dell'azienda selezionata.");
    		}
    	},
    	error : function () {
    		printError ("Errore", "Errore nella richiesta.");
    	}
	});
}