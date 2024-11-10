<?php 

$tabela = 'pareceres';
require_once("../../../conexao.php");

$id = $_POST['id'];
$nome = $_POST['nome']; // ['nome'] vem do imput name da Modal Form Usuario
$email = $_POST['email'];
$matricula = $_POST['matricula'];
$cargo = $_POST['cargo'];
$comissao = $_POST['comissao'];
$telefone = $_POST['telefone'];
$cpf = $_POST['cpf'];
$endereco = $_POST['endereco'];
$cidade = $_POST['cidade'];
$estado = $_POST['estado'];
$pais = $_POST['pais'];
//$foto = $_POST['foto'];
$obs = $_POST['obs'];
//$senha = '123';
//$senha_crip = md5($senha);


//validar cpf
$query = $pdo->query("SELECT * FROM $tabela where cpf = '$cpf'");
$res = $query->fetchAll(PDO::FETCH_ASSOC);
$total_reg = @count($res);
if($total_reg > 0 and $res[0]['id'] != $id){
	echo 'CPF já Cadastrado, escolha Outro!';
	exit();
}

//validacao email
$query = $pdo->query("SELECT * from $tabela where email = '$email'");
$res = $query->fetchAll(PDO::FETCH_ASSOC);
$id_reg = @$res[0]['id']; // trazendo id do bd

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



$query = $pdo->query("SELECT * FROM $tabela where id = '$id'");
$res = $query->fetchAll(PDO::FETCH_ASSOC);
$total_reg = @count($res);
if($total_reg > 0){
	$foto = $res[0]['foto'];
}else{
	$foto = 'sem-foto.jpg';
}



//SCRIPT PARA SUBIR FOTO NO SERVIDOR
$nome_img = date('d-m-Y H:i:s') .'-'.@$_FILES['foto']['name'];
$nome_img = preg_replace('/[ :]+/' , '-' , $nome_img);
$caminho = '../../images/perfil/' .$nome_img;

$imagem_temp = @$_FILES['foto']['tmp_name']; 

if(@$_FILES['foto']['name'] != ""){
	$ext = pathinfo($nome_img, PATHINFO_EXTENSION);   
	if($ext == 'png' or $ext == 'jpg' or $ext == 'jpeg' or $ext == 'gif'){ 

		if (@$_FILES['foto']['name'] != ""){

			//EXCLUO A FOTO ANTERIOR
			if($foto != "sem-foto.jpg"){
				@unlink('images/perfil/'.$foto);
			}

			$foto = $nome_img;
		}

		move_uploaded_file($imagem_temp, $caminho);
	}else{
		echo 'Extensão de Imagem não permitida!';
		exit();
	}
}

//$nome_cargo = "";
//$nome_comissao = "";
$ult_id = "";

//recuperar o nome do cargo
$query2 = $pdo->query("SELECT * FROM cargos where id = '$cargo'");
$res2 = $query2->fetchAll(PDO::FETCH_ASSOC);
if(@count($res2) > 0){
	$nome_cargo = $res2[0]['nome'];
}

if($nome_cargo == 'Discente'){
	$nivel_usu = 'Discente';				
}


if($nome_cargo == 'Docente'){
	$nivel_usu = 'Docente';			
}

if($nome_cargo == 'Tecnico-Administrativo'){
	$nivel_usu = 'Tecnico-Administrativo';			
}


//recuperar o nome da comissão
$query3 = $pdo->query("SELECT * FROM comissoes where id = '$comissao'");
$res3 = $query3->fetchAll(PDO::FETCH_ASSOC);
if(@count($res3) > 0){
	$nome_comissao = $res3[0]['nome'];
}

if($nome_comissao == 'COPEP'){
	$nivel_com = 'COPEP';				
}


if($nome_comissao == 'CAALEN'){
	$nivel_com = 'CAALEN';			
}

if($nome_comissao == 'CAEF'){
	$nivel_com = 'CAEF';			
}

if($nome_comissao == 'CAEG'){
	$nivel_com = 'CAEG';			
}



