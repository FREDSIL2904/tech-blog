<?php 
//PUXAR AS CATEGORIAS 
$sql_rodape = $pdo->prepare("SELECT * FROM categorias ORDER BY id DESC LIMIT 5");
$sql_rodape->execute();
$dados_categoria_rodape = $sql_rodape->fetchAll();
//PUXAR ULTIMAS POSTAGENS 
$sqlUltimas = $pdo->prepare("SELECT * FROM posts LIMIT 3");
$sqlUltimas->execute();
$dados_post_ultimas = $sqlUltimas->fetchAll();


?>


<div class="container mt-5">
<footer class="py-5">
<div class="row">
<div class="col-6 col-md-2 mb-3">
<h5>Categorias</h5>
<ul class="nav flex-column">
<?php foreach ($dados_categoria_rodape as $dadosRodape) { ?>
<li class="nav-item mb-2"><a href="categoria.php?x=<?php echo $dadosRodape['url_categoria']; ?>" class="nav-link p-0 text-muted"><?php echo $dadosRodape['nome_categoria']; ?></a></li>
<?php } ?>
</ul>
</div>

<div class="col-6 col-md-2 mb-3">
<h5>Últimas 3 postagens</h5>
<ul class="nav flex-column">
 <?php foreach ($dados_post_ultimas as $dadosPostRodape) { ?>
<li class="nav-item mb-2"><a href="artigo.php?x=<?php echo $dadosPostRodape['URL']; ?>" class="nav-link p-0 text-muted"><?php echo $dadosPostRodape['titulo']; ?></a></li>
<?php } ?>
</ul>
</div>
<div class="col-6 col-md-2 mb-3">
<h5>Sobre</h5>
<ul class="nav flex-column">
<li class="nav-item mb-2"><a href="autor.php" class="nav-link p-0 text-muted">Autor</a></li>
</ul>
</div>

<div class="col-md-5 offset-md-1 mb-3">
<form>
<h5>Subscribe to our newsletter</h5>
<p>Monthly digest of what's new and exciting from us.</p>
<div class="d-flex flex-column flex-sm-row w-100 gap-2">
<label for="newsletter1" class="visually-hidden">Email address</label>
<input id="newsletter1" type="text" class="form-control" placeholder="Email address">
<button class="btn btn-primary" type="button">Subscribe</button>
</div>
</form>
</div>
</div>
<div class="d-flex flex-column flex-sm-row justify-content-between py-4 my-4 border-top text-center">
<p>© Info Tec 2023. Todos os direitos reservados.</p>
<ul class="list-unstyled d-flex">
<li class="ms-3 h3"><a class="link-dark" href="#"><i class="bi bi-facebook"></i></a></li>
<li class="ms-3 h3"><a class="link-dark" href="#"><i class="bi bi-instagram"></i></a></li>
<li class="ms-3 h3"><a class="link-dark" href="#"><i class="bi bi-twitter"></i></a></li>
</ul>
</div>
</footer>
</div>