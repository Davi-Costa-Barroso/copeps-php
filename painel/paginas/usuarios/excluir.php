<?php 
@session_start(); 
$tabela = 'usuarios';
require_once("../../../conexao.php"); 

$id = $_POST['id'];

if(($_SESSION['nivel'] != 'Administrador') && ($_SESSION['nivel'] != 'Docente')) {	
	echo 'Somente um Administrador ou Docente pode excluir um membro';
	exit();
}

//Excluindo foto do usuario
$query = $pdo->query("SELECT * FROM $tabela where id = '$id'");
$res = $query->fetchAll(PDO::FETCH_ASSOC);
$foto = $res[0]['foto'];

if($foto != "sem-foto.jpg"){
	@unlink('../../images/perfil/'.$foto); //removendo a foto
}

//Excluindo o usuario
$pdo->query("DELETE FROM $tabela WHERE id = '$id' ");
$pdo->query("DELETE FROM membros where id_pessoa = '$id'");
echo 'Excluído com Sucesso';
?>