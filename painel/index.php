<?php 
@session_start();

require_once("../conexao.php");
require_once("verificar.php"); 

 
$pag_inicial = 'home'; 

if(@$_SESSION['nivel'] != 'Administrador'){
	require_once("verificar_permissoes.php");
}

 
//verifica se existe uma variavel GET['pagina'] 
if(@$_GET['pagina'] != ""){      //se existir uma página, ou seja diferente de vazia 
	$pagina = @$_GET['pagina'];  // carrega a página que foi chamado
}else{
	$pagina = $pag_inicial;      //recebe a página home ou outra que vier
}


$id_usuario = @$_SESSION['id']; //Recupera o id do usuario que está logado, criado no autenticar.php

//RECUPERANDO DADOS DO USUARIO LOGADO p/a usar na modal Perfil e em qualquer página que eu quiser.
$query = $pdo->query("SELECT * from usuarios where id = '$id_usuario'");
$res = $query->fetchAll(PDO::FETCH_ASSOC);
$linhas = @count($res);
if($linhas > 0){
	$nome_usuario = $res[0]['nome'];
	$email_usuario = $res[0]['email'];
	$telefone_usuario = $res[0]['telefone'];
	$senha_usuario = $res[0]['senha'];
	$nivel_usuario = $res[0]['nivel'];
	$foto_usuario = $res[0]['foto'];
	$endereco_usuario = $res[0]['endereco']; 
	$matricula_usuario = $res[0]['matricula'];
	

}


//Eu coloquei isso pra esconder os cards dos usuarios
$esc_admin = '';
$esc_disc = '';
$esc_doc = '';
$esc_tec = '';

//Permissoes dos usuarios pra esconder os cards dos usuarios nos cards
if($nivel_usuario == "Discente"){
	$esc_disc = 'ocultar';
}else if($nivel_usuario == "Docente"){
	$esc_doc = 'ocultar';
}else if($nivel_usuario == "Tecnico-Administrativo"){
	$esc_tec = 'ocultar';
}else if($nivel_usuario == "Administrador"){
	$esc_admin = 'ocultar';
}

 

//variaveis p/ relatorios de Logs
$data_atual = date('Y-m-d');
$mes_atual = Date('m');
$ano_atual = Date('Y');
$data_mes = $ano_atual."-".$mes_atual."-01";
$data_ano = $ano_atual."-01-01";




?>
<!DOCTYPE HTML>
<html>
<head>
	<title><?php echo $nome_sistema ?></title>
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<link rel="shortcut icon" href="../img/icone.png" type="image/x-icon">

	<script type="application/x-javascript"> addEventListener("load", function() { setTimeout(hideURLbar, 0); }, false); function hideURLbar(){ window.scrollTo(0,1); } </script>

	<!-- Bootstrap Core CSS -->
	<link href="css/bootstrap.css" rel='stylesheet' type='text/css' />

	<!-- Custom CSS -->
	<link href="css/style.css" rel='stylesheet' type='text/css' />

	<!-- font-awesome icons CSS -->
	<link href="css/font-awesome.css" rel="stylesheet"> 
	<!-- //font-awesome icons CSS-->

	<!-- side nav css file -->
	<link href='css/SidebarNav.min.css' media='all' rel='stylesheet' type='text/css'/>
	<!-- //side nav css file -->

	<link rel="stylesheet" href="css/monthly.css"> 

	<!-- js-->
	<script src="js/jquery-1.11.1.min.js"></script>

	<!-- Ajax para funcionar Jquery-ui-1.14.1 - movimentar modal-->
	<script src="js/jquery-ui-1.12.1/jquery-ui.js"></script> 
	
	<script src="js/modernizr.custom.js"></script>

	<!--webfonts-->
	<link href="//fonts.googleapis.com/css?family=PT+Sans:400,400i,700,700i&amp;subset=cyrillic,cyrillic-ext,latin-ext" rel="stylesheet">
	<!--//webfonts--> 

	<!-- chart -->
	<script src="js/Chart.js"></script>
	<!-- //chart -->

	<!-- Metis Menu -->
	<script src="js/metisMenu.min.js"></script>
	<script src="js/custom.js"></script>
	<link href="css/custom.css" rel="stylesheet">
	<!--//Metis Menu -->
	<style>
		#chartdiv {
			width: 100%;
			height: 295px;
		}

	<style>
    	.alert-small-inline {
	        padding: 5px 10px;
	        font-size: 14px;
	        margin: 5px 0;
	        display: inline-block;
   		 }
	</style>
	</style>
	<!--pie-chart --><!-- index page sales reviews visitors pie chart -->
	<script src="js/pie-chart.js" type="text/javascript"></script>
	<script type="text/javascript">

		$(document).ready(function () {
			$('#demo-pie-1').pieChart({
				barColor: '#2dde98',
				trackColor: '#eee',
				lineCap: 'round',
				lineWidth: 8,
				onStep: function (from, to, percent) {
					$(this.element).find('.pie-value').text(Math.round(percent) + '%');
				}
			});

			$('#demo-pie-2').pieChart({
				barColor: '#8e43e7',
				trackColor: '#eee',
				lineCap: 'butt',
				lineWidth: 8,
				onStep: function (from, to, percent) {
					$(this.element).find('.pie-value').text(Math.round(percent) + '%');
				}
			});

			$('#demo-pie-3').pieChart({
				barColor: '#ffc168',
				trackColor: '#eee',
				lineCap: 'square',
				lineWidth: 8,
				onStep: function (from, to, percent) {
					$(this.element).find('.pie-value').text(Math.round(percent) + '%');
				}
			});


		});

	</script>
	<!-- //pie-chart --><!-- index page sales reviews visitors pie chart -->



	<!-- Inserção de DataTables local p/ listar -->
	<link rel="stylesheet" type="text/css" href="DataTables/datatables.min.css"/> <script src="DataTables/datatables.min.js"></script>
	<script type="text/javascript" src="DataTables/datatables.min.js"></script>




	<!-- Inserção do select2 via pasta -->
	<link href="select2/select2-4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
	<script src="select2/select2-4.1.0-rc.0/dist/js/select2.min.js"></script>
	 

	<!-- Estilização do select2 -->
	<style type="text/css">
		.select2-selection__rendered {
			line-height: 36px !important;
			font-size:16px !important;
			color:#666666 !important;

		}

		.select2-selection {
			height: 36px !important;
			font-size:16px !important;
			color:#666666 !important;

		}
	</style>  	
	

	
