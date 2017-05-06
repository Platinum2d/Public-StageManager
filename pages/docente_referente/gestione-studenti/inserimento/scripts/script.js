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
};

$(document).ready(function (){
    $("#usernameStudente").keypress(function (e){
        if (e.which === 32) return false;
    });
    
    $(".buttonText").html("        Sfoglia");
    $(".icon-span-filestyle").remove();
    
    $("#usernameStudente").on('input',function (){
        $.ajax({
            type : 'POST',
            url : 'ajaxOpsPerStudente/ajaxCheckUserExistence.php',
            data : {'user' : $("#usernameStudente").val()},
            cache : false,
            success : function (msg)
            {
                if (msg === "trovato")
                {
                    $("#userexists").val("1");
                    $("#usr").html("Username (già in uso)*");
                    $("#usr").css("color","red");
                    $("#usernameregulator").removeClass("has-warning");
                    $("#usernameregulator").removeClass("has-success");
                    $("#usernameregulator").addClass("has-error");
                    $("#usernamespanregulator").removeClass("glyphicon-ok");
                    $("#usernamespanregulator").addClass("glyphicon-remove");  
                }
                else
                {
                    if ($("#usernameStudente").val().isEmpty())
                    {
                        $("#userexists").val("1");
                        $("#usr").css("color","red");
                        $("#usernameregulator").removeClass("has-warning");
                        $("#usernameregulator").removeClass("has-success");
                        $("#usernameregulator").addClass("has-error");
                        $("#usernamespanregulator").removeClass("glyphicon-ok");
                        $("#usernamespanregulator").addClass("glyphicon-remove");
                        return;
                    }
                    $("#userexists").val("0");
                    $("#usr").html("Username*");
                    $("#usr").css("color","#828282");
                    $("#usernameregulator").removeClass("has-warning");
                    $("#usernameregulator").removeClass("has-error");
                    $("#usernameregulator").addClass("has-success");
                    $("#usernamespanregulator").removeClass("glyphicon-remove");
                    $("#usernamespanregulator").addClass("glyphicon-ok");   
                }
            }
        });
    });
    
    function checkPasswordStudente()
    {
        if ($("#passwordStudente").val() !== $("#confermaPasswordStudente").val() || $("#passwordStudente").val().length < 8)
        {
            $("#passworderror").val("1");
            $("#psw").html("Password (Minimo 8 caratteri)* troppo corta o non coincide");
            $("#psw").css("color","red");
            $("#passwordregulator").removeClass("has-warning");
            $("#passwordregulator").removeClass("has-success");
            $("#passwordregulator").addClass("has-error");
            $("#passwordspanregulator").removeClass("glyphicon-ok");
            $("#passwordspanregulator").addClass("glyphicon-remove");
        }
        else
        {
            $("#passworderror").val("0");
            $("#psw").css("color","#828282"); 
            $("#psw").html("Password (Minimo 8 caratteri)*");
            $("#passwordregulator").removeClass("has-warning");
            $("#passwordregulator").removeClass("has-error");
            $("#passwordregulator").addClass("has-success");
            $("#passwordspanregulator").removeClass("glyphicon-remove");
            $("#passwordspanregulator").addClass("glyphicon-ok");                                        
        }
    }
    
    $("#passwordStudente").on("input", checkPasswordStudente);
    $("#confermaPasswordStudente").on("input", checkPasswordStudente);
});

var check = setInterval(function(){
    if ($("#usernameStudente").val().isEmpty() || $("#passwordStudente").val().isEmpty() || $("#confermaPasswordStudente").val().isEmpty() || $("#nomeStudente").val().isEmpty()
            || $("#cognomeStudente").val().isEmpty() || $("#classeStudente").val().isEmpty() || $("#userexists").val() === "1" || $("#passworderror").val() === "1")
    {
        $("input[value=\"Invia\"]").prop("disabled",true);
    }
    else
    {
        $("input[value=\"Invia\"]").prop("disabled",false);
    }
},1);

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
    studente.password = $('#passwordStudente').val().trim();
    studente.confermaPassword = $('#confermaPasswordStudente').val().trim();
    studente.username = $('#usernameStudente').val().trim();
    studente.nome = $('#nomeStudente').val().trim();
    studente.cognome = $('#cognomeStudente').val().trim();
    studente.citta = $('#cittaStudente').val().trim();
    studente.mail = $('#mailStudente').val().trim();
    studente.telefono = $('#telefonoStudente').val().trim();
    studente.classe = $('#classeStudente').val();
    
    if (studente.username.isEmpty() || studente.nome.isEmpty() || studente.cognome.isEmpty() || studente.classe.isEmpty())
    {
        printError("Errore", "<div align='center'>Si prega di inserire i campi obbligatori</div>");
        return;
    }
    if(!studente.password || studente.password !== studente.confermaPassword || studente.password < 8)
    {
        printError("Errore", "<div align='center'>Errore nella modifica della password</div>");
        return;
    }
    
    $.ajax({
        type : "POST",
        url :  "ajaxOpsPerStudente/ajaxInvia.php",
        data : studente,
        cache : false,
        success : function(msg)
        {
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
    localStorage.setItem("nome_classe", $("#classeStudenteForm").find(":selected").text());
}