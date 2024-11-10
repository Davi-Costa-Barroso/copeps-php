<?php 
$tabela = 'usuarios';
require_once("../conexao.php");

$nome = $_POST['nome'];
$email = $_POST['email'];
$telefone = $_POST['telefone'];
$conf_senha = $_POST['conf_senha'];
$endereco = $_POST['endereco'];
$senha = $_POST['senha'];
$senha_crip = md5($senha);
$id = $_POST['id_usuario'];
$matricula = $_POST['matricula'];

if($conf_senha != $senha){
	echo 'As senhas não se coincidem';
	exit();
}


//validacao email duplicado
$query = $pdo->query("SELECT * from $tabela where email = '$email'");
$res = $query->fetchAll(PDO::FETCH_ASSOC);
$id_reg = @$res[0]['id'];
if(@count($res) > 0 and $id != $id_reg){
	echo 'Email já Cadastrado!';
	exit();
}

//validacao telefone duplicado
$query = $pdo->query("SELECT * from $tabela where telefone = '$telefone'");
$res = $query->fetchAll(PDO::FETCH_ASSOC);
$id_reg = @$res[0]['id'];
if(@count($res) > 0 and $id != $id_reg){
	echo 'Telefone já Cadastrado!';
	exit();
}


//validacao matricula duplicado
$query = $pdo->query("SELECT * from $tabela where matricula = '$matricula'");
$res = $query->fetchAll(PDO::FETCH_ASSOC);
$id_reg = @$res[0]['id'];
if(@count($res) > 0 and $id != $id_reg){
	echo 'Matrícula já Cadastrado!';
	exit();
}


//validar troca da foto
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

$caminho = 'images/perfil/' .$nome_img;

$imagem_temp = @$_FILES['foto']['tmp_name']; 

if(@$_FILES['foto']['name'] != ""){
	$ext = pathinfo($nome_img, PATHINFO_EXTENSION);   
	if($ext == 'png' or $ext == 'jpg' or $ext == 'jpeg' or $ext == 'gif'){ 
	
			//EXCLUO A FOTO ANTERIOR
			if($foto != "sem-foto.jpg"){
				@unlink('images/perfil/'.$foto);
			}

			$foto = $nome_img;
		
		move_uploaded_file($imagem_temp, $caminho);
	}else{
		echo 'Extensão de Imagem não permitida!';
		exit();
	}
}





$query = $pdo->prepare("UPDATE $tabela SET nome = :nome, email = :email, telefone = :telefone, senha = :senha, senha_crip = '$senha_crip', matricula = :matricula, endereco = :endereco, foto = '$foto' where id = '$id'");

$query->bindValue(":nome", "$nome");
$query->bindValue(":email", "$email");
$query->bindValue(":telefone", "$telefone");
$query->bindValue(":endereco", "$endereco");
$query->bindValue(":senha", "$senha");
$query->bindValue(":matricula", "$matricula");
$query->execute();



//dsd
$query = $pdo->query("SELECT * FROM $tabela where id = '$id'");
$res = $query->fetchAll(PDO::FETCH_ASSOC);
$id_pessoa = $res[0]['id_pessoa'];

$query_func = $pdo->prepare("UPDATE membros SET nome = :nome, email = :email, telefone = :telefone, endereco = :endereco, matricula = :matricula,  foto = '$foto' where id = '$id_pessoa'");
$query_func->bindValue(":nome", "$nome");
$query_func->bindValue(":email", "$email");
$query_func->bindValue(":telefone", "$telefone");
$query_func->bindValue(":endereco", "$endereco");
$query_func->bindValue(":matricula", "$matricula");
$query_func->execute();



echo 'Editado com Sucesso';


//inserir log
$tabela = 'usuarios';
$acao = 'edição';
$descricao = $nome;
$id_reg = $id;
require_once("inserir-logs.php");


 ?>
