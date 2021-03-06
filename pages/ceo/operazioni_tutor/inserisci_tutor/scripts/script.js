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

function sendSingleData()
{
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
            
    if (tutor.username.isEmpty() || tutor.nome.isEmpty() || tutor.cognome.isEmpty())
    {
        printError("Errore", "<div align='center'>Si prega di inserire i campi obbligatori</div>");
        return;
    }            
    if (tutor.password !== tutor.confermaPassword || tutor.password.isEmpty() || tutor.password < 8)
    {
        printError("Errore", "<div align='center'>Errore nell'inserimento della password</div>");
        return;
    }
            
    $.ajax({
        type : 'POST', 
        url : 'ajaxOpsPerTutor/ajaxInvia.php',
        cache : false,
        data : tutor,
        success : function(msg)
        {
            if (msg === "Inserimento dei dati riuscito!")
            {
                printSuccess("Inserimento Riuscito", "<div align='center'>Tutor aziendale inserito correttamente!</div>");
                freeFields();
            }
            else 
                printError("Inserimento non riuscito", "<div align='center'>L'inserimento non è andato a buon fine. Si prega di riprovare<br>Se l'errore dovesse persistere, contattare l'amministratore</div>");
        }
    });
}

function freeFields()
{
    $("#usernameTutor").val('');
    $("#passwordTutor").val('');
    $("#confermaPasswordTutor").val('');
    $("#nomeTutor").val('');
    $("#cognomeTutor").val('');
    $("#telefonoTutor").val('');
    $("#emailTutor").val('');
    $("#aziendaTutor").val('');
}
