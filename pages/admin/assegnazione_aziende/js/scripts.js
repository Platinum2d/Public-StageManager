function showMessage(){
    $("#message").fadeIn({
        duration : 'slow',
        complete : function(){
            setTimeout(function() {
                $("#message").fadeOut('slow');
            }, 2000);
        } 
    });
}

function showFailureMessage(){
    $("#FailureMessage").fadeIn({
        duration : 'slow',
        complete : function(){
            setTimeout(function() {
                $("#FailureMessage").fadeOut('slow');
            }, 2000);
        } 
    });
}

function seleziona(e){
    var str=$(e.target).text();
    var id=$(e.target).siblings("input").val();
    $(e.target).closest(".student_box").find(".seleziona").text(str)
    $(e.target).closest(".student_box").find(".seleziona").val(id)
}     

function ok(e){
    var uid=$(e.target).val();
    var aid=$(e.target).siblings("button").children(".seleziona").val();
    $.ajax({
        type: 'POST',
        url: 'ajaxOps/assegna_azienda.php',   
        data: {
            'uid':uid,
            'aid':aid
        },
        
        success : function(msg)
        {
            if (msg === "ok") showMessage();
            else              showFailureMessage();            
        }
    }); 	   
}

function togli(e){
    var uid=$(e.target).val();
    $(e.target).closest(".student_box").find(".seleziona").text("Non Assegnato");
    
    $.ajax({
        type: 'POST',
       	url: 'ajaxOps/disassegna_azienda.php', 
       	data: {
            'uid':uid
        },
        
        success : function(msg)
        {
            if (msg === "ok") showMessage();
            else              showFailureMessage();       
        }
    });
}

function getClasse(e){
    $("#classes").children("li").removeClass("active");
    $(e.target.closest("li")).addClass("active");
    class_id = $(e.target).find(".classe_id").val()
    data = {
        "classe": class_id              
    }
    $.ajax({
        url: "ajaxOps/ajaxOp.php", //Pagina a quale invio la richiesta
        type: "POST", //Metodologia di invio di dati
        dataType: "xml", //Tipologia di dati restituiti
        data: data, //Dati inviati
        
        error: function(xhr, ajaxOptions, thrownError){ //in caso di errore attende 2 secondi
            setTimeout(getClasse(e),2000)
            //                    alert(xhr.status);
            //        alert(thrownError);
        },
        
        success: function(xml){            
            if (xml)
            {
//                alert((new XMLSerializer()).serializeToString(xml))
                $(".student_box").empty();
                $(xml).find("studenti").find("studente").each(function(index, element){
                    nome = $(this).find("nome").text()
                    cognome = $(this).find("cognome").text()
                    id = $(this).find("id").text()
                    nome_aziendale = $(this).find("nome_aziendale").text();
                    var menuAzienda;
                    if($(this).find("preferenza").length)                    
                    {
                        preferenza = $(this).find("preferenza").text();
                        
                    menuAzienda = $("<br><div class='dropdown'> \
						<span>" + nome + " " + cognome + " (preferenza : "+ preferenza +")</span>\
                        <button class='btn btn-default dropdown-toggle' id='button"+ id + "' data-toggle='dropdown' aria-expanded='true'>\
                        	<span class='seleziona'>" + nome_aziendale + "</span>\
                        	<span>   </span>\
                        	<span class='caret caretBlack'></span>\
                        </button>\
                        <button class='btn btn-default okbutton' value='"+ id + "'>OK</button>\
                        <button class='btn btn-default toglibutton' value='"+ id + "'>Rimuovi azienda</button>\
                        <ul class='dropdown-menu' role='menu' aria-labelledby='menu'></ul>\
                    </div>");
                    }
                    else
                    {
                        menuAzienda = $("<br><div class='dropdown'> \
						<span>" + nome + " " + cognome + "</span>\
                        <button class='btn btn-default dropdown-toggle' id='button"+ id + "' data-toggle='dropdown' aria-expanded='true'>\
                        	<span class='seleziona'>" + nome_aziendale + "</span>\
                        	<span>   </span>\
                        	<span class='caret caretBlack'></span>\
                        </button>\
                        <button class='btn btn-default okbutton' value='"+ id + "'>OK</button>\
                        <button class='btn btn-default toglibutton' value='"+ id + "'>Rimuovi azienda</button>\
                        <ul class='dropdown-menu' role='menu' aria-labelledby='menu'></ul>\
                    </div>");
                    }
                    
                    
                    
                    $(xml).find("aziende").find("azienda").each(function(index, element){
                        menuAzienda.find("ul.dropdown-menu").append("<li role='presentation'><a role='menuitem' class='azienda_item'>" + $(this).find("rs").text() + "</a></li>")
                        menuAzienda.find("ul.dropdown-menu").find("li:last").append("<input type='hidden' value='" + $(this).find("id").text() + "' class='aid'>")
                    })
                    $("#main").append("<div class='student_box'></div>");
                    $("#main div.student_box:last").append(menuAzienda);
                })
                $("a.azienda_item").click(seleziona);
                $('.dropdown-toggle').dropdown();
                $('.okbutton').click(ok);
                $('.toglibutton').click(togli);
            }
        }
    });
}

$(document).ready(function(){
    $("#message").hide();
    $("#FailureMessage").hide();
    $(".classe").click(getClasse)
})