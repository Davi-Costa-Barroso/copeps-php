<?php
$pag = 'copeps';

if (@$copeps == 'ocultar') {
	echo '<script>window.location="../index.php"</script>';
	exit();
}


?>


<style>
/* Ajustes para o modal */
.modal-dialog {
    max-height: 80vh; /* Altura máxima do modal (80% da viewport) */
    display: flex;
    flex-direction: column;
}

.modal-content {
    overflow: hidden; /* Evita transbordo do conteudo */
    display: flex;
    flex-direction: column;
    height: 100%; /* Ocupa toda a altura do modal-dialog */
}

.modal-header {
    background-color: black; /* Fundo preto mantido */
    color: white !important; /* Texto branco */
    flex-shrink: 0; /* Impede que o header de encolher */
    position: sticky; /* Fixa o header no topo */
    top: 0;
    z-index: 1; /* Garante que fique acima do conteúdo rolável */
    padding-bottom: 0; /* Remove padding inferior para alinhar abas */
}

.modal-body {
    overflow-y: auto; /* Adiciona barra de rolagem vertical */
    flex-grow: 1; /* Ocupa o espaço restante */
    max-height: calc(95vh - 100px); /* Define altura máxima subtraindo o header(apareceu barra de rollagem) */
    padding: 20px; /* Padding padrão do Bootstrap, ajuste se necessário */
    margin-top: 0; /* Remove margem superior para alinhar com as abas */
}

/* Estilização das abas (mantendo seu estilo original) */
.nav-tabs .nav-link {
    color: #8cecff; /* Cor dos links */
    background-color: transparent;
    font-size: 1.02rem;
}

.nav-tabs .nav-link:hover {
    background-color: transparent;
    color: white;
    font-size: 1.3rem;
}

/* Botão de fechar (mantendo seu estilo original) */
.modal-header .close {
    color: white;
    font-size: 1.8rem;
    opacity: 1;
}

.modal-header .close:hover {
    color: #b1f1fc;
    font-size: 2.1rem;
}

/* Ajuste para o conteúdo das abas -  Garante que o conteúdo das abas seja rolável */
.tab-content {
    height: 100%; /* Ocupa toda a altura disponível no modal-body */
}

/* Remove a rolagem desnecessária que você adicionou inline */
.modal-dialog {
    overflow: unset; /* Remove o overflow: scroll inline */
    scrollbar-width: none; /* Remove a barra de rolagem do modal-dialog */
}
</style>



<style type="text/css">
.icon-container:hover .icon-salvar {
    font-size: 2em; /* Aumenta o tamanho do ícone ao passar o mouse na aba */
}

.icon-container {
    display: flex;
    align-items: center;
    justify-content: center;
    transition: background-color 0.3s ease; /* Suave transição */
}

.icon-salvar {
    font-size: 1.2em; /* Tamanho normal */
    transition: font-size 0.3s ease; /* Suave transição para o tamanho */
}
</style>



	
<style type="text/css">
	.custom-btn-dark {
    background-color: #343a40;
    color: #fff;
    border: none;
}

</style>


<style type="text/css">
	/* Ajusta o container da tabela */
        .table-container {
            width: auto;
            margin: 5%;
        }
</style>

<style type="text/css">
	.btn-fixo4 {
     position: fixed;
     top: 79px;
     left: 246px;
     z-index: 1000; 

}
</style>

<style type="text/css">
  .btn-fixo5 {
     position: fixed;
     top: 79px;
     left: 352px;
     z-index: 1000;
  }
</style>

<style type="text/css">
  .btn-fixo6 {
     position: fixed;
     top: 83px;
     left: 456px;
     z-index: 1000;
  }
</style>



<div class="table-container">

<!-- Botão Inserir novo parecer com a função "inserir()" via "ajax.js" -->
<a onclick="inserir()" title="Criar Parecer" type="button" class="btn btn-primary btn-fixo4"><span class="fa fa-plus"></span> Parecer</a>

<li class="dropdown head-dpdn2 btn-fixo6" style="display: inline-block;">
	<a href="#" data-toggle="dropdown" class="btn btn-danger dropdown-toggle btn-fixo5" id="btn-deletar" style="display:none"><span class="fa fa-trash-o"></span> Deletar</a>

	<ul class="dropdown-menu">
		<li>
			<div class="notification_desc2">
				<p>Excluir Selecionados? <a href="#" onclick="deletarSel()"><span class="text-danger">Sim</span></a></p>
			</div>
		</li>
	</ul>
</li>
</div>


<div class="bs-example widget-shadow" style="padding:15px" id="listar">
</div>


<input type="hidden" id="ids">

