classe = {
    'nome' : '',
    'settore' : ''
};

function addSelectionsForSettore()
{
    $.ajax({
        url : "ajaxOpsPerClasse/ajaxSettore.php",
        cache : false,
        success : function(xml)
        {
            $(xml).find("settori").find("settore").each(function (){
                $("#settoreClasse").append("<option value=\""+$(this).find("id").text()+"\"> "+$(this).find("indirizzo").text()+" - "+$(this).find("nome").text()+" </option>");
            });
        }
    });
}

function sendData()
{
    String.prototype.isEmpty = function() {
        return (this.length === 0 || !this.trim());
    };   
    classe.nome = $("#nomeClasse").val().trim();
    classe.settore = $("#settoreClasse").val();
    
    if (classe.nome.isEmpty())
    {
        printError("Errore", "<div align='center'>Si prega di inserire i campi obbligatori</div>");
        return;
    }
    
    $.ajax({
        type : "POST",
        url : "ajaxOpsPerClasse/ajaxInvia.php",
        data : classe,
        success : function(msg)
        {
            if (msg === "Inserimento dei dati riuscito!")
                freeFields();
        }
    });
}

function freeFields()
{
    printSuccess("Azione eseguita correttamente", "<div align='center'>La classe è stata inserita correttamente</div>");
    $("#nomeClasse").val('');
}