contact = {
    'first': '',
    'last': '',
    'city': '',
    'mail': '',
    'phone': '',
    'preference': ''
};

$(document).ready(function(){
    $("#cancelButtonpreference").hide();
    $("input[type=\"text\"]").keydown(function (){ return false; });
    contact.first=$("#first").html();
    contact.last=$("#last").html();
    contact.city=$("#city").html();
    contact.mail=$("#mail").html();
    contact.phone=$("#phone").html();
    //contact.preference=$("#preference").html();
    $("span[data-role=\"remove\"]").css("visibility","hidden");
    
    //nascondo i bottoni save e cancel che compaiono solo in modalità edit
    $("#cancelButton").hide();
    $("#saveButton").hide();
    
    $("#editButton").click(function(){
        
        //faccio sparire il bottone edit
        //$('#preferenza').prop('disabled', false);
        $("#editButton").hide();
        $("#saveButton").show();
        $("#cancelButton").show();
        $("#myInformations td").attr('contenteditable', 'true').addClass("editCell");
    });
    
    $("#saveButton").click(function(){
        
        //salvo i nuovi dati contenuti nella tabella nell'oggetto contact
        
        //$('#preferenza').prop('disabled', true);
        //$('#preferenza').css('color', '#828282');
        //$("#addpreference").prop("disabled",true);        
        contact.first=$("#first").html();
        contact.last=$("#last").html();
        contact.city=$("#city").html();
        contact.mail=$("#mail").html();
        contact.phone=$("#phone").html();
        
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
        //$("#preference").html(contact.preference);        
        //esco dalla modalità edit
        exitEdit();
    });
    
    function exitEdit(){
        
        $("#preference").animate({
            height : $("#preference").height() - $("#HiddenAddBox").height()
        }, 500);
        //blocco la tabella
        $("#myInformations td").attr('contenteditable', 'false').removeClass("editCell");
        
        //spariscono i bottoni save e cancel
        $("#cancelButton").hide();
        $("#saveButton").hide();
        
        //compare bottone edit
        $("#editButton").show();
//        $("span[data-role=\"remove\"]").css("visibility","hidden");
//        $("input[type=\"text\"]").prop("disabled",true);
//        $("#btnaddpref").prop("disabled",true);
//        $("#HiddenAddBox").hide();
//        $("input[type=\"text\"]").keydown(function (){ return false; });

    }
});

function openPreferenceEdit(){
        $("#editButtonpreference").hide();
        $("#cancelButtonpreference").show();
        $("#HiddenAddBox").show("slide");
        $("#addpreference").prop("disabled",false);
        $("span[data-role=\"remove\"]").css("visibility","visible");
        $("#preferenceslist").prop("disabled",false)
}

function closePreferenceEdit(){
    $("#editButtonpreference").show();
    $("#cancelButtonpreference").hide();
    $("span[data-role=\"remove\"]").css("visibility","hidden");
    $("#HiddenAddBox").hide();
}