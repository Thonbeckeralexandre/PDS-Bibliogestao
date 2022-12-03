<script>
    var tab_livros;

    $.limpa_cad = function() {
        $('#id_livro').val('');
        $('#nome').val('');
        $('#colecao').val('');
        $('#edicao').val('');
        $('#isbn').val('');
        $('#select_disponivel').val('');
        $('#obs').val('');
        $('#codigo').val('');
    }
    
    $("#btn_voltar").click(function() {
        $('#painel_list').css('display', 'block'); 
        $('#panel_cad_livro').css('display', 'none');
        $.carrega_tabela_livros();
    })
    
    $("#btn_cad_livros").click(function() {
        $('#painel_list').css('display', 'none'); 
        $('#panel_cad_livro').css('display', 'block');        
        $.carrega_select('select_categoria', '', 'bll_categorias', 'Categorias...');
        $.carrega_select_autores('');
        $.limpa_cad();
    })

    $("#btn_add_autor").click(function() {
        $('#modal_add_autor').modal('show');
        $('#nome_autor').val('');
        $('#id_autor').val('');
    })

    $("#btn_add_categoria").click(function() {
        $('#modal_add_categoria').modal('show');
        $('#nome_categoria').val('');
        $('#cor').val("#FFFFFF");
        $('#id_categoria').val('');
    })

    $(".close").click(function() {
        $(".modal").modal('hide');
    })

    $.carrega_tabela_livros = function() {
        if (tab_livros) {
            tab_livros.destroy();
        }
        tab_livros = $('#tab_livros').DataTable({
            "pageLength": 10,
            ordering: true,
            searching: true,
            responsive: true,
            "processing": true,
            ajax: {
                'type': 'POST',
                'dataType': 'json',
                'url': '/bll/bll_livros.php',
                'data': {
                    'acao': 'carrega_datatable_livros',
                    disponivel: $("#filtro_disponivel").val()
                }
            },
            columns: [
                { data: 'nome' },
                { data: 'categoria' },
                { data: 'disponivel' },
                { data: 'codigo' },
                { data: 'autor' },
                { data: 'funcoes' }
            ],
            'language': {
                "url": "/js/js_tabela_pt_br.json"
            }
        });
    };
    $.carrega_tabela_livros();

    $("#filtro_disponivel").change(() => {
        $.carrega_tabela_livros($("#filtro_disponivel").val());
    })

    $('#select_disponivel').select2({
        placeholder: "Disponibilidade...",
        allowClear: true,
        language: "pt-BR"
    });

    $.carrega_select = function(select, elemento, arquivo, placeholder) {
        
        $('#' + select).empty();

        $('#' + select).append($('<option>', {
            value: '',
            text: ''
        }));

        $.ajax({
            type: 'POST',
            dataType: 'JSON',
            async: false,
            url: '/bll/' + arquivo + '.php',
            data: {
                'acao': 'carrega_selected'
            },
            success: function(dados) {
                $.each(dados, function(key, value) {
                    $('#' + select).append($('<option>', {
                        value: value.id,
                        text: value.nome
                    }));
                    if (value.id === elemento) {
                        $("#" + select + " option[value='" + elemento + "']").prop({
                            selected: 'selected'
                        });
                    }
                });
            },
            complete: function() {
                $('#' + select).select2({
                    placeholder: placeholder,
                    allowClear: true,
                    language: "pt-BR"
                });
            },
            error: function(xhr) {
                Swal.fire(
                    'Erro!',
                    "Nao foi possivel carregar o campo...",
                    'error'
                ).then(function() {
                    return false;
                });
            }
        });
    }

    $.carrega_select_autores = function(array_autores, id_livro) {
        
        $('#select_autor').empty();

        $.ajax({
            type: 'POST',
            dataType: 'JSON',
            url: '/bll/bll_autores.php',
            data: {
                'acao': 'carrega_selected',
                'id_livro': id_livro
            },
            success: function(dados) {
                $.each(dados, function(key, value) {
                    $('#select_autor').append($('<option>', {
                        value: value.id_autor,
                        text: value.nome
                    }));
                    if (array_autores) {
                        $.each(array_autores, function(key, value2) {
                            if (value.id_autor == value2.id_autor) {
                                $("#select_autor option[value='" + value2.id_autor + "']")
                                    .prop({
                                        selected: 'selected'
                                });
                            }
                        });
                    }
                });
            },
            complete: function() {
                $("#select_autor").select2({
                    multiple: true,
                    placeholder: "Autores...",
                    allowClear: true
                }).on('change', function(e) {
                    $(this).valid();
                });
            },
            error: function(xhr) {
                Swal.fire(
                    'Erro!',
                    "Nao foi possivel preencher os Autores",
                    'error'
                ).then(function() {
                    return false;
                });
            }
        });
    };

    $.inserir = function() {

        var frm = $('#form_cad_livro');

        $('#form_cad_livro').ajaxForm({
            type: 'POST',
            dataType: 'JSON',
            'url': '/bll/bll_livros.php',
            data: {
                'acao': 'inserir',
                'array_autores': $('#select_autor').val()
            },
            beforeSend: function() {

                console.log('enviando...');
            },
            success: function(response) {

                if (response.resposta == "sucesso") {
                    $('#id_livro').val(response.id_livro);
                    Swal.fire('Sucesso!', 'Dados salvos com sucesso!', 'success');
                    $('#painel_list').css('display', 'block'); 
                    $('#panel_cad_livro').css('display', 'none');
                    $.carrega_tabela_livros();
                } else if (response.resposta == "codigo") {

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

        if ($('#form_cad_livro').valid()) {
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
                    $.carrega_tabela_livros();
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

    $("#btn_salvar_autor").click(function() {
        Swal.fire({
            title: 'Você tem certeza?',
            text: "Você salvará um novo autor. Deseja continuar?",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Sim',
            cancelButtonText: 'Cancelar'
        }).then((result) => {
            if (result.isConfirmed) {
                if ($("#nome_autor").val()) {
                    $.ajax({
                        type: 'POST',
                        dataType: 'JSON',
                        'url': '/bll/bll_autores.php',
                        data: {
                            'acao': 'inserir',
                            'nome_autor': $('#nome_autor').val()
                        },
                        success: function(dados) {
                            if (dados) {
                                Swal.fire(
                                'Sucesso!',
                                "Autor inserido com sucesso!",
                                'success'
                                )
                                $('#modal_add_autor').modal('hide');
                                $.carrega_select_autores();
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

    $("#btn_salvar_categoria").click(function() {
        Swal.fire({
            title: 'Você tem certeza?',
            text: "Você salvará uma nova categoria. Deseja continuar?",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Sim',
            cancelButtonText: 'Cancelar'
        }).then((result) => {
            if (result.isConfirmed) {
                if ($("#nome_categoria").val() && $("#cor").val()) {
                    $.ajax({
                        type: 'POST',
                        dataType: 'JSON',
                        'url': '/bll/bll_categorias.php',
                        data: {
                            'acao': 'inserir',                            
                            'nome_categoria': $('#nome_categoria').val(),
                            'cor': $('#cor').val()
                        },
                        success: function(dados) {
                            if (dados) {
                                Swal.fire(
                                'Sucesso!',
                                "Categoria inserida com sucesso!",
                                'success'
                                )
                                $('#modal_add_categoria').modal('hide');
                                $.carrega_select('select_categoria', '', 'bll_categorias', 'Categorias...');
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

    function editar_livro(id_livro) {

        $('#form_cad_livro').children(".row").children(".form-group").each(function() {
            ($(this)).removeClass('bold has-feedback has-error has-success');
            ($(this)).children("span").remove("span.error");
        });
        
        $.limpa_cad();

        $.ajax({
            type: 'POST',
            dataType: 'JSON',
            url: "/bll/bll_livros.php",
            data: {
                'acao': 'carrega_objeto',
                id_livro: id_livro
            },
            success: function(data) {

                $('#painel_list').css('display', 'none'); 
                $('#panel_cad_livro').css('display', 'block');
                $('#id_livro').val(data.id_livro);
                $("#colecao").val(data.colecao);
                $("#edicao").val(data.edicao);
                $("#isbn").val(data.isbn);
                $('#nome').val(data.nome);
                $('#obs').val(data.obs);
                $('#codigo').val(data.codigo);
                $("#select_disponivel").val(data.disponivel);
                $.carrega_select('select_categoria', data.ex_categoria, 'bll_categorias', 'Categorias...');
                $.carrega_select_autores(data.array_autores, id_livro);
            },

            error: function() {
                Swal.fire(
                    'Erro!',
                    "Não foi possivel abrir esse livro para editar...",
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
                url: "/bll/bll_livros.php",
                data: {
                    "acao": "verifica_codigo",
                    'codigo': $("#codigo").val(),
                    'id_livro': $("#id_livro").val()
                },
                success: function(data) {
                    if (data == false) {
                        Swal.fire(
                            'Erro!',
                            "Código de livro já existente...",
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

    var validate_livro = $("#form_cad_livro").validate({
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