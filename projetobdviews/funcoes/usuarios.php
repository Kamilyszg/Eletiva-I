<?php

declare(strict_types = 1);

require_once('../config/bancodedados.php');

function login(string $email, string $senha) {
    global $pdo;

    // Verifica se o usuário ADM já existe
    $statement = $pdo->prepare("SELECT * FROM usuario WHERE email = ?");
    $statement->execute(['adm@adm.com']);
    $usuario = $statement->fetch(PDO::FETCH_ASSOC);

    // Se o usuário ADM não existir, cria um novo
    if (!$usuario) {
        novoUsuario('Administrador', 'adm@adm.com', 'adm', 'adm');
    }

    // Verifica email e senha do usuário fornecido no login
    $statement = $pdo->prepare("SELECT * FROM usuario WHERE email = ?");
    $statement->execute([$email]);
    $usuario = $statement->fetch(PDO::FETCH_ASSOC);

    if ($usuario && password_verify($senha, $usuario['senha'])) {
        return $usuario;
    }

    return null;
}

//função para salvar um novo usuário
function novoUsuario(string $nome, string $email, string $senha, string $nivel):bool {
    global $pdo;
    $senha_criptografada = password_hash($senha, PASSWORD_BCRYPT);
    $statement = $pdo->prepare("INSERT INTO usuario (nome, email, senha, nivel) VALUES (?, ?, ?, ?)");
    return $statement->execute([$nome, $email, $senha_criptografada, $nivel]);
}

function excluirUsuario(int $id):bool{
    global $pdo;
    $statement = $pdo->prepare("DELETE FROM usuario WHERE id = ?");
    return $statement->execute([$id]);
}

function todosUsuarios():array{
    global $pdo;
    //se não passo parâmetros, ou seja, o ?, usar query e não prepare
    $statement = $pdo->query("SELECT * FROM usuario WHERE nivel <> 'adm'");
    //associa e retorna todos os usuários
    //para query usar fetchall, para prepare usar fetch
    return $statement->fetchAll(PDO::FETCH_ASSOC);
}

function usuarioPorId(int $id):?array{
    global $pdo;
    $statement = $pdo->prepare("SELECT * FROM usuario WHERE id = ? AND nivel <> 'adm'");
    $statement->execute([$id]);
    $usuario = $statement->fetch(PDO::FETCH_ASSOC);
    return $usuario ? $usuario : null;
}
?>