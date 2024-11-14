<?php
$pag = 'copeps';

if (@$copeps == 'ocultar') {
	echo '<script>window.location="../index.php"</script>';
	exit();
}
?>

<!-- Botão Inserir novo membro com a função "inserir()" via "ajax.js" -->
<a onclick="inserir()" type="button" class="btn btn-primary"><span class="fa fa-plus"></span> Parecer</a>

<li class="dropdown head-dpdn2" style="display: inline-block;">
	<a href="#" data-toggle="dropdown" class="btn btn-danger dropdown-toggle" id="btn-deletar" style="display:none"><span class="fa fa-trash-o"></span> Deletar</a>

	<ul class="dropdown-menu">
		<li>
			<div class="notification_desc2">
				<p>Excluir Selecionados? <a href="#" onclick="deletarSel()"><span class="text-danger">Sim</span></a></p>
			</div>
		</li>
	</ul>
</li>

<div class="bs-example widget-shadow" style="padding:15px" id="listar">
</div>

<input type="hidden" id="ids">

<!-- Modal Form Cadastro Parecer -->
<div class="modal fade" id="modalForm" tabindex="-1" aria-labelledby="exampleModalLabel" data-backdrop="static">
	<div class="modal-dialog modal-lg" role="document" style="width:60%; overflow: scroll; height:auto; max-height: 590px; scrollbar-width: thin;" bis_skin_checked="1">
		<div class="modal-content">
			<div class="modal-header">
				<h4 class="modal-title" id="exampleModalLabel"><span id="titulo_inserir"></span>
					<small>
						<ul class="nav nav-tabs" id="myTab" role="tablist">
							<li class="nav-item">
								<a class="nav-link active" id="home-tab" data-toggle="tab" href="#home" role="tab" aria-controls="home" aria-selected="true">Dados Iniciais</a>
							</li>
							<li class="nav-item">
								<a class="nav-link" id="profile-tab" data-toggle="tab" href="#profile" role="tab" aria-controls="profile" aria-selected="false">Dados Documento</a>
							</li>
							<li class="nav-item">
								<a class="nav-link" id="contact-tab" data-toggle="tab" href="#contact" role="tab" aria-controls="contact" aria-selected="false">Dados Coordenador</a>
							</li>
							<li class="nav-item">
								<a class="nav-link" id="extra-tab" data-toggle="tab" href="#extra" role="tab" aria-controls="extra" aria-selected="false">Dados Relator</a>
							</li>
						</ul>
					</small>
				</h4>
				<button id="btn-fechar" type="button" class="close" data-dismiss="modal" aria-label="Close" style="margin-top: -50px">
					<span>&times;</span>
				</button>
			</div>
			<form id="form">
				<div class="modal-body" style="margin-top: -20px">
					<div class="tab-content" id="myTabContent">
						<div class="tab-pane fade" id="home" role="tabpanel" aria-labelledby="home-tab">
							<div class="row">
								<div class="col-md-3">
									<label for="numeroParecer">Número do Parecer:</label>
									<input type="text" class="form-control" id="numeroParecer" name="numeroParecer">
								</div>

								<div class="col-md-3">
									<label for="ano">Ano Parecer:</label>
									<!-- O ano será preenchido automaticamente usando PHP -->
									<input type="text" class="form-control" id="ano" name="ano" value="<?php echo date("Y"); ?>" readonly>
								</div>

								<div class="col-md-3">
									<label for="numeroOficio">Número do Ofício*:</label>
									<input type="text" class="form-control" id="numeroOficio" name="numeroOficio" required>
								</div>

								<div class="col-md-2">
									<label for="anoanoexercicio_field">Ano Ofício:</label>
									<select name="anoexercicio_field" class="form-control" id="anoexercicio_field">
										<option value="2028">2030</option>
										<option value="2028">2029</option>
										<option value="2028">2028</option>
										<option value="2027">2027</option>
										<option value="2026">2026</option>
										<option value="2025">2025</option>
										<option value="2024">2024</option>
										<option value="2023" selected="">2023</option>
										<option value="2022">2022</option>
										<option value="2021">2021</option>
										<option value="2020">2020</option>
										<option value="2019">2019</option>
										<option value="2018">2018</option>
										<option value="2017">2017</option>
										<option value="2016">2016</option>
										<option value="2015">2015</option>
									</select>
								</div>

							</div>

							<div class="row">
								<div class="col-md-4">
									<label for="item_field">Item do Ofício SE/CAMTUC:</label>
									<select name="item_field" class="form-control" id="item_field">
										<option value="1" selected="">Item 1</option>
										<option value="2">Item 2</option>
										<option value="3">Item 3</option>
										<option value="4">Item 4</option>
										<option value="5">Item 5</option>
										<option value="6">Item 6</option>
										<option value="7">Item 7</option>
										<option value="8">Item 8</option>
										<option value="8">Item 8</option>
										<option value="10">Item 9</option>
										<option value="11">Item 10</option>
										<option value="12">Item 11</option>
										<option value="13">Item 12</option>
										<option value="14">Item 13</option>
										<option value="15">Item 14</option>
										<option value="16">Item 15</option>
										<option value="17">Item 16</option>
									</select>

								</div>

								<div class="col-md-3">
									<div class="form-group">
										<label>Data Envio</label>
										<input type="date" class="form-control" name="data" id="data" value="<?php echo date('Y-m-d') ?>">
									</div>
								</div>

							</div>

							<div class="form-group">
								<label>TEXTO A SER ANÁLISADO:* <small>(Max 10000 Caracteres)</small></label>
								<textarea maxlength="1000" type="text" class="textareag" name="obs1" id="obs1" required></textarea>
							</div>

							<div class="form-group">
								<label>TITULO DO PROJETO A SER ANALIZADO:*</label>
								<textarea maxlength="500" type="text" class="textareag" name="obs2" id="obs2" required></textarea>
							</div>

							<div class="form-group">
								<label>DOCUMENTOS ENVIADOS:* <small>(Max 500 Caracteres)</small></label>
								<textarea maxlength="500" type="text" class="textareag" name="obs3" id="obs3" required></textarea>
							</div>

							<hr>
							<div align="right">
								<button type="button" id="seguinte_aba2" name="seguinte_aba2" class="btn btn-primary">Seguinte</button>
							</div>
						</div>

						<div class="tab-pane fade" id="profile" role="tabpanel" aria-labelledby="profile-tab">
							<div class="row">
								<div class="col-md-6" id="relatorio-div" required>
									<label for="tipo-desenvolvimento">Tipo de Documento: RELATÓRIO?</label>
									<div class="custom-controls custom-checkbox">
										<input type="radio" id="tipo-desenvolvimento-nao" name="tipo-desenvolvimento" value="nao" onchange="mudarRelatorio()">
										<label for="tipo-desenvolvimento-nao">Não</label>

										<input type="radio" id="tipo-desenvolvimento-parcial" name="tipo-desenvolvimento" value="parcial" onchange="mudarRelatorio()">
										<label for="tipo-desenvolvimento-parcial">Parcial</label>

										<input type="radio" id="tipo-desenvolvimento-final" name="tipo-desenvolvimento" value="final" onchange="mudarRelatorio()">
										<label for="tipo-desenvolvimento-final">Final</label>

									</div>
								</div>

								<div class="col-md-6" style="margin-top: -25px;margin-left: 250px;" id="listar_relatorios">
								</div>
							</div>

							<div class="row" style="margin-top: -2px; margin-left: 15px;">
								<div id="terceiro_select_container">
									<label for="terceiro_select"></label>
									<div id="terceiro_select"></div>
								</div>
							</div>

							<div class="row">
								<div class="col-md-3">
									<label for="mesesSelect">Período do Projeto:</label>
									<select class="form-control" id="mesesSelect" name="meses" required>
										<?php
										for ($i = 3; $i <= 24; $i++) {
											$texto = ($i == 1) ? "mês" : "meses";
											echo "<option value=\"$i\">$i ($texto)</option>";
										}
										?>
									</select>
								</div>

								<div class="col-md-3" id="carga-horaria-div" required>
									<label for="tipo-desenvolvimento">Possui Carga Horária?*</label>
									<div class="custom-controls custom-checkbox">
										<input type="radio" id="tipo-sim" name="tipo-carga" value="simc" onchange="mudarCarga()">
										<label for="tipo-sim">SIM</label>

										<input type="radio" id="tipo-nao" name="tipo-carga" value="naoc" onchange="mudarCarga()">
										<label for="tipo-nao">NÃO</label>

									</div>
								</div>

								<div class="col-md-2" style="margin-top: 20px" id="listar_cargas_container">
								</div>
							</div>

							<div class="row bloqueado" id="bloco_pesquisa">
								<div class="col-md-12">
									<div class="modal-body">
										<h4 class="modal-title" id="exampleModalLabel1" style="font-weight: bold;text-decoration: underline;">REQUISITOS PARA APROVAÇÃO DO PROJETO DE PESQUISA, PARA ATÉ 10 HORAS</h4>
									</div>

									<label>
										<input type="checkbox" value="ra10" id="requisito_a10" name="requisito_a10" onchange="contarCheckbox10()"> a) Orientação de pelo menos 1 discente da graduação, da pós-graduação, da educação básica ou do ensino técnico e tecnológico, bolsista ou voluntário, por ano, no período de vigência do projeto anterior;

									</label><br><br>
									<label>
										<input type="checkbox" value="rc10" id="requisito_c10" name="requisito_c10" onchange="contarCheckbox10()"> c) Apresentação de pelo menos um trabalho em evento científico, por ano, no período de vigência do projeto anterior;
									</label><br><br>
									<label>
										<input type="checkbox" value="rd10" id="requisito_d10" name="requisito_d10" onchange="contarCheckbox10()"> d) Orientação ou coorientação na pós-graduação stricto sensu;
									</label><br><br>
									<label>
										<input type="checkbox" value="rb10" id="requisito_b10" name="requisito_b10" onchange="contarCheckbox10()"> b) Publicação em média de um artigo em revista indexada, ou livro, ou capítulo de livro, por ano, no período de vigência do projeto anterior;

									</label><br><br>
									<label>
										<input type="checkbox" value="re10" id="requisito_e10" name="requisito_e10" onchange="contarCheckbox10()"> e) Aprovação do projeto em edital da UFPA ou de agência de fomento.
									</label><br><br>
								</div>
							</div>

							<div class="row bloqueado" id="bloco_ensino">
								<div class="col-md-12">
									<div class="modal-body">
										<h4 class="modal-title" id="exampleModalLabel2" style="font-weight: bold;text-decoration: underline;">REQUISITOS PARA APROVAÇÃO DO PROJETO DE ENSINO, PARA ATÉ 20 HORAS</h4>
									</div>

									<label>
										<input type="checkbox" value="ra20" id="requisito_a20" name="requisito_a20" onchange="contarCheckbox20()"> a) Orientação de pelo menos 2 discentes da graduação, da pós-graduação, da educação básica ou do ensino técnico e tecnológico em projeto de ensino, bolsista ou voluntário, por ano, no período de vigência do projeto anterior;

									</label><br><br>
									<label>
										<input type="checkbox" value="rc20" id="requisito_c20" name="requisito_c20" onchange="contarCheckbox20()"> c) Apresentação de pelo menos um trabalho em evento científico, por ano, no período de vigência do projeto anterior;
									</label><br><br>
									<label>
										<input type="checkbox" value="rd20" id="requisito_d20" name="requisito_d20" onchange="contarCheckbox20()"> d) Orientação ou coorientação na pós-graduação stricto sensu;
									</label><br><br>
									<label>
										<input type="checkbox" value="rb20" id="requisito_b20" name="requisito_b20" onchange="contarCheckbox20()"> b) Publicação em média de um artigo em revista indexada por ano, no período de vigência do projeto anterior;
									</label><br><br>
									<label>
										<input type="checkbox" value="re20" id="requisito_e20" name="requisito_e20" onchange="contarCheckbox20()"> e) Aprovação do projeto em edital da UFPA ou de agência de fomento.
									</label><br><br>
								</div>
							</div>

							<div class="row">
								<!-- Div para exibir o número de checkboxes selecionados 10 horas -->
								<div class="col-md-12 text-center" style="margin-top: 20px; font-size: 20px;" id="listar_checkbox10horas">
									REQUISITOS PARA APROVAÇÃO DO PROJETO: <span id="contador10">0</span>/3
								</div>
							</div>

							<div class="row">
								<!-- Div para exibir o número de checkboxes selecionados 20 horas -->
								<div class="col-md-12 text-center" style="margin-top: 20px; font-size: 20px;" id="listar_checkbox20horas">
									REQUISITOS PARA APROVAÇÃO DO PROJETO: <span id="contador20">0</span>/3
								</div>
							</div>

							<style>
								.bloqueado {
									display: none;
								}

								#listar_checkbox10horas,
								#listar_checkbox20horas {
									display: none;
								}
							</style>

							<hr>
							<div class="row">
								<div class="col-md-6">
									<button type="button" id="voltar_aba1" name="voltar_aba1" class="btn btn-primary">Voltar</button>
								</div>

								<div class="col-md-6" align="right">
									<button type="button" id="seguinte_aba3" name="seguinte_aba3" class="btn btn-primary">Seguinte</button>
								</div>

							</div>
						</div>

						<div class="tab-pane fade" id="contact" role="tabpanel" aria-labelledby="contact-tab">Contact

							<div class="row">
								<div class="col-md-8">
									<label>Nome do Coordenador</label>
									<input type="text" class="form-control" id="nome_coordenador" name="nome_coordenador" placeholder="Nome do Coordenador" >
								</div>
								
								<div class="col-md-4">
									<label for="sexoCoordenador">Sexo do Coordenador:</label>
									<select class="form-control" id="sexoCoordenador" name="sexoCoordenador" >
										<option value="" disabled selected>- Selecione -</option>
										<option value="masculino">Masculino</option>
										<option value="feminino">Feminino</option>
									</select>
								</div>
							</div>

							<div class="row">
								<div class="col-md-4">
									<div class="form-group">
										<label for="titulacaoCoordenador">Titulação do Coordenador:</label>
										<select class="form-control" id="titulacaoCoordenador" name="titulacaoCoordenador">
											<option value="" disabled selected>- Selecione -</option>
											<option value="tec-adm">Tec. Adm.</option>
											<option value="prof-me">Prof. Me.</option>
											<option value="prof-dr">Prof. Dr.</option>
										</select>
									</div>
								</div>

								<div class="col-md-8">
									<div class="form-group">
										<label for="faculdadeCoordenador">Faculdade do Coordenador:</label>
										<select class="form-control" id="faculdadeCoordenador" name="faculdadeCoordenador">
											<option value="" disabled selected>- Selecione -</option>
											<option value="camtuc">Campus Universitário de Tucuruí - CAMTUC</option>
											<option value="facfis">Faculdade de Física - FACFIS</option>
											<option value="faesa">Faculdade de Engenharia Sanitária e Ambiental - FAESA</option>
											<option value="fec">Faculdade de Engenharia Civil - FEC</option>
											<option value="fecomp">Faculdade de Engenharia de Computação - FECOMP</option>
											<option value="fee">Faculdade de Engenharia Elétrica - FEE</option>
											<option value="fem">Faculdade de Engenharia Mecânica - FEM</option>
										</select>
									</div>
								</div>
							</div>

							<!-- Comecça daqui pra analisarrrrrrrrrrrrrrrrrrrrrrrrrrrrrr -->

							<div class="row">
								<div class="col-md-6">
									<label for="possuiOutroCoordenador">Possui Outro Coordenador?</label>
									<div class="custom-controls custom-checkbox">
										<input type="radio" id="possui-outro-sim" name="possuiOutroCoordenador" value="sim" onchange="outroCordenador()">
										<label for="possui-outro-sim">Sim</label>

										<input type="radio" id="possui-outro-nao" name="possuiOutroCoordenador" value="nao" onchange="outroCordenador()">
										<label for="possui-outro-nao">Não</label>
									</div>
								</div>
							</div>

							<div class="row" id="outroCoordenadorInfo" style="display: none;">
								<div class="col-md-6">
									<label for="nomeOutroCoordenador">Nome do Outro Coordenador</label>
									<input type="text" class="form-control" id="nomeOutroCoordenador" name="nomeOutroCoordenador" placeholder="Nome do Outro Coordenador" >
								</div>

								<div class="col-md-4">
									<label for="sexoOutroCoordenador">Sexo do Outro Coordenador:</label>
									<select class="form-control" id="sexoOutroCoordenador" name="sexoOutroCoordenador">
										<option value="" disabled selected>- Selecione -</option>
										<option value="masculino">Masculino</option>
										<option value="feminino">Feminino</option>
									</select>
								</div>
							</div>

							<div class="row" id="titulacaoOutroCoordenadorInfo" style="display: none;">
								<div class="col-md-5">
									<label for="titulacaoOutroCoordenador">Titulação do Outro Coordenador:</label>
									<select class="form-control" id="titulacaoOutroCoordenador" name="titulacaoOutroCoordenador">
										<option value="" disabled selected>- Selecione -</option>
										<option value="tec-adm">Tec. Adm.</option>
										<option value="prof-ma">Profª. Ma.</option>
										<option value="prof-dra">Profª. Drª.</option>
									</select>
								</div>
							</div>
							<hr>
							<div class="row">
								<div class="col-md-6">
									<button type="button" id="voltar_aba2" name="voltar_aba2" class="btn btn-primary">Voltar</button>
								</div>

								<div class="col-md-6" align="right">
									<button type="button" id="seguinte_aba4" name="seguinte_aba4" class="btn btn-primary">Seguinte</button>
								</div>
							</div>
						</div>

						<div class="tab-pane fade" id="extra" role="tabpanel" aria-labelledby="extra-tab">
							<div class="row">
								<div class="col-md-7">
									<div class="form-group">
										<label for="nomeRelator">Nome do Relator:</label>
										<select class="form-control sel" name="nomeRelator" id="nomeRelator" required style="width:100%;">
											<option value="" disabled selected>- Selecione -</option>
											<?php
											$query = $pdo->query("SELECT * FROM membros order by nome asc");
											$res = $query->fetchAll(PDO::FETCH_ASSOC);
											for ($i = 0; $i < @count($res); $i++) {
												foreach ($res[$i] as $key => $value) {
												}

											?>
												<option value="<?php echo $res[$i]['id'] ?>"><?php echo $res[$i]['nome'] ?></option>

											<?php } ?>

										</select>
									</div>
								</div>

								<div class="col-md-3">
									<label for="sexoRelator">Sexo do Relator:</label>
									<select class="form-control" id="sexoRelator" name="sexoRelator">
										<option value="" disabled selected>- Selecione -</option>
										<option value="masculino">Masculino</option>
										<option value="feminino">Feminino</option>
									</select>
								</div>

							</div>
							<div class="row">
								<div class="col-md-6">
									<div class="form-group">
										<label>Descrição da Proposta:* <small>(A proposta tem como objetivo)</small></label>
										<textarea maxlength="500" type="text" class="textareag" name="obs4" id="obs4" required></textarea>
									</div>
								</div>
							</div>
							<!-- Comecça daqui pra analisarrrrrrrrrrrrrrrrrrrrrrrrrrrrrr -->
							<div class="col-md-5">
								<label for="aprovacaoFaculdade">A proposta foi Aprovada pela Faculdade?</label>
								<select class="form-control" id="aprovacaoFaculdade" name="aprovacaoFaculdade" onchange="propostaAprovada()">
									<option value="" disabled selected>- Selecione -</option>
									<option value="ad-referendum">Ad Referendum</option>
									<option value="ata-reuniao-ordinaria">Ata de Reunião Ordinária</option>
									<option value="ata-reuniao-extraordinaria">Ata de Reunião Extraordinária</option>
									<option value="nao">Não</option>
								</select>
							</div>

							<!-- Container a ser ocultado -->
							<div class="col-md-4" id="nasc">
								<div class="form-group">
									<label for="qualDia">Qual Dia?</label>
									<input type="date" class="form-control" id="qualDia" name="qualDia">
								</div>
							</div>
							<!-- Container a ser ocultado -->
							<div class="row" id="numeroDocumentoContainer">
								<div class="col-md-4">
									<label for="numeroDocumento">Número do Documento:</label>
									<select class="form-control" id="numeroDocumento" name="numeroDocumento">
										<option value="" disabled selected>- Selecione -</option>
										<?php
										for ($i = 1; $i <= 150; $i++) {
											echo "<option value=\"$i\">$i</option>";
										}
										?>
									</select>
								</div>

								<div class="col-md-5">
									<label for="parecerRelator">Parecer do Relator:</label>
									<div class="custom-controls custom-radio">
										<input type="radio" id="aprovado" name="parecerRelator" value="aprovado">
										<label for="aprovado">Aprovado</label>

										<input type="radio" id="naoAprovado" name="parecerRelator" value="naoAprovado">
										<label for="naoAprovado">Não Aprovado</label>
									</div>
								</div>
							</div>

							<div class="row">
								<div class="col-md-6" id="comentariosParecer">
									<div class="form-group">
										<label for="comentariosJustificativa">Justificativa:* <small>(Obrigatório)</small></label>
										<textarea maxlength="500" type="text" class="textareag" name="obs5" id="obs5" required></textarea>
									</div>
								</div>
							</div>

							<div class="row">
								<div class="col-md-6">
									<div class="form-group">
										<label for="comentariosParecer">Comentários Sobre o Parecer:* <small>(Opcional, caso seja aprovado)</small></label>
										<textarea maxlength="500" type="text" class="textareag" name="obs6" id="obs6" required></textarea>
									</div>
								</div>
							</div>

							<hr>
							<div class="row">
								<div class="col-md-6">
									<button type="button" id="voltar_aba3" name="voltar_aba3" class="btn btn-primary">Voltar</button>
								</div>

								<div class="col-md-6" align="right">
									<button type="submit" id="salvar" name="salvar" class="btn btn-primary">Salvar</button>
								</div>

							</div>
						</div>
					</div>

					<input type="hidden" class="form-control" id="id" name="id">

					<br>
					<small>
						<div id="mensagem" align="center"></div>
					</small>

				</div>
			</form>
		</div>
	</div>
