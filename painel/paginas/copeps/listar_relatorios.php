<?php
require_once("../../../conexao.php");

if (isset($_POST['escolhido'])) {
    // Obtém o valor do input radio selecionado
    $valor = $_POST['escolhido'];

    // Define os valores dos selects como arrays
    $select1 = [
        // "Projeto de Ensino",
        "Projeto de Pesquisa",
        "Projeto de Extensão",
        "Alocação de Carga horária",
        "Projeto Pedagógico Curso de Pós-Graduação Lato Sensu"
    ];

    // Define o conjunto de opções para $select2 com base no valor selecionado
    if ($valor === "Alocação de Carga horária") {
        $select2 = [
            "Projeto de Ensino",
            "Projeto de Pesquisa",
            "Projeto de Extensão"
        ];
    } else {
        $select2 = [
            "Relatório Parcial de Projeto de Ensino",
            "Relatório Parcial de Projeto de Pesquisa",
            "Relatório Parcial de Projeto de Extensão"
        ];
    }

    // Define o conjunto de opções para $select3 com base no valor selecionado
    if ($valor === "projeto-de-ensino") {
        $select3 = [
            "Opção 1",
            "Opção 2",
            "Opção 3"
        ];
    } else {
        // Se o valor não corresponder a "projeto-de-ensino", defina um conjunto padrão
        $select3 = [
            "Relatório Final de Projeto de Ensino",
            "Relatório Final de Projeto de Pesquisa",
            "Relatório Final de Projeto de Extensão"
        ];
    }

    // Define o valor do select apropriado para o valor do input radio selecionado
    switch ($valor) {
        case "nao":
            echo json_encode($select1);
            break;
        case "parcial":
            echo json_encode($select2);
            break;
        case "final":
            echo json_encode($select3);
            break;
        default:
            echo json_encode([]); // Retorna um array vazio se nenhum valor corresponder
            break;
    }
}
?>
