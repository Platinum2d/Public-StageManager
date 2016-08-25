contact = {
    'first': '',
    'last': '',
    'city': '',
    'mail': '',
    'phone': '',
    'preference': ''
};

$(document).ready(function(){
    $("#cancelButtonpreference").hide();
    $("input[type=\"text\"]").keydown(function (){ return false; });
    contact.first=$("#first").html();
    contact.last=$("#last").html();
    contact.city=$("#city").html();
    contact.mail=$("#mail").html();
    contact.phone=$("#phone").html();
    //contact.preference=$("#preference").html();
    $("span[data-role=\"remove\"]").css("visibility","hidden");
    
    //nascondo i bottoni save e cancel che compaiono solo in modalità edit
    $("#cancelButton").hide();
    $("#saveButton").hide();
    
    $("#editButton").click(function(){
        
        //faccio sparire il bottone edit
        //$('#preferenza').prop('disabled', false);
        $("#editButton").hide();
        $("#saveButton").show();
        $("#cancelButton").show();
        $("#myInformations td").attr('contenteditable', 'true').addClass("editCell");
        $("#password").attr('contenteditable', 'false');
        $("#password").html("<a style=\"color:#828282\" href=\"javascript:addPasswordEdit()\"> Modifica </a>");
    });
    
    $("#saveButton").click(function(){
        
        //salvo i nuovi dati contenuti nella tabella nell'oggetto contact
        
        //$('#preferenza').prop('disabled', true);
        //$('#preferenza').css('color', '#828282');
        //$("#addpreference").prop("disabled",true);        
        contact.first=$("#first").html();
        contact.last=$("#last").html();
        contact.city=$("#city").html();
        contact.mail=$("#mail").html();
        contact.phone=$("#phone").html();
        
        //eseguo query
        if(contact.first.length>0 && contact.last.length>0 && contact.city.length>0 && contact.mail.length>0 && contact.phone.length>0){
            $.ajax({
                type: "POST",
                url: "ajax.php",
                data: contact,
                cache: false,
                success : function(msg)
                {
                    //alert(msg);
                }
            });
        }
        
        //esco dalla modalità edit
        exitEdit();
        
    });
    
    $("#cancelButton").click(function(){
        
        //rimetto i valori precedenti nella tabella
        $("#first").html(contact.first);
        $("#last").html(contact.last);
        $("#city").html(contact.city);
        $("#mail").html(contact.mail);
        $("#phone").html(contact.phone);
        //$("#preference").html(contact.preference);        
        //esco dalla modalità edit
        exitEdit();
    });
    
    function exitEdit(){
        $("#password").html("");
        $("#preference").animate({
            height : $("#preference").height() - $("#HiddenAddBox").height()
        }, 500);
        //blocco la tabella
        $("#myInformations td").attr('contenteditable', 'false').removeClass("editCell");
        
        //spariscono i bottoni save e cancel
        $("#cancelButton").hide();
        $("#saveButton").hide();
        
        //compare bottone edit
        $("#editButton").show();
//        $("span[data-role=\"remove\"]").css("visibility","hidden");
//        $("input[type=\"text\"]").prop("disabled",true);
//        $("#btnaddpref").prop("disabled",true);
//        $("#HiddenAddBox").hide();
//        $("input[type=\"text\"]").keydown(function (){ return false; });

    }
});

function openPreferenceEdit(){
        $("#editButtonpreference").hide();
        $("#cancelButtonpreference").show();
        $("#HiddenAddBox").show("slide");
        $("#addpreference").prop("disabled",false);
        $("span[data-role=\"remove\"]").css("visibility","visible");
        $("#preferenceslist").prop("disabled",false)
}

function closePreferenceEdit(){
    $("#editButtonpreference").show();
    $("#cancelButtonpreference").hide();
    $("span[data-role=\"remove\"]").css("visibility","hidden");
    $("#HiddenAddBox").hide();
}

function addPasswordEdit()
{
    String.prototype.isEmpty = function() {
        return (this.length === 0 || !this.trim());
    };
    
    $("#password").html("<input type=\"hidden\" value=\"0\" id=\"validpassword\"> <input type=\"hidden\" value=\"0\" id=\"validinput\">  \n\
                                      <div class=\"col-xs-6\" style=\"padding:0px\"> <span> Attuale </span> <input for=\"vecchiapassword\" class=\"form-control\" type=\"password\">  \n\
                                      <span> Nuova </span> <input for=\"nuovapassword\" class=\"form-control\" type=\"password\" >\n\
                                      <span> Conferma la nuova </span> <input for=\"confermapassword\" class=\"form-control\" type=\"password\" > <br>\n\
                                      \n\
                                      <input class=\"btn btn-primary leftAlignment\" type=\"button\" value=\"Salva le modifiche\" disabled=\"true\" onclick=\"updatePassword()\">\n\
                                      <input class=\"btn btn-secondary leftAlignment\" style=\"color:#828282\" type=\"button\" value=\"Chiudi\" onclick=\"rollbackToEdit()\">\n\
                                      </div>\n\
                                      <div class=\"col-xs-6\" style=\"padding:0px\" id=\"reportcol\"></div>");
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

