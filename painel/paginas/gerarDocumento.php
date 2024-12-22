<?php
require '../../vendor/autoload.php';  
use ConvertApi\ConvertApi;

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
    try {
        // Detecta o sistema operacional
        $os = strtoupper(substr(PHP_OS, 0, 3));
        if ($os === 'WIN') {
            $libreOfficePath = '"C:\\Program Files\\LibreOffice\\program\\soffice.exe"';
        } else {
            $libreOfficePath = '/usr/bin/libreoffice';
        }

        // Obtém os dados JSON
        $dadosJson = file_get_contents('php://input');
        $dados = json_decode($dadosJson, true);

        if (!isset($dados['dados']) || !is_array($dados['dados'])) {
            throw new Exception("Dados inválidos ou faltando.");
        }

        $dados = $dados['dados'];

        // Caminhos dos arquivos
        $caminhoArquivoDocx = '../../docs/relatorioParecer.docx';
        $dataAtual = date('Y-m-d_H-i-s');
        $nomeArquivoEditadoDocx = "parecer_$dataAtual.docx";
        $caminhoArquivoEditadoDocx = "../../docs/$nomeArquivoEditadoDocx";
        $caminhoPdfGerado = "../../docs/parecer_$dataAtual.pdf";

        // Substituir texto no DOCX
        substituirTextoNoDocx($caminhoArquivoDocx, $caminhoArquivoEditadoDocx, $dados);

        // Comando para conversão com LibreOffice
        $comando = "$libreOfficePath --headless --convert-to pdf --outdir " . escapeshellarg(dirname($caminhoPdfGerado)) . " " . escapeshellarg($caminhoArquivoEditadoDocx);
        exec($comando, $output, $returnCode);

        if ($returnCode !== 0 || !file_exists($caminhoPdfGerado)) {
            throw new Exception("Erro ao converter DOCX para PDF com LibreOffice. Saída: " . implode("\n", $output));
        }

        // Envia o PDF para o cliente
        header('Content-Description: File Transfer');
        header('Content-Type: application/pdf');
        header('Content-Disposition: attachment; filename="' . basename($caminhoPdfGerado) . '"');
        header('Content-Transfer-Encoding: binary');
        header('Expires: 0');
        header('Cache-Control: must-revalidate');
        header('Pragma: public');
        header('Content-Length: ' . filesize($caminhoPdfGerado));

        readfile($caminhoPdfGerado);

        // Remove arquivos temporários
        unlink($caminhoArquivoEditadoDocx);
        unlink($caminhoPdfGerado);
        exit();

    } catch (Exception $e) {
        error_log("Erro: " . $e->getMessage());
        http_response_code(500);
        echo json_encode(['erro' => $e->getMessage()]);
    }
}


?>
