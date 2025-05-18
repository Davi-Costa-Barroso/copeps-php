<?php 

$tabela = 'usuarios';
require_once("../../../conexao.php");

$id = $_POST['id']; //usa o id, pq eu salvo e edito no msm formulario
$nome = $_POST['nome']; // ['nome'] vem do imput name da Modal Form Usuario
$email = $_POST['email'];
$telefone = $_POST['telefone'];
$nivel = $_POST['nivel'];
$endereco = $_POST['endereco'];
$senha = '123';
$senha_crip = md5($senha);
$matricula = $_POST['matricula'];
$comissao = $_POST['comissao'];


//validacao email
$query = $pdo->query("SELECT * from $tabela where email = '$email'");
$res = $query->fetchAll(PDO::FETCH_ASSOC);
$id_reg = @$res[0]['id']; //@ pq nem sempre vai encontrar o usuario, trazendo id do bd (recupera o id do usuario)

if(@count($res) > 0 and $id != $id_reg){ 
	echo 'Email já Cadastrado!';
	exit();
}


//validacao telefone
$query = $pdo->query("SELECT * from $tabela where telefone = '$telefone'");
$res = $query->fetchAll(PDO::FETCH_ASSOC);
$id_reg = @$res[0]['id'];
if(@count($res) > 0 and $id != $id_reg){
	echo 'Telefone já Cadastrado!';
	exit();
}


//validacao matricula
$query = $pdo->query("SELECT * from $tabela where matricula = '$matricula'");
$res = $query->fetchAll(PDO::FETCH_ASSOC);
$id_reg = @$res[0]['id'];
if(@count($res) > 0 and $id != $id_reg){
	echo 'Matrícula já Cadastrado!';
	exit();
}

$nome_cargo = "";
$nome_comissao = "";
$ult_id = "";


//recuperar o nome do cargo
$query2 = $pdo->query("SELECT * FROM cargos where nome = '$nivel'");
$res2 = $query2->fetchAll(PDO::FETCH_ASSOC);
if(@count($res2) > 0){
		$nome_cargo = $res2[0]['nome'];

}

if($nome_cargo == 'Discente'){
		$nivel_mem = 3;
						
}


if($nome_cargo == 'Docente'){
		$nivel_mem = 2;
					
}

if($nome_cargo == 'Tecnico-Administrativo'){
		$nivel_mem = 4;
					
}


$nivel_com = "";
//recuperar o nome da comissão
$query3 = $pdo->query("SELECT * FROM comissoes where nome = '$comissao'");
$res3 = $query3->fetchAll(PDO::FETCH_ASSOC);
if(@count($res3) > 0){
		$nome_comissao = $res3[0]['nome'];
}

if($nome_comissao == 'COPEP'){
		$nivel_com = 1;
						
}


if($nome_comissao == 'CAALEN'){
		$nivel_com = 2;
					
}

if($nome_comissao == 'CAEF'){
		$nivel_com = 3;
					
}

if($nome_comissao == 'CAEG'){
		$nivel_com = 4;

}



