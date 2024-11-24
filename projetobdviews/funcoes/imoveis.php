<?php
    declare(strict_types=1);
    require_once '../config/bancodedados.php';

    function buscarImoveis():  array { //buscar todos os dados de imoveis juntamente com endereco e proprietario
        global $pdo;
        $stmt = $pdo->query
        (
            "SELECT 
                i.*,
                e.idendereco 
            FROM imovel i 
            LEFT JOIN proprietario p 
                ON i.idproprietario = p.idproprietario
            LEFT JOIN endereco e
                ON I.idendereco = e.idendereco"
        );
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    function buscarImoveisPorId(int $idimovel):?array {
        global $pdo;
        $stmt = $pdo->prepare
        (
            "SELECT 
                i.*, 
                e.idendereco 
            FROM imovel i 
            LEFT JOIN proprietario p 
                ON i.idproprietario = p.idproprietario
            LEFT JOIN endereco e
                ON i.idendereco = e.idendereco
            WHERE i.idimovel = ?"
        );
        $stmt->execute([$idimovel]);
        $imovel = $stmt->fetch(PDO::FETCH_ASSOC);
        return $imovel ? $imovel : null;
    }

    function buscarEnderecoPorId(int $idendereco): ?array {
        global $pdo;
        $stmt = $pdo->prepare("SELECT * FROM endereco WHERE idendereco = ?");
        $stmt->execute([$idendereco]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    function criarImovel(string $tipo, float $valor, string $status, string $logradouro, int $numero, string $bairro, string $cidade, string $estado, int $idproprietario, string $descricao): bool 
    {
        global $pdo;

        $pdo->beginTransaction();

        try{
        // inserção na tabela 'endereço'
            $stmt = $pdo->prepare(
                "INSERT INTO endereco (logradouro, numero, bairro, cidade, estado) 
                    VALUES (?, ?, ?, ?, ?)"
            );
            $stmt->execute([$logradouro, $numero, $bairro, $cidade, $estado]);
            
        //método que extrai do bd o id recém criado
        $idendereco = $pdo->lastInsertId();

        // Inserção na tabela 'imovel', com dataCadastro automática 
        $stmt = $pdo->prepare(
            "INSERT INTO imovel (tipo, valor, status, dataCadastro, idendereco, idproprietario, descricao)
            VALUES (?, ?, ?, NOW(), ?, ?, ?)"
        );

        $stmt->execute([$tipo, $valor, $status, $idendereco, $idproprietario, $descricao]);

        $pdo->commit();
        return true;

        }catch (Exception $e){
            $pdo->rollBack();
            return false;
        }
    }

    function alterarImovel(int $idimovel, string $tipo, float $valor, string $status, string $logradouro, int $numero, string $bairro, string $cidade, string $estado, ?int $idproprietario = null, string $descricao): bool {
        global $pdo;
    
        $pdo->beginTransaction(); 
    
        try {
            // Atualizando na tabela imóvel
            $stmt = $pdo->prepare("UPDATE imovel SET tipo = ?, valor = ?, status = ?, descricao = ? WHERE idimovel = ?");
            $stmt->execute([$tipo, $valor, $status, $descricao, $idimovel]);
    
            // Obtendo o id do endereço relacionado ao imóvel
            $stmt = $pdo->prepare("SELECT idendereco FROM imovel WHERE idimovel = ?");
            $stmt->execute([$idimovel]);
            $idendereco = $stmt->fetchColumn();
    
            // Atualizando na tabela endereco
            $stmt = $pdo->prepare("UPDATE endereco SET logradouro = ?, numero = ?, bairro = ?, cidade = ?, estado = ? WHERE idendereco = ?");
            $stmt->execute([$logradouro, $numero, $bairro, $cidade, $estado, $idendereco]);
    
            $pdo->commit();
            return true;
    
        } catch (Exception $e) {
            $pdo->rollBack();
            return false;
        }
    }
 
    function excluirImovel(int $idimovel): bool {
        global $pdo;
    
        try {
            $pdo->beginTransaction();
    
            $stmt = $pdo->prepare("DELETE FROM imovel WHERE idimovel = ?");
            $stmt->execute([$idimovel]);
            $pdo->commit();
            return true;
        } catch (Exception $e) {
            $pdo->rollBack();
            return false;
        }
    }

    /*
function gerarDadosGrafico(): array {
global $pdo;
$stmt = $pdo->query(
"SELECT
p.id,
p.nome,
SUM(c.quantidade) AS estoque
FROM compra c 
INNER JOIN produto p
ON p.id = produto_id
GROUP BY p.id");
return $stmt->fetchAll(PDO::FETCH_ASSOC);
}
?>
*/