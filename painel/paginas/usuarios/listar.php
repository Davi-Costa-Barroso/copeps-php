<?php 
@session_start();
$id_usuario = $_SESSION['id'];
 
$nivel_usuario = $_SESSION['nivel'];
$tabela = 'usuarios';
require_once("../../../conexao.php"); 

$query = $pdo->query("SELECT * from $tabela order by id desc");
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
	$telefone = $res[$i]['telefone'];
	$email = $res[$i]['email'];
	$senha = $res[$i]['senha'];
	$foto = $res[$i]['foto'];
	$nivel = $res[$i]['nivel'];
	$endereco = $res[$i]['endereco'];
	$ativo = $res[$i]['ativo'];
	$data = $res[$i]['data'];
	$matricula = $res[$i]['matricula'];
	$comissao = $res[$i]['comissao'];

	$dataF = implode('/', array_reverse(explode('-', $data)));

	if($ativo == 'Sim'){
		$icone = 'fa-check-square';
		$titulo_link = 'Desativar Usuário';
		$acao = 'Não';
		$classe_ativo = '';
	}else{
		$icone = 'fa-square-o';
		$titulo_link = 'Ativar Usuário';
		$acao = 'Sim';
		$classe_ativo = '#c4c4c4';
	}

	$mostrar_adm = '';
	$flag = ''; 
	
	if($nivel == 'Administrador' ){		
		$senha = '******';
		$mostrar_adm = 'ocultar';
		 			
	}

	if($nivel_usuario == 'Discente'){		
		
		$mostrar_adm = 'ocultar';
		$flag = 'ocultar';	 			
	}

	if($nivel_usuario == 'Docente'){		
		
		$mostrar_adm = 'ocultar';	 			
	}

	if($nivel_usuario == 'Tecnico-Administrativo'){		
		
		$mostrar_adm = 'ocultar';	 			
	}	

	
	

	if($nivel != 'Administrador'){ //eu que coloquei esse if
		$senha = '******';
		
	}

	
	


echo <<<HTML
<tr style="color:{$classe_ativo}"> 
<td>
<input type="checkbox" id="seletor-{$id}" class="form-check-input {$flag}" onchange="selecionar('{$id}')">
{$nome}
</td>
<td class="esc">{$email}</td>
<td class="esc">{$nivel}</td>
<td class="esc">{$comissao}</td>
<td class="esc">{$matricula}</td>
<td class="esc">{$telefone}</td>
<td class="esc"><img src="images/perfil/{$foto}" width="25px"></td>
<td>
	   <!-- Editar -->
	<big><a href="#" onclick="editar('{$id}','{$nome}','{$email}','{$telefone}','{$endereco}','{$nivel}','{$matricula}','{$comissao}')" title="Editar Dados"><i class="fa fa-edit text-primary"></i></a></big>

	  <!-- Excluir -->
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

	<!-- Mostrar Dados --> 
	<big><a href="#" onclick="mostrar('{$nome}','{$email}','{$telefone}','{$endereco}','{$ativo}','{$dataF}', '{$senha}', '{$nivel}', '{$matricula}', '{$comissao}', '{$foto}')" title="Mostrar Dados"><i class="fa fa-info-circle text-primary"></i></a></big>

	<!-- Ativar -->	
	<big><a class="{$mostrar_adm}" href="#" onclick="ativar('{$id}', '{$nome}', '{$acao}')" title="{$titulo_link}"><i class="fa {$icone} text-success"></i></a></big>
     
	<!-- Permissoes -->
	<big><a class="{$mostrar_adm}" href="#" onclick="permissoes('{$id}', '{$nome}')" title="Dar Permissões"><i class="fa fa-lock text-primary"></i></a></big>


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
	function editar(id, nome, email, telefone, endereco, nivel, matricula, comissao){
		$('#mensagem').text('');
    	$('#titulo_inserir').text('Editar Registro');

    	$('#id').val(id);
    	$('#nome').val(nome);
    	$('#email').val(email);
    	$('#telefone').val(telefone);
    	$('#endereco').val(endereco);
    	$('#nivel').val(nivel).change(); //usa o .change() pq e um campo tipo select
    	$('#matricula').val(matricula);
    	$('#comissao').val(comissao).change(); //usa o .change() pq e um campo tipo select
    	

    	$('#modalForm').modal('show');
	}

</script>




<!-- Ajax função mostrar -->
<script type="text/javascript">
	function mostrar(nome, email, telefone, endereco, ativo, data, senha, nivel, matricula, comissao, foto){
		    	
    	$('#titulo_dados').text(nome);
    	$('#email_dados').text(email);
    	$('#telefone_dados').text(telefone);
    	$('#endereco_dados').text(endereco);
    	$('#ativo_dados').text(ativo);
    	$('#data_dados').text(data);
    	$('#senha_dados').text(senha);
    	$('#nivel_dados').text(nivel);
    	$('#matricula_dados').text(matricula);
    	$('#comissao_dados').text(comissao);
    	$('#foto_dados').attr("src", "images/perfil/" + foto);
    	

    	$('#modalDados').modal('show');
	}
</script>




<!-- Ajax função limpar campos -->
<script type="text/javascript">	

	function limparCampos(){
		$('#id').val('');
    	$('#nome').val('');
    	$('#email').val('');
    	$('#telefone').val('');
    	$('#endereco').val('');
    	$('#matricula').val('');
    	


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



