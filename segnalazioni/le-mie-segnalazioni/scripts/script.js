$(document).ready(function (){
    $(".segnalation").click(function (){
        var id_segnalazione = $(this).attr("name");
        
        $.ajax({
            type : 'POST',
            url : 'ajaxOpsPerSegnalazioni/ajaxDescrizione.php',
            cache : false,
            data : { 
            	'id' : id_segnalazione
        	},
            success : function (xml)
            {
                $("#SuperAlert").find(".modal-title").html("Descrizione della segnalazione");
                $("#SuperAlert").find(".modal-body").html($(xml).find("descrizione").text());
                
                $("#SuperAlert").find(".modal-footer").html("<button type=\"button\" class=\"btn btn-default\" data-dismiss=\"modal\">Chiudi</button>");
                if ($(xml).find("risolto").text() === "1") {
                	$("<button data-dismiss=\"modal\" class=\"btn btn-danger\" onclick=\"changeFlag("+id_segnalazione+", 0)\">Marca come da risolvere</button>").insertBefore($("#SuperAlert").find(".modal-footer").find("button"));
                }
            },
	        error : function () {
	        	printError ("Errore", "Problema nella comunicazione col server. Contattare l'amministratore.");
	        }
        });
        $("#SuperAlert").modal("show");
    });
});

function changeFlag(id_segnalazione, nuovostato)
{
	if (nuovostato == "0") {
	    $.ajax({
	        type : 'POST',
	        url : 'ajaxOpsPerSegnalazioni/ajaxChangeFlag.php',
	        cache : false,
	        data : { 'id' : id_segnalazione, 'stato' : nuovostato },
	        success : function (msg)
	        {
	            if (msg === "ok")
	            {
	                $("tr[name='"+id_segnalazione+"']").removeClass("success").addClass ("danger");
	            }
	            else {
		        	printError ("Errore", "Problema nella richiesta. Contattare l'amministratore.");
	            }
	        },
	        error : function () {
	        	printError ("Errore", "Problema nella comunicazione col server. Contattare l'amministratore.");
	        }
	    });
	}
}