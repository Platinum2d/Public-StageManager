stage = {
    'inizio' : '',
    'durata' : '0'
};
function freeFields()
{
    $("#inizioStage").val('');
    $("#durataStage").val('');
}

function sendData()
{
    stage.inizio = $("#inizioStage").val();
    stage.durata = $("#durataStage").val();
    $.ajax({
        type : 'POST',
        url : 'ajaxOpsPerStage/ajaxInvia.php',
        cache : false,
        data : stage,
        success : function (msg){
            if (msg === "ok")
            {
                freeFields();
                printSuccess("Inserimento Riuscito", "<div align='center'>Periodo di stage inserito correttamente!</div>");
            }                
        }
    });
}