<script>
    var tab_locatarios;

    $.limpa_cad = function() {
        $('#nome').val('');
        $('#endereco').val('');
        $('#responsavel').val('');
        $('#telefone').val('');
        $('#email').val('');
        $('#codigo').val('');
        $('#id_locatario').val('');
        $.carrega_select_tipo_locatario('');
    }
    
    $("#btn_voltar").click(function() {
        $('#painel_list').css('display', 'block'); 
        $('#panel_cad_locatario').css('display', 'none');
        $.carrega_tabela_locatarios();
    })
    
    $("#btn_cad_locatario").click(function() {
        $('#painel_list').css('display', 'none'); 
        $('#panel_cad_locatario').css('display', 'block');
        $.limpa_cad();
    })

    $("#btn_add_tipo_locatario").click(function() {
        $('#modal_add_tipo_locatario').modal('show');
        $('#tipo_locatario').val('');
        $('#id_tipo_locatario').val('');
    })

    $(".close").click(function() {
        $(".modal").modal('hide');
    })

    $.carrega_tabela_locatarios = function() {
        if (tab_locatarios) {
            tab_locatarios.destroy();
        }
        tab_locatarios = $('#tab_locatarios').DataTable({
            "pageLength": 10,
            ordering: true,
            searching: true,
            responsive: true,
            "processing": true,
            ajax: {
                'type': 'POST',
                'dataType': 'json',
                'url': '/bll/bll_locatarios.php',
                'data': {
                    'acao': 'carrega_datatable_locatarios'
                }
            },
            columns: [
                { data: 'nome' },
                { data: 'telefone' },
                { data: 'tipo' },
                { data: 'codigo' },
                { data: 'funcoes' }
            ],
            'language': {
                "url": "/js/js_tabela_pt_br.json"
            }
        });
    };
    $.carrega_tabela_locatarios();

    $.carrega_select_tipo_locatario = function(tipo) {
        console.log(tipo);

        $('#select_tipo').empty();

        $('#select_tipo').append($('<option>', {
            value: '',
            text: ''
        }));

        $.ajax({
            type: 'POST',
            dataType: 'JSON',
            async: false,
            url: '/bll/bll_tipo_locatario.php',
            data: {
                'acao': 'carrega_selected'
            },
            success: function(dados) {
                $.each(dados, function(key, value) {
                    $('#select_tipo').append($('<option>', {
                        value: value.id_tipo_locatario,
                        text: value.tipo
                    }));
                    if (value.id_tipo_locatario === tipo) {
                        $("#select_tipo option[value='" + tipo + "']").prop({
                            selected: 'selected'
                        });
                    }
                });
            },
            complete: function() {
                $('#select_tipo').select2({
                    placeholder: "Tipo...",
                    allowClear: true,
                    language: "pt-BR"
                });
            },
            error: function(xhr) {
                Swal.fire(
                    'Erro!',
                    "Nao foi possivel preencher as categorias...",
                    'error'
                ).then(function() {
                    return false;
                });
            }
        });
    }

    $.inserir = function() {

        var frm = $('#form_cad_locatario');

        $('#form_cad_locatario').ajaxForm({
            type: 'POST',
            dataType: 'JSON',
            'url': '/bll/bll_locatarios.php',
            data: {
                'acao': 'inserir'
            },
            beforeSend: function() {

                console.log('enviando...');
            },
            success: function(response) {

                if (response.resposta == "sucesso") {
                    $('#id_locatario').val(response.id_locatario);
                    Swal.fire('Sucesso!', 'Dados salvos com sucesso!', 'success');
                    $('#painel_list').css('display', 'block'); 
                    $('#panel_cad_locatario').css('display', 'none');
                    $.carrega_tabela_locatarios();
                }
            },
            complete: function() {},
            error: function(xhr) {
                Swal.fire(
                    'Erro!',
                    "Nao foi possivel Salvar as informações",
                    'error'
                );
            }
        }).submit();
    }

    $('#btn_salvar').click(function() {

        if ($('#form_cad_locatario').valid()) {
            Swal.fire({
                title: 'Você tem certeza que deseja salvar?',
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
                    $.carrega_tabela_locatarios();
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

    $("#btn_salvar_tipo_locatario").click(function() {
        Swal.fire({
            title: 'Você tem certeza?',
            text: "Você salvará um novo tipo de locatário. Deseja continuar?",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Sim',
            cancelButtonText: 'Cancelar'
        }).then((result) => {
            if (result.isConfirmed) {
                if ($("#tipo_locatario").val()) {
                    $.ajax({
                        type: 'POST',
                        dataType: 'JSON',
                        'url': '/bll/bll_tipo_locatario.php',
                        data: {
                            'acao': 'inserir',
                            'tipo_locatario': $('#tipo_locatario').val()
                        },
                        success: function(dados) {
                            if (dados) {
                                Swal.fire(
                                'Sucesso!',
                                "Tipo de Locatário inserido com sucesso!",
                                'success'
                                )
                                $('#modal_add_tipo_locatario').modal('hide');
                                $.carrega_select_tipo_locatario();
                            }
                        },
                        error: function() {
                            Swal.fire(
                                'Erro!',
                                "Erro ao enviar requisição...",
                                'error'
                            )
                        }
                    });
                } else {
                    Swal.fire(
                        'Erro!',
                        "Preencha todos os campos...",
                        'error'
                    )
                }
            }
        });
        $('.swal2-container').css("z-index", "99999999");
    });

    function editar_locatario(id_locatario) {

        $('#form_cad_locatario').children(".row").children(".form-group").each(function() {
            ($(this)).removeClass('bold has-feedback has-error has-success');
            ($(this)).children("span").remove("span.error");
        });
        
        $.limpa_cad();

        $.ajax({
            type: 'POST',
            dataType: 'JSON',
            url: "/bll/bll_locatarios.php",
            data: {
                'acao': 'carrega_objeto',
                id_locatario: id_locatario
            },
            success: function(data) {

                $('#painel_list').css('display', 'none'); 
                $('#panel_cad_locatario').css('display', 'block');
                $('#id_locatario').val(data.id_locatario);
                $("#nome").val(data.nome);
                $("#endereco").val(data.endereco);
                $("#telefone").val(data.telefone);
                $("#responsavel").val(data.responsavel);
                $("#email").val(data.email);
                $("#codigo").val(data.codigo);
                $.carrega_select_tipo_locatario(data.ex_tipo);
            },

            error: function() {
                Swal.fire(
                    'Erro!',
                    "Não foi possivel abrir esse locatário para editar...",
                    'error'
                )
            }
        });
    };

    $("#codigo").focusout(function() {
        if ($("#codigo").val() != '') {
            $.ajax({
                type: "POST",
                dataType: "JSON",
                url: "/bll/bll_locatarios.php",
                data: {
                    "acao": "verifica_codigo",
                    'codigo': $("#codigo").val(),
                    'id_locatario': $("#id_locatario").val()
                },
                success: function(data) {
                    if (data == false) {
                        Swal.fire(
                            'Erro!',
                            "Código de locatario já existente...",
                            'error'
                        )
                        $("#codigo").val('');
                    }
                },
                error: function(xhr) {
                    Swal.fire(
                        'Erro!',
                        "Erro de requisição!",
                        'error'
                    ).then(function() {
                        return false;
                    });
                }
            });
        }
    })

    var validate_locatario = $("#form_cad_locatario").validate({
        ignore: [],
        rules: {
            nome: {
                required: true
            },
            codigo: {
                required: true
            }
        },
        messages: {
            nome: {
                required: "Nome é obrigatorio..."
            },
            codigo: {
                required: "Código é obrigatório..."
            }
        },
        errorPlacement: function(error, element) {
            if (element.hasClass('select2-hidden-accessible')) {
                error.insertAfter(element.next('span'));
            } else {
                error.insertAfter(element);
            }

        },
        errorElement: 'span',
        highlight: function(element) {
            $(element).parents('.form-group').removeClass('has-feedback has-success');
            $(element).parents('.form-group').addClass('bold has-feedback has-error');
            $("span.error").addClass('validation-error-message help-block form-helper bold');

        },
        unhighlight: function(element) {
            $(element).parents('span.error').removeClass(
                'bold has-feedback has-error validation-error-message help-block form-helper bold');
            $(element).parents('.form-group').addClass('has-feedback has-success');
        }
    });
    
</script>