<?php
// Recebe o tipo de horas enviado via POST
$horas = $_POST['horas'];

// Faça as operações necessárias para reiniciar o contador, se necessário

// Retorna uma resposta ao cliente em formato JSON
echo json_encode(['success' => true]);
?>