<!-- Modal Form Cadastro Parecer -->
<div class="modal fade" id="modalForm" tabindex="-1" aria-labelledby="exampleModalLabel" data-backdrop="static">
	<div class="modal-dialog modal-lg" role="document" style="width: 61%; max-height: 640px;">
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
							<li class="navbar" style="display: flex; align-items: center; justify-content: flex-start; margin-left: 120px;">
							    <button type="button" onclick="salvarParecer('atualizar')" class="btn btn-dark btn-lg icon-container" title="Salvar">
							        <span class="fa fa-floppy-o icon-salvar"></span>
							    </button>
							</li>
							<li class="navbar" style="display: flex; align-items: center; justify-content: flex-start; margin-left: 10px;">
							    <button 
									type="button" 
									onclick="escolherTipDownload()" 
									class="btn btn-dark btn-lg icon-container" 
									title="Download"
								>
							        <span class="fa fa-download icon-salvar"></span>
							    </button>
							</li>
						</ul>
					</small>
				</h4>
				<button id="btn-fechar" type="button" class="close" onclick="limparDados()" data-dismiss="modal" aria-label="Close" style="margin-top: -50px">
					<span>&times;</span>
				</button>
			</div>
			<form id="form">
				<div class="modal-body" style="margin-top: -20px">
					<div class="tab-content" id="myTabContent">
						<div class="tab-pane fade" id="home" role="tabpanel" aria-labelledby="home-tab">
							<div class="row">
								
								<div class="col-md-3 hidden">
									<label for="ano">Id:</label>
									<input type="text" class="form-control" id="id_dados" name="id_dados" readonly>
								</div>

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
										<option value="18">Item 17</option>
										<option value="19">Item 18</option>
										<option value="20">Item 19</option>
										<option value="21">Item 20</option>										
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
								<label>TEXTO A SER ANALISADO:* <small>(Max 10000 Caracteres)</small></label>
								<textarea maxlength="1000" type="text" class="textareag" name="obs1" id="obs1" required></textarea>
							</div>

							<div class="form-group">
								<label>TITULO DO PROJETO A SER ANALISADO:*</label>
								<textarea maxlength="500" type="text" class="textareag" name="obs2" id="obs2" required></textarea>
							</div>

							<div class="form-group">
								<label>DOCUMENTOS ENVIADOS:* <small>(Máx. 6)</small></label>
								<div id="input-container">
									<input oninput="verificarInput()" type="text" class="in-doc form-control" name="docs[]" id="doc1">
								</div>
								<button disabled type="button" id="add-input" class="btn btn-primary" onclick="addInput()">Adicionar Novo Documento</button>
							</div>

							<hr>
							<div align="right">
								<button type="button" id="seguinte_aba2" name="seguinte_aba2" class="btn btn-primary">Seguinte <span class="fa fa-arrow-right"></button>
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
										 $numeros = [
											1 => "Um", 2 => "Dois", 3 => "Três", 4 => "Quatro", 5 => "Cinco", 
											6 => "Seis", 7 => "Sete", 8 => "Oito", 9 => "Nove", 10 => "Dez", 
											11 => "Onze", 12 => "Doze", 13 => "Treze", 14 => "Quatorze", 15 => "Quinze", 
											16 => "Dezesseis", 17 => "Dezessete", 18 => "Dezoito", 19 => "Dezenove", 
											20 => "Vinte", 21 => "Vinte e um", 22 => "Vinte e dois", 23 => "Vinte e três", 24 => "Vinte e quatro"
										];
									
										for ($i = 1; $i <= 24; $i++) {
											$texto = ($i == 1) ? "mês" : "meses";
											$label = $i . " (" . $numeros[$i] . ") " . $texto;
											echo "<option value=\"$label\">$label</option>";
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
										<h4 class="modal-title" id="exampleModalLabel1" style="font-weight: bold;text-decoration: underline;">
											REQUISITOS PARA APROVAÇÃO DO PROJETO DE PESQUISA, PARA ATÉ 
											<span class="listar_checkbox5horas">
												5 HORAS
											</span>
											<span class="listar_checkbox10horas">
												10 HORAS
											</span>
											<span class="listar_checkbox15horas">
												15 HORAS
											</span>
											<span class="listar_checkbox20horas">
												20 HORAS
											</span>
										</h4>
									</div>

									<label>
										<input type="checkbox" value="ra_pesquisa" id="requisito_a_pesquisa" name="requisito_a_pesquisa" onchange="contarCheckboxPesquisa()"> 
										a) Orientação de pelo menos 
										<span class="listar_checkbox5horas listar_checkbox10horas">1 discente</span>
										<span class="listar_checkbox15horas listar_checkbox20horas">2 discentes</span>
										da graduação, da educação básica ou do ensino técnico e tecnológico, bolsista ou voluntário, por ano, no período de vigência do projeto anterior;
									</label><br><br>

									<label>
										<input type="checkbox" value="rb_pesquisa" id="requisito_b_pesquisa" name="requisito_b_pesquisa" onchange="contarCheckboxPesquisa()"> 
										b) Apresentação de pelo menos um trabalho em evento científico, por ano, no período de vigência do projeto anterior;
									</label><br><br>

									<label>
										<input type="checkbox" value="rc_pesquisa" id="requisito_c_pesquisa" name="requisito_c_pesquisa" onchange="contarCheckboxPesquisa()"> 
										c) Orientação ou coorientação na pós-graduação stricto sensu;
									</label><br><br>

									<label>
										<input type="checkbox" value="rd_pesquisa" id="requisito_d_pesquisa" name="requisito_d_pesquisa" onchange="contarCheckboxPesquisa()"> 
										d) Publicação em média de um artigo em revista indexada
										<span class="listar_checkbox5horas listar_checkbox10horas">, ou livro, ou capítulo de livro, por ano, no período de vigência do projeto anterior;</span>
										<span class="listar_checkbox15horas listar_checkbox20horas">por ano, no período de vigência do projeto anterior;</span>
									</label><br><br>

									<label>
										<input type="checkbox" value="re_pesquisa" id="requisito_e_pesquisa" name="requisito_e_pesquisa" onchange="contarCheckboxPesquisa()"> 
										e) Aprovação do projeto em edital da UFPA ou de agência de fomento.
									</label><br><br>
								</div>

								<div class="row">
									<div class="col-md-12 text-center 
									listar_checkbox5horas 
									listar_checkbox10horas 
									listar_checkbox15horas
									listar_checkbox20horas
									" style="margin-top: 20px; font-size: 20px;" >
										REQUISITOS PARA APROVAÇÃO DO PROJETO: 
										<span class="contadorPesquisa">0</span>/3
									</div>
								</div>
							</div>

							<div class="row bloqueado" id="bloco_ensino">
								<div class="col-md-12">
									<div class="modal-body">
										<h4 class="modal-title" id="exampleModalLabel2" style="font-weight: bold;text-decoration: underline;">
											REQUISITOS PARA APROVAÇÃO DO PROJETO DE ENSINO, PARA ATÉ
											<span class="listar_checkbox5horas">
												5 HORAS
											</span>
											<span class="listar_checkbox10horas">
												10 HORAS
											</span>
											<span class="listar_checkbox15horas">
												15 HORAS
											</span>
											<span class="listar_checkbox20horas">
												20 HORAS
											</span>
										</h4>
									</div>

									<label>
										<input type="checkbox" value="ra_ensino" id="requisito_a" name="requisito_a" onchange="contarCheckboxEnsino()"> 
									  Orientação de pelo menos
										<span class="listar_checkbox5horas listar_checkbox10horas"> 1 discente </span>
										<span class="listar_checkbox15horas listar_checkbox20horas"> 2 discentes</span>
										da graduação, da pós-graduação, da educação básica ou do ensino técnico e tecnológico em projeto de ensino, bolsista ou voluntário, por ano, no período de vigência do projeto anterior;
									</label><br><br>

									<label>
										<input type="checkbox" value="rb_ensino" id="requisito_b" name="requisito_b" onchange="contarCheckboxEnsino()"> 
										 Uma apresentação em evento de uma unidade institucional, por ano, no período de vigência do projeto anterior;
									</label><br><br>

									<label>
										<input type="checkbox" value="rc_ensino" id="requisito_c" name="requisito_c" onchange="contarCheckboxEnsino()"> 
										
										<span class="listar_checkbox5horas">Publicação do resultado do projeto em periódico;</span>
										<span class="listar_checkbox10horas">Publicação do resultado do projeto em periódico;</span>
										<span class="listar_checkbox15horas">Uma publicação em revista indexada;</span>
										<span class="listar_checkbox20horas">Uma publicação em revista indexada;</span>
									</label><br><br>

									<label>
										<input type="checkbox" value="rd_ensino" id="requisito_d" name="requisito_d" onchange="contarCheckboxEnsino()"> 
										Aprovação do projeto em edital da UFPA ou agência 
										<span class="listar_checkbox5horas">externa;</span>
										<span class="listar_checkbox10horas">externa;</span>
										<span class="listar_checkbox15horas">de fomento;</span>
										<span class="listar_checkbox20horas">de fomento;</span>
									</label><br><br>

									<label>
										<input type="checkbox" value="re_ensino" id="requisito_e" name="requisito_e" onchange="contarCheckboxEnsino()"> 
										Elaboração de material didático concreto;
									</label><br><br>

									<label>
										<input type="checkbox" value="rf_ensino" id="requisito_f" name="requisito_f" onchange="contarCheckboxEnsino()"> 
										 Elaboração de material didático virtual.
									</label><br><br>
								</div>

								<div class="row">
									<div class="col-md-12 text-center 
									listar_checkbox5horas 
									listar_checkbox10horas 
									listar_checkbox15horas
									listar_checkbox20horas
									" style="margin-top: 20px; font-size: 20px;" >
										REQUISITOS PARA APROVAÇÃO DO PROJETO: 
										<span class="contadorEnsino">0</span>
										/
										<span class="listar_checkbox5horas listar_checkbox10horas">3</span>
										<span class="listar_checkbox15horas listar_checkbox20horas">4</span>
									</div>
								</div>
							</div>

							<div class="row bloqueado" id="bloco_extensao">
								<div class="col-md-12">
									<div class="modal-body">
										<h4 class="modal-title" id="exampleModalLabel3" style="font-weight: bold;text-decoration: underline;">
											REQUISITOS PARA APROVAÇÃO DO PROJETO DE EXTENSÃO, PARA ATÉ
											<span class="listar_checkbox5horas">
												5 HORAS
											</span>
											<span class="listar_checkbox10horas">
												10 HORAS
											</span>
											<span class="listar_checkbox15horas">
												15 HORAS
											</span>
											<span class="listar_checkbox20horas">
												20 HORAS
											</span>
										</h4>
									</div>


									<label>
										<input type="checkbox" value="ra_extensao" id="requisito_a_extensao" name="requisito_a_extensao" onchange="contarCheckboxExtensao()"> 
										Orientação de pelo menos
										<span class="listar_checkbox5horas listar_checkbox10horas">
											1 dicente da graduação, da pós-graduação, da educação básica ou do ensino técnico e tecnológico em projeto de ensino, bolsista ou voluntário, por ano, no período de vigência do projeto anterior;
										</span>
										<span class="listar_checkbox15horas listar_checkbox20horas">
											2 dicentes da graduação, a educação básica ou do ensino técnico e tecnológico em projeto de ensino, bolsista ou voluntário, por ano, no período de vigência do projeto anterior;
										</span>
									</label><br><br>

									<label>
										<input type="checkbox" value="rb_extensao" id="requisito_b_extensao" name="requisito_b_extensao" onchange="contarCheckboxExtensao()"> 
										<span class="listar_checkbox5horas listar_checkbox10horas">
											Realização de uma oficina, palestra ou painel nas jornadas dos campi por ano, no período de vigência do projeto anterior;
										</span>

										<span class="listar_checkbox15horas listar_checkbox20horas">
											Publicação em média de um artigo em revista indexada por ano, no período de vigência do projeto anterior;
										</span>
										
									</label><br><br>

									<label>
										<input type="checkbox" value="rc_extensao" id="requisito_c_extensao" name="requisito_c_extensao" onchange="contarCheckboxExtensao()"> 				
										<span class="listar_checkbox5horas listar_checkbox10horas">
											Publicação de um resumo expandido em Anais, por ano;
										</span>

										<span class="listar_checkbox15horas listar_checkbox20horas">
											Aprovação do projeto em edital da UFPA ou agência de formento;
										</span>
									</label><br><br>

									<label>
										<input type="checkbox" value="rd_extensao" id="requisito_d_extensao" name="requisito_d_extensao" onchange="contarCheckboxExtensao()"> 
										<span class="listar_checkbox5horas listar_checkbox10horas">
											Elaboração de uma cartilha, por ano, no período de vigência do projeto anterior.
										</span>

										<span class="listar_checkbox15horas listar_checkbox20horas">
											Apresentação, à PROEX, de proposta original de atualização ou inovação das atividades de extensão de um curso de graduação da UFPA.
										</span>
									</label><br><br>
								</div>

								<div class="row">
									<div class="col-md-12 text-center 
									listar_checkbox5horas 
									listar_checkbox10horas 
									listar_checkbox15horas
									listar_checkbox20horas
									" style="margin-top: 20px; font-size: 20px;" >
										REQUISITOS PARA APROVAÇÃO DO PROJETO: 
										<span class="contadorExtensao">0</span>/3
									</div>
								</div>
							</div>

							<style>
								.bloqueado {
									display: none;
								}

								.listar_checkbox5horas, 
								.listar_checkbox10horas, 
								.listar_checkbox15horas,
								.listar_checkbox20horas {
									display: none;
								}
							</style>

							<hr>
							<div class="row">
								<div class="col-md-6">
									<button type="button" id="voltar_aba1" name="voltar_aba1" class="btn btn-primary"><span class="fa fa-arrow-left"> Voltar</button>
								</div>

								<div class="col-md-6" align="right">
									<button type="button" id="seguinte_aba3" name="seguinte_aba3" class="btn btn-primary">Seguinte <span class="fa fa-arrow-right"></button>
								</div>

							</div>
						</div>

						<div class="tab-pane fade" id="contact" role="tabpanel" aria-labelledby="contact-tab">

							<div class="row">
								<div class="col-md-8">
									<label>Nome do Coordenador</label>
									<select class="form-control sel" name="nome_coordenador" id="nome_coordenador" style="width:100%;">
										<option value="" disabled selected>- Selecione -</option> 
											<?php 
											$query = $pdo->query("SELECT * FROM corpo_docentes order by nome asc");
											$res = $query->fetchAll(PDO::FETCH_ASSOC);
											for($i=0; $i < @count($res); $i++){
												foreach ($res[$i] as $key => $value){}
													
													?>	
												<option value="<?php echo $res[$i]['nome'] ?>"><?php echo $res[$i]['nome'] ?></option>

											<?php } ?>
									</select>
									<!-- <input type="text" class="form-control" id="nome_coordenador" name="nome_coordenador" placeholder="Nome do Coordenador" > -->
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
										</select>
									</div>
								</div>

								<div class="col-md-8">
									<div class="form-group">
										<label for="faculdadeCoordenador">Faculdade do Coordenador:</label>
										<select class="form-control" id="faculdadeCoordenador" name="faculdadeCoordenador">
											<option value="" disabled selected>- Selecione -</option>
											<option value="Campus Universitário de Tucuruí - CAMTUC">Campus Universitário de Tucuruí - CAMTUC</option>
											<option value="Faculdade de Física - FACFIS">Faculdade de Física - FACFIS</option>
											<option value="Faculdade de Engenharia Sanitária e Ambiental - FAESA">Faculdade de Engenharia Sanitária e Ambiental - FAESA</option>
											<option value="Faculdade de Engenharia Civil - FEC">Faculdade de Engenharia Civil - FEC</option>
											<option value="Faculdade de Engenharia de Computação - FECOMP">Faculdade de Engenharia de Computação - FECOMP</option>
											<option value="Faculdade de Engenharia Elétrica - FEE">Faculdade de Engenharia Elétrica - FEE</option>
											<option value="Faculdade de Engenharia Mecânica - FEM">Faculdade de Engenharia Mecânica - FEM</option>
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
									<select class="form-control sel" name="nomeOutroCoordenador" id="nomeOutroCoordenador" style="width:100%;">
										<option value="" disabled selected>- Selecione -</option> 
											<?php 
											$query = $pdo->query("SELECT * FROM corpo_docentes order by nome asc");
											$res = $query->fetchAll(PDO::FETCH_ASSOC);
											for($i=0; $i < @count($res); $i++){
												foreach ($res[$i] as $key => $value){}
													
													?>	
												<option value="<?php echo $res[$i]['nome'] ?>"><?php echo $res[$i]['nome'] ?></option>

											<?php } ?>
									</select>
									<!-- <input type="text" class="form-control" id="nomeOutroCoordenador" name="nomeOutroCoordenador" placeholder="Nome do Outro Coordenador" > -->
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
									</select>
								</div>
							</div>
							<hr>
							<div class="row">
								<div class="col-md-6">
									<button type="button" id="voltar_aba2" name="voltar_aba2" class="btn btn-primary"><span class="fa fa-arrow-left"> Voltar</button>
								</div>

								<div class="col-md-6" align="right">
									<button type="button" id="seguinte_aba4" name="seguinte_aba4" class="btn btn-primary">Seguinte <span class="fa fa-arrow-right"></button>
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
											$query = $pdo->query("SELECT * FROM membros where comissao = 1 order by nome asc ");
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
									<button type="button" id="voltar_aba3" name="voltar_aba3" class="btn btn-primary"><span class="fa fa-arrow-left"> voltar</button>
								</div>

								<div class="col-md-6" align="right">
									<button 
										type="button" 
										onclick="salvarParecer('atualizar')" 
										class="btn btn-primary btn-lg"
									>
										<span class="fa fa-floppy-o"> 
										Salvar
									</button>
									<button 
										onclick="escolherTipDownload()"
										type="button"
										class="btn btn-success btn-lg"
									>
										<span class="fa fa-download"> 
											Baixar e salvar
										</button>
									<button type="button" class="btn btn-link btn-sm" data-dismiss="modal">
										<span class="fa fa-times" aria-hidden="true"> 
											sair
										</button>
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

