<?php 
require_once("../conexao.php");
@session_start();
$id_usuario = $_SESSION['id'];

$home = 'ocultar';
$configuracoes = 'ocultar';  

//grupo pessoas
$usuarios = 'ocultar';
$membros = 'ocultar';

//grupo cadastros
$grupo_acessos = 'ocultar';
$acessos = 'ocultar';
$cargos = 'ocultar';
$comissoes = 'ocultar';
$coordenadores = 'ocultar';

//grupo logs  
$ver_logs = 'ocultar';
$relatorio_logs = 'ocultar';


//grupo Agenda
$agenda = 'ocultar';


//grupo Relatorios
$logs = 'ocultar';


//grupo Câmaras
$copeps = 'ocultar';


//buscando o usuario p/a saber quais permissoes ele tem
$query = $pdo->query("SELECT * FROM usuarios_permissoes where usuario = '$id_usuario'");
$res = $query->fetchAll(PDO::FETCH_ASSOC);
$total_reg = @count($res);
if($total_reg > 0){
	for($i=0; $i < $total_reg; $i++){
		foreach ($res[$i] as $key => $value){}
		$permissao = $res[$i]['permissao'];

		$query2 = $pdo->query("SELECT * FROM acessos where id = '$permissao'");
		$res2 = $query2->fetchAll(PDO::FETCH_ASSOC);
		$nome = $res2[0]['nome'];
		$chave = $res2[0]['chave'];
		$id = $res2[0]['id'];

		if($chave == 'home'){ //a chave vem do Cadastro Gerais/Acessos/Chave
			$home = '';  //home é ativada    - $home é declarado la em cima
		}

		if($chave == 'configuracoes'){
			$configuracoes = '';  //configuracoes é ativada
		}


		if($chave == 'usuarios'){
			$usuarios = '';  //usuarios é ativada
		}


		if($chave == 'grupo_acessos'){
			$grupo_acessos = '';  //é ativada
		}

		if($chave == 'coordenadores'){
			$coordenadores = '';  //é ativada
		}

		if($chave == 'acessos'){
			$acessos = '';     // e ativada
		}

		if($chave == 'cargos'){
			$cargos = '';     // e ativada
		}

		if($chave == 'comissoes'){
			$comissoes = '';     // e ativada
		}

		if($chave == 'membros'){
			$membros = '';     //membros é ativada
		}

		if($chave == 'ver_logs'){
			$ver_logs = '';     //ver_logs é ativada
		}

		if($chave == 'relatorio_logs'){
			$relatorio_logs = '';     //relatorio_logs é ativada
		}

		if($chave == 'agenda'){
			$agenda = '';     //relatorio_logs é ativada
		}


		if($chave == 'logs'){
			$logs = '';     //relatorio_logs é ativada
		}


		if($chave == 'copep'){
			$copeps = '';     //relatorio_logs é ativada
		}



	}

}



//Busca qual a permissão o usuario tem p/a poder habilitar a pagina inicial
$pag_inicial = ''; 
if($home != 'ocultar'){
	$pag_inicial = 'home';
}else{ //buscar nas permissões uma permissão p/a virar página inicial
	$query = $pdo->query("SELECT * FROM usuarios_permissoes where usuario = '$id_usuario' order by id asc limit 1");
	$res = $query->fetchAll(PDO::FETCH_ASSOC);
	$total_reg = @count($res);	
	if($total_reg > 0){
		for($i=0; $i<$total_reg; $i++){
			$permissao = $res[$i]['permissao'];		
			$query2 = $pdo->query("SELECT * FROM acessos where id = '$permissao'");
			$res2 = $query2->fetchAll(PDO::FETCH_ASSOC);
			if($res2[0]['pagina'] == 'Não'){
				continue;
			}else{
				$pag_inicial = $res2[0]['chave'];
				break;
			}	
				
		}
				

	}else{
		//echo 'Você não tem permissão para acessar nenhuma página, entre em contato com o administrador!';
		echo '<script>window.alert("Você não tem permissão para acessar nenhuma página, acione o administrador!")</script>'; //eu que coloquei
		echo '<script>window.location="../index.php"</script>'; //eu que coloquei
		
		exit();
		 
	}
}



//Ocultar Individualmente do Menu Pessoas
if($usuarios == 'ocultar' and $membros == 'ocultar'){
	$menu_pessoas = 'ocultar';
}else{
	$menu_pessoas = '';
}


//Ocultar Individualmente do Menu Agenda
if($agenda  == 'ocultar'){
	$menu_agenda = 'ocultar';
}else{
	$menu_agenda = '';
}



//Ocultar Individualmente do Menu Logs
if($ver_logs  == 'ocultar' and $relatorio_logs  == 'ocultar'){
	$menu_logs = 'ocultar';
}else{
	$menu_logs = '';
}


//Ocultar Individualmente do Menu Relatórios
if($logs  == 'ocultar'){
	$menu_relatorio = 'ocultar';
}else{
	$menu_relatorio = '';
}





//Ocultar Individualmente do Menu Cadastros
if($grupo_acessos == 'ocultar' and $acessos == 'ocultar' and $cargos == 'ocultar' and $comissoes == 'ocultar'  and $coordenadores == 'ocultar'){
	$menu_cadastros = 'ocultar';
}else{
	$menu_cadastros = '';
}




//Ocultar Individualmente do Menu Câmaras
if($copeps  == 'ocultar'){
	$menu_camaras = 'ocultar';
}else{
	$menu_camaras = '';
}





?>