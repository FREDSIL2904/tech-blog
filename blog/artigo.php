<?php 
require('db/conexao.php');
if (isset($_GET['x'])) {
$URL = limpaPost($_GET['x']);

//PUXAR POSTS DA URL VINDA DO GET
$sql = $pdo->prepare("SELECT * FROM posts WHERE URL=?");
$sql->execute(array($URL));
$quantos_posts = $sql->rowCount();
$dados_Post = $sql->fetchAll();
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
<link rel="stylesheet" href="style.css">
<title>Blog</title>
</head>
<body>
<!-------- incluir o Navbar-->
<?php include('componentes/navbar.php');?>
<?php if ($quantos_posts >0) {
$id_categoria = $dados_Post[0]['categoria'];
$id_autor = $dados_Post[0]['autor'];

//PUXAR TODAS AS CATEGORIAS
$sql_categoriaS = $pdo->prepare("SELECT * FROM categorias order by nome_categoria");
$sql_categoriaS->execute();
$dados_categoriaS = $sql_categoriaS->fetchAll();


//PUXAR O NOME DA CATEGORIA
$sql_categoria_nome = $pdo->prepare("SELECT * FROM categorias WHERE id=?");
$sql_categoria_nome->execute(array($id_categoria));
$dados_categoria_nome = $sql_categoria_nome->fetchAll();

//PUXAR O NOME DO AUTOR
$sql_autor = $pdo->prepare("SELECT * FROM admin WHERE id=?");
$sql_autor->execute(array($id_autor));
$dados_autor = $sql_autor->fetchAll();

?>

<div class="container-fluid">
<main class="main container">
   <div class="row g-5 my-5"> 
    <div class="col-md-8"> 
<h2 class="pb-4 mb-4 fw-bold border-bottom fs-4 text-primary"><?php echo $dados_categoria_nome[0]['nome_categoria']; ?></h2> 
     <article class="blog-post"> 
      <h1 class="blog-post-title mb-2 title"><?php echo $dados_Post[0]['titulo']; ?></h1> 
      <p class="blog-post-meta fw-bold text-primary fs-7"><?php echo $dados_Post[0]['data_postagem']; ?> as <?php echo $dados_Post[0]['hora']; ?></p> Por <a class="link-dark fw-bold fs-6" href="autor.php"><?php echo $dados_autor[0]['nome']; ?></a>
      <img class="img-fluid mb-5 mt-3 rounded" src="<?php echo $dados_Post[0]['imagem'] ?>" style="box-shadow: 0 0  10px rgba(0,0,0,.3);"/>
<p><?php echo $dados_Post[0]['conteudo'] ?></p>

</div> 
<div class="col-md-4 mt-5"> 
<div class="position-sticky" style="top: 2rem;"> 
<div class="p-4 mb-3 mt-5 bg-light text-center"> 
<img src="<?php echo $dados_autor[0]['imagem_autor']; ?>" width="50" height="50" class="mb-4 rounded-circle mt-5">
<h4 class="fs-3 fw-bold"><?php echo $dados_autor[0]['nome']; ?></h4> 
<p class="mb-0 fw-bold"><?php echo $dados_autor[0]['sobremin']; ?></p> 
</div> 

<div class="p-4"> 
<h3 class="fst-italic mb-3">Categorias</h3> 
<?php foreach ($dados_categoriaS as $dadosCat) { 
$id_categoria_foreach = $dadosCat['id'];
//PUXAR TODAS AS CATEGORIAS
$sql_posts3 = $pdo->prepare("SELECT * FROM posts WHERE categoria=?");
$sql_posts3->execute(array($id_categoria_foreach));
$qtd_posts_x = $sql_posts3->rowCount();

?>
<ol class="list-unstyled mb-3"> 
<li><a class="text-info fw-bold fs-6" href="categoria.php?x=<?php echo $dadosCat['url_categoria']; ?>"><?php echo $dadosCat['nome_categoria']; ?>    </a>  (<?php echo $qtd_posts_x; ?>)</li>
<?php } ?>
</ol> 

</div> 
</div> 
</div> 
</div> 
</main>
</div>
<?php }else{
echo('<div class="card p-5 mt-5 text-center">
  <div class="card-body">
    <h1>Erro 404 - página não encontrada...</h1>
  </div>
</div>');
  
}
?>

<!------ Rodapé -------->
<?php include('componentes/footer.php');?>










<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js" integrity="sha384-w76AqPfDkMBDXo30jS1Sgez6pr3x5MlQ1ZAGC+nuZB+EYdgRZgiwxhTBTkF7CXvN" crossorigin="anonymous"></script>
</body>
</html>