<?php 
@session_start();
$id_usuario = $_SESSION['id'];
 
$nivel_usuario = $_SESSION['nivel']; 
require_once("../../../conexao.php");

$query = $pdo->query("SELECT * from membros where comissao = 1 order by id desc");
$res = $query->fetchAll(PDO::FETCH_ASSOC);
$linhas = @count($res);
if($linhas > 0){
echo <<<HTML
<small>
	<table class="table table-hover" id="tabela">
	<thead> 
	<tr> 
	<th>Nome</th>		
	<th class="esc">Email</th>
	<th class="esc">Nível</th>	
	<th class="esc">Tipo de Membro</th>
	<th class="esc">Comissão</th>
	<th class="esc">Matrícula</th>
	<th class="esc">Telefone</th>	
	<th class="esc">Foto</th>	
	<th>Ações</th>
	</tr> 
	</thead> 
	<tbody>	
HTML;



for($i=0; $i<$linhas; $i++){
	$id = $res[$i]['id'];
	$nome = $res[$i]['nome'];
	$cpf = $res[$i]['cpf'];
	$telefone = $res[$i]['telefone'];
	$email = $res[$i]['email'];	
	$foto = $res[$i]['foto'];
	$cargo = $res[$i]['cargo']; //chave estrangeira que guarda id da tabela cargo
	$tipo_membro = $res[$i]['tipo_membro'];
	$comissao = $res[$i]['comissao'];
	$endereco = $res[$i]['endereco'];
	$cidade = $res[$i]['cidade'];
	$estado = $res[$i]['estado'];
	$pais = $res[$i]['pais'];
	$ativo = $res[$i]['ativo'];
	$data = $res[$i]['data'];
	$matricula = $res[$i]['matricula'];
	$obs = $res[$i]['obs'];


	//retirar quebra de texto do obs
	$obs = str_replace(array("\n", "\r"), ' + ', $obs);

	//Exibindo a data formatada
	$dataF = implode('/', array_reverse(explode('-', $data)));

	//$nome_cargo = "";
	//$nome_comissao = "";

	//Exibindo o nome do Cargo/membro da tabela membros ao inves do numero correspondente
	$query2 = $pdo->query("SELECT * FROM cargos where id = '$cargo'");
	$res2 = $query2->fetchAll(PDO::FETCH_ASSOC);
	if(@count($res2) > 0){
		$nome_cargo = $res2[0]['nome'];
	}else{
		$nome_cargo = 'Sem Cargo';
	}


	//Exibindo o nome da Comissao da tabela comissoes ao inves do numero correspondente
	$query3 = $pdo->query("SELECT * FROM comissoes where id = '$comissao'");
	$res3 = $query3->fetchAll(PDO::FETCH_ASSOC);
	if(@count($res3) > 0){
		$nome_comissao = $res3[0]['nome'];
	}else{
		$nome_comissao = 'Sem comissao';
	}

		


echo <<<HTML
<tr> 
<td>
<input type="checkbox" id="seletor-{$id}" class="form-check-input" onchange="selecionar('{$id}')">
{$nome}
</td>
<td class="esc">{$email}</td>
<td class="esc">{$nome_cargo}</td>
<td class="esc">{$tipo_membro}</td>
<td class="esc">{$nome_comissao}</td>
<td class="esc">{$matricula}</td>
<td class="esc">{$telefone}</td>
<td class="esc"><img src="images/perfil/{$foto}" width="25px"></td>
<td>
	   <!-- Editar -->
	<big><a href="#" onclick="editar('{$id}','{$nome}','{$cpf}','{$telefone}','{$email}', '{$cargo}', '{$comissao}','{$endereco}','{$cidade}', '{$estado}','{$pais}','{$matricula}','{$obs}', '{$foto}')" title="Editar Dados"><i class="fa fa-edit text-primary"></i></a></big>


	  <!-- Excluir -->
	<li class="dropdown head-dpdn2" style="display: inline-block;">
		<a href="#" class="dropdown-toggle" data-toggle="dropdown" aria-expanded="false"><big><i class="fa fa-trash-o text-danger"></i></big></a>


		<ul class="dropdown-menu" style="margin-left:-230px;">
		<li>
		<div class="notification_desc2">
		<p>Confirmar Exclusão? <a href="#" onclick="excluir('{$id}','{$nome}')"><span class="text-danger">Sim</span></a></p>
				
		</div>
		</li>										
		</ul>
	</li>

	<!-- Mostrar Dados --> 
	<big><a href="#" onclick="mostrar('{$nome}','{$cpf}','{$telefone}','{$email}', '{$nome_cargo}', '{$nome_comissao}', '{$tipo_membro}', '{$ativo}','{$dataF}','{$endereco}','{$cidade}', '{$estado}','{$pais}','{$matricula}','{$obs}', '{$foto}')" title="Mostrar Dados"><i class="fa fa-info-circle text-primary"></i></a></big>	


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


<!-- Iniciando e Mostrando o Datatables dos membros --> 
<script type="text/javascript">
	$(document).ready( function () {
	$('#btn-deletar').hide();	//fica oculto o btn deletar no inicio, + fica com delay ainda	
    $('#tabela').DataTable({
    	"language" : {
            //"url" : '//cdn.datatables.net/plug-ins/1.13.2/i18n/pt-BR.json'
        },
        "ordering": false,
		"stateSave": true
    });

    // In your Javascript - inicializao select2	
    $('.sel').select2({
    	dropdownParent: $('#modalForm')
    });

} );
</script>  



<!-- Ajax função editar --> 
<script type="text/javascript"> //tem que ser na mesma orderm do editar acima
	function editar(id, nome, cpf, telefone, email, cargo, comissao, endereco, cidade, estado, pais, matricula, obs, foto){

		for(let letra of obs){  				
			if (letra === '+'){
				obs = obs.replace(' +  + ', '\n')
			}			
		}

		$('#mensagem').text('');
    	$('#titulo_inserir').text('Editar Registro');

    	$('#id').val(id);
    	$('#nome').val(nome);
    	$('#cpf').val(cpf);
    	$('#telefone').val(telefone);
    	$('#email').val(email);
    	$('#cargo').val(cargo).change();//usa o .change() pq e um campo tipo select;
    	$('#comissao').val(comissao).change();//usa o .change() pq e um campo tipo select;
    	$('#endereco').val(endereco);
    	$('#cidade').val(cidade);
    	$('#estado').val(estado);
    	$('#pais').val(pais);
    	$('#matricula').val(matricula);    	
    	$("#matricula ").attr("readonly", true); 
    	$('#obs').val(obs);    	
    	$('#foto').val('');
		$('#target').attr('src','images/perfil/' + foto);    	
    	
		
    	$('#modalForm').modal('show');
    	
	}

</script>




<!-- Ajax função mostrar -->
<script type="text/javascript">//tem que ser na mesma orderm do mostrar acima
	function mostrar(nome, cpf, telefone, email, cargo, comissao, tipoMembro, ativo, data, endereco, cidade, estado, pais, matricula, obs, foto){

		for(let letra of obs){  				
			if (letra === '+'){
				obs = obs.replace(' +  + ', '\n')
			}			
		}
		    	
    	$('#titulo_dados').text(nome);    	
    	$('#cpf_dados').text(cpf);
    	$('#telefone_dados').text(telefone);
    	$('#email_dados').text(email);
    	$('#cargo_dados').text(cargo);
		$('#tipo_membro').text(tipoMembro);
		$('#comissao_dados').text(comissao);
    	$('#ativo_dados').text(ativo);
    	$('#data_dados').text(data);
    	$('#endereco_dados').text(endereco);
    	$('#cidade_dados').text(cidade);
    	$('#estado_dados').text(estado);
    	$('#pais_dados').text(pais);
    	$('#matricula_dados').text(matricula);
    	$('#obs_dados').text(obs);
    	$('#foto_dados').attr("src", "images/perfil/" + foto);
    	

    	$('#modalDados').modal('show');
	}
</script>


<!-- Ajax função limpar campos -->
<script type="text/javascript">	

	function limparCampos(){
		$('#id').val('');
    	$('#nome').val('');
    	$('#cpf').val('');
    	$('#telefone').val('');
    	$('#email').val('');
    	$('#cargo').val('').change();
    	$('#comissao').val('').change();
    	$('#endereco').val('');
    	$('#cidade').val('');
    	$('#estado').val('');
    	$('#pais').val('');
    	$('#matricula').val('');
    	$("#matricula ").attr("readonly", false);    	
    	$('#obs').val('');
    	$('#foto').val('');
    	$('#target').attr('src','images/perfil/sem-foto.jpg');


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




<!-- Ajax função permissoes campos -->
<script type="text/javascript">	

	function permissoes(id, nome){
		    	
    	$('#id_permissoes').val(id);
    	$('#nome_permissoes').text(nome);    	

    	$('#modalPermissoes').modal('show');
    	listarPermissoes(id);
	}
	
</script>



