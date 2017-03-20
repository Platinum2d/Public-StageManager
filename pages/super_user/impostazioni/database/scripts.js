$(function (){
    $("#saveButton").hide();
    $("#cancelButton").hide();
    String.prototype.isEmpty = function() {
        return (this.length === 0 || !this.trim());
    };
    
    $("#host").on("input", function (){
        checkTheWhole();
    });
    
    $("#name").on("input", function (){
        checkTheWhole();
    });
    
    $("#user").on("input", function (){
        checkTheWhole();
    });
});

function openEdit(){
    $("#databaseInfo td").attr("contenteditable", "true").addClass("editCell");
    $("#password").attr("contenteditable", "false");
    
    $("#password").append("<div class=\"col-xs-6\">\n\
                            <input type=\"hidden\" id=\"validpassword\" value=\"0\" />\n\
                            Attuale <input id=\"actualpassword\" type=\"text\" class=\"form-control\" />\n\
                            Nuova <input id=\"newpassword\" type=\"text\" class=\"form-control\" />\n\
                            Conferma la nuova <input id=\"confirmnewpassword\" type=\"text\" class=\"form-control\" />\n\
                          </div>\n\
                          <div class=\"col-xs-6\"> \n\
                            <div align=\"center\"><input id=\"dontedit\" type=\"checkbox\"> Non modificare la password</div>\n\
                          </div>");
    
    $("#dontedit").change(function (){
        if ($("#dontedit").prop("checked"))
        {
            $("#actualpassword").attr("disabled", true);
            $("#newpassword").attr("disabled", true);
            $("#confirmnewpassword").attr("disabled", true);
            $("#actualpassword").val("");
            $("#newpassword").val("");
            $("#confirmnewpassword").val("");
            $("#validpassword").val("1");
            checkTheWhole();
        }
        else
        {
            $("#validpassword").val("0");
            $("#actualpassword").attr("disabled", false);
            $("#newpassword").attr("disabled", false);
            $("#confirmnewpassword").attr("disabled", false);   
            checkTheWhole();
        }
    });
    
    checkPassword();
    
    $("#actualpassword").on("input", function (){
    	checkPassword ();
    });
    
    $("#newpassword").on("input", function (){        
        checkTheWhole();
    });
    
    $("#confirmnewpassword").on("input", function (){        
        checkTheWhole();
    });
    
    $("#saveButton").show();
    $("#cancelButton").show();
    $("#editButton").hide();    
}

function closeEdit(){
    $("#databaseInfo td").attr("contenteditable", "false").removeClass("editCell");;
    
    $("#password").html("");
    
    $("#saveButton").hide();
    $("#cancelButton").hide();
    $("#editButton").show();
}

function editAccess(){
    var data = {
        'host' : $("#host").html(),
        'user' : $("#user").html(),
        'name' : $("#name").html(),
        'editpassword' : true,
        'password' : $("#newpassword").val()
    };
    
    data.editpassword = ($("#dontedit").prop("checked")) ? false : true;
    
    $.ajax({
        url : 'ajaxOpsPerDatabase/ajaxEditAccessFile.php',
        type : 'POST',
        cache : false,
        data : data,
        success : function (msg){
            if (msg === "ok")
            {
                closeEdit();
            }
            else
            {
                alert("Errore nell'aggiornamento dei dati");
            }
        }
    });
}

function checkTheWhole(){
    if (!$("#host").html().trim().isEmpty() && !$("#user").html().trim().isEmpty() && !$("#name").html().trim().isEmpty() && $("#validpassword").val() === "1" && $("#newpassword").val() === $("#confirmnewpassword").val())
        $("#saveButton").prop("disabled", false);
    else
        $("#saveButton").prop("disabled", true);
}

function checkPassword() {
	$.ajax({
        url : 'ajaxOpsPerDatabase/ajaxCheckPassword.php',
        type : 'POST',
        cache : false,
        data : { 'password' : $("#actualpassword").val() },
        success : function (msg)
        {
            if (msg === "ok")
                $("#validpassword").val("1");
            else
                $("#validpassword").val("0");
        },
        complete : function () {
            checkTheWhole();
        }
    });
}