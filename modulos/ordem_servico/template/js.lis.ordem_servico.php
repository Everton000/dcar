<script type="text/javascript">

    $(document).ready(function ()
    {
        //CRIA O TOOLTIP DO BOOSTRAP EM TODOS OS ELEMENTOS COM O ATRIBUTO DATA-TOGGLE="TOOLTIP"
        $('[data-toggle="tooltip"]').tooltip();
    });

    function ModificarOrdemServico(id)
    {
        DialogFormulario({
            urlConteudo: "index.php?app_modulo=ordem_servico&app_comando=frm_editar_ordem_servico&id="+id,
            titulo:      "Modificar Ordem de Serviço",
            width:       "65vw",
            closeable:   true,
            ofset:       '10',
            botoes:      [{
                item: "<button type='button'></button>",
                event: "click",
                btnclass: "btn btn-primary btn-salvar",
                btntext: "Salvar",
                callback: function (event)
                {
                    var idClienteVeiculo = $("#id_cliente_veiculo").val();
                    ExecutarAcaoOrdemServico(event.data, "index.php?app_modulo=ordem_servico&app_comando=editar_ordem_servico&id=" + id + "&id_cliente_veiculo=" + idClienteVeiculo);
                }
            }]
        });
    }

    function ImprimirOs(idOs)
    {
        window.open('index_pdf.php?app_modulo=ordem_servico&app_comando=imprimir_os&numero_os='+idOs);
    }

</script>
