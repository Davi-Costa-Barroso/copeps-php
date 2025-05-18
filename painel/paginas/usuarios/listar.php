<?php
require_once("../../../conexao.php");
$tabela = 'usuarios';

@session_start();
$id_usuario = $_SESSION['id'];
 
$nivel_usuario = $_SESSION['nivel'];


//Oculta o editar/exclui/permissao caso não seja o Administrador
if($_SESSION['nivel'] == 'Administrador'){
	$acesso = '';
	$id_usuario = '%%';
}else{
	$acesso = 'ocultar';
	$id_usuario = '%'.$_SESSION['id'].'%';
}



//coloquei: where nivel != 'Administrador'  p/a não aparecer o administrador no listar 
$query = $pdo->query("SELECT * from $tabela where nivel != 'Administrador' order by id desc");
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
    margin-right: 7px; /* Espaço à direita de cada botão */
}

/* Efeito de zoom ao passar o mouse */
td .acao-btn:hover {
    transform: scale(2.1); /* Aumentei para 50% para ser mais visível */
}
</style>
<small>
	<table class="table table-hover" id="tabela">
	<thead style="background-color: #303030; color: white;"> 
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

	$dataF = implode('/', array_reverse(@explode('-', $data)));

	//Mudando o icone e a cor do usuario inativo
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
	
	if($nivel == 'Administrador' ){	//oculta a senha do Administrador	
		$senha = '******';
		$mostrar_adm = 'ocultar';
		 			
	}

	

	if($nivel != 'Administrador'){ //eu que coloquei esse if(oculta a senha demais)
		$senha = '******';
		
	}

	// Verificar se o usuário logado é o dono do registro
	$editar_acesso = 'ocultar'; // Padrão: escondido
	if ($_SESSION['nivel'] == 'Administrador' || $_SESSION['id'] == $id) {
   		 $editar_acesso = ''; // Visível para Administrador ou dono do registro
	}



echo <<<HTML
	<tr style="color:{$classe_ativo}"> 
	<td>
HTML;	
	
	
	// Mostrar o checkbox apenas para Administrador  - EU COLOQUEI ISSOOOOOOOO
        if ($nivel_usuario == 'Administrador') {
            echo "<input type=\"checkbox\" id=\"seletor-{$id}\" class=\"form-check-input\" onchange=\"selecionar('{$id}')\">";
        }

echo <<<HTML


{$nome}
</td>
<td class="esc">{$email}</td>
<td class="esc">{$nivel}</td>
<td class="esc">{$comissao}</td>
<td class="esc">{$matricula}</td>
<td class="esc">
{$telefone}
<a target="_blank" href="https://api.whatsapp.com/send?1=pt_BR&phone=55{$telefone}" title="Chamar no Whatsapp"><i class="fa fa-whatsapp verde"></i></a>
</td>
<td class="esc"><img src="images/perfil/{$foto}" width="25px"></td>
<td>
	   <!-- Editar class=""-->
	<big><a  href="#" onclick="editar('{$id}','{$nome}','{$email}','{$telefone}','{$endereco}','{$nivel}','{$matricula}','{$comissao}')" title="Editar Dados" class="{$editar_acesso} acao-btn"><i class="fa fa-edit text-primary"></i></a></big>

	  <!-- Excluir -->
	<li class="dropdown head-dpdn2" style="display: inline-block;">
		<a href="#" class="dropdown-toggle {$acesso} acao-btn" data-toggle="dropdown" aria-expanded="false"><big><i class="fa fa-trash-o text-danger"></i></big></a>


		<ul class="dropdown-menu" style="margin-left:-230px;">
		<li>
		<div class="notification_desc2">
		<p>Confirmar Exclusão? <a href="#" onclick="excluir('{$id}')"><span class="text-danger">Sim</span></a></p>
		</div>
		</li>										
		</ul>
	</li>

	<!-- Mostrar Dados --> 
	<big><a href="#" onclick="mostrar('{$nome}','{$email}','{$telefone}','{$endereco}','{$ativo}','{$dataF}', '{$senha}', '{$nivel}', '{$matricula}', '{$comissao}', '{$foto}')" title="Mostrar Dados" class="acao-btn"><i class="fa fa-info-circle text-primary"></i></a></big>

	<!-- Ativar -->	
	<big><a class="{$mostrar_adm} {$acesso} acao-btn" href="#" onclick="ativar('{$id}', '{$nome}', '{$acao}')" title="{$titulo_link}"><i class="fa {$icone} text-success"></i></a></big>
     
	<!-- Permissoes -->
	<big><a class="{$mostrar_adm} {$acesso} acao-btn" href="#" onclick="permissoes('{$id}', '{$nome}')" title="Dar Permissões"><i class="fa fa-lock text-primary"></i></a></big>


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



