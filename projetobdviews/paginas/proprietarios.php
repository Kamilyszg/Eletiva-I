<?php 
    require_once 'cabecalho.php'; 
    require_once 'navbar.php';
    require_once '../funcoes/imoveis.php';    
    require_once '../funcoes/proprietarios.php';
    // puxar endereco   

    $proprietarios = buscarProprietarios(); // Função para buscar todos os proprietários
?>

<div class="container mt-5">
    <h2>Gerenciamento de Proprietários</h2>
    <a href="novo_proprietario.php" class="btn btn-success mb-3">Novo Proprietário</a>
    <table class="table table-hover table-striped">
        <thead>
            <tr>
                <th>ID</th>
                <th>Nome</th>
                <th>CPF/CNPJ</th> <!--mudar-->
                <th>Endereço</th>
                <th>Email</th>
                <th>Telefone</th>
                <th>Ações</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($proprietarios as $p): 
                // Verifique se o idendereco existe antes de buscar o endereço
                $endereco = null;
                if ($p['idendereco']) {
                    $endereco = buscarEnderecoPorId($p['idendereco']);
                }
            ?>
            <tr>
                <td><?= $p['idproprietario'] ?></td>
                <td><?= $p['nome'] ?></td>
                <td><?= $p['cnpj'] ?: $p['cpf'] ?></td>
                <td>
                    <?php if ($endereco): ?>
                        <?= $endereco['logradouro'] ?>, <?= $endereco['numero'] ?>, 
                        <?= $endereco['bairro'] ?>, <?= $endereco['cidade'] ?> - <?= $endereco['estado'] ?>
                    <?php else: ?>
                        Endereço não encontrado
                    <?php endif; ?>
                </td>
                <td><?= $p['email'] ?></td>
                <td><?= $p['telefone'] ?></td>
                <td>
                    <a href="editar_proprietario.php?idproprietario=<?= $p['idproprietario'] ?>" class="btn btn-warning">Editar</a>
                    <a href="excluir_proprietario.php?idproprietario=<?= $p['idproprietario'] ?>" class="btn btn-danger">Excluir</a>
                </td>
            </tr>
            <?php endforeach; ?>           
        </tbody>
    </table>
</div>

<?php require_once 'rodape.php'; ?>