<div id="loading" style="display: none; position: fixed; top: 0; left: 0; width: 100%; height: 100%; background: rgba(0, 0, 0, 0.5); z-index: 9999; display: flex; justify-content: center; align-items: center;">
    <div class="spinner" style="border: 4px solid #f3f3f3; border-top: 4px solid #3498db; border-radius: 50%; width: 50px; height: 50px; animation: spin 2s linear infinite;"></div>
</div>

<div class="modal fade" id="modalTipoDownload" tabindex="-1">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Escolha o formato do arquivo</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Fechar">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body text-center">
        <button id="baixarPdf" class="btn btn-danger m-2">PDF</button>
        <button id="baixarWord" class="btn btn-primary m-2">Word</button>
      </div>
    </div>
  </div>
</div>

<div id="popupAviso" style="
  display: none;
  position: fixed;
  bottom: 20px;
  right: 20px;
  background-color: #ffa726; /* laranja */
  color: white;
  padding: 12px 20px;
  border-radius: 8px;
  box-shadow: 0px 2px 6px rgba(0,0,0,0.3);
  font-size: 16px;
  z-index: 9999;
">
   <span class="fa fa-exclamation-triangle" aria-hidden="true" style="font-size: 20px;"></span> 
   <span id="popupTexto" style="margin-left: 10px; font-weight: 600;"></span>
</div>

<style>
@keyframes spin {
  0% { transform: rotate(0deg); }
  100% { transform: rotate(360deg); }
}
</style>

