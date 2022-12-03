<?php
    require_once('apoio/apoio.php');
    verifica_login();
?>
<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Locatários</title>

    <link href="/css/style.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.datatables.net/1.12.1/css/jquery.dataTables.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css" integrity="sha512-xh6O/CkQoPOWDdYTDqeRdPCVd1SpvCA9XXcUnZS2FmJNp1coAFzvtCN9BmamE+4aHK8yyUHUSCcJHgXloTyT2A==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    
</head>

<body>
    <div id="container" class="effect aside-float aside-bright mainnav-sm">

        <?php include_once('menu_superior.php'); ?>

        <div id="page-head" style="background-color:#212529 !important; color:white;">
            <div id="page-title">
                <h2 class="page-header text-overflow" style="margin-top:0px; padding:1%; text-align:center">Locatários</h2>
            </div>
        </div>

        <div class="boxed">
            <div id="content-container">
                <div id="page-content">
                    <div class="text-center" id="painel_list">
                        <div class="panel" id="panel_locatarios">
                            <div class="panel-heading" style="padding-top: 10px">
                                <div class="form-group">
                                    <div class="text-right row" style="margin-right: 1%;">
                                        <div class="col-md-11"></div>
                                        <div class="col-md-1">
                                            <button class="btn btn-md btn-success" id="btn_cad_locatario" style="margin-top: 17%">Adicionar</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <hr>
                            <div class="panel-body " style="margin-top:2%; width:100%;">   
                                <div class="row" style="padding-left: 3%; padding-right: 3%;">                             
                                    <table id="tab_locatarios" class="table table-bordered table-hover table-responsive row-border" style="width: 100%; margin-top: 3%;">
                                        <thead class="bg-dark" style="color: white; font-family:sans-serif !important">
                                            <tr>
                                                <th style="width: 40%;">NOME</th>
                                                <th style="width: 20%;">TELEFONE</th>
                                                <th style="width: 20%;">TIPO</th>
                                                <th style="width: 10%;">CÓDIGO</th>
                                                <th style="width: 10%;"></th>
                                            </tr>
                                        </thead>
                                        <tbody style="cursor: pointer"></tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="panel" style="display: none; padding: 0% 5% 0% 5%;" id="panel_cad_locatario">
                        <div class="panel-heading" style="padding-top: 10px">
                            <h2 style="text-align: center">Adicionar</h2>
                            <div class="form-group" style="margin: 2%;">
                                <div class="col-md-12">
                                    <div class="text-right" style="text-align:end">
                                        <button class="btn btn-md btn-primary" id="btn_voltar">Voltar</button>
                                        <button class="btn btn-md btn-success" id="btn_salvar">Salvar</button>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="panel-body" style="margin-top:2%;">
                            <form id="form_cad_locatario">
                                <input type="hidden" id="id_locatario" name="id_locatario">
                                <div class="row">
                                    <div class="col-md-12">
                                        <label for="nome">Nome</label>
                                        <input class="form-control" type="text" id="nome" name="nome" placeholder="Nome...">
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-12">
                                        <label for="endereco">Endereço</label>
                                        <input class="form-control" type="text" id="endereco" name="endereco" placeholder="Endereço...">
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <label for="responsavel">Responsável</label>
                                        <input class="form-control" type="text" id="responsavel" name="responsavel" placeholder="Responsável...">
                                    </div>
                                    <div class="col-md-6">
                                        <label for="codigo">Código</label>
                                        <input class="form-control" type="text" id="codigo" name="codigo" placeholder="Código...">
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-12">
                                        <label for="email">Email</label>
                                        <input class="form-control" type="email" id="email" name="email" placeholder="Email@email.com...">
                                    </div>
                                </div>
                                <div class="row">                                    
                                    <div class="col-md-6">
                                        <label for="select_tipo">Tipo</label><br>
                                        <div class="input-group">
                                            <select class="form-control" id="select_tipo" name="select_tipo"></select>
                                            <button class="btn btn-sm btn-dark" type="button" id="btn_add_tipo_locatario"><i  class="fa fa-plus"></i></button>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <label for="telefone">Telefone</label>
                                        <input class="form-control" type="text" id="telefone" name="telefone" placeholder="(XX) XXXXX-XXXX...">
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>            
        </div>
    </div>

    <footer style="margin-top: 5%; text-align:center">
        <hr>
        <p class="pad-lft">&#0169; Bibliogestão</p>
    </footer>

    <div class="modal fade" id="modal_add_tipo_locatario" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
        <div class="modal-dialog modal-md" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="myModalLabel"><span id="modal13">Cadastrar tipo de Locatário</span></h4>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-12">
                            <label for="tipo_locatario">Descrição</label>
                            <input class="form-control" type="text" id="tipo_locatario" name="tipo_locatario" placeholder="Descrição do tipo de locatário...">
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <input type="hidden" id="id_tipo_locatario" name="id_tipo_locatario">
                    <button type="button" class="btn btn-primary close" data-dismiss="modal">Fechar</button>
                    <button type="button" class="btn btn-success" id="btn_salvar_tipo_locatario" name="btn_salvar_tipo_locatario">Salvar</button>
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
        include_once("js/locatarios_js.php");
    ?>

</body>

</html>
