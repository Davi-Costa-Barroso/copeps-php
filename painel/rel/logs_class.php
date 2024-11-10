<?php 
require_once("../../conexao.php");

$dataInicial = $_POST['dataInicial'];
$dataFinal = $_POST['dataFinal'];
$acao = $_POST['acao'];
$tabelas = $_POST['tabela'];
$usuario = $_POST['usuario']; 

//ALIMENTAR OS DADOS NO RELATÓRIO
$html = file_get_contents($url_sistema."painel/rel/logs.php?acao=$acao&tabelas=$tabelas&dataInicial=$dataInicial&dataFinal=$dataFinal&usuario=$usuario");

if($relatorio_pdf != 'pdf'){
	echo $html;
	exit();
}

//CARREGAR DOMPDF
require_once '../../dompdf/autoload.inc.php';
use Dompdf\Dompdf;
use Dompdf\Options;

header("Content-Transfer-Encoding: binary");
header("Content-Type: image/png");

//INICIALIZAR A CLASSE DO DOMPDF
$options = new Options();
$options->set('isRemoteEnabled', true);
$pdf = new DOMPDF($options);


//Definir o tamanho do papel e orientação da página
$pdf->set_paper('A4', 'portrait');

//CARREGAR O CONTEÚDO HTML
$pdf->load_html($html);

//RENDERIZAR O PDF
$pdf->render();

//NOMEAR O PDF GERADO
$pdf->stream(
'logs.pdf',
array("Attachment" => false)
);


?>