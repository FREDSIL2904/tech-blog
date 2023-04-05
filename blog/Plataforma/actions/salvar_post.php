<?php
session_start();
require('../../db/conexao.php');

if (isset($_SESSION['token']) && isset($_SESSION['id'])) {
  
$token = $_SESSION['token'];
$id = $_SESSION['id'];

//Verificar se existe os Valores
if (isset($_FILES['inputImg']) && isset($_POST['selectCategoria'])&& isset($_POST['titulo'])&& isset($_POST['url']) && isset($_POST['conteudo']) && isset($_POST['descricaoCurta'])) {
 //Verificar se estao corretos
$sql = $pdo->prepare("SELECT * from admin WHERE token=? AND id=? LIMIT 1");
 
$sql->execute(array($token,$id));
$quantos = $sql->rowCount();
if ($quantos == 0) {
header('location: ../index.php?erro=nao-autorizado');
}else {
//Verificou se o usuario e valido
//Verificacao da imagem
$tamanhoMax = 2097152; //2MB 
$permitido = array("jpg","png","jpeg");
$extensao = pathinfo($_FILES['inputImg']['name'], PATHINFO_EXTENSION);

//VERIFICAR SE TEM TAMANHO PERMITIDO
if ($_FILES['inputImg']['size'] >= $tamanhoMax){
header('location: ../index.php?erro=imagem-tamanho-grande');
}else{
//VERIFICAR SE EXTENSAO É PERMITIDA
if(in_array($extensao, $permitido)){
//echo "Permitido";
$pasta = "../img-posts/";
if(!is_dir($pasta)){
mkdir($pasta,0755);
}
$tmp = $_FILES['inputImg']['tmp_name'];
$novoNome = uniqid().".$extensao";
//Se moveu o arquivo
if(move_uploaded_file($tmp,$pasta.$novoNome)){
//Se Fez o Upload da imagem
$categoria = limpaPost($_POST['selectCategoria']);
$titulo = limpaPost($_POST['titulo']);
$descricaoCurta = limpaPost($_POST['descricaoCurta']);
$url = limpaPost($_POST['url']);
$conteudo = $_POST['conteudo'];
$imagem_url = "http://localhost:8080/blog/Plataforma/img-posts/$novoNome";
$data = date('d/m/Y');
$hora = date('H:i:s');
$status = 'Publicado';
//Validação da url
$url_limpa = strtolower( preg_replace("/[^a-zA-Z0-9-]/", "-", strtr(utf8_decode(trim($url)), utf8_decode("áàãâéêíóôõúüñçÁÀÃÂÉÊÍÓÔÕÚÜÑÇ"),"aaaaeeiooouuncAAAAEEIOOOUUNC-")) );
//Salvar no Banco
try{
$sql = $pdo->prepare("INSERT INTO posts VALUES (null, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
$sql->execute(array($id,$categoria,$titulo,$descricaoCurta,$url_limpa,$status,$conteudo,$imagem_url,$data,$hora));
header('location: ../index.php?erro=ok');
}catch(PDOException $e){
header('location: ../index.php?erro=falha-ao-inserir');
}
}else{                   
header('location: ../index.php?erro=imagem-upload');
}
}else{
header('location: ../index.php?erro=extensao-nao-permitida');
               
            }       
        }
  }

}
}else {
  header('location: ../../login.php');
}