</head> 

<body class="cbp-spmenu-push">
	<div class="main-content">
		<div class="cbp-spmenu cbp-spmenu-vertical cbp-spmenu-left" id="cbp-spmenu-s1">
			<!--left-fixed -navigation-->
			<aside class="sidebar-left" style="overflow: scroll; height:100%; scrollbar-width: thin;">
				<nav class="navbar navbar-inverse">
					<div class="navbar-header">
						<button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target=".collapse" aria-expanded="false">
							<span class="sr-only">Toggle navigation</span>
							<span class="icon-bar"></span>
							<span class="icon-bar"></span>
							<span class="icon-bar"></span>
						</button>
						<h1><a class="navbar-brand" href="index.php"><span class="fa fa-graduation-cap"></span> CAMTUC<span class="dashboard_text"><?php echo $nome_sistema ?></span></a></h1>
					</div>
					<div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
						<ul class="sidebar-menu">
							<li class="header">MENU NAVEGAÇÃO</li>
							<li class="treeview <?php echo $home ?>">
								<a href="index.php">
									<i class="fa fa-home"></i> <span>Home</span>
								</a>
							</li>
							<li class="treeview <?php echo $menu_pessoas ?>">
								<a href="#">
									<i class="fa fa-users"></i>
									<span>Cadastros Pessoas</span> 
									<i class="fa fa-angle-left pull-right"></i>
								</a>
								<ul class="treeview-menu">
									<li class="<?php echo $usuarios ?>"><a href="usuarios"><i class="fa fa-angle-right"></i> Usuários</a></li>

									<li class="<?php echo $membros ?>"><a href="membros"><i class="fa fa-angle-right"></i> Membros</a></li>					
									
								</ul>
							</li>

							
							<li class="treeview <?php echo $menu_camaras ?>">
								<a href="#" title="COMISSÕES DO CONSELHO">
									<i class="fa fa-laptop"></i>
									<span>Câmaras</span>
									<i class="fa fa-angle-left pull-right"></i>
								</a>
								<ul class="treeview-menu">
									<li class="<?php echo $copeps ?>"><a href="copeps"><i class="fa fa-angle-right"></i> Copep</a></li>								
									
								</ul>
							</li>


							
							<li class="treeview <?php echo $menu_agenda ?>">
								<a href="menu_agenda" title="ANOTAÇÕES">
									<i class="fa fa-calendar-o"></i> <span>Agenda</span>
								</a>
							</li>

							

							<li class="treeview <?php echo $menu_logs ?>">
								<a href="#">
									<i class="fa fa-lock"></i>
									<span>Logs</span>
									<i class="fa fa-angle-left pull-right"></i>
								</a>
								<ul class="treeview-menu">
									<li class="<?php echo $ver_logs ?>"><a href="ver_logs"><i class="fa fa-angle-right"></i> Ver Logs</a></li>

									<li class="<?php echo $relatorio_logs ?>"><a href="#" data-toggle="modal" data-target="#RelLogs"><i class="fa fa-angle-right"></i> Relatórios de Logs</a></li>						
									
								</ul>
							</li>

							<li class="treeview <?php echo $menu_relatorio ?>">
								<a href="#">
									<i class="fa fa-file"></i>
									<span>Relatórios</span>
									<i class="fa fa-angle-left pull-right"></i>
								</a>
								<ul class="treeview-menu">									
									<li class="<?php echo $logs ?>"><a href="#" data-toggle="modal" data-target="#RelLogs"><i class="fa fa-angle-right"></i> Logs</a></li>						
									
								</ul>
							</li>

							
							<li class="treeview <?php echo $menu_cadastros ?>">
								<a href="#" title="CONFIGURAÇÕES GERAIS">
									<i class="fa fa-plus-square"></i>
									<span>Cadastros Gerais</span>   
									<i class="fa fa-angle-left pull-right"></i>
								</a>
								<ul class="treeview-menu">	

									<li class="<?php echo $coordenadores ?>"><a href="coordenadores" title="Corpo Docente"><i class="fa fa-angle-right"></i> Coordenadores</a></li>

									<li class="<?php echo $cargos ?>"><a href="cargos"><i class="fa fa-angle-right"></i> Cargos</a></li>

									<li class="<?php echo $comissoes ?>"><a href="comissoes"><i class="fa fa-angle-right"></i> Comissões</a></li>

									<li class="<?php echo $grupo_acessos ?>"><a href="grupo_acessos"><i class="fa fa-angle-right"></i> Grupos</a></li>

									<li class="<?php echo $acessos ?>"><a href="acessos"><i class="fa fa-angle-right"></i> Acessos</a></li>

								</ul>
							</li>
							

						</ul>
					</div>
					<!-- /.navbar-collapse -->
				</nav>
			</aside>
		</div>
		<!--left-fixed -navigation-->
		
		<!-- header-starts -->
		<div class="sticky-header header-section ">
			<div class="header-left">
				<!--toggle button start-->
				<button id="showLeftPush" data-toggle="collapse" data-target=".collapse"><i class="fa fa-bars"></i></button>
				<!--toggle button end-->
				<div class="profile_details_left"><!--notifications of menu start -->
					<ul class="nofitications-dropdown">
								

								<?php 
								$query2 = $pdo->query("SELECT * FROM tarefas where status = 'Agendada' and usuario = '$id_usuario' order by data asc, hora asc ");
								$res2 = $query2->fetchAll(PDO::FETCH_ASSOC);
								$tarefasPendentes_taref = @count($res2);

								$query = $pdo->query("SELECT * FROM tarefas where status = 'Agendada' and usuario = '$id_usuario' order by data asc, hora asc limit 6 ");
								$res = $query->fetchAll(PDO::FETCH_ASSOC);
								$tarefasPendentes_taref_limit = @count($res);
								 ?>
								<li class="dropdown head-dpdn">
									<a href="#" class="dropdown-toggle" data-toggle="dropdown" aria-expanded="false"><i class="fa fa-bell"></i><span class="badge blue1"><?php echo $tarefasPendentes_taref ?></span></a>
									<ul class="dropdown-menu">
										<li>
											<div class="notification_header">
												<h3>Você possui <?php echo $tarefasPendentes_taref ?> Tarefas Pendentes!</h3>
											</div>
										</li>

										<?php 
											if($tarefasPendentes_taref_limit > 0){
											for($i=0; $i < $tarefasPendentes_taref_limit; $i++){
												foreach ($res[$i] as $key => $value){}
											$id_taref = $res[$i]['id'];
											$titulo_taref = $res[$i]['titulo'];	
											$hora_taref = $res[$i]['hora'];
											$data_taref = $res[$i]['data'];
											
											$dataF_taref = implode('/', array_reverse(explode('-', $data_taref)));
											$horaF_taref = date("H:i", strtotime($hora_taref));
										 ?>
										<li>
											<a href="#">
											<div class="notification_desc">
												<p><i class="fa fa-calendar-o text-danger" style="margin-right: 3px"></i><?php echo $titulo_taref ?></p>
												<p><span><?php echo $dataF_taref ?> às <?php echo $horaF_taref ?></span></p>
											</div>
											<div class="clearfix"></div>	
											</a>
											<hr style="margin:2px">
										</li>
									<?php }} ?>								
									
										
										<li>
											<div class="notification_bottom">
												<a href="index.php?pagina=agenda">Ver toda Agenda</a>
											</div> 
										</li>
									</ul>
								</li>	
								
							</ul>
					<div class="clearfix"> </div>
				</div>
				<?php
					

					// ID do usuário logado
					$id_usuario_logado = isset($_SESSION['id']) ? $_SESSION['id'] : '0';

					// Verificar se $pdo está definido
					if (!isset($pdo)) {
					    echo "Erro: \$pdo não está definido";
					    exit;
					}

					// Testar conexão com o banco
					try {
					    $pdo->query("SELECT 1");
					} catch (PDOException $e) {
					    echo "Erro na conexão PDO: " . $e->getMessage();
					    exit;
					}

					// Pegar o nível do usuário logado
					$query_nivel = $pdo->query("SELECT nivel FROM usuarios WHERE id = '$id_usuario_logado'");
					$resultado_nivel = $query_nivel->fetch(PDO::FETCH_ASSOC);
					$nivel_usuario_logado = $resultado_nivel ? $resultado_nivel['nivel'] : 'Desconhecido';

					// Só continuar se o usuário logado for Administrador
					if ($nivel_usuario_logado === 'Administrador') {
					    // Consulta para buscar TODOS os usuários com ativo = 'Não', exceto o usuário logado
					    $query = $pdo->query("SELECT * FROM usuarios WHERE ativo = 'Não' AND id != '$id_usuario_logado'");
					    $res = $query->fetchAll(PDO::FETCH_ASSOC);
					    $usuariosDesbloquear = @count($res);

					    // Verificar se o alerta foi fechado anteriormente
					    if ($usuariosDesbloquear > 0 && !isset($_SESSION['alerta_fechado'])) {
					        // Construir a lista de nomes
					        $nomes = [];
					        foreach ($res as $usuario) {
					            $nomes[] = '"' . htmlspecialchars($usuario['nome']) . '"';
					        }
					        $mensagem = implode(', ', $nomes) . ' a ser(em) desbloqueado(s)!';

					        echo '<div class="alert alert-danger alert-dismissible" role="alert" style="padding: 5px 10px; font-size: 15px; margin: 15px 15px; display: inline-block;">';
					        echo $mensagem;
					        echo '<button type="button" class="close" data-dismiss="alert" aria-label="Close" onclick="marcarFechado();">';
					        echo '<span aria-hidden="true">×</span>';
					        echo '</button>';
					        echo '</div>';
					    }
					}
					?>
			</div>
			<div class="header-right">

				<div class="profile_details">		
					<ul>
						<li class="dropdown profile_details_drop">
							<a href="#" class="dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
								<div class="profile_img">	
									<span class="prfil-img"><img src="images/perfil/<?php echo $foto_usuario ?>" alt="" width="50px" height="50px"> </span> 
									<div class="user-name esc">
										<p><?php echo $nome_usuario ?></p>
										<span><?php echo $nivel_usuario ?></span>
									</div>
									<i class="fa fa-angle-down lnr"></i>
									<i class="fa fa-angle-up lnr"></i>
									<div class="clearfix"></div>	
								</div>	
							</a>
							<ul class="dropdown-menu drp-mnu">
								<li class="<?php echo $configuracoes ?>"> <a href="" data-toggle="modal" data-target="#modalConfig"><i class="fa fa-cog"></i> Configurações</a> </li> 
								<li> <a href="" data-toggle="modal" data-target="#modalPerfil"><i class="fa fa-user"></i> Perfil</a> </li> 								
								<li> <a href="logout.php"><i class="fa fa-sign-out"></i> Sair</a> </li> 
							</ul>
						</li>
					</ul>
				</div>
				<div class="clearfix"> </div>				
			</div>
			<div class="clearfix"> </div>	
		</div>
		<!-- //header-ends -->




		<!-- main content start-->
		<div id="page-wrapper">
			<?php 
			require_once('paginas/'.$pagina.'.php'); //carrega area de cada página, conteudo interno
			?>
		</div>


		<!--footer eu que coloquei-->
		<div class="footer">
			<p> CAMTUC/UFPA - Secretaria Executiva. Engenharia de Computação</a></p>		
		</div>
		<!--//footer-->



	</div>

	<!-- new added graphs chart js-->
	
	<script src="js/Chart.bundle.js"></script>
	<script src="js/utils.js"></script>
	
	
	
	<!-- Classie --><!-- for toggle left push menu script -->
	<script src="js/classie.js"></script>
	<script>
		var menuLeft = document.getElementById( 'cbp-spmenu-s1' ),
		showLeftPush = document.getElementById( 'showLeftPush' ),
		body = document.body;

		showLeftPush.onclick = function() {
			classie.toggle( this, 'active' );
			classie.toggle( body, 'cbp-spmenu-push-toright' );
			classie.toggle( menuLeft, 'cbp-spmenu-open' );
			disableOther( 'showLeftPush' );
		};


		function disableOther( button ) {
			if( button !== 'showLeftPush' ) {
				classie.toggle( showLeftPush, 'disabled' );
			}
		}
	</script>
	<!-- //Classie --><!-- //for toggle left push menu script -->

	<!--scrolling js-->
	<script src="js/jquery.nicescroll.js"></script>
	<script src="js/scripts.js"></script>
	<!--//scrolling js-->
	
	<!-- side nav js -->
	<script src='js/SidebarNav.min.js' type='text/javascript'></script>
	<script>
		$('.sidebar-menu').SidebarNav()
	</script>
	<!-- //side nav js -->
	
	
	
	<!-- Bootstrap Core JavaScript -->
	<script src="js/bootstrap.js"> </script>
	<!-- //Bootstrap Core JavaScript -->



	<!-- Mascaras JS -->
