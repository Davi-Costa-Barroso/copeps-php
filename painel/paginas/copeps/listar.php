<?php 
@session_start();
$id_usuario = $_SESSION['id'];
 
$nivel_usuario = $_SESSION['nivel']; 
require_once("../../../conexao.php");

// Depuração: exibir valores da sessão EU COLOQUEI
//echo "<pre>Usuário logado: ID = $id_usuario, Nível = $nivel_usuario</pre>";

// Define o acesso geral (não afeta $id_usuario)
$acesso = ($nivel_usuario == 'Administrador') ? '' : 'ocultar';




// Modifica a query para incluir o nome do usuário com JOIN e ordenar por ID descendente
$query = $pdo->query("SELECT p.*, u.nome AS nome_usuario 
                      FROM pareceres p 
                      LEFT JOIN usuarios u ON p.id_usuario = u.id ORDER BY p.id DESC");
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
    margin-right: 8px; /* Espaço à direita de cada botão */
}

/* Efeito de zoom ao passar o mouse */
td .acao-btn:hover {
    transform: scale(2.1); /* Aumentei para 50% para ser mais visível */
}

.ocultar { display: none !important;} /* Garantir que ocultar funciona */
</style>
<small>
	<table class="table table-hover" id="tabela">
	<thead style="background-color: #303030; color: white;"> 
	<tr>	 
	<th>titulo</th>
	<th class="esc">Criado Por</th> <!-- Nova coluna EU COLOQUEI ISSOOO-->		
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
	$data = $res[$i]['data'];
	$id = $res[$i]['id'];
	$id_usuario_registro = $res[$i]['id_usuario']; // Campo que referencia o usuário que criou o parecer // Eu coloquei isso aqui e coloquei no bd
	//$nome_usuario = $res[$i]['nome_usuario']; // Nome do usuário que criou o parecer
	$nome_usuario = $res[$i]['nome_usuario'] ?? 'Desconhecido'; // Aqui é o lugar!

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
	$dataF = implode('/', array_reverse(@explode('-', $dataEnvio)));

	// Depuração: exibir valores para comparação  - EU COLOQUEI ISOOOOOOOOOOOOOOOOOOOOOOOO
      //   echo "<pre>ID Registro: $id, ID Usuário Registro: $id_usuario_registro</pre>";

        
    // Controle do botão "Editar" (permanece como estava)
    $editar_acesso = 'ocultar';
        if ($nivel_usuario == 'Administrador' || (int)$id_usuario === (int)$id_usuario_registro) {
            $editar_acesso = '';
            //echo "<pre>Botão visível para ID $id (Admin ou dono)</pre>";
        }


    // Controle do botão "Excluir" (apenas para Administrador)
        $excluir_acesso = 'ocultar';
        if ($nivel_usuario == 'Administrador') {
            $excluir_acesso = '';
        }

echo <<<HTML
	<tr> 
	<td>
HTML;

	// Mostrar o checkbox apenas para Administrador  - EU COLOQUEI ISSOOOOOOOO
        if ($nivel_usuario == 'Administrador') {
            echo "<input type=\"checkbox\" id=\"seletor-{$id}\" class=\"form-check-input\" onchange=\"selecionar('{$id}')\">";
        }

echo <<<HTML

	
	{$tituloProjeto}
