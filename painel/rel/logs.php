<?php 
require_once("../../conexao.php");

$dataInicial = $_GET['dataInicial'];
$dataFinal = $_GET['dataFinal'];
$acao = $_GET['acao'];
$tabelas = $_GET['tabelas'];
$usuario = $_GET['usuario'];


$dataInicialF = implode('/', array_reverse(explode('-', $dataInicial)));
$dataFinalF = implode('/', array_reverse(explode('-', $dataFinal)));

if($dataInicial == $dataFinal){
	$texto_apuracao = 'APURADO EM '.$dataInicialF;
}else if($dataInicial == '1980-01-01'){
	$texto_apuracao = 'APURADO EM TODO O PERÍODO';
}else{
	$texto_apuracao = 'APURAÇÃO DE '.$dataInicialF. ' ATÉ '.$dataFinalF;
}




if($acao == ''){
	$acao_rel = '';
}else{
	$acao_rel = ' - Ação: '.$acao;
}


if($tabelas == ''){
	$tabelas_rel = '';
}else{
	$tabelas_rel = ' - Tabela: '.$tabelas;
}


if($usuario == ''){
	$usuario_rel = '';
}else{
	$usuario_rel = ' - Usuário: '.$tabelas;
}


$acao = '%'.$acao.'%';
$tabelas = '%'.$tabelas.'%';
$usuario = '%'.$usuario.'%';


setlocale(LC_TIME, 'pt_BR', 'pt_BR.utf-8', 'pt_BR.utf-8', 'portuguese');
date_default_timezone_set('America/Sao_Paulo');
//$data_atual = date('Y-m-d'); //usei esse código pois deu erro utilizando o debaixo
$data_atual = date('d M Y', strtotime('today'));//achei na net
//$data_hoje = utf8_encode(strftime('%A, %d de %B de %Y', strtotime('today')));


?>




<!-- href="../../img/icone.png" -->

<!DOCTYPE html>
<html>
<head>
	<title>Relatório de Logs</title>

	<?php 
		if($relatorio_pdf != 'pdf'){
	 ?>
	<link rel="icon" href="<?php echo $url_sistema ?>/img/<?php echo $favicon ?>" type="image/x-icon">

	<?php } ?>

	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-wEmeIV1mKuiNpC+IOBjI7aAzPcEZeedi5yW5f2yOq55WWLwNGmvvx4Um1vskeMj0" crossorigin="anonymous">


	<style>

		@page {
			margin: 0px;

		}

		body{
			margin-top:0px;
			font-family:Times, "Times New Roman", Georgia, serif;
		}


		<?php if($relatorio_pdf == 'pdf'){ ?>

			.footer {
				margin-top:20px;
				width:100%;
				background-color: #ebebeb;
				padding:5px;
				position:absolute;
				bottom:0;
			}

		<?php }else{ ?>
			.footer {
				margin-top:20px;
				width:100%;
				background-color: #ebebeb;
				padding:5px;

			}

		<?php } ?>

		.cabecalho {    
			padding:10px;
			margin-bottom:30px;
			width:100%;
			font-family:Times, "Times New Roman", Georgia, serif;
		}

		.titulo_cab{
			color:#0340a3;
			font-size:17px;
		}

		
		
		.titulo{
			margin:0;
			font-size:28px;
			font-family:Arial, Helvetica, sans-serif;
			color:#6e6d6d;

		}

		.subtitulo{
			margin:0;
			font-size:12px;
			font-family:Arial, Helvetica, sans-serif;
			color:#6e6d6d;
		}



		hr{
			margin:8px;
			padding:0px;
		}


		
		.area-cab{
			
			display:block;
			width:100%;
			height:10px;

		}

		
		.coluna{
			margin: 0px;
			float:left;
			height:30px;
		}

		.area-tab{
			
			display:block;
			width:100%;
			height:30px;

		}


		.imagem {
			width: 200px;
			position:absolute;
			right:20px;
			top:10px;
		}

		.titulo_img {
		position: absolute;
		margin-top: 10px;
		margin-left: 10px;
		
		}

		.data_img {
		position: absolute;
		margin-top: 40px;
		margin-left: 10px;
		border-bottom:1px solid #000;
		font-size: 10px;
		}

		.endereco {
		position: absolute;
		margin-top: 50px;
		margin-left: 10px;
		border-bottom:1px solid #000;
		font-size: 10px;
		}
		

	</style>


