docente = {
    'username': '',
    'password': '',
    'confermaPassword': '',
    'nome': '',
    'cognome': '',
    'telefono': '',
    'email': '',
    'docente_tutor' : '0'
};

function send()
{
    String.prototype.isEmpty = function() {
        return (this.length === 0 || !this.trim());
    };      
    
    docente.username = ''+$("#UsernameDocente").val().trim();
    docente.password = ''+$("#PasswordDocente").val();
    docente.confermaPassword = ''+$("#ConfermaPasswordDocente").val();                        
    docente.nome = ''+$("#NomeDocente").val().trim();
    docente.cognome = ''+$("#CognomeDocente").val().trim();
    docente.telefono = ''+$("#TelefonoDocente").val().trim();
    docente.email = ''+$("#EmailDocente").val().trim();
    
    if ($("#isDocenteReferente").is(":checked")) 
        docente.docente_tutor = '0';
    else
        docente.docente_tutor = '1';
        
    if (docente.username.isEmpty() || docente.password.isEmpty() || docente.nome.isEmpty() || docente.cognome.isEmpty() || docente.telefono.isEmpty() || docente.email.isEmpty())
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
            url: "ajaxOps/ajaxInvia.php",
            data : docente,
            cache: false,
            success: function(msg)
            {
                if (msg === "Inserimento dei dati riuscito!")
                {
                    freeFields();
                    printSuccess("Inserimento Riuscito", "<div align='center'>Docente inserito correttamente!</div>");
                }                    
            }
        });
    }
}

function freeFields()
{
    $("#UsernameDocente").val('');
    $("#PasswordDocente").val('');
    $("#ConfermaPasswordDocente").val('');
    $("#NomeDocente").val('');
    $("#CognomeDocente").val('');
    $("#TelefonoDocente").val('');
    $("#EmailDocente").val('');
}

function setUserToAdd()
{
    if ($(".active").html() === "Docenti Tutor")
    {
        $("input[name='tipo_docente']").val("docente_tutor");
        localStorage.setItem("tipo_docente", "docente_tutor");
    }
    else
    {
        $("input[name='tipo_docente']").val("docente_referente");
        localStorage.setItem("tipo_docente", "docente_referente");
    }
}

function handleTypes(id)
{
    $(".list-group-item").each(function (){
        $(this).removeClass("active");
    });    
    $("#"+id).addClass("active");
}