<?php
session_start();
require('../../db/conexao.php');

if (isset($_SESSION['token']) && isset($_SESSION['id'])) {
  
$token = $_SESSION['token'];
$id = $_SESSION['id'];

//Verificar se existe os Valores
if(isset($_POST['novaCategoria'])) {
 //Verificar se estao corretos
$sql = $pdo->prepare("SELECT * from admin WHERE token=? AND id=?");
 
$sql->execute(array($token,$id));
$quantos = $sql->rowCount();
if ($quantos == 0) {
header('location: ../categorias.php?erro=nao-autorizado');
}else {
//Verificou se o usuario e valido
$categoria = limpaPost($_POST['novaCategoria']);
if ($categoria =="" || $categoria == null) {
 header('location: ../categorias.php?erro=falha-ao-inserir');
 exit();
}


//Validação da url
$categoria_limpa = strtolower( preg_replace("/[^a-zA-Z0-9-]/", "-", strtr(utf8_decode(trim($categoria)), utf8_decode("áàãâéêíóôõúüñçÁÀÃÂÉÊÍÓÔÕÚÜÑÇ"),"aaaaeeiooouuncAAAAEEIOOOUUNC-")) );

//Salvar no Banco
try{
$sql = $pdo->prepare("INSERT INTO categorias  VALUES (null,?,?)");
$sql->execute(array($categoria,$categoria_limpa));
header('location: ../categorias.php?erro=ok');
}catch(PDOException $e){
header('location: ../categorias.php?erro=falha-ao-inserir');
  }
 }
}
}else {
  header('location: ../../login.php');
}






