<?php
require '../../vendor/autoload.php';  

function replaceTextInDocx($sourceFilePath, $destFilePath, $search, $replace) {
    copy($sourceFilePath, $destFilePath);
    $zip = new ZipArchive;
    
    if ($zip->open($destFilePath) === TRUE) {
        $xml = $zip->getFromName('word/document.xml');
        $xml = mb_convert_encoding($xml, 'UTF-8', 'auto'); 
        $xml = str_replace($search, $replace, $xml);
        $zip->deleteName('word/document.xml'); 
        $zip->addFromString('word/document.xml', $xml); 
        $zip->close();
    }
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $dados = [
        'numeroParecer' => $_POST['numeroParecer'] ?? '', 
    ];

    $filePath = '../../docs/relatorioParecer.docx';
    $dataAtual = date('Y-m-d_H-i-s');
    $editedFileName = 'parecer_' . $dataAtual . '.docx';
    $editedFilePath = '../../docs/' . $editedFileName;

    replaceTextInDocx($filePath, $editedFilePath, 'numeroParecer', $dados['numeroParecer']);

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
