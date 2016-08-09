valutazione = {
    'gestione_ambiente_spazio_lavoro':'',
    'collaborazione_comunicazione':'',
    'uso_strumenti':'',
    'complessita_compito_atteggiamento':'',
    'valutazione_gestione_sicurezza':'',
    'competenze_linguistiche':'',
    'conoscenza_coerenza_approfondimento':'',
    'efficacia_esposizone':'',
    'qualita_processo':'',
    'efficacia_prodotto':'',
    'id_studente':''
};

function getUrlVars() {
	var vars = {};
	var parts = window.location.href.replace(/[?&]+([^=&]+)=([^&]*)/gi, function(m,key,value) {
	vars[key] = value;
	});
	return vars;
}

function insertGrades()
{
    valutazione.gestione_ambiente_spazio_lavoro = $("[name='gestione_ambiente_spazio_lavoro']").val();
    valutazione.collaborazione_comunicazione = $("[name='collaborazione_comunicazione']").val();
    valutazione.uso_strumenti = $("[name='uso_strumenti']").val();
    valutazione.complessita_compito_atteggiamento = $("[name='complessita_compito_atteggiamento']").val();
    valutazione.valutazione_gestione_sicurezza = $("[name='rispetto_ambiente']").val();
    valutazione.competenze_linguistiche = $("[name='competenze_linguistiche']").val();
    valutazione.conoscenza_coerenza_approfondimento = $("[name='conoscenza_coerenza_approfondimento']").val();
    valutazione.efficacia_esposizone = $("[name='efficacia_esposizone']").val();
    valutazione.qualita_processo = $("[name='qualita_processo']").val();
    valutazione.efficacia_prodotto = $("[name='efficacia_prodotto']").val();
    valutazione.id_studente = $("[name='id_studente']").val();
    
    $.ajax({
        type : 'POST',
        url : 'ajaxOps/ajaxInsertGrade.php',
        data : valutazione,
        cache : false,
        success : function (msg)
        {
            if (msg === "ok")
                alert("Valutazione inserita con successo !")
            else
                alert(msg)
        }
    });
    
}

function updateGrades()
{   
    valutazione.gestione_ambiente_spazio_lavoro = $("[name='gestione_ambiente_spazio_lavoro']").val();
    valutazione.collaborazione_comunicazione = $("[name='collaborazione_comunicazione']").val();
    valutazione.uso_strumenti = $("[name='uso_strumenti']").val();
    valutazione.complessita_compito_atteggiamento = $("[name='complessita_compito_atteggiamento']").val();
    valutazione.valutazione_gestione_sicurezza = $("[name='rispetto_ambiente']").val();
    valutazione.competenze_linguistiche = $("[name='competenze_linguistiche']").val();
    valutazione.conoscenza_coerenza_approfondimento = $("[name='conoscenza_coerenza_approfondimento']").val();
    valutazione.efficacia_esposizone = $("[name='efficacia_esposizone']").val();
    valutazione.qualita_processo = $("[name='qualita_processo']").val();
    valutazione.efficacia_prodotto = $("[name='efficacia_prodotto']").val();
    valutazione.id_studente = $("[name='id_studente']").val();
    
    $.ajax({
       type : 'POST',
       url : 'aggiornamento_valutazione.php',
       data : valutazione,
       cache : false,
       success : function (msg)
       {
           if (msg === "ok")
               alert("Valutazione aggiornata con successo !")
           else
               alert(msg)
       },
       error : function()
       {
           alert("errore");
       }
    });
}

