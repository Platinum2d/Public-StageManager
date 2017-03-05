docente = {
    'username': '',
    'password': '',
    'confermaPassword': '',
    'nome': '',
    'cognome': '',
    'telefono': '',
    'email': '',
    'isDocenteTutor': false,
    'isDocenteReferente': false        
};

azienda = {
    'username' : '',
    'password' : '',
    'confermaPassword': '',
    'nome' : '',
    'citta' : '',
    'CAP' : '',
    'indirizzo' : '',
    'telefono' : '',
    'email' : '',
    'sito' : '',
    'nomeresponsabile' : '',
    'cognomeresponsabile' : '',
    'telefonoresponsabile' : '',
    'emailresponsabile' : ''    
};

studente = {
    'username':'',
    'password':'',
    'confermaPassword':'',
    'nome':'',
    'cognome':'',
    'citta':'',
    'mail':'',
    'telefono':'',
    'scuola' : '',
    'classe':'',
    'stage':'',
    'annoclasse':''
};

classe = {
    'nome' : '',
    'scuola' : '',
    //    'stage' : '',
    'settore' : ''
    //    'anno' : ''
};

specializzazione = {
    'nome' : ''    
};

tutor = {
    'username':'',
    'password':'',
    'confermaPassword':'',
    'nome':'',
    'cognome':'',
    'telefono':'',
    'email':'',
    'azienda' : ''
};

preferenza = {
    'nome':''
};

scuola = {
    'username':'',
    'password':'',
    'confermaPassword':'',
    'nome':'',
    'citta':'',
    'CAP':'',
    'indirizzo':'',
    'telefono' : '',
    'email':'',
    'sito' : ''
};

annoscolastico = {
    'nome' : '',
    'corrente' : 'false'
};

figuraprofessionale = {
    'nome' : '',
    'settore' : ''
};

stage = {
    'inizio' : '',
    'durata' : '0'
};

settore = {
    'nomesettore' : '',
    'indirizzostudi' : ''    
};

function addDatePickerInInzioStage()
{
    $("#inizioStageStudente").datepicker({ dateFormat: 'dd-mm-yy' });
}

function uncheckTheOtherCheckBox(CheckBox)
{
    if (CheckBox === 'docenteTutor') $('#isDocenteReferente').attr('checked','false');
    else $('#isDocenteTutor').attr('checked','false');
}

function freeFieldsFor(userType)
{
    switch (userType)
    {
        case 'docente':
            $("#UsernameDocente").val('');
            $("#PasswordDocente").val('');
            $("#ConfermaPasswordDocente").val('');
            $("#NomeDocente").val('');
            $("#CognomeDocente").val('');
            $("#TelefonoDocente").val('');
            $("#EmailDocente").val('');
            $('#isDocenteTutor').val('');
            $('#isDocenteReferente').val('');
            break;
        
        case 'azienda':
            $("#UsernameAzienda").val('');
            $("#PasswordAzienda").val('');
            $("#ConfermaPasswordAzienda").val('');
            $("#NomeAzienda").val('');
            $("#CittaAzienda").val('');  
            $("#CAPAzienda").val('');
            $("#IndirizzoAzienda").val('');
            $("#TelefonoAzienda").val('');
            $("#MailAzienda").val('');
            $("#SitoAzienda").val('');
            $("#NomeResponsabileAzienda").val('');
            $("#CognomeResponsabileAzienda").val('');
            $("#TelefonoResponsabileAzienda").val('');
            $("#MailResponsabileAzienda").val('');
            break;
        
        case 'classe':
            $("#nomeClasse").val('');
            break;
        
        case 'specializzazione':
            $("#nomespecializzazione").val('');
            break;
        
        case 'studente':
            $("#usernameStudente").val('');
            $("#passwordStudente").val('');
            $("#confermaPasswordStudente").val('');
            $("#nomeStudente").val('');
            $("#cognomeStudente").val('');
            $("#cittaStudente").val('');
            $("#mailStudente").val('');
            $("#telefonoStudente").val('');
            $("#inizioStageStudente").val('');
            $("#durataStageStudente").val('');       
            //            $("#aziendaStudente").val('');
            //            $("#docenteStudente").val('');
            //            $("#tutorStudente").val('');            
            break;
        
        case 'tutor':
            $("#usernameTutor").val('');
            $("#passwordTutor").val('');
            $("#confermaPasswordTutor").val('');
            $("#nomeTutor").val('');
            $("#cognomeTutor").val('');
            $("#telefonoTutor").val('');
            $("#emailTutor").val('');
            $("#aziendaTutor").val('');
            break;
        
        case 'preferenza':
            $("#nomepreferenza").val('');
            break;
        
        case 'scuola':
            $("#usernameScuola").val('');
            $("#passwordScuola").val('');
            $("#confermapasswordScuola").val('');
            $("#nomeScuola").val('');
            $("#cittaScuola").val('');
            $("#CAPScuola").val('');
            $("#indirizzoScuola").val('');
            $("#telefonoScuola").val('');
            $("#emailScuola").val('');
            $("#sitoScuola").val('');
            break;
        
        case 'annoscolastico':
            $("#nomeAnno").val('');
            $("#currentyear").prop("checked", false);
            break;
        
        case 'figuraprofessionale':
            $("#nomeFigura").val('');
            break;
        
        case 'stage':
            $("#inizioStage").val('');
            $("#durataStage").val('');
            break;
        
        case 'settore':
            $("#indirizzoStudi").val('');
            $("#nomeSettore").val('');
            break;
        
    }
}

