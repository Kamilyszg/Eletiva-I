<?php 
    require_once 'cabecalho.php'; 
    require_once 'navbar.php';
    require_once '../funcoes/imoveis';
    require_once '../funcoes/proprietarios';
    $erro = '';

    $proprietarios = buscarProprietarios();

    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        try {
            $tipo = intval($_POST['tipo']);
            $valor = floatval($_POST['valor']);
            $logradouro = $_POST['logradouro'];
            $numero = intval($_POST['numero']);
            $bairro = $_POST['bairro'];
            $cidade = $_POST['cidade'];
            $estado = $_POST['estado'];
            $status = $_POST['status'];
            $proprietario = $_POST['proprietario'];
            $descricao = $_POST['descricao'];

            if (empty($tipo) || empty($valor) || empty($logradouro) || empty($numero) || empty($bairro) || empty($cidade) ||
            empty($estado) || empty($status) || empty($proprietario) || empty($descricao)) {
                $erro = "Informe os valores obrigatórios!";
            } else {
                if (criarImovel($tipo, $valor, $status, $logradouro, $numero, $bairro, $cidade, $estado, $proprietario, $descricao)) {
                    header('Location: imoveis.php');
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
    <h2>Adicionar novo imóvel</h2>

    <?php if(!empty($erro)): ?>
        <p class="text-danger"><?= $erro ?></p>
    <?php endif; ?>

    <form method="post">
        <div class="mb-3">
            <label for="tipo" class="form-label">Tipo do Imóvel</label>
            <select class="form-select" name="tipo" id="tipo" required>
                <option value="" disabled selected> </option>
                <option value="Casa">Casa</option>
                <option value="Apartamento">Apartamento</option>
                <option value="Comercial">Comercial</option>
            </select>
        </div>

        <div class="mb-3">
            <label for="valor" class="form-label">Valor</label>
            <input type="number" name="valor" id="valor" class="form-control" step="0.01" required>
        </div>

        <h4>Endereço</h4>
        <div class="mb-3">
            <label for="logradouro" class="form-label">Logradouro</label>
            <input type="text" name="logradouro" id="logradouro" class="form-control" required>
        </div>

        <div class="mb-3">
            <label for="numero" class="form-label">Número</label>
            <input type="number" name="numero" id="numero" class="form-control" required>
        </div>

        <div class="mb-3">
            <label for="bairro" class="form-label">Bairro</label>
            <input type="text" name="bairro" id="bairro" class="form-control" required>
        </div>

        <div class="mb-3">
            <label for="cidade" class="form-label">Cidade</label>
            <input type="text" name="cidade" id="cidade" class="form-control" required>
        </div>

        <div class="mb-3">
            <label for="estado" class="form-label">Estado</label>
            <input type="text" name="estado" id="estado" class="form-control" required>
        </div>
        
        <div class="mb-3">
            <label for="status" class="form-label">Status</label>
            <select class="form-select" name="status" id="status" required>
                <option value="" disabled selected> </option>
                <option value="Disponível">Disponível</option>
                <option value="Indisponível">Indisponível</option>
            </select>
        </div>
        
        <div class="mb-3">
            <label for="proprietario" class="form-label">Proprietario</label>
            <p>*Atenção, é necessário realizar o cadastro do proprietário préviamente</p>
            <select class="form-select" name="proprietario" id="proprietario" required>
                <option value="" disabled selected>Selecione o proprietário</option>
                <?php foreach($proprietarios as $p): ?>
                    <option value="<?= $p['idproprietario'] ?>"><?= $p['nome'] ?></option>
                <?php endforeach; ?>
            </select>
        </div>
            
        <div class="mb-3">
            <label for="descricao" class="form-label">Descrição</label>
            <textarea name="descricao" id="descricao" class="form-control" required></textarea>
        </div>

        <button type="submit" class="btn btn-primary">Criar Imóvel</button>
    </form>
</div>

<?php require_once 'rodape.php'; ?>
