<?php 
$tabela = 'usuarios';
require_once("../../../conexao.php");

$id = $_POST['id'];
$acao = $_POST['acao'];
$nome = $_POST['nome'];

$pdo->query("UPDATE $tabela SET ativo = '$acao' WHERE id = '$id' ");

echo 'Alterado com Sucesso';


//inserir log
$acao = 'edição';
$descricao = $nome;
$id_reg = $id;
require_once("../../inserir-logs.php");
?>