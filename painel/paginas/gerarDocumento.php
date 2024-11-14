<?php
require '../../vendor/autoload.php';  

function replaceTextInDocx($sourceFilePath, $destFilePath, $dados) {
    copy($sourceFilePath, $destFilePath);
    $zip = new ZipArchive;
    
    if ($zip->open($destFilePath) === TRUE) {
        $xml = $zip->getFromName('word/document.xml');
        $xml = mb_convert_encoding($xml, 'UTF-8', 'auto'); 

        foreach ($dados as $key => $value) {
            $xml = str_replace($key, $value, $xml);
        }

        $zip->deleteName('word/document.xml'); 
        $zip->addFromString('word/document.xml', $xml); 
        $zip->close();
    }
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $jsonData = file_get_contents('php://input');
    $dados = json_decode($jsonData, true);
    
    $dadosIniciais = $dados['dadosIniciais'];

    $filePath = '../../docs/relatorioParecer.docx';
    $dataAtual = date('Y-m-d_H-i-s');
    $editedFileName = 'parecer_' . $dataAtual . '.docx';
    $editedFilePath = '../../docs/' . $editedFileName;

    replaceTextInDocx($filePath, $editedFilePath, $dadosIniciais);

    header('Content-Description: File Transfer');
    header('Content-Type: application/vnd.openxmlformats-officedocument.wordprocessingml.document');
    header('Content-Disposition: attachment; filename="' . $editedFileName . '"');
    header('Content-Transfer-Encoding: binary');
    header('Expires: 0');
    header('Cache-Control: must-revalidate');
    header('Pragma: public');
    header('Content-Length: ' . filesize($editedFilePath));
    readfile($editedFilePath);

    unlink($editedFilePath);
    exit();
}
?>
