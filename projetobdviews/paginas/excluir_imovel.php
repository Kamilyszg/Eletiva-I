<?php 
    require_once 'cabecalho.php'; 
    require_once 'navbar.php';
    require_once '../funcoes/imoveis.php'; 

    $idimovel = $_GET['idimovel'];
    if (!$idimovel) {
        header('Location: imoveis.php');
        exit();
    }

    $imovel = buscarImoveisPorId($idimovel);
    if (!$imovel) { // Se o imóvel não for encontrado
        header('Location: imoveis.php');
        exit();
    }

    $erro = '';

    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        try {
            $idimovel = intval($_POST['idimovel']);
            if (empty($idimovel)) {
                header('Location: imoveis.php');
                exit();
            } else {
                if (excluirImovel($idimovel)) {
                    header('Location: imoveis.php');
                    exit();
                } else {
                    $erro = "Erro ao excluir o imóvel!";
                }
            }
        } catch (Exception $e) {
            $erro = "Erro: " . $e->getMessage();
        }
    }
?>

<div class="container mt-5">
    <h2>Excluir Imóvel</h2>
    
    <p>Tem certeza de que deseja excluir o imóvel abaixo?</p>
    <ul>
        <li><strong>Tipo:</strong> <?= $imovel['tipo'] ?></li>
        <li><strong>Valor:</strong> <?= $imovel['valor'] ?></li>
        <li><strong>Endereço:</strong> <?= $imovel['logradouro'] ?>, <?= $imovel['numero'] ?>, 
            <?= $imovel['bairro'] ?>, <?= $imovel['cidade'] ?> - <?= $imovel['estado'] ?></li>
        <li><strong>Status:</strong> <?= $imovel['status'] ?></li>
        <li><strong>Descrição:</strong> <?= $imovel['descricao'] ?></li>
    </ul>

    <form method="POST">
        <input type="hidden" name="idimovel" value="<?= $imovel['idimovel'] ?>">
        <button type="submit" name="confirmar" class="btn btn-danger">Excluir</button>
        <a href="imoveis.php" class="btn btn-secondary">Cancelar</a>
    </form>
</div>

<?php require_once 'rodape.php'; ?>

