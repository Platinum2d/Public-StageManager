ceo = {
    'username': '',
    'password': '',
    'confermaPassword': '',
    'nome': '',
    'cognome': '',
    'telefono': '',
    'email': '',
};

function freeFields()
{
    $('#usernameCeo').val('');
    $('#passwordCeo').val('');
    $('#confermaPasswordCeo').val('');
    $('#nomeCeo').val('');
    $('#cognomeCeo').val('');
    $('#telefonoCeo').val('');
    $('#emailCeo').val('');
}

function sendSingleData(userType)
{
    switch(userType)
    {
    case 'ceo':
            String.prototype.isEmpty = function() {
                return (this.length === 0 || !this.trim());
            }; 
            
            ceo.password = ''+$('#passwordCeo').val().trim();
            ceo.confermaPassword = ''+$('#confermaPasswordCeo').val().trim();
            if (ceo.password !== ceo.confermaPassword || !ceo.password || ceo.password.length < 8)
            {
                alert("errore nell'inserimento della password");
                return;
            }      
            
            ceo.username = ''+$('#usernameCeo').val().trim();            
            ceo.nome = ''+$('#nomeCeo').val().trim();
            ceo.cognome = '' + $('#cognomeCeo').val().trim();
            ceo.telefono = '' + $('#telefonoCeo').val();
            if (ceo.telefono.isEmpty()) ceo.telefono = ' ';

            ceo.email = '' + $('#emailCeo').val();
            if (ceo.email.isEmpty()) ceo.email = ' ';

            
            if (ceo.username.isEmpty() || ceo.password.isEmpty() || ceo.nome.isEmpty() || ceo.cognome.isEmpty() || ceo.telefono.isEmpty() ||ceo.email.isEmpty())
            {
                alert("Si prega di compilare i cambi obbligatori");
                return;
            }
            
            $.ajax({
                type : 'POST',
                url : '../inserisci_tutor/ajaxOps/ajaxCeo.php',
                data : ceo,
                cache : false,
                success: function(msg)
                {
                    alert(msg);
                    freeFields();
                }
            });
            break;
    }
    
    
}