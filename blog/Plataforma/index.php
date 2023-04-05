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
$dados = $sql->fetchAll();
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
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css" integrity="sha384-xOolHFLEh07PJGoPkLv1IbcEPTNtaed2xpHsD9ESMhqIYd0nLMwNLD69Npy4HI+N" crossorigin="anonymous">
  <link rel="stylesheet" href="plugins/datatables-responsive/css/responsive.bootstrap4.min.css">
  <!-- DataTables -->
  <link rel="stylesheet" href="plugins/datatables-bs4/css/dataTables.bootstrap4.min.css">
  <link rel="stylesheet" href="plugins/datatables-responsive/css/responsive.bootstrap4.min.css">
  <link rel="stylesheet" href="plugins/datatables-buttons/css/buttons.bootstrap4.min.css">
  <!-- summernote -->
<link rel="stylesheet" href="plugins/summernote/summernote-bs4.min.css">
  <!---- Modal fullscreen BS4 --->
  <!-- Toastr -->
<link rel="stylesheet" href="plugins/toastr/toastr.min.css">
<link rel="stylesheet" href="Plataforma/dist/css/style.css">
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
<a href="#" class="d-block"><?php echo $dados[0]['nome']; ?></a>
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
<a href="index.php" class="nav-link active">
<i class="nav-icon fas fa-edit"></i>
<p>Postagens</p>
</a>
</li>
<li class="nav-item">
<a href="categorias.php" class="nav-link">
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
<div class="col-sm-10 my-2">
<h1 class="m-0 dispay-3">Postagem</h1>
</div>
<div class="col-sm-2 my-2">
<button class="btn btn-primary" data-toggle="modal" data-target="#modalPostagem"><i class="fas fa-plus m-1"></i>Nova Postagem</button>
</div>
<!-- /.content-header -->
</div>
</div>
<!-- Main content -->
<div class="content">
<div class="container-fluid">
<div class="row">
<div class="col-lg-12">
<div class="card">
<div class="card-header">
<h3 class="card-title">Confira aqui a lista de Postagens</h3>
</div>
<!-- /.card-header -->
<div class="card-body">
<?php
$sql_posts = $pdo->prepare("SELECT * FROM posts WHERE autor=?");
$sql_posts->execute(array($id));
$qnts_posts = $sql_posts->rowCount();
?>
<?php if ($qnts_posts >0){ ?>
<table id="example1" class="table table-bordered table-striped ">
<thead>
<tr>
<th>ID</th>
<th>Categoria</th>
<th>Título</th>
<th>url</th>
<th>Status</th>
<th>Data de Publicação</th>
<th>Ações</th>
</tr>
</thead>
<tbody>
<?php $dados = $sql_posts->fetchAll(); ?>
<?php foreach($dados as $dado) { ?>
<tr>
<td><?php echo $dado['id'] ;?>
</td>
<?php
$sql_cate = $pdo->prepare("SELECT * FROM categorias WHERE id=?");
$sql_cate->execute(array($dado['categoria']));
$dado_categoria = $sql_cate->fetchAll();
?>
<td><?php echo $dado_categoria[0]['nome_categoria'] ;?>
</td>
<td><?php echo $dado['titulo'] ;?></td>
<td><?php echo $dado['URL'] ;?></td>
<td><?php echo $dado['status'] ;?></td>
<td><?php echo $dado['data_postagem'] ;?></td>
<td> 
<div class="btn-group" role="group">
<button data-conteudo='<?php echo $dado['conteudo'];?>' data-id='<?php echo $dado['id'];?>' data-imagem="<?php echo $dado['imagem'];?>" data-categoria="<?php echo $dado['categoria'];?>" data-titulo="<?php echo $dado['titulo'];?>" data-descricao="<?php echo $dado['desc_curta'];?>" data-url="<?php echo $dado['URL'];?>" data-status="<?php echo $dado['status'];?>" class="editar btn btn-warning"><i class="fa fa-edit"></i> Editar</button>
<?php if ($dado['status'] == 'Publicado') {?>
<button type="button" data-id='<?php echo $dado['id'];?>' o class="desativar btn btn-secondary"><i class="fa fa-ban"></i> Desativar</button>
<?php }else{ ?>
<button type="button" data-id='<?php echo $dado['id'];?>' class="ativar btn btn-success"><i class="fa fa-check"></i>Publicar</button>
<?php } ?>
<button type="button" data-id='<?php echo $dado['id'];?>' data-titulo='<?php echo $dado['titulo']; ?>' class="deletar btn btn-danger"><i class="fa fa-trash"></i> Deletar</button>
</div>

</td>
</tr>
<?php } ?>
</tbody>


<!----  DESATIVAR A POSTAGEM -->
<form class="d-none" id="formDesativa" method="post" action="actions/desativar_post.php">
<input type="hidden" name="idPostagem" id="idPostagem">
</form>

<!----  ATIVAR A POSTAGEM -->
<form class="d-none" id="formAtiva" method="post" action="actions/ativar_post.php">
<input type="hidden" name="idPostagemAtiva" id="idPostagemAtiva">
</form>
</table>
<?php }else{
echo "<b class='h3'>Nenhum Post por enquanto!</b>";} ?>
              </div>
              <!-- /.card-body -->
            </div>
                  </div>
                  </div>
                  </div>
                  <!-- /.row -->
                </div>
                <!-- /.container-fluid -->
              </div>
              <!-- /.content -->
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

