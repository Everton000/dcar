<?php
/**
 * Created by PhpStorm.
 * User: Everton
 * Date: 23/10/2018
 * Time: 23:40
 */
?>

<script type="text/javascript">

    function Callback(conteudo)
    {
        if (!("erro" in conteudo))
        {
            //ATUALIZA OS CAMPOS COM OS VALORES.
            document.getElementById('endereco').value=(conteudo.logradouro);
            document.getElementById('bairro').value=(conteudo.bairro);
            document.getElementById('cidade').value=(conteudo.localidade);
            document.getElementById('estado').value=(conteudo.uf);
//            document.getElementById('ibge').value=(conteudo.ibge);
        } //END IF.
        else
        {
            //CEP não Encontrado.
            LimpaFormularioCep();
//            alert("CEP não encontrado.");
        }
    }

    function PesquisarCep(campo)
    {
        var valor = $(campo).val();

        //NOVA VARIÁVEL "CEP" SOMENTE COM DÍGITOS.
        var cep = valor.replace(/\D/g, '');

        //VERIFICA SE CAMPO CEP POSSUI VALOR INFORMADO.
        if (cep !== "")
        {
            //EXPRESSÃO REGULAR PARA VALIDAR O CEP.
            var validacep = /^[0-9]{8}$/;

            //VALIDA O FORMATO DO CEP.
            if(validacep.test(cep))
            {
                //PREENCHE OS CAMPOS COM "..." ENQUANTO CONSULTA WEBSERVICE.
                document.getElementById('endereco').value="...";
                document.getElementById('bairro').value="...";
                document.getElementById('cidade').value="...";
                document.getElementById('estado').value="...";

                //CRIA UM ELEMENTO JAVASCRIPT.
                var script = document.createElement('script');

                //Sincroniza com o callback.
                script.src = 'https://viacep.com.br/ws/'+ cep + '/json/?callback=Callback';

                //INSERE SCRIPT NO DOCUMENTO E CARREGA O CONTEÚDO.
                document.body.appendChild(script);

            } //END IF.
            else
            {
                //CEP É INVÁLIDO.
                LimpaFormularioCep();
//                alert("Formato de CEP inválido.");
            }
        } //END IF.
        else
        {
            //CEP SEM VALOR, LIMPA FORMULÁRIO.
            LimpaFormularioCep();
        }
    }

    function LimpaFormularioCep()
    {
        //LIMPA VALORES DO FORMULÁRIO DE CEP.
        document.getElementById('endereco').value = ("");
        document.getElementById('bairro').value = ("");
        document.getElementById('cidade').value = ("");
        document.getElementById('estado').value = ("");
//        document.getElementById('ibge').value = ("");
    }
</script>
