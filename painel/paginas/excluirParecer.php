<?php
@session_start(); 
$tabela = 'pareceres';
require_once("../../conexao.php");

$id = $_POST['id'];

if(($_SESSION['nivel'] != 'Administrador') || ($_SESSION['nivel'] != 'Administrador')) {
	echo 'Somente um Administrador ou Docente pode excluir um membro';
	exit();
}

$pdo->query("DELETE FROM $tabela WHERE id = '$id' ");
echo 'Excluído com Sucesso';


?>