<?php
session_start();
require('../../db/conexao.php');

if (isset($_SESSION['token']) && isset($_SESSION['id'])) {
  
$token = $_SESSION['token'];
$id = $_SESSION['id'];

//Verificar se existe os Valores
if(isset($_POST['idCategoriaDeletar'])) {
 //Verificar se estao corretos
$sql = $pdo->prepare("SELECT * from admin WHERE token=? AND id=?");
 
$sql->execute(array($token,$id));
$quantos = $sql->rowCount();
$dados_usuario = $sql->fetchAll();
if ($quantos == 0) {
header('location: ../categorias.php?erro=deletar-nao-autorizado');
}else
//Verificou se o usuario e valido
$id_categoria = limpaPost($_POST['idCategoriaDeletar']);

if ($dados_usuario[0]['nivel'] == 'sim') {
//DELETAR NO BANCO
try{
$sql = $pdo->prepare("DELETE FROM categorias WHERE id=?");
$sql->execute(array($id_categoria));
$sql_postagens= $pdo->prepare("DELETE FROM posts WHERE categoria=?");
$sql_postagens->execute(array($id_categoria));

header('location: ../categorias.php?erro=deletar-ok');
}catch(PDOException $e){
header('location: ../categorias.php?erro=deletar-falha-ao-deletar');
  }
 }else{
header('location: ../categorias.php?erro=deletar-falha-ao-deletar');
 }
}

}else {
  header('location: ../../login.php');
}






