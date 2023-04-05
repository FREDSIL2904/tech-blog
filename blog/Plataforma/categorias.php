<?php
session_start();
require('../db/conexao.php');
if (isset($_SESSION['token']) && isset($_SESSION['id'])) {
  $tokenSessao = $_SESSION['token'];
$id = $_SESSION['id'];
$sql = $pdo->prepare('SELECT * from admin WHERE token=? AND id=? ');
$sql->execute(array($tokenSessao, $id));
$quantos = $sql->rowCount();
  if ($quantos == 0) {
header('location: ../login.php');
} else {
$dados_usuario = $sql->fetchAll();
}
} else {
session_unset();
session_destroy();
header('location: ../login.php');
}
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Área restrita</title>

  <!-- Google Font: Source Sans Pro -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <!-- Font Awesome Icons -->
  <link rel="stylesheet" href="plugins/fontawesome-free/css/all.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="dist/css/adminlte.min.css">
  <link rel="stylesheet" href="plugins/datatables-bs4/css/dataTables.bootstrap4.min.css">
  <link rel="stylesheet" href="plugins/datatables-responsive/css/responsive.bootstrap4.min.css">
  <link rel="stylesheet" href="plugins/datatables-buttons/css/buttons.bootstrap4.min.css">
    <!-- Toastr -->
<link rel="stylesheet" href="plugins/toastr/toastr.min.css">
<link rel="stylesheet" href="style.css">
</head>
<body class="hold-transition sidebar-mini">
  <div class="wrapper">
    <!-- Navbar -->
    <nav class="main-header navbar navbar-expand navbar-white navbar-light">
      <!-- Left navbar links -->
      <ul class="navbar-nav">
        <li class="nav-item">
          <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
        </li>
      </ul>

      <!-- Right navbar links -->
      <ul class="navbar-nav ml-auto">
        <!-- Navbar Search -->
        <li class="nav-item">
          <a class="nav-link" data-widget="navbar-search" href="#" role="button">
            <i class="fas fa-search"></i>
          </a>
          <div class="navbar-search-block">
            <form class="form-inline">
              <div class="input-group input-group-sm">
                <input class="form-control form-control-navbar" type="search" placeholder="Search" aria-label="Search">
                <div class="input-group-append">
                  <button class="btn btn-navbar" type="submit">
                    <i class="fas fa-search"></i>
                  </button>
                  <button class="btn btn-navbar" type="button" data-widget="navbar-search">
                    <i class="fas fa-times"></i>
                  </button>
                </div>
              </div>
            </form>
          </div>
        </li>


        <li class="nav-item">
          <a class="nav-link" data-widget="fullscreen" href="#" role="button">
            <i class="fas fa-expand-arrows-alt"></i>
          </a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="deslogar/" role="button">
            <i class="fa fa-power-off"></i>
          </a>
        </li>
      </ul>
    </nav>
    <!-- /.navbar -->

<!-- Main Sidebar Container -->
<aside class="main-sidebar sidebar-dark-primary elevation-4">
      <!-- Brand Logo -->
<a href="index.php" class="brand-link">
<img src="dist/img/desh.png" alt="Logo" class="brand-image img-circle elevation-3" style="opacity: .8">
<span class="brand-text font-weight-light">Area do Blog</span>
</a>

      <!-- Sidebar -->