//se ele não passou nada "", faz a inserção
if($id == ""){
	$query = $pdo->prepare("INSERT INTO $tabela SET nome = :nome, email = :email, matricula = :matricula, cargo = '$cargo', comissao = '$comissao', telefone = :telefone, cpf = :cpf, endereco = :endereco, cidade = :cidade, estado = :estado, pais = :pais,  foto = '$foto', data = curDate(), ativo = 'Sim', obs = :obs");

	$query->bindValue(":nome", "$nome");
	$query->bindValue(":email", "$email");
	$query->bindValue(":matricula", "$matricula");
	$query->bindValue(":telefone", "$telefone");
	$query->bindValue(":cpf", "$cpf");
	$query->bindValue(":endereco", "$endereco");
	$query->bindValue(":cidade", "$cidade");
	$query->bindValue(":estado", "$estado");
	$query->bindValue(":pais", "$pais");
	$query->bindValue(":obs", "$obs");
	$query->execute();
	$ult_id = $pdo->lastInsertId(); 

	$acao = 'inserção';  //eu coloquei por causa do log


//inserir o membro na tabela de usuários	
	if(@$nivel_usu != ""){
		$query_usu = $pdo->prepare("INSERT INTO usuarios SET nome = :nome, email = :email, senha_crip = :senha_crip, senha = :senha, nivel = '$nivel_usu', telefone = :telefone, endereco = :endereco, data = curDate(), ativo = 'Sim', matricula = :matricula, comissao = '$nivel_com', foto = '$foto', id_pessoa = '$ult_id'"); 


		$senha_crip = md5('123');
		$query_usu->bindValue(":nome", "$nome");
		$query_usu->bindValue(":email", "$email");		
		$query_usu->bindValue(":senha_crip", "$senha_crip");
		$query_usu->bindValue(":senha", "123");
		$query_usu->bindValue(":telefone", "$telefone");
		$query_usu->bindValue(":endereco", "$endereco");
		$query_usu->bindValue(":matricula", "$matricula");			
		$query_usu->execute();

		$acao = 'inserção';  //eu coloquei por causa do log
	}

}else{//atualizar na tabela de membros
	$query = $pdo->prepare("UPDATE $tabela SET nome = :nome, email = :email, matricula = :matricula, cargo = '$cargo', comissao = '$comissao', telefone = :telefone, cpf = :cpf, endereco = :endereco, cidade = :cidade, estado = :estado, pais = :pais,  foto = '$foto', obs = :obs where id = '$id'");

	$query->bindValue(":nome", "$nome");
	$query->bindValue(":email", "$email");
	$query->bindValue(":matricula", "$matricula");
	$query->bindValue(":telefone", "$telefone");
	$query->bindValue(":cpf", "$cpf");
	$query->bindValue(":endereco", "$endereco");
	$query->bindValue(":cidade", "$cidade");
	$query->bindValue(":estado", "$estado");
	$query->bindValue(":pais", "$pais");
	$query->bindValue(":obs", "$obs");
	$query->execute();
	$ult_id = $pdo->lastInsertId(); //eu coloquei por causa do log

	$acao = 'edição';  //eu coloquei por causa do log

	//atualizar na tabela de usuários
	if(@$nivel_usu != ""){
		$query_usu = $pdo->prepare("UPDATE usuarios SET nome = :nome, matricula = :matricula, email = :email, nivel = '$nivel_usu', comissao = '$nivel_com', telefone = :telefone, endereco = :endereco, foto = '$foto' WHERE id_pessoa = '$id'");

		if($query_usu != ""){
			$senha_crip = md5('123');
			$query_usu->bindValue(":nome", "$nome");
			$query_usu->bindValue(":email", "$email");
			$query_usu->bindValue(":telefone", "$telefone");
			$query_usu->bindValue(":endereco", "$endereco");
			$query_usu->bindValue(":matricula", "$matricula");						
			$query_usu->execute();
			$ult_id = $pdo->lastInsertId(); //eu coloquei por causa do log


			if($ult_id == "" || $ult_id == 0){
				$ult_id = $id;
			}

			$acao = 'edição';  //eu coloquei por causa do log
		}
	}


}




//inserir log
$acao = $acao;
$descricao = $nome;
$id_reg = $ult_id;
require_once("../../inserir-logs.php");


echo 'Salvo com Sucesso';

?>