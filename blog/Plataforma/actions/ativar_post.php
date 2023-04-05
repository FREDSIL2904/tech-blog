<?php
session_start();
require('../../db/conexao.php');

if (isset($_SESSION['token']) && isset($_SESSION['id'])) {
$token = $_SESSION['token'];
$id = $_SESSION['id'];
}
//Verificar se existe os Valores
if(isset($_POST['idPostagemAtiva'])) {
 //Verificar se estao corretos
$sql = $pdo->prepare("SELECT * from admin WHERE token=? AND id=?");
 
$sql->execute(array($token,$id));
$quantos = $sql->rowCount();
if ($quantos == 0) {
header('location: ../index.php?erro=desativar-nao-autorizado');
}else {
//Verificou se o usuario e valido
$id_post = limpaPost($_POST['idPostagemAtiva']);
$status = 'Publicado';

try{
$sql = $pdo->prepare("UPDATE posts SET status=? WHERE id=? AND autor=?");
$sql->execute(array($status,$id_post,$id));
header('location: ../index.php?erro=desativar-ok');
}catch(PDOException $e){
header('location: ../index.php?erro=desativar-falha-ao-inserir');
}

   }


}else {
  header('location: ../../login.php');
}






