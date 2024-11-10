<?php 
$tabela = 'comissoes';   
require_once("../../../conexao.php");

$query = $pdo->query("SELECT * from $tabela order by id asc");
$res = $query->fetchAll(PDO::FETCH_ASSOC);
$linhas = @count($res);
if($linhas > 0){
echo <<<HTML
<small>
	<table class="table table-hover" id="tabela">
	<thead> 
	<tr>
	<th>ID</th> 
	<th>Nome</th>
	<th>Usuários</th>		
	<th>Ações</th>
	</tr> 
	</thead> 
	<tbody>	
HTML;


for($i=0; $i<$linhas; $i++){
	$id = $res[$i]['id'];
	$nome = $res[$i]['nome']; 	

$query2 = $pdo->query("SELECT * from usuarios where comissao = '$nome' ");
$res2 = $query2->fetchAll(PDO::FETCH_ASSOC);
$total_acessos = @count($res2);

echo <<<HTML
<tr>
<td>{$id}</td> 
<td>
<input type="checkbox" id="seletor-{$id}" class="form-check-input" onchange="selecionar('{$id}')">
{$nome}
</td>
<td class="esc">{$total_acessos}</td>

<td>
	   <!-- Editar -->
	<big><a href="#" onclick="editar('{$id}','{$nome}')" title="Editar Dados"><i class="fa fa-edit text-primary"></i></a></big>

	  <!-- Excluir com poup-up -->
	<li class="dropdown head-dpdn2" style="display: inline-block;">
		<a href="#" class="dropdown-toggle" data-toggle="dropdown" aria-expanded="false"><big><i class="fa fa-trash-o text-danger"></i></big></a>


		<ul class="dropdown-menu" style="margin-left:-230px;">
		<li>
		<div class="notification_desc2">
		<p>Confirmar Exclusão? <a href="#" onclick="excluir('{$id}')"><span class="text-danger">Sim</span></a></p>
		</div>
		</li>										
		</ul>
	</li>
	
	
</td>
</tr>
HTML;

}

echo <<<HTML
</tbody>
<small><div align="center" id="mensagem-excluir"></div></small>
</table>

HTML;

}else{
	echo '<small>Nenhum Registro Encontrado!</small>';
}
?> 


<!-- Iniciando e Mostrando o Datatables do usuarios --> 
<script type="text/javascript">
	$(document).ready( function () {
	//$('#btn-deletar').hide();	//fica oculto o btn deletar no inicio, + fica com delay ainda	
    $('#tabela').DataTable({
    	"language" : {
            //"url" : '//cdn.datatables.net/plug-ins/1.13.2/i18n/pt-BR.json' 
        },
        "ordering": false,
		"stateSave": true
    });
} );
</script>  



<!-- Ajax função editar -->
<script type="text/javascript"> //tem que ser na mesma orderm do editar acima
	function editar(id, nome){
		$('#mensagem').text('');
    	$('#titulo_inserir').text('Editar Registro');

    	$('#id').val(id);
    	$('#nome').val(nome);    	

    	$('#modalForm').modal('show');
	}
</script>





<!-- Ajax função limpar campos -->
<script type="text/javascript">
	function limparCampos(){
		$('#id').val('');
    	$('#nome').val('');
    	


    	$('#ids').val('');
    	$('#btn-deletar').hide();	
	}
</script>



<!-- Ajax função selecionar campos input pelo checkbox -->
<script type="text/javascript"> 
	function selecionar(id){

		var ids = $('#ids').val();

		if($('#seletor-'+id).is(":checked") == true){  //checkbox marcado
			var novo_id = ids + id + '-';
			$('#ids').val(novo_id);
		}else{
			var retirar = ids.replace(id + '-', ''); //checkbox desmarcado
			$('#ids').val(retirar);
		}

		var ids_final = $('#ids').val();
		if(ids_final == ""){
			$('#btn-deletar').hide(); //não exibe o botão pois a variavel esta vazia
		}else{
			$('#btn-deletar').show(); // exibe o botão pois a variavel não esta vazia
		}
	}
</script>



<!-- Ajax função excluir os selecionados checkbox e envia p/a excluir.php usuarios -->
<script type="text/javascript">
	
		function deletarSel(){
		var ids = $('#ids').val();
		var id = ids.split("-");
		
		for(i=0; i<id.length-1; i++){
			excluir(id[i]);			
		}

		limparCampos();
	}
	
</script>







