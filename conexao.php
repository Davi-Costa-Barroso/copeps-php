<?php 

//definir fuso horário
date_default_timezone_set('America/Sao_Paulo');


$url_sistema = "http://$_SERVER[HTTP_HOST]/";
$url = explode("//", $url_sistema);
if($url[1] == 'localhost/'){
	$url_sistema = "http://$_SERVER[HTTP_HOST]/loginusuario/";
}



//dados conexão bd local
$servidor = 'localhost';
$banco = 'loginsenha';
$usuario = 'root';
$senha = '';


try {
	$pdo = new PDO("mysql:dbname=$banco;host=$servidor;charset=utf8", "$usuario", "$senha");
} catch (Exception $e) {
	echo 'Erro ao conectar ao banco de dados!<br>';
	echo $e;
}


//variaveis globais
$nome_sistema = 'Nome Sistema';
$email_sistema = 'maycon@ufpa.com.br';
$telefone_sistema = '(94)1000-0001';




//Inserir registros na tabela config
$query = $pdo->query("SELECT * from config");
$res = $query->fetchAll(PDO::FETCH_ASSOC);
$linhas = @count($res);
if($linhas == 0){
	$pdo->query("INSERT INTO config SET nome = '$nome_sistema', email = '$email_sistema', logs = 'Sim', telefone = '$telefone_sistema', logo = 'logo.png', logo_rel = 'logo.jpg', icone = 'icone.png', ativo = 'Sim', dias_limpar_logs = 40, relatorio_pdf = 'pdf' ");
}else{
//VARIAVEIS DE CONFIGURAÇÕES DA TABELA CONFIG exibindo no perfil config	
$nome_sistema = $res[0]['nome'];
$email_sistema = $res[0]['email'];
$logs = $res[0]['logs'];
$dias_limpar_logs = $res[0]['dias_limpar_logs'];
$relatorio_pdf = $res[0]['relatorio_pdf'];
$telefone_sistema = $res[0]['telefone'];
$endereco_sistema = $res[0]['endereco'];
$instagram_sistema = $res[0]['instagram'];
$logo_sistema = $res[0]['logo'];
$logo_rel = $res[0]['logo_rel'];
$icone_sistema = $res[0]['icone'];
$ativo_sistema = $res[0]['ativo'];


//bloquear sistema (planos futuros)
if($ativo_sistema != 'Sim' and $ativo_sistema != ''){
	echo 'Sistema Desativado';
	exit();
}

}




 ?>