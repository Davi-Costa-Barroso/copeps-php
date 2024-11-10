<?php

$tabela = 'comissoes';
require_once("../../../conexao.php");

$nome = $_POST['nome']; // ['nome'] vem do imput name da Modal Form Usuario
$id = $_POST['id'];



//validacao do nome Cargo
$query = $pdo->query("SELECT * from $tabela where nome = '$nome'");
$res = $query->fetchAll(PDO::FETCH_ASSOC);
$id_reg = @$res[0]['id']; // trazendo id do bd

if(@count($res) > 0 and $id != $id_reg){
	echo 'Comissão já Cadastrado!';
	exit();
}




//se ele não passou nada "", faz a inserção
if($id == ""){
	$query = $pdo->prepare("INSERT INTO $tabela SET nome = :nome");
	$acao = 'inserção';

}else{
	$query = $pdo->prepare("UPDATE $tabela SET nome = :nome where id = '$id'");
	$acao = 'edição';
}

$query->bindValue(":nome", "$nome"); 
$query->execute();
$ult_id = $pdo->lastInsertId(); //"$pdo->lastInsertId()" comando p/ receber o ultimo id executado no bd


if($ult_id == "" || $ult_id == 0){
	$ult_id = $id;
}


//inserir log

$acao = $acao;
$descricao = $nome;
$id_reg = $ult_id;
require_once("../../inserir-logs.php");

echo 'Salvo com Sucesso';

?>