</div>

<!-- Modal Exibir Dados Membros-->
<div class="modal fade" id="modalDados" tabindex="-1" aria-labelledby="exampleModalLabel">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<h4 class="modal-title" id="exampleModalLabel"><span id="titulo_dados"></span></h4>
				<button id="btn-fechar-dados" type="button" class="close" data-dismiss="modal" aria-label="Close" style="margin-top: -25px">
					<span>&times;</span>
				</button>
			</div>

			<div class="modal-body">
				<div class="row" style="margin-top: 0px; border-bottom: 1px solid #cac7c7;">
					<div class="col-md-6" style="margin-bottom: 5px">
						<span><b>Telefone: </b></span><span id="telefone_dados"></span>
					</div>


					<div class="col-md-8" style="margin-bottom: 5px">
						<span><b>Email: </b></span><span id="email_dados"></span>
					</div>

					<div class="col-md-8" style="margin-bottom: 5px">
						<span><b>Matrícula: </b></span><span id="matricula_dados"></span>
					</div>


					<div class="col-md-6" style="margin-bottom: 5px">
						<span><b>Cargo: </b></span><span id="cargo_dados"></span>
					</div>

					<div class="col-md-6" style="margin-bottom: 5px">
						<span><b>Comissão: </b></span><span id="comissao_dados"></span>
					</div>

					<div class="col-md-6" style="margin-bottom: 5px">
						<span><b>Ativo: </b></span><span id="ativo_dados"></span>
					</div>

					<div class="col-md-6" style="margin-bottom: 5px">
						<span><b>Data Cadastro: </b></span><span id="data_dados"></span>
					</div>

					<div class="col-md-12" style="margin-bottom: 5px">
						<span><b>Endereço: </b></span><span id="endereco_dados"></span>
					</div>

					<div class="col-md-4" style="margin-bottom: 5px">
						<span><b>Cidade: </b></span><span id="cidade_dados"></span>
					</div>

					<div class="col-md-4" style="margin-bottom: 5px">
						<span><b>Estado: </b></span><span id="estado_dados"></span>
					</div>

					<div class="col-md-4" style="margin-bottom: 10px">
						<span><b>País: </b></span><span id="pais_dados"></span>
					</div>

					<div class="row" style="border-bottom: 1px solid #cac7c7;">
						<div class="col-md-12">
							<span><b>OBS: </b></span>
							<span id="obs_dados"></span>
						</div>
					</div>

					<div class="row">
						<div class="col-md-12" style="margin-bottom: 10px">
							<div align="center"><img src="" id="foto_dados" width="100px"></div>
						</div>
					</div>
				</div>
			</div>

		</div>
	</div>
