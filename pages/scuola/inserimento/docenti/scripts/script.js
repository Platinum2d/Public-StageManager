prdocente = {
    'username': '',
    'password': '',
    'confermaPassword': '',
    'nome': '',
    'cognome': '',
    'telefono': '',
    'email': ''
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