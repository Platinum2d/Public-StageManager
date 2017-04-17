tutor = {
    'id' :       '',
    'password' :       '',
    'username' : '',
    'nome' :     '',
    'cognome' :  '',
    'telefono' : '',
    'mail' :     ''
}

function openEdit (id, idTutor)
{
    var numberId = id;
    
    $("#VisibleBox"+numberId).append("\
    <div id=\"HiddenBox"+numberId+"\">\n\
        <div class=\"row\">\n\
            <div class=\"col col-sm-12\">\n\
                <div class=\"row\">\n\
                    <div class=\"col col-sm-6\">\n\
                        <label id=\"userlabel"+numberId+"\">Username</label> <input placeholder=\"Username\" type=\"text\" class=\"form-control\" id=\"username"+numberId+"\">\n\
                        Password <input placeholder=\"Password (lasciare vuoto per nessuna modifica)\" type=\"password\" class=\"form-control\" id=\"password"+numberId+"\">\n\
                        Nome <input placeholder=\"Nome\" type=\"text\" class=\"form-control\" id=\"nome"+numberId+"\">\n\
                        Cognome <input placeholder=\"Cognome\" type=\"text\" class=\"form-control\" id=\"cognome"+numberId+"\">\n\
                     </div>\n\
                     <div class=\"col col-sm-6\">\n\
                        Telefono <input placeholder=\"Telefono\" type=\"text\" class=\"form-control\" id=\"telefono"+numberId+"\">\n\
                        E-mail <input placeholder=\"E-Mail\" type=\"text\" class=\"form-control\" id=\"email"+numberId+"\">\n\
                     </div>\n\
                </div>\n\
                        <button class=\"btn btn-danger btn-sm rightAlignment margin buttonfix\" onclick=\"closeEdit("+numberId+")\"> <span class=\"glyphicon glyphicon-remove\"> </span> </button>\n\
                        <button class=\"btn btn-success btn-sm rightAlignment margin buttonfix\"  onclick=\" sendData("+idTutor+","+numberId+")\"> <span class=\"glyphicon glyphicon-ok\"> </span> </button>\n\
            </div>\n\
        </div>\n\
    </div>");
    $("#modifica"+numberId).prop('disabled',true);
    $("#HiddenBox"+numberId).hide();
    setOnChangeEvents(numberId);
    
    $.ajax({
        type : 'POST',
        url : 'ajaxOpsPerTutor/getData.php',
        data : {'idtutor' : idTutor},
        cache : false,
        success : function (xml)
        {
            $(xml).find('tutors').find('tutor').each(function(){
                $("#username"+numberId).val(($(this).find('username').text()));
                $("#username"+numberId).attr('name',$(xml).find('username').text());
                $("#nome"+numberId).val(($(this).find('nome').text()));
                $("#cognome"+numberId).val(($(this).find('cognome').text()));
                $("#telefono"+numberId).val(($(this).find('telefono').text()));
                $("#email"+numberId).val(($(this).find('email').text()));
                $("#username"+numberId).on("input", function (){
                    $.ajax({
                        type : 'POST',
                        url : 'ajaxOpsPerTutor/ajaxCheckUserExistence.php',
                        cache : false,
                        data : { 'user' : $("#username"+numberId).val(), 'original' : $("#username"+numberId).attr("name") },
                        success : function(msg){
                            if (msg === "trovato")
                            {                    
                                $("#userlabel"+numberId).css("color", "red");
                                $("#userlabel"+numberId).html("username (esiste gia')");
                            }
                            else
                            {
                                $("#userlabel"+numberId).css("color", "#828282");
                                $("#userlabel"+numberId).html("username");
                            }
                        }
                    });
                });
            });
        },
        error : function()
        {
            alert("errore")
        }
    });
    $("#HiddenBox"+numberId).fadeIn("slow");
    $("#ButtonBox"+numberId).height($("#ButtonBox"+numberId).height() + $("#HiddenBox"+numberId).height());
}

function closeEdit (numberId)
{
    $("#ButtonBox"+numberId).height($("#ButtonBox"+numberId).height() - $("#HiddenBox"+numberId).height());
    $("#HiddenBox"+numberId ).remove();
    $("#modifica"+numberId).prop("disabled",false);
    $("#elimina"+numberId).prop("disabled",false);
    $("#registro"+numberId).prop("disabled",false);
}

