<?php
session_start();

if (isset($_SESSION['user_id'])) {
    header("Location: index2.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
<meta charset="UTF-8">
<title>Login</title>

<link rel="stylesheet"
href="https://cdn.jsdelivr.net/npm/bootstrap@3.4.1/dist/css/bootstrap.min.css">

<style>
body{
    background:#e4fccb;
}

.login-box{
    width:400px;
    margin:100px auto;
    background:white;
    padding:30px;
    border-radius:10px;
    box-shadow:0 0 10px rgba(0,0,0,.2);
}
</style>

</head>
<body>

<div class="login-box">

    <h3>Login</h3>

    <form action="validar_login.php" method="POST">

        <div class="form-group">
            <label>Usuário</label>
            <input type="text"
                   name="user_name"
                   class="form-control"
                   required>
        </div>

        <div class="form-group">
            <label>Senha</label>
            <input type="password"
                   name="senha"
                   class="form-control"
                   required>
        </div>

        <button type="submit" class="btn btn-primary">
            Entrar
        </button>

    </form>

</div>

</body>
</html>