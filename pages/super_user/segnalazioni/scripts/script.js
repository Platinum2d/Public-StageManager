$(document).ready(function (){
    $(".segnalation").click(function (){
        var id_segnalazione = $(this).attr("name");
        
        $.ajax({
            type : 'POST',
            url : 'ajaxOpsPerSegnalazioni/ajaxDescrizione.php',
            cache : false,
            data : { 'id' : id_segnalazione },
            success : function (xml)
            {
                $("#SuperAlert").find(".modal-title").html("Descrizione della segnalazione");
                $("#SuperAlert").find(".modal-body").html($(xml).find("descrizione").text());
                
                $("#SuperAlert").find(".modal-footer").html("<button type=\"button\" class=\"btn btn-default\" data-dismiss=\"modal\">Chiudi</button>");
                if ($(xml).find("risolto").text() === "0")
                    $("<button class=\"btn btn-success\">Marca come risolto</button>").insertBefore($("#SuperAlert").find(".modal-footer").find("button"));
                else
                    $("<button class=\"btn btn-danger\">Marca come da risolvere</button>").insertBefore($("#SuperAlert").find(".modal-footer").find("button"));
            }
        });
        $("#SuperAlert").modal("show");
    });
});