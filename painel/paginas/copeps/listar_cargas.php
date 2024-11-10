<?php
require_once("../../../conexao.php");

if (isset($_POST['escolhido2'])) {
    // Obtém o valor do input radio selecionado
    $valor = $_POST['escolhido2'];

    // Adicione mensagens de log para depuração
    error_log("Valor recebido do frontend: " . $valor);

    // Define os valores do select como um array
    $opcoes = [];

    // Lógica para determinar as opções com base no valor do input radio
    switch ($valor) {
        case "simc":
            $opcoes = [
                "5 (Cinco) horas",
                "10 (Dez) horas",
                "15 (Quinze) horas",
                "20 (Vinte) horas"
            ];
            break;
        case "naoc":
            $opcoes = [
                ""
                
            ];
            break;
        default:
            // Retorna um array vazio se nenhum valor corresponder
            $opcoes = [];
            break;
    }

     // Adicione mensagens de log para depuração
    error_log("Opções enviadas para o frontend: " . json_encode($opcoes));

    echo json_encode($opcoes);
} else {
    // Adicione uma mensagem de erro se os dados não forem recebidos corretamente
    error_log("Erro: Dados não recebidos corretamente.");
}
?>
