<?php
// ... (código existente)

// Obtém o valor do POST
$escolhido6 = $_POST['escolhido6'];

// Adiciona a lógica para determinar se deve ocultar o campo comentariosParecer
$ocultarComentariosParecer = false;
if ($escolhido6 === 'ad-referendum' || $escolhido6 === 'ata-reuniao-ordinaria' || $escolhido6 === 'ata-reuniao-extraordinaria') {
    $ocultarComentariosParecer = true;
}

// Cria um array associativo para ser convertido em JSON
$response = array('ocultarComentariosParecer' => $ocultarComentariosParecer);

// Converte o array para JSON e imprime
echo json_encode($response);
?>
