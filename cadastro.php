<?php 
require_once("conexao.php");

$nome = $_POST['nome']; 
$email = $_POST['email']; 
$senha = $_POST['senha_cadastro']; 
$conf_senha = $_POST['conf_senha']; 
$senha_crip = md5($senha);
$nivel = $_POST['nivel']; 
$matricula = $_POST['matricula'];


if ($senha != $conf_senha) {
	echo "As senhas não se coincidem!";
	exit(); 
}


//verificando se ja existe um email no BD
$query = $pdo->query("SELECT * FROM usuarios where email = '$email'");
$res = $query->fetchAll(PDO::FETCH_ASSOC);
if(@count($res) > 0){
	echo 'Este email já está cadastrado, escolha outro ou recupere sua senha!';
	exit();
}		


$query = $pdo->prepare("INSERT INTO usuarios SET nome = :nome, email = :email, senha = :senha, senha_crip = :senha_crip, nivel = '$nivel', matricula = :matricula, foto = 'sem-foto.jpg', status = 'Inativo', ativo = 'Não', data = curDate()");
$query->bindValue(":nome", "$nome");
$query->bindValue(":email", "$email");
$query->bindValue(":senha", "$senha");
$query->bindValue(":senha_crip", "$senha_crip");
//$query->bindValue(":nivel", "$nivel");		
$query->bindValue(":matricula", "$matricula");
$query->execute();

echo 'Cadastrado com Sucesso';


 ?>


