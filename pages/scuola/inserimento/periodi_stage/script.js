stage = {
    'inizio' : '',
    'fine' : ''
};

function sendData()
{
    stage.inizio = $("#inizioStage").val();
    stage.fine = $("#fineStage").val();
    $.ajax({
        type : 'POST',
        url : 'ajaxOpsPerStage/ajaxInvia.php',
        cache : false,
        data : stage,
        success : function (msg){
            if (msg === "ok")
                freeFields();
        }
    });
}

function freeFields()
{
    $("#inizioStage").val('');
    $("#fineStage").val('');
}