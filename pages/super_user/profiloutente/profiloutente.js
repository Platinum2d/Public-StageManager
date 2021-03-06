contact = {
    'username' : '',
    'first': '',
    'last': '',
    'mail': '',
    'phone': ''
};

limits = {
    'username' : 0,
    'first': 0,
    'last': 0,
    'mail': 0,
    'phone': 0
}

flags = {
    'username' : true,
    'first': true,
    'last': true,
    'mail': true,
    'phone': true
}

var initialUsername;

function turnEditOn()
{
    $("#myInformations td").addClass("editCell");
    $("#myInformations .edittextdiv").attr('contenteditable', 'true');
}

function turnEditOff()
{
    $("#myInformations td").removeClass("editCell");
    $("#myInformations .edittextdiv").attr('contenteditable', 'false');
}

function setLimits()
{
    var xmllimiteusername = getMaximumLengthOf("../../../", "utente", "username");
    
    $(xmllimiteusername).find("colonne").find("colonna").each(function (){
        if ($(this).find("nome").text() === "username") limits.username = parseInt($(this).find("lunghezza_massima").text());
    });    
    
    var xmllimiti = getMaximumLengthOf("../../../", "super_user");
    $(xmllimiti).find("colonne").find("colonna").each(function (){
        if ($(this).find("nome").text() === "nome") limits.first = parseInt($(this).find("lunghezza_massima").text());
        if ($(this).find("nome").text() === "cognome") limits.last = parseInt($(this).find("lunghezza_massima").text());
        if ($(this).find("nome").text() === "telefono") limits.phone = parseInt($(this).find("lunghezza_massima").text());
        if ($(this).find("nome").text() === "email") limits.mail = parseInt($(this).find("lunghezza_massima").text());
    });    
}

