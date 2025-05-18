<?php 
require_once("verificar.php");
require_once("../conexao.php");
$pag = 'agenda';
$data_atual = date('Y-m-d'); 
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


<button onclick="inserir()" type="button" class="btn btn-primary btn-flat btn-pri"><i class="fa fa-plus" aria-hidden="true"></i> Nova Tarefa</button>

<input type="hidden" name="data_agenda" id="data_agenda" value="<?php echo date('Y-m-d') ?>"> 



<div class="row" style="margin-top: 15px">

<div class="col-md-4 agile-calendar">
			<div class="calendar-widget">
                                       
				<!-- grids -->
					<div class="agile-calendar-grid">
						<div class="page">
							
							<div class="w3l-calendar-left">
								<div class="calendar-heading">
									
								</div>
								<div class="monthly" id="mycalendar"></div>
							</div>
							
							<div class="clearfix"> </div>
						</div>
					</div>
			</div>
		</div>


<div class="col-xs-12 col-md-8 bs-example widget-shadow" style="padding:10px 5px; margin-top: 0px;" id="listar">
	
</div>
</div>






<!-- Modal Agenda-->
<div class="modal fade" id="modalForm" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
	<div class="modal-dialog" role="document">  
		<div class="modal-content">
			<div class="modal-header">
				<h4 class="modal-title" id="titulo_inserir"></h4>
				<button id="btn-fechar" type="button" class="close" data-dismiss="modal" aria-label="Close" style="margin-top: -20px">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<form method="post" id="form-text"> 
				<div class="modal-body">

					<div class="row">
						<div class="col-md-5">						
							<div class="form-group"> 
								<label>Título <small>(Máx 40 Caracteres)</small></label> 
								<input maxlength="40" type="text" class="form-control" name="titulo" id="titulo" required> 
							</div>						
						</div>

						<div class="col-md-4" id="nasc">						
							<div class="form-group"> 
								<label>Data </label> 
								<input type="date" class="form-control" name="data" id="data-modal"> 
							</div>						
						</div>

										
						<div class="col-md-3" id="nasc">						
							<div class="form-group"> 
								<label>Hora</label> 
								<input type="time" class="form-control" name="hora" id="hora" value="" required> 
							</div>						
						</div>	


					</div>

					
					

					<div class="col-md-12">						
							<div class="form-group"> 
								<label>Descrição <small>(Máx 100 Caracteres)</small></label> 
								<input maxlength="100" type="text" class="form-control" name="descricao" id="descricao">
							</div>						
						</div>


					
					<div class="col-md-12">
						<div class="form-group"> 
							<label>OBS <small>(Max 1000 Caracteres)</small></label> 
							<textarea maxlength="1000" name="area" id="area" class="textarea"> </textarea>
						</div>
					</div>	
					

					<br>
					<input type="hidden" name="id" id="id">
					<input type="hidden" name="usuario" id="usuario"> 
					<small><div id="mensagem" align="center" class="mt-3"></div></small>					

				</div>


				<div class="modal-footer">
					<button type="submit" class="btn btn-primary">Salvar</button>
				</div>



			</form>

		</div>
	</div>
</div>





<!-- ModalMostrar -->
<div class="modal fade" id="modalMostrar" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" >
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h4 class="modal-title" id="tituloModal"><span id="nome_mostrar"> </span> <small>Tarefa : <span id="status_mostrar"> </span></small></h4>
				<button id="btn-fechar-excluir" type="button" class="close" data-dismiss="modal" aria-label="Close" style="margin-top: -20px">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			
			<div class="modal-body">			




				<div class="row" style="border-bottom: 1px solid #cac7c7;">
					<div class="col-md-6">							
						<span><b>Data: </b></span>
						<span id="data_mostrar"></span>							
					</div>
					<div class="col-md-6">							
						<span><b>Hora: </b></span>
						<span id="hora_mostrar"></span>
					</div>
				</div>


				<div class="row" style="border-bottom: 1px solid #cac7c7;">
					<div class="col-md-6">							
						<span><b>Usuário Tarefa: </b></span>
						<span id="usuario_mostrar"></span>							
					</div>
				
				</div>


				<div class="row" style="border-bottom: 1px solid #cac7c7;">
					
					<div class="col-md-12">							
						<span><b>Descrição: </b></span>
						<span id="descricao_mostrar"></span>
					</div>
				</div>


				

				<div class="row" style="border-bottom: 1px solid #cac7c7;">
					<div class="col-md-12">							
						<span><b>Observações: </b></span>
						<div id="obs_mostrar" style="margin-top: 15px"></div>							
					</div>
				</div>
				


			</div>


		</div>
	</div>