function addSelectionsFor(page, field)
{
    switch (page)
    {
        case 'studente':
            switch (field)
            {
                case 'anno_scolastico':
                    $.ajax({
                        url : "ajaxOpsPerStudente/ajaxAnnoScolastico.php",
                        cache : false,
                        success : function(xml)
                        {
                            $(xml).find("anni").find("anno").each(function (){
                                $("#annoclasseStudente").append("<option value=\""+$(this).find("id").text()+"\"> "+$(this).find("nome").text()+" </option>");
                            });
                        }
                    });
                    break;
                
                case 'scuola':
                    $.ajax({
                        url : '../studenti/ajaxOpsPerStudente/ajaxScuola.php',
                        cache : false,
                        success : function (xml)
                        {
                            var selectedindex = 0+$("#classeStudente").prop('selectedIndex');
                            $('#classeStudente').html('');
                            $(xml).find('scuole').find("scuola").each(function()
                            {
                                $('#scuolaStudente').append("<option value=\""+$(this).find("id").text()+"\"> "+$(this).find("nome").text()+" </option>");
                            });
                            addSelectionsFor('studente', 'classe');
                        }
                    });
                    break;
                
                case 'classe':
                    $.ajax({
                        type : 'POST',
                        url : '../studenti/ajaxOpsPerStudente/ajaxClasse.php',
                        cache : false,
                        data : { 'scuola' : $('#scuolaStudente').val() },
                        success : function (xml)
                        {
                            var selectedindex = 0+$("#classeStudente").prop('selectedIndex');
                            $('#classeStudente').html('');
                            $(xml).find('classi').find("classe").each(function()
                            {
                                $('#classeStudente').append("<option value=\""+$(this).find("id").text()+"\"> "+$(this).find("nome").text()+"</option>");
                            });
                        }
                    });
                    break;
                
                case 'azienda':
                    if(!$('#aziendaStudente').is(':focus'))
                    {
                        $.ajax({
                            url : '../studenti/ajaxOpsPerStudente/ajaxAzienda.php',
                            cache : false,
                            success : function (xml)
                            {
                                $('#aziendaStudente').html('<option value="-1"> </option>');
                                $('#keepIdAzienda').html('');
                                $(xml).find('aziende').find('azienda').each(function()
                                {
                                    currentid = $(this).find('id').text(); 
                                    $('#keepIdAzienda').append('<option> '+currentid+'</option>');                                    
                                    currentAzienda = $(this).find('nome').text();
                                    $('#aziendaStudente').append('<option value="'+currentid+'"> '+currentAzienda+'</option>');
                                });
                            }
                        });
                    }
                    break;
                
                case 'tutor':
                    miaazienda = {'idAzienda' : $("#aziendaStudente").val()};
                    if ($("#aziendaStudente").val() !== "-1")
                    {
                        $.ajax({
                            type : 'POST',
                            data : miaazienda,
                            url : '../studenti/ajaxOpsPerStudente/ajaxTutor.php',
                            cache : false,
                            success : function (xml)
                            {                                
                                $('#tutorStudente').html('<option value="-1"> </option>');
                                $('#tutorStudente').css("color", "#555");
                                $(xml).find('tutors').find('tutor').each(function()
                                {
                                    currentid = $(this).find('id').text(); 
                                    currentnome = $(this).find('nome').text(); 
                                    currentcognome = $(this).find('cognome').text();
                                    $('#tutorStudente').append('<option value="'+currentid+'"> '+currentcognome+' '+currentnome+'</option>');                                
                                });
                            }
                        });
                    }
                    else
                    {
                        $('#tutorStudente').html('<option value="-1"> Selezionare una azienda.... </option>');
                        $('#tutorStudente').css("color", "#D3D3D3");
                    }
                    break;
                
                case 'docente':
                    $.ajax({
                        url : '../studenti/ajaxOpsPerStudente/ajaxDocente.php',
                        cache : false,
                        success : function (xml)
                        {
                            if(!$('#docenteStudente').is(':focus'))
                            {
                                $('#docenteStudente').html('<option value="-1"> </option>');
                                $(xml).find('docenti').find('docente').each(function()
                                {
                                    currentid = $(this).find("id").text();
                                    currentUsername = $(this).find("username").text();
                                    currentNome = $(this).find("nome").text();
                                    currentCognome = $(this).find("cognome").text();
                                    $('#docenteStudente').append('<option value="'+currentid+'"> '+currentCognome+' '+currentNome+'</option>'); 
                                });
                            }
                        }
                    });
                    break;
            }
            break;
        
        case 'classe':
            switch (field)
            {
                case 'specializzazione':                    
                    if(!$('#SpecializzazioneClasse').is(':focus'))
                    {
                        $.ajax({
                            url : "../classi/ajaxOpsPerClasse/ajaxSpecializzazioni.php",
                            cache : false,
                            success : function(xml)
                            {
                                $("#SpecializzazioneClasse").html("<option> </option>");
                                $(xml).find('specializzazione').each(function() {
                                    $("#SpecializzazioneClasse").append("<option> "+$(this).text()+" </option>");
                                });
                            }
                        });
                    }
                    break;
                
                case 'scuola':
                    $.ajax({
                        url : "ajaxOpsPerClasse/ajaxScuola.php",
                        cache : false,
                        success : function(xml)
                        {
                            $(xml).find("scuole").find("scuola").each(function (){
                                $("#scuolaClasse").append("<option value=\""+$(this).find("id").text()+"\"> "+$(this).find("nome").text()+" </option>");
                            });
                        }
                    });
                    break;
                
                
                case 'settore':
                    $.ajax({
                        url : "ajaxOpsPerClasse/ajaxSettore.php",
                        cache : false,
                        success : function(xml)
                        {
                            $(xml).find("settori").find("settore").each(function (){
                                $("#settoreClasse").append("<option value=\""+$(this).find("id").text()+"\"> "+$(this).find("indirizzo").text()+" - "+$(this).find("nome").text()+" </option>");
                            });
                        }
                    });
                    break;
            }
            break;
        
        case 'tutor':
            switch(field)
            {
                case 'azienda':
                    $.ajax({
                        type : 'POST',
                        url : '../tutor/ajaxOpsPerTutor/ajaxAzienda.php',
                        cache : false,
                        success : function (xml)
                        {
                            $('#aziendaTutor').html('<option value="-1"></option>');
                            $(xml).find('aziende').find('azienda').each(function()
                            {                                
                                currentAzienda = $(this).find('nome').text();
                                $('#aziendaTutor').append("<option value="+$(this).find('id').text()+"> "+currentAzienda+" </option>");
                            });
                        }
                    });
                    break;
            }
            break;
    }
}

