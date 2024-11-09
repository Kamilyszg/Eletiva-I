<?php 
    require_once('../funcoes/usuarios.php');

    session_start(); #servidor armazena variavel que vou guardar
    if ($_SERVER['REQUEST_METHOD'] == "POST") {
        try {
            $email = $_POST['email'] ?? "";
            $senha = $_POST['senha'] ?? "";
            if ($email != "" && $senha != "") {
                $usuario = login($email, $senha);
                if ($usuario) {
                    $_SESSION['usuario'] = $usuario['nome'];
                    $_SESSION['nivel'] = $usuario['nivel'];
                    $_SESSION['acesso'] = true;
                    header("Location: dashboard.php");
                } else {
                    $erro = "Credenciais inválidas!";
                }
            }
        } catch (Exception $e) {
            echo "Erro: " . $e->getMessage();
        }
    }

    require_once 'cabecalho.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <style type="text/css">
        #tamanhoContainer{
            width: 500px;
        }
    </style>
</head>
<body>
<div class="container" id="tamanhoContainer" style="margin-top:40px">
    <h2>Login</h2>
    <form method="post">
        <div class="mb-3">
            <label for="email" class="form-label">Email</label>
            <input type="email" name="email" class="form-control" id="email" required>
        </div>
        <div class="mb-3">
            <label for="senha" class="form-label">Senha</label>
            <input type="password" name="senha" class="form-control" id="senha" required>
        </div>
        <button type="submit" class="btn btn-primary">Entrar</button>
    </form>
    <?php
        if (isset($erro)) {
            echo "<p class='text-danger'>$erro</p>";
        }
    ?>
</div>

<?php require_once 'rodape.php'; ?>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>
</html>

