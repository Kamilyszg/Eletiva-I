<?php
    $host = "localhost";
    $db = "imobiliaria";
    $usuario = "root";
    $senha = "";
    $port = "3306";

    try {
        $pdo = new PDO("mysql:host=$host;port=$port;dbname=$db", $usuario, $senha);
        if ($pdo) {
            echo "Conexão realizada com sucesso!";
        } else {
            echo "Erro ao conectar com o banco de dados";
        }
    } catch (Exception $e) {
        echo "Erro: " .$e->getMessage();
    }
?>