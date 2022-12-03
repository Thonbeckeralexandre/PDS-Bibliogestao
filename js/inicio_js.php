<script>
    
    $.carrega_inicio = function() {
        $.ajax({
            type: 'POST',
            dataType: 'JSON',
            url: "/bll/bll_inicio.php",
            data: {
                'acao': 'carrega_dash'
            },
            success: function(data) {
                $('#livros_cadastrados').html(data.livros_cadastrados);
                $('#livros_locados').html(data.livros_locados);
                $('#locatarios_cadastrados').html(data.locatarios_cadastrados);
                $('#locacoes_ativas').html(data.locacoes_ativas);
                $('#locacoes_finalizadas').html(data.locacoes_finalizadas);
            },

            error: function() {                
                Swal.fire('Erro!', "Erro ao enviar requisição...", 'error');
            }
        });
    };
    $.carrega_inicio();
</script>