<?php 
$pag = 'usuarios';

if(@$usuarios == 'ocultar') {	
	echo '<script>window.location="../index.php"</script>';
	exit(); 
}

?>  
<style>
.modal-header {
    background-color: #033238; /* Cor de fundo preta */
    color: white; /* Cor do texto para ficar legível */
}
</style>
<style>
.modal-header .close {
    color: white; /* Cor branca para contrastar com o fundo preto */
    font-size: 1.5rem; /* Tamanho do ícone do X */
    opacity: 1; /* Deixa o botão completamente visível */
}
.modal-header .close:hover {
    color: #ddd; /* Cor mais clara ao passar o mouse */
}
</style> 

 
	<!-- Botão Inserir novo usuario com a função "inserir()" via "ajax.js" com a tag <a> link -->
<a onclick="inserir()" title="Cadastrar Usuário" style="display: inline;" type="button" class="btn btn-primary btn-dinamico"><span class="fa fa-plus"></span> Usuário</a> 



	<!-- Botão Excluir com mult selecionados via "ajax.js" -->
<li class="dropdown head-dpdn2 btn-dinamico3" style="display: inline-block;">	
		<a href="#" data-toggle="dropdown" class="btn btn-danger dropdown-toggle btn-dinamico2" id="btn-deletar" style="display:none"><span class="fa fa-trash-o"></span> Deletar</a>

		<ul class="dropdown-menu">
		<li>
		<div class="notification_desc2">
		<p>Excluir Selecionados? <a href="#" onclick="deletarSel()"><span class="text-danger">Sim</span></a></p>
		</div>
		</li>										
		</ul>
</li> 


<!-- Área que vai exibir a tabela com os dados do Usuário atraves datatables --> 
<div class="bs-example widget-shadow" style="padding:15px" id="listar">

</div> 



<!-- toda vez que eu selecionar os registros ele vai colocar todos os ids no input p/a g
guardar as informações dos ids que estou selecionando -->
<input type="hidden" id="ids">



 
<!-- Modal Form Usuario -->
<div class="modal fade" id="modalForm" data-backdrop="static" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
	<div class="modal-dialog"> 
		<div class="modal-content">
			<div class="modal-header">
				<h4 class="modal-title" id="exampleModalLabel"><span id="titulo_inserir"></span></h4>
				<button id="btn-fechar" type="button" class="close" data-dismiss="modal" aria-label="Close" style="margin-top: -25px">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<form id="form">
			<div class="modal-body">
				

					<div class="row">
						<div class="col-md-8">							
								<label>Nome</label>
								<input type="text" class="form-control" id="nome" name="nome" placeholder="Nome" required>							
						</div>

						<div class="col-md-4">							
								<label>Matricula</label>
								<input type="text" class="form-control" id="matricula" name="matricula" placeholder="Matricula" required >							
						</div>
						
					</div>


					<div class="row">

						<div class="col-md-7">							
								<label>Email</label>
								<input type="email" class="form-control" id="email" name="email" placeholder="Email"  required>							
						</div>
						

						<div class="col-md-5"> 							
								<label>Nível</label>  
								<select class="form-control" name="nivel" id="nivel" required>
									<option value="" disabled selected>- Selecione -</option>
								  <?php
								  		$query = $pdo->query("SELECT * from cargos order by nome asc");
										$res = $query->fetchAll(PDO::FETCH_ASSOC);
										$linhas = @count($res);
										if($linhas > 0){
											for($i=0; $i<$linhas; $i++){												 
								   ?>
								   	<option value="<?php echo $res[$i]['nome'] ?>"><?php echo $res[$i]['nome'] ?></option>

								<?php } }else{ ?>
									<option value="">Cadastre um Cargo / Nivel</option>
								<?php } ?>
								</select>							
						</div>
						
					</div> 


					<div class="row">

						<div class="col-md-7"> 							
								<label>Comissão</label>
								<select class="form-control" name="comissao" id="comissao" required>
								<option value="" selected hidden >- Selecione -</option>
								  <?php
								  		$query2 = $pdo->query("SELECT * from comissoes order by nome asc");
										$res2 = $query2->fetchAll(PDO::FETCH_ASSOC);
										$linhas2 = @count($res2);
										if($linhas2 > 0){
											for($i=0; $i<$linhas2; $i++){												 
								   ?>
								   	<option value="<?php echo $res2[$i]['nome'] ?>"><?php echo $res2[$i]['nome'] ?></option>

								<?php } }else{ ?>
									<option value="">Cadastre uma Comissão</option>
								<?php } ?>
								</select>							
						</div>

						<div class="col-md-5">							
								<label>Telefone(zap)</label>
								<input type="text" class="form-control" id="telefone" name="telefone" placeholder="(xx)xxxxx-xxxx">							
						</div>						

					</div>


					<div class="row">

						<div class="col-md-12">							
								<label>Endereço</label>
								<input type="text" class="form-control" id="endereco" name="endereco" placeholder="Endereço" >							
						</div>
						

					</div>
					


					<input type="hidden" class="form-control" id="id" name="id">					

				<br>
				<small><div id="mensagem" align="center"></div></small>
			</div>
			<div class="modal-footer">
				       
				<button type="submit" class="btn btn-primary btn-lg"><span class="fa fa-floppy-o"> Salvar</button>

				<button type="button" class="btn btn-link btn-sm" data-dismiss="modal"><span class="fa fa-times"> sair</button> 
			</div>
			
			</form>
		</div>
	</div>
