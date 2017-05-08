var tempReturnValue = "";

function printError(title, message, closeFunction)
{
    $("#SuperAlert").modal("show");
    if (typeof(title) !== "undefined")
        $("#SuperAlert").find(".modal-title").html(title);
    else
        $("#SuperAlert").find(".modal-title").html("Errore");
    
    if (closeFunction !== undefined) {
    	$("#SuperAlert").on('hidden.bs.modal', function () {
            closeFunction ();
    	});
    }
    
    $("#SuperAlert").find(".modal-body").html("<b>"+message+"</b>");
    $("#SuperAlert").find(".modal-body").css("background-color", "rgba(255, 0, 0, 0.3)");
}

function printSuccess(title, message, closeFunction)
{
    $("#SuperAlert").modal("show");
    if (typeof(title) !== "undefined")
        $("#SuperAlert").find(".modal-title").html(title);
    else
        $("#SuperAlert").find(".modal-title").html("Errore");
    
    if (closeFunction !== undefined) {
    	$("#SuperAlert").on('hidden.bs.modal', function () {
            closeFunction ();
    	});
    }
    
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

function userProfile(user_id, goback)
{
    $("#redirectUserForm").remove();
    $.ajax({
        type : 'POST',
        url : goback+'../lib/custom/ajax/ajaxUserType.php',
        cache : false,
        data : {'id' : user_id},
        success : function (xml){
            if ($(xml).find("esito").text().length > 0)
            {
                var tipo = $(xml).find("tipo").text();
                
                $("body").append("<form id='redirectUserForm' style='height:0px; width:0px' action='"+goback+"visualizza_utente/"+tipo+"/index.php' method='POST'>\n\
                    <input type='hidden' name='user' value='"+user_id+"'/>\n\
               </form>");
                
                $("#redirectUserForm").submit();
                $("#redirectUserForm").remove();
            }
        }        
    });
}

function checkDateItalianFormat (dateString) {
    var patt = new RegExp('[0-9][0-9]-[0-9][0-9]-[0-9][0-9][0-9][0-9]');
    return patt.test(dateString);
}

function tempReturn(data)
{
    tempReturnValue = data;
}

function getMaximumLengthOf(goback, table, column)
{
    var tosend = (undefined !== column) ? {'table' : table, 'column' : column} : {'table' : table};
    
    $.ajax({
        type : 'POST',
        url : goback+'lib/custom/ajax/ajaxMaximumCharacters.php',
        data : tosend,
        async : false,
        success : function (xml)
        {            
            tempReturn(xml);
        }
    });
    
    return tempReturnValue;
}

String.prototype.isEmpty = function() {
    return (this.length === 0 || !this.trim());
};

function checkEmptyFields (fields) {
	var empty = false;
	if (Array.isArray (fields)) {
		fields.forEach (function (item) {
			$(item).each (function () {
				if ($(this).val() && $(this).val().trim().isEmpty()) {
					empty = true;
					return;
				}
			});
		});
	}
	else {
		empty = true;
	}
	return empty;
}