<?php 
$pag = 'logs';

if(@$membros == 'ocultar') {	
	echo '<script>window.location="../index.php"</script>';
	exit();
}

?> 




<div class="bs-example widget-shadow" style="padding:15px" id="listar">

</div> 




<!-- Modal Exibir Dados Membros-->
<div class="modal fade" id="modalMostrar" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<h4 class="modal-title" id="exampleModalLabel">Tabela de: <span id="titulo_mostrar"></span></h4>
				<button id="btn-fechar-dados" type="button" class="close" data-dismiss="modal" aria-label="Close" style="margin-top: -25px">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			
			<div class="modal-body">
				<div class="row" style="border-bottom: 1px solid #cac7c7;">
						<div class="col-md-6">							
							<span><b>Ação: </b></span>
							<span id="acao_mostrar"></span>							
						</div>
						<div class="col-md-6">							
							<span><b>Data: </b></span>
							<span id="data_mostrar"></span>
						</div>
					</div>


					<div class="row" style="border-bottom: 1px solid #cac7c7;">
						<div class="col-md-6">							
							<span><b>Hora: </b></span>
							<span id="hora_mostrar"></span>							
						</div>
						<div class="col-md-6">							
							<span><b>Usuário: </b></span>
							<span id="usuario_mostrar"></span>
						</div>
					</div>


					<div class="row" style="border-bottom: 1px solid #cac7c7;">
						<div class="col-md-6">							
							<span><b>Id do Registro: </b></span>
							<span id="id_reg_mostrar"></span>							
						</div>
						<div class="col-md-6">							
							<span><b>Descrição: </b></span>
							<span id="descricao_mostrar"></span>
						</div>
					</div>
					
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

</script>


<script type="text/javascript">
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