</head>
<body>	

		
		<div class="titulo_cab titulo_img"><u>Relatório de Logs <?php echo $acao_rel ?> <?php echo $tabelas_rel ?> <?php echo $usuario_rel ?></u></div>	
		<div class="data_img"><?php echo mb_strtoupper($data_atual) ?></div>
		
		<?php 
			if($logo_rel != ''){
		 ?>
		<img class="imagem" src="<?php echo $url_sistema ?>img/<?php echo $logo_rel ?>" width="200px" height="60">

		<?php } ?>
	

	<br><br><br>
	<div class="cabecalho" style="border-bottom: solid 1px #0340a3">
	</div>

	<div class="mx-2" style="padding-top:10px ">

	<section class="area-cab">
			
		<div class="coluna" style="width:50%">
			<small><small><small><u><?php echo $texto_apuracao ?></u></small></small></small>
		</div>

		
		
		</section>

		<br>
	
	<?php 
	$query = $pdo->query("SELECT * FROM logs where acao LIKE '$acao' and usuario LIKE '$usuario' and tabela LIKE '$tabelas' and data >= '$dataInicial' and data <= '$dataFinal' order by id asc");
	$res = $query->fetchAll(PDO::FETCH_ASSOC);
	$total_reg = count($res);
	if($total_reg > 0){
		?>

		

	<small><small>
				<section class="area-tab" style="background-color: #f5f5f5;">
					
					<div class="linha-cab" style="padding-top: 5px;">
						<div class="coluna" style="width:10%">DATA</div>
						<div class="coluna" style="width:10%">HORA</div>
						<div class="coluna" style="width:13%">TABELA</div>
						<div class="coluna" style="width:12%">AÇÃO</div>
						<div class="coluna" style="width:20%">USUÁRIO</div>
						<div class="coluna" style="width:10%">ID REG</div>
						<div class="coluna" style="width:25%">DESCRIÇÃO REGISTRO</div>

					</div>
					
				</section><small></small>

				<div class="cabecalho mb-1" style="border-bottom: solid 1px #e3e3e3;">
				</div>

				<?php
				 for($i=0; $i < $total_reg; $i++){
					foreach ($res[$i] as $key => $value){}
					$data = $res[$i]['data'];
					$hora = $res[$i]['hora'];
					$tabela = $res[$i]['tabela'];
					$acao = $res[$i]['acao'];
					$usuario = $res[$i]['usuario'];
					$registro = $res[$i]['id_reg'];
					$descricao = $res[$i]['descricao'];

					$data = implode('/', array_reverse(explode('-', $data)));

					$query_con = $pdo->query("SELECT * FROM usuarios where id = '$usuario'");
					$res_con = $query_con->fetchAll(PDO::FETCH_ASSOC);
					if(count($res_con) > 0){
						$nome_usu = $res_con[0]['nome'];
					}else{
						$nome_usu= '';
					}

										
					
				?>

				<section class="area-tab" style="padding-top:5px">					
					<div class="linha-cab <?php echo $classe_item ?> <?php echo $inativa ?>">				
						<div class="coluna" style="width:10%"><?php echo $data ?></div>

						<div class="coluna" style="width:10%"><?php echo $hora ?></div>

						<div class="coluna" style="width:13%"><?php echo $tabela ?></div>

						<div class="coluna" style="width:12%"><?php echo $acao ?></div>

						<div class="coluna" style="width:20%"><?php echo $nome_usu ?></div>		

						<div class="coluna" style="width:10%"><?php echo $registro ?></div>		

						<div class="coluna" style="width:25%"><?php echo $descricao ?></div>		

		

					</div>
				</section>
				<div class="cabecalho" style="border-bottom: solid 1px #e3e3e3;">
				</div>

			<?php } ?>

			</small>



		</div>


		<div class="cabecalho mt-3" style="border-bottom: solid 1px #0340a3">
		</div>


	<?php }else{
		echo '<div style="margin:8px"><small><small>Sem Registros no banco de dados!</small></small></div>';
	} ?>



	<div class="col-md-12 p-2">
			<div class="" align="right; margin-right: 20px;" >
				<span class=""> <small><small><small><small>TOTAL DE REGISTROS</small> :  <?php echo $total_reg ?></small></small></small>  </span>
			</div>
		</div>
		<div class="cabecalho" style="border-bottom: solid 1px #0340a3">
		</div>




	<div class="footer"  align="center">
		<span style="font-size:15px"><?php echo $endereco_sistema ?> Tel: <?php echo $telefone_sistema ?></span> 
	</div>



</body>
</html>