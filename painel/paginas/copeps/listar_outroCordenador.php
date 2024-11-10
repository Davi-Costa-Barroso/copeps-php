<?php
// listar_outroCordenador.php

// Verifica se os dados foram recebidos via POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Verifica se a chave 'escolhido5' está presente nos dados recebidos
    if (isset($_POST['escolhido5'])) {
        $escolhido5 = $_POST['escolhido5'];

        // Aqui você pode realizar as operações necessárias com a variável $escolhido5
        // por exemplo, você pode usá-la para consultar um banco de dados ou realizar outras ações.

        // Retorna uma resposta, por exemplo, um JSON indicando sucesso
        echo json_encode(['success' => true]);
    } else {
        // Se 'escolhido5' não estiver presente, retorna uma resposta indicando erro
        echo json_encode(['error' => 'Parâmetro "escolhido5" não foi recebido.']);
    }
} else {
    // Se a requisição não for do tipo POST, retorna uma resposta indicando erro
    echo json_encode(['error' => 'A requisição deve ser do tipo POST.']);
}
?>