function sendSingleData(userType)
{
    switch(userType)
    {
        case 'docente':
            String.prototype.isEmpty = function() {
                return (this.length === 0 || !this.trim());
            };      
            
            docente.password = ''+$("#PasswordDocente").val();
            docente.confermaPassword = ''+$("#ConfermaPasswordDocente").val();                        
            docente.username = ''+$("#UsernameDocente").val().trim();
            docente.nome = ''+$("#NomeDocente").val().trim();
            docente.cognome = ''+$("#CognomeDocente").val().trim();
            docente.telefono = ''+$("#TelefonoDocente").val().trim();
            docente.email = ''+$("#EmailDocente").val().trim();
            docente.isDocenteTutor = $('#isDocenteTutor').is(':checked');
            docente.isDocenteReferente = $('#isDocenteReferente').is(':checked');
            var NoCheckBoxSelected = false;
            if (!$('#isDocenteTutor').is(':checked') && !$('#isDocenteReferente').is(':checked'))
                NoCheckBoxSelected = true;        
            
            if (docente.username.isEmpty() || docente.password.isEmpty() || docente.nome.isEmpty() || docente.cognome.isEmpty() || docente.telefono.isEmpty() || docente.email.isEmpty() || NoCheckBoxSelected)
            {
                alert("Si prega di compilare i cambi obbligatori");
                return;
            }
            else
            {
                if (docente.password.trim() !== docente.confermaPassword.trim() || docente.password.length < 8)
                {
                    alert("errore nell'inserimento della password");
                    return;
                }
                
                $.ajax({
                    type: "POST",
                    url: "../docenti/ajaxOps/ajaxDocente.php",
                    data : docente,
                    cache: false,
                    success: function(msg)
                    {
                        if (msg === "Inserimento dei dati riuscito!")
                            freeFieldsFor('docente');
                    }
                });
            }
            break;
        
        case 'azienda':
            String.prototype.isEmpty = function() {
                return (this.length === 0 || !this.trim());
            }; 
            
            azienda.username = ''+$('#UsernameAzienda').val().trim();
            azienda.password = ''+$('#PasswordAzienda').val().trim();
            azienda.confermaPassword = ''+$("#ConfermaPasswordAzienda").val().trim();            
            azienda.nome = ''+$('#NomeAzienda').val().trim();
            azienda.citta = ''+$('#CittaAzienda').val().trim();
            azienda.CAP = ''+$('#CAPAzienda').val().trim();
            azienda.indirizzo = ''+$('#IndirizzoAzienda').val().trim();
            if (azienda.username.isEmpty() || azienda.password.isEmpty() || azienda.nome.isEmpty() || azienda.citta.isEmpty() || azienda.indirizzo.isEmpty())
            {
                alert("Si prega di compilare i cambi obbligatori");
                return;
            }
            
            if (azienda.password.trim() !== azienda.confermaPassword.trim() || azienda.password.length < 8)
            {
                alert("errore nell'inserimento della password");
                return;
            }
            
            azienda.telefono = ''+$('#TelefonoAzienda').val();
            if (azienda.telefono.isEmpty()) azienda.telefono = ' ';
            
            azienda.email = ''+$('#MailAzienda').val();
            if (azienda.email.isEmpty()) azienda.email = ' ';
            
            azienda.sito = ''+$('#SitoAzienda').val();
            if (azienda.sito.isEmpty()) azienda.sito = ' ';
            
            azienda.nomeresponsabile = ''+$('#NomeResponsabileAzienda').val();
            if (azienda.nomeresponsabile.isEmpty()) azienda.nomeresponsabile = ' ';
            
            azienda.cognomeresponsabile = ''+$('#CognomeResponsabileAzienda').val();
            if (azienda.cognomeresponsabile.isEmpty() || azienda.cognomeresponsabile === 'undefined') azienda.cognomeresponsabile = ' ';
            
            azienda.telefonoresponsabile = ''+$('#TelefonoResponsabileAzienda').val();
            if (azienda.telefonoresponsabile.isEmpty()) azienda.telefonoresponsabile = ' ';
            
            azienda.emailresponsabile = ''+$('#MailResponsabileAzienda').val();
            if (azienda.emailresponsabile.isEmpty()) azienda.emailresponsabile = ' ';
            
            $.ajax({
                type : 'POST',
                url : '../aziende/ajaxOpsPerAzienda/ajaxInvia.php',
                data : azienda,
                cache : false,
                success: function(msg)
                {
                    if (msg === "Inserimento dei dati riuscito!")
                        freeFieldsFor('azienda');
                }
            });
            break;
        
        case 'studente':
            
            String.prototype.isEmpty = function() {
                return (this.length === 0 || !this.trim());
            };    
            
            studente.password = $('#passwordStudente').val().trim();
            studente.confermaPassword = $('#confermaPasswordStudente').val().trim();
            studente.username = $('#usernameStudente').val().trim();
            studente.nome = $('#nomeStudente').val().trim();
            studente.cognome = $('#cognomeStudente').val().trim();
            studente.citta = $('#cittaStudente').val().trim();
            studente.mail = $('#mailStudente').val().trim();
            studente.telefono = $('#telefonoStudente').val().trim();
            studente.classe = $('#classeStudente').val();
            studente.scuola = $('#scuolaStudente').val();
            studente.annoclasse = $("#annoclasseStudente").val();
            
            if (studente.username.isEmpty() || studente.nome.isEmpty() || studente.cognome.isEmpty() || studente.citta.isEmpty() || studente.mail.isEmpty() || studente.telefono.isEmpty() || studente.classe.isEmpty() || studente.scuola.isEmpty())
            {
                alert("Si prega di compilare i cambi obbligatori");
                return;
            }
            if(!studente.password || studente.password !== studente.confermaPassword || studente.password < 8)
            {
                alert("errore nell'inserimento della password");
                return;
            }
            
            $.ajax({
                type : "POST",
                url :  "../studenti/ajaxOpsPerStudente/ajaxInvia.php",
                data : studente,
                cache : false,
                success : function(msg)
                {
                    if (msg === "ok")
                        freeFieldsFor('studente');
                }                
            });
            break;
        
        case 'classe':            
            String.prototype.isEmpty = function() {
                return (this.length === 0 || !this.trim());
            };   
            classe.nome = $("#nomeClasse").val().trim();
            classe.scuola = $("#scuolaClasse").val();
            classe.settore = $("#settoreClasse").val();
            
            if (classe.nome.isEmpty())
            {
                alert("Si prega di compilare i campi obbligatori");
                return;
            }
            
            $.ajax({
                type : "POST",
                url : "../classi/ajaxOpsPerClasse/ajaxInvia.php",
                data : classe,
                success : function(msg)
                {
                    if (msg === "Inserimento dei dati riuscito!")
                        freeFieldsFor('classe');
                }
            });
            break;
        
        case 'specializzazione':
            String.prototype.isEmpty = function() {
                return (this.length === 0 || !this.trim());
            };    
            
            specializzazione.nome = $("#nomespecializzazione").val().trim();
            if (specializzazione.nome.isEmpty())
            {
                alert("si prega di compilare i campi obbligatori");
                return;
            }
            
            $.ajax({
                type : 'POST',
                url : '../specializzazioni/ajaxOpsPerSpecializzazione/ajaxInvia.php',
                cache : false,
                data : specializzazione,
                success : function(msg)
                {
                    if (msg === "Inserimento dei dati riuscito!")
                        freeFieldsFor('specializzazione');
                }                
            });
            break;
        
        case 'tutor':
            String.prototype.isEmpty = function() {
                return (this.length === 0 || !this.trim());
            };             
            
            tutor.password = $("#passwordTutor").val().trim();
            tutor.confermaPassword = $("#confermaPasswordTutor").val().trim();            
            tutor.username = $("#usernameTutor").val().trim();
            tutor.nome = $("#nomeTutor").val().trim();
            tutor.cognome = $("#cognomeTutor").val().trim();
            tutor.telefono = $("#telefonoTutor").val().trim();
            tutor.email = $("#emailTutor").val().trim();
            tutor.azienda = $("#aziendaTutor").val().trim();
            
            if (tutor.username.isEmpty() || tutor.nome.isEmpty() || tutor.cognome.isEmpty() || tutor.telefono.isEmpty() || tutor.email.isEmpty())
            {
                alert("si prega di inserire i campi obbligatori");
                return;
            }            
            if (tutor.password !== tutor.confermaPassword || tutor.password.isEmpty() || tutor.password < 8)
            {
                alert("errore nell'inserimento della password");
                return;
            }
            
            $.ajax({
                type : 'POST', 
                url : '../tutor/ajaxOpsPerTutor/ajaxInvia.php',
                cache : false,
                data : tutor,
                success : function(msg)
                {
                    if (msg === "Inserimento dei dati riuscito!")
                        freeFieldsFor('tutor');
                }
            });
            
            break;
        
        case 'preferenza':
            String.prototype.isEmpty = function() {
                return (this.length === 0 || !this.trim());
            };   
            
            preferenza.nome = $("#nomepreferenza").val();
            if (preferenza.nome.isEmpty())
            {
                alert("si prega di compilare i campi obbligatori");
                return;
            }
            else
            {
                $.ajax({
                    type : 'POST',
                    url :  '../preferenze/ajaxOpsPerPreferenza/ajaxInvia.php',
                    cache : false,
                    data: preferenza,
                    success : function (msg)
                    {
                        alert (msg);
                        if (msg === "invio dei dati riuscito!")
                            freeFieldsFor('preferenza');
                    }
                });
            }            
            break;
        
        case 'scuola':
            scuola.username = $("#usernameScuola").val().trim();
            scuola.password = $("#passwordScuola").val();
            scuola.confermaPassword = $("#confermapasswordScuola").val();
            scuola.nome = $("#nomeScuola").val();
            scuola.citta = ($("#cittaScuola").val().isEmpty()) ? "NULL" : $("#cittaScuola").val();
            scuola.CAP = ($("#CAPScuola").val().isEmpty()) ? "NULL" : $("#CAPScuola").val();
            scuola.indirizzo = ($("#indirizzoScuola").val().isEmpty()) ? "NULL" : $("#indirizzoScuola").val();
            scuola.telefono = ($("#telefonoScuola").val().isEmpty()) ? "NULL" : $("#telefonoScuola").val();
            scuola.email = ($("#emailScuola").val().isEmpty()) ? "NULL" : $("#emailScuola").val();
            scuola.sito = ($("#sitoScuola").val().isEmpty()) ? "NULL" : $("#sitoScuola").val();
            
            $.ajax({
                type : 'POST',
                url : 'ajaxOpsPerScuola/ajaxInvia.php',
                cache : false,
                data : scuola,
                success : function (msg)
                {
                    if (msg === "ok")
                    {
                        freeFieldsFor("scuola");
                    }
                }
            });
            break;
        
        case 'annoscolastico':
            annoscolastico.nome = $("#nomeAnno").val();
            annoscolastico.corrente = $("#currentyear").prop("checked");            
            $.ajax({
                type : 'POST',
                url : 'ajaxOpsPerAnnoScolastico/ajaxInvia.php',
                cache : false,
                data : annoscolastico,
                success : function (msg){
                    if (msg === "ok")
                        freeFieldsFor ("annoscolastico");
                }
            });
            break;
        
        case 'figuraprofessionale':
            figuraprofessionale.nome = $("#nomeFigura").val();
            figuraprofessionale.settore = $("#nomeSettore").val();
            
            $.ajax({
                type : 'POST',
                url : 'ajaxOpsPerFiguraProfessionale/ajaxInvia.php',
                cache : false,
                data : figuraprofessionale,
                success : function (msg){
                    if (msg === "ok")
                        freeFieldsFor ("figuraprofessionale");
                    else
                        alert(msg);
                }
            });
            break;
        
        case 'stage':
            stage.inizio = $("#inizioStage").val();
            stage.durata = $("#durataStage").val();
            $.ajax({
                type : 'POST',
                url : 'ajaxOpsPerStage/ajaxInvia.php',
                cache : false,
                data : stage,
                success : function (msg){
                    if (msg === "ok")
                        freeFieldsFor ("stage");
                }
            });
            break;
        
        case 'settore':
            settore.indirizzostudi = $("#indirizzoStudi").val();
            settore.nomesettore = $("#nomeSettore").val();
            $.ajax({
                type : 'POST',
                url : 'ajaxOpsPerSettore/ajaxInvia.php',
                cache : false,
                data : settore,
                success : function (msg){
                    if (msg === "ok")
                        freeFieldsFor ("settore");
                }
            });
            break;
    }
}