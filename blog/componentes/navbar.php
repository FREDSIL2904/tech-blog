<style>
    .navbar{
      position: fixed;
      width: 100%;
      background: linear-gradient(90deg, #0a0b7a, #061176, #00095e);
      height: 60px;
      z-index:999999;
      top: 0;
    }
    .logo{
    text-transform: uppercase;
    text-decoration: none;
    font-size: 25px;
  }
  .logo span{
    color: #0eb9e4 !important;
  }
  .nav{
    display: flex;
    align-items: center;
    justify-content: center;
    position: relative;
  }
  .dropdown-menu li a{
    color: #000;
    font-weight: 400;
  }
  .menu{
    display: none;
    align-items: center;
    justify-content: center;
    flex-direction: column;
    margin-right: 20px;
  }
  .nav a{
    color: #fff;
    font-size: 20px;
    text-decoration: none;
    font-weight: 500;
    margin-right: 20px;
    transition: .3s;
  }
  .nav a:hover{
    color: #0eb9e4;
  }
  .menu .bar{
    width: 35px;
    height: 4px;
    background: #fff;
    margin: 6px auto;
    margin-right: 20px;
    border-radius: 20px;
    transition: .4s;
  }
  @media (max-width: 768px){
    .menu{
      display: block;
    }
    .nav{
      position: fixed;
      flex-direction: column;
      width: 100%;
      height: 100vh;
      background: #0c076f;
      z-index: 99;
      top: 60px;
      right: -900px;
      gap: 80px;
      transition: .3s;
    }
    .nav li{
      
    }
    .nav a{
    color: #fff;
    font-size: 25px;
    text-decoration: none;
    font-weight: 500;
    transition: .3s;
    z-index: 999;
  }
  .nav .home{
    margin: 10px 40px;
  }
    .nav.active{
      right: 0;
      margin-right: 0;
    }
.menu.active .bar:nth-child(1){
      transform: translateY(10px) rotate(45deg);
    }
.menu.active .bar:nth-child(2){
      opacity: 0;
    }
.menu.active .bar:nth-child(3){
transform: translateY(-10px) rotate(-45deg);
}
  }
</style>
  
<?php 
//PUXAR AS CATEGORIAS 
$sql = $pdo->prepare("SELECT * FROM categorias");
$sql->execute();
$dados = $sql->fetchAll();
?>
<div class="contariner-fluid">
  <nav class="navbar navbar-dark bg-dark ">
    <a href="index.php" class="logo fw-bold text-white ms-3">Info <span class="text-info">Tec</span></a>
    <ul class="nav">
      <li>
        <a href="index.php">Home</a>
      </li>
<li class="nav-item dropdown">
<a class="nav-link active dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
Categorias
</a>
<ul class="dropdown-menu">
<?php foreach ($dados as $dado){ ?>
<li><a class="dropdown-item text-center" href="categoria.php?x=<?php echo $dado['url_categoria']; ?>"><?php echo $dado['nome_categoria'];  ?></a></li>
<?php } ?>
</ul>
</li>
            <li>
<a href="autor.php">Sobre</a>
      </li>
    </ul>
      <div class="menu">
    <div class="bar"></div>
    <div class="bar"></div>
    <div class="bar"></div>
  </div>
  </nav>
</div>
<script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
<script>
$('.menu').click(function(){
$('.nav').toggleClass('active');
$('.menu').toggleClass('active');
});
</script>