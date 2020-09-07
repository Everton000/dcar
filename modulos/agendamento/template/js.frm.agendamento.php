<?php
/**
 * Created by PhpStorm.
 * User: Everton
 * Date: 07/11/2018
 * Time: 22:15
 */
?>
<script type="text/javascript">
    $(document).ready(function ()
    {
        $('#data_inicial').datetimepicker({
            format: 'DD/MM/YYYY HH:mm'
        }).on('dp.change', function(e) {
            $('#data_final').data("DateTimePicker").minDate(e.date)
        });
        $('#data_final').datetimepicker({
            format: 'DD/MM/YYYY HH:mm'
        });

        autocomplete("cliente", "id_cliente", "index.php?app_modulo=cliente&app_comando=listar_cliente_json");

        autocomplete("veiculo", "id_veiculo", "index.php?app_modulo=veiculo&app_comando=listar_veiculo_json", $("#id_cliente"));

        if ($("#visualicao").val() === '1')
        {
            $(".btn-salvar").remove();
            $(".panel-title").text('Visualizar Agendamento');
        }
    });

    function ExecutarAcaoAgendamento(form, url, listagem = false)
    {
        if (ValidarFormulario($("#form_agendamento")))
        {
            $.post(url,
                $("#form_agendamento").serialize(),
                function (response)
                {
                    if (response["codigo"] == 1)
                    {
                        AtualizarCalendarioAgendamento();
                        AtualizarGridAgendamento();

                        toastr.success(response["mensagem"], "Sucesso");
                        form.close();
                    }
                    else {
                        toastr.warning(response["mensagem"], "Aviso");
                    }
                }, 'json'
            );
        }
    }

    function AtualizarCalendarioAgendamento()
    {
        $('#calendar').fullCalendar('refetchEvents');
    }

    function LimparVeiculo()
    {
        $("#id_veiculo").val('');
        $("#veiculo").val('');
    }

</script>
