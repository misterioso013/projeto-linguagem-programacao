<?php
session_start();
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Hey Cred</title>
    <link rel="stylesheet" href="../style.css">
    <style>
        html,
body {
  height: 100%;
}

body {
  display: flex;
  align-items: center;
  padding-top: 40px;
  padding-bottom: 40px;
  background-color: #f5f5f5;
}

.form-signin {
  width: 100%;
  max-width: 330px;
  padding: 15px;
  margin: auto;
}

.form-signin .checkbox {
  font-weight: 400;
}

.form-signin .form-floating:focus-within {
  z-index: 2;
}

.form-signin input[type="email"] {
  margin-bottom: -1px;
  border-bottom-right-radius: 0;
  border-bottom-left-radius: 0;
}

.form-signin input[type="password"] {
  margin-bottom: 10px;
  border-top-left-radius: 0;
  border-top-right-radius: 0;
}
    </style>
</head>
<body>
<main class="form-signin text-center">
  <form action="../proc/login.php" method="post">
    <img class="mb-4" src="../images/lock.png" alt="" width="100" height="100">
    <h1 class="h3 mb-3 fw-normal">Acesse sua conta</h1>
      <?php
      if(isset($_SESSION["msg"])){
          echo $_SESSION["msg"];
          unset($_SESSION["msg"]);
      }
      ?>
    <div class="form-floating mt-3">
      <input type="email" class="form-control" id="floatingInput" placeholder="name@example.com" name="email" required>
      <label for="floatingInput">E-mail</label>
    </div>
    <div class="form-floating">
      <input type="password" class="form-control" id="floatingPassword" placeholder="Senha" name="password" required>
      <label for="floatingPassword">Senha</label>
    </div>

    <div class="checkbox mb-3">
      <label>
        <input type="checkbox" value="remember-me"> Lembrar de mim
      </label>
    </div>
    <button class="w-100 btn btn-lg btn-primary mb-3" type="submit">Acessar</button>
      <p>OU</p>
      <a href="../register" class="w-100 btn btn-lg btn-danger">Crie sua conta</a>
    <p class="mt-5 mb-3 text-muted">&copy; Hey Cred</p>
  </form>
</main>
    <script src="../vendor/twbs/bootstrap/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>