<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <?php
        $valor = (int) $_POST['valor'];
        $valor = (float) $_POST['valor'];
        $valor = (string) $_POST['valor'];
        //$valor = (bool) $_POST['valor'];
        echo 'Valor informado: '.$valor; #o "." é o operador de concatenação
        #echo "Valor informado: $valor";
    ?>
</body>
</html>