</div>







<!-- Modal Exibir Dados Usuarios-->
<div class="modal fade" id="modalDados" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<h4 class="modal-title" id="exampleModalLabel"><span id="titulo_dados"></span></h4>
				<button id="btn-fechar-dados" type="button" class="close" data-dismiss="modal" aria-label="Close" style="margin-top: -25px">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			
			<div class="modal-body">
				<div class="row" style="margin-top: 0px">
					<div class="col-md-6" style="margin-bottom: 5px">
						<span><b>Telefone: </b></span><span id="telefone_dados"></span>
					</div>

					
					<div class="col-md-8" style="margin-bottom: 5px">
						<span><b>Email: </b></span><span id="email_dados"></span>
					</div>

					<div class="col-md-8" style="margin-bottom: 5px">
						<span><b>Matrícula: </b></span><span id="matricula_dados"></span>
					</div>					

					<div class="col-md-4" style="margin-bottom: 5px">
						<span><b>Senha: </b></span><span id="senha_dados"></span>
					</div>

					<div class="col-md-6" style="margin-bottom: 5px">
						<span><b>Nível: </b></span><span id="nivel_dados"></span>
					</div>

					<div class="col-md-6" style="margin-bottom: 5px">
						<span><b>Ativo: </b></span><span id="ativo_dados"></span>
					</div>

					<div class="col-md-6" style="margin-bottom: 5px">
						<span><b>Data Cadastro: </b></span><span id="data_dados"></span>
					</div>

					<div class="col-md-6" style="margin-bottom: 5px">
						<span><b>Comissão: </b></span><span id="comissao_dados"></span>
					</div>

					<div class="col-md-12" style="margin-bottom: 5px">
						<span><b>Endereço: </b></span><span id="endereco_dados"></span>
					</div>

					<div class="col-md-12" style="margin-bottom: 5px">
						<div align="center"><img src="" id="foto_dados" width="100px"></div>
					</div>
				</div>
			</div>
					
		</div>
	</div>
</div>









<!-- Barra de rolagem Permissoes -->
<style type="text/css">
	.modal-dialog {
    max-height: 85vh; /* Define uma altura máxima para o modal (85% da altura da viewport) */
    display: flex;
    flex-direction: column;
}

.modal-content {
    overflow: hidden; /* Evita que o conteúdo transborde */
    display: flex;
    flex-direction: column;
    height: 100%;
}