<div class="sidebar">
<!-- Sidebar user panel (optional) -->
<div class="user-panel mt-3 pb-3 mb-3 d-flex">
<div class="image">
<img src="dist/img/user2-160x160.jpg" class="img-circle elevation-2" alt="User Image">
</div>
<div class="info">
<a href="#" class="d-block"><?php echo $dados_usuario[0]['nome']; ?></a>
</div>
</div>
<!-- Sidebar Menu -->
<nav class="mt-2">
<ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
<li class="nav-item menu-open">
<a href="#" class="nav-link">
<i class="nav-icon fas fa-tachometer-alt"></i>
<p>Páginas Restritas<i class="right fas fa-angle-left"></i>
</p>
</a>
</li>
<li class="nav-item">
<a href="index.php" class="nav-link">
<i class="nav-icon fas fa-edit"></i>
<p>Postagens</p>
</a>
</li>
<li class="nav-item">
<a href="categorias.php" class="nav-link active">
<i class="nav-icon fas fa-th"></i>
<p>Categorias</p>
</a>
</li>
</ul>
</nav>
<!-- /.sidebar-menu -->
</div>
<!-- /.sidebar -->
</aside>

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
<!-- Content Header (Page header) -->
<div class="content-header">
<div class="container-fluid">
<div class="row mb-2">
<div class="col-sm-6 my-2">
<h1 class="m-0 dispay-3">Categorias</h1>
</div>
<?php if ($dados_usuario[0]['nivel'] == 'sim') { ?>
<div class="col-sm-4 my-2">
<div class="form-group col-md-12">
<input type="text" class="form-control" id="digitaCategoria" aria-describedby="titulo" placeholder="Adicionar categoria" name="digitaCategoria">
<div class="invalid-feedback">
  Informe uma categoria!
</div>
</div>
</div>
<div class="col-sm-2 my-2">
<a id="btn-add-categoria" href="#" class="btn btn-primary"><i class="fas fa-plus"></i>Add Categoria</a>
<a id="btn-edit-categoria" href="#" class="btn btn-warning d-none"><i class="fas fa-edit"></i>Editar Categoria</a>
</div>
<?php } ?>
<!-- /.content-header -->
<form class="d-none" id="formNovaCategoria" method="post" action="actions/salvar-categoria.php">
<input type="hidden" class="form-control" id="novaCategoria" aria-describedby="novaCategoria" placeholder="Digite uma categoria" name="novaCategoria">
</form>
<form class="d-none" id="formEditCategoria" method="post" action="actions/editar-categoria.php">
<input type="hidden" class="form-control" id="editarCategoria" aria-describedby="editarCategoria" placeholder="Editar categoria" name="editarCategoria">
<input type="hidden" class="form-control" id="idCategoria" aria-describedby="editarCategoria" placeholder="ID categoria" name="idCategoria">
</form>
</div>
</div>
<!-- Main content -->
<div class="content">
<div class="container-fluid">
<div class="row">
<div class="col-lg-12">
<div class="card">
<div class="card-header">
<h3 class="card-title">Confira aqui a lista de Categorias</h3>
</div>
<!-- /.card-header -->
<div class="card-body">
<?php
$sql_categorias = $pdo->prepare("SELECT * FROM categorias");
$sql_categorias->execute();
$qnts_categorias = $sql_categorias->rowCount();
?>
<?php if ($qnts_categorias >0){ ?>
<table id="example1" class="table table-bordered table-striped">
<thead>
<tr>
<th>ID</th>
<th>Nome da Categoria</th>
<th>url da Categoria</th>
<th>Quantidade de postagens</th>
<?php if ($dados_usuario[0]['nivel'] == 'sim') { ?>
<th>Ações</th>
<?php } ?>
</tr>
</thead>
<tbody>
<?php $dados = $sql_categorias->fetchAll(); ?>
<?php foreach($dados as $dado) { ?>
<tr>
<td><?php echo $dado['id']; ?></td>
<td><?php echo $dado['nome_categoria']; ?></td>
<td><?php echo $dado['url_categoria']; ?></td>
<?php
$sql_post = $pdo->prepare("SELECT * FROM posts WHERE categoria=?");
$sql_post->execute(array($dado['id']));
$qnts_posts = $sql_post->rowCount();
?>
<td><?php echo $qnts_posts; ?></td>
<?php if ($dados_usuario[0]['nivel'] == 'sim') { ?>
<td> 

<button type="button" data-id="<?php echo $dado['id']; ?>" data-categoria="<?php echo $dado['nome_categoria']; ?>" class="editar btn btn-warning"><i class="fa fa-edit"></i>  Editar</button>
<button type="button" data-id="<?php echo $dado['id']; ?>" data-categoria="<?php echo $dado['nome_categoria']; ?>" class="deletar btn btn-danger"><i class="fa fa-trash"></i> Deletar</button>
</td>
<?php } ?>
</tr>
<?php } ?>
</tbody>
</table>
<?php }else{
echo "<b class='h3'>Nenhuma categoria por enquanto!</b>";} ?>
              </div>
              <!-- /.card-body -->
                  <!-- /.row -->
                </div>
                <!-- /.container-fluid -->
              </div>
              <!-- /.content -->
              </div>
              </div>
              </div>
              </div>
              </div>
            <!-- /.content-wrapper -->
            <!-- Main Footer -->
            <footer class="main-footer">
              <!-- To the right -->
