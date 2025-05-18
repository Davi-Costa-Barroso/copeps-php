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


// Mapear nivel para cargo (buscar o ID na tabela cargos)
$query_cargo = $pdo->prepare("SELECT id FROM cargos WHERE nome = :nivel");
$query_cargo->bindValue(":nivel", $nivel);
$query_cargo->execute();
$res_cargo = $query_cargo->fetch(PDO::FETCH_ASSOC);
$cargo_id = $res_cargo ? $res_cargo['id'] : null;


// Verificar se o nível é válido (somente Docente, Discente, Tecnico-Administrativo)
$níveis_permitidos = ['Docente', 'Discente', 'Tecnico-Administrativo'];
if (!$cargo_id || !in_array($nivel, $níveis_permitidos)) {
    echo "Nível inválido! Escolha um nível válido: Docente, Discente ou Técnico-Administrativo.";
    exit();
}		


// Inserção em usuarios
$query = $pdo->prepare("INSERT INTO usuarios SET nome = :nome, email = :email, senha = :senha, senha_crip = :senha_crip, nivel = '$nivel', matricula = :matricula, foto = 'sem-foto.jpg', status = 'Inativo', ativo = 'Não', data = curDate()");
$query->bindValue(":nome", "$nome");
$query->bindValue(":email", "$email");
$query->bindValue(":senha", "$senha");
$query->bindValue(":senha_crip", "$senha_crip");
//$query->bindValue(":nivel", "$nivel");		
$query->bindValue(":matricula", "$matricula");
$query->execute();


$ult_id_usuario = $pdo->lastInsertId(); // ID gerado em usuarios, ex.: 1


// Inserção em membros
$query_membro = $pdo->prepare("INSERT INTO membros SET nome = :nome, email = :email, matricula = :matricula, cargo = :cargo, data = CURDATE(), ativo = 'Não', id_pessoa = '$ult_id_usuario'");
$query_membro->bindValue(":nome", $nome);     // id_pessoa em membros recebe o id de usuarios
$query_membro->bindValue(":email", $email);
$query_membro->bindValue(":matricula", $matricula);
$query_membro->bindValue(":cargo", $cargo_id); // Usa o ID do cargo correspondente ao nivel

$query_membro->execute();

$ult_id_membro = $pdo->lastInsertId(); // ID gerado em membros, ex.: 5


// Atualizar usuarios com o id de membros
$query_update_usuario = $pdo->prepare("UPDATE usuarios SET id_pessoa = '$ult_id_membro' WHERE id = '$ult_id_usuario'");


$query_update_usuario->execute();

echo 'Cadastrado com Sucesso';
 

 ?>


