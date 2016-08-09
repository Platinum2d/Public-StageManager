contact = {
    'first': '',
    'last': '',
    'city': '',
    'mail': '',
    'phone': '',
    'preference': ''
};

$(document).ready(function(){
    
    contact.first=$("#first").html();
    contact.last=$("#last").html();
    contact.city=$("#city").html();
    contact.mail=$("#mail").html();
    contact.phone=$("#phone").html();
    contact.preference=$("#preference").html();
    
    //nascondo i bottoni save e cancel che compaiono solo in modalità edit
    $("#cancelButton").hide();
    $("#saveButton").hide();
    
    $("#editButton").click(function(){
        
        //faccio sparire il bottone edit
        $('#preferenza').prop('disabled', false);		
        
        $("#editButton").hide();
        
        //faccio comprarire i bottoni save e cancel
        $("#saveButton").show();
        $("#cancelButton").show();
        
        //rendo al tabella editabile
        $("#myInformations td").attr('contenteditable', 'true').addClass("editCell");
        $("#preference").attr('contenteditable', 'false');
        $('#preferenza').css('color', '#DB2525');
    });
    
    $("#saveButton").click(function(){
        
        //salvo i nuovi dati contenuti nella tabella nell'oggetto contact
        $('#preferenza').prop('disabled', true);
        $('#preferenza').css('color', '#828282');
        contact.first=$("#first").html();
        contact.last=$("#last").html();
        contact.city=$("#city").html();
        contact.mail=$("#mail").html();
        contact.phone=$("#phone").html();
        contact.preference=$("#preferenza").val();
        
        //eseguo query
        if(contact.first.length>0 && contact.last.length>0 && contact.city.length>0 && contact.mail.length>0 && contact.phone.length>0){
            $.ajax({
                type: "POST",
                url: "ajax.php",
                data: contact,
                cache: false,
                success : function(msg)
                {
                    //alert(msg);
                }
            });
        }
        
        //esco dalla modalità edit
        exitEdit();
    });
    
    $("#cancelButton").click(function(){
        
        //rimetto i valori precedenti nella tabella
        $("#first").html(contact.first);
        $("#last").html(contact.last);
        $("#city").html(contact.city);
        $("#mail").html(contact.mail);
        $("#phone").html(contact.phone);
        $("#preference").html(contact.preference);
        
        //esco dalla modalità edit
        exitEdit();
    });
    
    function exitEdit(){
        
        //blocco la tabella
        $("#myInformations td").attr('contenteditable', 'false').removeClass("editCell");
        
        //spariscono i bottoni save e cancel
        $("#cancelButton").hide();
        $("#saveButton").hide();
        
        //compare bottone edit
        $("#editButton").show();
    }
});