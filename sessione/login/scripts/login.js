function sendAgree(){    
    user= $("#username").val();
    password=$("#password").val();
    url = "sessione/login/ajaxOps/agree.php";
    
    $.ajax({
        type: 'POST',   
        url: url,   
        data: {
            'user':user, 
            'password':password
        },
        success: function(xml){
        	alert (xml);
            if(dati_corretti === '0') {
            	wrongInformation ();
            }
            else {
            	stato = $(xml).find("stato").text();
            	if (stato === '1') {
                	tipo = $(xml).find("tipo").text();
            		openProfile (tipo);
            	}
            	else if (stato === '0') {	
            		printError ("Errore", "Problemi di comunicazione col server.");
            	}
            	else {
            		printError ("Errore", "Errore non previsto.");
            		
            	}
            }
        },
        error: function () {        	
    		printError ("Errore", "Problema di origine sconosciuta.");
        }
    });
}

function openProfile (tipo) {
	if(tipo==='0') //Super User
    {
        location.href = ((location.href.indexOf("/pages/login/index.php") > 0)) ? "../super_user/profiloutente/index.php" : "pages/super_user/profiloutente/index.php";
    }
    else
    {
        if(tipo==='1') //Scuola
        {
            location.href = ((location.href.indexOf("/pages/login/index.php") > 0)) ? "../scuola/profiloutente/index.php" : "pages/scuola/profiloutente/index.php";
        }
        else
        {      
            if(tipo==='2') //Docente referente
            {
                location.href = ((location.href.indexOf("/pages/login/index.php") > 0)) ? "../docente_referente/profiloutente/index.php" : "pages/docente_referente/profiloutente/index.php";
            }
            else
            {
                if(tipo==='3') //Docente tutor
                {
                    location.href = ((location.href.indexOf("/pages/login/index.php") > 0)) ? "../docente_tutor/profiloutente/index.php" : "pages/docente_tutor/profiloutente/index.php";
                    
                }   
                else
                {
                    if(tipo==='4') //Responsabile impresa
                    {
                        location.href = ((location.href.indexOf("/pages/login/index.php") > 0)) ? "../ceo/profiloutente/index.php" : "pages/ceo/profiloutente/index.php";
                    }
                    else
                    {
                        if(tipo==='5') //Tutor aziendale
                        {
                            location.href = ((location.href.indexOf("/pages/login/index.php") > 0)) ? "../tutor/profiloutente/index.php" : "pages/tutor/profiloutente/index.php";
                        }
                        else
                        {
                            if(tipo==='6') //Studente
                            {
                                location.href = ((location.href.indexOf("/pages/login/index.php") > 0)) ? "../studente/profiloutente/index.php" : "pages/studente/profiloutente/index.php";
                            }
                        }
                    }
                }
            }
        }
    }
}

function wrongInformation () {
    $("#error").remove();
    $("#login-text").html("<p id='error'>Utente e/o password sbagliati.</p>"); 
    error.style.color="red";
    error.style.fontSize="medium";
    $("#password").val("");
}

function check_login(){
    $("#error").remove();
    user= $("#username").val();
    password=$("#password").val();
    url = "sessione/login/ajaxOps/login.php";
    
    $.ajax({
        type: 'POST',   
        url: url,   
        data: {
            'user':user, 
            'password':password
        },
        success: function(xml){
            dati_corretti = $(xml).find("dati_corretti").text();
            if(dati_corretti === '0') {
            	wrongInformation ();
            }
            else {
            	trattamento_dati = $(xml).find("trattamento_dati").text();
            	if (trattamento_dati === '0') {

            	    $("#SuperAlert").modal("show");
            	    $("#SuperAlert").find(".modal-title").html("Richiesta per il trattamento dei dati personali");            	    
            	    $("#SuperAlert").find(".modal-body").html("<b>Per accedere ed utilizzare la piattagorma è necessario acconsentire " +
            	    											"il trattamento dei propri dati personali. Tale autorizzazione verrà" +
            	    											" utilizziata al solo scopo di fornire in modo ottimale i servizi proposti.</b>");
            	    $("#SuperAlert").find(".modal-footer").prepend ("<button id='buttonAgree' type='button' class='btn btn-success' onclick='sendAgree ();'>Acconsento</button>");
            	    $("#SuperAlert").find(".modal-body").css("background-color", "#B9D3F6");
            	    
                	$("#SuperAlert").on('hidden.bs.modal', function () {
                		$("#buttonAgree").remove ();
                	});
            	}
            	else {
            		tipo = $(xml).find("tipo").text();
	                openProfile (tipo);
            	}
            }
        }
    });
}