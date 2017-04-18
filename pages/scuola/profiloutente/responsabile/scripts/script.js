reponsabile = {
    'first': '',
    'cognome': '',
    'mail': '',
    'phone' : ''
};

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
	
    reponsabile.cognome=$("#cognome").html();
    reponsabile.first=$("#first").html();
    reponsabile.mail=$("#mail").html();
    reponsabile.phone=$("#phone").html();
    
    //nascondo i bottoni save e cancel che compaiono solo in modalità edit
    $("#cancelButton").hide();
    $("#saveButton").hide();
	
    $("#editButton").click(function(){
    	
        reponsabile.cognome=$("#cognome").html();
        reponsabile.first=$("#first").html();
        reponsabile.mail=$("#mail").html();
        reponsabile.phone=$("#phone").html();
		
        //faccio sparire il bottone edit
        $("#editButton").hide();
		
        //faccio comprarire i bottoni save e cancel
        $("#saveButton").show();
        $("#cancelButton").show();
		
        //rendo al tabella editabile
        turnEditOn();
    });
	
    $("#saveButton").click(function(){

        //salvo i nuovi dati contenuti nella tabella nell'oggetto contact
        reponsabile.cognome=$("#cognome").html();
        reponsabile.first=$("#first").html();
        reponsabile.mail=$("#mail").html();
        reponsabile.phone=$("#phone").html();
		
        $.ajax({
            type: "POST",
            url: "ajaxOpsPerResponsabile/ajaxInvia.php",
            data: reponsabile,
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
    });

    $("#cancelButton").click(function(){
		
        //rimetto i valori precedenti nella tabella
        $("#first").html(reponsabile.first);
        $("#mail").html(reponsabile.mail);
        $("#phone").html(reponsabile.phone);
        $("#cognome").html(reponsabile.cognome);
		
        //esco dalla modalità edit
        exitEdit();
    });
	
    function exitEdit(){

        //blocco la tabella
        turnEditOff();
		
        //spariscono i bottoni save e cancel
        $("#cancelButton").hide();
        $("#saveButton").prop("disabled", false);
        $("#saveButton").hide();
		
        //compare bottone edit
        $("#editButton").show();
                
    }
});

