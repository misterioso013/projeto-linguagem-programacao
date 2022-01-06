<?php
session_start();
require_once '../vendor/autoload.php';
use App\Models\Model;
$dotenv = Dotenv\Dotenv::createImmutable("../");
$dotenv->load();

$name = $_POST["name"];
$email = $_POST["email"];
$password = $_POST["pass"];

if(empty($email) or empty($name) or empty($password)) {
    $_SESSION["msg"] = '<div class="alert alert-warning alert-dismissible fade show" role="alert">
  <strong>Ops!</strong> Você esqueceu de digitar alguns campos, verifique seus dados e tente novamente!
  <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
</div>';
    header('location: ../register');
    exit;
}

$pdo =  new Model();

$verify = $pdo->select(['email' => $email], '1');
if($verify->fetch()) {
    $_SESSION["msg"] = '<div class="alert alert-warning alert-dismissible fade show" role="alert">
  <strong>Essa conta já foi criada!</strong> Acesse sua conta agora mesmo.
  <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
</div>';
    header('location: ../login');
    exit;
}else {
    $password = password_hash($password, PASSWORD_DEFAULT);
    $date = date("Y-m-d H:i:s");
    $token = md5($date.'-'.$email);
    $data = [
        "name" => $name,
        "email"  => $email,
        "password" => $password,
        "token" => $token,
        "session" => $date,
        "credit" => rand(1111,9999),
        "type"  => 'user'
    ];
    $create = $pdo->insert($data);
    if($create){
        $_SESSION["msg"] = '<div class="alert alert-success alert-dismissible fade show" role="alert">
  <strong>Conta criada com sucesso!</strong> Acesse usando os dados cadastrados.
  <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
</div>';
        header('location: ../login');
    }else{
        $_SESSION["msg"] = '<div class="alert alert-warning alert-dismissible fade show" role="alert">
  <strong>Erro ao criar sua conta!</strong> tente novamente!
  <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
</div>';
        header('location: ../register');
    }
    exit;

}