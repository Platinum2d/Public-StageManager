$(document).ready(function (){
    $("#nomeModulo").on("input", check);
});

function check(){
    if ($("#nomeModulo").val().trim() !== "" && ($("#valutastudenti").hasClass("active") || $("#valutaaziende").hasClass("active")))
        $("input[value='Invia']").prop("disabled", false);
    else
        $("input[value='Invia']").prop("disabled", true);
}

function sendData()
{
    modulo = {
        'nome' : $("#nomeModulo").val().trim(),
        'descrizione' : $("#descrizioneModulo").val().trim(),
        'tipo' : ''
    };
    
    modulo.tipo = ($("#valutastudenti").hasClass("active")) ? "studente" : "azienda";
    
    $.ajax({
        type : 'POST',
        url : 'ajaxOpsPerModuliValutazione/ajaxInvia.php',
        cache : false,
        data : modulo,
        success : function (msg)
        {
            if (msg === "ok")
            {
                printSuccess("Inserimento Riuscito", "<div align='center'>Modulo di valutazione inserito correttamente!</div>");
                freeFields();
            }
            else {
                printError("Inserimento fallito", "<div align='center'>L'inserimento del modulo di valutazione è fallito<br>Contattare l'amministratore</div>");
        		alert (msg);
            }
        }
    });
}

function freeFields()
{
    $("#nomeModulo").val("");
    $("#descrizioneModulo").val("");
    $("#valutastudenti").removeClass("active");
    $("#valutaaziende").removeClass("active");
}