</div>









<script type="text/javascript">var pag = "<?=$pag?>"</script>
<script src="js/ajax.js"></script>




<!-- calendar -->
	<script type="text/javascript" src="js/monthly.js"></script>
	<script type="text/javascript">
		$(window).load( function() {

			$('#mycalendar').monthly({
				mode: 'event',
				
			});

			$('#mycalendar2').monthly({
				mode: 'picker',
				target: '#mytarget',
				setWidth: '250px',
				startHidden: true,
				showTrigger: '#mytarget',
				stylePast: true,
				disablePast: true
			});

		switch(window.location.protocol) {
		case 'http:':
		case 'https:':
		// running on a server, should be good.
		break;
		case 'file:':
		alert('Just a heads-up, events will not work when run locally.');
		}

		});
		</script>
	<!-- //calendar --> 



<script type="text/javascript">
	$(document).ready(function() {
		
		$('.sel3').select2({
			
		});
	});
</script>


<script type="text/javascript">
	$(document).ready(function() {
		$('.sel2').select2({
			dropdownParent: $('#modalForm')
		});
	});
</script>







<script>
$("#form-text").submit(function () {
	event.preventDefault();
    nicEditors.findEditor('area').saveContent();
	var formData = new FormData(this);

	$.ajax({
		url: 'paginas/' + pag + "/inserir.php",		
		type: 'POST',
		data: formData,

		success: function (mensagem) {
            $('#mensagem').text('');
            $('#mensagem').removeClass()
            if (mensagem.trim() == "Salvo com Sucesso") {                    
                    $('#btn-fechar').click();
                    listar();
                } else {
                	$('#mensagem').addClass('text-danger')
                    $('#mensagem').text(mensagem)
                }

            },

            cache: false,
            contentType: false,
            processData: false,
            
        });

});
</script>




<!--Listar Ajax -->
<script type="text/javascript">
	function listar(){

	var data = $("#data_agenda").val();	
	$("#data-modal").val(data);


    $.ajax({
    	url: 'paginas/' + pag + "/listar.php",        
        method: 'POST',
        data: {data},
        dataType: "text",

        success:function(result){
            $("#listar").html(result);
        }
    });
}
</script>





<!--Mostrar Ajax -->
<script type="text/javascript">
	function mostrar(id, titulo, descricao, hora, data, usuario, status, obs){

		for (let letra of obs){  				
			if (letra === '*'){
				obs = obs.replace('**', '"');
			}			
		}

				
		$('#nome_mostrar').text(titulo);
		$('#descricao_mostrar').text(descricao);
		$('#hora_mostrar').text(hora);
		$('#data_mostrar').text(data);
		$('#usuario_mostrar').text(usuario);		
		$('#status_mostrar').text(status);		
		
		$("#obs_mostrar").html(obs);
		
		
		$('#modalMostrar').modal('show');		
	}

	function limparCampos(){
		$('#id').val('');
		$('#titulo').val('');		
		$('#descricao').val('');
		$('#hora').val('');				
		$('#data').val('<?=$data_atual?>');	
		nicEditors.findEditor("area").setContent('');	
		
	}
</script>





<script src="//js.nicedit.com/nicEdit-latest.js" type="text/javascript"></script>
<script type="text/javascript">bkLib.onDomLoaded(nicEditors.allTextAreas);</script>


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