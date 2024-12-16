<?php
// Recebe o número de checkboxes selecionados enviado via POST
$totalSelecionados = $_POST['escolhido5'];

// Faça as operações necessárias com $totalSelecionados, se necessário

// Retorna uma resposta ao cliente em formato JSON
echo json_encode(['success' => true, 'totalSelecionados' => $totalSelecionados]);
?>