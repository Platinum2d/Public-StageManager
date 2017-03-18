$(document).ready(function (){
    $("#add").change(function (){
        if ($(this).val() !== "-1")
            $("#addButton").prop("disabled", false);
        else
            $("#addButton").prop("disabled", true);
    });
});

function sendData(classe, anno, stage)
{
    esperienza = {
        'stage' : stage,
        'classe' : classe,
        'anno' : anno
    };
    
    $.ajax({
        url : 'ajaxOpsPerStage/ajaxInvia.php',
        type : 'POST',
        cache : false,
        data : esperienza,
        success : function (msg){
            if (msg === "ok")
                location.reload();
            else
                printError("Eliminazione non riuscita","Contattare l'amministratore");
        }
    });
}

function deleteExperience(idexp){
    var confirmed = confirm("--- ATTENZIONE ---\nL'eliminazione di questa esperienza di stage comporta l'eliminazione di TUTTI i dati ad essa correlata.\nNON C'E' MODO DI ANNULLARE L'OPERAZIONE.\nProcedere?");
    
    if (confirmed)
    {
        $.ajax({
            type : 'POST',
            url : 'ajaxOpsPerStage/ajaxDeleteExperience.php',
            cache : false,
            data : { 'id_classe_has_stage' : idexp},
            success : function (msg)
            {
                if (msg === "ok")
                    location.reload();
                else
                    printError("Eliminazione non riuscita","Contattare l'amministratore");
            }
        });    
    }
}