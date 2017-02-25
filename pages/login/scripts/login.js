function check_login(){    
    var user= $("#username").val();
    var password=$("#password").val();
    var url = "";
    
    url = (location.href.indexOf("/pages/login/index.php") > 0) ? "login.php" : "pages/login/login.php";
    
    $.ajax({
        type: 'POST',   
        url: url,   
        data: {
            'user':user, 
            'password':password
        },
        success: function(xml){
            var tipo = $(xml).find("tipo").text(); //tipo contiene il tipo di utente loggato, è uguale a 0 se non loggato
            if(tipo==='-1')
            {
                $("#error").remove();
                $("#login-text").html("<p id='error'>Utente e/o password sbagliati.</p>"); 
                error.style.color="red";
                error.style.fontSize="medium";
                $("#password").val("");
            }
            else{
                localStorage.removeItem("dialogconst");
                localStorage.removeItem("openedChat");
                localStorage.removeItem("chatCode");
                
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
    });
}