<script type="text/javascript" src="js/mascaras.js"></script>

<!-- Ajax para funcionar Mascaras JS -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.11/jquery.mask.min.js"></script> 

	
</body>
</html>





 
<!-- Modal Perfil -->
<div class="modal fade" id="modalPerfil" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<h4 class="modal-title" id="exampleModalLabel">Alterar Dados</h4>
				<button id="btn-fechar-perfil" type="button" class="close" data-dismiss="modal" aria-label="Close" style="margin-top: -25px">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<form id="form-perfil">
			<div class="modal-body"> 
				

					<div class="row">
						<div class="col-md-6">							
								<label>Nome</label>
								<input type="text" class="form-control" id="nome_perfil" name="nome" placeholder="Seu Nome" value="<?php echo $nome_usuario ?>" required>							
						</div>

						<div class="col-md-6">							
								<label>Email</label>
								<input type="email" class="form-control" id="email_perfil" name="email" placeholder="Seu Nome" value="<?php echo $email_usuario ?>" required>							
						</div>
					</div>


					<div class="row">
						<div class="col-md-4">							
								<label>Telefone</label>
								<input type="text" class="form-control" id="telefone_perfil" name="telefone" placeholder="Seu Telefone" value="<?php echo $telefone_usuario ?>" required>							
						</div>

						<div class="col-md-4">							
								<label>Senha</label>
								<input type="password" class="form-control" id="senha_perfil" name="senha" placeholder="Senha" value="<?php echo $senha_usuario ?>" required>							
						</div>

						<div class="col-md-4">							
								<label>Confirmar Senha</label>
								<input type="password" class="form-control" id="conf_senha_perfil" name="conf_senha" placeholder="Confirmar Senha" value="" required>							
						</div>

						
					</div>


					<div class="row">
						<div class="col-md-8">	
							<label>Endereço</label>
							<input type="text" class="form-control" id="endereco_perfil" name="endereco" placeholder="Seu Endereço" value="<?php echo $endereco_usuario ?>" >	
						</div>

						<div class="col-md-4">	
							<label>Matricula</label>
							<input type="text" class="form-control" id="matricula_perfil" name="matricula" placeholder="Sua Matricula" value="<?php echo $matricula_usuario ?>" >	
						</div>
					</div>
					


					<div class="row">
						<div class="col-md-8">							
								<label>Foto</label>
								<input type="file" class="form-control" id="foto_perfil" name="foto" value="<?php echo $foto_usuario ?>" onchange="carregarImgPerfil()">							
						</div>

						<div class="col-md-4">								
							<img src="images/perfil/<?php echo $foto_usuario ?>"  width="80px" id="target-usu">								
							
						</div>

						
					</div>


					<input type="hidden" name="id_usuario" value="<?php echo $id_usuario ?>">
				

				<br>
				<small><div id="msg-perfil" align="center"></div></small>
			</div>
			<div class="modal-footer">       
				<button type="submit" class="btn btn-primary"><span class="fa fa-floppy-o"> Salvar</button>
				<button type="button" class="btn btn-link btn-sm" data-dismiss="modal"><span class="fa fa-times"> sair</button>
			</div>
			</form>
		</div>
	</div>
