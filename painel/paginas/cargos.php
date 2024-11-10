<?php 
$pag = 'cargos'; 

if(@$cargos == 'ocultar') {	
	echo '<script>window.location="../index.php"</script>';
	exit();
}

?> 

	<!-- Botão Inserir novo Cargo com a função "inserir()" via "ajax.js" -->
<a onclick="inserir()" type="button" class="btn btn-primary"><span class="fa fa-plus"></span> Cargo</a> 



<li class="dropdown head-dpdn2" style="display: inline-block;">	
		<a href="#" data-toggle="dropdown" class="btn btn-danger dropdown-toggle" id="btn-deletar" style="display:none"><span class="fa fa-trash-o"></span> Deletar</a>

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


 
 
<!-- Modal Form Cargos -->
<div class="modal fade" id="modalForm" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
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
						<div class="col-md-6">							
								<label>Nome</label>
								<input type="text" class="form-control" id="nome" name="nome" placeholder="Nome do Cargo" required>							
						</div>					

						<button type="submit" class="btn btn-primary" style="margin-top:22px">Salvar</button>
					</div>					
					


					<input type="hidden" class="form-control" id="id" name="id">					

				<br>
				<small><div id="mensagem" align="center"></div></small>
			</div>
			
			</form>
		</div>
	</div>
</div>







<!-- Trás uma variavel do Php "$pag" que está la em cima pro javascript "var pag"  ele que vai ligar php com o javascript a variavel página -->
<script type="text/javascript">var pag = "<?=$pag?>"</script>
<script src="js/ajax.js"></script>






