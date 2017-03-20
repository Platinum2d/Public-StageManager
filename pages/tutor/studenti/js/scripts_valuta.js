valutazione = {
    'gestione_ambiente_spazio_lavoro':'',
    'collaborazione_comunicazione':'',
    'uso_strumenti':'',
    'complessita_compito_atteggiamento':'',
    'valutazione_gestione_sicurezza':'',
    'competenze_linguistiche':'',
    'conoscenza_coerenza_approfondimento':'',
    'efficacia_esposizone':'',
    'qualita_processo':'',
    'efficacia_prodotto':'',
    'commento':'',
    'id_studente_has_stage':''
};

var media = 0;
var n_select = 0;

function insertGrades ()
{
    valutazione.gestione_ambiente_spazio_lavoro = $("[name='gestione_ambiente_spazio_lavoro']").val();
    valutazione.collaborazione_comunicazione = $("[name='collaborazione_comunicazione']").val();
    valutazione.uso_strumenti = $("[name='uso_strumenti']").val();
    valutazione.complessita_compito_atteggiamento = $("[name='complessita_compito_atteggiamento']").val();
    valutazione.valutazione_gestione_sicurezza = $("[name='rispetto_ambiente']").val();
    valutazione.competenze_linguistiche = $("[name='competenze_linguistiche']").val();
    valutazione.conoscenza_coerenza_approfondimento = $("[name='conoscenza_coerenza_approfondimento']").val();
    valutazione.efficacia_esposizone = $("[name='efficacia_esposizone']").val();
    valutazione.qualita_processo = $("[name='qualita_processo']").val();
    valutazione.efficacia_prodotto = $("[name='efficacia_prodotto']").val();
    valutazione.commento = $("[name='commento']").val();
    valutazione.id_studente_has_stage = $("[name='id_studente_has_stage']").val();
    
    $.ajax({
        type : 'POST',
        url : 'ajaxOps/inserisci_voto.php',
        data : valutazione,
        cache : false,
        success : function (msg)
        {
            if (msg === "ok") {
                printSuccess ("Inserimento riuscito", "Valutazione inserita con successo!");
                $("input#SalvaValutazione").attr ("value", "Aggiorna valutazione");
                $("input#SalvaValutazione").attr ("onclick", "updateGrades();");
            }
            else {
            	printError ("Errore", "Problema non previsto.");
            }
        },
        error : function () {
        	printError ("Errore", "Problema nell'invio della richiesta.");
        }
    });
    
}

function updateGrades()
{   
    valutazione.gestione_ambiente_spazio_lavoro = $("[name='gestione_ambiente_spazio_lavoro']").val();
    valutazione.collaborazione_comunicazione = $("[name='collaborazione_comunicazione']").val();
    valutazione.uso_strumenti = $("[name='uso_strumenti']").val();
    valutazione.complessita_compito_atteggiamento = $("[name='complessita_compito_atteggiamento']").val();
    valutazione.valutazione_gestione_sicurezza = $("[name='rispetto_ambiente']").val();
    valutazione.competenze_linguistiche = $("[name='competenze_linguistiche']").val();
    valutazione.conoscenza_coerenza_approfondimento = $("[name='conoscenza_coerenza_approfondimento']").val();
    valutazione.efficacia_esposizone = $("[name='efficacia_esposizone']").val();
    valutazione.qualita_processo = $("[name='qualita_processo']").val();
    valutazione.efficacia_prodotto = $("[name='efficacia_prodotto']").val();
    valutazione.commento = $("[name='commento']").val();
    valutazione.id_studente_has_stage = $("[name='id_studente_has_stage']").val();
    
    $.ajax({
       type : 'POST',
       url : 'ajaxOps/aggiorna_valutazione.php',
       data : valutazione,
       cache : false,
       success : function (msg)
       {
           if (msg === "ok")
               printSuccess ("Aggiornamento riuscito", "Valutazione aggiornata con successo!");
           else
        	   printError ("Errore", "Problema non previsto.");
       },
       error : function(msg)
       {
    	   printError ("Errore", "Problema nell'invio della richiesta.");
       }
    });
}

function aggiornaMedia () {
	media = 0;
	$("select").each (function () {
		media += parseInt($(this).val ());
	});
	media = media / n_select;
	$('#media').text("Media attuale = " + media + "\\" + n_select);
}

$(document).ready(function() {
	$("select").each (function () {
		n_select += 1;
	});
	aggiornaMedia ();
	
	$("select").change (function () {
		aggiornaMedia ();
	});
});