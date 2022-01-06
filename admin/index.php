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
<!doctype html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Administração - Hey Cad</title>
    <link rel="stylesheet" href="../style.css">
</head>
<body>
<div class="container">
    <?php
    if(isset($_GET["edit"])){
        // Edit
        $user = $pdo->select(["id" =>$_GET["edit"]],1);
        $result  = $user->fetch();
    ?>
        <h1 class="text-center">Editar cliente #<?php echo $result["id"];?></h1>
        <form action="./proc/edit.php?token=<?php echo $_SESSION['token'];?>" method="post">
            <input type="hidden" value="<?php echo $result['id']; ?>" name="id">
            <div class="mb-3">
                <label for="nome" class="form-label">Nome</label>
                <input type="text" class="form-control" id="nome" placeholder="Nome" name="name" value="<?php echo $result['name'];?>">
            </div>
            <div class="mb-3">
                <label for="email" class="form-label">E-mail</label>
                <input type="email" class="form-control" id="email" placeholder="Email" name="email" value="<?php echo $result['email'];?>">
            </div>
            <div class="mb-3">
                <select class="form-select" aria-label="Função" name="type">
                    <label for="type">Alterar função</label>
                    <?php
                    if($result['type'] == 'user'){
                        echo '<option value="user" selected>Cliente</option>';
                        echo '<option value="admin">Administrador</option>';
                    }else{
                        echo '<option value="user">Cliente</option>';
                        echo '<option value="admin" selected>Administrador</option>';
                    }
                    ?>
                </select>
            </div>
            <div class="mb-3">
                <label for="credit" class="form-label">Novo limite de Crédito</label>
                <input type="number" class="form-control" id="credit" placeholder="Novo limite de crédito" name="credit" value="<?php echo $result['credit'];?>">
            </div>
            <button type="submit" class="btn btn-success">Editar</button>
        </form>
    <?php
        // Fim:Edit
    }elseif(isset($_GET["delete"])){
        $id = $_GET['delete'];
        $delete = $pdo->delete("id = '{$id}'");
        if($delete){
            $_SESSION["msg"] = '<div class="alert alert-success alert-dismissible fade show" role="alert">
  <strong>Dados deletados com sucesso!</strong>
  <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
</div>';
            header('location: ./admin');
            exit;
        }else{
            $_SESSION["msg"] = '<div class="alert alert-warning alert-dismissible fade show" role="alert">
  <strong>erro interno:</strong> não foi possível deletar os dados desse cliente.
  <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
</div>';
            header('location: ./admin');
            exit;
        }
    }else{
    ?>
    <h1 class="text-center mt-5 mb-5">Clientes</h1>
        <?php
        if($_SESSION["msg"]){
            echo $_SESSION["msg"];
            unset($_SESSION["smg"]);
        }
        ?>
    <table class="table">
        <thead>
        <tr>
            <th scope="col">ID</th>
            <th scope="col">Nome</th>
            <th scope="col">E-mail</th>
            <th scope="col">Função</th>
            <th scope="col">Crédito</th>
            <th>Editar</th>
            <th>Excluir</th>
        </tr>
        </thead>
        <tbody>
        <?php
        $users = $pdo->select();

        while ($row = $users->fetch(PDO::FETCH_ASSOC)){
            extract($row);
            echo "</tr>";
            echo '<th scope="row">'.$id.'</th>';
            echo '<td>'.$name.'</td>';
            echo '<td>'.$email.'</td>';
            echo '<td>'.$type.'</td>';
            echo '<td>R$'.number_format($credit, 2, ",", ".").'</td>';
            echo '<td><a href="./admin?edit='.$id.'" class="btn btn-primary">Editar</a></td>';
            if($type == 'admin') {
                echo '<td><a href="./admin?delete='.$id.'" class="btn btn-danger disabled">Excluir</a></td>';
            }else{
                echo '<td><a href="./admin?delete='.$id.'" class="btn btn-danger">Excluir</a></td>';
            }
            echo "</tr>";



        }
        ?>
        </tbody>
    </table>
    <?php
    }
    ?>
</div>
<script src="../vendor/twbs/bootstrap/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
