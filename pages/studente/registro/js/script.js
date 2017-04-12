var data = "";
var lavoro = "";
var insegnamenti = "";
var commento = "";

function openEdit(progressiv, idDescrizione)
{
    data = $("#data"+progressiv).html().trim();
    lavoro = $("#lavoroSvolto"+progressiv).html().trim();
    insegnamenti = $("#insegnamenti"+progressiv).html().trim();
    commento = $("#commento"+progressiv).html().trim();
    $("riga"+progressiv).css("background","yellow")
    $("#modifica"+progressiv).html("<span class='glyphicon glyphicon-save'></span>");
    $("#modifica"+progressiv).attr("id","conferma"+progressiv);
    $("#conferma"+progressiv).attr("onclick","sendData("+progressiv+", "+idDescrizione+")");
    $("#conferma"+progressiv).removeClass("btn-warning");
    $("#conferma"+progressiv).addClass("btn-success");
    $("#data"+progressiv).html("<input placeholder=\"gg-mm-aaaa\" class=\"form-control\" style=\"padding:5px\" type=\"text\" id=\"textboxdata"+progressiv+"\" value=\""+data+"\">");
    $("#data"+progressiv).data ("old", data);
    $("#lavoroSvolto"+progressiv).html("<textarea maxlength=\"500\" id=\"textareaLavoro"+progressiv+"\" style=\"resize:vertical\" rows=\"7\" class = \"form-control\" type=\"text\">"+lavoro+"</textarea>");
    $("#lavoroSvolto"+progressiv).data ("old", lavoro);
    $("#insegnamenti"+progressiv).html("<textarea maxlength=\"500\" id=\"textareaInsegnamenti"+progressiv+"\" style=\"resize:vertical\" rows=\"7\" class = \"form-control\" type=\"text\">"+insegnamenti+"</textarea>");
    $("#insegnamenti"+progressiv).data ("old", insegnamenti);
    $("#commento"+progressiv).html("<textarea maxlength=\"500\" id=\"textareaCommento"+progressiv+"\" style=\"resize:vertical\" rows=\"7\" class = \"form-control\" type=\"text\" placeholder=\"Facoltativo\">"+commento+"</textarea>");
    $("#commento"+progressiv).data("old", commento);
    $("#textboxdata"+progressiv).datepicker({ 
		dateFormat: 'dd-mm-yy', 
		minDate: inizio_stage,
		maxDate: fine_stage
	});
    $("#textboxdata"+progressiv).hide(); $("#textboxdata"+progressiv).hide().fadeIn("slow");
    $("#textareaLavoro"+progressiv).hide(); $("#textareaLavoro"+progressiv).hide().fadeIn("slow");
    $("#textareaInsegnamenti"+progressiv).hide(); $("#textareaInsegnamenti"+progressiv).hide().fadeIn("slow");
    $("#textareaCommento"+progressiv).hide(); $("#textareaCommento"+progressiv).hide().fadeIn("slow");
    $("#elimina"+progressiv).html("<span class='glyphicon glyphicon-remove'></span>");
    $("#elimina"+progressiv).attr("id","annulla"+progressiv);
    $("#annulla"+progressiv).attr("onclick","closeEdit("+progressiv+", "+idDescrizione+")");
    setOnChangeEvents(progressiv);
}

function closeEdit(progressiv, idDescrizione)
{
        $("#textboxdata"+progressiv).remove();
        $("#textareaLavoro"+progressiv).remove();
        $("#textareaInsegnamenti"+progressiv).remove();
        $("#textareaCommento"+progressiv).remove();
        $("#data"+progressiv).html($("#data"+progressiv).data("old"));
        $("#lavoroSvolto"+progressiv).html($("#lavoroSvolto"+progressiv).data("old"));
        $("#insegnamenti"+progressiv).html($("#insegnamenti"+progressiv).data("old"));
        $("#commento"+progressiv).html($("#commento"+progressiv).data("old"));
        $("#conferma"+progressiv).attr("id","modifica"+progressiv);
        $("#annulla"+progressiv).attr("id","elimina"+progressiv);
        $("#modifica"+progressiv).html("<span class='glyphicon glyphicon-edit'></span>");
        $("#elimina"+progressiv).html("<span class='glyphicon glyphicon-trash'></span>");
        $("#modifica"+progressiv).removeClass("btn-success");
        $("#modifica"+progressiv).addClass("btn-warning");
        $("#modifica"+progressiv).attr("onclick","openEdit("+progressiv+", "+idDescrizione+")");
        $("#elimina"+progressiv).attr("onclick","deleteDescrizione("+progressiv+", "+idDescrizione+")");
        data = "";
        lavoro = "";
        insegnamenti = "";
        commento = "";
}

