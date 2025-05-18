<?php 
@session_start();
require_once("../conexao.php"); 

//inserir log
	$tabela = 'usuarios';
	$acao = 'logout';
	$descricao = 'logout';
	require_once("inserir-logs.php");

@session_destroy();
echo '<script>window.alert("Sessão Encerrada!")</script>';
echo '<script>window.location="../index.php"</script>'; //redirecionamento via JS p/a o index.php tela de login.

 ?>