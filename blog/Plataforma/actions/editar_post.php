<?php
session_start();
require('../../db/conexao.php');

if (isset($_SESSION['token']) && isset($_SESSION['id'])) {
  
$token = $_SESSION['token'];
$id = $_SESSION['id'];

//Verificar se existe os Valores
if (isset($_POST['editar_id'])  &&isset($_POST['editar_selectCategoria']) && isset($_POST['editar_titulo'])&& isset($_POST['editar_descricaoCurta'])&& isset($_POST['editar_url'])&& isset($_POST['editar_conteudo'])) {
 //Verificar se estao corretos
$sql = $pdo->prepare("SELECT * from admin WHERE token=? AND id=?");
 
$sql->execute(array($token,$id));
$quantos = $sql->rowCount();
if ($quantos == 0) {
header('location: ../index.php?erro=editar-nao-autorizado');
}else {
//Verificou se o usuario e valido
if ($_FILES['editar_inputImg']['size'] == 0) {
//SE NÃO FOI ALTERADO A IMAGEM
$id_post  = limpaPost($_POST['editar_id']);
$categoria = limpaPost($_POST['editar_selectCategoria']);
$titulo = limpaPost($_POST['editar_titulo']);
$descricaoCurta = limpaPost($_POST['editar_descricaoCurta']);
$url = limpaPost($_POST['editar_url']);
$conteudo = $_POST['editar_conteudo'];
$data = date('d/m/Y');
$hora = date('H:i:s');
$status = 'Publicado';
//Validação da url
$url_limpa = strtolower( preg_replace("/[^a-zA-Z0-9-]/", "-", strtr(utf8_decode(trim($url)), utf8_decode("áàãâéêíóôõúüñçÁÀÃÂÉÊÍÓÔÕÚÜÑÇ"),"aaaaeeiooouuncAAAAEEIOOOUUNC-")) );

//Atualizar no Banco
try{
$sql = $pdo->prepare("UPDATE posts SET categoria=?, titulo=?, desc_curta=?, URL=?, status=?, conteudo=?, data_postagem=?, hora=? WHERE id=? AND autor=?");
$sql->execute(array($categoria,$titulo,$descricaoCurta,$url_limpa,$status,$conteudo,$data,$hora,$id_post,$id));
header('location: ../index.php?erro=editar-ok');
}catch(PDOException $e){
header('location: ../index.php?erro=editar-falha-ao-inserir');
} 
 
 
}else {
 //SE FOI ALTERADO A IMAGEM
//Verificacao da imagem
$tamanhoMax = 2097152; //2MB 
$permitido = array("jpg","png","jpeg");
$extensao = pathinfo($_FILES['editar_inputImg']['name'], PATHINFO_EXTENSION);

//VERIFICAR SE TEM TAMANHO PERMITIDO
if ($_FILES['editar_inputImg']['size'] >= $tamanhoMax){
header('location: ../index.php?erro=editar-imagem-tamanho-grande');
}else{
//VERIFICAR SE EXTENSAO É PERMITIDA
if(in_array($extensao, $permitido)){
//echo "Permitido";
$pasta = "../img-posts/";
if(!is_dir($pasta)){
mkdir($pasta,0755);
}
$tmp = $_FILES['editar_inputImg']['tmp_name'];
$novoNome = uniqid().".$extensao";
//Se moveu o arquivo
if(move_uploaded_file($tmp,$pasta.$novoNome)){
//Se Fez o Upload da imagem
$id_post  = limpaPost($_POST['editar_id']);
$categoria = limpaPost($_POST['editar_selectCategoria']);
$titulo = limpaPost($_POST['editar_titulo']);
$descricaoCurta = limpaPost($_POST['editar_descricaoCurta']);
$url = limpaPost($_POST['editar_url']);
$conteudo = $_POST['editar_conteudo'];
$imagem_url = "http://localhost:8080/blog/Plataforma/img-posts/$novoNome";
$data = date('d/m/Y');
$hora = date('H:i:s');
$status = 'Publicado';
//Validação da url
$url_limpa = strtolower( preg_replace("/[^a-zA-Z0-9-]/", "-", strtr(utf8_decode(trim($url)), utf8_decode("áàãâéêíóôõúüñçÁÀÃÂÉÊÍÓÔÕÚÜÑÇ"),"aaaaeeiooouuncAAAAEEIOOOUUNC-")) );

//Atualizar no Banco
try{
$sql = $pdo->prepare("UPDATE posts SET categoria=?, titulo=?, desc_curta=?, URL=?, status=?, conteudo=?, imagem=?, data_postagem=?, hora=? WHERE id=? AND autor=?");
$sql->execute(array($categoria,$titulo,$descricaoCurta,$url_limpa,$status,$conteudo,$imagem_url,$data,$hora,$id_post,$id));
header('location: ../index.php?erro=editar-ok');
}catch(PDOException $e){
header('location: ../index.php?erro=editar-falha-ao-inserir');
}
}else{                   
header('location: ../index.php?erro=editar-imagem-upload');
}
}else{
header('location: ../index.php?erro=editar-extensao-nao-permitida');
               
            }       
        }
  }
}
}
}else {
  header('location: ../../login.php');
}






