docente = {
    'username': '',
    'password': '',
    'confermaPassword': '',
    'nome': '',
    'cognome': '',
    'telefono': '',
    'email': ''     
};

function freeFields()
{
    $("#UsernameDocente").val('');
	$("#PasswordDocente").val('');
	$("#ConfermaPasswordDocente").val('');
	$("#NomeDocente").val('');
	$("#CognomeDocente").val('');
	$("#TelefonoDocente").val('');
	$("#EmailDocente").val('');
	$('#isDocenteTutor').val('');
	$('#isDocenteReferente').val('');
}

function sendSingleData(userType)
{
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
    
    if (docente.username.isEmpty() || docente.password.isEmpty() || docente.nome.isEmpty() || docente.cognome.isEmpty() || docente.telefono.isEmpty() || docente.email.isEmpty())
    {
        printError("Errore", "Si prega di compilare i cambi obbligatori");
        return;
    }
    else
    {
        if (docente.password.trim() !== docente.confermaPassword.trim() || docente.password.length < 8)
        {
        	printError("Errore", "Errore nell'inserimento della password");
            return;
        }
        
        $.ajax({
            type: "POST",
            url: "ajaxOps/ajaxDocente.php",
            data : docente,
            cache: false,
            success: function(msg)
            {
                if (msg === "Inserimento dei dati riuscito!")
                    freeFields();
            }
        });
    }
}

$(document).ready (function () {
	String.prototype.isEmpty = function() {
        return (this.length === 0 || !this.trim());
    };    
    
    var check = setInterval(function(){
        if ($("#UsernameDocente").val().isEmpty() || $("#PasswordDocente").val().isEmpty() || $("#ConfermaPasswordDocente").val().isEmpty() || $("#NomeDocente").val().isEmpty()
                || $("#CognomeDocente").val().isEmpty() || $("#TelefonoDocente").val().isEmpty() || $("#EmailDocente").val().isEmpty() || $("#userexists").val() === "1" 
            	|| $("#passworderror").val() === "1")
        {
            $("button#inviaSingolo").prop("disabled",true);
        }
        else
        {
            $("button#inviaSingolo").prop("disabled",false);
        }
    },1);
    
    $("#UsernameDocente").on('input',function (){
        $.ajax({
            type : 'POST',
            url : 'ajaxOps/ajaxCheckUserExistence.php',
            data : {'user' : $("#UsernameDocente").val()},
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
                    if ($("#UsernameDocente").val().isEmpty())
                    {
                        $("#usr").html("Username*");
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
    
    var checkpw = setInterval(function (){
        if ($("#PasswordDocente").val() !== $("#ConfermaPasswordDocente").val() || $("#PasswordDocente").val().length < 8)
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
    }, 1);
});