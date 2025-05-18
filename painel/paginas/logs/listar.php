<?php 
@session_start();
$id_usuario = $_SESSION['id'];
 
$nivel_usuario = $_SESSION['nivel']; 
$tabela = 'logs';
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
</style>
<small>
	<table class="table table-hover" id="tabela">
	<thead style="background-color: #303030; color: white;"> 
	<tr>
	<th>Tabela</th>	
	<th>Ação</th> 
	<th class="esc">Data</th>		
	<th class="esc">Hora</th>	
	<th class="esc">Usuário</th>
	<th class="esc">ID Reg</th>	
	<th class="esc">Descrição</th>	
	<th>Ações</th>
	</tr> 
	</thead> 
	<tbody>	
HTML;


for($i=0; $i<$linhas; $i++){
	foreach ($res[$i] as $key => $value){}	
	$id = $res[$i]['id'];
	$tabela = $res[$i]['tabela'];
	$acao= $res[$i]['acao'];
	$data = $res[$i]['data'];
	$hora = $res[$i]['hora'];
	$usuario = $res[$i]['usuario'];
	$id_reg = $res[$i]['id_reg'];
	$descricao = $res[$i]['descricao'];	
	
	
	//Exibindo a data formatada
	$dataF = implode('/', array_reverse(explode('-', $data)));

	

	//Exibindo o nome do Cargo/membro da tabela membros ao inves do numero correspondente
	$query2 = $pdo->query("SELECT * FROM usuarios where id = '$usuario'");
	$res2 = $query2->fetchAll(PDO::FETCH_ASSOC);
	if(@count($res2) > 0){
		$nome_usu = $res2[0]['nome'];
	}else{
		$nome_usu = 'Sem Usuário';
	}


echo <<<HTML
<tr> 
<td>{$tabela}</td>
<td>{$acao}</td>
<td class="esc">{$dataF}</td>
<td class="esc">{$hora}</td>
<td class="esc">{$nome_usu}</td>
<td class="esc">{$id_reg}</td>
<td class="esc">{$descricao}</td>

<td>	  

	<!-- Mostrar Dados --> 
	<big><a href="#" onclick="mostrar('{$id}','{$tabela}','{$acao}','{$dataF}', '{$hora}', '{$nome_usu}','{$id_reg}','{$descricao}')" title="Mostrar Dados"><i class="fa fa-info-circle text-primary"></i></a></big>
</td>
</tr>
HTML;

}

echo <<<HTML
</tbody>

</table>
</small>
HTML;

}else{
	echo '<small>Nenhum Registro Encontrado!</small>';
}
?> 


<!-- Iniciando e Mostrando o Datatables dos membros --> 
<script type="text/javascript">
	$(document).ready( function () {		
	    $('#tabela').DataTable({
	    	
	        "ordering": false,
			"stateSave": true
	    });
	    
	    $('#tabela_filter label input').focus();
	} );
</script>




<!-- Ajax função mostrar -->
<script type="text/javascript">//tem que ser na mesma orderm do mostrar acima
	function mostrar(id, tabela, acao, data, hora, usuario, id_reg, descricao){
				    	
    	$('#titulo_mostrar').text(tabela);    	
    	$('#acao_mostrar').text(acao);
    	$('#data_mostrar').text(data);    	
    	$('#hora_mostrar').text(hora);    	
    	$('#usuario_mostrar').text(usuario);    	
    	$('#id_reg_mostrar').text(id_reg);    	
    	$('#descricao_mostrar').text(descricao);
    	    	

    	$('#modalMostrar').modal('show');
	}
</script>







