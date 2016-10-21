    lavoro = {
        'id' : '',
        'data' : '',
        'descrizione' : ''
    }

function openEdit(progressiv)
{
    var data = $("#data"+progressiv).html().trim();
    var descrizione = $("#descrizione"+progressiv).html().trim();
    $("riga"+progressiv).css("background","yellow")
    $("#modifica"+progressiv).val('Conferma');
    $("#modifica"+progressiv).attr("id","conferma"+progressiv);
    $("#conferma"+progressiv).attr("onclick","sendData("+progressiv+",this.name)")
    $("#conferma"+progressiv).removeClass("btn-info");
    $("#conferma"+progressiv).addClass("btn-success");
    $("#data"+progressiv).html("<input class=\"form-control\" style=\"padding:5px\" type=\"text\" id=\"textboxdata"+progressiv+"\" value=\""+data+"\">");
    $("#descrizione"+progressiv).html("<textarea id=\"textareadescrizione"+progressiv+"\" style=\"resize:vertical\"  class = \"form-control\" type=\"text\">"+descrizione+"</textarea>");
    $("#textboxdata"+progressiv).datepicker({ dateFormat : 'yy-mm-dd' });
    $("#textboxdata"+progressiv).hide(); $("#textboxdata"+progressiv).hide().fadeIn("slow");
    $("#textareadescrizione"+progressiv).hide(); $("#textareadescrizione"+progressiv).hide().fadeIn("slow");
    $("#elimina"+progressiv).val("Chiudi");
    $("#elimina"+progressiv).attr("id","annulla"+progressiv);
    $("#annulla"+progressiv).attr("onclick","closeEdit("+progressiv+")");
    setOnChangeEvents(progressiv);
}

function closeEdit(progressiv)
{
        var data = $("#textboxdata"+progressiv).val();
        var descrizione = $("#textareadescrizione"+progressiv).val();
        $("#textboxdata"+progressiv).remove();
        $("#textareadescrizione"+progressiv).remove();
        $("#data"+progressiv).html(data)
        $("#descrizione"+progressiv).html(descrizione)
        $("#conferma"+progressiv).attr("id","modifica"+progressiv);
        $("#annulla"+progressiv).attr("id","elimina"+progressiv);
        $("#modifica"+progressiv).val("Modifica")
        $("#elimina"+progressiv).val("Cancella")
        $("#modifica"+progressiv).removeClass("btn-success");
        $("#modifica"+progressiv).addClass("btn-info");
        $("#modifica"+progressiv).attr("onclick","openEdit("+progressiv+")")
        $("#elimina"+progressiv).attr("onclick","deleteDescrizione("+progressiv+"),this.name");
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
    
    lavoro.id = idDescrizione;
    lavoro.data = ''+$("#textboxdata"+progressiv).val() ;
    lavoro.descrizione = ''+$("#textareadescrizione"+progressiv).val();
  
    if (!lavoro.data.isEmpty() && !lavoro.descrizione.isEmpty())
    {
        $.ajax({
            type : 'POST',
            url : '../registro/ajaxOpsPerRegistro/ajaxInvia.php',
            data : lavoro,
            cache : false,
            success : function (msg)
            {
                if (msg === "ok")
                    resetColors(progressiv);
                    closeEdit (progressiv);
            },
            error : function ()
            {
                alert("errore")
            }
        });
    }
}

function setOnChangeEvents(progressiv)
{
    $("#textareadescrizione"+progressiv).on('input',function() {
        $("#textareadescrizione"+progressiv).css("color","red");
    });
    
    $("#textboxdata"+progressiv).on('input',function() {
        $("#textboxdata"+progressiv).css("color","red");
    });
}

function resetColors(progressiv)
{
    $("#textareadescrizione"+progressiv).css("color","#555");
    $("#textboxdata"+progressiv).css("color","#555");
}

