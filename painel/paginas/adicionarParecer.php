<?php

$tabela = 'pareceres';
require_once("../../conexao.php");

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $dados = [
        'id' => $_POST['id'],
        // dados iniciais
        'numeroParecer' => $_POST['numeroParecer'],
        'ano' => $_POST['anoParecer'],
        'numeroOficio' => $_POST['numeroOficio'],
        'itemOficio' => $_POST['itemOficio'],
        'dataEnvio' => $_POST['dataEnvio_nao_formatada'],
        'textoAnalise' => $_POST['textoAnalisado'],
        'tituloProjeto' => $_POST['tituloProjetoAnalisado'],
        'documEnviados' => $_POST['documentosEnviados'],
        // dados documentos
        'TIPODOCUMENTO' => $_POST['TIPODOCUMENTO'],
        'nomeRelatorio' => $_POST['nomeRelatorio'],
        'periodoProjeto' => $_POST['periodoProjeto'],
        'cargaHoraria' => $_POST['cargaHoraria'],
        // dados coordenador
        'nomeCoordenador' => $_POST['nomeCoordenador'],
        'sexoCoordenador' => $_POST['sexoCoordenador'],
        'titulacaoCoordenador' => $_POST['titulacaoCoordenador'],
        'faculdadeCoordenador' => $_POST['faculdadeCoordenador'],
        'possuiOutroCoordenador' => $_POST['possuiOutroCoordenador'],
        'nomeViceCoordenador' => $_POST['nomeViceCoordenador'],
        'sexoViceCoordenador' => $_POST['sexoViceCoordenador'],
        'titulacaoViceCoordenador' => $_POST['titulacaoViceCoordenador'],
        // dados relator
        'nomeRelator' => $_POST['nomeRelator'],
        'sexoRelator' => $_POST['sexoRelator'],
        'descricaoProposta' => $_POST['descricaoProposta'],
        'aprovacaoFaculdade' => $_POST['aprovacaoFaculdade'],
        'dataAprovacao' => $_POST['dataAprovacao'],
        'numeroDocumento' => $_POST['numeroDoc'],
        'numeroDocumento' => $_POST['numeroDoc'],
        'justificativa' => $_POST['justificativa'], // campo $obs5
        'comentariosParecer' => $_POST['comentariosParecer'], // campo $obs6
        'parecerRelator' => $_POST['situacaoRelatorio'],
    ];
    
    $campos = array_keys($dados);
    $valores = array_values($dados);
    $placeholders = array_map(fn($campo) => ":$campo", $campos);

    // Se o ID estiver vazio, então faz a inserção
    if (empty($dados['id'])) {
        $query = "INSERT INTO $tabela (" . implode(", ", $campos) . ") VALUES (" . implode(", ", $placeholders) . ")";
        $acao = 'inserção';
    } else {
        $set = implode(", ", array_map(fn($campo) => "$campo = :$campo", $campos));
        $query = "UPDATE $tabela SET $set WHERE id = :id";
        $acao = 'atualização';
    }

    $stmt = $pdo->prepare($query);
    foreach ($dados as $chave => $valor) {
        $stmt->bindValue(":$chave", $valor);
    }

    $stmt->execute();
    $ult_id = $pdo->lastInsertId(); // "$pdo->lastInsertId()" comando para receber o último ID executado no BD
    
    $ult_id = $pdo->lastInsertId() ?: $dados['id'];

    // Inserir log    
    $descricao = "Número do parecer: {$dados['numeroParecer']}, Ano: {$dados['ano']}, Número do ofício: {$dados['numeroOficio']}";
    $id_reg = $ult_id;
    require_once("../inserir-logs.php");

    echo json_encode([
        'status' => 'success',
        'message' => 'Salvo com sucesso',
        'id' => $ult_id
    ]);
}

?>