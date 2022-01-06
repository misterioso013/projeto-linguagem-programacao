<?php
session_start();
require_once '../vendor/autoload.php';
use App\Models\Model;
$dotenv = Dotenv\Dotenv::createImmutable("../");
$dotenv->load();
if(!isset($_GET["token"]) or $_GET["token"] != $_SESSION["token"]){
    header('location: ../login');
    exit;
}
$connect_admin = new Model();
$verify_admin = $connect_admin->select(['id' => $_SESSION['id']])->fetch();
if($verify_admin["type"] != "admin"){
    header('location: ../login');
    exit;
}
$user = $connect_admin->update([
    "name" => $_POST['name'],
    "email" => $_POST['email'],
    "type" => $_POST['type'],
    "credit" => $_POST["credit"]
], "id='".$_POST['id']."'");
if($user) {
    $_SESSION["msg"] = '<div class="alert alert-success alert-dismissible fade show" role="alert">
  <strong>Muito bem!</strong> dados alterados com sucesso!
  <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
</div>';
    header('location: ../admin');
    exit;
}else{
    $_SESSION["msg"] = '<div class="alert alert-warning alert-dismissible fade show" role="alert">
  <strong>Não foi possível alterar os dados desse cliente</strong>
  <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
</div>';
    header('location: ../admin');
    exit;
}