function deleteDescrizione(progressiv, idDescrizione)
{
    var confirmed = confirm("Confermare l'eliminazione di questa attivita'?");
    
    if (confirmed)
    {
        $.ajax({
            type : 'POST',
            url : '../registro/ajaxOpsPerRegistro/ajaxElimina.php',
            cache : false,
            data : {'idlavoro' : idDescrizione },
            success : function (msg)
            {
                if (msg === "ok")
                    location.reload();
            }
        })
    }
}

function sendData(progressiv, idDescrizione)
{    
    String.prototype.isEmpty = function() {
        return (this.length === 0 || !this.trim());
    };
    
    lavoro = {
    	    'id' : idDescrizione,
    	    'data' : ''+$("#textboxdata"+progressiv).val(),
    	    'lavoro' : ''+$("#textareaLavoro"+progressiv).val(),
    	    'insegnamenti' : ''+$("#textareaInsegnamenti"+progressiv).val(),
    	    'commento' : ''+$("#textareaCommento"+progressiv).val()
	};

    if (checkDateItalianFormat (lavoro.data)) {
	    if (!lavoro.data.isEmpty() && !lavoro.lavoro.isEmpty() && !lavoro.insegnamenti.isEmpty())
	    {
	    	$("#data"+progressiv).data ("old", lavoro.data);
	        $("#lavoroSvolto"+progressiv).data ("old", lavoro.lavoro);
	        $("#insegnamenti"+progressiv).data ("old", lavoro.insegnamenti);
	        $("#commento"+progressiv).data("old", lavoro.commento);
	        
	    	date = lavoro.data.split ("-");
	    	date = new Date (date[2], parseInt (date[1]) - 1, date[0]); 
	    	if (date >= inizio_stage && date <=fine_stage) {
	    		lavoro.data = date;
		        $.ajax({
		            type : 'POST',
		            url : '../registro/ajaxOpsPerRegistro/ajaxInvia.php',
		            data : lavoro,
		            cache : false,
		            success : function (msg)
		            {
		                if (msg === "ok")
		                    resetColors(progressiv);
			                data = $("#textboxdata"+progressiv).val();
			                lavoro = $("#textareaLavoro"+progressiv).val();
			                insegnamenti = $("#textareaInsegnamenti"+progressiv).val();
			                commento = $("#textareaCommento"+progressiv).val();
		                    closeEdit (progressiv, idDescrizione);
		                    
		                    var riga_successiva = null;
		                    $("#DescTable tbody").find ("tr").each (function () {
		                    	var riga = this;
		                    	var data_riga=$(riga).find ("td[id^='data']").text();
		                    	data_riga = data_riga.split ("-");
		                    	data_riga = new Date (data_riga[2], parseInt (data_riga[1]) - 1, data_riga[0]);
		                    	if (data_riga > date) {
		                    		riga_successiva = riga;
		                    		return false;
		                    	}
		                    });
	                        var temp = $("#riga"+progressiv);
	                        $("#riga"+progressiv).remove();
		                    if (riga_successiva != null) {
		                        temp.insertBefore(riga_successiva);
		                    }
		                    else {
		                    	temp.insertAfter($("#DescTable tbody").find ("tr:last"));
		                    }
		                    $("#riga"+progressiv).hide();
		                	$("#riga"+progressiv).fadeIn("slow");
		            },
		            error : function ()
		            {
		                printError ("Errore", "Problema nell'invio della richiesta.");
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

function setOnChangeEvents(progressiv)
{
    $("#textareaLavoro"+progressiv).on('input',function() {
        $("#textareaLavoro"+progressiv).css("color","red");
    });
    
    $("#textareaInsegnamenti"+progressiv).on('input',function() {
        $("#textareaInsegnamenti"+progressiv).css("color","red");
    });
    
    $("#textareaCommento"+progressiv).on('input',function() {
        $("#textareaCommento"+progressiv).css("color","red");
    });
    
    $("#textboxdata"+progressiv).on('input',function() {
        $("#textboxdata"+progressiv).css("color","red");
    });
}

function resetColors(progressiv)
{
    $("#textareaLavoro"+progressiv).css("color","#555");
    $("#textareaInsegnamenti"+progressiv).css("color","#555");
    $("#textareaCommento"+progressiv).css("color","#555");
    $("#textboxdata"+progressiv).css("color","#555");
}

function appendAddingBox()
{
    var progressiv = parseInt($("#contatoreaggiungi").val());
    $("#DescTable").append("<tr> <td> <input placeholder=\"gg-mm-aaaa\" type=\"text\" id=\"aggiungidata"+progressiv+"\" class=\"form-control\" style=\"padding:5px\"> </td> <td> <textarea maxlength=\"500\" style=\"resize:vertical\" rows=\"7\" class=\"form-control\" id=\"aggiungiLavoro"+progressiv+"\"></textarea> </td> <td> <textarea maxlength=\"500\" style=\"resize:vertical\" rows=\"7\" class=\"form-control\" id=\"aggiungiInsegnamenti"+progressiv+"\"></textarea> </td> <td> <textarea maxlength=\"500\" style=\"resize:vertical\" rows=\"7\" class=\"form-control\" id=\"aggiungiCommento"+progressiv+"\" placeholder=\"Facoltativo\"></textarea> </td> <td class=\"pull-content-bottom\" id=\"gobuttons"+progressiv+"\"> <div align=\"center\"> <button id=\"confirmadding"+progressiv+"\" class=\"btn btn-success btn-sm margin buttonfix\"  onclick=\"insertActivity("+progressiv+") \"> <span class=\"glyphicon glyphicon-save\"> </span> </button> <button style=\"height:30px\" class=\"btn btn-danger btn-sm margin buttonfix\" onclick=\"closeAddingBox("+progressiv+")\" id=\"canceladding"+progressiv+"\"> <span class=\"glyphicon glyphicon-trash\"> </span> </button> </div> </td> </tr>");
    $("#gobuttons"+progressiv+"").hide(); $("#gobuttons"+progressiv+"").fadeIn("slow");
    $("#aggiungiLavoro"+progressiv+"").hide();
    $("#aggiungiLavoro"+progressiv+"").fadeIn("slow");
    $("#aggiungiInsegnamenti"+progressiv+"").hide();
    $("#aggiungiInsegnamenti"+progressiv+"").fadeIn("slow");
    $("#aggiungiCommento"+progressiv+"").hide();
    $("#aggiungiCommento"+progressiv+"").fadeIn("slow");
    $("#aggiungidata"+progressiv+"").hide();
    $("#aggiungidata"+progressiv+"").fadeIn("slow");
    $("#contatoreaggiungi").val(progressiv+1);
    $("#confirmadding"+progressiv+"").attr("onclick","insertActivity("+progressiv+")");
    $("#aggiungidata"+progressiv+"").datepicker({ 
		dateFormat: 'dd-mm-yy', 
		minDate: inizio_stage,
		maxDate: fine_stage
	});
}

function insertActivity(progressiv)
{
    String.prototype.isEmpty = function() {
        return (this.length === 0 || !this.trim());
    }; 
    
    var data = ''+$("#aggiungidata"+progressiv+"").val();
    var lavoroSvolto = ''+$("#aggiungiLavoro"+progressiv+"").val();
    var insegnamenti = ''+$("#aggiungiInsegnamenti"+progressiv+"").val();
    var commento = ''+$("#aggiungiCommento"+progressiv+"").val();
    
    lavorodainserire = {
        'data' : data,
        'lavoroSvolto' : lavoroSvolto,
        'insegnamenti' : insegnamenti,
        'commento' : commento
    }

    if (checkDateItalianFormat (lavorodainserire.data)) {
	    if (!lavorodainserire.data.isEmpty() && !lavorodainserire.lavoroSvolto.isEmpty() && !lavorodainserire.insegnamenti.isEmpty())
	    {
	    	date = data.split ("-");
	    	date = new Date (date[2], parseInt (date[1]) - 1, date[0]);
	    	if (date >= inizio_stage && date <=fine_stage) {
		        $.ajax({
		           type : 'POST',
		           url : '../registro/ajaxOpsPerRegistro/ajaxInserisci.php',
		           cache : false,
		           data : lavorodainserire,
		           success : function (maxid)
		           {
		               convertToInsertedData(progressiv, maxid, date);
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

function closeAddingBox(progressiv)
{
    $("#aggiungidata"+progressiv+"").closest("tr").remove();
}

function convertToInsertedData(progressiv, maxid, date_new_element)
{
    var generalprogressiv = parseInt($("#edit").attr("name"));
    $("#aggiungidata"+progressiv+"").closest("tr").attr("id","riga"+(generalprogressiv + 1));
    
    var data = $("#aggiungidata"+progressiv+"").val();
    $("#aggiungidata"+progressiv+"").closest("td").attr("id","data"+(generalprogressiv + 1));
    $("#aggiungidata"+progressiv+"").closest("td").html(data)
    
    var lavoro = $("#aggiungiLavoro"+progressiv+"").val();
    $("#aggiungiLavoro"+progressiv+"").closest("td").attr("id","lavoroSvolto"+(generalprogressiv + 1));
    $("#aggiungiLavoro"+progressiv+"").closest("td").html(lavoro);
    
    var insegnamenti = $("#aggiungiInsegnamenti"+progressiv+"").val();
    $("#aggiungiInsegnamenti"+progressiv+"").closest("td").attr("id","insegnamenti"+(generalprogressiv + 1));
    $("#aggiungiInsegnamenti"+progressiv+"").closest("td").html(insegnamenti);

    var commento = $("#aggiungiCommento"+progressiv+"").val();
    $("#aggiungiCommento"+progressiv+"").closest("td").attr("id","commento"+(generalprogressiv + 1));
    $("#aggiungiCommento"+progressiv+"").closest("td").html(commento);
    
    $("#gobuttons"+progressiv).html("<div align=\"center\" style=\"vertical-align: middle;\"><button class=\"btn btn-warning buttonfix btn-sm margin\" id=\"modifica"+(generalprogressiv + 1)+"\" onclick = \"openEdit("+(generalprogressiv + 1)+", "+maxid+")\"><span class=\"glyphicon glyphicon-edit\"></span></button> <button class=\"btn btn-danger buttonfix btn-sm margin\" id=\"elimina"+(generalprogressiv + 1)+"\" onclick = \"deleteDescrizione("+(generalprogressiv + 1)+", "+maxid+")\"><span class=\"glyphicon glyphicon-trash\"></span></button></div>");
    $("#gobuttons"+progressiv).removeAttr("style");
    $("#gobuttons"+progressiv).addClass("regEdit");
    $("#gobuttons"+progressiv).attr("id","");
    $("#edit").attr("name",(generalprogressiv+1));
    
    
    var riga_successiva = null;
    $("#DescTable tbody").find ("tr").each (function () {
    	var riga = this;
    	var data_riga=$(riga).find ("td[id^='data']").text();
    	data_riga = data_riga.split ("-");
    	data_riga = new Date (data_riga[2], parseInt (data_riga[1]) - 1, data_riga[0]);
    	if (data_riga > date_new_element) {
    		riga_successiva = riga;
    		return false;
    	}
    });
    if (riga_successiva != null) {
        var temp = $("#riga"+(generalprogressiv + 1));
        $("#riga"+(generalprogressiv + 1)).remove();
        temp.insertBefore(riga_successiva);
    }
    $("#riga"+(generalprogressiv + 1)).hide();
	$("#riga"+(generalprogressiv + 1)).fadeIn("slow");
}