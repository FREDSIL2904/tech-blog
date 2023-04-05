<?php 
require('db/conexao.php');
if (isset($_POST['busca'])) {
$valor_busca = limpaPost($_POST['busca']);

// BUSCAR NOS POSTS POR ESSE VALOR 
$sql_busca = $pdo->prepare("SELECT * FROM posts WHERE titulo LIKE ? OR conteudo LIKE ?");
$sql_busca->execute(array('%'.$valor_busca.'%','%'.$valor_busca.'%'));
$quantos_posts_busca = $sql_busca->rowCount();
//$dados_Post = $sql_buscal->fetchAll();

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
<link rel="stylesheet" href="Plataforma/dist/css/style.css">
<title>Busca</title>
</head>
<body>
<!-------- incluir o Navbar-->
<?php include('componentes/navbar.php');?>

<main class="container">
<div class="row m-5">
<div class="col text-center">
<h1>Busca por: <?php echo($valor_busca); ?></h1>
<h3>Resultados encontrados: <?php echo($quantos_posts_busca); ?></h3>
</div>
<?php if ($quantos_posts_busca ==0) {
echo('<div class="card p-5 mt-5 text-center">
  <div class="card-body">
    <h1>Nenhum resultado encontrado ...</h1>
  </div>
</div>');
}else { $dados_Post_Busca = $sql_busca->fetchAll();?>
<!------ POSTS ------>
<div class="container">
<div class="row row-cols-1 row-cols-md-2 g-4" id="areaPosts">
<?php foreach ($dados_Post_Busca as $dadosPost){ ?>
<div class="col-md-6">
<div class="card shadow-sm h-100">
<div style="background: url('<?php echo $dadosPost['imagem']; ?>') no-repeat;background-size:cover;background-position:center;">
<img src="Plataforma/dist/img/postp.png" class="img-fluid invisible">
</div>
<div class="card-body">
<h5 class="card-title"><?php echo $dadosPost['titulo']; ?></h5>
<p class="card-text"><?php echo $dadosPost['desc_curta']; ?></p>
<a href="artigo.php?x=<?php echo $dadosPost['URL']; ?>" class="btn btn-sm btn-primary">Ler mais</a>
<?php
//PUXAR O NOME DA CATEGORIA
$sql_categoria_nome2 = $pdo->prepare("SELECT * FROM categorias WHERE id=?");
$sql_categoria_nome2->execute(array($dadosPost['categoria']));
$dados_categoria_nome2 = $sql_categoria_nome2->fetchAll();
?>
<a href="categoria.php?x=<?php echo $dados_categoria_nome2[0]['url_categoria']; ?>" class="btn btn-primary btn-sm" style="position:relative; float: right;"><?php echo $dados_categoria_nome2[0]['nome_categoria']; ?></a>

      </div>
    </div>
  </div>
<?php }?>
</div>
</div>
<?php } ?>
</div>
</main>



<!------ Rodapé -------->
<?php include('componentes/footer.php');?>










<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js" integrity="sha384-w76AqPfDkMBDXo30jS1Sgez6pr3x5MlQ1ZAGC+nuZB+EYdgRZgiwxhTBTkF7CXvN" crossorigin="anonymous"></script>
</body>
</html>