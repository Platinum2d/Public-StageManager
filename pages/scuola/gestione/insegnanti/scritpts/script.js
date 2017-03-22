var repeated = false;

function openInfo(progressiv, nome_classe, id_classe, id_anno)
{
    $("#SuperAlert").modal("show");
    $("#SuperAlert").find(".modal-title").html("Docenti che insegnano in "+nome_classe);
    
    var modal = $("#SuperAlert").find(".modal-body");
    
    modal.html("<div align=\"center\">\n\
                    <a style=\"color:#828282\" href=\"javascript:openAddInsegnante("+progressiv+", "+id_classe+", "+id_anno+")\"><span style=\"color:green\" class=\"glyphicon glyphicon-plus\"></span>   Aggiungi</a>\n\
                </div>")
    
    modal.append("<table style='table-layout:fixed' id='docs' class='table table-hover table-responsive'>\n\
                <thead>\n\
                    <th style='text-align : center'>Docenti assegnati</th>\n\
                    <th style='text-align : center'>Azioni</th>\n\
                </thead>\n\
                <tbody>\n\
                </tbody>\n\
            </table>\n\
            ");
    
    
    
    $.ajax({
        type : 'POST',
        url : 'ajaxOpsPerInsegnanti/ajaxDocenti.php',
        data : {'classe' : id_classe, 'anno' : id_anno},
        cache : false,
        success : function (xml)
        {
            $(xml).find("docenti").find("docente").each(function (){
                
                var id_docente = $(this).find("id").text();
                var id_chd = $(this).find("id_chd").text();
                var nome = $(this).find("nome").text();
                var cognome = $(this).find("cognome").text();
                
                $("#docs").append("<tr class='idcont' id='"+id_docente+"'>\n\
                                                <td align='center'>"+cognome+" "+nome+"</td>\n\
                                                <td align='center'><button onclick='disassegna("+id_chd+", this)' class='btn btn-danger'><span class='glyphicon glyphicon-remove'></span> Disassegna</button></td>\n\
                                              </tr>");
            });
        }
    });
    
    $("#SuperAlert").on('hidden.bs.modal', function () {
        $("#info"+progressiv).prop("disabled", false);
    });
}

function disassegna(id_chd, btn)
{
    $.ajax({
        type : 'POST',
        url : 'ajaxOpsPerInsegnanti/ajaxDisassegnaInsegnante.php',
        data : {'chd' : id_chd},
        cache : false,
        success : function (msg)
        {
            if (msg === "ok")
            {
                $(btn).parents("tr").fadeOut();
            }
        }
    });
}

function closeInfo(progressiv)
{
    $("#infoclassi"+progressiv).remove();
    $("#info"+progressiv).prop("disabled", false);
}

function openAddInsegnante(progressiv, id_classe, id_anno)
{
    if($("#addInsegnanteRow").length <= 0)
    {
        $("#docs").append("\
            <tr id='addInsegnanteRow'>\n\
                <td align='center'>\n\
                    <select style='margin-top:5px; text-align-last:center;' class='form-control' id='addInsegnanteSelect'></select>\n\
                </td>\n\
                <td align='center'> \n\
                    <button onclick='assegna("+id_classe+", "+id_anno+")' class='btn btn-success btn-sm margin buttonfix'><span class='glyphicon glyphicon-ok'></span></button>\n\
                    <button onclick='closeAddInsegnante()' class='btn btn-danger btn-sm margin buttonfix'><span class='glyphicon glyphicon-remove'></span></button>\n\
                </td>\n\
            </tr>");
        
        $.ajax({
            type : 'POST',
            url : 'ajaxOpsPerInsegnanti/ajaxDocentiScuola.php',
            cache : false,
            success : function (xml)
            {
                //alert(xml);
                $(xml).find("docenti").find("docente").each(function (){
                    var id_docente = $(this).find("id").text();
                    var nome = $(this).find("nome").text();
                    var cognome = $(this).find("cognome").text();
                    
                    localStorage.setItem("repeated", "0");
                    $(".idcont").each(function (){
                        if (this.id === id_docente)
                            localStorage.setItem("repeated", "1");
                    });
                    
                    if (localStorage.getItem("repeated") === "0")
                        $("#addInsegnanteSelect").append("<option value='"+id_docente+"'>"+cognome+" "+nome+"</option>");
                });
            }
        });
    }
}

function assegna(id_classe, id_anno)
{
    $.ajax({
        type : 'POST',
        url : 'ajaxOpsPerInsegnanti/ajaxAssegnaDocente.php',
        data : {'docente' : $("#addInsegnanteSelect").val(), 'classe' : id_classe, 'anno' : id_anno},
        cache : false,
        success : function (xml)
        {
            if($(xml).find("esito").text() === "ok")
            {
                var id_chd = $(xml).find("id_chd").text();
                
                $("#docs").append("<tr class='idcont' id='"+$("#addInsegnanteSelect").val()+"'>\n\
                        <td align='center'>"+$("#addInsegnanteSelect").find(":selected").text()+"</td>\n\
                        <td align='center'><button onclick='disassegna("+id_chd+", this)' class='btn btn-danger'><span class='glyphicon glyphicon-remove'></span> Disassegna</button></td>\n\
                     </tr>");
                
                closeAddInsegnante();
            }
        }
    });
}

function closeAddInsegnante()
{
    $("#addInsegnanteRow").remove();
}