<div class="float-right d-none d-sm-inline">
<h6>By <b>Fred Sousa</b></h6>
</div>
              <!-- Default to the left -->
<p class="dispay-6">Copyright &copy; 2023 <a href="">Meu blog</a>.</p> Todos os direitos reservados.
</footer>
</div>
<!-- ./wrapper -->

<?php if ($dados_usuario[0]['nivel'] == 'sim') { ?>
<!-----MODAL DELETAR ---->
<div class="modal fade" id="modal-deletar">
<div class="modal-dialog">
<div class="modal-content bg-danger">
<div class="modal-header">
<h4 class="modal-title">Deletar Categoria</h4>
<button type="button" class="close" data-dismiss="modal" aria-label="Close">
<span aria-hidden="true">&times;</span>
</button>
</div>
<div class="modal-body">
<h5>Tem certeza que quer deletar a categoria <b id="nome_da_categoria"></b> ?</h5>
<p>Ao deletar, todas as postagens dentro desta categoria também serão excluídas. Essa ação é irreversível!</p>
<form class="d-none" action="actions/deletar-categoria.php" method="post" id="formDeletarCategoria">
<input type="hidden" id="idCategoriaDeletar" name="idCategoriaDeletar">
</form>
</div>
<div class="modal-footer justify-content-between">
<button type="button" class="btn btn-light fw-bold" data-dismiss="modal">Não</button>
<button id="sim_deletar" type="button" class="btn btn-warning fw-bold">Sim, pode deletar</button>
</div>
</div>
<!-- /.modal-content -->
</div>
<!-- /.modal-dialog -->
</div>
<!-- /.modal -->
<?php } ;?>


<!-- REQUIRED SCRIPTS -->

      <!-- jQuery -->
<script src="plugins/jquery/jquery.min.js"></script>
   <!-- Bootstrap 4 -->
<script src="plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
    <!-- AdminLTE App -->
