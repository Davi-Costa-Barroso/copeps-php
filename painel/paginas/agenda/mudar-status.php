<?php 
$tabela = 'tarefas';
require_once("../../../conexao.php");

$id = $_POST['id'];
$acao = $_POST['acao'];
$nome = $_POST['nome'];

$pdo->query("UPDATE $tabela SET status = '$acao' where id = '$id'");


//inserir log
$acao = $acao;
$descricao = $nome;
$id_reg = $id;
require_once("../../inserir-logs.php");

echo 'Alterado com Sucesso';


?>