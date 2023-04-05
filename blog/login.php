<?php 
session_start();
require('db/conexao.php');

if (isset($_SESSION['token']) && isset($_SESSION['id'])) {
$tokenSessao = $_SESSION['token'];
$id = $_SESSION['id'];
$sql = $pdo->prepare('SELECT * from admin WHERE token=? AND id=? ');
$sql->execute(array($tokenSessao,$id));
$quantos = $sql->rowCount();
if ($quantos == 0) {
  session_unset();
  session_destroy();
}else {
header('location: Plataforma/index.php');
}
}else {
  session_unset();
  session_destroy();
}
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
<title>Login</title>
</head>
<body>
<!-------- incluir o Navbar-->
<?php include('componentes/navbar.php'); ?>

<main class="form-signin w-100 m-auto text-center container">
<form class="my-4 m-4 login" method="post" id="formLogin">
<strong class="display-1 fw-bolder text-uppercase">Blog</strong>
<h1 class="h3 mb-3 mt-3 fw-normal">Entrar na conta</h1>
<?php
if(isset($_POST['login']) && isset($_POST['senha'])){

$email = limpaPost($_POST['login']
);
if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
  echo '<div class="alert alert-danger" role="alert">
  Email inválido!
</div>';
}
$senha = limpaPost($_POST['senha']
);
$senhaCriptografada = md5($senha);
$sql = $pdo->prepare("SELECT * FROM admin WHERE email=? and senha=? LIMIT 1");
$sql->execute(array($email,$senhaCriptografada));
$quantos = $sql->rowCount();

if ($quantos == 1) {
  $dados = $sql->fetchAll();
  session_start();
  $hoje = date('d-m-Y-H-s-i');
  $token = md5(uniqid().$hoje);
  $id = $dados[0]['id'];
  $_SESSION['id'] = $id;
  $_SESSION['token'] = $token;

  try{
$sql = $pdo->prepare("UPDATE admin SET token=? WHERE id=?");
$sql->execute(array($token,$id));
  if (isset($_POST['lembrar'])) {
//SALVAR O COOKIE
setcookie('lembrar-login', $email, time() + (86400 * 30));
}else {
 setcookie('lembrar-login','', time() - 3600);
}
  header('location: Plataforma/index.php');
  }catch(PDOException $e){
echo '<div class="alert alert-danger" role="alert">
  Falha ao comunicar com o servidor!
</div>';
  }
}else{
  echo '<div class="alert alert-danger" role="alert">
  Email ou senha inválido!
</div>';
}
}

?>


<div class="form-floating">
<input type="email" class="form-control mb-3" id="login" name="login" placeholder="Seu email..." <?php if(isset($_COOKIE['lembrar-login'])){
$emailcookie = $_COOKIE['lembrar-login'];
echo "value='$emailcookie'";
} ?> required>
<label for="login">E-mail</label>
<div id="msg-login" class="invalid-feedback">

</div>
</div>
<div class="form-floating">
<input type="password" class="form-control " id="senha" name="senha" placeholder="Sua senha..." required>
<label for="senha">Senha</label>
<div id="msg-senha" class="invalid-feedback">

</div>
</div>

<div class="checkbox mb-5 mt-5">
<label>
<input name="lembrar" type="checkbox" value="Lembrar" <?php if(isset($_COOKIE['lembrar-login'])){
echo "checked";
} ?>  class="me-1 justify-content-center"> Lembrar de min
</label>
</div>
<button name="fazerLogin" class="w-100 btn btn-primary btn-lg" type="button" id="fazerLogin">Login</button>
<p class="my-5 text-muted">
©
<script>
document.write(new Date().getFullYear());
</script>
</p>
</form>
</main>




<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js" integrity="sha384-w76AqPfDkMBDXo30jS1Sgez6pr3x5MlQ1ZAGC+nuZB+EYdgRZgiwxhTBTkF7CXvN" crossorigin="anonymous"></script>
<script src="https://code.jquery.com/jquery-3.6.3.js" integrity="sha256-nQLuAZGRRcILA+6dMBOvcRh5Pe310sBpanc6+QBmyVM=" crossorigin="anonymous"></script>
<script>

function validateEmail($email) {
  var emailReg = /^([\w-\.]+@([\w-]+\.)+[\w-]{2,4})?$/;
  return emailReg.test( $email );
}
$("#login").keyup(function(){
$("#login").removeClass('is-invalid');
});
$("#senha").keyup(function(){
$("#senha").removeClass('is-invalid');
});

$("#fazerLogin").click(function() {
var login = $("#login").val();
var senha = $("#senha").val();

if (login == "" || login == null) {
$("#msg-login").html('Informe um e-mail de login');
$("#login").addClass('is-invalid');
$("#login").val('');
$("#login").focus();
return false;
}else{
  if( !validateEmail(login)) {
$("#msg-login").html('Informe um e-mail válido');
$("#login").addClass('is-invalid');
$("#login").val('');
$("#login").focus();
return false;
  }else{
    var emailok = "sim";
  }
}
if (senha == "" || senha == null) {
$("#msg-senha").html('Informe uma senha');
$("#senha").addClass('is-invalid');
$("#senha").val('');
$("#senha").focus();
return false;
}else{
  var senhaok = "sim";
}
if(emailok == "sim" && senhaok == "sim"){
  $("#formLogin").submit();
}
});
</script>
</body>
</html>