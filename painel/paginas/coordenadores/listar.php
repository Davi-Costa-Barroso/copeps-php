<?php 
$tabela = 'corpo_docentes';   
require_once("../../../conexao.php");

$query = $pdo->query("SELECT * from $tabela order by id asc");
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

/* Estilizando os botões de ação */
td .acao-btn {
    display: inline-block; /* Garante que o transform funcione */
    transition: transform 0.3s ease; /* Transição mais perceptível */
    margin-right: 10px; /* Espaço à direita de cada botão */
}

/* Efeito de zoom ao passar o mouse */
td .acao-btn:hover {
    transform: scale(1.9); /* Aumentei para 50% para ser mais visível */
}
</style>
<small>
	<table class="table table-hover" id="tabela">
	<thead style="background-color: #303030; color: white;"> 
	<tr>
	<th>ID</th> 
	<th>Nome</th> 
	<th>E-mail</th>
	<th>Curso</th>
	<th>Situação</th>		
	<th>Ações</th>
	</tr> 
	</thead> 
	<tbody>	
HTML;


for($i=0; $i<$linhas; $i++){
	$id = $res[$i]['id'];
	$nome = $res[$i]['nome'];
	$email = $res[$i]['email'];
	$curso = $res[$i]['curso'];
	$situacao = $res[$i]['situacao'];	

$query2 = $pdo->query("SELECT * from $tabela where nome = '$nome' ");
$res2 = $query2->fetchAll(PDO::FETCH_ASSOC);
$total_acessos = @count($res2);

echo <<<HTML
<tr>
<td>{$id}</td> 
<td>
<input type="checkbox" id="seletor-{$id}" class="form-check-input" onchange="selecionar('{$id}')">
{$nome}
</td>
<td>{$email}</td>
<td>{$curso}</td>
<td>{$situacao}</td>

<td>
	   <!-- Editar -->
	<big><a href="#" onclick="editar('{$id}','{$nome}','{$email}','{$curso}','{$situacao}')" title="Editar Dados" class="acao-btn"><i class="fa fa-edit text-primary"></i></a></big>

	  <!-- Excluir com poup-up -->
	<li class="dropdown head-dpdn2" style="display: inline-block;">
		<a href="#" title="Excluir" class="dropdown-toggle acao-btn" data-toggle="dropdown" aria-expanded="false"><big><i class="fa fa-trash-o text-danger"></i></big></a>


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


<!-- Iniciando e Mostrando o Datatables dos cordenadores --> 
<script type="text/javascript">
	$(document).ready( function () {
	//$('#btn-deletar').hide();	//fica oculto o btn deletar no inicio, + fica com delay ainda	
    $('#tabela').DataTable({
    	"language" : {
            //"url" : '//cdn.datatables.net/plug-ins/1.13.2/i18n/pt-BR.json' 
        },
        "ordering": false,
		"stateSave": true,
		"lengthMenu": [8, 10, 25, 50, 100] // Define as opções, incluindo 8		
    });

} );
</script> 




<!-- Movendo o botoao coordenador --> 
<script>
    $(document).ready(function() {
        $('#tabela').DataTable();  

        const botao = $('.btn-dinamico');
        const posicaoInicial = botao.offset().top; // Posição inicial do botão

        $(window).scroll(function() {
            if ($(window).scrollTop() > posicaoInicial) {
                botao.addClass('btn-fixo'); // Fica fixo ao rolar
            } else {
                botao.removeClass('btn-fixo'); // Volta ao normal
            }
        });
    });

   
</script>


<!-- Movendo o botao deletar --> 
<script>
    $(document).ready(function() {
        $('#tabela').DataTable();  

        const botao2 = $('.btn-dinamico2');
        const posicaoInicial2 = botao2.offset().top; // Posição inicial do botão

        $(window).scroll(function() {
            if ($(window).scrollTop() > posicaoInicial2) {
                botao2.addClass('btn-fixo2'); // Fica fixo ao rolar
            } else {
                botao2.removeClass('btn-fixo2'); // Volta ao normal
            }
        });
    });

   
</script> 



<!-- Ajax função editar -->
<script type="text/javascript"> //tem que ser na mesma orderm do editar acima
	function editar(id, nome, email, curso, situacao){
		 console.log('Valores recebidos: ', { id, nome, email, curso, situacao }); // Adicione isso
		$('#mensagem').text('');
    	$('#titulo_inserir').text('Editar Registro');

    	$('#id').val(id);
    	$('#nome').val(nome);
    	$('#email').val(email);
    	$('#curso').val(curso).change(); //usa o .change() pq e um campo tipo select;
    	$('#situacao').val(situacao);   	

    	$('#modalForm').modal('show');
	}
</script>





<!-- Ajax função limpar campos -->
<script type="text/javascript">
	function limparCampos(){
		$('#id').val('');
    	$('#nome').val('');
    	$('#email').val('');
    	$('#situacao').val('');
    	


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








