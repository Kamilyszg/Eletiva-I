<?php
    declare(strict_types=1);
    require_once '../config/bancodedados.php';

    function buscarProprietarios(): array {
        global $pdo;
        $stmt = $pdo->query("SELECT idproprietario, nome FROM proprietario");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    function CadastrarProprietario(string $nome, string $cpf, ?string $cnpj, string $logradouro, int $numero, string $bairro, string $cidade, string $estado, string $email, string $telefone): bool {
        global $pdo;

        $pdo->beginTransaction();

        try {
            // Verificar se o endereço já existe
            $stmt = $pdo->prepare("SELECT idendereco FROM endereco WHERE logradouro = ? AND numero = ? AND bairro = ? AND cidade = ? AND estado = ?");
            $stmt->execute([$logradouro, $numero, $bairro, $cidade, $estado]);
            $idendereco = $stmt->fetchColumn();

            // Se não encontrar o endereço, insira um novo
            if (!$idendereco) {
                $stmt = $pdo->prepare(
                    "INSERT INTO endereco (logradouro, numero, bairro, cidade, estado) 
                    VALUES (?, ?, ?, ?, ?)"
                );
                $stmt->execute([$logradouro, $numero, $bairro, $cidade, $estado]);
                $idendereco = $pdo->lastInsertId(); // Obter o id do endereço recém inserido
            }

            // Inserir o proprietário com o id do endereço
            $stmt = $pdo->prepare("INSERT INTO proprietario (nome, cpf, cnpj, idendereco, email, telefone) 
                                VALUES (?, ?, ?, ?, ?, ?)");
            $stmt->execute([$nome, $cpf, $cnpj, $idendereco, $email, $telefone]);

            // Confirmar a transação
            $pdo->commit();
            return true;

            }catch (Exception $e){
                $pdo->rollBack();
                return false;
            }
    }

    function buscarProprietarioPorId(int $idproprietario): ?array {
        global $pdo;
    
        $stmt = $pdo->prepare(
            "SELECT 
                p.*, 
                e.idendereco 
            FROM proprietario p
            LEFT JOIN endereco e ON p.idendereco = e.idendereco
            WHERE p.idproprietario = ?"
        );
        $stmt->execute([$idproprietario]);
    
        $proprietario = $stmt->fetch(PDO::FETCH_ASSOC);
        return $proprietario ? $proprietario : null;
    }

    function alterarProprietario(int $idproprietario, string $nome, string $cpf, ?string $cnpj, string $email, string $telefone, string $logradouro, int $numero, string $bairro, string $cidade, string $estado): bool {
        global $pdo;
    
        $pdo->beginTransaction();
    
        try {
            /// Se o CNPJ não for informado, define como NULL
            $cnpj = empty($cnpj) ? null : $cnpj;

            // Atualizando na tabela proprietário
            $stmt = $pdo->prepare("UPDATE proprietario SET nome = ?, cpf = ?, cnpj = ?, email = ?, telefone = ? WHERE idproprietario = ?");
            $stmt->execute([$nome, $cpf, $cnpj, $email, $telefone, $idproprietario]);
    
            // Obtendo o id do endereço relacionado ao proprietário
            $stmt = $pdo->prepare("SELECT idendereco FROM proprietario WHERE idproprietario = ?");
            $stmt->execute([$idproprietario]);
            $idendereco = $stmt->fetchColumn();
    
            // Atualizando na tabela endereço
            $stmt = $pdo->prepare("UPDATE endereco SET logradouro = ?, numero = ?, bairro = ?, cidade = ?, estado = ? WHERE idendereco = ?");
            $stmt->execute([$logradouro, $numero, $bairro, $cidade, $estado, $idendereco]);
    
            // Commit da transação
            $pdo->commit();
            return true;
    
        } catch (Exception $e) {
            // Rollback em caso de erro
            $pdo->rollBack();
            return false;
        }
    }

    function excluirProprietario(int $idproprietario): bool {
        global $pdo;
    
        try{
            $pdo->beginTransaction();
    
            $stmt = $pdo->prepare("DELETE FROM proprietario WHERE idproprietario = ?");
            $stmt->execute([$idproprietario]);
            $pdo->commit();
            return true;

        } catch (Exception $e) {
            $pdo->rollBack();
            return false;
        }
    }
?>