<script src="dist/js/adminlte.min.js"></script>
<script src="plugins/datatables/jquery.dataTables.min.js"></script>
<script src="plugins/datatables-bs4/js/dataTables.bootstrap4.min.js"></script>
<script src="plugins/datatables-responsive/js/dataTables.responsive.min.js"></script>
<script src="plugins/datatables-responsive/js/responsive.bootstrap4.min.js"></script>
<script src="plugins/datatables-buttons/js/dataTables.buttons.min.js"></script>
<script src="plugins/datatables-buttons/js/buttons.bootstrap4.min.js"></script>
<script src="plugins/jszip/jszip.min.js"></script>
<script src="plugins/pdfmake/pdfmake.min.js"></script>
<script src="plugins/pdfmake/vfs_fonts.js"></script>
<script src="plugins/pdfmake/vfs_fonts.js"></script>
<script src="plugins/pdfmake/vfs_fonts.js"></script>
<script src="plugins/datatables-buttons/js/buttons.html5.min.js"></script>
<script src="plugins/datatables-buttons/js/buttons.print.min.js"></script>
<script src="plugins/datatables-buttons/js/buttons.colVis.min.js"></script>
<!-- Toastr -->
<script src="plugins/toastr/toastr.min.js"></script>
<script>
<?php if ($dados_usuario[0]['nivel'] == 'sim') { ;?>
//CLICOU NO DELETAR
$('.deletar').click(function(){
var id = $(this).attr('data-id');
var nome_categoria = $(this).attr('data-categoria');
$('#idCategoriaDeletar').val(id);
$('#nome_da_categoria').html(nome_categoria);
$('#modal-deletar').modal('show');
});
//CLOCOU NA CONFIRMAÇÃO DELETAR
$('#sim_deletar').click(function(){
$("#formDeletarCategoria").submit();
});


//BOTAO ADICIONAR NA TABELA
$('#btn-add-categoria').click(function(){
var campoCategoria = $("#digitaCategoria").val();

if(campoCategoria == "" || campoCategoria == null){
$("#digitaCategoria").addClass('is-invalid');
return false;
}else{
$("#digitaCategoria").removeClass('is-invalid');
$("#novaCategoria").val(campoCategoria);
$("#formNovaCategoria").submit();
}
});
//CLICOU NO BOTÃO EDITAR DA TABELA
$(".editar").click(function(){
var id = $(this).attr('data-id');
var nome_categoria = $(this).attr('data-categoria');

//ALIMENTAR A CATEGORIA 
$("#digitaCategoria").val(nome_categoria);
$("#idCategoria").val(id);
$("#digitaCategoria").focus();
//aparecer o editar e desaparecer o adicionar
$("#btn-edit-categoria").removeClass('d-none');
$("#btn-add-categoria").addClass('d-none');
});
//BOTAO EDITAR A CATEGORIA
$('#btn-edit-categoria').click(function(){
var campoCategoria = $("#digitaCategoria").val();

if(campoCategoria == "" || campoCategoria == null){
$("#digitaCategoria").addClass('is-invalid');
return false;
}else{
$("#digitaCategoria").removeClass('is-invalid');
$("#editarCategoria").val(campoCategoria);
$("#formEditCategoria").submit();
}
});
<?php }; ?>


