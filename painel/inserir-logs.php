<?php 
@session_start();

$id_usuario = $_SESSION['id'];

if(@$id_reg == ""){
	$id_reg = 0;
}

if($id_usuario != ""){
	if($logs == 'Sim'){
		$query = $pdo->query("INSERT INTO logs SET data = curDate(), hora = curTime(), tabela = '$tabela', acao = '$acao', usuario = '$id_usuario', id_reg = '$id_reg', descricao = '$descricao'");
	}
}
 
 

?>