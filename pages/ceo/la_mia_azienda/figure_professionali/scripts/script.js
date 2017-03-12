function deleteNeeding(idneeding, caller)
{
    $.ajax({
        type : 'POST',
        url : 'ajaxOpsPerFigureProfessionali/ajaxRemoveCompanyNeed.php',
        cache : false,
        data : {'id' : idneeding},
        success : function (msg)
        {
            if (msg === "ok")
                $(caller).parents("tr").fadeOut();
            else
                printError("Errore di eliminazione", "<div align='center'>Si è verificato un errore in fase di eliminazione. Si prega di riprovare più tardi o di contattare gli amministratori.<br>Ci scusiamo dell'inconveniente</div>");
        }
    });
}

function openAddBox()
{
    var lasttr = $("#figtable").find("tr").last();
    
    $("<tr>\n\
            <td><select class='form-control' id='addBoxFigure'></select></td>\n\
            <td align='center'>\n\
                <button id='sendButton' class='btn btn-success btn-sm margin buttonfix'><span class='glyphicon glyphicon-ok'></span></button>\n\
                <button onclick='closeAddBox()' class='btn btn-danger btn-sm margin buttonfix'><span class='glyphicon glyphicon-remove'></span></button>\n\
            </td>\n\
        </tr>").insertAfter(lasttr);
    
    $.ajax({
        type : 'POST',
        url : 'ajaxOpsPerFigureProfessionali/ajaxFigure.php',
        cache : false,
        success : function (xml)
        {
            $("#addBoxFigure").html("");
            $(xml).find("figure").find("figura").each(function (){
                var id = $(this).find("id").text();
                var nome = $(this).find("nome").text();
                
                $("#addBoxFigure").append("<option value='"+id+"'>"+nome+"</option>");
            });
        }
    });
    
    $("#sendButton").on("click", function (){
        send($("#addBoxFigure").val());
    });
}

function send(figura)
{
    $.ajax({
        type : 'POST',
        url : 'ajaxOpsPerFigureProfessionali/ajaxAddFigure.php',
        cache : false,
        data : 
                {
                    'figura' :  figura  
        },
        success : function (msg)
        {
            if ($(msg).find("esito").text() === "ok")
            {
                var added_figura = $("#addBoxFigure").find(":selected").text();
                var id = $(msg).find("insert_id").text();
                
                closeAddBox();
                $("#figtable").find("tbody").append("<tr><td>"+added_figura+"</td>\n\
                                                     <td align='center'><button class='btn btn-danger' onclick='deleteNeeding("+id+", this)'><span class=\"glyphicon glyphicon-remove\"></span> Elimina</button>\n\
                                                     </td></tr>");
            }
            else
            {
                printError("Errore di inserimento", "<div align='center'>Si è verificato un errore di inserimento. Si prega di riprovare più tardi o di contattare gli amministratori.<br>Ci scusiamo dell'inconveniente</div>");
            }
        }
    });
}

function closeAddBox()
{
    $("#addBoxFigure").parents("tr").remove();
    $("#addButton").prop("disabled", false);
}