<?php 
$tabela = 'acessos';
require_once("../../../conexao.php");

$query = $pdo->query("SELECT * from $tabela order by id desc");
$res = $query->fetchAll(PDO::FETCH_ASSOC);
$linhas = @count($res);
if($linhas > 0){
echo <<<HTML
<style type="text/css">
.dataTables_length {
    margin-bottom: 1rem; /* Espaço abaixo do "Mostrar registros" */
}

.dataTables_filter {
    margin-bottom: 1rem; /* Espaço abaixo do "Buscar" */
}

/* Se quiser alinhar melhor */
.dataTables_wrapper .row {
    margin-bottom: 1rem;
}

.dataTables_wrapper {
    position: relative;
    max-height: 522px; /* Ajuste conforme necessário */
    overflow-y: auto;
}

/* Fixando o cabeçalho */
thead th {
    position: sticky;
    top: 0;
    z-index: 10;
    background-color: #303030;
    color: white;
    width: auto;
}
</style>
<small>
	<table class="table table-hover" id="tabela">
	<thead style="background-color: #303030; color: white;"> 
	<tr>
	<th>Nome</th>	
	<th>Chave</th>	
	<th>Grupo</th>
	<th>Página</th>
	<th>Ações</th>
	</tr> 
	</thead> 
	<tbody>	
HTML;


for($i=0; $i<$linhas; $i++){
	$id = $res[$i]['id'];
	$nome = $res[$i]['nome'];
	$grupo = $res[$i]['grupo'];
	$chave = $res[$i]['chave'];
	$pagina = $res[$i]['pagina'];

$query2 = $pdo->query("SELECT * from grupo_acessos where id = '$grupo' ");
$res2 = $query2->fetchAll(PDO::FETCH_ASSOC);
if(@count($res2) > 0){
	$nome_grupo = $res2[0]['nome'];
}else{
	$nome_grupo = 'Sem Grupo';
}

		
echo <<<HTML
<tr>
<td>
<input type="checkbox" id="seletor-{$id}" class="form-check-input" onchange="selecionar('{$id}')">
{$nome}
</td>
<td class="esc">{$chave}</td>
<td class="esc">{$nome_grupo}</td>
<td class="esc">{$pagina}</td>

<td>
	<big><a href="#" onclick="editar('{$id}','{$nome}','{$chave}','{$grupo}','{$pagina}')" title="Editar Dados"><i class="fa fa-edit text-primary"></i></a></big>

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


<!-- Iniciando e Mostrando o Datatables do acessos --> 
<script type="text/javascript">
	$(document).ready( function () {		
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
<script type="text/javascript">//tem que ser na mesma orderm do editar acima
	function editar(id, nome, chave, grupo, pagina){
		$('#mensagem').text('');
    	$('#titulo_inserir').text('Editar Registro');

    	$('#id').val(id);
    	$('#nome').val(nome);
    	$('#chave').val(chave);
    	$('#grupo').val(grupo).change(); //usa o .change() pq e um campo tipo select
    	$('#pagina').val(pagina).change(); //usa o .change() pq e um campo tipo select
    
    	$('#modalForm').modal('show');
	}


	// Ajax função limpar campos 
	function limparCampos(){
		$('#id').val('');
    	$('#nome').val('');
    	$('#chave').val('');
    	$('#grupo').val('0').change();

    	$('#ids').val('');
    	$('#btn-deletar').hide();	
	}


	//Ajax função selecionar campos input pelo checkbox
	function selecionar(id){

		var ids = $('#ids').val();

		if($('#seletor-'+id).is(":checked") == true){
			var novo_id = ids + id + '-';
			$('#ids').val(novo_id);
		}else{
			var retirar = ids.replace(id + '-', '');
			$('#ids').val(retirar);
		}

		var ids_final = $('#ids').val();
		if(ids_final == ""){
			$('#btn-deletar').hide();
		}else{
			$('#btn-deletar').show();
		}
	}

	function deletarSel(){
		var ids = $('#ids').val();
		var id = ids.split("-");
		
		for(i=0; i<id.length-1; i++){
			excluir(id[i]);			
		}

		limparCampos();
	}
</script>