<!-- Script para passar o nível do usuário ao JavaScrip - EU COLOQUEI ISSOOOOOOO -->
<script type="text/javascript">
    var nivelUsuario = '<?php echo $nivel_usuario; ?>';
</script>



<!-- Iniciando e Mostrando o Datatables do usuarios --> 
<script type="text/javascript">
	$(document).ready( function () {
	//$('#btn-deletar').hide();	//fica oculto o btn deletar no inicio, + fica com delay ainda	
    $('#tabela').DataTable({
    	"language" : { //comentei a linha abaixo, pois não estou utilizando o cdn datatables
            //"url" : '//cdn.datatables.net/plug-ins/1.13.2/i18n/pt-BR.json'
        },
        "ordering": false,
		"stateSave": true,
		"lengthMenu": [8, 10, 25, 50, 100] // Define as opções, incluindo 8
    });  

} );
</script> 


<!-- Movendo o botoao usuarios --> 
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


<!-- Movendo o Excluir Selecionados? --> 
<script>
    $(document).ready(function() {
        $('#tabela').DataTable();  

        const botao3 = $('.btn-dinamico3');
        const posicaoInicial3 = botao3.offset().top; // Posição inicial do botão

        $(window).scroll(function() {
            if ($(window).scrollTop() > posicaoInicial3) {
                botao3.addClass('btn-fixo3'); // Fica fixo ao rolar
            } else {
                botao3.removeClass('btn-fixo3'); // Volta ao normal
            }
        });
    });

   
</script>





<!-- Ajax função editar --> 
<script type="text/javascript"> //tem que ser na mesma orderm do editar acima
	function editar(id, nome, email, telefone, endereco, nivel, matricula, comissao){
		$('#mensagem').text('');
    	$('#titulo_inserir').text('Editar Registro');

    	$('#id').val(id);
    	$('#nome').val(nome); //usa .val pq usa o input
    	$('#email').val(email);
    	$('#telefone').val(telefone);
    	$('#endereco').val(endereco);
    	$('#nivel').val(nivel).change(); //usa o .change() pq e um campo tipo select
    	$('#matricula').val(matricula);
    	$('#comissao').val(comissao).change(); //usa o .change() pq e um campo tipo select
    	

    	$('#modalForm').modal('show'); //modal que abre
	}

</script>




<!-- Ajax função mostrar -->
<script type="text/javascript">
	function mostrar(nome, email, telefone, endereco, ativo, data, senha, nivel, matricula, comissao, foto){
		    	
    	$('#titulo_dados').text(nome);  //usa .text pq usa o span
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

		var ids = $('#ids').val(); //var ids, recupera um valor do input que criei em usuarios.php 

		if($('#seletor-'+id).is(":checked") == true){  //checkbox marcado
			var novo_id = ids + id + '-';
			$('#ids').val(novo_id);
		}else{
			var retirar = ids.replace(id + '-', ''); //checkbox desmarcado
			$('#ids').val(retirar);
		}

		var ids_final = $('#ids').val();
		if (ids_final == "" || nivelUsuario !== 'Administrador') {//eu Alteria aquiiiiiiiiiiiiii
			$('#btn-deletar').hide(); //não exibe o botão pois a variavel esta vazia
		}else{
			$('#btn-deletar').show(); // exibe o botão pois a variavel não esta vazia
		}
	}

</script>



<!-- Ajax função deletar os selecionados checkbox e envia p/a excluir.php usuarios -->
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



