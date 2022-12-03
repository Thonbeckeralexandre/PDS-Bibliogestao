<script>

    $('#btn_login').click(function() {

        var frm = $('#form_usuario');

        $('#form_usuario').ajaxForm({
            type: 'POST',
            dataType: 'JSON',
            'url': '/bll/bll_usuarios.php',
            data: {
                'acao': 'login'
            },
            beforeSend: function() {

                console.log('enviando...');
            },
            success: function(response) {

                if (response) {
                    window.location.replace('inicio.php');
                } else {
                    Swal.fire(
                    'Atenção!',
                    "Usuário ou senha incorretos...",
                    'warning'
                );
                }
            },
            complete: function() {},
            error: function(xhr) {
                Swal.fire(
                    'Erro!',
                    "Nao foi possivel enviar requisição",
                    'error'
                );
            }
        }).submit();
    });

    $.inserir = function() {

        var frm = $('#form_cadastro_user');

        $('#form_cadastro_user').ajaxForm({
            type: 'POST',
            dataType: 'JSON',
            'url': '/bll/bll_usuarios.php',
            data: {
                'acao': 'inserir'
            },
            beforeSend: function() {

                console.log('enviando...');
            },
            success: function(response) {

                if (response.resposta == "sucesso") {
                    $('#id_usuario').val(response.id_usuario);
                    Swal.fire('Sucesso!', 'Dados salvos com sucesso!', 'success');
                    $('#panel_cadastro_login').css('display', 'none'); 
                    $('#panel_login').css('display', 'block');
                }
            },
            error: function(xhr) {
                Swal.fire(
                    'Erro!',
                    "Nao foi possivel Salvar as informações",
                    'error'
                );
            }
        }).submit();
    }

    $('#btn_salvar_login').click(function() {

        if ($("#senha_cadastro").val() == $("#senha_cadastro2").val()) {            
            if ($('#form_cadastro_user').valid()) {
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
        } else {
            Swal.fire(
                'Erro!',
                "A senha e sua confirmação devem ser iguais!",
                'error'
            )
        }
    });

    $.carrega_select_categoria = function(categoria) {

        $('#select_categoria').empty();

        $('#select_categoria').append($('<option>', {
            value: '',
            text: ''
        }));

        $.ajax({
            type: 'POST',
            dataType: 'JSON',
            async: false,
            url: '/bll/bll_categoria_usuario.php',
            data: {
                'acao': 'carrega_selected'
            },
            success: function(dados) {
                $.each(dados, function(key, value) {
                    $('#select_categoria').append($('<option>', {
                        value: value.id_categoria_usuario,
                        text: value.nome
                    }));
                    if (value.id_categoria_usuario === categoria) {
                        $("#select_categoria option[value='" + categoria + "']").prop({
                            selected: 'selected'
                        });
                    }
                });
            },
            complete: function() {
                $('#select_categoria').select2({
                    placeholder: "Categoria de usuário...",
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

    $('#btn_cadastro').click(function() {
        $('#panel_login').css('display', 'none'); 
        $('#panel_cadastro_login').css('display', 'block');
        $('#login').val('');
        $('#senha_cadastro').val('');
        $('#senha_cadastro2').val('');
        $('#nome_user').val('');
        $('#usuario').val('');
        $('#senha').val('');
        $.carrega_select_categoria();
    });

    $('#btn_voltar').click(function() {
        $('#panel_login').css('display', 'block'); 
        $('#panel_cadastro_login').css('display', 'none');
    });

    $("#btn_add_categoria_user").click(function() {
        $('#modal_add_categoria_user').modal('show');
        $('#input_categoria_user').val('');
        $('#id_categoria_usuario').val('');
    })

    $(".close").click(function() {
        $(".modal").modal('hide');
    })
    
    $("#btn_salvar_categoria_usuario").click(function() {
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
                if ($("#input_categoria_user").val()) {
                    $.ajax({
                        type: 'POST',
                        dataType: 'JSON',
                        'url': '/bll/bll_categoria_usuario.php',
                        data: {
                            'acao': 'inserir',
                            'nome': $('#input_categoria_user').val()
                        },
                        success: function(dados) {
                            if (dados) {
                                Swal.fire(
                                'Sucesso!',
                                "Categoria inserida com sucesso!",
                                'success'
                                )
                                $('#modal_add_categoria_user').modal('hide');
                                $.carrega_select_categoria();
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
    
</script>