<?php
    if (!isset($_SESSION)) {
        session_start();
    }
    if (isset($_SESSION['usuario'])) {        
        header('Location: /inicio.php');
    }
?>
<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>

    <link href="/css/style.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.datatables.net/1.12.1/css/jquery.dataTables.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css" integrity="sha512-xh6O/CkQoPOWDdYTDqeRdPCVd1SpvCA9XXcUnZS2FmJNp1coAFzvtCN9BmamE+4aHK8yyUHUSCcJHgXloTyT2A==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    
</head>

<body>
    <div id="container" class="effect aside-float aside-bright mainnav-sm">
        <div class="panel" id="panel_login">
            <div class="panel-heading" style="text-align:center; margin-top:5%">
                <h1>Bibliogestão</h1>
            </div>
            <div class="panel-body" style="margin-top:2%">
                <div class="row" style="margin: 5% 30% 20% 30%;">
                    <form id="form_usuario">
                        <div class="row">
                            <div class="col-md-12">
                                <label for="usuario">Usuário</label>
                                <input class="form-control" type="text" id="usuario" name="usuario" placeholder="Usuário...">
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <label for="senha">Senha</label>
                                <input class="form-control" type="password" id="senha" name="senha" placeholder="Senha...">
                            </div>
                        </div>
                        <div class="row" style="margin-top: 5%;">
                            <center>
                                <button class="btn btn-primary" type="button" id="btn_cadastro">Cadastre-se</button>
                                <button class="btn btn-primary" type="button" id="btn_login">Login</button>
                            </center>
                        </div>
                    </form>
                </div>            
            </div>
        </div> 
        <div class="panel" id="panel_cadastro_login" style="display: none;">
            <div class="panel-heading" style="text-align:center; margin-top:5%">
                <h3>Cadastro de Usuário</h3>
            </div>
            <div class="panel-body" style="margin-top:2%">
                <div class="row" style="margin: 0% 30% 20% 30%;">
                    <form id="form_cadastro_user">
                        <input type="hidden" id="id_usuario" name="id_usuario">
                        <div class="row">
                            <div class="col-md-12">
                                <label for="nome_user">Nome</label>
                                <input class="form-control" type="text" id="nome_user" name="nome_user" placeholder="Nome...">
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <label for="login">Usuário</label>
                                <input class="form-control" type="text" id="login" name="login" placeholder="Login...">
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <label for="senha_cadastro">Senha</label>
                                <input class="form-control" type="password" id="senha_cadastro" name="senha_cadastro" placeholder="Senha...">
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <label for="senha_cadastro2">Confirme sua senha</label>
                                <input class="form-control" type="password" id="senha_cadastro2" name="senha_cadastro2" placeholder="Confirme sua senha...">
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <label for="select_categoria">Categoria</label>
                                <div class="input-group">
                                    <select class="form-control" id="select_categoria" name="select_categoria"></select>
                                    <button class="btn btn-sm btn-dark" type="button" id="btn_add_categoria_user"><i  class="fa fa-plus"></i></button>
                                </div>
                            </div>
                        </div>
                        <div class="row" style="margin-top: 3%;">
                            <center>
                                <button class="btn btn-primary" type="button" id="btn_voltar">Voltar</button>
                                <button class="btn btn-success" type="button" id="btn_salvar_login">Salvar</button>
                            </center>
                        </div>
                    </form>
                </div>            
            </div>
        </div>       
    </div>

    <footer style="margin-top: 5%; text-align:center">
        <hr>
        <p class="pad-lft">&#0169; Bibliogestão</p>
    </footer>

    <div class="modal fade" id="modal_add_categoria_user" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
        <div class="modal-dialog modal-md" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h6 class="modal-title" id="myModalLabel"><span id="modal13">Cadastrar categoria de usuário</span></h6>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-12">
                            <input class="form-control" type="text" id="input_categoria_user" name="input_categoria_user" placeholder="Categoria...">
                        </div>
                    </div>
                </div>                
                <div class="modal-footer">
                    <input type="hidden" id="id_categoria_usuario" name="id_categoria_usuario">
                    <button type="button" class="btn btn-success" id="btn_salvar_categoria_usuario" name="btn_salvar_categoria_usuario">Salvar</button>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/js/bootstrap.bundle.min.js"></script>
    <script src="js/jquery.min.js"></script>
    <script src="https://cdn.datatables.net/1.12.1/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10/dist/sweetalert2.all.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.form/4.3.0/jquery.form.min.js" integrity="sha512-YUkaLm+KJ5lQXDBdqBqk7EVhJAdxRnVdT2vtCzwPHSweCzyMgYV/tgGF4/dCyqtCC2eCphz0lRQgatGVdfR0ww==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.5/jquery.validate.min.js" integrity="sha512-rstIgDs0xPgmG6RX1Aba4KV5cWJbAMcvRCVmglpam9SoHZiUCyQVDdH2LPlxoHtrv17XWblE/V/PP+Tr04hbtA==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/js/all.min.js" integrity="sha512-naukR7I+Nk6gp7p5TMA4ycgfxaZBJ7MO5iC3Fp6ySQyKFHOGfpkSZkYVWV5R7u7cfAicxanwYQ5D1e17EfJcMA==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    
    <?php
        include_once("js/login_js.php");
    ?>

</body>

</html>
