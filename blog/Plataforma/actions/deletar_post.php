<?php
session_start();
require('../../db/conexao.php');

if (isset($_SESSION['token']) && isset($_SESSION['id'])) {
  
$token = $_SESSION['token'];
$id = $_SESSION['id'];

//Verificar se existe os Valores
if(isset($_POST['idPostagemDeletar'])) {
 //Verificar se estao corretos
$sql = $pdo->prepare("SELECT * from admin WHERE token=? AND id=?");
 
$sql->execute(array($token,$id));
$quantos = $sql->rowCount();
if ($quantos == 0) {
header('location: ../index.php?erro=deletar-nao-autorizado');
}else {
//Verificou se o usuario e valido
$id_post = limpaPost($_POST['idPostagemDeletar']);

try{
$sql = $pdo->prepare("DELETE FROM posts WHERE id=? AND autor=?");
$sql->execute(array($id_post,$id));
header('location: ../index.php?erro=deletar-ok');
}catch(PDOException $e){
header('location: ../index.php?erro=deletar-falha-ao-deletar');
  }
 }
}


}else {
  header('location: ../../login.php');
}






