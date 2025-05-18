<?php 
$pag = 'membros';

if(@$membros == 'ocultar') {	
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

<style>
    
.btn-fi {
     position: fixed;
     top: 11px;
     left: 340px;
     z-index: 1000;
}

.btn-fixo2-membro {
	  position: fixed;
	  top: 11px;
	  left: 446px;
	  z-index: 1000;
}

</style>

 


	<!-- Botão Inserir novo membro com a função "inserir()" via "ajax.js" -->
<a onclick="inserir()" title="Cadastrar Membro" style="display: inline;" type="button" class="btn btn-primary btn-dinamico-membro"><span class="fa fa-plus"></span> Membro</a>  


   <!-- Botão Excluir com mult selecionados via "ajax.js" -->
<li class="dropdown head-dpdn2" style="display: inline-block;">	
		<a href="#" data-toggle="dropdown" class="btn btn-danger dropdown-toggle btn-dinamico2" id="btn-deletar" style="display:none"><span class="fa fa-trash-o"></span> Deletar</a>

		<ul class="dropdown-menu">
		<li>
		<div class="notification_desc2">
		<p>Excluir Selecionados? <a href="#" onclick="deletarSel()"><span class="text-danger">Sim</span></a></p>
		</div>
		</li>										
		</ul>
</li> 


<div class="bs-example widget-shadow" style="padding:15px" id="listar">

</div> 



<input type="hidden" id="ids">



 
<!-- Modal Form Cadastro Membro -->
<div class="modal fade" id="modalForm" data-backdrop="static" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
	<div class="modal-dialog modal-lg">
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
						<div class="col-md-5">							
								<label>Nome</label>
								<input type="text" class="form-control" id="nome" name="nome" placeholder="Nome" required>							
						</div>

						<div class="col-md-4">							
								<label>Email</label>
								<input type="email" class="form-control" id="email" name="email" placeholder="E-mail"  required>							
						</div>

						<div class="col-md-3">							
								<label>Matricula</label>
								<input type="text" class="form-control" id="matricula" name="matricula" placeholder="Matricula">							
						</div>											

						
					</div>


					<div class="row">												

						<div class="col-md-3">						
							<div class="form-group"> 
								<label>Cargo</label> 
								<select class="form-control sel" name="cargo" id="cargo" required style="width:100%;">
								<option value="" disabled selected>- Selecione -</option> 
									<?php 
									$query = $pdo->query("SELECT * FROM cargos where nome != 'Administrador' order by nome asc");
									$res = $query->fetchAll(PDO::FETCH_ASSOC);
									for($i=0; $i < @count($res); $i++){
										foreach ($res[$i] as $key => $value){}

											?>	
										<option value="<?php echo $res[$i]['id'] ?>"><?php echo $res[$i]['nome'] ?></option>

									<?php } ?>

								</select>
							</div>						
						</div>



						<div class="col-md-3">						
							<div class="form-group"> 
								<label>Comissão</label> 
								<select class="form-control sel2" name="comissao" id="comissao" required style="width:100%;">
								<option value="" disabled selected>- Selecione -</option> 
									<?php 
									$query = $pdo->query("SELECT * FROM comissoes order by nome asc");
									$res = $query->fetchAll(PDO::FETCH_ASSOC);
									for($i=0; $i < @count($res); $i++){
										foreach ($res[$i] as $key => $value){}

											?>	
										<option value="<?php echo $res[$i]['id'] ?>"><?php echo $res[$i]['nome'] ?></option>

									<?php } ?>

								</select>
							</div>						
						</div>



						<div class="col-md-3">  							
								<label>Telefone</label>
								<input type="text" class="form-control" id="telefone" name="telefone" placeholder="Telefone" required>							
						</div>



						<div class="col-md-3">						
							<div class="form-group"> 
								<label>CPF</label> 
								<input type="text" class="form-control" name="cpf" id="cpf" placeholder="Cpf"> 
							</div>						
						</div>

					  </div>



					


					<div class="row">

						

						<div class="col-md-8">							
								<label>Endereço</label>
								<input type="text" class="form-control" id="endereco" name="endereco" placeholder="Endereço" >							
						</div>


						<div class="col-md-4">  							
								<label>Cidade</label>
								<input type="text" class="form-control" id="cidade" name="cidade" placeholder="Cidade" required>							
						</div>

						
						

					</div>


					<div class="row">

						<div class="col-md-2">  							
								<label>Estado</label>
								<input type="text" class="form-control" id="estado" name="estado" placeholder="Estado" required>							
						</div>


						<div class="col-md-2">  							
								<label>País</label>
								<input type="text" class="form-control" id="pais" name="pais" placeholder="País" required>							
						</div>

						<div class="col-md-5">						
							<div class="form-group"> 
								<label>Foto</label> 
								<input type="file" name="foto" onChange="carregarImg();" id="foto">
							</div>						
						</div>
						<div class="col-md-3">
							<div id="divImg">
								<img src="images/perfil/sem-foto.jpg"  width="100px" id="target">									
							</div>
						</div>						

					</div>


					<div class="row">		
						

						<div class="col-md-8">
							<div class="form-group"> 
								<label>OBS <small>(Max 500 Caracteres)</small></label> 
								<textarea maxlength="500" type="text" class="form-control" name="obs" id="obs"> </textarea>
							</div>
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







<!-- Modal Exibir Dados Membros-->
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
				<div class="row" style="margin-top: 0px; border-bottom: 1px solid #cac7c7;">
					<div class="col-md-6" style="margin-bottom: 5px">
						<span><b>Telefone: </b></span><span id="telefone_dados"></span>
					</div>

					
					<div class="col-md-8" style="margin-bottom: 5px">
						<span><b>Email: </b></span><span id="email_dados"></span>
					</div>

					<div class="col-md-8" style="margin-bottom: 5px">
						<span><b>Matrícula: </b></span><span id="matricula_dados"></span>
					</div>					

					
					<div class="col-md-6" style="margin-bottom: 5px">
						<span><b>Cargo: </b></span><span id="cargo_dados"></span>
					</div>

					<div class="col-md-6" style="margin-bottom: 5px">
						<span><b>Comissão: </b></span><span id="comissao_dados"></span>
					</div>

					<div class="col-md-6" style="margin-bottom: 5px">
						<span><b>Ativo: </b></span><span id="ativo_dados"></span>
					</div>

					<div class="col-md-6" style="margin-bottom: 5px">
						<span><b>Data Cadastro: </b></span><span id="data_dados"></span>
					</div>

					<div class="col-md-12" style="margin-bottom: 5px">
						<span><b>Endereço: </b></span><span id="endereco_dados"></span>
					</div>

					<div class="col-md-4" style="margin-bottom: 5px">
						<span><b>Cidade: </b></span><span id="cidade_dados"></span>
					</div>

					<div class="col-md-4" style="margin-bottom: 5px">
						<span><b>Estado: </b></span><span id="estado_dados"></span>
					</div>

					<div class="col-md-4" style="margin-bottom: 10px">
						<span><b>País: </b></span><span id="pais_dados"></span>
					</div>

					<div class="row" style="border-bottom: 1px solid #cac7c7;">
						<div class="col-md-12">							
							<span><b>OBS: </b></span>
							<span id="obs_dados"></span>							
						</div>
					</div>

					<div class="row">
					<div class="col-md-12" style="margin-bottom: 10px">
						<div align="center"><img src="" id="foto_dados" width="100px"></div>
					</div>
					</div>
				</div>
			</div>
					
		</div>
	</div>
</div>




 

<!-- Modal Permissoes -->
<div class="modal fade" id="modalPermissoes" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<h4 class="modal-title" id="exampleModalLabel"><span id="nome_permissoes"></span>

					<span style="position:absolute; right:35px">
						<input class="form-check-input" type="checkbox" id="input-todos" onchange="marcarTodos()">
						<label class="" >Marcar Todos</label>
					</span>

				</h4>
				<button id="btn-fechar-permissoes" type="button" class="close" data-dismiss="modal" aria-label="Close" style="margin-top: -25px">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			
			<div class="modal-body">
				<div class="row" id="listar_permissoes">
					
				</div>

				<br>
				<input type="hidden" name="id" id="id_permissoes">
				<small><div id="mensagem_permissao" align="center" class="mt-3"></div></small>		
			</div>
					
		</div>
	</div>
</div>






<!-- Trás uma variavel do Php "$pag" pro javascript "var pag" -->
<script type="text/javascript">var pag = "<?=$pag?>"</script>
<script src="js/ajax.js"></script>



<!-- Select2 p/a formulario de membros -->
<script type="text/javascript">
	$(document).ready(function() {
		$('.sel2').select2({
			dropdownParent: $('#modalForm')
		});
	});
</script>



<!-- Carregamento da foto para o formulari de membros -->
<script type="text/javascript">
	function carregarImg() {
		var target = document.getElementById('target');
		var file = document.querySelector("#foto").files[0];

		var reader = new FileReader();

		reader.onloadend = function () {
			target.src = reader.result;
		};

		if (file) {
			reader.readAsDataURL(file);

		} else {
			target.src = "";
		}
	}
</script>




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





		//Ajax função Add permissoes
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
// Torna o modal arrastável quando ele for exibido
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

