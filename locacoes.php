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
    <title>Locações</title>

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
                <h2 class="page-header text-overflow" style="margin-top:0px; padding:1%; text-align:center">Locações</h2>
            </div>
        </div>

        <div class="boxed">
            <div id="content-container">
                <div id="page-content">
                    <div class="text-center" id="painel_list">
                        <div class="panel" id="panel_locacoes">
                            <div class="panel-heading" style="padding-top: 10px">  
                                <div class="text-right row" style="margin-right: 1%;">
                                    <div class="col-md-9"></div>
                                    <div class="col-md-2" style="text-align: left !important;">
                                        <label for="filtro_status">Filtro: </label>
                                        <select class="form-control" id="filtro_status" style="width:100%!important">
                                            <option value="A">Ativo</option>
                                            <option value="I">Devolvido</option>
                                        </select>
                                    </div>
                                    <div class="col-md-1">
                                        <button class="btn btn-md btn-dark" id="btn_tab_locacao" style="margin-top: 17%">Locação</button>
                                    </div>                                    
                                </div>                                
                            </div>
                            <hr>
                            <div class="panel-body " style="margin-top:2%; width:100%;">
                                <div class="row" style="padding-left: 3%; padding-right: 3%;"> 
                                    <table id="tab_locacoes" class="table table-bordered table-hover table-responsive row-border" style="width: 100%; margin-top: 3%;">
                                        <thead class="bg-dark" style="color: white; font-family:sans-serif !important">
                                            <tr>
                                                <th style="width: 30%;">LOCATÁRIO</th>
                                                <th id="livros_tab_locacoes" style="width: 45%;"></th>
                                                <th id="datahora_tab_locacoes" style="width: 15%;"></th>
                                                <th style="width: 10%;"></th>
                                            </tr>
                                        </thead>
                                        <tbody style="cursor: pointer"></tbody>
                                    </table>
                                </div> 
                            </div>
                        </div>
                        <div class="panel" id="panel_locacao" style="display: none; padding: 0% 5% 0% 5%;">
                            <div class="panel-heading" style="padding-top: 10px">
                                <div class="form-group">                                    
                                    <h3 style="text-align: center">Realizar Locação</h3>
                                </div>
                            </div>
                            <div class="panel-body" style="margin-top:2%; width:100%;">   
                                <form id="form_locacao">
                                    <input type="hidden" id="id_locacao" name="id_locacao">                                    
                                    <div class="row">                                    
                                        <div class="col-md-12">
                                            <label for="select_locatario">Locatário</label><br>
                                            <select class="form-control select_locatario" id="select_locatario" name="select_locatario" style="width:100% !important"></select>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-12">
                                            <label for="select_livros">Livros</label>
                                            <select class="form-control select_livros" id="select_livros" name="select_livros" style="width:100%!important" multiple>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="form-group col-md-12">
                                            <label for="obs_locacao">Observações
                                                <span class="fa fa-question-circle" title="Informações que necessitam de atenção"></span>
                                            </label>
                                            <textarea rows="5" style="resize:none" name="obs_locacao" id="obs_locacao" class="form-control" placeholder="Observações..."></textarea>
                                        </div>
                                    </div>
                                </form>
                            </div>
                            <div class="panel-footer" style="padding-top: 10px">
                                <div class="form-group" style="margin: 2%;">
                                    <div class="col-md-12">
                                        <div class="text-right" style="text-align:end">
                                            <button class="btn btn-md btn-primary btn_voltar" id="btn_voltar">Voltar</button>
                                            <button class="btn btn-md btn-success" id="btn_salvar">Salvar</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="panel" id="panel_devolucao" style="display: none; padding: 0% 5% 0% 5%;">
                            <div class="panel-heading" style="padding-top: 10px">
                                <div class="form-group">                                    
                                    <h3 style="text-align: center">Devolução</h3>
                                </div>
                            </div>
                            <div class="panel-body " style="margin-top:2%; width:100%;">   
                                <form id="form_devolucao">
                                    <input type="hidden" id="id_devolucao" name="id_devolucao">                                    
                                    <div class="row">                                    
                                        <div class="col-md-12">
                                            <label for="select_locatario_devolucao">Locatário</label><br>
                                            <select class="form-control select_locatario" id="select_locatario_devolucao" name="select_locatario_devolucao" style="width:100% !important"></select>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div id="div_select_livros_devolucao" class="col-md-12" style="display: none;">
                                            <label for="select_livros_devolucao">Livros</label>
                                            <select class="form-control select_livros" id="select_livros_devolucao" name="select_livros_devolucao" style="width:100%!important" multiple>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="form-group col-md-12">
                                            <label for="obs_devolucao">Observações
                                                <span class="fa fa-question-circle" title="Informações que necessitam de atenção"></span>
                                            </label>
                                            <textarea rows="5" style="resize:none" name="obs_devolucao" id="obs_devolucao" class="form-control" placeholder="Observações..."></textarea>
                                        </div>
                                    </div>
                                </form>
                            </div>
                            <div class="panel-footer" style="padding-top: 10px">
                                <div class="form-group" style="margin: 2%;">
                                    <div class="col-md-12">
                                        <div class="text-right" style="text-align:end">
                                            <button class="btn btn-md btn-primary btn_voltar" id="btn_voltar_devolucao">Voltar</button>
                                            <button class="btn btn-md btn-success" id="btn_devolucao">Salvar</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>            
        </div>
    </div>

    <div class="modal fade" id="modal_obs_devolucao" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="myModalLabel"><span id="modal13">Observações</span></h4>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-12">
                            <textarea rows="5" style="resize:none" name="obs_modal" id="obs_modal" class="form-control" placeholder="Observações..."></textarea>
                        </div>
                    </div>
                </div>                
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary close" data-dismiss="modal">Fechar</button>
                </div>
            </div>
        </div>
    </div>

    <footer style="margin-top: 5%; text-align:center">
        <hr>
        <p class="pad-lft">&#0169; Bibliogestão</p>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/js/bootstrap.bundle.min.js"></script>
    <script src="js/jquery.min.js"></script>
    <script src="https://cdn.datatables.net/1.12.1/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10/dist/sweetalert2.all.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.form/4.3.0/jquery.form.min.js" integrity="sha512-YUkaLm+KJ5lQXDBdqBqk7EVhJAdxRnVdT2vtCzwPHSweCzyMgYV/tgGF4/dCyqtCC2eCphz0lRQgatGVdfR0ww==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.5/jquery.validate.min.js" integrity="sha512-rstIgDs0xPgmG6RX1Aba4KV5cWJbAMcvRCVmglpam9SoHZiUCyQVDdH2LPlxoHtrv17XWblE/V/PP+Tr04hbtA==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/js/all.min.js" integrity="sha512-naukR7I+Nk6gp7p5TMA4ycgfxaZBJ7MO5iC3Fp6ySQyKFHOGfpkSZkYVWV5R7u7cfAicxanwYQ5D1e17EfJcMA==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    
    <?php
        include_once("js/locacoes_js.php");
    ?>

</body>

</html>
