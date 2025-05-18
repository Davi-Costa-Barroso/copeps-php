<?php  
$tabela = 'corpo_docentes';
require_once("../../../conexao.php");

$id = $_POST['id'];
//@$nome = $_POST['nome'];  

//fiz essa consulta pra pegar o $nome pra usar no logs
$query3 = $pdo->query("SELECT * from $tabela where id = '$id' ");
$res3 = $query3->fetchAll(PDO::FETCH_ASSOC);
$nome = $res3[0]['nome']; 
 

$pdo->query("DELETE FROM $tabela WHERE id = '$id' ");
echo 'Excluído com Sucesso';  

//inserir log

$acao = 'exclusão';
$descricao = $nome;
$id_reg = $id;
require_once("../../inserir-logs.php");

?>