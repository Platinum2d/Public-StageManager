function check_login(){    
    var user= $("#username").val();
    var password=$("#password").val();
    var url = "sessione/login/ajaxOps/login.php";
    
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
                $("#error").remove();
                $("#login-text").html("<p id='error'>Utente e/o password sbagliati.</p>"); 
                error.style.color="red";
                error.style.fontSize="medium";
                $("#password").val("");
            }
            else {
            	trattamento_dati = $(xml).find("trattamento_dati").text();
            	if (trattamento_dati === '0') {
            		//stampare richiesta trattamento dati
            	}
            	else {
            		tipo = $(xml).find("tipo").text();
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
            }
        }
    });
}