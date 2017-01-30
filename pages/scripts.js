function printError(title, message)
{
    $("#SuperAlert").modal("show");
    if (typeof(title) !== "undefined")
        $("#SuperAlert").find(".modal-title").html(title);
    else
        $("#SuperAlert").find(".modal-title").html("Errore");
    
    $("#SuperAlert").find(".modal-body").html("<b>"+message+"</b>");
    $("#SuperAlert").find(".modal-body").css("background-color", "rgba(255, 0, 0, 0.3)");
}

function printSuccess(title, message)
{
    $("#SuperAlert").modal("show");
    if (typeof(title) !== "undefined")
        $("#SuperAlert").find(".modal-title").html(title);
    else
        $("#SuperAlert").find(".modal-title").html("Errore");
    
    $("#SuperAlert").find(".modal-body").html("<b>"+message+"</b>");
    $("#SuperAlert").find(".modal-body").css("background-color", "#B7F4B7");
}

function changeDatabase(database)
{
    $.ajax({
        type : 'POST',
        url : 'ajaxOpsPerDatabase/ajaxCambiaDatabase.php',
        cache : false,
        data : { 'db' : database},
        success : function (session)
        {
            location.reload();
        }
    })
}