</td>
<td>{$nome_usuario}</td> <!-- Exibe o nome do usuário -->
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
		onclick="editar('editar','{$data}', '{$id}', '{$numeroParecer}', '{$ano}', '{$numeroOficio}', '{$itemOficio}', '{$dataEnvio}', '{$tituloProjeto}', '{$nomeCoordenador}', '{$nomeRelator}', '{$documentosEnviados}', '{$textoAnalisado}', '{$TIPODOCUMENTO}', '{$cargaHoraria}', '{$periodoProjeto}','{$nomeRelatorio}' ,'{$sexoCoordenador}', '{$titulacaoCoordenador}', '{$faculdadeCoordenador}', '{$descricaoProposta}', '{$sexoRelator}', '{$possuiOutroCoordenador}', '{$nomeViceCoordenador}', '{$sexoViceCoordenador}', '{$titulacaoViceCoordenador}', '{$aprovacaoFaculdade}', '{$dataAprovacao}', '{$numeroDocumento}', '{$comentariosParecer}', '{$justificativa}', '{$parecerRelator}')" 
		title="Editar Dados" class="{$editar_acesso} acao-btn"
	>
			<i class="fa fa-edit text-primary">
			</i>
		</a>
	

	<a 
		href="#" 
		onclick="editar('baixar','{$data}','{$id}', '{$numeroParecer}', '{$ano}', '{$numeroOficio}', '{$itemOficio}', '{$dataEnvio}', '{$tituloProjeto}', '{$nomeCoordenador}', '{$nomeRelator}', '{$documentosEnviados}', '{$textoAnalisado}', '{$TIPODOCUMENTO}', '{$cargaHoraria}', '{$periodoProjeto}','{$nomeRelatorio}' ,'{$sexoCoordenador}', '{$titulacaoCoordenador}', '{$faculdadeCoordenador}', '{$descricaoProposta}', '{$sexoRelator}', '{$possuiOutroCoordenador}', '{$nomeViceCoordenador}', '{$sexoViceCoordenador}', '{$titulacaoViceCoordenador}', '{$aprovacaoFaculdade}', '{$dataAprovacao}', '{$numeroDocumento}', '{$comentariosParecer}', '{$justificativa}', '{$parecerRelator}')" 
		title="Baixar parecer" class="acao-btn"
	>
		<i class="fa fa-download text-primary"></i>
	</a>
	</big>
	  <!-- Excluir -->
	<li class="dropdown head-dpdn2" style="display: inline-block;">
		<a href="#" title="Excluir Parecer" class="dropdown-toggle {$excluir_acesso} acao-btn" data-toggle="dropdown" aria-expanded="false"><big><i class="fa fa-trash-o text-danger"></i></big></a>


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


<!-- Script para passar o nível do usuário ao JavaScrip - EU COLOQUEI ISSOOOOOOO -->
<script type="text/javascript">
    var nivelUsuario = '<?php echo $nivel_usuario; ?>';
</script>


