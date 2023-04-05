<?php
// CONFIGURAÇÕES GERAIS
$servidor = "localhost";
$usuario  = "root";
$senha    = "";
$banco    = "blog";

//CONEXÃO
try {
$pdo = new PDO("mysql:host=$servidor;dbname=$banco",$usuario, $senha,);
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
// echo "Conectado com sucesso!";
}catch(PDOException $erro){
  echo "Falha ao se conectar com o banco !"; 
}
//LIMPEZA DE POSTS
function limpaPost($data) {
  $data = trim($data);
  $data = stripslashes($data);
  $data = htmlspecialchars($data);
  return $data;
}








?>