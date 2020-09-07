<script type="text/javascript">

    //EVENTO DA TECLA ENTER
    $(document).keypress(function(e) {
        if(e.which == 13) {
            Entrar();
        }
    });

    function Entrar()
    {
        $.ajax({
            type : "POST",
            url  : "index.php?app_modulo=login&app_comando=login&login=on",
            data : {"usuario" : $("#usuario").val(), "senha" : $("#senha").val()},
            dataType :  'json',
            success : function (data)
            {
                var mensagem = data["mensagem"];
                //SUCESSO, REDIRECIONO PARA A PÁGINA INICIAL
                if(data["codigo"] == '1')
                {
                    $("#div-resposta").html("<p class='alert alert-success'><strong>"+mensagem+"</strong></p>");

                    window.open("index.php?app_modulo=home&app_comando=home&login=true", "_self");
                }
                //FRACASSO, ALERTO O ERRO
                else
                {
                    $("#div-resposta").html("<p class='alert alert-danger'><strong>"+mensagem+"</strong></p>");
                }
            }
        });
    }
</script>