//se ele não passou nada "", faz a inserção usuarios
if($id == ""){
		$query = $pdo->prepare("INSERT INTO $tabela SET nome = :nome, email = :email, senha = '$senha', senha_crip = '$senha_crip', nivel = '$nivel', ativo = 'Sim', foto = 'sem-foto.jpg', telefone = :telefone, data = curDate(), endereco = :endereco, matricula = :matricula, comissao = :comissao");

		$query->bindValue(":nome", "$nome");
		$query->bindValue(":email", "$email");
		$query->bindValue(":matricula", "$matricula");
		$query->bindValue(":telefone", "$telefone");	
		$query->bindValue(":endereco", "$endereco");	
		$query->bindValue(":comissao", "$comissao");
		$query->execute();

		$ult_id_usuario = $pdo->lastInsertId(); //Captura o último ID gerado usuarios.php automaticamente por uma inserção em uma tabela de uma coluna AUTO_INCREMENT, como a chave primária id em membros.


		$acao = 'inserção';  //eu coloquei por causa do log


//inserir o membro na tabela de membros	
	if(@$nivel_mem != ""){
		$query_mem = $pdo->prepare("INSERT INTO membros SET nome = :nome, email = :email, matricula = :matricula, cargo = '$nivel_mem', comissao = '$nivel_com', telefone = :telefone,  endereco = :endereco, foto = 'sem-foto.jpg', data = curDate(), ativo = 'Sim', id_pessoa = '$ult_id_usuario'"); 


		$query_mem->bindValue(":nome", "$nome");
		$query_mem->bindValue(":email", "$email");
		$query_mem->bindValue(":matricula", "$matricula");
		$query_mem->bindValue(":telefone", "$telefone");
		//$query_mem->bindValue(":cpf", "$cpf");
		$query_mem->bindValue(":endereco", "$endereco");
		//$query_mem->bindValue(":cidade", "$cidade");
		//$query_mem->bindValue(":estado", "$estado");
		//$query_mem->bindValue(":pais", "$pais");
		//$query_mem->bindValue(":obs", "$obs");
		$query_mem->execute();

		//foi inserido algo novo pela IA
		$ult_id_membro = $pdo->lastInsertId(); // ID de membros


		// Atualizar usuarios com o id de membros
    $query_update_usuario = $pdo->prepare("UPDATE $tabela SET id_pessoa = '$ult_id_membro' WHERE id = '$ult_id_usuario'");    
    
    $query_update_usuario->execute();

		$acao = 'inserção';  //eu coloquei por causa do log
	}

}else{//atualizar na tabela de usuarios
	$query = $pdo->prepare("UPDATE $tabela SET nome = :nome, matricula = :matricula, email = :email, nivel = '$nivel', comissao = '$comissao', telefone = :telefone, endereco = :endereco WHERE id = '$id'");

	$senha_crip = md5('123');
	$query->bindValue(":nome", "$nome");
	$query->bindValue(":email", "$email");
	$query->bindValue(":telefone", "$telefone");
	$query->bindValue(":endereco", "$endereco");
	$query->bindValue(":matricula", "$matricula");						
	$query->execute();

	$ult_id = $id; //COLOQUE P/A FAZER TESTES
	//$ult_id = $pdo->lastInsertId(); //eu coloquei por causa do log (COMENTEI P/ FAZER TESTES)

	$acao = 'edição';  //eu coloquei por causa do log

	//atualizar na tabela de membros
			if(@$nivel_mem != ""){
				$query_mem = $pdo->prepare("UPDATE membros SET nome = :nome, email = :email, matricula = :matricula, cargo = '$nivel_mem', comissao = '$nivel_com', telefone = :telefone, endereco = :endereco, foto = 'sem-foto.jpg' where id_pessoa = '$id'");

				if($query_mem != ""){
					$senha_crip = md5('123');
					$query_mem->bindValue(":nome", "$nome");
					$query_mem->bindValue(":email", "$email");
					$query_mem->bindValue(":telefone", "$telefone");
					$query_mem->bindValue(":endereco", "$endereco");
					$query_mem->bindValue(":matricula", "$matricula");						
					$query_mem->execute();

					$ult_id = $id; //COLOQUE P/A FAZER TESTES
					//$ult_id = $pdo->lastInsertId(); //eu coloquei por causa do log (COMENTEI P/ FAZER TESTES)

						//COMENTEI P/FAZER TESTES  
					if($ult_id == "" || $ult_id == 0){
						$ult_id = $id;
					} 

					$acao = 'edição';  //eu coloquei por causa do log
		}
	}


}




//inserir log
$acao = $acao;  //pode ser inserção ou edição (depende em qual usuario selecionar)
$descricao = $nome; //nome do usuario
$id_reg = $ult_id;
require_once("../../inserir-logs.php");


echo 'Salvo com Sucesso';

?>