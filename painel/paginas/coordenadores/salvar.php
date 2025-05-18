<?php

$tabela = 'corpo_docentes'; 
require_once("../../../conexao.php");

$id = $_POST['id'];
$nome = $_POST['nome']; // ['nome'] vem do imput name da Modal Form Coordenadores
$email = $_POST['email'];
$curso = $_POST['curso'];
$situacao = $_POST['situacao']; 



//validacao email
$query = $pdo->query("SELECT * from $tabela where email = '$email'");
$res = $query->fetchAll(PDO::FETCH_ASSOC);
$id_reg = @$res[0]['id']; // trazendo id do bd

if(@count($res) > 0 and $id != $id_reg){
	echo 'Email já Cadastrado!';
	exit();
}


//validacao do nome Coordenador
$query = $pdo->query("SELECT * from $tabela where nome = '$nome'");
$res = $query->fetchAll(PDO::FETCH_ASSOC);
$id_reg = @$res[0]['id']; // trazendo id do bd

if(@count($res) > 0 and $id != $id_reg){
	echo 'Coordenador já Cadastrado!';
	exit();
}




//se ele não passou nada "", faz a inserção
if($id == ""){
	$query = $pdo->prepare("INSERT INTO $tabela SET nome = :nome, email = :email, curso = :curso, situacao = :situacao");
	$acao = 'inserção';

}else{
	$query = $pdo->prepare("UPDATE $tabela SET nome = :nome, email = :email, curso = :curso, situacao = :situacao where id = '$id'");
	$acao = 'edição';
}

$query->bindValue(":nome", "$nome");
$query->bindValue(":email", "$email");
$query->bindValue(":curso", "$curso");
$query->bindValue(":situacao", "$situacao"); 
$query->execute();
$ult_id = $pdo->lastInsertId(); // comando p/ receber o ultimo id executado no bd


//pega o ultimo id que está fazendo a edição
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