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

function addDatePickerInInzioStage()
{
    $("#inizioStageStudente").datepicker({ dateFormat: 'dd-mm-yy' });
}

function freeFieldsFor(userType)
{
    switch (userType)
    {        
        case 'azienda':
            printSuccess("Azione eseguita correttamente", "<div align='center'>L'azienda è stata inserita correttamente</div>");
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
            if (azienda.username.isEmpty() || azienda.password.isEmpty() || azienda.nome.isEmpty())
            {
                printError("Errore", "Si prega di compilare i cambi obbligatori");
                return;
            }
            
            if (azienda.password.trim() !== azienda.confermaPassword.trim() || azienda.password.length < 8)
            {
                printError("Errore", "Errore nell'inserimento della password");
                return;
            }
            
            azienda.telefono = ''+$('#TelefonoAzienda').val();
            if (azienda.telefono.isEmpty()) azienda.telefono = '';
            
            azienda.email = ''+$('#MailAzienda').val();
            if (azienda.email.isEmpty()) azienda.email = '';
            
            azienda.sito = ''+$('#SitoAzienda').val();
            if (azienda.sito.isEmpty()) azienda.sito = '';
            
            azienda.nomeresponsabile = ''+$('#NomeResponsabileAzienda').val();
            if (azienda.nomeresponsabile.isEmpty()) azienda.nomeresponsabile = '';
            
            azienda.cognomeresponsabile = ''+$('#CognomeResponsabileAzienda').val();
            if (azienda.cognomeresponsabile.isEmpty() || azienda.cognomeresponsabile === 'undefined') azienda.cognomeresponsabile = '';
            
            azienda.telefonoresponsabile = ''+$('#TelefonoResponsabileAzienda').val();
            if (azienda.telefonoresponsabile.isEmpty()) azienda.telefonoresponsabile = '';
            
            azienda.emailresponsabile = ''+$('#MailResponsabileAzienda').val();
            if (azienda.emailresponsabile.isEmpty()) azienda.emailresponsabile = '';
            
            $.ajax({
                type : 'POST',
                url : 'ajaxOpsPerAzienda/ajaxInvia.php',
                data : azienda,
                cache : false,
                success: function(msg)
                {
                    if (msg === "Inserimento dei dati riuscito!")
                        freeFieldsFor('azienda');
                    else printError ("Errore", "Problema non previsto.");
                },
                error : function () {
                	printError ("Errore", "Problema nell'invio della richiesta.");
                }
            });
            break;
    }
}