.modal-header {
    flex-shrink: 0; /* Impede que o header encolha */
    position: sticky; /* Torna o header fixo */
    top: 0; /* Fixa no topo */
    z-index: 1; /* Garante que fique acima do conteúdo rolável */
    background-color: #1c262e; /* Mantém o fundo  (ajuste conforme seu design) */
}

.modal-body {
    overflow-y: auto; /* Adiciona barra de rolagem vertical quando necessário */
    flex-grow: 1; /* Permite que o body ocupe o espaço restante */
    max-height: 100%; /* Garante que respeite a altura do modal */
}
</style>

 

<!-- Modal Permissoes -->
<div class="modal fade" id="modalPermissoes" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="exampleModalLabel">
                    <span id="nome_permissoes"></span>
                    <span style="position:absolute; right:35px">
                        <input class="form-check-input" type="checkbox" id="input-todos" onchange="marcarTodos()">
                        <label class="">Marcar Todos</label>
                    </span>
                </h4>
                <button id="btn-fechar-permissoes" type="button" class="close" data-dismiss="modal" aria-label="Close" style="margin-top: -25px">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            
            <div class="modal-body">
                <div class="row" id="listar_permissoes">
                    <!-- Seu conteúdo aqui -->
                </div>
                <br>
                <!-- Em caso de erro, aparece a mensagem -->
                <input type="hidden" name="id" id="id_permissoes">
                <small><div id="mensagem_permissao" align="center" class="mt-3"></div></small>        
            </div>
        </div>
    </div>
</div>






<!-- Cria uma variavel do JS "var pag" p/a receber uma variavel do php "$pag" -->
<script type="text/javascript">var pag = "<?=$pag?>"</script>
<script src="js/ajax.js"></script> <!-- chama a página do ajax.js contendo todas as funçoes do ajax.js -->




<!-- Ajax função listar permissoes -->
<script type="text/javascript">
	function listarPermissoes(id){
		 $.ajax({
        url: 'paginas/' + pag + "/listar_permissoes.php",
        method: 'POST',
        data: {id},
        dataType: "html",

        success:function(result){        	
            $("#listar_permissoes").html(result);
            $('#mensagem_permissao').text('');
        }
    });
	}





		//Ajax função Add permissoes (insere e exclui)
	function adicionarPermissao(id, usuario){
		 $.ajax({
        url: 'paginas/' + pag + "/add_permissao.php",
        method: 'POST',
        data: {id, usuario},
        dataType: "html",

        success:function(result){        	
           listarPermissoes(usuario);
        }
    });
	}



   //Ajax função marcar todos
	function marcarTodos(){
		let checkbox = document.getElementById('input-todos');
		var usuario = $('#id_permissoes').val();
		
		if(checkbox.checked) {
		    adicionarPermissoes(usuario);		    
		} else {
		    limparPermissoes(usuario);
		}
	}

 


	function adicionarPermissoes(id_usuario){
		
		$.ajax({
        url: 'paginas/' + pag + "/add_permissoes.php",
        method: 'POST',
        data: {id_usuario},
        dataType: "html",

        success:function(result){        	
           listarPermissoes(id_usuario);
        }
    });
	}



    //Ajax função limpar permissoes
	function limparPermissoes(id_usuario){
		
		$.ajax({
        url: 'paginas/' + pag + "/limpar_permissoes.php",
        method: 'POST',
        data: {id_usuario},
        dataType: "html",

        success:function(result){        	
           listarPermissoes(id_usuario);
        }
    });
	}

</script>


<script>
// Torna o modal arrastável quando ele for exibido bootstrap 4
//precisa de - jquery-ui.js e 	
$(document).ready(function(){
    $("#modalForm").on("shown.bs.modal", function () {
        $(".modal-dialog").draggable({
            handle: ".modal-header", // Arrasta segurando a barra de título
            containment: "window"   // Mantém dentro da tela
        });
    });
});
</script>

