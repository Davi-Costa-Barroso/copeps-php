<?php
// Recebe o número de checkboxes selecionados enviado via POST
$totalSelecionados2 = $_POST['escolhido4'];

// Faça as operações necessárias com $totalSelecionados2, se necessário

// Retorna uma resposta ao cliente em formato JSON
echo json_encode(['success' => true, 'totalSelecionados2' => $totalSelecionados2]);
?>
