contact = {
    'username' : '',
    'first': '',
    'last': '',
    'mail': '',
    'phone': ''
};

var initialUsername;

$(document).ready(function()
{
    initialUsername = $("#username").html();
    contact.username=$("#username").html();
    contact.first=$("#first").html();
    contact.last=$("#last").html();
    contact.mail=$("#mail").html();
    contact.phone=$("#phone").html();
	
    //nascondo i bottoni save e cancel che compaiono solo in modalità edit
    $("#cancelButton").hide();
    $("#saveButton").hide();
	
    $("#editButton").click(function(){
    	
        contact.username=$("#username").html();
        contact.first=$("#first").html();
        contact.last=$("#last").html();
        contact.mail=$("#mail").html();
        contact.phone=$("#phone").html();
		
        //faccio sparire il bottone edit
        $("#editButton").hide();
		
        //faccio comprarire i bottoni save e cancel
        $("#saveButton").show();
        $("#cancelButton").show();
		
        //rendo al tabella editabile
        $("#myInformations td").attr('contenteditable', 'true').addClass("editCell");
        $("#password").attr('contenteditable', 'false');
        $("#password").html("<a style=\"color:#828282\" href=\"javascript:addPasswordEdit()\"> Modifica </a>");
    });
	
    $("#saveButton").click(function(){

        //salvo i nuovi dati contenuti nella tabella nell'oggetto contact
        contact.username = $("#username").html();
        contact.first=$("#first").html();
        contact.last=$("#last").html();
        contact.mail=$("#mail").html();
        contact.phone=$("#phone").html();
		
        //eseguo query
        if(contact.first.length>0 && contact.last.length>0 && contact.username.length>0)
        {
            $.ajax({
                type: "POST",
                url: "ajaxOps/ajax.php",
                data: contact,
                cache: false,
                success : function (msg)
                {
                    if (msg === "ok")
                        exitEdit();
                    else
                       printError("Errore di aggiornamento", "<div align='center'>Si è verificato un errore in fase di aggiornamento del profilo. Si prega di ritentare.<br>\n\
                                                               Se il problema persiste, contattare un amministratore.</div>"); 
                }
            });
        }
        else
        {
            printError("Informazioni incomplete", "<div align='center'>Si prega di completare tutti i campi necessari</div>");
        }	
    });

    $("#cancelButton").click(function(){
		
        //rimetto i valori precedenti nella tabella
        $("#username").parent().find("th").html("Username");
        $("#username").parent().find("th").css("color", "#828282");
        $("#username").html(contact.username);
        $("#first").html(contact.first);
        $("#last").html(contact.last);
        $("#mail").html(contact.mail);
        $("#phone").html(contact.phone);
		
        //esco dalla modalità edit
        exitEdit();
    });
	
    function exitEdit(){
        $("#password").html("");
        //blocco la tabella
        $("#myInformations td").attr('contenteditable', 'false').removeClass("editCell");
		
        //spariscono i bottoni save e cancel
        $("#cancelButton").hide();
        $("#saveButton").prop("disabled", false);
        $("#saveButton").hide();
		
        //compare bottone edit
        $("#editButton").show();
    }
    
    $("#username").on("input", function () {
        if ($("#username").html().toString().trim() === "")
        {
            $("#saveButton").prop("disabled", true);
            $("#username").parent().find("th").html("Informazione obbligatoria");
            $("#username").parent().find("th").css("color", "red");
            return;
        }
        
        if ($("#username").html().toString().trim().length > 50)
        {
            $("#saveButton").prop("disabled", true);
            $("#username").parent().find("th").html("Troppo lungo (max. caratteri: 50)");
            $("#username").parent().find("th").css("color", "red");
            return;
        }
        
        $.ajax({
            type : 'POST',
            url : 'ajaxOps/ajaxCheckUserExistence.php',
            cache : false,
            data : {'user' : $("#username").html(), 'exception' : initialUsername},
            success : function (esito)
            {
                if (esito === "trovato")
                {
                    $("#saveButton").prop("disabled", true);
                    $("#username").parent().find("th").html("Username (Esiste già)");
                    $("#username").parent().find("th").css("color", "red");
                }
                else
                {
                    $("#username").parent().find("th").html("Username");
                    $("#username").parent().find("th").css("color", "#828282");
                    if ($("#first").html().toString().trim() !== "" && $("#last").html().toString().trim() !== "")
                    {
                        $("#saveButton").prop("disabled", false);
                    }
                }
            }
        });
    });
    
    $("#first").on("input", function () {
        if ($("#first").html().toString().trim() === "")
        {
            $("#saveButton").prop("disabled", true);
        }
        else {
            if ($("#last").html().toString().trim() !== "" && $("#username").html().toString().trim() !== "")
            {
                $("#saveButton").prop("disabled", false);
            }
        }
    });
    
    $("#last").on("input", function () {
        if ($("#last").html().toString().trim() === "")
        {
            $("#saveButton").prop("disabled", true);
        }
        else {
            if ($("#first").html().toString().trim() !== "" && $("#username").html().toString().trim() !== "")
            {
                $("#saveButton").prop("disabled", false);
            }
        }
    });
});

