<?php

session_start();
require_once '../vendor/autoload.php';
use App\Models\Model;
$dotenv = Dotenv\Dotenv::createImmutable("../");
$dotenv->load();

$email = $_POST["email"];
$password = $_POST["password"];

if(empty($email)  or empty($password)) {
    $_SESSION["msg"] = '<div class="alert alert-warning alert-dismissible fade show" role="alert">
  <strong>Ops!</strong> Você esqueceu de digitar alguns campos, verifique seus dados e tente novamente!
  <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
</div>';
    header('location: ../login');
    exit;
}

$pdo =  new Model();

$verify = $pdo->select(['email' => $email], '1');
$result = $verify->fetch();
if($result) {
    if(password_verify($password, $result["password"])) {
        $id = $result['id'];
        $type = $result["type"];
        $date = date("Y-m-d H:i:s");
        $token = md5($date.'-'.$email);
        $data = [
            'session' => $date,
            "token" => $token
        ];
        $_SESSION["token"] = $token;
        $_SESSION["id"] = $id;
        if($pdo->update($data, "id='$id'")) {
            if($type == "admin") header('location: ../admin');
            else header('location: ../pages/home.php');
            exit;
        }
    }else{
        $_SESSION["msg"] = '<div class="alert alert-warning alert-dismissible fade show" role="alert">
  <strong>Senha incorreta! Tente novamente.</strong>
  <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
</div>';
        header('location: ../login');
        exit;
    }
}else{
    $_SESSION["msg"] = '<div class="alert alert-warning alert-dismissible fade show" role="alert">
  <strong>Ops!</strong> Conta não cadastrada no sistema, por favor crie sua conta!
  <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
</div>';
    header('location: ../register');
    exit;
}