</div>








<!-- Modal Config -->
<div class="modal fade" id="modalConfig" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
	<div class="modal-dialog modal-lg">
		<div class="modal-content">
			<div class="modal-header">
				<h4 class="modal-title" id="exampleModalLabel">Configurações do Sistema</h4>
				<button id="btn-fechar-config" type="button" class="close" data-dismiss="modal" aria-label="Close" style="margin-top: -25px">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<form id="form-config">
			<div class="modal-body">
				

					<div class="row">
						<div class="col-md-4">							
								<label>Nome do Projeto</label>
								<input type="text" class="form-control" id="nome_sistema" name="nome_sistema" placeholder="Delivery Interativo" value="<?php echo @$nome_sistema ?>" required>							
						</div>

						<div class="col-md-4">							
								<label>Email Sistema</label>
								<input type="email" class="form-control" id="email_sistema" name="email_sistema" placeholder="Email do Sistema" value="<?php echo @$email_sistema ?>" >							
						</div>


						<div class="col-md-4">							
								<label>Telefone Sistema</label>
								<input type="text" class="form-control" id="telefone_sistema" name="telefone_sistema" placeholder="Telefone do Sistema" value="<?php echo @$telefone_sistema ?>" required>							
						</div>

					</div>


					<div class="row">
						<div class="col-md-6">							
								<label>Endereço <small>(Rua Número Bairro e Cidade)</small></label>
								<input type="text" class="form-control" id="endereco_sistema" name="endereco_sistema" placeholder="Rua X..." value="<?php echo @$endereco_sistema ?>" >							
						</div>

						<div class="col-md-6">							
								<label>Instagram</label>
								<input type="text" class="form-control" id="instagram_sistema" name="instagram_sistema" placeholder="Link do Instagram" value="<?php echo @$instagram_sistema ?>">							
						</div>
					</div>



				<div class="row">					
					<div class="col-md-2">
						<div class="form-group"> 
							<label>Capturar Logs</label> 
							<select class="form-control" name="logs"  required> 
								<option <?php if($logs == 'Sim'){ ?>selected <?php } ?> value="Sim">Sim</option>
								<option <?php if($logs == 'Não'){ ?>selected <?php } ?> value="Não">Não</option>
							</select>
						</div>
					</div>

					<div class="col-md-3">						
						<div class="form-group"> 
							<label>Dias Limpar Logs</label> 
							<input type="number" class="form-control" name="dias_limpar_logs" value="<?php echo $dias_limpar_logs ?>" required> 
						</div>						
					</div>

					<div class="col-md-3">						
						<div class="form-group"> 
							<label>Relatório PDF / HTML</label> 
							<select class="form-control" name="rel"  required> 
								<option <?php if($relatorio_pdf == 'pdf'){ ?>selected <?php } ?> value="pdf">PDF</option>
								<option <?php if($relatorio_pdf == 'html'){ ?>selected <?php } ?> value="html">HTML</option>
							</select>
						</div>						
					</div>

				</div>

					

					<div class="row">
						<div class="col-md-4">						
								<div class="form-group"> 
									<label>Logo (*PNG)</label> 
									<input class="form-control" type="file" name="foto-logo" onChange="carregarImgLogo();" id="foto-logo">
								</div>						
							</div>
							<div class="col-md-2">
								<div id="divImg">
									<img src="../img/<?php echo $logo_sistema ?>"  width="80px" id="target-logo">									
								</div>
							</div>


							<div class="col-md-4">						
								<div class="form-group"> 
									<label>Ícone (*Png)</label> 
									<input class="form-control" type="file" name="foto-icone" onChange="carregarImgIcone();" id="foto-icone">
								</div>						
							</div>
							<div class="col-md-2">
								<div id="divImg">
									<img src="../img/<?php echo $icone_sistema ?>"  width="50px" id="target-icone">									
								</div>
							</div>
						
					</div>


 

					<div class="row">
							<div class="col-md-4">						
								<div class="form-group"> 
									<label>Logo Relatório (*Jpg) 200x60</label> 
									<input class="form-control" type="file" name="foto-logo-rel" onChange="carregarImgLogoRel();" id="foto-logo-rel">
								</div>						
							</div>
							<div class="col-md-2">
								<div id="divImg">
									<img src="../img/<?php echo @$logo_rel ?>"  width="80px" id="target-logo-rel">									
								</div>
							</div>


						
					</div>					
				

				<br>
				<small><div id="msg-config" align="center"></div></small>
			</div>
			<div class="modal-footer">       
				<button type="submit" class="btn btn-primary"><span class="fa fa-floppy-o"> Salvar</button>
				<button type="button" class="btn btn-link btn-sm" data-dismiss="modal"><span class="fa fa-times"> sair</button>
			</div>
			</form>
		</div>
	</div>
