<?php
/**
 * Created by PhpStorm.
 * User: Everton
 * Date: 07/11/2018
 * Time: 01:19
 */
?>

<script type="text/javascript">

    $(document).ready(function ()
    {
        AtualizarGridAgendamento();

        $("#adicionar").click(function ()
        {
            DialogFormulario({
                urlConteudo: "index.php?app_modulo=agendamento&app_comando=frm_adicionar_agendamento",
                titulo:      "Adicionar Agendamento",
                width:       "65vw",
                closeable:   true,
                botoes:      [{
                    item:     "<button type='button'></button>",
                    event:    "click",
                    btnclass: "btn btn-primary btn-salvar",
                    btntext:  "Salvar",
                    callback: function (event)
                    {
                        ExecutarAcaoAgendamento(event.data, "index.php?app_modulo=agendamento&app_comando=adicionar_agendamento", true);
                    }
                }]
            });
        });

        $("#excluir").click(function ()
        {
            var id = [];
            var x = 0;

            $(".checkbox-lis").each(function ()
            {
                if ($(this).is(":checked") === true)
                {
                    id[x] = $(this).val();
                    x++;
                }
            });

            if (id != "") {
                ConfirmModal('Aviso', 'Tem certeza que deseja executar essa ação?', 'Excluir', id);
            } else {
                toastr.warning('Nenhum registro foi selecionado!', 'Atenção');
            }
        });
    });

    function AlternarBackground(nav)
    {
        if (nav == '0')
            $("#background_listagem_agendamento").css('background-color', '#ebefed');
        else
            $("#background_listagem_agendamento").css('background-color', '#fff');
    }

    function AtualizarGridAgendamento(pagina, busca, filtro, ordem)
    {
        if (pagina === undefined) pagina = "";
        if (ordem === undefined)  ordem = "";
        if (busca === undefined)  busca = "";
        if (filtro === undefined) filtro = "";

        var post = {
            pagina : pagina,
            busca  : busca,
            filtro : filtro,
            ordem : ordem
        };

        $("#conteudo_agendamento").load("index.php?app_modulo=agendamento&app_comando=ajax_listar_agendamento", post);
    }

    function Excluir(id)
    {
        $.post("index.php?app_modulo=agendamento&app_comando=deletar_agendamento&id="+id,
            function (response)
            {
                if(response['codigo'] == 1)
                {
                    AtualizarGridAgendamento();
                    toastr.success(response["mensagem"], "Sucesso");
                }
                else
                {
                    toastr.warning(response["mensagem"], "Erro");
                }
            }, "json"
        );
    }

    var handleCalendarDemo = function() {

        $('#external-events .fc-event').each(function() {

            $(this).data('event', {
                title: $.trim($(this).text()), // use the element's text as the event title
                stick: true, // maintain when user navigates (see docs on the renderEvent method)
                color: ($(this).attr('data-color')) ? $(this).attr('data-color') : ''
            });
            $(this).draggable({
                zIndex: 999,
                revert: true,      // will cause the event to go back to its
                revertDuration: 0  //  original position after the drag
            });
        });

        var date = new Date();
        var currentYear = date.getFullYear();
        var currentMonth = date.getMonth() + 1;
        currentMonth = (currentMonth < 10) ? '0' + currentMonth : currentMonth;

        $('#calendar').fullCalendar({
            height: 550,
            lang: 'pt-br',
            header: {
                left: 'month,agendaWeek,agendaDay',
                center: 'title',
                right: 'prev,today,next '
            },
            buttonText: {
                today:    'Hoje',
                month:    'Mês',
                week:     'Semana',
                day:      'Dia'
            },
            droppable: true, // this allows things to be dropped onto the calendar
            drop: function() {
                $(this).remove();
            },
            selectable: true,
            selectHelper: true,
            select: function(start, end)
            {
                var inicio = $.fullCalendar.formatRange(start, start, 'DD/MM//YYYY HH:mm:ss');
                var fim = $.fullCalendar.formatRange(end, end, 'DD/MM//YYYY HH:mm:ss');

                DialogFormulario({
                    urlConteudo: "index.php?app_modulo=agendamento&app_comando=frm_adicionar_agendamento",
                    data: {data_inicial:inicio, data_final:fim},
                    titulo:      "Adicionar Agendamento",
                    width:       "65vw",
                    closeable:   true,
                    botoes:      [{
                        item:     "<button type='button'></button>",
                        event:    "click",
                        btnclass: "btn btn-primary btn-salvar",
                        btntext:  "Salvar",
                        callback: function (event)
                        {
                            ExecutarAcaoAgendamento(event.data, "index.php?app_modulo=agendamento&app_comando=adicionar_agendamento");
                        }
                    }]
                });
            },
            editable: true,
            eventLimit: true, // allow "more" link when too many events
            events: function(start, end, timezone, callback)
            {
                $.ajax({
                    url: 'index.php?app_modulo=agendamento&app_comando=ajax_listar_calendario_agendamento',
                    type: 'POST',
                    dataType: 'json',
                    data: {
                        // our hypothetical feed requires UNIX timestamps
                        start: start.format('YYYY-MM-DD HH:mm:ss'),
                        end: end.format('YYYY-MM-DD HH:mm:ss')
                    },
                    success: function(doc) {
                        var events = [];
                        $(doc).each(function()
                        {
                            //ATRIBUI COR AO EVENTO
                            var cor = $(this).attr('color');
                            if (cor === 'COLOR_GREEN')
                                cor = COLOR_GREEN;
                            if (cor === 'COLOR_BLUE')
                                cor = COLOR_BLUE;
                            if (cor === 'COLOR_RED')
                                cor = COLOR_RED;

                            events.push({
                                title: $(this).attr('title'),
                                start: $(this).attr('start'),
                                end: $(this).attr('end'),
                                id: $(this).attr('id'),
                                color: cor
                            });
                        });
                        callback(events);
                    }
                });
            },
            eventClick: function(event, element)
            {
                var id = event.id;
                DialogFormulario({
                    urlConteudo: "index.php?app_modulo=agendamento&app_comando=frm_editar_agendamento",
                    data: {id:id},
                    titulo:      "Modificar Agendamento",
                    width:       "65vw",
                    closeable:   true,
                    botoes:      [{
                        item:     "<button type='button'></button>",
                        event:    "click",
                        btnclass: "btn btn-primary btn-salvar",
                        btntext:  "Salvar",
                        callback: function (event)
                        {
                            ExecutarAcaoAgendamento(event.data, "index.php?app_modulo=agendamento&app_comando=editar_agendamento&id="+id);
                        }
                    }]
                });
            },
            eventDrop: function (event, element)
            {
                var inicio = $.fullCalendar.formatRange(event.start, event.start, 'YYYY-MM-DD HH:mm:ss');
                var fim = $.fullCalendar.formatRange(event.end, event.end, 'YYYY-MM-DD HH:mm:ss');
                var id = event.id;

                $.ajax({
                    type: "POST",
                    url: 'index.php?app_modulo=agendamento&app_comando=editar_data_agendamento',
                    data: {id : id, data_inicial : inicio, data_final : fim},
                    success: function ()
                    {
                        $('#calendar').fullCalendar('refetchEvents');
                        AtualizarGridAgendamento();
                    }
                });
            }
        });
    };

    var Calendar = function () {
        "use strict";
        return {
            //main function
            init: function () {
                handleCalendarDemo();
            }
        };
    }();
</script>
