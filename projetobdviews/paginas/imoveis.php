<?php 
    require_once 'cabecalho.php'; 
    require_once 'navbar.php';    
    require_once '../funcoes/imoveis.php';  

    $imoveis = buscarImoveis(); // Função para buscar todos os imóveis

?>

<div class="container mt-5">
    <h2>Gerenciamento de Imóveis</h2>
    <a href="novo_imovel.php" class="btn btn-success mb-3">Novo Imóvel</a>
    <table class="table table-hover table-striped">
        <thead>
            <tr>
                <th>ID</th>
                <th>Tipo</th>
                <th>Valor</th>
                <th>Endereço</th>
                <th>Status</th>
                <th>Ações</th>
            </tr>
        </thead>
        <tbody>
            
        <?php foreach ($imoveis as $i): 
            $endereco = buscarEnderecoPorId($i['idendereco']); //Por meio da função buscarei o endereço para que possa ser exibido
            ?>
            <tr>
                <td><?= $i['idimovel'] ?></td>
                <td><?= $i['tipo'] ?></td>
                <td><?= number_format($i['valor'], 2, ',', '.') ?></td>
                <td>
                    <?= $endereco['logradouro'] ?>, <?= $endereco['numero'] ?>, 
                    <?= $endereco['bairro'] ?>, <?= $endereco['cidade'] ?> - <?= $endereco['estado'] ?>
                </td>
                <td><?= $i['status'] ?></td>
                <td>
                    <a href="editar_imovel.php?idimovel=<?= $i['idimovel'] ?>" class="btn btn-warning">Editar</a>
                    <a href="excluir_imovel.php?idimovel=<?= $i['idimovel'] ?>" class="btn btn-danger">Excluir</a>
                </td>
            </tr>
            <?php endforeach; ?>           
        </tbody>
    </table>
</div>

<?php require_once 'rodape.php'; ?>
