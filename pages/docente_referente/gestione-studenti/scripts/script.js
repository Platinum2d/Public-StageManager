$(document).ready(function (){
    $(".docTutButton").click ( function () {
    	tr_click = $(this).parents("tr");
	    id_docente = $(this).data("id");
	    id_classe = $(tr_click).data("classe");
        tutorContent = $("<tr>" +
			        		"<td colspan='3'>" +
			        			"<div class='row information-row'>" +
			        				"<div class='col col-sm-4'>" +
			        					"Docente tutor:" +
			        					"<br>" +
			        					"<select class='form-control'>" +
			        					"</select>" +
			        					"<br>" +
			        					"<button class='remove-assignment btn btn-danger''>Rimuovi assegnazione</button>" +
			        				"</div>" +
			        				"<div class='col col-sm-8 dati-docente'>" +
			        				"</div>" +
			        			"</div>" +
			        		"</td>" +
			        		"<td class='actions text-center'>" +
				        		"<button class='btn btn-danger' disabled>Annulla</button> " +
				        		"<button class='btn btn-success' disabled>Assegna</button>" +
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
	        		select = tutorContent.find ("select");
	        		select.data ("last", id_docente);
	        		if (id_docente == "-1") {
	        			tutorContent.find (".remove-assignment").attr("disabled","disabled");
	        			select.addClass("titolo-non-selezionabile");
	        			select.append("<option value='-1' selected>Scegli un'opzione</option>");
	        		}
	        		$(xml).find("docente").each ( function (index, element) {
	        			id = $(element).find("id").text();
	        			nome = $(element).find("nome").text();
	        			cognome = $(element).find("cognome").text();
	        			selected = "";
	        			if (id == id_docente) {
	        				selected = "selected";
	        			}
	        			select.append("<option value='"+id+"' "+selected+">" +nome + " " + cognome + "</option>");
	        			
	        			select.change (function () {
	        				//$(this).siblings (".remove-assignment").removeAttr("disabled");
	        				showDatiDocente ($(this).parent("div").siblings(".dati-docente"), $(this).val());
	        				if (select.data("last") != select.val()) {
	        					$(".actions").find ("button").removeAttr ("disabled");
	        				}
	        			})
	        			
	        			if (id_docente !== -1)  {
		        			showDatiDocente (tutorContent.find (".dati-docente"), id_docente);
	        			}
		        		$(tr_click).after (tutorContent);
	        		});
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
        		nome = $(xml2).find("nome").text();
        		cognome = $(xml2).find("cognome").text();
        		telefono = $(xml2).find("telefono").text();
        		email = $(xml2).find("email").text();
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

/*function openEdit(numberId, id_scuola)
{
    $.ajax({
        type : 'POST',
        url : 'ajaxOpsPerScuole/getData.php',
        cache : false,
        data : { 
        	'id' : id_scuola
    	},
        success : function (xml)
        {
            $("#modifica"+numberId).prop("disabled", true);
            var nome = $(xml).find("scuola").find("nome").text();
            var citta = $(xml).find("scuola").find("citta").text();
            var CAP = $(xml).find("scuola").find("CAP").text();
            var indirizzo = $(xml).find("scuola").find("indirizzo").text();
            var telefono = $(xml).find("scuola").find("telefono").text();
            var email = $(xml).find("scuola").find("email").text();
            var sitoweb = $(xml).find("scuola").find("sito_web").text();
            
            setOnChangeEvents(numberId);
            $("#edit"+numberId).hide();
            $("#edit"+numberId).fadeIn("slow");
        }
    });    
}

function setOnChangeEvents(numberId)
{
    $("#nome"+numberId).on ('input', function (e){ $(this).css('color','red'); });
    $("#citta"+numberId).on ('input', function (e){ $(this).css('color','red'); });
    $("#CAP"+numberId).on ('input', function (e){ $(this).css('color','red'); });
    $("#indirizzo"+numberId).on ('input', function (e){ $(this).css('color','red'); });
    $("#telefono"+numberId).on ('input', function (e){ $(this).css('color','red'); });
    $("#email"+numberId).on ('input', function (e){ $(this).css('color','red'); });
    $("#sitoweb"+numberId).on ('input', function (e){ $(this).css('color','red'); });
}

function resetColors(numberId)
{
    $("#nome"+numberId).css('color','#555');
    $("#citta"+numberId).css('color','#555');
    $("#CAP"+numberId).css('color','#555');
    $("#indirizzo"+numberId).css('color','#555');
    $("#telefono"+numberId).css('color','#555');
    $("#email"+numberId).css('color','#555');
    $("#sitoweb"+numberId).css('color','#555');
}

function sendData(numberId, id_scuola)
{
    tosend = {
        'id' : id_scuola,
        'nome' : $("#nome"+numberId).val(),
        'citta' : $("#citta"+numberId).val(),
        'CAP' : $("#CAP"+numberId).val(),
        'indirizzo' : $("#indirizzo"+numberId).val(),
        'telefono' : $("#telefono"+numberId).val(),
        'email' : $("#email"+numberId).val(),
        'sitoweb' : $("#sitoweb"+numberId).val()
    };
    
    $.ajax({
        type : 'POST',
        url : 'ajaxOpsPerScuole/ajaxInvia.php',
        cache : false,
        data : tosend,
        success : function (msg)
        {
            if (msg === "ok")
                resetColors(numberId);
        }
    });
}

function deleteSchool(numberId, id_scuola)
{
    var confirmed = confirm("Confermare l'eliminazione della seguente scuola?");
    
    if (confirmed)
    {
        $.ajax({
            type : 'POST',
            url : 'ajaxOpsPerScuole/ajaxElimina.php',
            cache : false,
            data : { 'id' : id_scuola },
            success : function (msg)
            {
                if (msg === "ok")
                    location.reload();
                else
                    printError("Eliminazione non riuscita",msg);
            }
        }); 
    }
}*/

function closeEdit(numberId)
{
    $("#edit"+numberId).remove();
    $("#modifica"+numberId).prop("disabled", false);
}