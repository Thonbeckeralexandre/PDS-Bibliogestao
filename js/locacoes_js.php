<script>
    var tab_locacoes;

    $.limpa_cad = function() {
        $('#id_locacao').val('');
        $('#obs_locacao').val('');
        $.carrega_select_livros('', 'L');
        $.carrega_select_locatario('', 'L');
    }

    $.limpa_cad_devolucao = function() {
        $('#id_devolucao').val('');
        $('#obs_devolucao').val('');
        $.carrega_select_livros('', 'D');
        $.carrega_select_locatario('', 'D');
    }

    $(".btn_voltar").click(function() {
        $('#panel_locacoes').css('display', 'block'); 
        $('#panel_locacao').css('display', 'none'); 
        $('#panel_devolucao').css('display', 'none');
        $.carrega_tabela_locacoes();
    })
    
    $("#btn_tab_locacao").click(function() {
        $('#panel_locacao').css('display', 'block');        
        $('#panel_locacoes').css('display', 'none');
        $.limpa_cad();
    })

    $.carrega_select_livros = function(array_livros, funcao, id_locacao) {
        $('.select_livros').empty();

        $.ajax({
            type: 'POST',
            dataType: 'JSON',
            url: '/bll/bll_livros.php',
            data: {
                'acao': 'carrega_select',
                'funcao': funcao,
                ex_locacao: id_locacao
            },
            success: function(dados) {
                $.each(dados, function(key, value) {
                    $('.select_livros').append($('<option>', {
                        value: value.id_livro,
                        text: value.nome + ' - Código: ' + value.codigo
                    }));

                    if (array_livros) {
                        $.each(array_livros, function(key, value2) {
                            if (value.id_livro == value2) {
                                $(".select_livros option[value='" + value2 + "']")
                                    .prop({
                                        selected: 'selected'
                                    });
                            }
                        });
                    }
                });
            },
            complete: function() {
                $(".select_livros").select2({
                    multiple: true,
                    placeholder: "Livros...",
                    allowClear: true
                }).on('change', function(e) {
                    $(this).valid();
                });
            },
            error: function(xhr) {
                Swal.fire(
                    'Erro!',
                    "Nao foi possivel preencher os Livros...",
                    'error'
                ).then(function() {
                    return false;
                });
            }
        });
    };

    $.carrega_select_locatario = function(locatario, funcao) {

        $('.select_locatario').empty();

        $('.select_locatario').append($('<option>', {
            value: '',
            text: ''
        }));

        $.ajax({
            type: 'POST',
            dataType: 'JSON',
            async: false,
            url: '/bll/bll_locatarios.php',
            data: {
                'acao': 'carrega_select',
                'funcao': funcao
            },
            success: function(dados) {
                $.each(dados, function(key, value) {
                    $('.select_locatario').append($('<option>', {
                        value: value.id_locatario,
                        text: value.nome + ' - Código: ' + value.codigo
                    }));
                    if (value.id_locatario === locatario) {
                        $(".select_locatario option[value='" + locatario + "']").prop({
                            selected: 'selected'
                        });
                    }
                });
            },
            complete: function() {
                $('.select_locatario').select2({
                    placeholder: "Locatário...",
                    allowClear: true,
                    language: "pt-BR"
                });
            },
            error: function(xhr) {
                Swal.fire(
                    'Erro!',
                    "Nao foi possivel encontrar locatários...",
                    'error'
                ).then(function() {
                    return false;
                });
            }
        });
    }

    $.inserir = function() {

        var frm = $('#form_locacao');

        $('#form_locacao').ajaxForm({
            type: 'POST',
            dataType: 'JSON',
            'url': '/bll/bll_locacoes.php',
            data: {
                'acao': 'inserir',
                'array_livros': $('#select_livros').val()
            },
            beforeSend: function() {

                console.log('enviando...');
            },
            success: function(response) {

                if (response.resposta == "sucesso") {
                    $('#id_locacao').val(response.id_locacao);
                    Swal.fire('Sucesso!', 'Locação realizada com sucesso!', 'success');
                    $.limpa_cad();
                }
            },
            complete: function() {},
            error: function(xhr) {
                Swal.fire(
                    'Erro!',
                    "Nao foi possivel realizar locação!",
                    'error'
                );
            }
        }).submit();
    }

    $.devolucao = function() {

        var frm = $('#form_devolucao');

        $('#form_devolucao').ajaxForm({
            type: 'POST',
            dataType: 'JSON',
            'url': '/bll/bll_locacoes.php',
            data: {
                'acao': 'devolucao',
                'array_livros_devolucao': $('#select_livros_devolucao').val()
            },
            beforeSend: function() {

                console.log('enviando...');
            },
            success: function(response) {

                if (response.resposta == "sucesso") {
                    $('#id_locacao').val(response.id_locacao);
                    Swal.fire('Sucesso!', 'Devolução realizada com sucesso!', 'success');
                    $.limpa_cad_devolucao();
                }
            },
            complete: function() {},
            error: function(xhr) {
                Swal.fire(
                    'Erro!',
                    "Nao foi possivel realizar devolução!",
                    'error'
                );
            }
        }).submit();
    }

    $('#btn_salvar').click(function() {

        if ($('#form_locacao').valid()) {
            Swal.fire({
                title: 'Deseja realizar a locação?',
                text: "Você poderá reverter isso depois...",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Sim, salvar agora',
                cancelButtonText: 'Cancelar', 
            }).then((result) => {
                if (result.isConfirmed) {
                    $.inserir();
                    $('#panel_locacoes').css('display', 'block'); 
                    $('#panel_locacao').css('display', 'none');
                    $.carrega_tabela_locacoes();
                }
            });
            $('.swal2-container').css("z-index", "99999999");
        } else {
            Swal.fire(
                'Erro!',
                "Existe algum campo com erro, por favor verifique...",
                'error'
            ).then(function() {
                return false;
            })
        }
    });

    $('#btn_devolucao').click(function() {

        if ($('#form_devolucao').valid()) {
            Swal.fire({
                title: 'Deseja realizar a devolução?',
                text: "Você poderá reverter isso depois...",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Sim, salvar agora',
                cancelButtonText: 'Cancelar', 
            }).then((result) => {
                if (result.isConfirmed) {
                    $.devolucao();
                    $('#panel_locacoes').css('display', 'block');
                    $('#panel_devolucao').css('display', 'none');
                    $.carrega_tabela_locacoes();
                }
            });
            $('.swal2-container').css("z-index", "99999999");
        } else {
            Swal.fire(
                'Erro!',
                "Existe algum campo com erro, por favor verifique...",
                'error'
            ).then(function() {
                return false;
            })
        }
    });

    $.carrega_tabela_locacoes = function() {
        if ($("#filtro_status").val() == 'A') {
            $("#livros_tab_locacoes").html('LIVROS EM HAVER');
        } else {
            $("#livros_tab_locacoes").html('LIVROS');
        }
        if (tab_locacoes) {
            tab_locacoes.destroy();
        }
        tab_locacoes = $('#tab_locacoes').DataTable({
            "pageLength": 10,
            ordering: true,
            searching: true,
            responsive: true,
            "processing": true,
            ajax: {
                'type': 'POST',
                'dataType': 'json',
                'url': '/bll/bll_locacoes.php',
                'data': {
                    'acao': 'carrega_datatable',
                    status: $("#filtro_status").val()
                }
            },
            columns: [
                { data: 'locatario' },
                { data: 'livros' },
                { data: 'datahora_locacao' },
                { data: 'funcoes' }
            ],
            'language': {
                "url": "/js/js_tabela_pt_br.json"
            }
        });
    };
    $.carrega_tabela_locacoes();

    $("#filtro_status").change(() => {
        $.carrega_tabela_locacoes($("#filtro_status").val());
    })

    $("#select_locatario").change(() => {
        $.post(
            '/bll/bll_locacoes.php', {
                'acao': 'verifica_locatario',
                locatario: $("#select_locatario").val()
            }
        )
        .done((resposta) => {
            if (resposta == 'false') {
                $.carrega_select_locatario('', 'L');
                Swal.fire('Erro!', "Locatário já possui locação ativa...", 'error')
            }
        })
        .fail(() => {
            Swal.fire('Erro!', "Erro ao enviar requisição...", 'error')
        })
    })

    $('[href="#demo-tabs-box-1"]').click(function(e) {
        e.preventDefault();
        $("#panel_locacoes").css('display', 'block');
        $("#panel_locacao").css('display', 'none');        
        $("#panel_devolucao").css('display', 'none');        
        $('[href="#demo-tabs-box-1"]').tab('show');
        $.carrega_tabela_locacoes();
        $("#btn_tab_locacoes").addClass('bg-dark');
    });

    $('[href="#demo-tabs-box-2"]').click(function(e) {
        e.preventDefault();
        $("#panel_locacao").css('display', 'block');
        $("#panel_locacoes").css('display', 'none');
        $("#panel_devolucao").css('display', 'none');
        $('[href="#demo-tabs-box-2"]').tab('show');
        $.limpa_cad();
        if($("#tab_locacao").attr('active', true)) {
            $("#tab_locacao").addClass('bg-dark');
        }
    });

    $('[href="#demo-tabs-box-3"]').click(function(e) {
        e.preventDefault();
        $("#panel_devolucao").css('display', 'block');
        $("#panel_locacoes").css('display', 'none');
        $("#panel_locacao").css('display', 'none');
        $('[href="#demo-tabs-box-3"]').tab('show');
        $.limpa_cad_devolucao();
        if($("#tab_devolucao").attr('active', true)) {
            $("#tab_devolucao").addClass('bg-dark');
        }
    });

    function realizar_devolucao(locatario, array_livros, id_locacao) {
        $("#panel_devolucao").css('display', 'block');
        $("#panel_locacoes").css('display', 'none');
        $("#panel_locacao").css('display', 'none');
        $('#id_devolucao').val(id_locacao);
        $("#div_select_livros_devolucao").css('display', 'block');
        $('[href="#demo-tabs-box-3"]').tab('show');
        $.carrega_select_locatario(locatario, 'D');
        $.carrega_select_livros(array_livros, 'D', id_locacao);
        if($("#tab_devolucao").attr('active', true)) {
            $("#tab_devolucao").addClass('bg-dark');
        }
    };

    function abre_obs(ex_locacao) {
        $.ajax({
            type: 'POST',
            dataType: 'JSON',
            url: "/bll/bll_devolucoes.php",
            data: {
                'acao': 'carrega_objeto',
                ex_locacao: ex_locacao
            },
            success: function(data) {
                $('#modal_obs_devolucao').modal('show');
                $('#obs_modal').val(data.obs);
            },

            error: function() {                
                Swal.fire('Erro!', "Erro ao enviar requisição...", 'error');
            }
        });
    };
    

    $('#select_locatario_devolucao').change(function() {
        if($('#select_locatario_devolucao').val()) {
            $("#select_livros_devolucao").css('display', 'block');
        }
    });

    $(".close").click(function() {
        $(".modal").modal('hide');
    })
</script>