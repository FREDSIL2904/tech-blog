<?php 
require('db/conexao.php');

$sql = $pdo->prepare("SELECT * FROM posts");
$sql->execute();
$quantos_posts2 = $sql->rowCount();
$dados_post2 = $sql->fetchAll();

$id_autor2 = $dados_post2[0]['autor'];
//PUXAR O NOME DO AUTOR
$sql_autor2 = $pdo->prepare("SELECT * FROM admin WHERE id=?");
$sql_autor2->execute(array($id_autor2));
$dados_autor2 = $sql_autor2->fetchAll();
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
<title>Autor</title>
</head>
<body>
<?php include('componentes/navbar.php');?>

<div class="main container mt-5">
 <div class="row mt-5">
   <p class="text-center" style="margin-top: 45px;">Bem-vindo ao <b>Tec Info</b>!<br> 
   Aqui você encontrará artigos e análises sobre as mais recentes tendências em tecnologia, saúde, novidades muito mais.<br>
  Nós trazemos as novidades do mundo da tecnologia de uma forma acessível, divertida e informativa para todos que querem se manter atualizados nesse incrível universo de inovações e transformações digitais. <br>
    Então, fique por aqui e descubra conosco como a tecnologia está transformando cada aspecto de nossas vidas!</p>
   <div class="col text-center">
<h3 class="my-4 fw-bold text-uppercase">
<img class="img-fluid mt-5 rounded-circle mb-4" src="<?php echo $dados_autor2[0]['imagem_autor']; ?>" alt="autor" width="80" height="80" class="mb-4 "/><br>
<?php echo $dados_autor2[0]['nome']; ?></h3>
     <p class="fs-4 fw-bold"><?php echo $dados_autor2[0]['sobremin']; ?></p>
<a href="#" class="btn btn-primary btn-sm"><i class="bi bi-facebook "> </i>Facebook</a>
<a href="#" class="btn btn-danger btn-sm"> <i class="bi bi-instagram "> </i>Instagram</a>
<a href="#" class="btn btn-success btn-sm"> <i class="bi bi-whatsapp"> </i>Whatsapp</a>
   </div>
 </div>
 </div>
<!-------- incluir o footer-->














<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js" integrity="sha384-w76AqPfDkMBDXo30jS1Sgez6pr3x5MlQ1ZAGC+nuZB+EYdgRZgiwxhTBTkF7CXvN" crossorigin="anonymous"></script>
</body>
</html>