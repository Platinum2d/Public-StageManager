$(document).ready(function() {
	
	$("input#visita").click (function () {
		var checkbox = $(this);
		var visita = checkbox.data ("visita");
		if (visita === 1) {
			visita = 0;
		}
		else {
			visita = 1;
		}
		var tr = checkbox.closest ("tr");
		var id_shs = tr.data ("shs");
		$.ajax({
            type: 'POST',
            url : "ajaxOps/visita_ajax.php",
            data: {
                'id':id_shs,
                'visita':visita
            },
            success: function () {
            	checkbox.data ("visita", visita);
            	checkbox.attr ("data-visita", visita);
            	if (visita) {
            		tr.find ("button").removeAttr ("disabled");
            	}
            	else {
            		tr.find ("button").attr ("disabled", "disabled");
            	}
            }
        });
	});
	$("button[name='registro_studente']").click (function () {
		$(this).closest ("form").submit ();
	});
	$("button[name='valuta_studente']").click (function () {
		$(this).closest ("form").submit ();
	});
});