</div>










<!-- Modal Rel Logs -->
<div class="modal fade" id="RelLogs" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h4 class="modal-title" id="exampleModalLabel">Relatório de Logs
					<small>(
										<a href="#" onclick="datas('1980-01-01', 'tudo-Logs', 'Logs')">
											<span style="color:#000" id="tudo-Logs">Tudo</span>
										</a> / 
									<a href="#" onclick="datas('<?php echo $data_atual ?>', 'hoje-Logs', 'Logs')">
											<span id="hoje-Logs">Hoje</span>
										</a> /
										<a href="#" onclick="datas('<?php echo $data_mes ?>', 'mes-Logs', 'Logs')">
											<span style="color:#000" id="mes-Logs">Mês</span>
										</a> /
										<a href="#" onclick="datas('<?php echo $data_ano ?>', 'ano-Logs', 'Logs')">
											<span style="color:#000" id="ano-Logs">Ano</span>
										</a> 
									)</small>



				</h4>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close" style="margin-top: -20px">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<form method="post" action="rel/logs_class.php" target="_blank">
			<div class="modal-body">

				<div class="row">
					<div class="col-md-6">						
						<div class="form-group"> 
							<label>Data Inicial</label> 
							<input type="date" class="form-control" name="dataInicial" id="dataInicialRel-Logs" value="<?php echo date('Y-m-d') ?>" required> 
						</div>						
					</div>
					<div class="col-md-6">
						<div class="form-group"> 
							<label>Data Final</label> 
							<input type="date" class="form-control" name="dataFinal" id="dataFinalRel-Logs" value="<?php echo date('Y-m-d') ?>" required> 
						</div>
					</div>

				</div>


				<div class="row">
					<div class="col-md-4">						
						<div class="form-group"> 
							<label>Ações</label> 
							<select class="form-control" name="acao">
								<option value="">Selecionar Ação</option>
								<option value="login">Login</option>
								<option value="inserção">Inserção</option>
								<option value="exclusão">Exclusão</option>
								<option value="edição">Edição</option>
								<option value="logout">Logout</option>
							</select> 
						</div>						
					</div>
					
					<div class="col-md-4">						
						<div class="form-group"> 
							<label>Usuário</label> 
							<select class="form-control sel2index" name="usuario" style="width:100%;">
								<option value="">Selecionar Usuário</option>
								<?php 
									$query = $pdo->query("SELECT * FROM usuarios order by nome asc");
									$res = $query->fetchAll(PDO::FETCH_ASSOC);
									for($i=0; $i < @count($res); $i++){
										foreach ($res[$i] as $key => $value){}

											?>	
										<option value="<?php echo $res[$i]['id'] ?>"><?php echo $res[$i]['nome'] ?></option>

									<?php } ?>
							</select> 
						</div>						
					</div>


					<div class="col-md-4">						
						<div class="form-group"> 
							<label>Tabelas</label> 
							<select class="form-control sel2index" name="tabela" style="width:100%;">
								<option value="">Selecionar Tabela</option>
								<?php 
									$query = $pdo->query("SELECT table_name FROM information_schema.tables where table_schema = 'loginsenha'");							
									$res = $query->fetchAll(PDO::FETCH_ASSOC);

									for($i=0; $i < @count($res); $i++){
										foreach ($res[$i] as $key => $value){}

											?>	
										<option value="<?php echo $res[$i]['table_name'] ?>"><?php echo $res[$i]['table_name'] ?></option>

									<?php } ?>
							</select> 
						</div>						
					</div>

				</div>	
				

			</div>

			<div class="modal-footer">
				<button type="submit" class="btn btn-primary">Gerar Relatório</button>
			</div>
			</form>

		</div>
	</div>
