<?php 
require_once("../../../conexao.php");
@session_start();
$usuario = @$_SESSION['id']; 
$data = @$_POST['data']; 

//echo $_SESSION['nome'];
//exit();

if($data == ""){
	$data = date('Y-m-d');
}


echo <<<HTML
<small>
HTML;
$query = $pdo->query("SELECT * FROM tarefas where usuario = '$usuario' and data = '$data' ORDER BY hora asc");
$res = $query->fetchAll(PDO::FETCH_ASSOC);
$total_reg = @count($res);
if($total_reg > 0){
for($i=0; $i < $total_reg; $i++){
	foreach ($res[$i] as $key => $value){}
$id = $res[$i]['id'];
$titulo = $res[$i]['titulo'];
$descricao = $res[$i]['descricao'];
$hora = $res[$i]['hora'];
$data = $res[$i]['data'];
$usuario = $res[$i]['usuario'];
$status = $res[$i]['status'];
$obs = $res[$i]['obs'];


$dataF = implode('/', array_reverse(explode('-', $data)));
$horaF = date("H:i", strtotime($hora));


if($status == 'Concluída'){
	$icone = 'fa-check-square';
	$titulo_link = 'Cancelar Conclusão';
	$acao = 'Agendada';
	$classe_linha = '';
}else{
	$icone = 'fa-square-o';
	$titulo_link = 'Concluir Tarefa';
	$acao = 'Concluída';
	$classe_linha = 'text-muted';
}



if($status == 'Agendada'){
	$imagem = 'icone-relogio.png';	
}else{
	$imagem = 'icone-relogio-verde.png';
}

$query2 = $pdo->query("SELECT * FROM usuarios where id = '$usuario'");
$res2 = $query2->fetchAll(PDO::FETCH_ASSOC);
if(@count($res2) > 0){
	$nome_usu = $res2[0]['nome'];
}else{
	$nome_usu = 'Sem Usuário';
}


//retirar aspas do texto do obs
$obs = str_replace('"', "**", $obs);

echo <<<HTML
			<div class="col-xs-12 col-md-4 widget cardTarefas">
        		<div class="r3_counter_box">
        		

				<li class="dropdown head-dpdn2" style="list-style-type: none;">
				<a href="#" class="dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
		<button type="button" class="close" title="Excluir Tarefa" style="margin-top: -10px">
					<span aria-hidden="true"><big>&times;</big></span>
				</button>
				</a>

		<ul class="dropdown-menu" style="margin-left:-30px;">
		<li>
		<div class="notification_desc2">
		<p>Confirmar Exclusão? <a href="#" onclick="excluir('{$id}', '{$titulo}')"><span class="text-danger">Sim</span></a></p>
		</div>
		</li>										
		</ul>
		</li>

				<a href="#" onclick="mostrar('{$id}', '{$titulo}', '{$descricao}','{$horaF}','{$dataF}','{$nome_usu}', '{$status}','{$obs}')" title="Ver Dados">
        		<div class="row">
        		<div class="col-md-3">
        			 <img class="icon-rounded-vermelho" src="images/{$imagem}" width="45px" height="45px">
        		</div>
        		<div class="col-md-9">
        			<h5><strong>{$horaF}</strong></h5>
        		</div>
        		</div>
        		</a>
        		<hr style="margin-top:-2px; margin-bottom: 3px">                    
                    <div class="stats esc" style="margin-top:-15px;">
                      <span>
                      <a href="#" onclick="ativar('{$id}', '{$titulo}', '{$acao}')" title="{$titulo_link}">
                      <i class="fa {$icone} mr-1 text-primary" style="font-size:14px; margin:0; padding:0; width:17px; height: 17px"></i>
                      </a>
                       <small>{$titulo}</small></span>
                    </div>
                </div>
        	</div>
HTML;
}

}else{
	echo 'Não possui nenhum registro cadastrado!';
}

?>





