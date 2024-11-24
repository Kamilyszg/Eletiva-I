<?php 
    require_once 'cabecalho.php'; 
    require_once 'navbar.php';
    require_once '../funcoes/proprietarios.php'; 

    // Obtém o ID do proprietário a ser excluído
    $idproprietario = $_GET['idproprietario'];
    if (!$idproprietario) {
        header('Location: proprietarios.php');
        exit();
    }

    // Busca os dados do proprietário
    $proprietario = buscarProprietarioPorId($idproprietario);
    if (!$proprietario) { // Se o proprietário não for encontrado
        header('Location: proprietarios.php');
        exit();
    }

    $erro = '';

    // Verifica se o formulário foi enviado
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        try {
            $idproprietario = intval($_POST['idproprietario']);
            if (empty($idproprietario)) {
                header('Location: proprietarios.php');
                exit();
            } else {
                // Chama a função para excluir o proprietário
                if (excluirProprietario($idproprietario)) {
                    header('Location: proprietarios.php');
                    exit();
                } else {
                    $erro = "Erro ao excluir o proprietário!";
                }
            }
        } catch (Exception $e) {
            $erro = "Erro: " . $e->getMessage();
        }
    }
?>

<div class="container mt-5">
    <h2>Excluir Proprietário</h2>
    
    <p>Tem certeza de que deseja excluir o proprietário abaixo?</p>
    <ul>
        <li><strong>Nome:</strong> <?= $proprietario['nome'] ?></li>
        <li><strong>CPF:</strong> <?= $proprietario['cpf'] ?></li>
        <li><strong>CNPJ:</strong> <?= $proprietario['cnpj'] ? $proprietario['cnpj'] : 'Não informado' ?></li>
        <li><strong>Email:</strong> <?= $proprietario['email'] ?></li>
        <li><strong>Telefone:</strong> <?= $proprietario['telefone'] ?></li>
        <li><strong>Endereço:</strong> <?= $proprietario['logradouro'] ?>, <?= $proprietario['numero'] ?>, 
            <?= $proprietario['bairro'] ?>, <?= $proprietario['cidade'] ?> - <?= $proprietario['estado'] ?></li>
    </ul>

    <!-- Formulário de confirmação -->
    <form method="POST">
        <input type="hidden" name="idproprietario" value="<?= $proprietario['idproprietario'] ?>">
        <button type="submit" name="confirmar" class="btn btn-danger">Excluir</button>
        <a href="proprietarios.php" class="btn btn-secondary">Cancelar</a>
    </form>

    <!-- Mensagem de erro, caso haja -->
    <?php if ($erro): ?>
        <div class="alert alert-danger mt-3"><?= $erro ?></div>
    <?php endif; ?>
</div>

<?php require_once 'rodape.php'; ?>
