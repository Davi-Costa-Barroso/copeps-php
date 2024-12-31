<?php 
@session_start();
$id_usuario = $_SESSION['id'];
 
$nivel_usuario = $_SESSION['nivel']; 
require_once("../../../conexao.php");

$query = $pdo->query("SELECT * from pareceres");
$res = $query->fetchAll(PDO::FETCH_ASSOC);
$linhas = @count($res);
if($linhas > 0){
echo <<<HTML
<small>
	<table class="table table-hover" id="tabela">
	<thead> 
	<tr> 
	<th>titulo</th>		
	<th class="esc">Nº parecer</th>
	<th class="esc">Ano</th>	
	<th class="esc">Nº Oficio</th>
	<th class="esc">Item oficio</th>
	<th class="esc">Data envio</th>
	<th class="esc">Coordenador</th>
	<th class="esc">Relator</th>	
	<th>Ações</th>
	</tr> 
	</thead> 
	<tbody>	
HTML;



for($i=0; $i<$linhas; $i++){
	$id = $res[$i]['id'];

	// Dados Iniciais
	$numeroParecer = $res[$i]['numeroParecer'];
	$ano = $res[$i]['ano'];
	$numeroOficio = $res[$i]['numeroOficio'];
	$itemOficio = $res[$i]['itemOficio'];
	$dataEnvio = $res[$i]['dataEnvio'];
	$textoAnalisado = $res[$i]['textoAnalise'];
	$tituloProjeto = $res[$i]['tituloProjeto'];
	$documentosEnviados = $res[$i]['documEnviados'];
	// Dados documento
	$TIPODOCUMENTO = $res[$i]['TIPODOCUMENTO'];
	$cargaHoraria = $res[$i]['cargaHoraria'];
	$periodoProjeto = $res[$i]['periodoProjeto'];
	$nomeRelatorio = $res[$i]['nomeRelatorio'];
	// Dados coordenador	
	$nomeCoordenador = $res[$i]['nomeCoordenador'];
	$sexoCoordenador = $res[$i]['sexoCoordenador'];
	$titulacaoCoordenador = $res[$i]['titulacaoCoordenador'];
	$faculdadeCoordenador = $res[$i]['faculdadeCoordenador'];
	$possuiOutroCoordenador = $res[$i]['possuiOutroCoordenador'];
	$nomeViceCoordenador = $res[$i]['nomeViceCoordenador'];
	$sexoViceCoordenador = $res[$i]['sexoViceCoordenador'];
	$titulacaoViceCoordenador = $res[$i]['titulacaoViceCoordenador'];
	// Dados Relator
	$descricaoProposta = $res[$i]['descricaoProposta'];
	$nomeRelator = $res[$i]['nomeRelator'];
	$sexoRelator = $res[$i]['sexoRelator'];
	$aprovacaoFaculdade = $res[$i]['aprovacaoFaculdade'];
	$dataAprovacao = $res[$i]['dataAprovacao'];
	$numeroDocumento = $res[$i]['numeroDocumento'];
	$justificativa = $res[$i]['justificativa'];
	$comentariosParecer = $res[$i]['comentariosParecer'];
	$parecerRelator = $res[$i]['parecerRelator'];
	
	//Exibindo a data formatada
	$dataF = implode('/', array_reverse(explode('-', $dataEnvio)));


echo <<<HTML
<tr> 
<td>
	<input type="checkbox" id="seletor-{$id}" class="form-check-input" onchange="selecionar('{$id}')">
	{$tituloProjeto}
</td>
<td>
	{$numeroParecer}
</td>
<td>
	{$ano}
</td>
<td>
	{$numeroOficio}
</td>
<td>
	{$itemOficio}
</td>
<td>
	{$dataF}
</td>
<td>
	{$nomeCoordenador}
</td>
<td>
	{$nomeRelator}
</td>
<td>
	   <!-- Editar -->
	<big>
	<a 
		href="#" 
		onclick="editar('{$id}', '{$numeroParecer}', '{$ano}', '{$numeroOficio}', '{$itemOficio}', '{$dataEnvio}', '{$tituloProjeto}', '{$nomeCoordenador}', '{$nomeRelator}', '{$documentosEnviados}', '{$textoAnalisado}', '{$TIPODOCUMENTO}', '{$cargaHoraria}', '{$periodoProjeto}','{$nomeRelatorio}' ,'{$sexoCoordenador}', '{$titulacaoCoordenador}', '{$faculdadeCoordenador}', '{$descricaoProposta}', '{$sexoRelator}', '{$possuiOutroCoordenador}', '{$nomeViceCoordenador}', '{$sexoViceCoordenador}', '{$titulacaoViceCoordenador}', '{$aprovacaoFaculdade}', '{$dataAprovacao}', '{$numeroDocumento}', '{$comentariosParecer}', '{$justificativa}', '{$parecerRelator}')" 
		title="Editar Dados"
	>
			<i class="fa fa-edit text-primary">
			</i>
		</a>
	</big>


	  <!-- Excluir -->
	<li class="dropdown head-dpdn2" style="display: inline-block;">
		<a href="#" class="dropdown-toggle" data-toggle="dropdown" aria-expanded="false"><big><i class="fa fa-trash-o text-danger"></i></big></a>


		<ul class="dropdown-menu" style="margin-left:-230px;">
		<li>
		<div class="notification_desc2">
		<p>Confirmar Exclusão? <a href="#" onclick="excluirParecer('{$id}')"><span class="text-danger">Sim</span></a></p>
				
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

	function popularSelect(select, paraComparar){
		const campoSelect = document.getElementById(select)
		const options = campoSelect.getElementsByTagName('option');

		for (let i = 0; i < options.length; i++) {
			const option = options[i];
			if (option.textContent.trim() === paraComparar) {
				campoSelect.value = option.value;
				$(campoSelect).trigger('change'); 
				break;
			}
		}
	}

	async function editar(
		id, 
		numeroParecer, 
		ano, 
		numeroOficio, 
		itemOficio, 
		dataEnvio, 
		tituloProjeto, 
		nomeCoordenador, 
		nomeRelator, 
		documentosEnviados, 
		textoAnalisado, 
		TIPODOCUMENTO, 
		cargaHoraria, 
		periodoProjeto, 
		nomeRelatorio,
		sexoCoordenador, 
		titulacaoCoordenador, 
		faculdadeCoordenador, 
		descricaoProposta, 
		sexoRelator, 
		possuiOutroCoordenador,
		nomeViceCoordenador,
		sexoViceCoordenador,
		titulacaoViceCoordenador,
		aprovacaoFaculdade,
		dataAprovacao,
		numeroDocumento,
		comentariosParecer,
		justificativa,
		parecerRelator
	) {
		limparCamposParecer();
		// falta preencher documentosEnviados
		$('#mensagem').text('');
    	$('#titulo_inserir').text('Editar Registro');
		$('#id_dados').val(id);

		// Dados Iniciais
		$('#numeroParecer').val(numeroParecer);
		$('#ano').val(ano);
		$('#numeroOficio').val(numeroOficio);
		$('#item_field').val(itemOficio);
		$('#data').val(dataEnvio);
		$('#obs1').val(textoAnalisado);
		$('#obs2').val(tituloProjeto);

		let documentosArray = documentosEnviados.split(';'); // Divide os documentos em um array
		let indice = 1;

		for (let i = 0; i < documentosArray.length; i++) {
			let doc = documentosArray[i].trim();
			let textoSemParenteses = doc.replace(/\([^\)]*\)/g, '').trim();

			if (textoSemParenteses.includes(' e ')) {
				let partes = textoSemParenteses.split(' e '); // Divide no 'e'
				for(let j=0;j<partes.length;j++){
					const item = partes[j].trim()
					$(`#doc${indice}`).val(item);
					indice++;
					addInput()
				}
			} else {
				$(`#doc${indice}`).val(textoSemParenteses);
				addInput()
			}
		}

		// dados documento
		$('input[name="tipo-desenvolvimento"][value="' + TIPODOCUMENTO + '"]').prop('checked', true);
		mudarRelatorio();

		let elemento_relatorio = document.getElementById('listar_relatorios');
		let observer = new MutationObserver(() => {
			let elementoFilho = elemento_relatorio.querySelector('#tipo');
			if (elementoFilho) {
				// Percorre todas as opções e seleciona a que corresponde ao nomeRelatorio
				let opcoes = elementoFilho.options;
				for (let i = 0; i < opcoes.length; i++) {
					if (opcoes[i].text === nomeRelatorio) {
						elementoFilho.value = opcoes[i].value;  // Define o valor do select
						break;
					}
				}
				observer.disconnect();  // Para de observar após encontrar
			}
		});
		observer.observe(elemento_relatorio, { childList: true, subtree: true });

		$('#tipo-carga').val(cargaHoraria)
		if (cargaHoraria !== 'desabilitado') {
			$('#tipo-sim').prop('checked', true); 
		} else {
			$('#tipo-nao').prop('checked', true);
		}
		mudarCarga();

		let elemento_carga = document.getElementById('listar_cargas_container');
		let observer_carga = new MutationObserver(() => {
			let elemento_tipo_carga = elemento_carga.querySelector('#tipo-carga');
			if (elemento_tipo_carga) {
			// 	// Percorre todas as opções e seleciona a que corresponde a cargaHoraria
				let opcoes = elemento_tipo_carga.options;
				for (let i = 0; i < opcoes.length; i++) {
					if (opcoes[i].text === cargaHoraria) {
						elemento_tipo_carga.value = opcoes[i].value;  // Define o valor do select
						const opcao_simc_naoc = $('input[name="tipo-carga"]:checked').val();
						mostrarBlocosRequisitos(opcao_simc_naoc, cargaHoraria);
						break;
					}
				}
				observer_carga.disconnect();  // Para de observar após encontrar
			}
		});
		observer_carga.observe(elemento_carga, { childList: true, subtree: true });

		$('#mesesSelect').val(periodoProjeto);
		// dados coordenador
		$('#nome_coordenador').val(nomeCoordenador);
		$('#sexoCoordenador').val(sexoCoordenador);

		atualizarOpcoesTitulacaoCoordenador();
	
		popularSelect("titulacaoCoordenador", titulacaoCoordenador);
		
		$('#faculdadeCoordenador').val(faculdadeCoordenador);
		if (possuiOutroCoordenador === "sim") {
			$('#possui-outro-sim').prop('checked', true); 
			outroCordenador();
			
			$('#nomeOutroCoordenador').val(nomeViceCoordenador);
			$('#sexoOutroCoordenador').val(sexoViceCoordenador);
			atualizarOpcoesTitulacaoOutroCoordenador();
			popularSelect("titulacaoOutroCoordenador", titulacaoViceCoordenador);
		} else {
			$('#possui-outro-nao').prop('checked', true);
		}
		

		// Dados relator
		popularSelect("nomeRelator", nomeRelator);
		$('#sexoRelator').val(sexoRelator);
		$('#aprovacaoFaculdade').val(aprovacaoFaculdade);
		$('#qualDia').val(dataAprovacao);
		$('#numeroDocumento').val(numeroDocumento);
		$('#obs4').val(descricaoProposta);
		$('#obs5').val(justificativa);
		$('#obs6').val(comentariosParecer);
    	$('input[name="parecerRelator"][value="' + parecerRelator + '"]').prop('checked', true);

    	$('#modalForm').modal('show');
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

	function excluirParecer(id){
		$.ajax({
			url: '/loginusuario/painel/paginas/excluirParecer.php',
			type: 'POST',
			data: {id},
		});
		location.reload(); 
	}

</script>



<!-- Ajax função excluir os selecionados checkbox e envia p/a excluir.php usuarios -->
<script type="text/javascript">
	
		function deletarSel(){
		var ids = $('#ids').val();
		var id = ids.split("-");
		
		for(i=0; i<id.length-1; i++){
			excluirParecer(id[i]);			
		}
	}
	
</script>

<!-- Ajax função limpar campos -->
<script type="text/javascript">	
	function limparCamposParecer(){
		$('#id_dados').val('');
		// dados inciais
		$('#numeroParecer').val('');
		$('#ano').val(new Date().getFullYear());
		$('#numeroOficio').val('');
		$('#item_field').val('1');
		$('#data').val('');
		$('#obs1').val('');
		$('#obs2').val('');
		let i = 1;
		while ($('#doc' + i).length) {
			$('#doc' + i).val('');
			i++;
		}
		const container = document.getElementById("input-container");
		const inputs = container.getElementsByTagName("input");
		for (let i = inputs.length - 1; i > 0; i--) inputs[i].remove();
		// dados documentos
		$('#listar_cargas_container').html('');
		$('#listar_relatorios').html('');
		$('input[name="tipo-desenvolvimento"]').prop('checked', false);
		$('#bloco_pesquisa').hide();
		$('#bloco_ensino').hide();
		$('#bloco_extensao').hide();
		$('#tipo-sim').prop('checked', false); 
		$('#tipo-nao').prop('checked', false);
		$('#mesesSelect').val('3 (Três) meses');
		// dados coordenador
		$('#nome_coordenador').val('');
		$('#sexoCoordenador').val('');
		$('#faculdadeCoordenador').val('');
		$('#titulacaoCoordenador').val('');
		$('#nomeOutroCoordenador').val('');
		$('#sexoOutroCoordenador').val('');
		$('#titulacaoOutroCoordenador').val('');
		$('#possui-outro-nao').prop('checked', false);
		$('#possui-outro-sim').prop('checked', false); 
		atualizarOpcoesTitulacaoCoordenador();
		atualizarOpcoesTitulacaoOutroCoordenador();
		outroCordenador();
		// dados relator
		$('#nomeRelator').val('');	// nomeRelator precisa resetar o campo com val e com o change
		$('#nomeRelator').change();
		$('#sexoRelator').val('');
		$('#aprovacaoFaculdade').val('');
		$('#qualDia').val('');
		$('#numeroDocumento').val('');
		$('#obs4').val('');
		$('#obs5').val('');
		$('#obs6').val('');
		$('input[name="parecerRelator"]').prop('checked', false);

	}
	
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
		
		limparCamposParecer();

    	$('#ids').val('');
    	$('#btn-deletar').hide();	
	}
</script>