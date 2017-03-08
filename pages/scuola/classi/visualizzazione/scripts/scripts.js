var temp;

$(document).ready(function (){
    fillTable();
});

function fillTable(){
    $.ajax({
        url : 'ajaxOpsPerClasse/ajaxClasse.php',
        cache : false,
        type : 'POST',
        success : function (xml)
        {
            var newtable = "<input type='hidden' id='tmp'><table id=\"current\" class=\"table table-bordered\"> \n\
                    <thead style=\"background : #eee\"> <th style=\"width:2%; text-align : center\"> <input id=\"checkall\" type=\"checkbox\"> </th> <th style=\"text-align : center\"> Nome </th> <th style=\"text-align : center\"> Settore </th> <th style=\"text-align : center\"> Azioni </th> </thead> <tbody> </tbody>   \n\
                    </table>";
            $("#table").html(newtable);
            var I=0;
            
            $(xml).find("classi").find("classe").each(function (){
                
                var newline = 
                        "<tr style=\"text-align : center\" id=\"riga"+I+"\"> \n\
                        <td><input class=\"singlecheck\" type=\"checkbox\"></td>\n\
                        <td style=\"width: 33%\"> <div id=\"VisibleBox"+I+"\"> "+$(this).find("nome").text()+" </div> </td>\n\
                        <td>"+$(this).find("indirizzo_studi").text()+" "+$(this).find("settore").text()+"</td>\n\
                        <td style=\"width : 33%\"> <div align=\"center\" id=\"ButtonBox"+I+"\">\n\
                            <form style=\"height:0px\" action=\"\" method=\"POST\"> \n\
                                <input type=\"hidden\" value=\""+$(this).find("id").text()+"\" name=\"id_classe\">\n\
                                <input type=\"hidden\" value=\"\" name=\"years\">\n\
                            </form> \n\
                            <button type=\"button\" class=\"btn btn-success\" value=\"\" id=\"modifica"+I+"\" onclick=\"openEdit('VisibleBox"+I+"', "+$(this).find("id").text()+")\"><span class='glyphicon glyphicon-edit'></span> Modifica </button>\n\
                            <button type=\"button\" class=\"btn btn-info\" value=\"\" id=\"visualizza"+I+"\" onclick=\"redirect("+I+")\"><span class='glyphicon glyphicon-circle-arrow-right'></span>  Visualizza</button>\n\
                        </td>\n\
                            \n\
                    </tr>";
                $("#current").find("tbody").append(newline);
                I++;
            });
            
            $("#checkall").change(function (){
                if ($(this).prop("checked"))
                    $(".singlecheck").prop("checked", true);
                else
                    $(".singlecheck").prop("checked", false);
            });
        }
    });
}

function openEdit(id, idClasse)
{
    var numberId = id.replace("VisibleBox", "");
    $("#modifica"+numberId).prop("disabled", true);
    
    var editline = "<tr id=\"HiddenBox"+numberId+"\">\n\
                        <td colspan=\"3\">\n\
                            <div class=\"row\">\n\
                                <div class=\"col col-sm-12\">\n\
                                    <div class=\"row\">\n\
                                        <div class=\"col-sm-6\">\n\
                                            Nome classe <input style='margin-bottom:8px' type=\"text\" class=\"form-control\" id=\"nomeclasse"+numberId+"\">\n\
                                            Settore <select class=\"form-control\" id=\"settoreclasse"+numberId+"\"> </select>\n\
                                        </div>\n\
                                    </div>\n\
                                    <button id=\"confirm"+numberId+"\" class=\"btn btn-success btn-sm rightAlignment margin buttonfix\" onclick=\"sendData("+numberId+", "+idClasse+")\">\n\
                                        <span class=\"glyphicon glyphicon-ok\"></span>\n\
                                    </button>\n\
                                    <button id=\"closedit"+numberId+"\" class=\"btn btn-danger btn-sm rightAlignment margin buttonfix\" onclick=\"closeEdit("+numberId+")\">\n\
                                        <span class=\"glyphicon glyphicon-remove\"></span>\n\
                                    </button>\n\
                                </div>\n\
                            </div>\n\
                        </td>\n\
                        <td> </td>\n\
                    </tr>";
    $.ajax({
        url : 'ajaxOpsPerClasse/getData.php',
        cache : false,
        type : 'POST',
        data : { 'classe' : idClasse },
        success : function (xml)
        {
            $(xml).find("classi").find("classe").each(function (){
                $("#nomeclasse"+numberId).val($(this).find("nome").text());
                $("#settoreclasse"+numberId).html("<option value=\""+$(this).find("id_settore").text()+"\"> "+$(this).find("indirizzo").text()+" - "+$(this).find("settore").text()+" </option>");
            });
            $.ajax({
                url : 'ajaxOpsPerClasse/ajaxSettore.php',
                cache : false,
                type : 'POST',
                data : { 'exception' : $("#settoreclasse"+numberId).val() },
                success : function (xml)
                {
                    $(xml).find("settori").find("settore").each(function (){
                        $("#settoreclasse"+numberId).append("<option value=\""+$(this).find("id").text()+"\"> "+$(this).find("indirizzo_studi").text()+" - "+$(this).find("nome_settore").text()+" </option>");
                    });
                }
            });
        }
    });
    $(editline).insertAfter("#riga"+numberId);
    setOnChangeEvents(numberId);
    $("#HiddenBox"+numberId).hide();
    $("#HiddenBox"+numberId).fadeIn();    
}

function sendData(numberId, idClasse){
    $.ajax({
        type : 'POST',
        url : 'ajaxOpsPerClasse/ajaxInvia.php',
        cache : false,
        data : { 
            'id' : idClasse,
            'nomeclasse' : $("#nomeclasse"+numberId).val(),
            'settore' : $("#settoreclasse"+numberId).val()
        },
        success : function (msg){
            if (msg === "ok")
            {
                resetColors(numberId);
                $("#VisibleBox"+numberId).html($("#nomeclasse"+numberId).val());
            }
        }
    })
}

function redirect(progressiv)
{
    var action = $("#actions").val();
    var year = $("#anni").val();
    var form = $("#visualizza"+progressiv).parent("div[align='center']").find("form");
    
    form.find("input[name='years']").val(year);
    switch (action)
    {
        case 'studenti':
            form.attr("action", "studenti/index.php");
            break;
        
        case 'stage':
            form.attr("action", "esperienzestage/index.php");
            break;
    }
    
    form.submit();
}

function closeEdit(numberId)
{
    $("#HiddenBox"+numberId).remove();
    $("#modifica"+numberId).prop("disabled", false);
}

function setOnChangeEvents(numberId)
{
    $("#nomeclasse"+numberId).on ('input', (((function (e){ $("#nomeclasse"+numberId).css('color','red'); }))));
    $("#settoreclasse"+numberId).on ('change', (((function (e){ $("#settoreclasse"+numberId).css('color','red'); }))));
}

function resetColors(numberId)
{
    $("#nomeclasse"+numberId).css("color" , "#555");
    $("#settoreclasse"+numberId).css("color" , "#555");    
}