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

function doSetupForProfileImage()
{
    var containerwidth = $("#profileimage").parent("div[align=\"center\"]").width();
    var containerheight = $("#profileimage").parent("div[align=\"center\"]").height();
    
    $("#editspan").css("left", containerwidth / 1.9);
    $("#editspan").css("top", containerheight / 2);
    $("#editspan").css("visibility" , "hidden");   
    $("#profileimage").hover(function (){
        $("#editspan").css("visibility" , "visible");
        $("#profileimage").css("opacity", "0.2");
    })
    $("#profileimage").on("mouseout", function (){
        $("#editspan").css("visibility" , "hidden");              
        $("#profileimage").css("opacity", "1");
    });
    $('#SuperAlert').on('hidden.bs.modal', function () {
        $("#editspan").css("visibility" , "hidden");              
        $("#profileimage").css("opacity", "1");
    });
    $("#editspan").hover(function (){
        $("#editspan").css("visibility" , "visible");
        $("#profileimage").css("opacity", "0.2");
    });
    window.onresize = function (){
        var containerwidth = $("#profileimage").parent("div[align=\"center\"]").width();
        var containerheight = $("#profileimage").parent("div[align=\"center\"]").height();
        $("#editspan").css("left", containerwidth / 1.9);
        $("#editspan").css("top", containerheight / 2);
    };
}

function resetAvatar()
{
    $.ajax({
        type : 'POST',
        url : 'ajaxOps/ajaxResetAvatar.php',
        cache : false,
        success : function (msg)
        {
            if (msg === "ok")
            {
                $("#SuperAlert").modal("hide");
                location.reload();
            }
        }
    });
}

function checkSubmitForProfileImage()
{
    if ($(".file-default-preview").length > 0) return false;
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