$(document).ready(function() {  
    $("#conferma_scelta").click(function(){  
       // var id = 
        var nuova_scelta=$("#scelta").val();
        if (nuova_scelta == '1'){
            $.ajax({
                type: 'POST',
                url : "visita_ajax.php",
                data: {
                    'id':id
                }
            });
        }
    });    
    function DescEdit(event){
    	var regtr = $(event.target).closest("tr")
    	var desc = regtr.find(".regDesc").html()
    	var regDesc = regtr.find(".regDesc")
    	regDesc.empty()
    	regDesc.append("<textarea class='newDesc'>" + desc + "</textarea>")
    	regDesc.find("textarea").jqte()
    	regDesc.append("<textarea class='descBackup' style='display: none;'>" + desc + "</textarea>")
    	regtr.find("td.regOpt").empty()
    	regtr.find("td.regOpt").append('<button class="descSave">Salva</button><button class="descDiscard">Annulla</button>')
    	regtr.find(".descDiscard").click(DescDiscard)
    	regtr.find(".descSave").click(DescSave)
    }

    function DescDiscard(event){
    	var regtr = $(event.target).closest("tr")
    	var desc = regtr.find(".descBackup").val()
    	regtr.find("td.regDesc").empty()
    	regtr.find("td.regDesc").append(desc)
    	regtr.find("td.regOpt").empty()
    	regtr.find("td.regOpt").append("<button class='regEdit'>Modifica</button>")
    	regtr.find(".regEdit").click(DescEdit)
    	regtr.find("td.regOpt").append("<button class='regDelete'>Elimina</button>")
    	regtr.find(".regDelete").click(DescDelete)
    }

    function DescInit(){
    	$("#DescMain").empty();
    	$("#DescMain").append("Loading...")
    	var content = $("<table id='DescTable' class='table table-striped table-bordered'><thead><tr></tr></thead><tbody></tbody></table>");
    	content.find("thead tr").append("<td>Data</td>")
    	content.find("thead tr").append("<td>Descrizione delle attivit&agrave lavorative</td>")
    	content.find("thead tr").append("<td>Opzioni</td>")
        var idstud= getUrlVars()["id_studente"]
    	data = {
            "idstud":idstud
    	}
    	$.ajax({
    		url: "ajaxOps/ajaxOp0.php", //Pagina a quale invio la richiesta
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
    				line.append("<td>"+ $(element).find("date").text() +"</td>")
    				line.append("<td class='regDesc'></td>")
    				line.find("td.regDesc").append(desc)
    				line.append("<td class='regOpt'><button class='regEdit'>Modifica</button><button class='regDelete'>Elimina</button></td>")
    				line.append("<input type='hidden' class='descId' value='" +  $(element).find("id").text() + "' />")
    			})
    			$("#DescMain").empty();
    			$("#DescMain").append(content)
    			$("#DescMain").append("<button id='DescAddButton'>Aggiungi</button>")
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
    			url: "ajaxOps/ajaxOp2.php", //Pagina a quale invio la richiesta
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
        
    	var regtr = $(event.target).closest("tr")
    	var desctd = regtr.find("td.regDesc")
    	var nd = desctd.find(".newDesc").val()
    	data = {
    		"newdesc": nd,
    		"id": regtr.find(".descId").val()
    	}
    	$.ajax({
    		url: "ajaxOps/ajaxOp1.php", //Pagina a quale invio la richiesta
    		type: "POST", //Metodologia di invio di dati
    		dataType: "xml", //Tipologia di dati restituiti
    		data: data, //Dati inviati


    		error: function(){ //in caso di errore attende 2 secondi
    			alert("Invio dei dati non riuscito")
    		},

    		success: function(xml){ //inserisco il risultato (contenuto nel tag xml result) dentro #response
    			if($(xml).find("status").text() == 0){
    				regtr.find("td.regDesc").empty()
    				regtr.find("td.regDesc").append(nd)
    				regtr.find("td.regOpt").empty()
    				regtr.find("td.regOpt").append("<button class='regEdit'>Modifica</button>")
    				//regtr.find(".regEdit").click(DescEdit)
    				regtr.find("td.regOpt").append("<button class='regDelete'>Elimina</button>")
    				//regtr.find(".regDelete").click(DescDelete)
    				DescInit()
    			}
    			else{
    				alert("Errore durante l'invio, prego riprovare")
    			}
    		}
    	});
    }
    
    function DescAdd(){
        
    	$("#DescTable tbody").append("<tr id='DescAddTR'></tr>");
    	
    	////init tr e  td
    	$("#DescAddTR").append("<td><input class='datepicker' id='DescAddDate' /></td>");
    	$("#DescAddTR").append("<td><textarea id='DescAddDesc' /></td>");
    	$("#DescAddTR").append("<td><button id='DescAddSave'>Salva</button><button id='DescAddDelete'>Elimina</button></td>");
    	
    	////init componente
    	//init 
    	$(".datepicker").datepicker();
    	$("#DescAddDesc").jqte();
    	$("#DescAddButton").attr("disabled", true);
    	
    	//add events (save and delete)
    	$("#DescAddSave").click(function(){
    		try{
    			data = {
    				"sid": getUrlVars()["id_studente"],
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
    			url: "ajaxOps/ajaxOp3.php", //Pagina a quale invio la richiesta
    			type: "POST", //Metodologia di invio di dati
    			dataType: "xml", //Tipologia di dati restituiti
    			data: data, //Dati inviati
    	
    	
    			error: function(){ //in caso di errore attende 2 secondi
    				alert("Salvataggio della relazione non riuscito")
    			},
    	
    			success: function(xml){ //inserisco il risultato (contenuto nel tag xml result) dentro #response
    				if($(xml).find("status").text() == 0){
    					$("#DescAddTR").remove()
    					alert("Relazione salvata con successo")
    					DescInit()
    				}
    				else{
    					alert("Salvataggio della relazione non riuscita")
    				}
    			}
    			
    		});

    	})
    }
    
    $("#DescAddDelete").click(function(){
		$("#DescAddTR").remove();
		$("#DescAddButton").attr("disabled", false);
	})
    
    $(".regEdit").click(DescEdit)
	$("#DescAddButton").click(DescAdd)
	$(".regDelete").click(DescDelete)
});

function grantOrRevokeRegisterPermisson(privilege, idStudente)
{
    $.ajax({
        type : 'POST',
        url : 'ajaxOps/ajaxAutorizzazione.php',
        cache : false,
        data : { 'permesso' : privilege, 'studente' : idStudente },
        success : function (msg)
        {
            if (msg === "ok")
                location.reload();
        }
    });
}