<?php if (isset($_GET['erro'])){ ?>
//ADD CATEGORIA
<?php if ($_GET['erro'] == 'nao-autorizado'){ ?>
toastr.error('<b>Erro:</b> Usuário não autorizado!');
<?php } ?>

<?php if ($_GET['erro'] == 'falha-ao-inserir'){ ?>
toastr.error('<b>Erro:</b> Falha ao inserir no Banco!');
<?php } ?>

<?php if ($_GET['erro'] == 'ok'){ ?>
toastr.success('<b>Sucesso:</b> Categoria adicionada!');
<?php } ?>

<?php if ($_GET['erro'] == 'editar-ok'){ ?>
toastr.success('<b>Sucesso:</b> Categoria Editada!');
<?php } ?>

//ERRO DELETAR
<?php if ($_GET['erro'] == 'deletar-nao-autorizado'){ ?>
toastr.error('<b>Erro ao deletar:</b> Usuário não autorizado!');
<?php } ?>
<?php if ($_GET['erro'] == 'deletar-ok'){ ?>
toastr.success('<b>Sucesso:</b> Categoria excluída com sucesso!');
<?php } ?>
<?php if ($_GET['erro'] == 'ativar-falha-ao-inserir'){ ?>
toastr.error('<b>Erro ao deletar:</b> Falha ao deletar!');

<?php } ?>

<?php } ?>
  
  
  
  
$(function () {
$("#example1").DataTable({
"responsive": true, "lengthChange": false, "autoWidth": false,
"buttons": ["copy", "csv", "excel", "pdf", "print", "colvis"],
"language":{
"emptyTable": "Nenhum registro encontrado",
"info": "Mostrando de _START_ até _END_ de _TOTAL_ registros",
"infoFiltered": "(Filtrados de _MAX_ registros)",
"infoThousands": ".",
"loadingRecords": "Carregando...",
"zeroRecords": "Nenhum registro encontrado",
"search": "Pesquisar",
"paginate": {
"next": "Próximo",
"previous": "Anterior",
"first": "Primeiro",
"last": "Último"
},
"aria": {
"sortAscending": ": Ordenar colunas de forma ascendente",
"sortDescending": ": Ordenar colunas de forma descendente"
},
"select": {
"rows": {
"_": "Selecionado %d linhas",
"1": "Selecionado 1 linha"
},
"cells": {
"1": "1 célula selecionada",
            "_": "%d células selecionadas"
        },
        "columns": {
            "1": "1 coluna selecionada",
            "_": "%d colunas selecionadas"
        }
    },
    "buttons": {
        "copySuccess": {
            "1": "Uma linha copiada com sucesso",
            "_": "%d linhas copiadas com sucesso"
        },
        "collection": "Coleção  <span class=\"ui-button-icon-primary ui-icon ui-icon-triangle-1-s\"><\/span>",
        "colvis": "Visibilidade da Coluna",
        "colvisRestore": "Restaurar Visibilidade",
        "copy": "Copiar",
        "copyKeys": "Pressione ctrl ou u2318 + C para copiar os dados da tabela para a área de transferência do sistema. Para cancelar, clique nesta mensagem ou pressione Esc..",
        "copyTitle": "Copiar para a Área de Transferência",
        "csv": "CSV",
        "excel": "Excel",
        "pageLength": {
            "-1": "Mostrar todos os registros",
            "_": "Mostrar %d registros"
        },
        "pdf": "PDF",
        "print": "Imprimir",
        "createState": "Criar estado",
        "removeAllStates": "Remover todos os estados",
        "removeState": "Remover",
        "renameState": "Renomear",
        "savedStates": "Estados salvos",
        "stateRestore": "Estado %d",
        "updateState": "Atualizar"
    },
    "autoFill": {
        "cancel": "Cancelar",
        "fill": "Preencher todas as células com",
        "fillHorizontal": "Preencher células horizontalmente",
        "fillVertical": "Preencher células verticalmente"
    },
    "lengthMenu": "Exibir _MENU_ resultados por página",
    "searchBuilder": {
        "add": "Adicionar Condição",
        "button": {
            "0": "Construtor de Pesquisa",
            "_": "Construtor de Pesquisa (%d)"
        },
        "clearAll": "Limpar Tudo",
        "condition": "Condição",
        "conditions": {
            "date": {
                "after": "Depois",
                "before": "Antes",
                "between": "Entre",
                "empty": "Vazio",
                "equals": "Igual",
                "not": "Não",
                "notBetween": "Não Entre",
                "notEmpty": "Não Vazio"
            },"number": {
                "between": "Entre",
                "empty": "Vazio",
                "equals": "Igual",
                "gt": "Maior Que",
                "gte": "Maior ou Igual a",
                "lt": "Menor Que",
                "lte": "Menor ou Igual a",
                "not": "Não",
                "notBetween": "Não Entre",
                "notEmpty": "Não Vazio"
            },
            "string": {
                "contains": "Contém",
                "empty": "Vazio",
                "endsWith": "Termina Com",
                "equals": "Igual",
                "not": "Não",
                "notEmpty": "Não Vazio",
                "startsWith": "Começa Com",
                "notContains": "Não contém",
                "notStartsWith": "Não começa com",
                "notEndsWith": "Não termina com"
            },
            "array": {
                "contains": "Contém",
                "empty": "Vazio",
                "equals": "Igual à",
                "not": "Não",
                "notEmpty": "Não vazio",
                "without": "Não possui"
            }
        },
        "data": "Data",
        "deleteTitle": "Excluir regra de filtragem",
        "logicAnd": "E",
        "logicOr": "Ou",
        "title": {
            "0": "Construtor de Pesquisa",
            "_": "Construtor de Pesquisa (%d)"
        },
        "value": "Valor",
        "leftTitle": "Critérios Externos",
        "rightTitle": "Critérios Internos"
    },
    "searchPanes": {
        "clearMessage": "Limpar Tudo",
        "collapse": {
            "0": "Painéis de Pesquisa",
            "_": "Painéis de Pesquisa (%d)"
        },
        "count": "{total}",
        "countFiltered": "{shown} ({total})",
        "emptyPanes": "Nenhum Painel de Pesquisa",
        "loadMessage": "Carregando Painéis de Pesquisa...",
        "title": "Filtros Ativos",
        "showMessage": "Mostrar todos",
        "collapseMessage": "Fechar todos"
    },
    "thousands": ".",
    "datetime": {
        "previous": "Anterior",
        "next": "Próximo",
        "hours": "Hora",
        "minutes": "Minuto",
        "seconds": "Segundo",
        "amPm": [
            "am",
            "pm"
        ],
        "unknown": "-",
        "months": {
            "0": "Janeiro",
            "1": "Fevereiro",
            "10": "Novembro",
            "11": "Dezembro",
            "2": "Março",
            "3": "Abril",
            "4": "Maio",
            "5": "Junho",
            "6": "Julho",
            "7": "Agosto",
            "8": "Setembro",
            "9": "Outubro"
        },
        "weekdays": [
            "Domingo",
            "Segunda-feira",
            "Terça-feira",
            "Quarta-feira",
            "Quinte-feira",
            "Sexta-feira",
            "Sábado"
        ]
    },
    "editor": {
        "close": "Fechar",
        "create": {
            "button": "Novo",
            "submit": "Criar",
            "title": "Criar novo registro"
        },
        "edit": {
            "button": "Editar",
            "submit": "Atualizar",
            "title": "Editar registro"
        },
        "error": {
            "system": "Ocorreu um erro no sistema (<a target=\"\\\" rel=\"nofollow\" href=\"\\\">Mais informações<\/a>)."
        },
        "multi": {
            "noMulti": "Essa entrada pode ser editada individualmente, mas não como parte do grupo",
            "restore": "Desfazer alterações",
            "title": "Multiplos valores",
            "info": "Os itens selecionados contêm valores diferentes para esta entrada. Para editar e definir todos os itens para esta entrada com o mesmo valor, clique ou toque aqui, caso contrário, eles manterão seus valores individuais."
        },
        "remove": {
            "button": "Remover",
            "confirm": {
                "_": "Tem certeza que quer deletar %d linhas?",
                "1": "Tem certeza que quer deletar 1 linha?"
            },
            "submit": "Remover",
            "title": "Remover registro"
        }
    },"decimal": ",",
    "stateRestore": {
        "creationModal": {
            "button": "Criar",
            "columns": {
                "search": "Busca de colunas",
                "visible": "Visibilidade da coluna"
            },
            "name": "Nome:",
            "order": "Ordernar",
            "paging": "Paginação",
            "scroller": "Posição da barra de rolagem",
            "search": "Busca",
            "searchBuilder": "Mecanismo de busca",
            "select": "Selecionar",
            "title": "Criar novo estado",
            "toggleLabel": "Inclui:"
        },
        "emptyStates": "Nenhum estado salvo",
        "removeConfirm": "Confirma remover %s?",
        "removeJoiner": "e",
        "removeSubmit": "Remover",
        "removeTitle": "Remover estado",
        "renameButton": "Renomear",
        "renameLabel": "Novo nome para %s:",
        "renameTitle": "Renomear estado",
        "duplicateError": "Já existe um estado com esse nome!",
        "emptyError": "Não pode ser vazio!",
        "removeError": "Falha ao remover estado!"
    },
    "infoEmpty": "Mostrando 0 até 0 de 0 registro(s)",
    "processing": "Carregando...",
    "searchPlaceholder": "Buscar registros"}
              }).buttons().container().appendTo('#example1_wrapper .col-md-6:eq(0)');
            });
          </script>

        </body>
      </html>