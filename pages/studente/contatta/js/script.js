mail = {
    'destinatario' : '',
    'mittente' : '',
    'oggetto': '',
    'messaggio' : ''
}

function sendMail()
{
    mail.destinatario = ($('#destinatario').find(":selected").attr('value'));
    mail.oggetto = $('#obj').val(); 
    mail.messaggio = $('#comment').val();
    
    $.ajax({
       url : 'ajaxOps/ajaxSendMail.php',
       type: 'POST',
       data : mail,
       cache : false,
       success : function (msg)
       {
           alert(msg);
           freeFields();
       }
    });
}

function freeFields()
{
    $('#obj').val(' ');
    $('#comment').val(' ');
}