</div>







<script type="text/javascript">
	function carregarImgPerfil() {
    var target = document.getElementById('target-usu');
    var file = document.querySelector("#foto_perfil").files[0];
    
        var reader = new FileReader();

        reader.onloadend = function () {
            target.src = reader.result;
        };

        if (file) {
            reader.readAsDataURL(file);

        } else {
            target.src = "";
        }
    }
</script>







 <!--Ajax p/a Inserir o Modal Perfil(quando for submit o botão salvar) -->
 <script type="text/javascript">
	$("#form-perfil").submit(function () {

		event.preventDefault();
		var formData = new FormData(this);

		$.ajax({
			url: "editar-perfil.php",
			type: 'POST',
			data: formData,

			success: function (mensagem) {
				$('#msg-perfil').text('');
				$('#msg-perfil').removeClass()
				if (mensagem.trim() == "Editado com Sucesso") {

					$('#btn-fechar-perfil').click();
					location.reload();	//comando em script p/a atualização pagina			
						

				} else {

					$('#msg-perfil').addClass('text-danger')
					$('#msg-perfil').text(mensagem)
				}


			},

			cache: false,
			contentType: false,
			processData: false,

		});

	});
</script>






<!--Ajax p/a Inserir o Modal Config(quando for submit o botão salvar) -->
 <script type="text/javascript">
	$("#form-config").submit(function () {

		event.preventDefault();
		var formData = new FormData(this);

		$.ajax({
			url: "editar-config.php",
			type: 'POST',
			data: formData,

			success: function (mensagem) {
				$('#msg-config').text('');
				$('#msg-config').removeClass()
				if (mensagem.trim() == "Editado com Sucesso") {

					$('#btn-fechar-config').click();
					location.reload();				
						

				} else {

					$('#msg-config').addClass('text-danger')
					$('#msg-config').text(mensagem)
				}


			},

			cache: false,
			contentType: false,
			processData: false,

		});

	});
