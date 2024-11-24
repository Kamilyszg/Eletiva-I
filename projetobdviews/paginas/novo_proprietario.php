<?php 
    require_once 'cabecalho.php'; 
    require_once 'navbar.php';
    require_once '../funcoes/imoveis.php'; 
    require_once '../funcoes/proprietarios.php'; 

    $erro = '';

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
            $telefone = isset($_POST['telefone']) ? $_POST['telefone'] : null;
            

            if (!$nome || !$cpf || !$logradouro || !$numero || !$bairro || !$cidade || !$estado || !$email || !$telefone) {
                $erro = "Informe os valores obrigatórios!";           
            } else {
                if (cadastrarProprietario($nome, $cpf, $cnpj, $logradouro, $numero, $bairro, $cidade, $estado, $email, $telefone)) {
                    header('Location: proprietarios.php');
                    exit();
                } else {
                    $erro = "Erro ao inserir imóvel!";
                }
            }
        } catch (Exception $e) {
            $erro = "Erro: " . $e->getMessage();
        }
    }
?>

<div class="container mt-5">
    <h2>Adicionar novo proprietário</h2>

    <?php if(!empty($erro)): ?>
        <p class="text-danger"><?= $erro ?></p>
    <?php endif; ?>

    <form method="POST">
        <div class="mb-3">
            <label for="nome" class="form-label">Nome</label>
            <input type="text" class="form-control" id="nome" name="nome" required>
        </div>
        <div class="mb-3">
            <label for="cpf" class="form-label">CPF</label>
            <input type="text" class="form-control" id="cpf" name="cpf" required>
        </div>
        <div class="mb-3">
            <label for="cnpj" class="form-label">CNPJ (opcional)</label>
            <input type="text" class="form-control" id="cnpj" name="cnpj">
        </div>
        <h4>Endereço</h4>
        <div class="mb-3">
            <label for="logradouro" class="form-label">Logradouro</label>
            <input type="text" class="form-control" id="logradouro" name="logradouro" required>
        </div>
        <div class="mb-3">
            <label for="numero" class="form-label">Número</label>
            <input type="number" class="form-control" id="numero" name="numero" required>
        </div>
        <div class="mb-3">
            <label for="bairro" class="form-label">Bairro</label>
            <input type="text" class="form-control" id="bairro" name="bairro" required>
        </div>
        <div class="mb-3">
            <label for="cidade" class="form-label">Cidade</label>
            <input type="text" class="form-control" id="cidade" name="cidade" required>
        </div>
        <div class="mb-3">
            <label for="estado" class="form-label">Estado</label>
            <input type="text" class="form-control" id="estado" name="estado" required>
        </div>
        <h4>Contato</h4>
        <div class="mb-3">
            <label for="email" class="form-label">Email</label>
            <input type="email" class="form-control" id="email" name="email" required>
        </div>
        <div class="mb-3">
            <label for="telefone" class="form-label">Telefone</label>
            <input type="text" class="form-control" id="telefone" name="telefone" required>
        </div>
        <button type="submit" class="btn btn-primary">Cadastrar</button>
    </form>
</div>

<?php require_once 'rodape.php'; ?>