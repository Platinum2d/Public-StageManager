contact = {
    'first': '',
    'city': '',
    'address': '',
    'mail': '',
    'phone': ''
};

var figuresSize = 12.5; //Costanti generali per le figure professionali
var figuresLimit = 5;

function turnEditOn()
{
    $("#myInformations td").addClass("editCell");
    $(".edittextdiv").attr('contenteditable', 'true');
}

function turnEditOff()
{
    $("#myInformations td").removeClass("editCell");
    $(".edittextdiv").attr('contenteditable', 'false');
}

$(document).ready(function(){
    $("#HiddenAddBox").hide();
    $("#cancelButtonspec").hide();
    contact.first=$("#first").html();
    contact.city=$("#city").html();
    contact.address=$("#address").html();
    contact.mail=$("#mail").html();
    contact.phone=$("#phone").html();
    $(".label-info").css("font-size", figuresSize);
    $("#figurerichieste").on("itemAdded", function (event){  
        $(".label-info").css("font-size", figuresSize);
        $.ajax({
            type : 'POST',
            url : 'ajaxOpsPerFigureProfessionali/ajaxAddFigure.php',
            cache : false,
            data : { 'nome' : event.item },
            success : function (msg)
            {
                if (msg !== "ok")
                {
                    printError("Errore durante l'inserimento", "Si prega di riprovare ad aggiungere la figura professionale. Ci scusiamo per il disagio");
                }
            }
        });
    });
    
    $("#figurerichieste").on("itemRemoved", function (event){
        $(".label-info").css("font-size", figuresSize);
        $.ajax({
            type : 'POST',
            url : 'ajaxOpsPerFigureProfessionali/ajaxRemoveCompanyNeed.php',
            cache : false,
            data : { 'figura' : event.item },
            success : function (msg)
            {
                if (msg !== "ok")
                {
                    printError("Errore durante la rimozione", "Si prega di riprovare a rimuovere la figura professionale. Ci scusiamo per il disagio");
                }
            }
        });
    });
    
    //nascondo i bottoni save e cancel che compaiono solo in modalità edit
    $("#cancelButton").hide();
    $("#saveButton").hide();
    
    $("#editButton").click(function(){
        
        //faccio sparire il bottone edit
        $("#editButton").hide();
        
        //faccio comprarire i bottoni save e cancel
        $("#saveButton").show();
        $("#cancelButton").show();
        
        //rendo al tabella editabile
        turnEditOn();
    });
    
    $("#saveButton").click(function(){
        
        //salvo i nuovi dati contenuti nella tabella nell'oggetto contact
        contact.first=$("#first").html();
        contact.city=$("#city").html();
        contact.address=$("#address").html();
        contact.mail=$("#mail").html();
        contact.phone=$("#phone").html();
        
        //eseguo query
        if(contact.first.length>0 && contact.city.length>0 && contact.address.length>0 && contact.mail.length>0 && contact.phone.length>0){
            $.ajax({
                type: "POST",
                url: "ajaxOps/ajax.php",
                data: contact,
                cache: false
            });
        }
        
        //esco dalla modalità edit
        exitEdit();
    });
    
    $("#cancelButton").click(function(){
        
        //rimetto i valori precedenti nella tabella
        $("#first").html(contact.first);
        $("#city").html(contact.city);
        $("#address").html(contact.last);
        $("#mail").html(contact.mail);
        $("#phone").html(contact.phone);
        
        //esco dalla modalità edit
        exitEdit();
    });
    
    function exitEdit(){
        
        //blocco la tabella
        turnEditOff();
        
        //spariscono i bottoni save e cancel
        $("#cancelButton").hide();
        $("#saveButton").hide();
        
        //compare bottone edit
        $("#editButton").show();
    }
});

function openSpecEdit(){
    $("#editButtonspec").hide();
    $("#cancelButtonspec").show();
    $("#HiddenAddBox").show("slide");
    $("#addspec").prop("disabled",false);
    $("span[data-role=\"remove\"]").fadeIn("slow");
    $("#speclist").prop("disabled",false);
}

function closeSpecEdit(){
    $("#editButtonspec").show();
    $("#cancelButtonspec").hide();
    $("span[data-role=\"remove\"]").fadeOut("fast");
    $("#HiddenAddBox").hide();
}

function openGuide()
{
    $("#SuperAlert").modal();
    var modal = $("#SuperAlert").find(".modal-body");
    
    $("#SuperAlert").find(".modal-title").html("Cosa devo fare?");
    modal.html("Per aggiungere una qualsiasi figura professionale tra quelle desiderate, basta scriverla nella casella di testo (ad esempio \"Programmatore\") e premere Invio.<br>\n\
                Per eliminarne una tra quelle correnti, cliccare sull'icona \"x\" situata sulla destra di ognuna.");
}