<!-- Iniciando e Mostrando o Datatables dos copeps --> 
<script type="text/javascript">
	$(document).ready( function () {
	$('#btn-deletar').hide();	//fica oculto o btn deletar no inicio, + fica com delay ainda	
    $('#tabela').DataTable({
    	"language" : {
            //"url" : '//cdn.datatables.net/plug-ins/1.13.2/i18n/pt-BR.json'
        },
        "ordering": false,
		"stateSave": true,
		"lengthMenu": [8, 10, 25, 50, 100] // Define as opções, incluindo 8
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

	function editar(
		acao,
		data,
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
		limparCamposParecer('editar');
		
		// falta preencher documentosEnviados
		$('#mensagem').text('');
    	$('#titulo_inserir').text('Editar Registro');
		$('#id_dados').val(id);
		$('#data').val(data);

		// Dados Iniciais
		$('#numeroParecer').val(numeroParecer)  ;
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
						dados.nomeRelatorio = nomeRelatorio
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
		setTimeout(() => {$('#nome_coordenador').val(nomeCoordenador).trigger('change') }, 400);
		$('#sexoCoordenador').val(sexoCoordenador);

		atualizarOpcoesTitulacaoCoordenador();
	
		popularSelect("titulacaoCoordenador", titulacaoCoordenador);
		
		$('#faculdadeCoordenador').val(faculdadeCoordenador);
		if (possuiOutroCoordenador === "sim") {
			$('#possui-outro-sim').prop('checked', true); 
			outroCordenador();
			
			setTimeout(() => { $('#nomeOutroCoordenador').val(nomeViceCoordenador).trigger('change')}, 400);

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

		if(acao !== 'baixar'){
			$('#modalForm').modal('show');
		}else{
			setTimeout(() => {
				baixarParecer();
			}, 1000);
		}
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
		if (ids_final == "" || nivelUsuario !== 'Administrador') {//eu Alteria aquiiiiiiiiiiiiii
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
	function limparCamposParecer(acao){
		$('#id_dados').val('');
		// dados inciais
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

		if(acao !== 'editar'){
			$.ajax({
				url: 'paginas/adicionarParecer.php',
				type: 'GET',
				success: function(response) {
					const res = JSON.parse(response);
					$('#numeroParecer').val(res.proximo_id);
					dados.numeroParecer = res.proximo_id;
				},
				error: function() {
					alert('Erro na comunicação com o servidor.');
				}
			});
		}
		limparDados();
	}

	function limparDados() {

		dados.id_dados = "";
		dados.anoParecer = "";
		dados.numeroOficio = "";
		dados.itemOficio = "";
		dados.dataEnvio = "";
		dados.dataEnvio_nao_formatada = "";
		dados.textoAnalisado = "";
		dados.tituloProjetoAnalisado = "";
		dados.documentosEnviados = [];

		dados.TIPODOCUMENTO = "RELATÓRIO";
		dados.nomeRelatorio = "";
		dados.periodoProjeto = "";
		dados.cargaHoraria = "";
		dados.pedidoAprovacao = "";
		dados.letra = "";
		dados.paragrafo5 = "";
		dados.artgo = "";
		dados.capitulo = "";
		dados.proj_Ana_Enc = "";
		dados.paragrafo7 = "";
		dados.descricaoProposta = "";

		dados.nomeCoordenador = "";
		dados.sexoCoordenador = "";
		dados.PRNCoordenador = "";
		dados.PRNTxtCoordenador = "";
		dados.titulacaoCoordenador = "";
		dados.faculdadeCoordenador = "";
		dados.descricaoCoordenadores = "";
		dados.possuiOutroCoordenador = "";

		dados.nomeViceCoordenador = "";
		dados.pronomeViceCoordenador = "";
		dados.sexoViceCoordenador = "";
		dados.titulacaoViceCoordenador = "";

		dados.objetivoDescricaoProposta = "";
		dados.objetivoProjeto = "";
		dados.proposicaoOuRelatorio = "";
		dados.aprovacaoFaculdade = "";
		dados.paragrafo2 = "";
		dados.numeroDoc = "";
		dados.dataAprovacao = null;
		dados.obs5 = "";
		dados.justificativa = "";

		dados.nomeRelator = "";
		dados.sexoRelator = "";
		dados.pronRelat = "";
		dados.pronomeTxt = "";

		dados.situacaoRelatorio = "";
		dados.aprovOuReprov = "";

		dados.paragrafo8 = "";
		dados.partePrg8 = "";
		dados.comentariosParecer = "";
		dados.paragrafo9 = "";
		dados.dataAtual = "";
		dados.elementosCargaHoraria = [];
		inputCount = 1;

		$('input[name^="requisito_a_pesquisa"]:checked, input[name^="requisito_b_pesquisa"]:checked, input[name^="requisito_c_pesquisa"]:checked, input[name^="requisito_d_pesquisa"]:checked, input[name^="requisito_e_pesquisa"]:checked').each(function() {
			$(this).prop('checked', false);
		});
		$('.contadorPesquisa').text(0);

		$('input[name^="requisito_a_extensao"]:checked, input[name^="requisito_b_extensao"]:checked, input[name^="requisito_c_extensao"]:checked, input[name^="requisito_d_extensao"]:checked').each(function() {
			$(this).prop('checked', false);
		});
		$('.contadorExtensao').text(0);

		$('input[name^="requisito_a"]:checked, input[name^="requisito_b"]:checked, input[name^="requisito_c"]:checked, input[name^="requisito_d"]:checked, input[name^="requisito_e"]:checked, input[name^="requisito_f"]:checked').each(function() {
			$(this).prop('checked', false);
		});
		$('.contadorEnsino').text(0);
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