</div>

<!-- Modal Permissoes -->
<div class="modal fade" id="modalPermissoes" tabindex="-1" aria-labelledby="exampleModalLabel">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<h4 class="modal-title" id="exampleModalLabel"><span id="nome_permissoes"></span>

					<span style="position:absolute; right:35px">
						<input class="form-check-input" type="checkbox" id="input-todos" onchange="marcarTodos()">
						<label class="">Marcar Todos</label>
					</span>

				</h4>
				<button id="btn-fechar-permissoes" type="button" class="close" data-dismiss="modal" aria-label="Close" style="margin-top: -25px">
					<span>&times;</span>
				</button>
			</div>

			<div class="modal-body">
				<div class="row" id="listar_permissoes">

				</div>

				<br>
				<input type="hidden" name="id" id="id_permissoes">
				<small>
					<div id="mensagem_permissao" align="center" class="mt-3"></div>
				</small>
			</div>

		</div>
	</div>
</div>

<script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>

<script type="text/javascript">
	function mudarRelatorio() {
		// Obtém o valor do input radio selecionado
		var escolhido = document.querySelector('input[name="tipo-desenvolvimento"]:checked').value;

		// Faz a requisição AJAX
		$.ajax({
			url: 'paginas/' + pag + '/listar_relatorios.php',
			method: 'POST',
			data: {
				escolhido: escolhido
			},
			dataType: 'json',
			success: function(result) {
				// Cria um novo <select> com as opções retornadas do PHP
				var select = $('<select class="form-select" name="tipo" id="tipo">');
				for (var i = 0; i < result.length; i++) {
					select.append($('<option>', {
						value: result[i],
						text: result[i]
					}));
				}

				// Substitui o conteúdo atual do elemento com id 'listar_relatorios' pelo novo <select>
				$('#listar_relatorios').html(select);

				// Quando o segundo select muda, criar o terceiro select se necessário
				select.change(function() {
					var escolhidoSegundoSelect = select.val();
					if (escolhidoSegundoSelect === "Alocação de Carga horária") {
						var terceiroSelect = $('<div id="terceiro_select_container"></div>');
						terceiroSelect.prepend('<label for="tipo">Tipo de Projeto?</label>');
						terceiroSelect.append($('<select class="form-select" name="tipo" id="tipo">'));
						terceiroSelect.find('#tipo').append($('<option>', {
							value: "Projeto de Ensino",
							text: "Projeto de Ensino"
						}));
						terceiroSelect.find('#tipo').append($('<option>', {
							value: "Projeto de Pesquisa",
							text: "Projeto de Pesquisa"
						}));
						terceiroSelect.find('#tipo').append($('<option>', {
							value: "Projeto de Extensão",
							text: "Projeto de Extensão"
						}));

						// Substitui o conteúdo atual do elemento com id 'terceiro_select' pelo novo terceiro <select>
						$('#terceiro_select').html(terceiroSelect);
						// Mostra o terceiro select
						$('#terceiro_select').show();
					} else {
						// Se o segundo select não for "Alocação de Carga horária", esconde o terceiro select
						$('#terceiro_select').empty().hide();
					}
				});
			},
			error: function(xhr, status, error) {
				// Trate os erros aqui, se necessário
				console.error(error);
			}
		});
	}

	function mudarCarga() {
		var escolhido2 = $('input[name="tipo-carga"]:checked').val();

		$.ajax({
			url: 'paginas/' + pag + '/listar_cargas.php',
			method: 'POST',
			data: {
				escolhido2: escolhido2
			},
			dataType: 'json',
			success: function(result) {
				var select = $('<select class="form-select" name="tipo-carga" id="tipo-carga">');
				for (var i = 0; i < result.length; i++) {
					select.append($('<option>', {
						value: result[i],
						text: result[i]
					}));
				}

				$('#listar_cargas_container').html(select);

				if (escolhido2 === 'naoc') {
					$('#tipo-carga').prop('disabled', true);
					$('#tipo-carga').append($('<option>', {
						value: 'desabilitado',
						text: 'Sem Alocação de Carga Horária',
						selected: 'selected'
					}));
				} else {
					$('#tipo-carga').prop('disabled', false);
				}

				var horasSelecionadas = $('#tipo-carga').val();
				mostrarBlocosRequisitos(escolhido2, horasSelecionadas);
			},
			error: function(xhr, status, error) {
				console.error(error);
			}
		});
	}

	function mostrarBlocosRequisitos(escolha, horasSelecionadas) {
		console.log('Escolha:', escolha);
		console.log('Horas selecionadas:', horasSelecionadas);

		// Oculta ambos os blocos
		$('#bloco_pesquisa').hide();
		$('#bloco_ensino').hide();

		// Exibe o bloco correspondente à escolha de horas
		if (escolha === 'simc' && (horasSelecionadas === '10 (Dez) horas' || horasSelecionadas === '5 (Cinco) horas')) {
			console.log('Exibindo pesquisa-projeto e listar_checkbox10horas');
			$('#bloco_pesquisa').show();
		} else if (escolha === 'simc' && (horasSelecionadas === '20 (Vinte) horas' || horasSelecionadas === '15 (Quinze) horas')) {
			console.log('Exibindo ensino-projeto e listar_checkbox20horas');
			$('#bloco_ensino').show();
		}

		// Atualiza a mensagem conforme a escolha de horas
		if (horasSelecionadas === '10 (Dez) horas' || horasSelecionadas === '5 (Cinco) horas') {
			$('#listar_checkbox10horas').show();
			$('#listar_checkbox20horas').hide();
		} else if (horasSelecionadas === '20 (Vinte) horas' || horasSelecionadas === '15 (Quinze) horas') {
			$('#listar_checkbox10horas').hide();
			$('#listar_checkbox20horas').show();
		} else {
			// Se não for 10, 5, 20 ou 15 horas, oculta ambas as mensagens
			$('#listar_checkbox10horas').hide();
			$('#listar_checkbox20horas').hide();
		}
	}

	$(document).on('change', '#tipo-carga', function() {
		var horasSelecionadas = $(this).val();
		var escolha = $('input[name="tipo-carga"]:checked').val();
		console.log('Mudança de horas. Nova seleção:', horasSelecionadas);
		console.log('Escolha atual:', escolha);
		mostrarBlocosRequisitos(escolha, horasSelecionadas);
	});

	// Função para contar checkboxes para 10 horas
	function contarCheckbox10() {
		var totalSelecionados = $('input[name^="requisito_a10"]:checked, input[name^="requisito_b10"]:checked, input[name^="requisito_c10"]:checked, input[name^="requisito_d10"]:checked, input[name^="requisito_e10"]:checked').length;
		console.log('Total selecionado para 10 horas:', totalSelecionados);
		$('#contador10').text(totalSelecionados);
		// Faz a requisição AJAX para 10 horas
		$.ajax({
			url: 'paginas/' + pag + '/listar_checkbox10horas.php',
			method: 'POST',
			data: {
				escolhido3: totalSelecionados
			},
			dataType: 'json',
			success: function(result) {
				if (result.success) {
					// Faça algo com a resposta do servidor, se necessário
				} else {
					console.error('Erro no servidor.');
				}
			},
			error: function(xhr, status, error) {
				console.error('Erro na requisição AJAX: ' + status + ' - ' + error);
			}
		});
	}

	// Função para contar checkboxes para 20 horas
	function contarCheckbox20() {
		var totalSelecionados2 = $('input[name^="requisito_a20"]:checked, input[name^="requisito_b20"]:checked, input[name^="requisito_c20"]:checked, input[name^="requisito_d20"]:checked, input[name^="requisito_e20"]:checked').length;
		console.log('Total selecionado para 20 horas:', totalSelecionados2);
		$('#contador20').text(totalSelecionados2);
		// Faz a requisição AJAX para 20 horas
		$.ajax({
			url: 'paginas/' + pag + '/listar_checkbox20horas.php',
			method: 'POST',
			data: {
				escolhido4: totalSelecionados2
			},
			dataType: 'json',
			success: function(result) {
				if (result.success) {
					// Faça algo com a resposta do servidor, se necessário
				} else {
					console.error('Erro no servidor.');
				}
			},
			error: function(xhr, status, error) {
				console.error('Erro na requisição AJAX: ' + status + ' - ' + error);
			}
		});
	}


	// Função para reiniciar o contador no servidor
	function reiniciarContador(horas) {
		$.ajax({
			url: 'paginas/' + pag + '/reiniciar_contador.php', // Atualize com o caminho correto
			method: 'POST',
			data: {
				horas: horas
			},
			dataType: 'json',
			success: function(result) {
				if (!result.success) {
					console.error('Erro ao reiniciar o contador para ' + horas + ' horas.');
				}
			},
			error: function(xhr, status, error) {
				console.error('Erro na requisição AJAX para reiniciar o contador:', status, '-', error);
			}
		});
	}

	function outroCordenador() {
		var escolhido5 = $('input[name="possuiOutroCoordenador"]:checked').val();


		if (escolhido5 === 'sim') {
			$('#outroCoordenadorInfo').show();
			$('#titulacaoOutroCoordenadorInfo').show();
		} else {
			$('#outroCoordenadorInfo').hide();
			$('#titulacaoOutroCoordenadorInfo').hide();
		}


		// Restante do seu código AJAX
		$.ajax({
			url: 'paginas/' + pag + '/listar_outroCordenador.php',
			method: 'POST',
			data: {
				escolhido5
			},
			dataType: 'json',
			success: function(result) {
				// Lógica de sucesso
			},
			error: function(error) {
				// Lógica de erro
			}
		});
	}


	function propostaAprovada() {
		var escolhido6 = $("#aprovacaoFaculdade").val();

		if (escolhido6 === 'nao') {
			$('#nasc').hide();
			$('#numeroDocumento').hide();
		} else {
			$('#nasc').show();
			$('#numeroDocumento').show();
		}

		// Restante do seu código AJAX
		$.ajax({
			url: 'paginas/' + pag + '/faltaNome.php',
			method: 'POST',
			data: {
				escolhido6
			},
			dataType: 'json',
			success: function(result) {
				// Lógica de sucesso
			},
			error: function(error) {
				// Lógica de erro
			}
		});
	}

	$(document).ready(function() {
		// Chama a função quando a página carrega
		propostaAprovada();

		// Adiciona um ouvinte de evento de mudança ao select
		$("#aprovacaoFaculdade").change(function() {
			// Chama a função quando o select for alterado
			propostaAprovada();
		});
	});

	function propostaAprovada() {
		var escolhido6 = $("#aprovacaoFaculdade").val();

		// Lógica para mostrar ou ocultar os campos
		if (escolhido6 === 'nao') {
			$("#nasc, #numeroDocumento, label[for='numeroDocumento']").hide();
		} else {
			$("#nasc, #numeroDocumento, label[for='numeroDocumento']").show();
		}

		// Verificar se a opção selecionada requer a ocultação do campo comentariosParecer
		$.ajax({
			url: 'paginas/' + pag + '/faltaNome.php',
			method: 'POST',
			data: {
				escolhido6
			},
			dataType: 'json',
			success: function(result) {
				console.log(result);

				// Verificar se a opção selecionada requer a ocultação do campo comentariosParecer
				if (result.ocultarComentariosParecer) {
					$("#comentariosParecer").hide();
				} else {
					$("#comentariosParecer").show();
				}
			},
			error: function(error) {
				console.error(error);
			}
		});
	}