function sendData(idTutor, numberId)
{
    String.prototype.isEmpty = function() {
        return (this.length === 0 || !this.trim());
    };
    
    tutor.id = idTutor;
    tutor.username = $("#username"+numberId).val();
    tutor.password = ($("#password"+numberId).val().isEmpty()) ? "immutato" : $("#password"+numberId).val();
    tutor.nome = $("#nome"+numberId).val();
    tutor.cognome = $("#cognome"+numberId).val();
    tutor.telefono = $("#telefono"+numberId).val();
    tutor.mail = $("#email"+numberId).val();
    
    if (!tutor.username.isEmpty() && !tutor.nome.isEmpty() && !tutor.nome.isEmpty() && !tutor.cognome.isEmpty())
    {
        
        $.ajax({
            type : 'POST',
            url : 'ajaxOpsPerTutor/ajaxInvia.php',
            data : tutor,
            success : function (msg)
            {
                if (msg === "Inserimento dei dati riuscito!")
                {
                    $("#label"+numberId).html($("#cognome"+numberId).val() + " " + $("#nome"+numberId).val() + " ("+$("#username"+numberId).val()+")");
                }
                resetColors(numberId);
            }
        });
    }
}

function askForDeleteTutor(idTutor, progressiv)
{
    $("#SuperAlert").modal("show");
    var modal = $("#SuperAlert").find(".modal-body");
    $("#SuperAlert").find(".modal-title").html("ATTENZIONE");
    modal.html("<div align='center'><u>ATTENZIONE</u></div>\n\
                <br>\n\
                Eliminando questo tutor, verranno persi \n\
                <ul>\n\
                    <li>Tutti i suoi dati personali e l'immagine di profilo</li>\n\
                    <li>Tutte le assegnazioni agli studenti che lo riguardano</li>\n\
                </ul>\n\
                <br>\n\
                <u>Verranno conservati</u>\n\
                <ul>\n\
                    <li>I registri delle attività</li>\n\
                    <li>Le valutazioni rilasciate agli studenti</li>\n\
                </ul>\n\
                <br>\n\
                <div align='center'>Le informazioni conservate saranno nuovamente accessibili quando gli studenti assegnati al tutor che si intende cancellare verranno assegnati a dei nuovi tutor</div>\n\
");
    $("#SuperAlert").find(".modal-footer").html("<div class='row'> \n\
                                                    <div class='col col-sm-6' align='left'><h3 style='display:inline'>Procedere?</h3></div>\n\
                                                    <div class='col col-sm-6'> \n\
                                                        <button class='btn btn-success' onclick=\"deleteTutor("+idTutor+", "+progressiv+")\">Si</button>\n\
                                                        <button class='btn btn-danger' data-dismiss='modal'>No</button>\n\
                                                    </div> \n\
                                                 </div>");
}

function deleteTutor(idTutor, progressiv)
{    
    $.ajax({
        type : 'POST',
        url : 'ajaxOpsPerTutor/ajaxElimina.php',
        data : {'idtutor' : idTutor},
        success : function (msg)
        {
            if (msg === "ok")
            {
                printSuccess("Eliminazione riuscita", "<div align='center'>Il tutor è stato eliminato correttamente!</div>", function (){
                    $("#riga"+progressiv).fadeOut("slow");
                });
                $("#SuperAlert").find(".modal-footer").html("<button type='button' class='btn btn-default' data-dismiss='modal'>Chiudi</button>");
            }
            else
            {
                printError("Eliminazione fallita", "<div align='center'>Si prega di segnalare l'errore e contattare l'amministratore</div>");
                $("#SuperAlert").find(".modal-footer").html("<button type='button' class='btn btn-default' data-dismiss='modal'>Chiudi</button>");
            }
        }
    });
}

function setOnChangeEvents(numberId)
{
    $("#username"+numberId).on('input', ((function (e){ $("#username"+numberId).css('color','red'); })));
    $("#nome"+numberId).on('input', ((function (e){ $("#nome"+numberId).css('color','red'); })));
    $("#password"+numberId).on('input', ((function (e){ $("#password"+numberId).css('color','red'); })));
    $("#cognome"+numberId).on('input', ((function (e){ $("#cognome"+numberId).css('color','red'); })));
    $("#email"+numberId).on('input', ((function (e){ $("#email"+numberId).css('color','red'); })));
    $("#telefono"+numberId).on('input', ((function (e){ $("#telefono"+numberId).css('color','red'); })));
}

function resetColors(numberId)
{
    $("#username"+numberId).css('color','#555');
    $("#password"+numberId).css('color','#555');
    $("#nome"+numberId).css('color','#555');
    $("#cognome"+numberId).css('color','#555');
    $("#telefono"+numberId).css('color','#555');
    $("#email"+numberId).css('color','#555');
}