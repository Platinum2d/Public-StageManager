var FadeInDuration = "fast";
var FadeOutDuration = "fast";

$(function() {
    $("#report").css("visibility", "hidden");
});

function changeTutor(idstudente, idnuovotutor)
{
    if (parseInt(idnuovotutor) !== -1)
    {
        $.ajax({
            type : 'POST',
            url : 'ajaxOps/ajaxChangeTutor.php',
            cache : false,
            data : 
                    { 
                        'idstudente' : idstudente,
                'idtutor' : idnuovotutor
            },
            success : function (msg)
            {
                if (msg === "ok")
                {
                    $("#report").css("visibility", "visible");
                    $("#report").hide();
                    $("#reportmessage").html("Operazione esguita con successo");
                    $("#reportmessage").addClass("bg-success");
                    $("#reportmessage").removeClass("bg-danger");
                    $("#report").fadeIn({
                        duration : FadeInDuration,
                        complete : function(){
                            setTimeout(function() {
                                $("#report").fadeOut({
                                    duration : FadeOutDuration,
                                    complete : function (){
                                        $("#report").show();
                                        $("#report").css("visibility", "hidden");
                                    }
                                });
                            }, 1000);
                        }
                    });
                }
                else
                {
                    $("#report").css("visibility", "visible");
                    $("#report").hide();
                    $("#reportmessage").html("Operazione fallita");
                    $("#reportmessage").addClass("bg-danger");
                    $("#reportmessage").removeClass("bg-success");
                    $("#report").fadeIn({
                        duration : FadeInDuration,
                        complete : function(){
                            setTimeout(function() {
                                $("#report").fadeOut({
                                    duration : FadeOutDuration,
                                    complete : function (){
                                        $("#report").show();
                                        $("#report").css("visibility", "hidden");
                                    }
                                });
                            }, 1000);
                        }
                    }); 
                }
            }
        });
    }
}

function freeStudent(idstudente, progressiv)
{
    $.ajax({
        type : 'POST',
        url : 'ajaxOps/ajaxFreeStudent.php',
        cache : false,
        data : 
                { 
                    'idstudente' : idstudente,
        },
        success : function (msg)
        {
            if (msg === "ok")
            {
                $("#tutor"+progressiv).val("");
                $("#report").css("visibility", "visible");
                $("#report").hide();
                $("#reportmessage").html("Operazione esguita con successo");
                $("#reportmessage").addClass("bg-success");
                $("#reportmessage").removeClass("bg-danger");
                $("#report").fadeIn({
                    duration : FadeInDuration,
                    complete : function(){
                        setTimeout(function() {
                            $("#report").fadeOut({
                                duration : FadeOutDuration,
                                complete : function (){
                                    $("#report").show();
                                    $("#report").css("visibility", "hidden");
                                }
                            });
                        }, 1000);
                    }
                });
            }
            else
            {
                $("#report").css("visibility", "visible");
                $("#report").hide();
                $("#reportmessage").html("Operazione fallita");
                $("#reportmessage").addClass("bg-danger");
                $("#reportmessage").removeClass("bg-success");
                $("#report").fadeIn({
                    duration : FadeInDuration,
                    complete : function(){
                        setTimeout(function() {
                            $("#report").fadeOut({
                                duration : FadeOutDuration,
                                complete : function (){
                                    $("#report").show();
                                    $("#report").css("visibility", "hidden");
                                }
                            });
                        }, 1000);
                    }
                }); 
            }
        }
    });
}