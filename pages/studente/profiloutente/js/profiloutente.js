contact = {
    'first': '',
    'last': '',
    'city': '',
    'mail': '',
    'phone': '',
    'preference': ''
};

$(document).ready(function(){
    contact.first=$("#first").html();
    contact.last=$("#last").html();
    contact.city=$("#city").html();
    contact.mail=$("#mail").html();
    contact.phone=$("#phone").html();
    
    //nascondo i bottoni save e cancel che compaiono solo in modalità edit
    $("#cancelButton").hide();
    $("#saveButton").hide();
    
    $("#editButton").click(function(){
        
        //faccio sparire il bottone edit
        $("#editButton").hide();
        $("#saveButton").show();
        $("#cancelButton").show();
        $("#myInformations td").attr('contenteditable', 'true').addClass("editCell");
        $("#password").attr('contenteditable', 'false');
        $("#password").html("<a style=\"color:#828282\" href=\"javascript:addPasswordEdit()\"> Modifica </a>");
    });
    
    $("#saveButton").click(function(){
        
        //salvo i nuovi dati contenuti nella tabella nell'oggetto contact
          
        contact.first=$("#first").html();
        contact.last=$("#last").html();
        contact.city=$("#city").html();
        contact.mail=$("#mail").html();
        contact.phone=$("#phone").html();

        //eseguo query
        if(contact.first.length>0 && contact.last.length>0 && contact.city.length>0 && contact.mail.length>0 && contact.phone.length>0){
            $.ajax({
                type: "POST",
                url: "ajaxOps/save.php",
                data: contact,
                cache: false,
                success : function(msg)
                {
//                    alert(msg);
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
        $("#myInformations td").attr('contenteditable', 'false').removeClass("editCell");
        
        //spariscono i bottoni save e cancel
        $("#cancelButton").hide();
        $("#saveButton").hide();
        
        //compare bottone edit
        $("#editButton").show();
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

/*    $('#preferenza').prop('disabled', true);
    $('#preferenza').css('color', '#828282');
    $('#preferenceslist').on('itemRemoved', function (event){
        $.ajax({
            type : 'POST',
            url : 'ajaxOps/ajaxRemovePreference.php',
            data : { 'preferenza' : event.item },
            cache : false,
            success : function (msg)
            {
                if (msg !== "ok")
                    alert("Eliminazione della preferenza non riuscita!");
            }
        });
    });
    
    $("#btnaddpref").click(function () {
        var toadd = $( "#addpreference option:selected" ).text();
        var current = $( "#preferenceslist" ).val();
        
        if (current.indexOf(toadd.trim()) === -1)
        {
            $('#preferenceslist').tagsinput('add', $( "#addpreference option:selected" ).text());                                        
            $.ajax({
                type : 'POST',
                url : 'ajaxOps/ajaxAddPreference.php',
                data : { 'preferenza' : $( "#addpreference" ).val() },
                cache : false,
                success : function (msg)
                {
                    if (msg !== "ok")
                        alert("Inserimento della preferenza non riuscita!");
                }
            });
        }
    });
    $("#HiddenAddBox").hide();

	function openPreferenceEdit(){
	        $("#editButtonpreference").hide();
	        $("#cancelButtonpreference").show();
	        $("#HiddenAddBox").show("slide");
	        $("#addpreference").prop("disabled",false);
	        $("span[data-role=\"remove\"]").fadeIn("slow")
	        $("#preferenceslist").prop("disabled",false)
	}
	
	function closePreferenceEdit(){
	    $("#editButtonpreference").show();
	    $("#cancelButtonpreference").hide();
	    $("span[data-role=\"remove\"]").fadeOut("slow")
	    $("#HiddenAddBox").hide();
	}*/
});

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
				
				newTbody.append("<tr></tr>");
				tr = newTbody.find("tr:last");
				//tr.data("id", id);
				tr.append("<td>"+ nome +"</td>");
				tr.append("<td class='centeredText'>" + priorita + "</td>"); //stampare stella al posto di 1 o 0
				tr.append("<td class='centeredText'><button class='btn btn-danger' onclick='removePreference ("+id+");'><span class='glyphicon glyphicon-trash'></span>  Elimina</button></td>"); //aggiungere cestino per rimuovere preferenza
			})
			tbody.remove();
			table.append(newTbody);  	
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
        	        		printError ("Errore", "Impossibile rimuovere questa figura professionale1");
        	        	}
        	        },
        	        error : function () {
        	        	printError ("Errore", "Impossibile rimuovere questa figura professionale2");
        	        }
        	    });	
        	}
        	else {
        		alert (xml);
        		printError ("Errore", "Impossibile rimuovere questa figura professionale3");
        	}
        },
        error : function () {
        	printError ("Errore", "Impossibile rimuovere questa figura professionale4");
        }
    });	
}