<?php 
    require_once 'cabecalho.php'; 
    require_once 'navbar.php';
    require_once '../funcoes/imoveis.php'; 
    require_once '../funcoes/proprietarios.php'; 

    $erro = '';

    // fazer o get 
    
    $proprietario = buscarProprietarioPorId($idproprietario); 
    if (!$proprietario) {
        header('Location: proprietarios.php');
        exit();
    }

    $endereco = buscarEnderecoPorId($proprietario['idendereco']); // A função que busca o endereço do proprietário, caso seja necessário

    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        try {
            $nome = $_POST['nome'];
            $cpf = $_POST['cpf'];
            $cnpj = $_POST['cnpj'] ?? null;
            $logradouro = $_POST['logradouro'];
            $numero = intval($_POST['numero']);
            $bairro = $_POST['bairro'];
            $cidade = $_POST['cidade'];
            $estado = $_POST['estado'];
            $email = $_POST['email'];
            $telefone = $_POST['telefone1'];

            if (empty($nome) || empty($cpf) || empty($logradouro) || empty($numero) || empty($bairro) || empty($cidade) || empty($estado) || empty($email) || empty($telefone)) {
                $erro = "Informe os valores obrigatórios!";
            } else {
                // Atualizar os dados do proprietário
                if (alterarProprietario($idproprietario, $nome, $cpf, $cnpj, $logradouro, $numero, $bairro, $cidade, $estado, $email, $telefone)) {
                    header('Location: proprietarios.php');
                    exit();
                } else {
                    $erro = "Erro ao atualizar proprietário!";
                }
            }
        } catch (Exception $e) {
            $erro = "Erro: " . $e->getMessage();
        }
    }
?>

<div class="container mt-5">
    <h2>Editar Proprietário</h2>

    <?php if (!empty($erro)): ?>
        <p class="text-danger"><?= $erro ?></p>
    <?php endif; ?>

    <form method="POST">
        <input type="hidden" name="idproprietario" value="<?= $proprietario['idproprietario'] ?>">

        <div class="mb-3">
            <label for="nome" class="form-label">Nome</label>
            <input type="text" class="form-control" id="nome" name="nome" value="<?= $proprietario['nome'] ?>" required>
        </div>

        <div class="mb-3">
            <label for="cpf" class="form-label">CPF</label>
            <input type="text" class="form-control" id="cpf" name="cpf" value="<?= $proprietario['cpf'] ?>" required>
        </div>

        <div class="mb-3">
            <label for="cnpj" class="form-label">CNPJ (opcional)</label>
            <input type="text" class="form-control" id="cnpj" name="cnpj" value="<?= $proprietario['cnpj'] ?>">
        </div>

        <h4>Endereço</h4>
        <div class="mb-3">
            <label for="logradouro" class="form-label">Logradouro</label>
            <input type="text" class="form-control" id="logradouro" name="logradouro" value="<?= $endereco['logradouro'] ?>" required>
        </div>

        <div class="mb-3">
            <label for="numero" class="form-label">Número</label>
            <input type="number" class="form-control" id="numero" name="numero" value="<?= $endereco['numero'] ?>" required>
        </div>

        <div class="mb-3">
            <label for="bairro" class="form-label">Bairro</label>
            <input type="text" class="form-control" id="bairro" name="bairro" value="<?= $endereco['bairro'] ?>" required>
        </div>

        <div class="mb-3">
            <label for="cidade" class="form-label">Cidade</label>
            <input type="text" class="form-control" id="cidade" name="cidade" value="<?= $endereco['cidade'] ?>" required>
        </div>

        <div class="mb-3">
            <label for="estado" class="form-label">Estado</label>
            <input type="text" class="form-control" id="estado" name="estado" value="<?= $endereco['estado'] ?>" required>
        </div>

        <h4>Contato</h4>
        <div class="mb-3">
            <label for="email" class="form-label">Email</label>
            <input type="email" class="form-control" id="email" name="email" value="<?= $proprietario['email'] ?>" required>
        </div>

        <div class="mb-3">
            <label for="telefone1" class="form-label">Telefone</label>
            <input type="text" class="form-control" id="telefone1" name="telefone1" value="<?= $proprietario['telefone1'] ?>" required>
        </div>

        <button type="submit" class="btn btn-primary">Atualizar Proprietário</button>
    </form>
</div>

<?php require_once 'rodape.php'; ?>