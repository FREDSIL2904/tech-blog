<?php 
require('db/conexao.php');
if (isset($_GET['x'])) {
  
$url_categoria = limpaPost($_GET['x']);

//PEGAR ID DA CATEGORIA
$sql_cat = $pdo->prepare("SELECT * FROM categorias WHERE url_categoria=? LIMIT 1");
$sql_cat->execute(array($url_categoria));
$quantas_categorias = $sql_cat->rowCount();
if ($quantas_categorias >0) {
$dados_cat = $sql_cat->fetchAll();
$id_categoria = $dados_cat[0]['id'];
//PUXAR POSTS PARA DESTAQUES
$sql_destaque = $pdo->prepare("SELECT * FROM posts WHERE categoria=? LIMIT 2");
$sql_destaque->execute(array($id_categoria));
$dados_destaque = $sql_destaque->fetchAll();

//PUXAR TODOS OS POSTS DESSA CATEGORIA 
$qntd=4;
$sql = $pdo->prepare("SELECT * FROM posts WHERE categoria=? order by id DESC LIMIT $qntd");
$sql->execute(array($id_categoria));
$quantos_posts = $sql->rowCount();
$dados_post = $sql->fetchAll();
}
}else {
  header('location: index.php');
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-GLhlTQ8iRABdZLl6O3oVMWSktQOp6b7In1Zl3/Jr59b6EGGoI1aFkw7cmDA6j6gD" crossorigin="anonymous">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.3/font/bootstrap-icons.css">
<link rel="stylesheet" href="style.css" />
<title>Blog</title>
<style>
   .cat{
    box-shadow: rgba(50, 50, 93, 0.25) 0px 13px 27px -5px, rgba(0, 0, 0, 0.3) 0px 8px 16px -8px;
</style>
</head>
<body>
<!-------- incluir o Navbar-->
<?php include('componentes/navbar.php');?>
<?php if ($quantas_categorias > 0) { ?>
<!------ HEADER ------>
<header>
<div class="p-4 p-md-5 mb-4 text-bg-dark container-fluid top">
    <div class="col-md-12 px-0 text-center mt-5">
 <p class="text-info fs-5 mt-4">Últimas notícias sobre</p>
<h1 class="fs-2 fw-bolder"><?php echo($dados_cat[0]['nome_categoria']); ?></h1>
    </div>
  </div>
</header>
<!------ Fim Caroussel ------>
<!------ DESTAQUES ------>
<div class="container-fluid">
<?php if ($quantos_posts == 0) { 
echo('<div class="card p-5 mt-5 text-center">
  <div class="card-body">
    <h1>Em breve um conteúdo incrível aqui!</h1>
  </div>
</div>');
}else {
?>
<div class="container mt-5">
<div class="row mb-5">
<?php foreach ($dados_destaque as $dadosDestaque)

{ ?>
<div class="col-md-6 mb-4">
<div class="row g-0 border rounded overflow-hidden flex-md-row h-100 cat">
<div class="col p-4 d-flex flex-column position-static">
<?php
//PUXAR O NOME DA CATEGORIA
$sql_categoria_nome = $pdo->prepare("SELECT * FROM categorias WHERE id=?");
$sql_categoria_nome->execute(array($dadosDestaque['categoria']));
$dados_categoria_nome = $sql_categoria_nome->fetchAll();
?>
<strong class="d-inline-block mb-2 text-primary"><?php echo($dados_categoria_nome[0]['nome_categoria']); ?></strong>
<h3 class="mb-0"><?php echo($dadosDestaque['titulo']); ?></h3>
<div class="mb-1 text-muted">
<?php echo($dadosDestaque['data_postagem']); ?>
</div>
<p class="card-text mb-auto">
<?php echo($dadosDestaque['desc_curta']); ?>
</p>
<a href="artigo.php?x=<?php echo($dadosDestaque['URL']); ?>" class="btn btn-sm btn-primary mt-4 btn-post">Continue lendo...</a>
</div>
<div class="col-auto d-none d-lg-block">
<img class="img-d-post img-fluid" src="<?php echo $dadosDestaque['imagem']; ?>">
</div>
</div>
</div>
<?php } ?>
</div>
</div>
<!------ FECHA DESTAQUES ------>

<!------ POSTS ------>
<div class="container">
<div class="row row-cols-1 row-cols-md-2 g-4" id="areaPosts">
<?php foreach ($dados_post as $dadosPost){ ?>
<div class="col-md-6">
<div class="card cat h-100">
<div style="background: url('<?php echo $dadosPost['imagem']; ?>') no-repeat;background-size:cover;background-position:center;border-top-left-radius:5px;border-top-right-radius:5px;">
<img src="Plataforma/dist/img/postp.png" class="img-fluid invisible img_cat rounded">
</div>
<div class="card-body">
<h3 class="card-title"><?php echo $dadosPost['titulo']; ?></h3>
<p class="card-text"><?php echo $dadosPost['desc_curta']; ?></p>
<a href="artigo.php?x=<?php echo $dadosPost['URL']; ?>" class="btn btn-sm btn-primary btn-post">Ler mais</a>
<?php
//PUXAR O NOME DA CATEGORIA
$sql_categoria_nome2 = $pdo->prepare("SELECT * FROM categorias WHERE id=?");
$sql_categoria_nome2->execute(array($dadosPost['categoria']));
$dados_categoria_nome2 = $sql_categoria_nome2->fetchAll();
?>
<a href="categoria.php?x=<?php echo $dados_categoria_nome2[0]['url_categoria']; ?>" class="btn btn-primary btn-sm btn-post" style="position:relative; float: right;"><?php echo $dados_categoria_nome2[0]['nome_categoria']; ?></a>

      </div>
    </div>
  </div>
<?php }?>
</div>
<?php } ?>
</div>
<!------ FECHA POSTS ------>
<?php if ($quantos_posts > 0) { ?>
<div class="row my-5">
<div class="col-10 mt-4 mx-auto">
<div class="d-grid gap-2">
  <button data-pagina="1" id="maisPosts" class="btn btn-primary" type="button">Ver mais postagens</button>
</div>
</div>
</div>
<hr class="border border-1 opacity-100 m-3"/>
<?php } ?>
<?php }else {
  echo('<div class="card p-5 mt-5 text-center">
  <div class="card-body">
    <h1>Erro 404 - página não encontrada...</h1>
  </div>
</div>');
}

?>
<!------ Rodapé -------->
<?php include('componentes/footer.php');?>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js" integrity="sha384-w76AqPfDkMBDXo30jS1Sgez6pr3x5MlQ1ZAGC+nuZB+EYdgRZgiwxhTBTkF7CXvN" crossorigin="anonymous">
</script>
<script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
<?php if ($quantas_categorias >0) { ?>
<script>
$('#maisPosts').click(function(){
 var pagina = $('#maisPosts').attr('data-pagina');
$('#maisPosts').text('Carregando postagens...');
$('#maisPosts').addClass('disabled');

// REQUISIÇÃO PARA PUXAR MAIS POSTS
$.ajax({
url: "Plataforma/actions/puxar_posts_cat.php",
type: "post",
data: {pagina:pagina,qtd:<?php echo $qntd; ?>, idcategoria:<?php echo $id_categoria; ?>} ,
success: function (resposta) {
          
if(resposta==0){
$('#maisPosts').addClass('d-none');
}else{
$('#maisPosts').text('Ver mais postagens');
$('#maisPosts').removeClass('disabled');
$('#areaPosts').append(resposta);
var novaPagina = parseInt(pagina) +1;
$('#maisPosts').attr('data-pagina',novaPagina);
}
},
error: function(jqXHR, textStatus, errorThrown) {
console.log(textStatus, errorThrown);
  }
 });
});
</script>
<?php } ?>
</body>
</html>