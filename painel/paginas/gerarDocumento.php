<?php
require '../../vendor/autoload.php';  
use ConvertApi\ConvertApi;

function substituirTextoNoDocx($caminhoArquivoOrigem, $caminhoArquivoDestino, $dados) {
    copy($caminhoArquivoOrigem, $caminhoArquivoDestino);
    $zip = new ZipArchive;
    
    if ($zip->open($caminhoArquivoDestino) === TRUE) {
        $xml = $zip->getFromName('word/document.xml');
        $xml = mb_convert_encoding($xml, 'UTF-8', 'auto'); 

        foreach ($dados as $chave => $valor) {
            $xml = str_replace($chave, $valor, $xml);
        }

        $zip->deleteName('word/document.xml'); 
        $zip->addFromString('word/document.xml', $xml); 
        $zip->close();
    }
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $dadosJson = file_get_contents('php://input');
    $dados = json_decode($dadosJson, true);
    
    $dados = $dados['dados'];

    $caminhoArquivoDocx = '../../docs/relatorioParecer.docx';
    $dataAtual = date('Y-m-d_H-i-s');
    $nomeArquivoEditadoDocx = 'parecer_' . $dataAtual . '.docx';
    $caminhoArquivoEditadoDocx = '../../docs/' . $nomeArquivoEditadoDocx;

    $caminhoPdfGerado = '../../docs/relatorio_' . $dataAtual . '.pdf';

    substituirTextoNoDocx($caminhoArquivoDocx, $caminhoArquivoEditadoDocx, $dados);

    ConvertApi::setApiCredentials('secret_mmHuw1YZ6vk30CLY');

    $resultado = ConvertApi::convert('pdf', [ 'File' => $caminhoArquivoEditadoDocx], 'docx');
    $resultado->saveFiles($caminhoPdfGerado); 

    header('Content-Description: File Transfer');
    header('Content-Type: application/pdf');
    header('Content-Transfer-Encoding: binary');
    header('Expires: 0');
    header('Cache-Control: must-revalidate');
    header('Pragma: public');
    header('Content-Length: ' . filesize($caminhoPdfGerado));

    readfile($caminhoPdfGerado);

    unlink($caminhoArquivoEditadoDocx);
    unlink($caminhoPdfGerado);
    exit();
}
?>
