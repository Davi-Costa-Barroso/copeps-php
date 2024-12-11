<?php
require_once("../../../conexao.php");

try {
    $query = $pdo->query("SELECT tipo_membro, nome, cargo FROM membros WHERE comissao = 1 ORDER BY nome ASC");
    $result = $query->fetchAll(PDO::FETCH_ASSOC);

   
    echo json_encode($result);
} catch (Exception $e) {
    echo json_encode(['error' => $e->getMessage()]);
}
?>