function appendAddingBox()
{
    var progressiv = parseInt($("#contatoreaggiungi").val());
    $("#DescTable").append("<tr> <td> <input type=\"text\" id=\"aggiungidata"+progressiv+"\" class=\"form-control\" style=\"padding:5px\"> </td> <td> <textarea style=\"resize:vertical\"  class=\"form-control\" id=\"aggiungidescrizione"+progressiv+"\"></textarea> </td> <td id=\"gobuttons"+progressiv+"\"> <div align=\"center\"> <button style=\"height:30px\" class=\"btn btn-danger btn-sm margin buttonfix\" onclick=\"closeAddingBox("+progressiv+")\" id=\"canceladding"+progressiv+"\"> <span class=\"glyphicon glyphicon-remove\"> </span> </button> <button id=\"confirmadding"+progressiv+"\" class=\"btn btn-success btn-sm margin buttonfix\"  onclick=\"insertActivity("+progressiv+") \"> <span class=\"glyphicon glyphicon-ok\"> </span> </button> </div> </td> </tr>");
    $("#gobuttons"+progressiv+"").hide(); $("#gobuttons"+progressiv+"").fadeIn("slow");
    $("#aggiungidescrizione"+progressiv+"").hide(); $("#aggiungidescrizione"+progressiv+"").fadeIn("slow");
    $("#aggiungidata"+progressiv+"").hide(); $("#aggiungidata"+progressiv+"").fadeIn("slow");
    $("#contatoreaggiungi").val(progressiv+1);
    $("#confirmadding"+progressiv+"").attr("onclick","insertActivity("+progressiv+")");
    $("#aggiungidata"+progressiv+"").datepicker({ dateFormat : 'yy-mm-dd' })
}

function insertActivity(progressiv)
{
    String.prototype.isEmpty = function() {
        return (this.length === 0 || !this.trim());
    }; 
    
    var data = ''+$("#aggiungidata"+progressiv+"").val();
    var descrizione = ''+$("#aggiungidescrizione"+progressiv+"").val();
    
    lavorodainserire = {
        'data' : data,
        'descrizione' : descrizione
    }
    
    if (!lavorodainserire.data.isEmpty() && !lavorodainserire.descrizione.isEmpty())
    {
        $.ajax({
           type : 'POST',
           url : '../registro/ajaxOpsPerRegistro/ajaxInserisci.php',
           cache : false,
           data : lavorodainserire,
           success : function (maxid)
           {
               convertToInsertedData(progressiv, maxid);
           }
        });
    }
}

function closeAddingBox(progressiv)
{
    $("#aggiungidata"+progressiv+"").closest("tr").remove();
}

function convertToInsertedData(progressiv, maxid)
{
    var generalprogressiv = parseInt($("#edit").attr("name"));
    $("#aggiungidata"+progressiv+"").closest("tr").attr("id","riga"+(generalprogressiv + 1));
    
    var data = $("#aggiungidata"+progressiv+"").val();
    $("#aggiungidata"+progressiv+"").closest("td").attr("id","data"+(generalprogressiv + 1));
    $("#aggiungidata"+progressiv+"").closest("td").html(data)
    
    var descrizione = $("#aggiungidescrizione"+progressiv+"").val();
    $("#aggiungidescrizione"+progressiv+"").closest("td").attr("id","descrizione"+(generalprogressiv + 1));
    $("#aggiungidescrizione"+progressiv+"").closest("td").html(descrizione);
    
    $("#gobuttons"+progressiv).html("<div align=\"center\"><input type=\"button\" class=\"btn btn-info\" id=\"modifica"+(generalprogressiv + 1)+"\" name=\""+maxid+"\" value=\"Modifica\" onclick = \"openEdit("+(generalprogressiv + 1)+")\"> <input type=\"button\" class=\"btn btn-danger\" id=\"elimina"+(generalprogressiv + 1)+"\" name=\""+maxid+"\" value=\"Cancella\" onclick = \"deleteDescrizione("+(generalprogressiv + 1)+", this.name)\"></div>");
    $("#edit").attr("name",(generalprogressiv+1));
    
    $("#riga"+(generalprogressiv + 1)).hide();
    $("#riga"+(generalprogressiv + 1)).fadeIn("slow");
}