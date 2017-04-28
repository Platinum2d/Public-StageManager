$(document).ready(function (){
    $.datepicker.setDefaults( $.datepicker.regional[ "it" ] );
    $("input[name='data_inizio']").each(function (){
        $(this).datepicker({dateFormat : 'dd-mm-yy'});
        
        $(this).change(checkInizio);
    });
    
    $("input[name='data_fine']").each(function (){
        $(this).datepicker({dateFormat : 'dd-mm-yy', minDate : $('#inizio'+$(this).attr("data-id")).val()});
        $('#fine'+$(this).attr("data-id")).datepicker("setDate", new Date ($('#fine'+$(this).attr("data-id")).val()));
        $(this).change(checkFine);
    });
});

function checkInizio()
{
    $(this).css('color', 'red');
    $('#fine'+$(this).attr("data-id")).datepicker('destroy');
    $('#fine'+$(this).attr("data-id")).datepicker({dateFormat : 'dd-mm-yy', minDate : $('#inizio'+$(this).attr("data-id")).val()});
    
    var start = new Date($('#inizio'+$(this).attr("data-id")).datepicker("getDate"));
    var end = new Date($('#fine'+$(this).attr("data-id")).datepicker("getDate"));
    if (end <= start)
    {
        $('#fine'+$(this).attr("data-id")).val("");
    }
}

function checkFine()
{
    $(this).css('color', 'red');
    
    var start = new Date($('#inizio'+$(this).attr("data-id")).datepicker("getDate"));
    var end = new Date($('#fine'+$(this).attr("data-id")).datepicker("getDate"));
    
    if (end <= start)
    {
        $('#inizio'+$(this).attr("data-id")).val("");
    }
}

function sendData(numberId, id_stage)
{
    tosend = {
        'id' : id_stage,
        'inizio' : $("#inizio"+numberId).val(),
        'fine' : $("#fine"+numberId).val()
    };
    
    
    if (tosend.inizio.trim() === "" || typeof(tosend.inizio.trim()) === "undefined" || tosend.fine.trim() === "" || typeof(tosend.fine.trim()) === "undefined")
        return;
    
    $.ajax({
        type : 'POST',
        url : 'ajaxOpsPerStage/ajaxInvia.php',
        data : tosend,
        cache : false,
        success : function (msg){
            if (msg === "ok")
                resetColors(numberId);
        }
    });
}

function resetColors(numberId)
{
    $("#inizio"+numberId).css("color", "#828282");
    $("#fine"+numberId).css("color", "#828282");
}
