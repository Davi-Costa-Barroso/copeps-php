<?php  
$tabela = 'cargos';
require_once("../../../conexao.php");

$id = $_POST['id'];
//@$nome = $_POST['nome'];  

//fiz esse comando pra pegar o $nome pra usar no logs
$query3 = $pdo->query("SELECT * from cargos where id = '$id' ");
$res3 = $query3->fetchAll(PDO::FETCH_ASSOC);
$nome = $res3[0]['nome']; 
 
 //saber se tem algum membro se tem um cargo igual ao id que esta tentando deletar
$query2 = $pdo->query("SELECT * from membros where cargo = '$id' ");
$res2 = $query2->fetchAll(PDO::FETCH_ASSOC); 
$total_acessos = @count($res2);
if($total_acessos > 0){
	echo 'Você precisa primeiro excluir os usuários / membros para depois excluir o cargo relacionado!';
	exit();
}
$pdo->query("DELETE FROM $tabela WHERE id = '$id' ");
echo 'Excluído com Sucesso';  

//inserir log

$acao = 'exclusão';
$descricao = $nome;
$id_reg = $id;
require_once("../../inserir-logs.php");

?>