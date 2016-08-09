preferenza = {
  'id' : '',
  'nome' : ''    
};

function openEdit(id, idPreferenza)
{
    id = id+'';
    var numberId = id.replace('VisibleBox','');
    //alert(numberId)
    
    $("#modifica"+numberId).prop("disabled",true);
    $("#elimina"+numberId).prop("disabled",true);
    $('#'+id).append("<div id=\"HiddenBox"+numberId+"\"> nome <input placeholder=\"Nome della preferenza\" class=\"form-control\" type=\"text\" id=\"nome"+numberId+"\"> <button class=\"btn btn-danger btn-sm rightAlignment margin buttonfix\" onclick=\"closeEdit("+numberId+")\"> <span class=\"glyphicon glyphicon-remove\"> </span> </button> <button class=\"btn btn-success btn-sm rightAlignment margin buttonfix\"  onclick=\" sendData("+idPreferenza+","+numberId+")\"> <span class=\"glyphicon glyphicon-ok\"> </span> </button> <br><br></div>");
    $("#HiddenBox"+numberId).hide();
//    $("#HiddenBox"+numberId).fadeIn("slow");    
    $.ajax(
        {
            type : 'POST',
            url : 'scripts/getData.php',
            data : { 'id' : idPreferenza},
            success : function (nome)
            {
                $("#nome"+numberId).attr('value',nome);
            }
        });
       
    
    $("#nome"+numberId).keypress(function (event){
        if (event.which === 13) sendData(idPreferenza, numberId);
    });
    
    $("#HiddenBox"+numberId).fadeIn("slow");
    $("#ButtonBox"+numberId).height($("#ButtonBox"+numberId).height() + $("#HiddenBox"+numberId).height());
//    $("#ButtonBox"+numberId).animate({
//        height : $("#ButtonBox"+numberId).height() + $("#HiddenBox"+numberId).height()
//    }, 500);
    setOnChangeEvents(numberId)
//    $("#ButtonBox"+numberId).height($("#ButtonBox"+numberId).height() + $("#HiddenBox"+numberId).height());
}

function sendData(idPreferenza, numberId)
{
    String.prototype.isEmpty = function() {
        return (this.length === 0 || !this.trim());
    };  
    
    preferenza.id = idPreferenza;
    preferenza.nome = $("#nome"+numberId+"").val();
    
    if (!preferenza.nome.isEmpty())
    {
        $.ajax({
           type : 'POST',
           url : 'scripts/ajaxInvia.php',
           data : preferenza,
           success : function (msg)
           {
               if (msg !== "errore")
               {
                   $("#label"+numberId).replaceWith("<label id=\"label"+numberId+"\"> "+preferenza.nome+" </label>");
                   resetColor(numberId)
               }
           }
        });
    }
    else
    {
        alert("i dati inseriti non sono validi")
    }
}

function deleteData(idPreferenza)
{
    var confirmed = confirm("Confermare la cancellazione di questa preferenza?");
    if (confirmed)
    {
        $.ajax({
            type : 'POST',
            url : 'scripts/ajaxCancella.php',
            data : {'id' : idPreferenza},
            success : function (msg)
            {
                location.reload();
            }
        });
    }
}

function closeEdit(numberId)
{
//    $("#ButtonBox"+numberId).animate({
//        height : $("#ButtonBox"+numberId).height() - $("#HiddenBox"+numberId).height()
//    }, 500)
    $("#ButtonBox"+numberId).height($("#ButtonBox"+numberId).height() - $("#HiddenBox"+numberId).height());
    $( "#HiddenBox"+numberId ).remove();
    
    //$( "#VisibleBox"+numberId).append('<br><br>');
    //$( "#HiddenBox"+numberId ).remove();
    
    $("#modifica"+numberId).prop("disabled",false);
    $("#elimina"+numberId).prop("disabled",false);
    $("#registro"+numberId).prop("disabled",false);
    
    //$("#ButtonBox"+numberId).height($("#ButtonBox"+numberId).height() - $("#HiddenBox"+numberId).height());
}

function setOnChangeEvents(numberId)
{
    $("#nome"+numberId).on("input", function (){
       $("#nome"+numberId).css("color","red")
    });
}

function resetColor(numberId)
{
    $("#nome"+numberId).css("color","#555")
}