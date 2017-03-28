studente = {
    'username':'',
    'password':'',
    'confermaPassword':'',
    'nome':'',
    'cognome':'',
    'citta':'',
    'mail':'',
    'telefono':'',
    'classe':'',
    'stage':'',
    'annoclasse':''
};
function freeFields()
{
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
}

function addSelectionsFor(field)
{
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
                        $("#annoclasseStudenteForm").append("<option value=\""+$(this).find("id").text()+"\"> "+$(this).find("nome").text()+" </option>");
                    });
                }
            });
            break;
        
        case 'classe':
            $.ajax({
                type : 'POST',
                url : 'ajaxOpsPerStudente/ajaxClasse.php',
                cache : false,
                success : function (xml)
                {
                    var selectedindex = 0+$("#classeStudente").prop('selectedIndex');
                    $('#classeStudente').html('');
                    $(xml).find('classi').find("classe").each(function()
                    {
                        $('#classeStudente').append("<option value=\""+$(this).find("id").text()+"\"> "+$(this).find("nome").text()+"</option>");
                        $('#classeStudenteForm').append("<option value=\""+$(this).find("id").text()+"\"> "+$(this).find("nome").text()+"</option>");
                    });
                }
            });
            break;
    }
}

function sendData()
{    
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
    studente.annoclasse = $("#annoclasseStudente").val();
    
    if (studente.username.isEmpty() || studente.nome.isEmpty() || studente.cognome.isEmpty() || studente.classe.isEmpty() || studente.annoclasse.isEmpty())
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
        url :  "ajaxOpsPerStudente/ajaxInvia.php",
        data : studente,
        cache : false,
        success : function(msg)
        {
            alert(msg); 
            if (msg === "ok")
            {
                freeFields();
                printSuccess("Inserimento Riuscito", "<div align='center'>Studente inserito correttamente!</div>");
            }
        }                
    });
}

function updateFormInputs()
{
    $("form[name='uploadform']").find("input[name='classe']").val($("#classeStudenteForm").val());
    $("form[name='uploadform']").find("input[name='anno']").val($("#annoclasseStudenteForm").val());
    localStorage.setItem("nome_classe", $("#classeStudenteForm").find(":selected").text());
    localStorage.setItem("nome_anno", $("#annoclasseStudenteForm").find(":selected").text());
}