</script>




<script type="text/javascript">
	function carregarImgLogo() {
    var target = document.getElementById('target-logo');
    var file = document.querySelector("#foto-logo").files[0];
    
        var reader = new FileReader();

        reader.onloadend = function () {
            target.src = reader.result;
        };

        if (file) {
            reader.readAsDataURL(file);

        } else {
            target.src = "";
        }
    }
</script>





<script type="text/javascript">
	function carregarImgLogoRel() {
    var target = document.getElementById('target-logo-rel');
    var file = document.querySelector("#foto-logo-rel").files[0];
    
        var reader = new FileReader();

        reader.onloadend = function () {
            target.src = reader.result;
        };

        if (file) {
            reader.readAsDataURL(file);

        } else {
            target.src = "";
        }
    }
</script>





<script type="text/javascript">
	function carregarImgIcone() {
    var target = document.getElementById('target-icone');
    var file = document.querySelector("#foto-icone").files[0];
    
        var reader = new FileReader();

        reader.onloadend = function () {
            target.src = reader.result;
        };

        if (file) {
            reader.readAsDataURL(file);

        } else {
            target.src = "";
        }
    }
</script>




<!--Ajax p/a select2index) -->
<script type="text/javascript">
	$(document).ready(function() {
		$('.sel2index').select2({
			dropdownParent: $('#RelLogs')
		});
	});
</script>



<!--scripts p/a datas Rel de Logs -->
<script type="text/javascript">
	function datas(data, id, campo){
		var data_atual = "<?=$data_atual?>";
		$('#dataInicialRel-'+campo).val(data);
		$('#dataFinalRel-'+campo).val(data_atual);

		document.getElementById('hoje-'+campo).style.color = "#000";
		document.getElementById('mes-'+campo).style.color = "#000";
		document.getElementById(id).style.color = "blue";	
		document.getElementById('tudo-'+campo).style.color = "#000";
		document.getElementById('ano-'+campo).style.color = "#000";
		document.getElementById(id).style.color = "blue";		
	}
</script>




<script>
function marcarFechado() {
    localStorage.setItem('alerta_fechado', 'true');
    fetch('marcar_fechado.php', { method: 'POST' })
        .then(response => console.log('Alerta marcado como fechado'))
        .catch(error => console.error('Erro:', error));
}

document.addEventListener('DOMContentLoaded', function() {
    if (localStorage.getItem('alerta_fechado') === 'true' && <?php echo isset($_SESSION['alerta_fechado']) ? 'false' : 'true'; ?>) {
        fetch('marcar_fechado.php', { method: 'POST' });
    }
});
</script>



