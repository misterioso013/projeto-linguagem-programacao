<?php
session_start();
require_once '../vendor/autoload.php';
use App\Models\Model;
$dotenv = Dotenv\Dotenv::createImmutable("../");
$dotenv->load();
$pdo = new Model();

$verify = $pdo->select(['id' => $_SESSION["id"]], '1');
$result = $verify->fetch();

if(!$result) {
    $_SESSION["msg"] = '<div class="alert alert-warning alert-dismissible fade show" role="alert">
  <strong>Faça o login  para continuar.</strong>
  <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
</div>';
    header('location: ../login');
    exit;
}


$token = md5($result["session"].'-'.$result["email"]);

if($token != $_SESSION["token"]){
    $_SESSION["msg"] = '<div class="alert alert-warning alert-dismissible fade show" role="alert">
  <strong>Token incorreto! Faça o login  para continuar.</strong>
  <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
</div>';
    header('location: ../login');
    exit;
}

?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hey Cred - Tenha seu cartão de crédito grátis</title>
    <link rel="stylesheet" href="../style.css">
</head>
<body>
    <div class="container">
        <h1 class="text-center pt-5">Hey Cred</h1>
        <h3 class="text-center mt-5 mb-5">Olá, <?php echo $result["name"]; ?>! Seja bem-vindo(a)!</h3>
       <div class="row">
           <div class="col-sm-4">
               <div class="card text-center" style="width: 18rem;">
                   <div class="card-body">
                       <h5 class="card-title">Despesas</h5>
                       <h6 class="card-subtitle mb-2 text-muted">
                           <span class="text-danger" data-bs-toggle="tooltip" data-bs-placement="top" title="Você ainda não usou seu cartão">R$0,00</span>
                       </h6>
                       <p class="card-text">Aqui você controla suas despesas mensais</p>
                   </div>
               </div>
           </div>
           <div class="col-sm-4">
               <div class="card text-center" style="width: 18rem;">
                   <div class="card-body">
                       <h5 class="card-title">Seu limite</h5>
                       <h6 class="card-subtitle mb-2 text-muted">
                           <span class="text-success" data-bs-toggle="tooltip" data-bs-placement="top" title="Seu limite poderá aummentar em breve">R$<?php echo number_format($result["credit"], 2, ",", ".");?></span> <span class="badge bg-danger">Novo</span>
                       </h6>
                       <p class="card-text">Seu limite aumentará após realizar compras com seu cartão.</p>
                   </div>
               </div>
           </div>
           <div class="col-sm-4">
               <div class="card text-center" style="width: 18rem;">
                   <div class="card-body">
                       <h5 class="card-title">Saldo em conta</h5>
                       <h6 class="card-subtitle mb-2 text-muted">
                           <span class="text-success" data-bs-toggle="tooltip" data-bs-placement="top" title="Use seu saldo agora mesmo">R$<?php echo number_format(rand(11,99999), 2, ",", ".");?></span>
                       </h6>
                       <p class="card-text">Esse é seu saldo total na sua conta HeyCred</p>
                   </div>
               </div>
           </div>
       </div>
        <?php
        if($result['type'] == 'admin'){
            echo '<div class="text-center pt-5 pb-5"><h4 class="mb-3">Você é um administrador</h4>';
            echo '<a href="../admin" class="btn btn-primary btn-lg">Acessar Painel</a></div>';
        }
        ?>
    </div>
    <script src="../vendor/twbs/bootstrap/dist/js/bootstrap.bundle.min.js"></script>
<script>
    var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
    var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
        return new bootstrap.Tooltip(tooltipTriggerEl)
    })
</script>
</body>
</html>