 <?php 
$tabela = 'usuarios';
require_once("../../../conexao.php");

$id = $_POST['id'];
$acao = $_POST['acao'];
$nome = $_POST['nome'];

//Fiz desse jeito p/a pegar a ultima Id autizado
 // Atualizar usuarios
$query = $pdo->prepare("UPDATE $tabela SET ativo = :acao WHERE id = :id");
$query->bindValue(":acao", $acao);
$query->bindValue(":id", $id);
$query->execute();

$ult_id_atualizado = $id; // pega a ultima Id utizado, o ID atualizado


// Atualizar membro
$query2 = $pdo->prepare("UPDATE membros SET ativo = :acao WHERE id_pessoa = :id");
$query2->bindValue(":acao", $acao);
$query2->bindValue(":id", $ult_id_atualizado);
$query2->execute();



echo 'Alterado com Sucesso';


//inserir log
$acao = 'edição';
$descricao = $nome;
$id_reg = $id;
require_once("../../inserir-logs.php");
?>