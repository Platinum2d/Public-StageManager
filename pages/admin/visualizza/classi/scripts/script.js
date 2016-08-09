classe = {
  'id' : '',
  'nome' : '',
  'specializzazione' : ''
};

function openEdit(id, idClasse)
{
    id = id+'';
    var numberId = id.replace('VisibleBox','');
    
    $("#modifica"+numberId).prop("disabled",true);
    $("#elimina"+numberId).prop("disabled",true);
    $('#'+id).append("<div id=\"HiddenBox"+numberId+"\"> <label id=\"label"+numberId+"\"> Nome </label><input placeholder=\"Nome della classe\" class=\"form-control\" type=\"text\" id=\"nome"+numberId+"\"> ");
    $("#HiddenBox"+numberId).append(" Specializzazione <select class=\"form-control\" type=\"text\" id=\"spec"+numberId+"\"> <option value=\"-1\"> </option> </select>  <button class=\"btn btn-danger btn-sm rightAlignment margin buttonfix\" onclick=\"closeEdit("+numberId+")\"> <span class=\"glyphicon glyphicon-remove\"> </span> </button> <button class=\"btn btn-success btn-sm rightAlignment margin buttonfix\"  onclick=\" sendData("+idClasse+","+numberId+")\"> <span class=\"glyphicon glyphicon-ok\"> </span> </button> <br><br></div>");
    $("#HiddenBox"+numberId).hide();
//    $("#HiddenBox"+numberId).fadeIn("slow");    
    $.ajax(
        {
            type : 'POST',
            url : 'scripts/getData.php',
            data : { 'id' : idClasse},
            success : function (xml)
            {
                var nome = $(xml).find("nome_classe").text();
                var specializzazione = $(xml).find("nome_spec").text();
                $("#nome"+numberId).val(nome);
                
                $.ajax({
                   url : 'scripts/ajaxSpecializzazioni.php',
                   cache : false,
                   success : function (spec)
                   {
                       $(spec).find("specializzazioni").find("specializzazione").each(function (){
                           var id = $(this).find("id").text();
                           var nome = $(this).find("nome").text();
                           
                           $("#spec"+numberId).append("<option value=\""+id+"\"> "+nome+" </option>");
                           
                           var rightindex = 1;
                           $("#spec"+numberId+" > option").each(function (){
                               if (this.text === specializzazione)
                               {
                                   rightindex = this.index;
                                   $("#spec"+numberId).prop("selectedIndex",rightindex);
                               }
                           })
                       });
                   }
                });
                
            }
        });
       
    
    $("#nome"+numberId).keypress(function (event){
        if (event.which === 13) sendData(idClasse, numberId);
    });
    
    $("#HiddenBox"+numberId).fadeIn("slow");
    $("#ButtonBox"+numberId).height($("#ButtonBox"+numberId).height() + $("#HiddenBox"+numberId).height())
//    $("#ButtonBox"+numberId).animate({
//        height : $("#ButtonBox"+numberId).height() + $("#HiddenBox"+numberId).height()
//    }, 500)
//    $("#ButtonBox"+numberId).height($("#ButtonBox"+numberId).height() + $("#HiddenBox"+numberId).height());
    setOnChangeEvents(numberId);
}

function sendData(idClasse, numberId)
{
    String.prototype.isEmpty = function() {
        return (this.length === 0 || !this.trim());
    };  
    
    classe.id = idClasse;
    classe.nome = $("#nome"+numberId+"").val();
    classe.specializzazione = $("#spec"+numberId).val();
    
    if (!classe.nome.isEmpty() && !classe.specializzazione.isEmpty())
    {
        $.ajax({
           type : 'POST',
           url : 'scripts/ajaxInvia.php',
           data : classe,
           success : function (nuovonome)
           {
               $("#label"+numberId).replaceWith("<label id=\"label"+numberId+"\"> "+nuovonome+" </label>");
               resetColors(numberId);
           }
        });
    }
    else
    {
        alert("i dati inseriti non sono validi")
    }
}

function deleteData(idClasse)
{
    var confirmed = confirm("Confermare la cancellazione di questa classe?");
    if (confirmed)
    {
        $.ajax({
            type : 'POST',
            url : 'scripts/ajaxCancella.php',
            data : {'id' : idClasse},
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
    $("#ButtonBox"+numberId).height($("#ButtonBox"+numberId).height() - $("#HiddenBox"+numberId).height())
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
    $("#nome"+numberId).on ('input', (((function (e){ $("#nome"+numberId).css('color','red'); }))));
    $("#spec"+numberId).change(((function (e){ $("#spec"+numberId).css('color','red'); })));
}

function resetColors(numberId)
{
    $("#nome"+numberId).css('color','#555');
    $("#spec"+numberId).css('color','#555');
}
