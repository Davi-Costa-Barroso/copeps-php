<?php 
require_once("conexao.php");  

											
//verificar scripts para executar

//rotina para limpar os logs
$data_atual = date('Y-m-d');
$data_limpeza = date('Y-m-d', strtotime("-$dias_limpar_logs days",strtotime($data_atual)));
$pdo->query("DELETE FROM logs where data < '$data_limpeza'");



//Cria um Usuario ADMIN
$query = $pdo->query("SELECT * from usuarios");
$res = $query->fetchAll(PDO::FETCH_ASSOC);
$linhas = @count($res);
$senha = '123';
$senha_crip = md5($senha);

if($linhas == 0){
	$pdo->query("INSERT INTO usuarios SET nome = '$nome_sistema', email = '$email_sistema', senha = '$senha', senha_crip = '$senha_crip', nivel = 'Administrador', ativo = 'Sim', status = 'Ativo', foto = 'sem-foto.jpg', telefone = '$telefone_sistema', id_pessoa = '0', data = curDate() ");
}

$query = $pdo->query("SELECT * from cargos");
$res = $query->fetchAll(PDO::FETCH_ASSOC);
$linhas = @count($res);
if($linhas == 0){
	$pdo->query("INSERT INTO cargos SET nome = 'Administrador'");
}



?>


<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=no">	
	<link rel="stylesheet" type="text/css" href="css/bootstrap.css">
	<link rel="stylesheet" type="text/css" href="css/login.css">	
	<link rel="shortcut icon" type="image/x-icon" href="img/icone.png">
	<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.6.3/css/all.css" integrity="sha384-UHRtZLI+pbxtHCWp1t77Bi1L4ZtiqrqD80Kn4Z8NTSRyMA2Fd33n5dQ8lWUE00s/" crossorigin="anonymous">


	<title><?php echo $nome_sistema ?></title>




</head>
<body>

	

	
	<div class="container" id="tamanho" style=" border-radius: 18px; border: 20px solid #f3f3f3">		
		<div>
			<div style="margin-top: 12px; text-align:center">
				<img src="img/cadeado.png" class="imagem" width="60px" height="60px">
			</div>
			<br> 	
			<div style="text-align:center">
				<h2 class="log_title">Sistema de Acesso </h2> 
			</div>

			<form method="post" action="autenticar.php">
				<div>
					<label  for="usuario" class="form-label">Usuario</label>
					<input type="email" name="usuario" id="usuario" class="form-control" 
					placeholder="E-mail" required>
				</div>
				<div>
					<label  for="senha" class="form-label">Senha</label>
					<input type="password" name="senha" id="senha" class="form-control" placeholder="Senha" required>
				</div>
				<span class="fa fa-eye"></span>

				<div class="d-grid gap-2" >
					<button  class="btn btn-success">Entrar</button>
				</div>
			</form>

			<div class="cont">		
				<p>Não possui cadastro?<a class="text-primary" href="" data-bs-toggle="modal" data-bs-target="#modalCadastro"> Cadastre-se</a></p>		
			</div> 

		</div>
	</div>
	




	<script type="text/javascript" src="js/bootstrap.js"></script>
	<script type="text/javascript" src="js/jquery-3.7.1.min.js"></script>


	<!-- Script mostrar senha -->
	<script> 
		let btn = document.querySelector('.fa-eye');

		btn.addEventListener('click', function() {
			let input = document.querySelector('#senha');

			if(input.getAttribute('type') == 'password') {
				input.setAttribute('type', 'text');
			} else {
				input.setAttribute('type', 'password');
			}

		});
	</script>
	


</body>
</html>





<!-- Modal Cadastro Externo -->
<div class="modal fade" id="modalCadastro" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true" data-bs-backdrop="static">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<h3 class="modal-title" id="exampleModalLabel">Cadastre-se</h3>
				<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
			</div>
			<form id="form-cadastro">
				<div class="modal-body ">
					<div class="row">					
						<div class="mb-3">
							<label for="nome"><small>Nome:</small></label>
							<input type="text" class="form-control" id="nome" name="nome" placeholder="Nome" required>
						</div>					

						<div class="mb-3">
							<label for="email"><small>E-mail:</small></label>
							<input type="email" class="form-control" id="email" name="email" placeholder="E-mail" required>
						</div>
					</div>


					<div class="row">
						<div class="mb-3 col-md-6">
							<label for="senha_cadastro"><small>Senha</small></label>
							<input type="password" class="form-control" id="senha_cadastro" name="senha_cadastro" placeholder="Senha" required>
						</div>

						<div class="mb-3 col-md-6">
							<label for="conf_senha"><small>Confirmar Senha</small></label>
							<input type="password" class="form-control" id="conf_senha" name="conf_senha" placeholder="Confirme Senha" required>
						</div>
					</div>

					<div class="row">
						<div class="form-group col-md-6">
							<label for="nivel" ><small>Selecione o Nível:</small></label> 
							<select class="form-select" name="nivel" id="nivel" >					
								<option>Discente</option>
								<option>Docente</option>		
								<option>Técnico-Administrativo</option>
							</select>
						</div>

						<div class="form-group col-md-6">							
							<label for="matricula"><small>Matricula<small></label>
							<input type="text" class="form-control" id="matricula" name="matricula" placeholder="Matrícula" required>						
						</div>						
					</div>

				<!-- Mensagem exibindo sucessso ou erro via Ajax atraves id="mensagem-cadastro")-->
					<br><big><div  align="center" id="mensagem-cadastro"></div></big>
				</div>
				<div class="modal-footer">       
					<button type="submit" class="btn btn-secondary" data-bs-dismiss="modal">Fechar</button>
					<button type="submit" class="btn btn-primary">Cadastrar</button>
				</div>
			</form>
		</div>
	</div>
</div>





<!-- Ajax para Inserir Cadastro (quando for submit o botão cadastrar) -->
<script type="text/javascript">
	$("#form-cadastro").submit(function () {		
		event.preventDefault(); //não deixa recarregar a página
		var formData = new FormData(this); //todos os itens do formularis vai p/a variavel formData

		$.ajax({
			url: "cadastro.php",
			type: 'POST',
			data: formData,

			success: function (mensagem) {
				$('#mensagem-cadastro').text(''); //limpa o texto
				$('#mensagem-cadastro').removeClass()  //limpa a classe
				if (mensagem.trim() == "Cadastrado com Sucesso") {
					//$('#btn-fechar-usu').click();  //fecha a moda
					//window.location="index.php";   //atualiza a página e vai p/a index
					$('#mensagem-cadastro').addClass('text-success') //cor da mensagem
					$('#mensagem-cadastro').text(mensagem)	//mostra a msg "Cadastrado com Sucesso"
					//$('#usuario').val($('#email').val()) //preenche automaticamente usuario no login
					//$('#senha').val($('#senha_cadastro').val()) ////preenche automaticamente senha no login	
					//window.location="index.php";   //atualiza a página e vai p/a index			
					
				}else {

					$('#mensagem-cadastro').addClass('text-danger')
					$('#mensagem-cadastro').text(mensagem)
				}

				//função que coloca tempo para mensagem
				$(document).ready(function () {
	   					setTimeout(function () {
	       				 window.location.reload(1);	   					  	
	  					}, 3000); //tempo em milisegundos. Neste caso, o refresh vai acontecer de 3 em 3 segundos.
				});


			},

			cache: false,
			contentType: false,
			processData: false,
				
		});
				
	});
</script>