$(document).ready(function()
{
    initialUsername = $("#username").text();
    contact.username=$("#username").text();	
    contact.first=$("#first").text();
    contact.last=$("#last").text();
    contact.mail=$("#mail").text();
    contact.phone=$("#phone").text();
    
    $("#username").keypress(function (e){
        if (e.which === 32) return false;
    });
    
    setLimits();
    
    $("#cancelButton").hide(); //nascondo i bottoni save e cancel che compaiono solo in modalità edit
    $("#saveButton").hide();
    
    $("#editButton").click(function(){
    	
        contact.username=$("#username").text();
        contact.first=$("#first").text();
        contact.last=$("#last").text();
        contact.mail=$("#mail").text();
        contact.phone=$("#phone").text();
        
        //faccio sparire il bottone edit
        $("#editButton").hide();
        
        //faccio comprarire i bottoni save e cancel
        $("#saveButton").show();
        $("#cancelButton").show();
        
        //rendo al tabella editabile
        turnEditOn();
        $("#password").html("<a style=\"color:#828282\" href=\"javascript:addPasswordEdit()\"> Modifica </a>");
    });
    
    $("#saveButton").click(function(){
        
        //salvo i nuovi dati contenuti nella tabella nell'oggetto contact
        contact.username = $("#username").text();
        contact.first=$("#first").text();
        contact.last=$("#last").text();
        contact.mail=$("#mail").text();
        contact.phone=$("#phone").text();
        
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
        
        //esco dalla modalità edit
        exitEdit();
    });
    
    $("#cancelButton").click(function(){
        
        //rimetto i valori precedenti nella tabella
        $("#username").parent().parent().find("th").html("Username");
        $("#username").parent().parent().find("th").css("color", "#828282");
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
        turnEditOff();
        
        //spariscono i bottoni save e cancel
        $("#cancelButton").hide();
        $("#saveButton").prop("disabled", false);
        $("#saveButton").hide();
        
        //compare bottone edit
        $("#editButton").show();
    }
    
    $("#username").on("input", function () {
        if ($("#username").text().toString().trim() === "")
        {
            $("#username").parent().parent().find("th").html("Informazione obbligatoria");
            $("#username").parent().parent().find("th").css("color", "red");
            flags.username = false;
            checkForValidFields();
            return;
        }
        
        if ($("#username").text().toString().trim().length > limits.username)
        {
            $("#username").parent().parent().find("th").html("Troppo lungo (max. caratteri: "+limits.username+")");
            $("#username").parent().parent().find("th").css("color", "red");
            flags.username = false;
            checkForValidFields();
            return;
        }
        
        $.ajax({
            type : 'POST',
            url : 'ajaxOps/ajaxCheckUserExistence.php',
            cache : false,
            data : {'user' : $("#username").text(), 'exception' : initialUsername},
            success : function (esito)
            {
                if (esito === "trovato")
                {
                    $("#username").parent().parent().find("th").html("Username (Esiste già)");
                    $("#username").parent().parent().find("th").css("color", "red");
                    flags.username = false;
                    checkForValidFields();
                }
                else
                {
                    $("#username").parent().parent().find("th").html("Username");
                    $("#username").parent().parent().find("th").css("color", "#828282");
                    flags.username = true;
                    checkForValidFields();
                }
            }
        });
    });
    
    $("#first").on("input", function () {
        if ($("#first").text().toString().trim() === "")
        {
            $("#first").parent().parent().find("th").html("Informazione obbligatoria");
            $("#first").parent().parent().find("th").css("color", "red");
            flags.first = false;
            checkForValidFields();
            return;
        }
        
        if ($("#first").text().toString().trim().length > limits.first)
        {
            $("#first").parent().parent().find("th").html("Troppo lungo (max. caratteri: "+limits.first+")");
            $("#first").parent().parent().find("th").css("color", "red");
            flags.first = false;
            checkForValidFields();
            return;
        }
        
        $("#first").parent().parent().find("th").html("Nome");
        $("#first").parent().parent().find("th").css("color", "#828282");
        flags.first = true;
        checkForValidFields();
    });
    
    $("#last").on("input", function () {
        if ($("#last").text().toString().trim() === "")
        {
            $("#last").parent().parent().find("th").html("Informazione obbligatoria");
            $("#last").parent().parent().find("th").css("color", "red");
            flags.last = false;
            checkForValidFields();
            return;
        }
        
        if ($("#last").text().toString().trim().length > limits.last)
        {
            $("#last").parent().parent().find("th").html("Troppo lungo (max. caratteri: "+limits.last+")");
            $("#last").parent().parent().find("th").css("color", "red");
            flags.last = false;
            checkForValidFields();
            return;
        }
        
        $("#last").parent().parent().find("th").html("Cognome");
        $("#last").parent().parent().find("th").css("color", "#828282");
        flags.last = true;
        checkForValidFields();
    });
    
    $("#mail").on("input", function(){        
        if ($("#mail").text().toString().trim().length > limits.mail)
        {
            $("#mail").parent().parent().find("th").html("Troppo lungo (max. caratteri: "+limits.mail+")");
            $("#mail").parent().parent().find("th").css("color", "red");
            flags.mail = false;
            checkForValidFields();
            return;
        }
        
        $("#mail").parent().parent().find("th").html("Email");
        $("#mail").parent().parent().find("th").css("color", "#828282");
        flags.mail = true;
        checkForValidFields();
    });
    
    $("#phone").on("input", function(){        
        if ($("#phone").text().toString().trim().length > limits.phone)
        {
            $("#phone").parent().parent().find("th").html("Troppo lungo (max. caratteri: "+limits.phone+")");
            $("#phone").parent().parent().find("th").css("color", "red");
            flags.mail = false;
            checkForValidFields();
            return;
        }
        
        $("#phone").parent().parent().find("th").html("Telefono");
        $("#phone").parent().parent().find("th").css("color", "#828282");
        flags.phone = true;
        checkForValidFields();
    });
});

function changePicture(){
    $("form[name=\"uploadchangeform\"]").fadeIn("fast");
    $("span[class=\"buttonText\"]").text("Scegli un file");
}

function removeChangeForm(){
    $("form[name=\"uploadchangeform\"]").hide();
}

function addPasswordEdit()
{
    String.prototype.isEmpty = function() {
        return (this.length === 0 || !this.trim());
    };
    
    $("#password").hide();
    $("#password").html("<input type=\"hidden\" value=\"0\" id=\"validpassword\"> <input type=\"hidden\" value=\"0\" id=\"validinput\">  \n\
                                      <div class=\"col-xs-6\" style=\"padding:0px\"> <span> Attuale </span> <input for=\"vecchiapassword\" class=\"form-control\" type=\"password\">  \n\
                                      <span> Nuova </span> <input for=\"nuovapassword\" class=\"form-control\" type=\"password\" >\n\
                                      <span> Conferma la nuova </span> <input for=\"confermapassword\" class=\"form-control\" type=\"password\" > <br>\n\
                                      \n\
                                      <input class=\"btn btn-primary leftAlignment\" type=\"button\" value=\"Salva le modifiche\" disabled=\"true\" onclick=\"updatePassword()\">\n\
                                      <input class=\"btn btn-secondary leftAlignment\" style=\"color:#828282\" type=\"button\" value=\"Chiudi\" onclick=\"rollbackToEdit()\">\n\
                                      </div>\n\
                                      <div class=\"col-xs-6\" style=\"padding:0px\" id=\"reportcol\"></div>");
    $("#password").fadeIn("slow");
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
        }
    });
}

function checkForValidFields()
{
    if (flags.username && flags.first && flags.last && flags.mail && flags.phone)
    {
        $("#saveButton").prop("disabled", false);
    }
    else
    {
        $("#saveButton").prop("disabled", true);
    }
}
