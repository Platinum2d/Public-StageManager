contact = {
    'username' : '',
    'first': '',
    'last': '',
    'city': '',
    'mail': '',
    'phone': '',
    'preference': ''
};

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

$(document).ready(function(){
    initialUsername = $("#username").text();
    $("#cancelButtonpreference").hide();
    $("input[type=\"text\"]").keydown(function (){ return false; });
    contact.username=$("#username").text();
    contact.first=$("#first").text();
    contact.last=$("#last").text();
    contact.city=$("#city").text();
    contact.mail=$("#mail").text();
    contact.phone=$("#phone").text();
    
    $(".edittextdiv").each(function (){
        $(this).height($(this).parents("td").height());
    });
    
    $("#username").keypress(function (e){
        if (e.which === 32) return false;
    });
    
    $("span[data-role=\"remove\"]").hide();
    
    //nascondo i bottoni save e cancel che compaiono solo in modalità edit
    $("#cancelButton").hide();
    $("#saveButton").hide();
    
    $("#editButton").click(function(){
    	
        contact.username=$("#username").text();
        contact.first=$("#first").text();
        contact.last=$("#last").text();
        contact.city=$("#city").text();
        contact.mail=$("#mail").text();
        contact.phone=$("#phone").text();
        
        //faccio sparire il bottone edit
        $("#editButton").hide();
        $("#saveButton").show();
        $("#cancelButton").show();
        turnEditOn();
        $("#password").html("<a style=\"color:#828282\" href=\"javascript:addPasswordEdit()\"> Modifica </a>");
    });
    
    $("#saveButton").click(function(){
        
        //salvo i nuovi dati contenuti nella tabella nell'oggetto contact
        contact.username = $("#username").text();  
        contact.first=$("#first").text();
        contact.last=$("#last").text();
        contact.city=$("#city").text();
        contact.mail=$("#mail").text();
        contact.phone=$("#phone").text();
        
        //eseguo query
        if(contact.first.length>0 && contact.username.length>0 && contact.last.length>0){
            $.ajax({
                type: "POST",
                url: "ajaxOps/save.php",
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
        $("#city").html(contact.city);
        $("#mail").html(contact.mail);
        $("#phone").html(contact.phone);      
        //esco dalla modalità edit
        exitEdit();
    });
    
    initPreferences ();
    
    function exitEdit(){
        $("#password").html("");
        $("#preference").animate({
            height : $("#preference").height() - $("#HiddenAddBox").height()
        }, 500);
        
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
            $("#saveButton").prop("disabled", true);
            $("#username").parent().parent().find("th").html("Informazione obbligatoria");
            $("#username").parent().parent().find("th").css("color", "red");
            return;
        }
        
        if ($("#username").text().toString().trim().length > 50)
        {
            $("#saveButton").prop("disabled", true);
            $("#username").parent().parent().find("th").html("Troppo lungo (max. caratteri: 50)");
            $("#username").parent().parent().find("th").css("color", "red");
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
                    $("#saveButton").prop("disabled", true);
                    $("#username").parent().parent().find("th").html("Username (Esiste già)");
                    $("#username").parent().parent().find("th").css("color", "red");
                }
                else
                {
                    $("#username").parent().parent().find("th").html("Username");
                    $("#username").parent().parent().find("th").css("color", "#828282");
                    if ($("#first").text().toString().trim() !== "" && $("#last").text().toString().trim() !== "")
                    {
                        $("#saveButton").prop("disabled", false);
                    }
                }
            }
        });
    });
    
    $("#first").on("input", function () {
        if ($("#first").text().toString().trim() === "")
        {
            $("#saveButton").prop("disabled", true);
        }
        else {
            if ($("#last").text().toString().trim() !== "" && $("#username").text().toString().trim() !== "")
            {
                $("#saveButton").prop("disabled", false);
            }
        }
    });
    
    $("#last").on("input", function () {
        if ($("#last").text().toString().trim() === "")
        {
            $("#saveButton").prop("disabled", true);
        }
        else {
            if ($("#first").text().toString().trim() !== "" && $("#username").text().toString().trim() !== "")
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

function rollbackToEdit()
{
    $("#password").html("<a style=\"color:#828282\" href=\"javascript:addPasswordEdit()\"> Modifica </a>");
}

function initPreferences () {
    table = $('#preferencesTable');
    tbody = table.find ("tbody");
    newTbody = $("<tbody></tbody>");
    $.ajax({
        type : 'POST',
        url : 'ajaxOps/returnPreferences.php',
        cache : false,
        success : function (xml) {
            $(xml).find("preference").each(function(index, element){
                id = $(element).find("id").text();
                nome = $(element).find("name").text();
                priorita = $(element).find("priority").text();
				
                newTbody.append("<tr data-id='"+id+"'></tr>");
                tr = newTbody.find("tr:last");
                tr.append("<td>"+ nome +"</td>");
                if (priorita == "1") {
                    tr.append("<td class='centeredText'><image class='star-priority' data-star='1' src='../../../media/img/star_colored.png'/></td>");
                }
                else {
                    tr.append("<td class='centeredText'><image class='star-priority' data-star='0' src='../../../media/img/star_blank.png'/></td>");
                }
                tr.append("<td class='centeredText'><button class='btn btn-danger' onclick='removePreference ("+id+");'><span class='glyphicon glyphicon-trash'></span>  Elimina</button></td>"); //aggiungere cestino per rimuovere preferenza
            })
            tbody.remove();
            table.append(newTbody);  	
        },
        error : function () {
            printError ("Errore", "Impossibile inizializzare la tabella.");
        },
        complete : function () {
            $('.star-priority').mouseenter (function () {
            	if ($(this).data("star") == "0") {
                    $(this).attr ("src", "../../../media/img/star_colored.png");
            	}
            	else if ($(this).data("star") == "1") {
                    $(this).attr ("src", "../../../media/img/star_blank.png");
            	}
            });
            
            $(".star-priority").mouseleave (function () {
            	if ($(this).data("star") == "0") {
                    $(this).attr ("src", "../../../media/img/star_blank.png");
            	}
            	else if ($(this).data("star") == "1") {
                    $(this).attr ("src", "../../../media/img/star_colored.png");
            	}
            });
            
            $(".star-priority").click (function () {
            	star = $(this);
            	if (star.data("star") == "0") {
                    id_preferenza = star.closest("tr").data("id");

                    $.ajax({
            	        type : 'POST',
            	        url : 'ajaxOps/addPriority.php',
            	        data : {
                            'preferenza' : id_preferenza
            	        },
            	        cache : false,
            	        success : function (msg) {
                            if (msg !== "ok") {
                                printError ("Errore", "Impossibile modificare la priorità");
                            }
                            else {
                                $(".star-priority").attr ("src", "../../../media/img/star_blank.png").data("star", "0");
                                star.attr ("src", "../../../media/img/star_colored.png");
                                star.data("star", "1");
                            }
            	        }
            	    });
            	}
            	else if (star.data("star") == "1") {
                    id_preferenza = star.closest("tr").data("id");

                    $.ajax({
            	        type : 'POST',
            	        url : 'ajaxOps/removePriority.php',
            	        data : {
                            'preferenza' : id_preferenza
            	        },
            	        cache : false,
            	        success : function (msg) {
                            if (msg !== "ok") {
                                printError ("Errore", "Impossibile modificare la priorità");
                            }
                            else {
                                star.attr ("src", "../../../media/img/star_blank.png");
                                star.data("star", "0");
                            }
            	        }
            	    });
            	}
            });
        }
    });	
}

function addPreference () {
    id_figura = $("#selectFigura").val();
    $.ajax({
        type : 'POST',
        url : 'ajaxOps/ajaxAddPreference.php',
        data : {
            'preferenza' : id_figura
        },
        cache : false,
        success : function (msg) {
            if (msg == "ok") {
                $('#selectFigura').find(":selected").remove();
                initPreferences ();
            }
            else {
                printError ("Errore", "Impossibile aggiungere questa figura professionale");
            }
        }
    });	
}

function removePreference (id_preferenza) {
    $.ajax({
        type : 'POST',
        url : 'ajaxOps/returnFigure.php',
        data : {
            'preferenza' : id_preferenza
        },
        cache : false,
        success : function (xml) {
            status = $(xml).find("status").text();
            if (status == "1") {
            	id_figura = $(xml).find("id").text();
            	nome_figura = $(xml).find("nome").text();
                $.ajax({
                    type : 'POST',
                    url : 'ajaxOps/ajaxRemovePreference.php',
                    data : {
                        'preferenza' : id_preferenza
                    },
                    cache : false,
                    success : function (msg) {
                        if (msg == "ok") {
                            initPreferences ();
                            $("#selectFigura").append("<option value='"+id_figura+"'>"+nome_figura+"</option>");
                        }
                        else {
                            printError ("Errore", "Impossibile rimuovere questa figura professionale");
                        }
                    },
                    error : function () {
                        printError ("Errore", "Impossibile rimuovere questa figura professionale");
                    }
                });	
            }
            else {
                printError ("Errore", "Impossibile rimuovere questa figura professionale");
            }
        },
        error : function () {
            printError ("Errore", "Impossibile rimuovere questa figura professionale");
        }
    });	
}
