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
    <title>Livros</title>
    
    <link href="/css/style.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.datatables.net/1.12.1/css/jquery.dataTables.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css" integrity="sha512-xh6O/CkQoPOWDdYTDqeRdPCVd1SpvCA9XXcUnZS2FmJNp1coAFzvtCN9BmamE+4aHK8yyUHUSCcJHgXloTyT2A==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-colorpicker/3.4.0/css/bootstrap-colorpicker.css" integrity="sha512-HcfKB3Y0Dvf+k1XOwAD6d0LXRFpCnwsapllBQIvvLtO2KMTa0nI5MtuTv3DuawpsiA0ztTeu690DnMux/SuXJQ==" crossorigin="anonymous" referrerpolicy="no-referrer" />

</head>

<body>
    <div id="container" class="effect aside-float aside-bright mainnav-sm">

        <?php include_once('menu_superior.php'); ?>

        <div id="page-head" style="background-color:#212529 !important; color:white;">
            <div id="page-title">
                <h2 class="page-header text-overflow" style="margin-top:0px; padding:1%; text-align:center;">Livros</h2>
            </div>
        </div>

        <div class="boxed">
            <div id="content-container">
                <div id="page-content">
                    <div class="text-center" id="painel_list">
                        <div class="panel" id="panel_livros">
                            <div class="panel-heading" style="padding-top: 10px">
                                <div class="form-group">
                                    <div class="text-right row" style="margin-right: 1%;">
                                        <div class="col-md-9"></div>                                                                 
                                        <div class="col-md-2 text-left">
                                            <label for="filtro_disponivel">Filtro: </label>
                                            <select class="form-control" id="filtro_disponivel" style="width:100%!important">
                                                <option value="T">Todos</option>
                                                <option value="S">Disponível</option>
                                                <option value="N">Indisponível</option>
                                            </select>
                                        </div>   
                                        <div class="col-md-1">
                                            <button class="btn btn-md btn-success" id="btn_cad_livros" style="margin-top: 17%">Adicionar</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <hr>   
                            <div class="panel-body " style="margin-top:2%; width:100%;">
                                <div class="row">   
                                    <div class="col-md-12"></div>
                                </div> 
                                <br>
                                <div class="row" style="padding-left: 3%; padding-right: 3%;">          
                                    <table id="tab_livros" class="table table-bordered table-hover table-responsive row-border" style="width: 100%; margin-top: 3%;">
                                        <thead class="bg-dark" style="color: white; font-family:sans-serif !important">
                                            <tr>
                                                <th style="width: 33%;">NOME</th>
                                                <th style="width: 19%;">CATEGORIA</th>
                                                <th style="width: 9%;">DISPONIBILIDADE</th>
                                                <th style="width: 10%;">CÓDIGO</th>
                                                <th style="width: 19%;">AUTOR</th>
                                                <th style="width: 10%;"></th>
                                            </tr>
                                        </thead>
                                        <tbody style="cursor: pointer"></tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="panel" style="display: none; padding: 0% 5% 0% 5%;" id="panel_cad_livro">
                        <div class="panel-heading" style="padding-top: 10px">
                            <h2 style="text-align: center">Adicionar</h2>
                            <div class="form-group" style="margin: 2%;">
                                <div class="col-md-12">
                                    <div class="text-right" style="text-align:end">
                                        <button class="btn btn-sm btn-primary" id="btn_voltar">Voltar</button>
                                        <button class="btn btn-sm btn-success" id="btn_salvar">Salvar</button>                                        
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="panel-body" style="margin-top:2%">
                            <form id="form_cad_livro">
                                <input type="hidden" id="id_livro" name="id_livro">
                                <div class="row">
                                    <div class="col-md-12">
                                        <label for="nome">Nome</label>
                                        <input class="form-control" type="text" id="nome" name="nome" placeholder="Nome...">
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-12">
                                        <label for="colecao">Coleção</label>
                                        <input class="form-control" type="text" id="colecao" name="colecao" placeholder="Coleção...">
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-3">
                                        <label for="edicao">Edição</label>
                                        <input class="form-control" type="text" id="edicao" name="edicao" placeholder="Edição...">
                                    </div>
                                    <div class="col-md-3">
                                        <label for="isbn">ISBN</label>
                                        <input class="form-control" type="text" id="isbn" name="isbn" placeholder="ISBN...">
                                    </div>
                                    <div class="col-md-3">
                                        <label for="codigo">Código</label>
                                    <input class="form-control" type="text" id="codigo" name="codigo" placeholder="Código...">
                                    </div>
                                    <div class="col-md-3">
                                        <label for="select_disponivel">Disponibilidade</label>
                                        <select class="form-control" id="select_disponivel" name="select_disponivel" style="width:100%!important">
                                            <option value="S">Disponível</option>
                                            <option value="N">Indisponível</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="input-group">
                                            <label for="select_categoria">Categoria</label>
                                            <select class="form-control" id="select_categoria" name="select_categoria" style="width:96%!important"></select>
                                            <button class="btn btn-sm btn-dark" type="button" id="btn_add_categoria"><i  class="fa fa-plus"></i></button>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="input-group">
                                            <label for="select_autor">Autores</label>
                                            <select class="form-control" id="select_autor" name="select_autor" style="width:96%!important" multiple></select>                                        
                                            <button class="btn btn-sm btn-dark" type="button" id="btn_add_autor"><i  class="fa fa-plus"></i></button>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="form-group col-md-12">
                                        <label for="obs">Observações
                                            <span class="fa fa-question-circle" title="Informações que necessitam de atenção"></span>
                                        </label>
                                        <textarea rows="5" style="resize:none" name="obs" id="obs" class="form-control" placeholder="Observações..."></textarea>
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

    <div class="modal fade" id="modal_add_autor" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
        <div class="modal-dialog modal-md" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="myModalLabel"><span id="modal13">Cadastrar Autor</span></h4>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-12">
                            <label for="nome_autor">Nome</label>
                            <input class="form-control" type="text" id="nome_autor" name="nome_autor" placeholder="Nome do autor...">
                        </div>
                    </div>
                </div>                
                <div class="modal-footer">
                    <input type="hidden" id="id_autor" name="id_autor">
                    <button type="button" class="btn btn-primary close" data-dismiss="modal">Fechar</button>
                    <button type="button" class="btn btn-success" id="btn_salvar_autor" name="btn_salvar_autor">Salvar</button>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="modal_add_categoria" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
        <div class="modal-dialog modal-md" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="myModalLabel"><span id="modal13">Cadastrar Categoria</span></h4>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-9">
                            <label for="nome_categoria">Descrição</label>
                            <input class="form-control" type="text" id="nome_categoria" name="nome_categoria" placeholder="Descrição da categoria...">
                        </div>
                        <div class="col-md-3">
                            <label for="cor">Cor</label>
                            <!-- <input class="form-control" type="text" id="cor" name="cor" placeholder="Clique para selecionar a cor..."> -->
                            <input type="color" class="form-control form-control-color" id="cor" value="#FFFFFF" title="Escolha a cor...">
                        </div>
                    </div>
                </div>                
                <div class="modal-footer">
                    <input type="hidden" id="id_categoria" name="id_categoria">
                    <button type="button" class="btn btn-primary close" data-dismiss="modal">Fechar</button>
                    <button type="button" class="btn btn-success" id="btn_salvar_categoria" name="btn_salvar_categoria">Salvar</button>
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
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-colorpicker/3.4.0/js/bootstrap-colorpicker.min.js" integrity="sha512-94dgCw8xWrVcgkmOc2fwKjO4dqy/X3q7IjFru6MHJKeaAzCvhkVtOS6S+co+RbcZvvPBngLzuVMApmxkuWZGwQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    
    <?php
        include_once("js/livros_js.php");
    ?>

</body>

</html>
