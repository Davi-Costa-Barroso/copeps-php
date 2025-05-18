<?php
require '../../vendor/autoload.php';  

function substituirTextoNoDocx($caminhoArquivoOrigem, $caminhoArquivoDestino, $dados) {
    copy($caminhoArquivoOrigem, $caminhoArquivoDestino);
    $zip = new ZipArchive;

    if ($zip->open($caminhoArquivoDestino) === TRUE) {
        $xml = $zip->getFromName('word/document.xml');
        $xml = mb_convert_encoding($xml, 'UTF-8', 'auto');

        $dom = new DOMDocument();
        $dom->loadXML($xml);
        $xpath = new DOMXPath($dom);
        $xpath->registerNamespace('w', 'http://schemas.openxmlformats.org/wordprocessingml/2006/main');

        // Lida com a remoção de linhas (apenas se estiver vazio)
        if (isset($dados['comentariosParecer']) && empty($dados['comentariosParecer'])) {
            $nodes = $xpath->query("//w:t[contains(., 'comentariosParecer')]");
            foreach ($nodes as $node) {
                $parent = $node->parentNode;
                while ($parent && $parent->nodeName !== 'w:p') {
                    $parent = $parent->parentNode;
                }
                if ($parent) {
                    $parent->parentNode->removeChild($parent);
                }
            }
            //Remove a chave do array $dados para evitar que seja processada novamente no loop de substituição.
            unset($dados['comentariosParecer']);
        }

        // Realiza as substituições normais (agora inclui comentariosParecer se não estiver vazio)
        foreach ($dados as $chave => $valor) {
            $nodes = $xpath->query("//w:t[contains(., '" . $chave . "')]");
            foreach ($nodes as $node) {
                $node->nodeValue = str_replace($chave, $valor, $node->nodeValue);
            }
        }

        $xml = $dom->saveXML();

        $zip->deleteName('word/document.xml');
        $zip->addFromString('word/document.xml', $xml);
        $zip->close();

    } else {
      return false;
    }
    return true;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    try{
        $dadosJson = file_get_contents('php://input');
        $dados = json_decode($dadosJson, true);
        
        $dados = $dados['dados'];

        $caminhoArquivoDocx = '../../docs/relatorioParecer.docx';
        $dataAtual = date('Y-m-d_H-i-s');
        $nomeArquivoEditadoDocx = 'parecer_' . $dataAtual . '.docx';
        $caminhoArquivoEditadoDocx = '../../docs/' . $nomeArquivoEditadoDocx;

        substituirTextoNoDocx($caminhoArquivoDocx, $caminhoArquivoEditadoDocx, $dados);

        header('Content-Description: File Transfer');
        header('Content-Type: application/vnd.openxmlformats-officedocument.wordprocessingml.document');
        header('Content-Disposition: attachment; filename="' . $nomeArquivoEditadoDocx . '"');
        header('Content-Transfer-Encoding: binary');
        header('Expires: 0');
        header('Cache-Control: must-revalidate');
        header('Pragma: public');
        header('Content-Length: ' . filesize($caminhoArquivoEditadoDocx));

        readfile($caminhoArquivoEditadoDocx); // envia o conteúdo do arquivo
        unlink($caminhoArquivoEditadoDocx);   // deletando do servidor o arquivo enviado
        exit();

    } catch (Exception $e) {
        error_log("Erro no processo de geração do DOC: " . $e->getMessage());
        unlink($caminhoArquivoEditadoDocx);//coloquei isso
        http_response_code(500);
    }
}
?>
