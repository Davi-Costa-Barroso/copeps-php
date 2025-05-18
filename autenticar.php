<?php 
@session_start();
require_once("conexao.php");


$usuario = $_POST['usuario'];  //['usuario']vem do input name do index.php
$senha = $_POST['senha'];
$senha_crip = md5($senha);


//usa o prepare, quando chega de uma caixa de texto(input) formulário, segurança
$query = $pdo->prepare("SELECT * from usuarios where email = :email and senha_crip = :senha"); //cria a consulta
$query->bindValue(":email", "$usuario");
$query->bindValue(":senha", "$senha_crip");
$query->execute();
$res = $query->fetchAll(PDO::FETCH_ASSOC); //executa a consulta.
$linhas = @count($res); //@count é contagens de linhas que o $res vai trazer.


if($linhas > 0){ 
	//Bloqueia o acesso do usuario inativo
	if($res[0]['ativo'] != 'Sim'){
		echo '<script>window.alert("Contate o administrador do sistema!")</script>'; 
		echo '<script>window.location="index.php"</script>'; //redirecionamento via JS p/a o index.php
		exit(); 
	}
  
	//Cria variaveis sessão p/a recuperar dados do usuario(nome,id,nivel) e poder ter permissão p/a ser chamada no index do painel.
	$_SESSION['nome'] = $res[0]['nome'];
	$_SESSION['id'] = $res[0]['id'];
	$_SESSION['nivel'] = $res[0]['nivel'];

	//inserir log
	$tabela = 'usuarios';
	$acao = 'login';
	$descricao = 'login';
	require_once("painel/inserir-logs.php");

	echo '<script>window.location="painel"</script>'; //redirecionamento via JS p/a o index.php do painel

}else{
	echo '<script>window.alert("Dados Incorretos!!")</script>'; 
	echo '<script>window.location="index.php"</script>'; //redirecionamento via JS p/a o index.php 
}



 ?>