function addPasswordEdit()
{
    String.prototype.isEmpty = function() {
        return (this.length === 0 || !this.trim());
    };
    
    $("#password").html("<input type=\"hidden\" value=\"0\" id=\"validpassword\"> <input type=\"hidden\" value=\"0\" id=\"validinput\">  \n\
                                      <div class=\"col-xs-7\" style=\"padding:0px\"> <span> Attuale </span> <input for=\"vecchiapassword\" class=\"form-control\" type=\"password\">  \n\
                                      <span> Nuova </span> <input for=\"nuovapassword\" class=\"form-control\" type=\"password\" >\n\
                                      <span> Conferma la nuova </span> <input for=\"confermapassword\" class=\"form-control\" type=\"password\" > <br>\n\
                                      \n\
                                      <input class=\"btn btn-primary leftAlignment\" type=\"button\" value=\"Salva le modifiche\" disabled=\"true\" onclick=\"updatePassword()\">\n\
                                      <input class=\"btn btn-secondary leftAlignment\" style=\"color:#828282\" type=\"button\" value=\"Chiudi\" onclick=\"rollbackToEdit()\">\n\
                                      </div>\n\
                                      <div class=\"col-xs-5\" style=\"padding:0px\" id=\"reportcol\"></div>");
    $("input[for=\"vecchiapassword\"]").on("keyup",function (e){
        if (e.which === 13 && !$("input[value=\"Salva i cambiamenti\"]").prop("disabled"))
            updatePassword();
        
        $.ajax({
            type : 'POST',
            url : 'ajaxOps/ajaxCheckPassword.php',
            cache : false,
            data : { 'password' : $("input[for=\"vecchiapassword\"]").val() },
            success : function (msg)
            {
                if (msg !== "esiste")
                    $("#validpassword").val("0");
                else
                    $("#validpassword").val("1");
             
                checkTheWhole();
            }
        })
    });
    
    $("input[for=\"nuovapassword\"]").on("keyup",function (e){
        if (e.which === 13 && !$("input[value=\"Salva i cambiamenti\"]").prop("disabled"))
            updatePassword();
        
        if ($("input[for=\"nuovapassword\"]").val() !== $("input[for=\"confermapassword\"]").val() || $("input[for=\"nuovapassword\"]").val().isEmpty() || $("input[for=\"confermapassword\"]").val().isEmpty())
        {
            $("#validinput").val("0");
        }
        else
        {
            $("#validinput").val("1");
        }
        checkTheWhole();
    });
    
    $("input[for=\"confermapassword\"]").on("keyup",function (e){
        if (e.which === 13 && !$("input[value=\"Salva i cambiamenti\"]").prop("disabled"))
            updatePassword();
            
        if ($("input[for=\"nuovapassword\"]").val() !== $("input[for=\"confermapassword\"]").val() || $("input[for=\"nuovapassword\"]").val().isEmpty() || $("input[for=\"confermapassword\"]").val().isEmpty())
        {
            $("#validinput").val("0");
        }
        else
        {
            $("#validinput").val("1");
        }
        checkTheWhole();
    });
}

function checkTheWhole()
{
    if ($("#validinput").val() === "1" && $("#validpassword").val() === "1") 
        $("input[value=\"Salva le modifiche\"]").prop("disabled", false);
    else
        $("input[value=\"Salva le modifiche\"]").prop("disabled", true);
}

function rollbackToEdit()
{
    $("#password").html("<a style=\"color:#828282\" href=\"javascript:addPasswordEdit()\"> Modifica </a>");
}

function updatePassword()
{
    $.ajax({
        type : 'POST',
        url : 'ajaxOps/ajaxReplacePassword.php',
        cache : false,
        data : { 'password' : $("input[for=\"nuovapassword\"]").val() },
        success : function (msg)
        {
            if (msg === "ok")
            {
                $("#reportcol").html("<div align=\"center\" name=\"reportwrap\"><span style=\"color:green\">Modifiche salvate con successo</span></div>");
                $("#reportcol").hide();
                $("#reportcol").fadeIn(2450);
                $("#reportcol").fadeOut(1500);
            }
            else
            {
                $("#reportcol").html("<div align=\"center\" name=\"reportwrap\"><span style=\"color:red\">Errore durante il salvataggio. Riprova piu' tardi</span></div>");
                $("#reportcol").hide();
                $("#reportcol").fadeIn(2450);
                $("#reportcol").fadeOut(1500);
            }
        }
    })
}
