$(document).ready(function (){
    $("#actionwrapper").hide();
    $("#viewoptions").hide();
    
    $("#classes").change(function (){
        $.ajax({
            url : 'ajaxOpsPerClasse/ajaxClasse.php',
            cache : false,
            type : 'POST',
            data : { 'idscuola' : $("#classes").val() },
            success : function (xml)
            {
                if ($("#classes").val() !== "-1")
                {
                    $("#actionwrapper").fadeIn();
                    $("#viewoptions").fadeIn();
                }
                else
                {
                    $("#actionwrapper").fadeOut();
                    $("#viewoptions").fadeOut();
                }
                var newtable = "<table id=\"current\" class=\"table table-bordered\"> \n\
                    <thead style=\"background : #eee\"> <th style=\"width:2%; text-align : center\"> <input id=\"checkall\" type=\"checkbox\"> </th> <th style=\"text-align : center\"> Nome </th> <th style=\"text-align : center\"> Azioni </th> <th style=\"text-align : center\"> Anno Scolastico </th> </thead> <tbody> </tbody>   \n\
                    </table>";
                $("#table").html(newtable);
                var I=0;
                $(xml).find("classi").find("classe").each(function (){
                    var newline = 
                            "<tr style=\"text-align : center\" id=\"riga"+I+"\"> \n\
                        <td><input class=\"singlecheck\" type=\"checkbox\"></td>\n\
                        <td style=\"width: 33%\"> <div id=\"VisibleBox"+I+"\"> "+$(this).find("nome").text()+" </div> </td>\n\
                        <td style=\"width : 33%\"> <div align=\"center\" id=\"ButtonBox"+I+"\"> \n\
                            <input type=\"button\" class=\"btn btn-success\" value=\"Modifica\" id=\"modifica"+I+"\" onclick=\"openEdit('VisibleBox"+I+"', "+$(this).find("id").text()+")\">\n\
                            <input type=\"button\" class=\"btn btn-danger\" value=\"Elimina\" id=\"elimina"+I+"\"> </div> </td>\n\
                        <td style=\"width : 33%\"> \n\
                            <form style=\"height:0px\" action=\"\" method=\"POST\"> \n\
                                    <input type=\"hidden\" value=\""+$(this).find("id").text()+"\" name=\"id_classe\"> \n\
                                    <select name=\"years\" class=\"form-control\"> <option> </option>\n\
                                    </select> \n\
                            </form> \n\
                        </td>\n\
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
                
                $("#table").hide();
                $("#table").fadeIn();
            }
        });
        
        $.ajax({
            url : 'ajaxOpsPerClasse/ajaxAnnoScolastico.php',
            cache : false,
            success : function (xml)
            {
                $(xml).find("anni").find("anno").each(function (){
                    $("select[name=\"years\"]").append("<option value=\""+$(this).find("id").text()+"\"> "+$(this).find("nome").text()+" </option>");
                    $("select[name=\"years\"]").change(function (){
                        switch ($("#action").val())
                        {
                            case 'studenti':
                                $(this).closest("form").attr("action", "../studenti/index.php");
                                break;
                            
                            case 'stage':
                                $(this).closest("form").attr("action", "../esperienzestage/index.php");
                                break;
                        }
                        $(this).closest("form").submit();
                    });
                });
            }
        });
    });
});

function openEdit(id, idClasse)
{
    var numberId = id.replace("VisibleBox", "");
    var editline = "<tr id=\"HiddenBox"+numberId+"\">\n\
                        <td colspan=\"3\">\n\
                            <div class=\"row\">\n\
                                <div class=\"col col-sm-12\">\n\
                                    <div class=\"row\">\n\
                                        <div class=\"col-sm-6\">\n\
                                            Nome classe <input type=\"text\" class=\"form-control\" id=\"nomeclasse"+numberId+"\">\n\
                                            Scuola <select class=\"form-control\" id=\"scuolaclasse"+numberId+"\"> </select>\n\
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
                $("#scuolaclasse"+numberId).html("<option value=\""+$(this).find("id_scuola").text()+"\"> "+$(this).find("nome_scuola").text()+" </option>");
                $("#settoreclasse"+numberId).html("<option value=\""+$(this).find("id_settore").text()+"\"> "+$(this).find("indirizzo").text()+" - "+$(this).find("settore").text()+" </option>");
            });
            $.ajax({
                url : 'ajaxOpsPerClasse/ajaxScuola.php',
                cache : false,
                type : 'POST',
                data : { 'exception' : $("#scuolaclasse"+numberId).val() },
                success : function (xml)
                {
                    $(xml).find("scuole").find("scuola").each(function (){
                        $("#scuolaclasse"+numberId).append("<option value=\""+$(this).find("id").text()+"\"> "+$(this).find("nome").text()+" </option>");
                    });
                }
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
            'scuola' : $("#scuolaclasse"+numberId).val(),
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

function closeEdit(numberId)
{
    $("#HiddenBox"+numberId).remove();
}

function setOnChangeEvents(numberId)
{
    $("#nomeclasse"+numberId).on ('input', (((function (e){ $("#nomeclasse"+numberId).css('color','red'); }))));
    $("#scuolaclasse"+numberId).on ('change', (((function (e){ $("#scuolaclasse"+numberId).css('color','red'); }))));
    $("#settoreclasse"+numberId).on ('change', (((function (e){ $("#settoreclasse"+numberId).css('color','red'); }))));
}

function resetColors(numberId)
{
    $("#nomeclasse"+numberId).css("color" , "#555");
    $("#scuolaclasse"+numberId).css("color" , "#555");
    $("#settoreclasse"+numberId).css("color" , "#555");    
}