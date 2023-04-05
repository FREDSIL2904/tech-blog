<?php
require('db/conexao.php');

//PUXAR POSTS PARA O CAROUSSEL
$sql_caroussel = $pdo->prepare("SELECT * FROM posts ORDER BY id DESC LIMIT 3");
$sql_caroussel->execute();
$dados_caroussel = $sql_caroussel->fetchAll();

//PUXAR POSTS PARA DESTAQUES
$sql_destaque = $pdo->prepare("SELECT * FROM posts order by id DESC LIMIT 2");
$sql_destaque->execute();
$dados_destaque = $sql_destaque->fetchAll();


//PUXAR TODOS OS POSTS
$qntd = 4;

$sql = $pdo->prepare("SELECT * FROM posts order by id DESC LIMIT $qntd");
$sql->execute();
$quantos_posts = $sql->rowCount();
$dados_post = $sql->fetchAll();

?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-GLhlTQ8iRABdZLl6O3oVMWSktQOp6b7In1Zl3/Jr59b6EGGoI1aFkw7cmDA6j6gD" crossorigin="anonymous">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.3/font/bootstrap-icons.css">
<link rel="stylesheet" href="style.css"/>
<style>
  .post{
    box-shadow: 0 0 8px rgba(0,0,0,.5);
  }
  .cat{
    box-shadow: rgba(50, 50, 93, 0.25) 0px 13px 27px -5px, rgba(0, 0, 0, 0.3) 0px 8px 16px -8px;
  }
</style>
<title>Blog</title>
</head>
<body>
<!-------- incluir o Navbar-->
<?php include('componentes/navbar.php');?>
<?php if ($quantos_posts > 0) { ?>
<!------ Corousel ------>
<div id="carouselExampleCaptions" class="carousel slide">
<div class="carousel-indicators">
<button type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide-to="0" class="active" aria-current="true" aria-label="Slide 1"></button>
<button type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide-to="1" aria-label="Slide 2"></button>
<button type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide-to="2" aria-label="Slide 1"></button>
</div>
<div class="carousel-inner">
<?php
$indice=0;
foreach ($dados_caroussel as $dadosCaroussel)
{
$indice++;
 ?>
<div class="carousel-item <?php if($indice == 1){ echo "active";} ?>" style="background-image: linear-gradient(0deg, rgba(0,0,0,0.7), rgba(0,0,0,0.4), rgba(0,0,0,0.9)), url('<?php echo $dadosCaroussel['imagem']; ?>'); background-position: center;">
<div class="carousel-caption  d-md-block mb-lg-5">
<h4 class="fs-3 fw-bolder"><?php echo $dadosCaroussel['titulo']; ?></h4>
<p class="mb-lg-5">
<?php echo $dadosCaroussel['desc_curta']; ?>
</p>
<p>
<a href="artigo.php?x=<?php echo $dadosCaroussel['URL']; ?>" class="btn btn-lg btn-primary btn-caroussel">Ler artigo</a>
</p>
</div>
</div>
<?php } ?>
</div>
<button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide="prev">
<span class="carousel-control-prev-icon" aria-hidden="true"></span>
<span class="visually-hidden">Previous</span>
</button>
<button class="carousel-control-next" type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide="next">
<span class="carousel-control-next-icon" aria-hidden="true"></span>
<span class="visually-hidden">Next</span>
</button>
</div>
<!------ Fim Caroussel ------>
<!------ DESTAQUES ------>
<div class="container-fluid">
<div class="container">
<div class="row mb-5">
<?php foreach ($dados_destaque as $dadosDestaque)

{ ?>
<div class="col-md-6 mb-4">
<div class="row g-0 border rounded overflow-hidden flex-md-row cat h-100">
<div class="col p-4 d-flex flex-column position-static">
<?php
//PUXAR O NOME DA CATEGORIA
$sql_categoria_nome = $pdo->prepare("SELECT * FROM categorias WHERE id=?");
$sql_categoria_nome->execute(array($dadosDestaque['categoria']));
$dados_categoria_nome = $sql_categoria_nome->fetchAll();
?>
<strong class="d-inline-block mb-2 text-primary"><?php echo($dados_categoria_nome[0]['nome_categoria']); ?></strong>
<h3 class="mb-0 title"><?php echo($dadosDestaque['titulo']); ?></h3>
<div class="mb-1 text-muted">
<?php echo($dadosDestaque['data_postagem']); ?>
</div>
<p class="card-text mb-auto">
<?php echo($dadosDestaque['desc_curta']); ?></p>
<a href="artigo.php?x=<?php echo($dadosDestaque['URL']); ?>" class="btn btn-sm btn-primary mt-4 btn-des">Continue lendo...</a>
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
<div class="row row-cols-1 row-cols-md-2 g-4 h-100" id="areaPosts">
<?php foreach ($dados_post as $dadosPost){ ?>
<div class="col-md-6">
<div class="card cat h-100">
<div style="background: url('<?php echo $dadosPost['imagem']; ?>') no-repeat;background-size:cover;background-position:center; border-top-left-radius:5px;border-top-right-radius:5px;">
<img src="Plataforma/dist/img/postp.png" class="img-fluid invisible">
</div>
<div class="card-body">
<h5 class="card-title title"><?php echo $dadosPost['titulo']; ?></h5>
<p class="card-text"><?php echo $dadosPost['desc_curta']; ?></p>
<a href="artigo.php?x=<?php echo $dadosPost['URL']; ?>" class="btn btn-sm btn-primary btn-post">Ler mais</a>
<?php
//PUXAR O NOME DA CATEGORIA
$sql_categoria_nome2 = $pdo->prepare("SELECT * FROM categorias WHERE id=?");
$sql_categoria_nome2->execute(array($dadosPost['categoria']));
$dados_categoria_nome2 = $sql_categoria_nome2->fetchAll();
?>
<a href="categoria.php?x=<?php echo $dados_categoria_nome2[0]['url_categoria']; ?>" class="btn btn-primary btn-sm btn-des" style="position:relative; float: right;"><?php echo $dados_categoria_nome2[0]['nome_categoria']; ?></a>

      </div>
    </div>
  </div>
<?php }?>
</div>
</div>
<!------ FECHA POSTS ------>

<div class="row my-5">
<div class="col-10 mt-4 mx-auto">
<div class="d-grid gap-2">
  <button data-pagina="1" id="maisPosts" class="btn btn-outline-primary" type="button">Ver mais postagens</button>
</div>
</div>
</div>
<hr class="border border-1 opacity-100 m-3"/>
<?php }else {
  echo('<div class="card p-5 mt-5 text-center">
  <div class="card-body">
    <h1>Em breve um conteúdo incrível aqui!</h1>
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
<script>
$('#maisPosts').click(function(){
 var pagina = $('#maisPosts').attr('data-pagina');
$('#maisPosts').text('Carregando postagens...');
$('#maisPosts').addClass('disabled');

// REQUISIÇÃO PARA PUXAR MAIS POSTS
$.ajax({
url: "Plataforma/actions/puxar_posts.php",
type: "post",
data: {pagina:pagina,qtd: <?php echo $qntd; ?>} ,
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
})
</script>
</body>
</html>