$(document).ready(function() {
    function DescEdit(event){
    	var regtr = $(event.target).closest("tr");
    	var regDesc = regtr.find(".regDesc");
    	var desc = regDesc.html();
    	var regDate = regtr.find(".regDate");
    	var date = regDate.html();
    	var dateSplitted = date.split("-");
    	var year = dateSplitted [2];
    	var month = parseInt (dateSplitted [1]) - 1;
    	var day = dateSplitted [0];
    	regDate.empty ();
    	regDesc.empty();
    	regDate.append ("<input class='datepicker'/>");
    	regDate.find (".datepicker").datepicker({ 
    		dateFormat: 'dd-mm-yy', 
    		minDate: inizio_stage,
    		maxDate: fine_stage
		});
    	regDate.find (".datepicker").datepicker("setDate", new Date(year,month,day));
    	regDate.data ("oldDate", date);
    	regDesc.append("<textarea class='newDesc'>" + desc + "</textarea>");
    	regDesc.find("textarea").jqte();
    	regDesc.append("<textarea class='descBackup' style='display: none;'>" + desc + "</textarea>");
    	regtr.find("td.regOpt").empty();
    	regtr.find("td.regOpt").append('<button class="descSave btn btn-primary">Salva</button> <button class="descDiscard btn btn-primary">Annulla</button>');
    	regtr.find(".descDiscard").click(DescDiscard);
    	regtr.find(".descSave").click(DescSave);
    }

    function DescDiscard(event){
    	var regtr = $(event.target).closest("tr");
    	var desc = regtr.find(".descBackup").val();
    	var date = regtr.find(".regDate").data ("oldDate");
    	regtr.find("td.regDate").empty().html(date);
    	regtr.find("td.regDesc").empty();
    	regtr.find("td.regDesc").append(desc);
    	regtr.find("td.regOpt").empty();
    	regtr.find("td.regOpt").append("<button class='regEdit btn btn-primary'>Modifica</button> ");
    	regtr.find(".regEdit").click(DescEdit);
    	regtr.find("td.regOpt").append("<button class='regDelete btn btn-primary'>Elimina</button>");
    	regtr.find(".regDelete").click(DescDelete);
    }

    function DescInit(){
    	$("#DescMain").empty();
    	$("#DescMain").append("Loading...");
    	var content = $("<div class='table-responsive'><table id='DescTable' class='table table-striped table-bordered'><thead><tr></tr></thead><tbody></tbody></table></div>");
    	content.find("thead tr").append("<td>Data</td>");
    	content.find("thead tr").append("<td>Descrizione delle attivit&agrave lavorative</td>");
    	content.find("thead tr").append("<td>Opzioni</td>");
        var idstudHasStage= shs;
    	data = {
            "idStudenteHasStage":idstudHasStage
    	}
    	$.ajax({
    		url: "ajaxOps/aggiorna_registro.php", //Pagina a quale invio la richiesta
    		type: "POST", //Metodologia di invio di dati
    		dataType: "xml", //Tipologia di dati restituiti
    		data: data, //Dati inviati
    		
    		error: function(){ //in caso di errore attende 2 secondi
    			setTimeout(DescInit,2000)
    		},

    		success: function(xml){
    			$(xml).find("line").each(function(index, element){
    				desc = $(element).find("desc").text();
    				
    				content.find("tbody").append("<tr></tr>")
    				line = content.find("tbody tr:last")
    				line.append("<td class='regDate'>"+ $(element).find("date").text() +"</td>")
    				line.append("<td class='regDesc'></td>")
    				line.find("td.regDesc").append(desc)
    				line.append("<td class='regOpt'><button class='regEdit btn btn-primary'>Modifica</button> <button class='regDelete btn btn-primary'>Elimina</button></td>")
    				line.append("<input type='hidden' class='descId' value='" +  $(element).find("id").text() + "' />")
    			})
    			$("#DescMain").empty();
    			$("#DescMain").append(content)
    			$("#DescMain").append("<button id='DescAddButton' class='btn btn-primary'>Aggiungi</button>")
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
    				alert("Eliminazione della descrizione non riuscita")
    			},
    	
    			success: function(msg){ //inserisco il risultato (contenuto nel tag xml result) dentro #response
    				
    			}
    			
    		});
    	}
    	DescInit()
    }

    function DescSave(event){
        
    	var regtr = $(event.target).closest("tr");
    	var desctd = regtr.find("td.regDesc");
    	var nd = desctd.find(".newDesc").val();
    	var date = regtr.find(".regDate").find (".datepicker").datepicker("getDate");
    	data = {
    		"newdesc": nd,
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


    		error: function(){ //in caso di errore attende 2 secondi
    			alert("Invio dei dati non riuscito")
    		},

    		success: function(xml){ //inserisco il risultato (contenuto nel tag xml result) dentro #response
    			if($(xml).find("status").text() == 0){
    				regtr.find("td.regDesc").empty();
    				regtr.find("td.regDesc").append(nd);
    				regtr.find("td.regOpt").empty();
    		    	regtr.find("td.regOpt").append("<button class='regEdit btn btn-primary'>Modifica</button> ");
    		    	regtr.find(".regEdit").click(DescEdit);
    		    	regtr.find("td.regOpt").append("<button class='regDelete btn btn-primary'>Elimina</button>");
    		    	regtr.find(".regDelete").click(DescDelete);
    				DescInit()
    			}
    			else{
    				alert("Errore durante l'invio, prego riprovare");
    			}
    		}
    	});
    }
    
    function DescAdd(){
        
    	$("#DescTable tbody").append("<tr id='DescAddTR'></tr>");
    	
    	////init tr e  td
    	$("#DescAddTR").append("<td><input class='datepicker' id='DescAddDate' /></td>");
    	$("#DescAddTR").append("<td><textarea id='DescAddDesc' /></td>");
    	$("#DescAddTR").append("<td><button id='DescAddSave' class='btn btn-primary'>Salva</button> <button id='DescAddDelete' class='btn btn-primary'>Annulla</button></td>");
    	
    	//init componente
    	//init 
    	$(".datepicker").datepicker({ 
    		dateFormat: 'dd-mm-yy', 
    		minDate: inizio_stage,
    		maxDate: fine_stage
		});
    	$("#DescAddDesc").jqte();
    	$("#DescAddButton").attr("disabled", true);
    	
    	//add events (save and delete)
    	$("#DescAddSave").click(function(){
    		try{
    			data = {
    				"sid": shs,
    				"day": $("#DescAddDate").datepicker( "getDate" ).getDate(),
    				"month":  $("#DescAddDate").datepicker( "getDate" ).getMonth() + 1,
    				"year":  $("#DescAddDate").datepicker( "getDate" ).getFullYear(),
    				"desc": $("#DescAddDesc").val()
    			}
    		}
    		catch(err){
    			var err_str = ""
    			
    			if($("#DescAddDate").val() == ""){
    				err_str += "La data non è valida\n"
    			}
    			alert(err_str)
    		}		
    	
    		$.ajax({
    			url: "ajaxOps/aggiungi_lavoro.php", //Pagina a quale invio la richiesta
    			type: "POST", //Metodologia di invio di dati
    			dataType: "xml", //Tipologia di dati restituiti
    			data: data, //Dati inviati
    	
    	
    			error: function(){ //in caso di errore attende 2 secondi
    				alert("Salvataggio della relazione non riuscito")
    			},
    	
    			success: function(xml){ //inserisco il risultato (contenuto nel tag xml result) dentro #response
    				if($(xml).find("status").text() == 0){
    					$("#DescAddTR").remove();
    					//alert("Relazione salvata con successo")
    					DescInit();
    				}
    				else{
    					alert("Salvataggio della relazione non riuscita");
    				}
    			}
    			
    		});

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