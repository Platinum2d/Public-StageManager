contact = {
		'first': '',
		'last': '',
        'mail': '',
        'phone': ''
};

$(document).ready(function(){
	
	contact.first=$("#first").html();
	contact.last=$("#last").html();
	contact.mail=$("#mail").html();
	contact.phone=$("#phone").html();
	
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
		$("#myInformations td").attr('contenteditable', 'true').addClass("editCell");
	});
	
	$("#saveButton").click(function(){

		//salvo i nuovi dati contenuti nella tabella nell'oggetto contact
		contact.first=$("#first").html();
		contact.last=$("#last").html();
		contact.mail=$("#mail").html();
		contact.phone=$("#phone").html();
		
		//eseguo query
		if(contact.first.length>0 && contact.last.length>0 && contact.mail.length>0 && contact.phone.length>0){
            $.ajax({
                type: "POST",
                url: "ajax.php",
                data: contact,
                cache: false,
                success : function (msg)
                {
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
		$("#mail").html(contact.mail);
		$("#phone").html(contact.phone);
		
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