</script>

<script src="js/ajax.js"></script>

<script type="text/javascript">
<!-- Trás uma variavel do Php "$pag" pro javascript "var pag" -->
	var pag = "<?= $pag ?>"

	//Ajax p/a Ler os documento:  Select2 p/a formulario de membros 
	$(document).ready(function() {

		$('#myTab a[href="#home"]').tab('show'); //comando que abre a aba inicial da modal.

		$('.sel2').select2({
			dropdownParent: $('#modalForm')
		});
	});

var dadosIniciais = {
    numeroParecer: "",
    anoParecer: "",
    numeroOficio: "",
    anoOficio: "",
    itemOficio: "",
    dataEnvio: "",
    textoAnalisado: "",
    tituloProjetoAnalisado: "",
    documentosEnviados: ""
};

var dadosDocumento = {
    tipoDocumento: "",
    periodoProjeto: "",
    cargaHoraria: "",
};

var dadosCoordenador = {
    nome: "",
    sexo: "",
    titulacao: "",
    faculdade: "",
    possuiOutro: null
};

	//Ajax p/a avançar nas abas quando o botao for clicado

	$("#voltar_aba1").click(function() {
		$('#myTab a[href="#home"]').tab('show');
		$('#mensagem').addClass('')
	});

	$("#voltar_aba2").click(function() {
		$('#myTab a[href="#profile"]').tab('show');
		$('#mensagem').addClass('')
	});

	$("#voltar_aba3").click(function() {
		$('#myTab a[href="#contact"]').tab('show');
		$('#mensagem').addClass('')
	});

	function preencherDadosIniciais(){
		dadosIniciais.numeroParecer = $("#numeroParecer").val();
		dadosIniciais.anoParecer = $("#ano").val();
		dadosIniciais.numeroOficio = $("#numeroOficio").val();
		dadosIniciais.anoOficio = $("#anoexercicio_field").val();
		dadosIniciais.itemOficio = $("#item_field").val();
		dadosIniciais.dataEnvio = $("#data").val();
		dadosIniciais.textoAnalisado = $("#obs1").val();
		dadosIniciais.tituloProjetoAnalisado = $("#obs2").val();
		dadosIniciais.documentosEnviados = $("#obs3").val();
	}

	$("#seguinte_aba2").click(function() {		
		preencherDadosIniciais()
		console.log('dadosIniciais: ', dadosIniciais)

		if (!dadosIniciais.numeroOficio) {
			$('#mensagem').addClass('text-danger')
			$('#mensagem').text("Preencha o Campo número do Ofício!")
		} else if (!dadosIniciais.textoAnalisado) {
			$('#mensagem').addClass('text-danger')
			$('#mensagem').text("Preencha o campo texto a ser analisado!")
		} else if (!dadosIniciais.tituloProjetoAnalisado) {
			$('#mensagem').addClass('text-danger')
			$('#mensagem').text("Preencha o campo título do Projeto a ser analisado!")
		} else if (!dadosIniciais.documentosEnviados) {
			$('#mensagem').addClass('text-danger')
			$('#mensagem').text("Preencha o campo documentos enviados!")
		} else {
			$('#myTab a[href="#profile"]').tab('show');
			$('#mensagem').text("")
		}
	});


	function preencherDadosDocumento(){
		dadosDocumento.tipoDocumento = document.querySelector('input[name="tipo-desenvolvimento"]:checked')?.value || null;
		dadosDocumento.periodoProjeto = $("#mesesSelect").val();
		dadosDocumento.cargaHoraria = $("#tipo-carga").val();
	}

	$("#seguinte_aba3").click(function() {

		preencherDadosDocumento()
		console.log('dadosDocumento: ', dadosDocumento)

		if (!dadosDocumento.tipoDocumento) {
			$('#mensagem').addClass('text-danger')
			$('#mensagem').text("Preencha o Campo Tipo de Documento Relatório! ")
		} else if (!dadosDocumento.periodoProjeto) {
			$('#mensagem').addClass('text-danger')
			$('#mensagem').text("Selecione o Tempo vigência do Relatório!")
		} else if (!dadosDocumento.cargaHoraria) {
			$('#mensagem').addClass('text-danger')
			$('#mensagem').text("Inclua as horas do projeto!")
		} else {
			$('#myTab a[href="#contact"]').tab('show');
			$('#mensagem').text("")
		}
	});

	function preencherDadosCoordenador(){
		dadosCoordenador.nome = $("#nome_coordenador").val();
		dadosCoordenador.sexo = $("#sexoCoordenador").val();
		dadosCoordenador.titulacao = $("#titulacaoCoordenador").val();
		dadosCoordenador.faculdade = $("#faculdadeCoordenador").val();
		dadosCoordenador.possuiOutro = $('input[name="possuiOutroCoordenador"]:checked')?.val() || null;
	}

	$("#seguinte_aba4").click(function() {
	
		preencherDadosCoordenador();
		console.log('dadosCoordenador: ', dadosCoordenador)

		$('#myTab a[href="#extra"]').tab('show');
		$('#mensagem').text("")
	});

	$(document).ready(function() {
		$('#salvar').click(function(event) {
			event.preventDefault(); 

			preencherDadosIniciais()
			preencherDadosDocumento()
			preencherDadosCoordenador()
			console.log(dadosIniciais)
			console.log(dadosDocumento)
			console.log(dadosCoordenador)

			fetch('/loginusuario/painel/paginas/gerarDocumento.php', {
				method: 'POST',
				headers: {'Content-Type': 'application/json'},
				body: JSON.stringify({
					dadosIniciais: dadosIniciais,
				})
			})
			.then(response => response.blob())
			.then(blob => {
				const url = window.URL.createObjectURL(blob);
				const a = document.createElement('a');
				a.style.display = 'none';
				a.href = url;
				a.download = 'relatorio_parecer.docx';
				document.body.appendChild(a);
				a.click();
				window.URL.revokeObjectURL(url);
			})
			.catch(error => console.error('Erro ao gerar o documento:', error));
		});
	});

	// Carregamento da foto para o formulari de membros 
	function carregarImg() {
		var target = document.getElementById('target');
		var file = document.querySelector("#foto").files[0];

		var reader = new FileReader();

		reader.onloadend = function() {
			target.src = reader.result;
		};

		if (file) {
			reader.readAsDataURL(file);

		} else {
			target.src = "";
		}
	}

	//Ajax função listar permissoes
	function listarPermissoes(id) {
		$.ajax({
			url: 'paginas/' + pag + "/listar_permissoes.php",
			method: 'POST',
			data: {
				id
			},
			dataType: "html",

			success: function(result) {
				$("#listar_permissoes").html(result);
				$('#mensagem_permissao').text('');
			}
		});
	}

	//Ajax função Add permissoes
	function adicionarPermissao(id, usuario) {
		$.ajax({
			url: 'paginas/' + pag + "/add_permissao.php",
			method: 'POST',
			data: {
				id,
				usuario
			},
			dataType: "html",

			success: function(result) {
				listarPermissoes(usuario);
			}
		});
	}

	//Ajax função marcar todos
	function marcarTodos() {
		let checkbox = document.getElementById('input-todos');
		var usuario = $('#id_permissoes').val();

		if (checkbox.checked) {
			adicionarPermissoes(usuario);
		} else {
			limparPermissoes(usuario);
		}
	}

	function adicionarPermissoes(id_usuario) {
		$.ajax({
			url: 'paginas/' + pag + "/add_permissoes.php",
			method: 'POST',
			data: {
				id_usuario
			},
			dataType: "html",

			success: function(result) {
				listarPermissoes(id_usuario);
			}
		});
	}

	//Ajax função limpar permissoes
	function limparPermissoes(id_usuario) {
		$.ajax({
			url: 'paginas/' + pag + "/limpar_permissoes.php",
			method: 'POST',
			data: {
				id_usuario
			},
			dataType: "html",

			success: function(result) {
				listarPermissoes(id_usuario);
			}
		});
	}
</script>