function checkEquals () {
    var email = ""+$("input[name=mail]").val();
    var confermamail = ""+$("input[name=confermamail]").val();
    if (email !== confermamail || !email.trim() || !confermamail.trim()) {
    	document.getElementById("send").disabled = true;
    }
    else {
    	document.getElementById("send").disabled = false;
    }
}

$(document).ready(function() {
	$("input[name=mail]").keyup (checkEquals);
	$("input[name=confermamail]").keyup (checkEquals);
});