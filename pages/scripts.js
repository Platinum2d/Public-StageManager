function changeDatabase(database)
{
    $.ajax({
        type : 'POST',
        url : 'ajaxOpsPerDatabase/ajaxCambiaDatabase.php',
        cache : false,
        data : { 'db' : database},
        success : function (session)
        {
            location.reload();
        }
    })
}

function Download() {
//    alert("ciaoborel")
//        $.fileDownload('../help.pdf')
//    .done(function () { alert('File download a success!'); })
//    .fail(function () { alert('File download failed!'); });
    var newA = document.createElement('a');
    newA.id = "aDownload";
    newA.href = "/help.pdf";
    newA.download = "helpme.pdf";
    $('#aDownload').trigger('click');
};

function createIntervalToMoveHelpBadge()
{
    window.setInterval(function() {
        alert("ciao borel");
    }, 1);
    
}