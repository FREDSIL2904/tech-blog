<?php 
require('../../db/conexao.php');
if (isset($_POST['pagina']) && isset($_POST['qtd']) && isset($_POST['idcategoria'])) {

$pagina = limpaPost($_POST['pagina']);
$qtd = limpaPost($_POST['qtd']);
$id_categoria = limpaPost($_POST['idcategoria']);
$post_inicial = $pagina * $qtd;
//PROCURAR OS POSTS NO BANCO
$sql = $pdo->prepare("SELECT * FROM posts WHERE categoria=? ORDER BY id DESC LIMIT $post_inicial, $qtd");
$sql->execute(array($id));
$quantos = $sql->rowCount();
$dados_post_add = $sql->fetchAll();

if ($quantos>0) {
$card="";
foreach ($dados_post_add as $dadosPostAdd){ 
//PUXAR O NOME DA CATEGORIA
$sql_categoria_nome_add = $pdo->prepare("SELECT * FROM categorias WHERE id=?");
$sql_categoria_nome_add->execute(array($dadosPostAdd['categoria']));
$dados_categoria_nome_add = $sql_categoria_nome_add->fetchAll();

$card .= '<div class="col-md-6 cat">
<div class="card  h-100">
<div style="background: url(\''.$dadosPostAdd['imagem'].'\') no-repeat;background-size:cover;background-position:center;border-top-left-radius:5px;border-top-right-radius:5px;">
<img src="Plataforma/dist/img/postp.png" class="img-fluid invisible">
</div>
<div class="card-body">
<h5 class="card-title">'.$dadosPostAdd['titulo'].'</h5>
<p class="card-text">'.$dadosPostAdd['desc_curta'].'</p>
<a href="artigo.php?x='.$dadosPostAdd['URL'].'" class="btn btn-sm btn-primary">Ler mais</a>
<a href="categoria.php?x='.$dados_categoria_nome_add[0]['url_categoria'].'" class="btn btn-primary btn-sm" style="position:relative; float: right;">'.$dados_categoria_nome_add[0]['nome_categoria'].'</a>

      </div>
    </div>
  </div>';
  
}
echo $card;


 }else{
   echo 0;
 }
}
?>