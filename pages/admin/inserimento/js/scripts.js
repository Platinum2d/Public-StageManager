(function() {
//    addSelectionsFor('studente','classe');
//    addSelectionsFor('studente','azienda');
//    addSelectionsFor('studente','docente');
//    addSelectionsFor('classe','specializzazione');
//    
//    addDatePickerInInzioStage();

})();

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
    'iniziostage':'',
    'duratastage':0,
    'classe':'',
    'azienda':'',
    'docente':'',
    'tutor':''
};

classe = {
    'nome' : ''
}

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
            $("#classeStudente").val('');
            $("#aziendaStudente").val('');
            $("#docenteStudente").val('');
            $("#tutorStudente").val('');            
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
    }
}

function addSelectionsFor(page,field)
{
    switch (page)
    {
        case 'studente':
            switch (field)
            {
                case 'classe':
                    if(!$('#classeStudente').is(':focus'))
                    {
                        $.ajax({
                            url : '../studenti/ajaxOpsPerStudente/ajaxClasse.php',
                            cache : false,
                            success : function (xml)
                            {
                                //alert(xml);
                                var selectedindex = 0+$("#classeStudente").prop('selectedIndex');
                                $('#classeStudente').html('');
                                $(xml).find('classe').each(function()
                                {
                                    current = $(this).text();
                                    $('#classeStudente').append('<option> '+current+' </option>');
                                });
                                //$('#classeStudente')[selectedindex].selected = true;
                            }
                        });
                    }
                    break;
                
                case 'azienda':
                    if(!$('#aziendaStudente').is(':focus'))
                    {
                        $.ajax({
                            url : '../studenti/ajaxOpsPerStudente/ajaxAzienda.php',
                            cache : false,
                            success : function (xml)
                            {
                                //                                alert(xml);
                                $('#aziendaStudente').html('<option> </option>');
                                $('#keepIdAzienda').html('');
                                $(xml).find('aziende').find('azienda').each(function()
                                {
                                    currentid = $(this).find('id').text(); 
                                    $('#keepIdAzienda').append('<option> '+currentid+'</option>');                                    
                                    currentAzienda = $(this).find('nome').text();
                                    $('#aziendaStudente').append('<option> '+currentAzienda+'</option>');
                                    //                                    if ($("#aziendaStudente").prop('selectedIndex') !== '-1')
                                    //                                        alert($("#aziendaStudente").prop('selectedIndex'));
                                });
                            }
                        });
                    }
                    else
                    { 
                        $('#tutorStudente').css('color','black');
                        index = parseInt($("#aziendaStudente").prop('selectedIndex'),10);
                        var list = document.getElementById("keepIdAzienda");
                        id = list.options[index-1].text;
                        miaazienda = {'idAzienda' : id};                        
                        
                        $.ajax({
                            type : 'POST',
                            data : miaazienda,
                            url : '../studenti/ajaxOpsPerStudente/ajaxTutor.php',
                            cache : false,
                            success : function (xml)
                            {
                                //alert(xml);
                                $('#tutorStudente').html('<option> </option>');
                                $(xml).find('tutors').find('tutor').each(function()
                                {
                                    currentnome = $(this).find('nome').text(); 
                                    currentcognome = $(this).find('cognome').text();
                                    $('#tutorStudente').append('<option> '+currentcognome+' '+currentnome+'</option>');
                                    //                                        $('#tutorStudente').append('<option> '+currentcognome+'</option>');
                                    //                                    if ($("#aziendaStudente").prop('selectedIndex') !== '-1')
                                    //                                        alert($("#aziendaStudente").prop('selectedIndex'));
                                });
                            }
                        });
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
                                //                            alert(xml);
                                $('#docenteStudente').html('<option> </option>');
                                $(xml).find('docenti').find('docente').each(function()
                                {
                                    //currentUsername = $(this).find("username").text();
                                    currentUsername = $(this).find("username").text();
                                    currentNome = $(this).find("nome").text();
                                    // alert(currentNome);
                                    currentCognome = $(this).find("cognome").text();
                                    //alert(currentCognome);
                                    $('#docenteStudente').append('<option> '+currentCognome+' '+currentNome+'</option>'); 
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
                                    $("#SpecializzazioneClasse").append("<option> "+$(this).text()+" </option>")
                                });
                            }
                        });
                    }
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
                                $('#aziendaTutor').html('<option> </option>');
                                $(xml).find('aziende').find('azienda').each(function()
                                {                                
                                    currentAzienda = $(this).find('nome').text();
                                    $('#aziendaTutor').append('<option> '+currentAzienda+'</option>');
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
            if (azienda.username.isEmpty() || azienda.password.isEmpty() || azienda.nome.isEmpty() || azienda.citta.isEmpty() || azienda.CAP.isEmpty() || azienda.indirizzo.isEmpty())
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
            studente.classe = $('#classeStudente').val().trim();
            
            if (studente.username.isEmpty() || studente.nome.isEmpty() || studente.cognome.isEmpty() || studente.citta.isEmpty() || studente.mail.isEmpty() || studente.telefono.isEmpty() || studente.classe.isEmpty())
            {
                alert("Si prega di compilare i cambi obbligatori");
//                alert(studente.classe);
                return;
            }
            if(!studente.password || studente.password !== studente.confermaPassword || studente.password < 8)
            {
                alert("errore nell'inserimento della password");
                return;
            }
            
            //$("#tutor"+numberId).html('<option value = "-1"></option>');        
            studente.iniziostage = $('#inizioStageStudente').val();
            if (studente.iniziostage === '') studente.iniziostage = 'NULL';
//            alert(studente.iniziostage);
            studente.duratastage = ''+$('#durataStageStudente').val();
            studente.duratastage = (studente.duratastage === '') ? 'NULL' : studente.duratastage;
            studente.azienda = $('#aziendaStudente').val().trim();
            studente.docente = $('#docenteStudente').val().trim();
            studente.tutor = $('#tutorStudente').val().trim();
            
            $.ajax({
                type : "POST",
                url :  "../studenti/ajaxOpsPerStudente/ajaxInvia.php",
                data : studente,
                cache : false,
                success : function(msg)
                {
                    alert(msg);
                    if (msg === "Inserimento dei dati riuscito! (mail inviata)" || msg == "Inserimento dei dati riuscito! (mail non inviata)")
                        freeFieldsFor('studente');
                }                
            });
            break;
        
        case 'classe':            
            String.prototype.isEmpty = function() {
                return (this.length === 0 || !this.trim());
            };   
            classe.nome = $("#nomeClasse").val().trim();
            
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
                    alert(msg)
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
    }   
}

function checkUserOnInput(user){

}