<!-- Modal  Postagem-->
<div class="modal fade" id="modalPostagem" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
 <div class="modal-dialog" style="width: 100%;max-width: none;
height: 100%;margin: 0;">
    <div class="modal-content" style="height: auto;
  min-height: 100%;
  border-radius: 0;">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Nova Postagem</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body" style="overflow-y: auto;">
<form action="actions/salvar_post.php" method="post" enctype="multipart/form-data" id="postArtigo" class="row">
<div class="col-md-6">
<div id="divImagem" style=" background-image: url('dist/img/img-post.png') no-repeat; background-size:contain;cursor:pointer;" class="col-md-12">
<img id="imagemPost" src="dist/img/img-post.png" class="img-fluid invisible">
</div>
<input type="file" accept="image/*" id="inputImg" class="form-control d-none" name="inputImg">
<div class="row mt-5">
<div class="form-group col-md-4">
<label for="titulo">Categoria da Postagem</label>
<?php
$sql_categoria = $pdo->prepare("SELECT * FROM categorias");
$sql_categoria->execute();
$qtd_cat = $sql_categoria->rowCount();
if ($qtd_cat ==0) {
echo(' <select class="custom-select" id="selectCategoria" name="selectCategoria" value="">
<option disabled >Nenhuma Categoria</option>');
}else{
$dados = $sql_categoria->fetchAll();
echo('<select class="custom-select" id="selectCategoria" name="selectCategoria">');
echo('<option disabled selected>Selecionar Categoria</option>');
foreach ($dados as $dado){
$id_cat = $dado['id'];
$nome_cat = $dado['nome_categoria'];
echo("<option value='$id_cat'>$nome_cat</option>");
}
echo('</select>');
}
?>
<div class="invalid-feedback">
  Selecione uma Categoria!
</div>
</div>
<div class="form-group col-md-8 mt-4">
<label for="titulo">Título da Postagem</label>
<input type="text" class="form-control" id="titulo" aria-describedby="titulo" placeholder="Digite o titulo do post" name="titulo">
<div class="invalid-feedback">
  Coloque o título da postagem!
</div>
</div>
</div>
<div class="row mt-1">
<div class="form-group col-md-12 mt-4">
<label for="url">URL da Postagem</label>
<input type="text" class="form-control" id="url" aria-describedby="url" placeholder="URL do Post" name="url">
<div class="invalid-feedback">
  Informe uma URL!
</div>
</div>
</div>
<div class="row mt-1">
<div class="form-group col-md-12 mt-4">
<label for="descricao">Descrição curta da Postagem</label>
<input type="text" class="form-control" id="descricaoCurta" aria-describedby="descricao" placeholder="Uma pequena descrição do post" name="descricaoCurta">
<div class="invalid-feedback">
  Informe uma descrição curta!
</div>
</div>
</div>
</div>
<div class="col-md-6">
<label>Conteúdo da Postagem</label>
<textarea class="form-control" id="summernote" name="conteudo"></textarea>
<div class="invalid-feedback">
  Informe um Conteúdo!
</div>
</div>
</form>
</div>
      <div class="modal-footer">
<button id="salvarArtigo" type="button" class="btn btn-primary">Postar Artigo</button>
<button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
          </div>
      </div>
    </div>
  </div>

<!-- Modal Editar-->
<div class="modal fade" id="modalEditar" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" style="width: 100%;max-width: none;
height: 100%;margin: 0;">
<div class="modal-content" style="height: auto;
  min-height: 100%;
  border-radius: 0;">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Editar Postagem</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
<form action="actions/editar_post.php" method="post" enctype="multipart/form-data" id="editarArtigo" class="row">
<div class="col-md-6">
<div id="editar_divImagem" style="background: url('dist/img/img-post.png') no-repeat; background-size:contain;cursor:pointer;" class="col-md-12">
<img id="editar_imagemPost" src="dist/img/img-post.png" class="img-fluid invisible">
</div>
<input type="file" accept="image/*" id="editar_inputImg" class="form-control d-none" name="editar_inputImg">
<input type="hidden" id="editar_id" name="editar_id">
<div class="row mt-5">
<div class="form-group col-md-4">
<label for="categoria">Editar Categoria</label>
<?php
$sql_categoria = $pdo->prepare("SELECT * FROM categorias");
$sql_categoria->execute();
$qtd_cat = $sql_categoria->rowCount();
if ($qtd_cat ==0) {
echo(' <select class="custom-select" id="editar_selectCategoria" name="editar_selectCategoria" value="">
<option disabled >Nenhuma Categoria</option>');
}else{
$dados = $sql_categoria->fetchAll();
echo('<select class="custom-select" id="editar_selectCategoria" name="editar_selectCategoria">');
echo('<option disabled selected>Selecionar Categoria</option>');
foreach ($dados as $dado){
$id_cat = $dado['id'];
$nome_cat = $dado['nome_categoria'];
echo("<option value='$id_cat'>$nome_cat</option>");
}
echo('</select>');
}
?>
<div class="invalid-feedback">
  Selecione uma Categoria!
</div>
</div>
<div class="form-group col-md-8">
<label for="titulo">Editar título Postagem</label>
<input type="text" class="form-control" id="editar_titulo" aria-describedby="titulo" placeholder="Digite o titulo do post" name="editar_titulo">
<div class="invalid-feedback">
  Coloque o título da postagem!
</div>
</div>
</div>
<div class="row mt-1">
<div class="form-group col-md-12 mt-4">
<label for="url">URL da Postagem</label>
<input type="text" class="form-control" id="editar_url" aria-describedby="url" placeholder="URL do Post" name="editar_url">
<div class="invalid-feedback">
  Informe uma URL!
</div>
</div>
</div>

<div class="row mt-1">
<div class="form-group col-md-12 mt-4">
<label for="editar">Editar Descrição curta</label>
<input type="text" class="form-control" id="editar_descricaoCurta" aria-describedby="editar_descricaoCurta" placeholder="Editar Descrição" name="editar_descricaoCurta">
<div class="invalid-feedback">
  Informe um Descrição
</div>
</div>
</div>
</div>
<div class="col-md-6">
<label>Conteúdo da Postagem</label>
<textarea class="form-control" id="editar_summernote" name="editar_conteudo"></textarea>
<div class="invalid-feedback">
  Informe um Conteúdo!
</div>
</div>
</form>
</div>
      <div class="modal-footer">
<button id="editar_Artigo" type="button" class="btn btn-warning">Editar Artigo</button>
<button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
          </div>
      </div>
    </div>
  </div>
<!-----MODAL DELETAR ---->
<div class="modal fade" id="modal-deletar">
<div class="modal-dialog">
<div class="modal-content bg-danger">
<div class="modal-header">
<h4 class="modal-title">Deletar Postagem</h4>
<button type="button" class="close" data-dismiss="modal" aria-label="Close">
<span aria-hidden="true">&times;</span>
</button>
</div>
<div class="modal-body">
<h5>Tem certeza que quer deletar <b id="nome_da_postagem"></b> ?</h5>
<form class="d-none" action="actions/deletar_post.php" method="post" id="formDeletarPost">
<input type="hidden" id="idPostagemDeletar" name="idPostagemDeletar">
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

<!-- REQUIRED SCRIPTS -->
<!-- jQuery -->
<script src="plugins/jquery/jquery.min.js"></script>
<!-- Summernote -->
<script src="plugins/summernote/summernote-bs4.min.js"></script>
<!-- Bootstrap 4 -->
<script src="plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- DataTables  & Plugins -->
<script src="plugins/datatables/jquery.dataTables.min.js"></script>
<script src="plugins/datatables-bs4/js/dataTables.bootstrap4.min.js"></script>
<script src="plugins/datatables-responsive/js/dataTables.responsive.min.js"></script>
<script src="plugins/datatables-responsive/js/responsive.bootstrap4.min.js"></script>
<script src="plugins/datatables-buttons/js/dataTables.buttons.min.js"></script>
<script src="plugins/datatables-buttons/js/buttons.bootstrap4.min.js"></script>
<script src="plugins/jszip/jszip.min.js"></script>
<script src="plugins/pdfmake/pdfmake.min.js"></script>
<script src="plugins/pdfmake/vfs_fonts.js"></script>
<script src="plugins/datatables-buttons/js/buttons.html5.min.js"></script>
<script src="plugins/datatables-buttons/js/buttons.print.min.js"></script>
<script src="plugins/datatables-buttons/js/buttons.colVis.min.js"></script>
<!-- AdminLTE App -->
<script src="dist/js/adminlte.min.js"></script>
<!-- Toastr -->
<script src="plugins/toastr/toastr.min.js"></script>
<script>
//CLICOU NO DELETAR
$('.deletar').click(function(){
var id = $(this).attr('data-id');
var titulo = $(this).attr('data-titulo');
$('#idPostagemDeletar').val(id);
$('#nome_da_postagem').html(titulo);
$('#modal-deletar').modal('show');
});
//CLOCOU NA CONFIRMAÇÃO DELETAR
$('#sim_deletar').click(function(){
$("#formDeletarPost").submit();
});

//CLICOU NO DESATIVAR
$('.desativar').click(function(){
var id = $(this).attr('data-id');
$('#idPostagem').val(id);

$('#formDesativa').submit();
});
//CLICOU NO ATIVAR
$('.ativar').click(function(){
var id = $(this).attr('data-id');
$('#idPostagemAtiva').val(id);

$('#formAtiva').submit();
});
//EDITAR
$('.editar').click(function(){
//Valores pegos da tabela
var id = $(this).attr('data-id');
var categoria = $(this).attr('data-categoria');
var imagem = $(this).attr('data-imagem');
var titulo = $(this).attr('data-titulo');
var descricaoCurta = $(this).attr('data-descricao');
var url = $(this).attr('data-url');
var status = $(this).attr('data-status');
var conteudo = $(this).attr('data-conteudo');

//ALIMENTAR MODAL EDITAR
//LIMENTAR O ID 
$('#editar_id').val(id);
//ALIMENTAR Imagem
$("#editar_divImagem").css('background', 'url("'+imagem+'") no-repeat');
$("#editar_divImagem").css('background-size', 'contain');
$("#editar_divImagem").css('cursor', 'pointer');
//ALIMENTAR CATEGORIA 
$('#editar_selectCategoria').val(categoria);
//ALIMENTAR TITULO
$('#editar_titulo').val(titulo);
//ALIMENTAR DESCRIÇÃO CURTA
$('#editar_descricaoCurta').val(descricaoCurta);
//ALIMENTAR A URL
$('#editar_url').val(url);
//ALIMENTAR SUMMERNOTE
$('#editar_summernote').summernote("code",conteudo);

$('#modalEditar').modal('show');

});
// Summernote
$('#editar_summernote').summernote({height:400});

//EDITAR ARTIGO 
$("#editar_Artigo").click(function(){
  // Validacao para editar Artigo
var imagem = $("#editar_inputImg").val();
var categoria = $('#editar_selectCategoria').val();
var titulo = $('#editar_titulo').val();
var descricaoCurta = $('#editar_descricaoCurta').val();
var url = $('#editar_url').val();
var conteudo = $('#editar_summernote').val();

$("#editar_divImagem").val(imagem);
// Validação da categoria
if(categoria == "" || categoria == null){
$("#editar_selectCategoria").addClass('is-invalid');
return false;
}else{
$("#editar_selectCategoria").removeClass('is-invalid');
}
// Validação do titulo
if(titulo == "" || titulo == null){
$("#editar_titulo").addClass('is-invalid');
return false;
}else{
$("#editar_titulo").removeClass('is-invalid');
}
// Validação da Descrição curta
if(descricaoCurta == "" || descricaoCurta == null){
$("#editar_descricaoCurta").addClass('is-invalid');
return false;
}else{
$("#editar_descricaoCurta").removeClass('is-invalid');
}
// Validação da URL
if(url == "" || url == null){
$("#editar_url").addClass('is-invalid');
return false;
}else{
$("#editar_url").removeClass('is-invalid');
}
// Validação do Conteúdo 
if($('#editar_summernote').summernote('isEmpty')){
   $('#editar_summernote').addClass('is-invalid');
}else{
  $('#editar_summernote').removeClass('is-invalid');
}

// FORMAR A URL EDITAR
$('#editar_titulo').blur(function(){
var titulo = $('#editar_titulo').val();
var url = titulo.replace( /\s+/g,'-').toLowerCase();
$('#editar_url').val(retira_acentos(url));
var conteudo = $('#editar_summernote').val();
});

$("#editarArtigo").submit();

});


//FORMAR A URL
$('#titulo').blur(function(){
var titulo = $('#titulo').val();
var url = titulo.replace( /\s+/g,'-').toLowerCase();
$('#url').val(retira_acentos(url));
var conteudo = $('#summernote').val();
});


function retira_acentos(str) 
{
com_acento = "ÀÁÂÃÄÅÆÇÈÉÊËÌÍÎÏÐÑÒÓÔÕÖØÙÚÛÜÝŔÞßàáâãäåæçèéêëìíîïðñòóôõöøùúûüýþÿŕ,";

sem_acento ="AAAAAAACEEEEIIIIDNOOOOOOUUUUYRsBaaaaaaaceeeeiiiionoooooouuuuybyr,";
    novastr="";
    for(i=0; i<str.length; i++) {
        troca=false;
        for (a=0; a<com_acento.length; a++) {
            if (str.substr(i,1)==com_acento.substr(a,1)) {
                novastr+=sem_acento.substr(a,1);
                troca=true;
                break;
            }
        }
        if (troca==false) {
            novastr+=str.substr(i,1);
        }
    }
    return novastr;
}       

$("#salvarArtigo").click(function(){
// VALIDAÇÃO PARA SALVAR ARTIGO
var imagem = $("#inputImg").val();
var categoria = $('#selectCategoria').val();
var titulo = $('#titulo').val();
var url = $('#url').val();
var descricaoCurta = $('#descricaoCurta').val();
var conteudo = $('#summernote').val();
$("#divImagem").css('background', 'url("'+imagem+'") no-repeat');
$("#divImagem").css('background-size', 'contain');
$("#divImagem").css('cursor', 'pointer');
//Validacao da imagem
if(imagem == "" || imagem == null){
$("#divImagem").addClass('border');
$("#divImagem").addClass('border-danger');
return false;
}else{
$("#divImagem").removeClass('border');
$("#divImagem").removeClass('border-danger');
}
// Validação da categoria
if(categoria == "" || categoria == null){
$("#selectCategoria").addClass('is-invalid');
return false;
}else{
$("#selectCategoria").removeClass('is-invalid');
}
// Validação do titulo
if(titulo == "" || titulo == null){
$("#titulo").addClass('is-invalid');
return false;
}else{
$("#titulo").removeClass('is-invalid');
}
// Validação da Descrição curta
if(descricaoCurta == "" || descricaoCurta == null){
$("#descricaoCurta").addClass('is-invalid');
return false;
}else{
$("#descricaoCurta").removeClass('is-invalid');
}

// Validação da URL
if(url == "" || url == null){
$("#url").addClass('is-invalid');
return false;
}else{
$("#url").removeClass('is-invalid');
}

// Validação do Conteúdo 
if(conteudo == "" || conteudo == null){
$("#summernote").addClass('is-invalid');
return false;
}else{
$("#summernote").removeClass('is-invalid');
}

$("#postArtigo").submit();

});



$("#editar_divImagem").click(function(){
$("#editar_inputImg").click();
});
editar_inputImg.onchange = evt => {
  const [file] = editar_inputImg.files
  if (file) {
$("#editar_divImagem").css('background', 'url("'+URL.createObjectURL(file)+'") no-repeat');
$("#editar_divImagem").css('background-size','contain');
$("#editar_divImagem").css('cursor', 'pointer');
  }
}

$("#divImagem").click(function(){
$("#inputImg").click();
});

inputImg.onchange = evt => {
  const [file] = inputImg.files
  if (file) {
$("#divImagem").css('background', 'url("'+URL.createObjectURL(file)+'") no-repeat');
$("#divImagem").css('background-size', 'contain');
$("#divImagem").css('cursor', 'pointer');
  }
}

//SUMMERNOTE
$('#summernote').summernote({height: 350});

//Mensagem de erro 
<?php if (isset($_GET['erro'])){ ?>
//ERRO SALVAR POST
<?php if ($_GET['erro'] == 'nao-autorizado'){ ?>
toastr.error('<b>Erro:</b> Usuário não autorizado!');
<?php } ?>

<?php if ($_GET['erro'] == 'imagem-tamanho-grande'){ ?>
toastr.error('<b>Erro:</b> A imagem deve ter no máximo 2MB. Tente novamente!');
<?php } ?>

<?php if ($_GET['erro'] == 'falha-ao-inserir'){ ?>
toastr.error('<b>Erro:</b> Falha ao inserir no Banco!');
<?php } ?>

<?php if ($_GET['erro'] == 'imagem-upload'){ ?>
toastr.error('<b>Erro:</b> Falha ao fazer upload da imagem!');
<?php } ?>

<?php if ($_GET['erro'] == 'extensao-nao-permitida'){ ?>
toastr.error('<b>Erro:</b> A extensão da imagem não é permitida. Somente: <b>jpg, png e jpeg</b>');
<?php } ?>

<?php if ($_GET['erro'] == 'ok'){ ?>
toastr.success('<b>Sucesso:</b> Postagem adicionada!');
<?php } ?>

/******* ****** ******* ********/

//ERRO EDITAR POST

<?php if ($_GET['erro'] == 'editar-nao-autorizado'){ ?>
toastr.error('<b>Erro ao editar:</b> Usuário não autorizado!');
<?php } ?>

<?php if ($_GET['erro'] == 'editar-imagem-tamanho-grande'){ ?>
toastr.error('<b>Erro ao editar:</b> A imagem deve ter no máximo 2MB. Tente novamente!');
<?php } ?>

<?php if ($_GET['erro'] == 'editar-falha-ao-inserir'){ ?>
toastr.error('<b>Erro ao editar:</b> Falha ao inserir no Banco!');
<?php } ?>

<?php if ($_GET['erro'] == 'editar-imagem-upload'){ ?>
toastr.error('<b>Erro ao editar:</b> Falha ao fazer upload da imagem!');
<?php } ?>

<?php if ($_GET['erro'] == 'editar-extensao-nao-permitida'){ ?>
toastr.error('<b>Erro ao editar:</b> A extensão da imagem não é permitida. Somente: <b>jpg, png e jpeg</b>');
<?php } ?>

<?php if ($_GET['erro'] == 'editar-ok'){ ?>
toastr.success('<b>Sucesso:</b> Postagem Editada!');
<?php } ?>

/******* ****** ****** *******/
//ERRO DESATIVAR
<?php if ($_GET['erro'] == 'desativar-nao-autorizado'){ ?>
toastr.error('<b>Erro ao desativar:</b> Usuário não autorizado!');
<?php } ?>


<?php if ($_GET['erro'] == 'desativar-ok'){ ?>
toastr.success('<b>Sucesso:</b> Postagem desativada!');
<?php } ?>
<?php if ($_GET['erro'] == 'desativar-falha-ao-inserir'){ ?>
toastr.error('<b>Erro ao desativar:</b> Falha ao inserir no Banco!');
<?php } ?>

/******* ****** ****** *******/
//ERRO ATIVAR
<?php if ($_GET['erro'] == 'ativar-nao-autorizado'){ ?>
toastr.error('<b>Erro ao ativar:</b> Usuário não autorizado!');
<?php } ?>
<?php if ($_GET['erro'] == 'ativar-ok'){ ?>
toastr.success('<b>Sucesso:</b> Postagem Ativada!');
<?php } ?>
<?php if ($_GET['erro'] == 'ativar-falha-ao-inserir'){ ?>
toastr.error('<b>Erro ao ativar:</b> Falha ao inserir no Banco!');
<?php } ?>
/******* ****** ****** *******/

//ERRO DELETAR
<?php if ($_GET['erro'] == 'deletar-nao-autorizado'){ ?>
toastr.error('<b>Erro ao deletar:</b> Usuário não autorizado!');
<?php } ?>
<?php if ($_GET['erro'] == 'deletar-ok'){ ?>
toastr.success('<b>Sucesso:</b> Postagem excluída com sucesso!');
<?php } ?>
<?php if ($_GET['erro'] == 'ativar-falha-ao-inserir'){ ?>
toastr.error('<b>Erro ao deletar:</b> Falha ao deletar!');

<?php } ?>

<?php } ?>

 $("#example1").DataTable({
"responsive": true, "lengthChange": false, "autoWidth": false,
"buttons": ["copy", "csv", "excel", "pdf", "print", "colvis"],
"order": [[0, "desc"]],
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


</script>

</body>
</html>