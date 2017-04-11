function isEmpty(str) {
    return (!str || 0 === str.length);
}

$(document).ready(function() {
    function DescEdit(event){
    	var regtr = $(event.target).closest("tr");
    	var regLavoro = regtr.find(".regLavoro");
    	var lavoro = regLavoro.html();
    	var regInsegnamenti = regtr.find(".regInsegnamenti");
    	var insegnamenti = regInsegnamenti.html();
    	var regCommento = regtr.find(".regCommento");
    	var commento = regCommento.html();
    	var regDate = regtr.find(".regDate");
    	var date = regDate.html();
    	var dateSplitted = date.split("-");
    	var year = dateSplitted [2];
    	var month = parseInt (dateSplitted [1]) - 1;
    	var day = dateSplitted [0];
    	regDate.empty ();
    	regLavoro.empty();
    	regInsegnamenti.empty();
    	regCommento.empty();
    	regDate.append ("<input placeholder=\"gg-mm-aaaa\" class='datepicker form-control'/>");
    	regDate.find (".datepicker").datepicker({ 
    		dateFormat: 'dd-mm-yy', 
    		minDate: inizio_stage,
    		maxDate: fine_stage
		});
    	regDate.find (".datepicker").datepicker("setDate", new Date(year,month,day));
    	regDate.data ("oldDate", date);
    	regLavoro.append("<textarea maxlength=\"500\" class='newLavoro form-control'>" + lavoro + "</textarea>");
    	regLavoro.append("<textarea class='lavoroBackup' style='display: none;'>" + lavoro + "</textarea>");
    	regInsegnamenti.append("<textarea maxlength=\"500\" class='newInsegnamenti form-control'>" + insegnamenti + "</textarea>");
    	regInsegnamenti.append("<textarea class='insegnamentiBackup' style='display: none;'>" + insegnamenti + "</textarea>");
    	regCommento.append("<textarea maxlength=\"500\" placeholder='Facoltativo' class='newCommento form-control'>" + commento + "</textarea>");
    	regCommento.append("<textarea class='commentoBackup' style='display: none;'>" + commento + "</textarea>");
    	regtr.find("td.regOpt").empty();
    	regtr.find("td.regOpt").append('<button class="descSave btn btn-success buttonfix btn-sm margin"><span class="glyphicon glyphicon-save"></span></button> <button class="descDiscard btn btn-danger buttonfix btn-sm margin"><span class="glyphicon glyphicon-remove"></span></button>');
    	regtr.find(".descDiscard").click(DescDiscard);
    	regtr.find(".descSave").click(DescSave);
    }

    function DescDiscard(event){
    	var regtr = $(event.target).closest("tr");
    	var lavoro = regtr.find(".lavoroBackup").val();
    	var insegnamenti = regtr.find(".insegnamentiBackup").val();
    	var commento = regtr.find(".commentoBackup").val();
    	var date = regtr.find(".regDate").data ("oldDate");
    	regtr.find("td.regDate").empty().html(date);
    	regtr.find("td.regLavoro").empty();
    	regtr.find("td.regLavoro").append(lavoro);
    	regtr.find("td.regInsegnamenti").empty();
    	regtr.find("td.regInsegnamenti").append(insegnamenti);
    	regtr.find("td.regCommento").empty();
    	regtr.find("td.regCommento").append(commento);
    	regtr.find("td.regOpt").empty();
    	regtr.find("td.regOpt").append("<button class='regEdit btn btn-warning buttonfix btn-sm margin'><span class='glyphicon glyphicon-edit'></span></button> ");
    	regtr.find(".regEdit").click(DescEdit);
    	regtr.find("td.regOpt").append("<button class='regDelete btn btn-danger buttonfix btn-sm margin'><span class='glyphicon glyphicon-trash'></span></button>");
    	regtr.find(".regDelete").click(DescDelete);
    }

    function DescInit(){
    	$("#DescMain").empty();
    	$("#DescMain").append("Loading...");
    	var content = $("<div class='table-responsive'><table id='DescTable' class='table table-bordered'><thead><tr></tr></thead><tbody></tbody></table></div>");
    	content.find("thead tr").append("<td class='text-center col col-sm-2'>Data</td>");
    	content.find("thead tr").append("<td class='text-center col col-sm-3'>Lavoro svolto</td>");
    	content.find("thead tr").append("<td class='text-center col col-sm-3'>Insegnamenti</td>");
    	content.find("thead tr").append("<td class='text-center col col-sm-2'>Commento</td>");
    	content.find("thead tr").append("<td class='text-center col col-sm-2'>Opzioni</td>");
        var idstudHasStage= shs;
    	data = {
            "idStudenteHasStage":idstudHasStage
    	}
    	$.ajax({
    		url: "ajaxOps/aggiorna_registro.php", //Pagina a quale invio la richiesta
    		type: "POST", //Metodologia di invio di dati
    		dataType: "xml", //Tipologia di dati restituiti
    		data: data, //Dati inviati
    		
    		error: function (request, error) { //riprovo dopo due secondi
    			setTimeout(DescInit,2000)
    		},

    		success: function(xml){
    			$(xml).find("line").each(function(index, element){
    				var lavoro = $(element).find("lavoro").text();
    				var insegnamenti = $(element).find("insegnamenti").text();
    				var commento = $(element).find("commento").text();
    				
    				content.find("tbody").append("<tr></tr>");
    				line = content.find("tbody tr:last");
    				line.append("<td class='regDate'>"+ $(element).find("date").text() +"</td>");
    				line.append("<td class='regLavoro'>"+lavoro+"</td>");
    				line.append("<td class='regInsegnamenti'>"+insegnamenti+"</td>");
    				line.append("<td class='regCommento'>"+commento+"</td>");
    				line.append("<td class='regOpt pull-content-bottom text-center'><button class='regEdit btn btn-warning buttonfix btn-sm margin'><span class='glyphicon glyphicon-edit'></span></button> <button class='regDelete btn btn-danger buttonfix btn-sm margin'><span class='glyphicon glyphicon-trash'></span></button></td>")
    				line.append("<input type='hidden' class='descId' value='" +  $(element).find("id").text() + "' />")
    			})
    			$("#DescMain").empty();
    			$("#DescMain").append(content)
    			$("#DescMain").append("<button id='DescAddButton' class='btn btn-info'><span class='glyphicon glyphicon-plus'></span> Aggiungi</button>")
    			$("input").unbind()
    			
    			$(".regEdit").click(DescEdit)
    			$("#DescAddButton").click(DescAdd)
    			$(".regDelete").click(DescDelete)
    		}
    	});
    }

    function DescDelete(event){
    	var regtr = $(event.target).closest("tr")
    	var descId = regtr.find(".descId").val()
    	if(window.confirm("Confermi di voler eliminare la descrizione?")){
    		data = {
    			"sid": descId
    		}
    		$.ajax({
    			url: "ajaxOps/cancella_lavoro.php", //Pagina a quale invio la richiesta
    			type: "POST", //Metodologia di invio di dati
    			data: data, //Dati inviati
    	
    	
    			error: function(){ //in caso di errore attende 2 secondi
    				printError ("Errore", "Problema nell'invio della richiesta.");
    			},
    	
    			success: function(msg){ //inserisco il risultato (contenuto nel tag xml result) dentro #response
    				
    			}
    			
    		});
    	}
    	DescInit()
    }

    function DescSave(event){
        
    	var regtr = $(event.target).closest("tr");
    	var lavorotd = regtr.find("td.regLavoro");
    	var lavoro = lavorotd.find(".newLavoro").val();
    	var insegnamentitd = regtr.find("td.regInsegnamenti");
    	var insegnamenti = insegnamentitd.find(".newInsegnamenti").val();
    	var commentotd = regtr.find("td.regCommento");
    	var commento = commentotd.find(".newCommento").val();
    	if (checkDateItalianFormat (regtr.find(".regDate").find (".datepicker").val ())) {
	    	var date = regtr.find(".regDate").find (".datepicker").datepicker("getDate");
			if (!isEmpty(date) && !isEmpty(lavoro) && !isEmpty(insegnamenti))
		    {
		    	if (date >= inizio_stage && date <=fine_stage){
			    	data = {
			    		"lavoro": lavoro,
			    		"insegnamenti": insegnamenti,
			    		"commento": commento,
			    		"id": regtr.find(".descId").val(),
						"day": date.getDate(),
						"month": date.getMonth() + 1,
						"year": date.getFullYear(),
			    	}
			    	$.ajax({
			    		url: "ajaxOps/aggiorna_lavoro.php", //Pagina a quale invio la richiesta
			    		type: "POST", //Metodologia di invio di dati
			    		dataType: "xml", //Tipologia di dati restituiti
			    		data: data, //Dati inviati
			
			
			    		error: function(){
			    			printError ("Errore", "Problema nell'invio della richiesta.");
			    		},
			
			    		success: function(xml){ //inserisco il risultato (contenuto nel tag xml result) dentro #response
			    			if($(xml).find("status").text() == 0){
			    				regtr.find("td.regLavoro").empty();
			    				regtr.find("td.regLavoro").append(lavoro);
			    				regtr.find("td.regInsegnamenti").empty();
			    				regtr.find("td.regInsegnamenti").append(insegnamenti);
			    				regtr.find("td.regCommento").empty();
			    				regtr.find("td.regCommento").append(commento);
			    				regtr.find("td.regOpt").empty();
			    		    	regtr.find("td.regOpt").append("<button class='regEdit btn btn-warning buttonfix btn-sm margin'><span class='glyphicon glyphicon-edit'></span></button> ");
			    		    	regtr.find(".regEdit").click(DescEdit);
			    		    	regtr.find("td.regOpt").append("<button class='regDelete btn btn-danger buttonfix btn-sm margin'><span class='glyphicon glyphicon-trash'></span></button>");
			    		    	regtr.find(".regDelete").click(DescDelete);
			    				DescInit()
			    			}
			    			else{
			    				printError("Errore", "Errore durante l'invio, prego riprovare.");
			    			}
			    		}
			    	});
		    	}
		    	else {
		    		printError ("Errore", "Impossibile inviare il lavoro giornaliero.<br>La data specificata non rientra nel periodo di stage. Riprovare con una data corretta.");
		    	}
		    }
			else {
				printError ("Errore", "Impossibile inviare il lavoro giornaliero.<br>Uno o più campi obbligatori sono vuoti.");
			}
    	}
    	else {
    		printError ("Errore", "Il formato della data inserito non è corretto.");
    	}
    }
    
    function DescAdd(){
        
    	$("#DescTable tbody").append("<tr id='DescAddTR'></tr>");
    	
    	////init tr e  td
    	$("#DescAddTR").append("<td><input placeholder=\"gg-mm-aaaa\" class='form-control datepicker' id='DescAddDate' /></td>");
    	$("#DescAddTR").append("<td><textarea maxlength=\"500\" id='lavoroAdd' class='form-control' rows='7'></textarea></td>");
    	$("#DescAddTR").append("<td><textarea maxlength=\"500\" id='insegnamentiAdd' class='form-control' rows='7'></textarea></td>");
    	$("#DescAddTR").append("<td><textarea maxlength=\"500\" id='commentoAdd' class='form-control' rows='7' placeholder='Facoltativo'></textarea></td>");
    	$("#DescAddTR").append("<td class='pull-content-bottom text-center'><button id='DescAddSave' class='btn btn-success buttonfix btn-sm margin'><span class='glyphicon glyphicon-save'></span></button> <button id='DescAddDelete' class='btn btn-danger buttonfix btn-sm margin'><span class='glyphicon glyphicon-trash'></span></button></td>");
    	
    	//init componente
    	//init 
    	$(".datepicker").datepicker({ 
    		dateFormat: 'dd-mm-yy', 
    		minDate: inizio_stage,
    		maxDate: fine_stage
		});
    	$("#DescAddButton").attr("disabled", true);
    	
    	//add events (save and delete)
    	$("#DescAddSave").click(function(){
    		var data = $("#DescAddDate").datepicker( "getDate" );
    		var lavoro = $("#lavoroAdd").val();
    		var insegnamenti = $("#insegnamentiAdd").val();
    		var commento = $("#commentoAdd").val();
        	if (checkDateItalianFormat ($("#DescAddDate").val ())) {
	    		if (!isEmpty(data) && !isEmpty(lavoro) && !isEmpty(insegnamenti))
	    	    {
		        	if (data >= inizio_stage && data <=fine_stage) {
		    			data = {
		    				"sid": shs,
		    				"day": data.getDate(),
		    				"month":  data.getMonth() + 1,
		    				"year":  data.getFullYear(),
		    				"lavoro": lavoro,
		    				"insegnamenti" : insegnamenti,
		    				"commento" : commento
		    			}
			    	
			    		$.ajax({
			    			url: "ajaxOps/aggiungi_lavoro.php", //Pagina a quale invio la richiesta
			    			type: "POST", //Metodologia di invio di dati
			    			dataType: "xml", //Tipologia di dati restituiti
			    			data: data, //Dati inviati
			    	
			    	
			    			error: function () {
			    				  printError ("Errore", "Problema nell'invio della richiesta.");
			    			},
			    	
			    			success: function(xml){ //inserisco il risultato (contenuto nel tag xml result) dentro #response
			    				if($(xml).find("status").text() == 0){
			    					$("#DescAddTR").remove();
			    					DescInit();
			    				}
			    				else{
			    					printErorr ("Errore", "Salvataggio della relazione non riuscita.");
			    				}
			    			}
			    			
			    		});
		        	}
		        	else {
		        		printError ("Errore", "Impossibile inviare il lavoro giornaliero.<br>La data specificata non rientra nel periodo di stage. Riprovare con una data corretta.");
		        	}
	    	    }
	    		else {
	    			printError ("Errore", "Impossibile inviare il lavoro giornaliero.<br>Uno o più campi obbligatori sono vuoti.");
	    		}
        	}
        	else {
        		printError ("Errore", "Il formato della data inserito non è corretto.");
        	}
    	});
        $("#DescAddDelete").click(function() {
    		$("#DescAddTR").remove();
    		$("#DescAddButton").attr("disabled", false);
    	});
    }
    $(".regEdit").click(DescEdit);
	$("#DescAddButton").click(DescAdd);
	$(".regDelete").click(DescDelete);
});

function grantOrRevokeRegisterPermisson(privilege, idStudenteHasStage)
{
    $.ajax({
        type : 'POST',
        url : 'ajaxOps/aggiorna_autorizzazione.php',
        cache : false,
        data : {'permesso' : privilege,
        		'studente' : idStudenteHasStage
        },
        success : function (msg)
        {
            if (msg === "ok")
                location.reload();
        }
    });
}