<script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>

<script type="text/javascript">
	$('#loading').hide();
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

				dados.nomeRelatorio = select.val();
				select.change(function() {
					dados.nomeRelatorio = $(this).val();
				});
				// Quando o segundo select muda, criar o terceiro select se necessário
				select.change(function() {
					var escolhidoSegundoSelect = select.val();
					if (escolhidoSegundoSelect === "Alocação de Carga horária") {
						var terceiroSelect = $('<div id="terceiro_select_container"></div>');
						terceiroSelect.prepend('<label for="tipo">Tipo de Projeto?</label>');
						terceiroSelect.append($('<select class="form-select" name="tipo" id="tipo">'));
						// terceiroSelect.find('#tipo').append($('<option>', {
						// 	value: "Projeto de Ensino",
						// 	text: "Projeto de Ensino"
						// }));
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

		if(!dados.nomeRelatorio){
			$('#mensagem').addClass('text-danger').text("Informe relatório");
		}
		dados.horasSelecionadas = horasSelecionadas;

		$('#bloco_pesquisa').hide();
		$('#bloco_ensino').hide();
		$('#bloco_extensao').hide();
		
		$('.listar_checkbox5horas').hide();
		$('.listar_checkbox10horas').hide();
		$('.listar_checkbox15horas').hide();
		$('.listar_checkbox20horas').hide();

		if(escolha === 'simc'){
			
			if(dados.nomeRelatorio.toLowerCase().includes("ensino")){
				$('#bloco_ensino').show();
			}else if(dados.nomeRelatorio.toLowerCase().includes("pesquisa")){
				$('#bloco_pesquisa').show();
			}else if(dados.nomeRelatorio.toLowerCase().includes("extensão")){
				$('#bloco_extensao').show();
			}

			if (horasSelecionadas === '5 (Cinco) horas') {
				$('.listar_checkbox5horas').show();
			} else if (horasSelecionadas === '10 (Dez) horas') {
				$('.listar_checkbox10horas').show();
			} else if (horasSelecionadas === '15 (Quinze) horas') {
				$('.listar_checkbox15horas').show();
			} else if (horasSelecionadas === '20 (Vinte) horas') {
				$('.listar_checkbox20horas').show();
			}
		}
	}

	$(document).on('change', '#tipo-carga, #tipo', function() {
		var horasSelecionadas = $('#tipo-carga').val();
		var escolha = $('input[name="tipo-carga"]:checked').val();
		console.log('Mudança de horas. Nova seleção:', horasSelecionadas);
		console.log('Escolha atual:', escolha);
		mostrarBlocosRequisitos(escolha, horasSelecionadas);
	});

	function contarCheckboxPesquisa() {
		var totalSelecionados = $('input[name^="requisito_a_pesquisa"]:checked, input[name^="requisito_b_pesquisa"]:checked, input[name^="requisito_c_pesquisa"]:checked, input[name^="requisito_d_pesquisa"]:checked, input[name^="requisito_e_pesquisa"]:checked').length;
		$('.contadorPesquisa').text(totalSelecionados);
		$.ajax({
			url: 'paginas/' + pag + '/listar_checkboxPesquisa.php',
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

	function contarCheckboxEnsino() {
		var totalSelecionados2 = $('input[name^="requisito_a"]:checked, input[name^="requisito_b"]:checked, input[name^="requisito_c"]:checked, input[name^="requisito_d"]:checked, input[name^="requisito_e"]:checked, input[name^="requisito_f"]:checked').length;
		$('.contadorEnsino').text(totalSelecionados2);
		$.ajax({
			url: 'paginas/' + pag + '/listar_checkboxEnsino.php',
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

	function contarCheckboxExtensao() {
		var totalSelecionados2 = $('input[name^="requisito_a_extensao"]:checked, input[name^="requisito_b_extensao"]:checked, input[name^="requisito_c_extensao"]:checked, input[name^="requisito_d_extensao"]:checked').length;
		$('.contadorExtensao').text(totalSelecionados2);
		$.ajax({
			url: 'paginas/' + pag + '/listar_checkboxExtensao.php',
			method: 'POST',
			data: {
				escolhido5: totalSelecionados2
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

		$('.sel').select2({
			dropdownParent: $('#modalForm')
		});
	});

$('#loading').hide();

var dados = {
	data: null,
	id_dados: "",
    numeroParecer: "",
    anoParecer: "",
    numeroOficio: "",
    itemOficio: "",
    dataEnvio: "",
	dataEnvio_nao_formatada: "",
    textoAnalisado: "",
    tituloProjetoAnalisado: "",
    documentosEnviados: [],

	TIPODOCUMENTO: "RELATÓRIO",
	nomeRelatorio: "",
    periodoProjeto: "",
    cargaHoraria: "",
	pedidoAprovacao: "",
	letra: "",
	paragrafo5: "",
	artgo: "",
	capitulo: "",
	proj_Ana_Enc: "",
	paragrafo7: "",
	descricaoProposta: "",

	nomeCoordenador: "",
    sexoCoordenador: "",
	PRNCoordenador: "",
	PRNTxtCoordenador: "",
    titulacaoCoordenador: "",
    faculdadeCoordenador: "",
	descricaoCoordenadores: "",
    possuiOutroCoordenador: "",

	nomeViceCoordenador: "",
	pronomeViceCoordenador: "",
	sexoViceCoordenador: "",
	titulacaoViceCoordenador: "",

	objetivoDescricaoProposta: "",
	objetivoProjeto: "",
	proposicaoOuRelatorio:"",
	aprovacaoFaculdade:"",
	paragrafo2: "",
	numeroDoc: "",
	dataAprovacao: null,
	obs5: "",
	justificativa: "",

	nomeRelator: "",
	sexoRelator: "",
	pronRelat: "",
	pronomeTxt: "",

	situacaoRelatorio: "",
	aprovOuReprov: "",

	paragrafo8: "", 
	partePrg8: "",
	comentariosParecer: "",
	paragrafo9: "",
	dataAtual: "",

	nomePresid: "",
	nomeDocTit1: "",
	nomeDocTit2: "",
	nomeDocSup1: "",
	nomeDocSup2: "",
	nomeTecTit: "",
	nomeTecSup: "",
	nomeDiscTit: "",
	nomeDiscSup: "",
	elementosCargaHoraria: []
};


listarMembrosComissao(function(result) {
	var contTit = 1;
	var contSup = 1;
	result.forEach(element => {
		if (element.tipo_membro === "Presidente") {
			dados.nomePresid = element.nome;
		}
		else if(element.tipo_membro === "Titular" && element.cargo === 2) {
			if(contTit === 1) {
				dados.nomeDocTit1 = element.nome;
			}
			else{
				dados.nomeDocTit2 = element.nome;

			}
			contTit ++;
		}
		else if(element.tipo_membro === "Suplente" && element.cargo === 2) {
			if(contSup === 1) {
				dados.nomeDocSup1 = element.nome;
			}
			else{
				dados.nomeDocSup2 = element.nome;

			}
			contSup++;
		}
		else if(element.tipo_membro === "Titular" && element.cargo === 3) {
			dados.nomeDiscTit = element.nome;

		}
		else if(element.tipo_membro === "Suplente" && element.cargo === 3) {
			dados.nomeDiscSup = element.nome;

		}
		else if(element.tipo_membro === "Titular" && element.cargo === 4) {
			dados.nomeTecTit = element.nome;

		}
		else  {
			dados.nomeTecSup = element.nome;
		}
		
	});
});

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

	$("#seguinte_aba2").click(function() {		
		if (!$("#numeroParecer").val()) {
			$('#mensagem').addClass('text-danger')
			$('#mensagem').text("Preencha o Campo número do Ofício!")
		} else if (!$("#obs1").val()) {
			$('#mensagem').addClass('text-danger')
			$('#mensagem').text("Preencha o campo texto a ser analisado!")
		} else if (!$("#obs2").val()) {
			$('#mensagem').addClass('text-danger')
			$('#mensagem').text("Preencha o campo título do Projeto a ser analisado!")
		} else if (!$("#doc1").val()) {
		 	$('#mensagem').addClass('text-danger')
		 	$('#mensagem').text("Adicione pelo menos um documento!")
		}
		else {
			$('#myTab a[href="#profile"]').tab('show');
			$('#mensagem').text("")
		}
	});

	$("#seguinte_aba3").click(function() {
		const TIPODOCUMENTO = document.querySelector('input[name="tipo-desenvolvimento"]:checked')?.value || null
		if (!TIPODOCUMENTO) {
			$('#mensagem').addClass('text-danger')
			$('#mensagem').text("Preencha o Campo Tipo de Documento Relatório! ")
		} else if (!$("#mesesSelect").val()) {
			$('#mensagem').addClass('text-danger')
			$('#mensagem').text("Selecione o Tempo vigência do Relatório!")
		} else if (!$("#tipo-carga").val()) {
			$('#mensagem').addClass('text-danger')
			$('#mensagem').text("Inclua as horas do projeto!")
		} else {
			$('#myTab a[href="#contact"]').tab('show');
			$('#mensagem').text("")
		}
	});

	function atualizarOpcoesTitulacaoCoordenador() {
		var selectTitulacaoCoordenador = document.getElementById("titulacaoCoordenador");
		var sexoCoordenador = document.getElementById("sexoCoordenador").value;

		selectTitulacaoCoordenador.innerHTML = '<option value="" disabled selected>- Selecione -</option>';
		if (sexoCoordenador === "masculino") {
			selectTitulacaoCoordenador.innerHTML += `
				<option value="Tec. Adm.">Tec. Adm.</option>
				<option value="Prof. Me.">Prof. Me.</option>
				<option value="Prof. Dr.">Prof. Dr.</option>
			`;
		} else if (sexoCoordenador === "feminino") {
			selectTitulacaoCoordenador.innerHTML += `
				<option value="Tec. Adm.">Tec. Adm.</option>
				<option value="Profª. Ma.">Profª. Ma.</option>
				<option value="Profª. Drª.">Profª. Drª.</option>
			`;
		}
	}

	function atualizarOpcoesTitulacaoOutroCoordenador() {
		var selectTitulacaoOutroCoordenador = document.getElementById("titulacaoOutroCoordenador");
		var sexoOutroCoordenador = document.getElementById("sexoOutroCoordenador").value;

		selectTitulacaoOutroCoordenador.innerHTML = '<option value="" disabled selected>- Selecione -</option>';
		if (sexoOutroCoordenador === "masculino") {
			selectTitulacaoOutroCoordenador.innerHTML += `
				<option value="Tec. Adm.">Tec. Adm.</option>
				<option value="Prof. Me.">Prof. Me.</option>
				<option value="Prof. Dr.">Prof. Dr.</option>
			`;
		} else if (sexoOutroCoordenador === "feminino") {
			selectTitulacaoOutroCoordenador.innerHTML += `
				<option value="Tec. Adm.">Tec. Adm.</option>
				<option value="Profª. Ma.">Profª. Ma.</option>
				<option value="Profª. Drª.">Profª. Drª.</option>
			`;
		}
	}
	document.getElementById("sexoCoordenador").addEventListener("change", atualizarOpcoesTitulacaoCoordenador);
	document.getElementById("sexoOutroCoordenador").addEventListener("change", atualizarOpcoesTitulacaoOutroCoordenador);

	// Ajuste o formato da data para ficar no estilo 20 de dezembro de 2024
	function ajustarFormatoData(data) {
		const meses = [
        "janeiro", "fevereiro", "março", "abril", "maio", "junho",
        "julho", "agosto", "setembro", "outubro", "novembro", "dezembro"
    	];

    	const partes = data?.split("-");

		const ano = partes[0]; // Ano
		const mes = parseInt(partes[1], 10) - 1; // Mês (convertendo para índice do array)
		const dia = partes[2]; // Dia

		return `${dia} de ${meses[mes]} de ${ano}`;
	}

	function getDataAtual() {
		const dataAtual = new Date();

		const ano = String(dataAtual.getFullYear()); // Pega os dois últimos dígitos do ano
		const mes = String(dataAtual.getMonth() + 1).padStart(2, '0'); // Adiciona zero à esquerda se necessário
		const dia = String(dataAtual.getDate()).padStart(2, '0'); // Adiciona zero à esquerda se necessário

		const dataFormatada = `${ano}-${mes}-${dia}`;

		return ajustarFormatoData(dataFormatada)
	}

	// Verifica se todos os campos foram preenchidos antes de baixar o relatorio
	function validarCampos() {
		if (!dados.numeroParecer) {
			const msg = "Informe número do parecer";
			$('#mensagem').addClass('text-danger');
			$('#mensagem').text(msg);
			mostrarPopupAviso(msg);
			console.log(msg);
			return false;
		}

		if (!dados.anoParecer) {
			const msg = "Informe ano do parecer";
			$('#mensagem').addClass('text-danger');
			$('#mensagem').text(msg);
			mostrarPopupAviso(msg);
			console.log("Erro: Ano do parecer não informado.");
			return false;
		}

		if (!dados.numeroOficio) {
			const msg = "Informe número do ofício";
			$('#mensagem').addClass('text-danger');
			$('#mensagem').text(msg);
			mostrarPopupAviso(msg);
			console.log("Erro: Número do ofício não informado.");
			return false;
		}

		if (!dados.itemOficio) {
			const msg = "Informe item do ofício";
			$('#mensagem').addClass('text-danger');
			$('#mensagem').text(msg);
			mostrarPopupAviso(msg);
			console.log("Erro: Item do ofício não informado.");
			return false;
		}

		if (!dados.dataEnvio) {
			const msg = "Informe a data de envio";
			$('#mensagem').addClass('text-danger');
			$('#mensagem').text(msg);
			mostrarPopupAviso(msg);
			console.log("Erro: Data de envio não informada.");
			return false;
		}

		if (!dados.textoAnalisado) {
			const msg = "Informe o texto analisado";
			$('#mensagem').addClass('text-danger');
			$('#mensagem').text(msg);
			mostrarPopupAviso(msg);
			console.log("Erro: Texto analisado não informado.");
			return false;
		}

		if (!dados.tituloProjetoAnalisado) {
			const msg = "Informe o título do projeto analisado";
			$('#mensagem').addClass('text-danger');
			$('#mensagem').text(msg);
			mostrarPopupAviso(msg);
			console.log("Erro: Título do projeto analisado não informado.");
			return false;
		}

		if (!dados.documentosEnviados) {
			const msg = "Informe os documentos enviados";
			$('#mensagem').addClass('text-danger');
			$('#mensagem').text(msg);
			mostrarPopupAviso(msg);
			console.log("Erro: Documentos enviados não informados.");
			return false;
		}

		if (!dados.TIPODOCUMENTO) {
			const msg = "Informe o tipo do documento";
			$('#mensagem').addClass('text-danger');
			$('#mensagem').text(msg);
			mostrarPopupAviso(msg);
			console.log("Erro: Tipo do documento não informado.");
			return false;
		}

		if (!dados.nomeRelatorio) {
			const msg = "Informe o relatório";
			$('#mensagem').addClass('text-danger');
			$('#mensagem').text(msg);
			mostrarPopupAviso(msg);
			console.log("Erro: Nome do relatório não informado.");
			return false;
		}

		if (!dados.periodoProjeto) {
			const msg = "Informe o período do projeto";
			$('#mensagem').addClass('text-danger');
			$('#mensagem').text(msg);
			mostrarPopupAviso(msg);
			console.log("Erro: Período do projeto não informado.");
			return false;
		}

		if (!dados.cargaHoraria) {
			const msg = "Informe a carga horária";
			$('#mensagem').addClass('text-danger');
			$('#mensagem').text(msg);
			mostrarPopupAviso(msg);
			console.log("Erro: Carga horária não informada.");
			return false;
		}

		if (!dados.nomeCoordenador) {
			const msg = "Informe o nome do coordenador";
			$('#mensagem').addClass('text-danger');
			$('#mensagem').text(msg);
			mostrarPopupAviso(msg);
			console.log("Erro: Nome do coordenador não informado.");
			return false;
		}

		if (!dados.sexoCoordenador) {
			const msg = "Informe o sexo do coordenador";
			$('#mensagem').addClass('text-danger');
			$('#mensagem').text(msg);
			mostrarPopupAviso(msg);
			console.log("Erro: Sexo do coordenador não informado.");
			return false;
		}

		if (!dados.titulacaoCoordenador) {
			const msg = "Informe a titulação do coordenador";
			$('#mensagem').addClass('text-danger');
			$('#mensagem').text(msg);
			mostrarPopupAviso(msg);
			console.log("Erro: Titulação do coordenador não informada.");
			return false;
		}

		if (!dados.faculdadeCoordenador) {
			const msg = "Informe a faculdade do coordenador";
			$('#mensagem').addClass('text-danger');
			$('#mensagem').text(msg);
			mostrarPopupAviso(msg);
			console.log("Erro: Faculdade do coordenador não informada.");
			return false;
		}

		if (!dados.possuiOutroCoordenador) {
			const msg = "Informe se possui outro coordenador";
			$('#mensagem').addClass('text-danger');
			$('#mensagem').text(msg);
			mostrarPopupAviso(msg);
			console.log("Erro: Informação sobre outro coordenador não informada.");
			return false;
		}

		if (!dados.descricaoProposta) {
			const msg = "Informe descrição de proposta.";
			$('#mensagem').addClass('text-danger');
			$('#mensagem').text(msg);
			mostrarPopupAviso(msg);
			console.log("Erro: Descrição de proposta não informada.");
			return false;
		}

		return true;
	}

	// Pega os dados do formulario do parecer e coloca no objeto dados para depois preencher no doc
	function preencherDados(){
		dados.id_dados = $("#id_dados").val();
		// Dados iniciais
		dados.numeroParecer = $("#numeroParecer").val();
		dados.anoParecer = $("#ano").val();
		dados.numeroOficio = $("#numeroOficio").val();
		dados.itemOficio = $("#item_field").val();
		dados.dataEnvio_nao_formatada = $("#data").val() || '';
		dados.dataEnvio = ajustarFormatoData($("#data").val()) || '';
		dados.textoAnalisado = $("#obs1").val();
		dados.tituloProjetoAnalisado = $("#obs2").val();

		documentosEnviados = []

		for (let i = 1; i <= 6; i++) {
			if($(`#doc${i}`).val()) {
				documentosEnviados.push(`(${String.fromCharCode(97 + (i))}) ` + $(`#doc${i}`).val())
				
			}			
		}

		if (documentosEnviados.length > 1) {
			const ultimoDocumento = documentosEnviados.pop();
			dados.documentosEnviados = documentosEnviados.join('; ') + ' e ' + ultimoDocumento;
		} else {
    		dados.documentosEnviados = documentosEnviados.join('');
		}

		// dados documentos
		// nomeRelatorio esta sendo adicionado na função mudarRelatorio()
		dados.TIPODOCUMENTO = document.querySelector('input[name="tipo-desenvolvimento"]:checked')?.value || null;
		dados.periodoProjeto = $("#mesesSelect").val();
		dados.cargaHoraria = $("#tipo-carga").val();
		// dados coordenador
		dados.nomeCoordenador = $("#nome_coordenador").val();
		dados.sexoCoordenador = $("#sexoCoordenador").val();
		dados.titulacaoCoordenador = $("#titulacaoCoordenador").val();
		dados.faculdadeCoordenador = $("#faculdadeCoordenador").val();
		dados.possuiOutroCoordenador = $('input[name="possuiOutroCoordenador"]:checked')?.val() || null;

		if(dados.possuiOutroCoordenador === "sim") {
			dados.nomeViceCoordenador = $("#nomeOutroCoordenador").val();
			dados.sexoViceCoordenador = $("#sexoOutroCoordenador").val();
			dados.titulacaoViceCoordenador = $("#titulacaoOutroCoordenador").val();
		}
		else {
			dados.textoComViceCoordenador = ""
			dados.nomeViceCoordenador = ""
			dados.pronomeViceCoordenador =  ""
			dados.sexoViceCoordenador =  ""
			dados.titulacaoViceCoordenador = "" 	
		}

		// dados relator
		dados.descricaoProposta = $("#obs4").val();
		
		dados.aprovacaoFaculdade = $("#aprovacaoFaculdade").val();
		dados.numeroDoc = $('#numeroDocumento').val();
		dados.dataAprovacao = $("#qualDia").val()
		dados.obs5 = $("#obs5").val();
		dados.justificativa = $("#obs5").val()
		dados.obs5 = '"' + dados.obs5 + '"'

		dados.sexoRelator = $("#sexoRelator").val()

		const selecionado = document.querySelector('input[name="parecerRelator"]:checked');
		if (selecionado) {
			dados.situacaoRelatorio =  selecionado.value
		} 

		dados.comentariosParecer = $("#obs6").val()
		
		const relator = document.getElementById('nomeRelator')
    	const selectedText = relator.options[relator.selectedIndex].text;
		
		dados.nomeRelator = selectedText;

    }

	$("#seguinte_aba4").click(function() {
		$('#myTab a[href="#extra"]').tab('show');
		$('#mensagem').text("")
	});

	// $(document).ready(function() {
	// 	$('#baixarParecer').click(function(event) {
	// 		event.preventDefault(); 
 	// 		baixarParecer();
	// 	});
	// });

	// Quando o botão PDF for clicado
	$('#baixarPdf').click(function() {
		$('#modalTipoDownload').modal('hide');
		// Chamada para baixar em PDF
		baixarParecer('pdf');
	});

	// Quando o botão Word for clicado
	$('#baixarWord').click(function() {
		$('#modalTipoDownload').modal('hide');
		// Chamada para baixar em Word
		baixarParecer('word');
	});

	function mostrarPopupAviso(texto) {
		const popup = document.getElementById('popupAviso');
		popup.textContent = '';  // limpa conteúdo anterior

		// Cria o ícone com span Font Awesome
		const icone = document.createElement('span');
		icone.className = 'fa fa-exclamation-triangle';
		icone.setAttribute('aria-hidden', 'true');
		icone.style.fontSize = '20px';
		icone.style.marginRight = '8px';

		// Adiciona o ícone e o texto ao popup
		popup.appendChild(icone);
		popup.appendChild(document.createTextNode(texto));

		popup.style.display = 'flex';

		setTimeout(() => { popup.style.display = 'none'}, 2500);
	}

	function escolherTipDownload() {
		preencherDados();
		if(!validarCampos()) return

		$('#modalForm').modal('hide');
		$('#modalTipoDownload').modal('show');
	}

	function baixarParecer(tipoDownload){

		salvarParecer();

		if(dados.sexoRelator === "feminino") {
			dados.pronRelat = "a"
			dados.pronomeTxt = "a"
		}
		else{
			dados.pronRelat = "o"
			dados.pronomeTxt = ""
		}
		
		if(dados.situacaoRelatorio === "aprovado") {
			dados.aprovOuReprov = "Aprovação"
			dados.paragrafo9 = "são suficientes para considerá-la aprovada, ratificando a decisão da Subunidade"
		}
		else{
			dados.aprovOuReprov = "Reprovação"
			dados.paragrafo9 = "não são suficientes para considerá-la aprovada, discordando da decisão da Subunidade"
		}
		if(dados.sexoCoordenador === "masculino") {
			dados.PRNCoordenador = "o"
			dados.PRNTxtCoordenador = ""
		}
		else{
			dados.PRNCoordenador = "a"
			dados.PRNTxtCoordenador = "a"
		}
		// Verifica se possui outro cordenador e se sim vai precisar adicionar o pronome e o titulo vice-coordenador
		if(dados.possuiOutroCoordenador === "sim") {
			if(dados.sexoViceCoordenador === "masculino") {
				dados.pronomeViceCoordenador = "o"
				dados.textoComViceCoordenador = " e pel" + dados.pronomeViceCoordenador + " vice-coordenador" + " " + dados.titulacaoViceCoordenador + " " +  dados.nomeViceCoordenador
			}
			else{
				dados.pronomeViceCoordenador = "a"
				dados.textoComViceCoordenador = " e pel" + dados.pronomeViceCoordenador + " vice-coordenadora" + " " + dados.titulacaoViceCoordenador + " " +  dados.nomeViceCoordenador

			}
		}

		// verificar o pronome do relatório ou proposição
		let pronomeRelatorio = ""

		if(dados.proposicaoOuRelatorio === "A proposição") {
			pronomeRelatorio = "a";
		}
		else{
			pronomeRelatorio = "o";

		}

		// verificar o pronome da faculdade
		let pronomeFaculdade = ""
		if(dados.faculdadeCoordenador?.startsWith("F")) {
			pronomeFaculdade = "a";
		}
		else{
			pronomeFaculdade = "o";

		}

		// I.TIPODOCUMENTO
		dados.descricaoCoordenadores = dados.titulacaoCoordenador + " " + dados.nomeCoordenador + dados.textoComViceCoordenador

		// Aqui define como deve ser a frase quando tem ou não carga horaria
		if(dados.cargaHoraria === 'desabilitado'){
			dados.cargaHoraria = 'sem alocação de Carga Horária';
			dados.partePrg8 = "não há necessidade de análise nos termos da Resolução Nº 4.918, de 2017, do CONSEPE, referente à segunda solicitação de liberação e às solicitações subsequentes."
		} else{
			let textos = [];
			let horasSelecionadasNumero = parseInt(dados.horasSelecionadas?.split(' ')[0]);
			let elementosCH = [];

			dados.cargaHoraria = 'com alocação de '+ dados.horasSelecionadas
			dados.partePrg8 = "deve-se verificar o atendimento aos critérios da Resolução Nº 4.918, de 2017, do CONSEPE. Observou-se que a proposição atendeu a todas as exigências da referida Resolução."
			
			elementosCH = capturarCheckboxesEspecificos(horasSelecionadasNumero, dados.nomeRelatorio)
			textos = elementosCH.map((element, index) => `(${String.fromCharCode(97 + index)}) ${element.texto.trim().replace(/[;.]$/, '')}`);

			if (textos.length > 1) {
				let penultimoEultimo = textos.slice(-2).map(txt => txt.replace(/[;.]$/, '')).join(' e '); // Remove o ";" e une com " e "
				dados.elementosCargaHoraria = textos.slice(0, -2).join(' ') + (textos.length > 2 ? ' ' : '') + penultimoEultimo;
			} else if (textos.length === 1) {
				dados.elementosCargaHoraria = textos[0]; // Apenas um elemento
			} else {
				dados.elementosCargaHoraria = []; // Nenhum elemento
			}
		}
		
		// Aqui verifica se o tipo de documento não é um relatorio final e nem parcial
		// Dependendo do tipo o primeiro topico pode ser DESCRIÇÃO ou RELATÓRIO
		if(dados.TIPODOCUMENTO === 'nao'){
			dados.paragrafo8 = "Acerca da quantidade de horas a serem alocadas, por se tratar de um projeto" + dados.cargaHoraria + "para " +  dados.PRNCoordenador + " " +  dados.coordenadorPRNTxtCoordenador + ", " + dados.partePrg8 
			// Topico 1
			dados.TIPODOCUMENTO = "DESCRIÇÃO";
			dados.pedidoAprovacao = "\u00A0pedido de aprovação de";
			dados.objetivoDescricaoProposta = '"' + dados.descricaoProposta + '".';
			dados.objetivoProjeto = 'O objetivo do projeto é';
			dados.proposicaoOuRelatorio = "A proposição";
			dados.letra = "i";
			dados.paragrafo5 = "COPEP “A aprovação dos projetos de pesquisa e extensão pelas subunidades, observando a carga horária deliberada”";

			if(dados.nomeRelatorio === "Projeto de Extensão") {
				dados.artgo = "192 a 197";
				dados.capitulo = "VII, da Extensão";
				dados.paragrafo7 = "na definição de extensão estabelecida no art. 192 do Regimento Geral da UFPA, pois é um processo educativo e científico articulado ao ensino e à pesquisa, de modo indissociável, que promove a relação transformadora entre a Universidade e a sociedade por meio de ações acadêmicas de natureza contínua que visem tanto à qualificação prática e à formação cidadã do discente quanto à melhoria da qualidade de vida da comunidade envolvida. O financiamento do projeto será com recursos próprios e pleiteando recursos externos, atendendo ao disposto no art. 195 do Regimento Geral."
				+ " Deste modo, " + dados.pronRelat + " relator" + dados.pronomeTxt + " afirma que a proposta está de acordo com as diretrizes da Instituição";

			}
			else{
				dados.artgo = "184 a 191";
				dados.capitulo = "VI, da Pesquisa";
				
				dados.paragrafo7 = "na definição de pesquisa estabelecida no art. 184 do Regimento Geral da UFPA, pois objetiva gerar, ampliar e difundir conhecimento científico e tecnológico. O financiamento do projeto será com recursos próprios, atendendo ao disposto no art. 185 do Regimento Geral, e ainda aproveitará os recursos humanos e laboratoriais da Universidade, conforme previsto na alínea 'a' do art. 186. A proposta possui um coordenador, atendendo também ao parágrafo 4º do art. 189 do Regimento Geral."
				+ " Deste modo, " + dados.pronRelat + " relator" + dados.pronomeTxt + " afirma que a proposta está de acordo com as diretrizes da Instituição";
			}
			dados.proj_Ana_Enc = "analisado";

		}else{
			// Topico 1
			dados.TIPODOCUMENTO = "RELATÓRIO";
			dados.pedidoAprovacao = '';
			dados.objetivoDescricaoProposta = "";
			dados.objetivoProjeto = "";
			dados.proposicaoOuRelatorio = "O relatório"
			dados.paragrafo5 = "CAPEP “emitir parecer sobre a aprovação dos relatórios parciais e finais das atividades de pesquisa e extensão observando os critérios estabelecidos para a concessão de carga horária para cada projeto”";
			dados.letra = "j";
			dados.proj_Ana_Enc = "encerrado";
			dados.paragrafo7 = "no que dispõe o art. 192 do Regimento Geral da instituição. Por meio da atividade, buscou-se " + dados.descricaoProposta 
							+ ". Também esteve adequado às demais disposições presentes no capítulo mencionado do Regimento Geral"

			if(dados.nomeRelatorio === 'Relatório Parcial de Projeto de Extensão' || dados.nomeRelatorio === 'Relatório Final de Projeto de Extensão'){
				dados.artgo = "192 a 197";
				dados.capitulo = "VII, da Extensão";
			}else{
				dados.artgo = "184 a 191";
				dados.capitulo = "VI, da Pesquisa";

			}
			dados.paragrafo8 = "As atividades de coordenação de projeto foram exercidas " + dados.cargaHoraria + " de carga horária. Portanto, deveria atender às exigências do Anexo 1 da Resolução 4.918, de 2017, do CONSEPE. Verificou-se, na documentação encaminhada, que foram atendidos os seguintes quesitos, nos termos da Resolução: "  + dados.elementosCargaHoraria + ". Assim, consideram-se cumpridas as exigências e disposições presentes no capítulo mencionado do Regimento Geral"
						
		}
		dados.dataAprovacao = ajustarFormatoData(dados.dataAprovacao) || '';
		// paragrafo 2
		if(dados.aprovacaoFaculdade === "ad-referendum") {
			dados.paragrafo2 = " ainda será aprovad" + pronomeRelatorio +  " em reunião da Subunidade Acadêmica, porém possui o Ad Referendum Nº " + dados.numeroDoc + "/" + dados.anoParecer + " -" + dados.faculdadeCoordenador?.split("-")[1] + ", emitido em " + dados.dataAprovacao + ", e o projeto é " + dados.cargaHoraria
		}
		else if(dados.aprovacaoFaculdade === "ata-reuniao-ordinaria"){
			dados.paragrafo2 = " foi aprovad" + pronomeRelatorio +  " em " + dados.dataAprovacao + " pel" + pronomeFaculdade + " " + dados.faculdadeCoordenador + ", foi aprovad"  + pronomeRelatorio +  " em Ata de Reunião Ordinária Nº " + dados.numeroDoc + "/" + dados.anoParecer + " -"  + dados.faculdadeCoordenador?.split("-")[1] + " da subunidade, por um período de " + dados.periodoProjeto + ", " + dados.cargaHoraria
		}
		else if (dados.aprovacaoFaculdade === "ata-reuniao-extraordinaria"){
			dados.paragrafo2 = " foi aprovad" + pronomeRelatorio +  " em " + dados.dataAprovacao + " pel" + pronomeFaculdade + " " + dados.faculdadeCoordenador + ", foi aprovad"  + pronomeRelatorio +  " em Ata de Reunião Extraordinária Nº " + dados.numeroDoc + "/" + dados.anoParecer + " -"  + dados.faculdadeCoordenador?.split("-")[1] + " da subunidade, por um período de " + dados.periodoProjeto + ", " + dados.cargaHoraria
		}
		else{
			dados.paragrafo2 = " não foi aprovad" + pronomeRelatorio +  " pela faculdade, a justificativa informada foi " + dados.obs5
		}

		dados.dataAtual = getDataAtual()	
		// Aqui define o nome do arquivo PDF
		const nomeArquivo = `PARECER N º ${dados.numeroParecer}, de ${dados.anoParecer} - OC ${dados.numeroOficio} - ITEM ${dados.itemOficio}`;
		// Aqui faz a requisção para baixar o PARECER em PDF
		$('#loading').show()
	
		const URL_API = tipoDownload === "pdf" ? 'gerarParecerPDF.php' : 'gerarParecerDOC.php';
		const extensao =  tipoDownload === "pdf" ? '.pdf' : '.docx';
		console.log(nomeArquivo + extensao)
		console.log(URL_API)
		fetch(`/loginusuario/painel/paginas/${URL_API}`, {
			method: 'POST',
			headers: {'Content-Type': 'application/json'},
			body: JSON.stringify({dados})
		})
		.then(async response => {
			if (!response.ok) {
				const errorJson = await response.json();
				throw errorJson;
			}
			return response.blob();
		})
		.then(blob => {
			// aqui construi o componente e ativa para baixar pelo navegador
			const url = window.URL.createObjectURL(blob);
			const a = document.createElement('a');
			a.style.display = 'none';
			a.href = url;
			a.download = nomeArquivo + extensao;
			document.body.appendChild(a);
			a.click();
			window.URL.revokeObjectURL(url);
		})
		.catch((error) => {
			alert('Erro na API ao gerar PARECER ')
		})
		$('#loading').hide()
	}
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
	let inputCount = 1;

	function verificarInput() {
		const addButton = document.getElementById("add-input");

		console.log(document.getElementById(`doc${inputCount}`)?.value)
		if(document.getElementById(`doc${inputCount}`)?.value) {
			addButton.disabled = false; 
		}
		else {
			addButton.disabled = true; 
		}
	}

	function addInput() {
		const container = document.getElementById("input-container");
		const addButton = document.getElementById("add-input");

		if (inputCount < 6) {
			inputCount++;
			const newInput = document.createElement("input");

			newInput.type = "text";
			newInput.className = "in-doc form-control";
			newInput.name = `docs[]`;
			newInput.id = `doc${inputCount}`;
			newInput.required = true;
			newInput.oninput = verificarInput;
			container.appendChild(newInput);
			addButton.disabled = true; 


		} else {
			addButton.disabled = true; 
		}

	}

	function getDataFormatada() {
		const agora = new Date();

		const ano = agora.getFullYear();
		const mes = String(agora.getMonth() + 1).padStart(2, '0'); // meses de 0 a 11
		const dia = String(agora.getDate()).padStart(2, '0');

		const horas = String(agora.getHours()).padStart(2, '0');
		const minutos = String(agora.getMinutes()).padStart(2, '0');
		const segundos = String(agora.getSeconds()).padStart(2, '0');

		return `${ano}-${mes}-${dia} ${horas}:${minutos}:${segundos}`;
	}
//************************ SALVAR PARECER ******************************************************
	function salvarParecer(acao) {
		// a função preencher dados pega os dados dos campos e armazena em um unico objeto
		preencherDados()
		// a função validar verifica se todos os campos necessarios foram preenchidos.
		if(!validarCampos()) return;
		dados.data = getDataFormatada(); // salva a data da ultima atualização
		console.log('dados do parecer: ', dados)
		// requisição para salvar no banco de dados, note que envia apenas um unico objeto que contém todos os dados

		// Prevenir múltiplos cliques
   	    $('#btn-salvar-parecer').prop('disabled', true);

		$.ajax({
			url: 'paginas/adicionarParecer.php',
			type: 'POST',
			data: dados,
			success: function(response) {
				let res = JSON.parse(response);
				if(res.id){
					// mostra o alert apenas se clicar no botão de salvar
					if(acao === "atualizar") alert('Parecer salvo com sucesso!')
					// adiciona o id para referenciar qual é o parecer salvo no banco
					$("#id_dados").val(res.id)
					listar();
					$('#modalForm').modal('hide');
				}
			},
			error: function() {
            alert('Erro na comunicação com o servidor.');
	        },
	        complete: function() {
	            $('#btn-salvar-parecer').prop('disabled', false);
	        }
	    });
	}
//*************************************************************************************************

	function listarMembrosComissao(callback) {
    // Faz a requisição AJAX
		$.ajax({
			url: 'paginas/' + pag + '/buscar_membros_comissao.php', 
			method: 'GET',
			dataType: 'json',
			success: function(result) {
				if (result.error) {
					console.error(result.error);
					return;
				}
				console.log(result)
				callback(result);


			},
			error: function(xhr, status, error) {
				console.error('Erro ao buscar membros:', error);
			}
		});
	}

	function capturarCheckboxesEspecificos(horas, tipoDocumento) {
    // Define os checkboxes relevantes com base no tipo de documento
		let seletores = "";
		switch (tipoDocumento) {
			case "Relatório Parcial de Projeto de Pesquisa" || "Projeto de Pesquisa" || "Relatório Final de Projeto de Pesquisa":
				seletores = 'input[name^="requisito_a_pesquisa"], input[name^="requisito_b_pesquisa"], input[name^="requisito_c_pesquisa"], input[name^="requisito_d_pesquisa"], input[name^="requisito_e_pesquisa"]';
				break;
			case "Relatório Parcial de Projeto de Ensino" || "Projeto de Ensino" || "Relatório Final de Projeto de Ensino" :
				seletores = 'input[name^="requisito_a"], input[name^="requisito_b"], input[name^="requisito_c"], input[name^="requisito_d"], input[name^="requisito_e"], input[name^="requisito_f"]';
				break;
			case "Relatório Parcial de Projeto de Extensão" || "Projeto de Extensão" || "Relatório Final de Projeto de Extensão":
				seletores = 'input[name^="requisito_a_extensao"], input[name^="requisito_b_extensao"], input[name^="requisito_c_extensao"], input[name^="requisito_d_extensao"]';
				break;
			default:
				console.error("Tipo de documento desconhecido:", tipoDocumento);
				return [];
		}

		// Seleciona os checkboxes com base nos seletores definidos
		const checkboxesRelevantes = document.querySelectorAll(seletores);

		let resultados = [];

		// Itera sobre os checkboxes relevantes
		checkboxesRelevantes.forEach((checkbox) => {
			if (checkbox.checked) {
				let textoAssociado = "";
				let elementosIrmaos = checkbox.parentNode.childNodes;

				elementosIrmaos.forEach(elemento => {
					if (elemento.nodeType === Node.TEXT_NODE) {
						textoAssociado += elemento.textContent.trim();
					} else if (elemento.nodeType === Node.ELEMENT_NODE && elemento.tagName === 'SPAN') {
						if (elemento.classList.contains(`listar_checkbox${horas}horas`)) {
							textoAssociado += elemento.textContent.trim();
						}
					}
				});

				resultados.push({
					valor: checkbox.value,
					texto: textoAssociado,
				});
			}
		});

		return resultados;
	}



</script>

<!-- jQuery e Bootstrap -->





<script>
// Torna o modal arrastável quando ele for exibido bootstrap 4
//precisa de - jquery-ui.js e 	
$(document).ready(function(){
    $("#modalForm").on("shown.bs.modal", function () {
        $(".modal-dialog").draggable({
            handle: ".modal-header", // Arrasta segurando a barra de título
            containment: "window"   // Mantém dentro da tela
        });
    });
});
</script>



