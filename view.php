<?php
require 'db.php';

if(!isset($_GET['file'])){
    http_response_code(404);
    echo "Link not found";
    exit;
}

$urlCode = sanitizeInput($_GET['file']);
$query = $pdo->prepare("SELECT * FROM files WHERE url_code = ?");
$query->execute([$urlCode]);
$file = $query->fetch();

if(!$file){
    http_response_code(404);
    echo "File not found";
    exit;
}

$path = 'files/' . $file['filename'];
$mime = $file['mime_type'];

if(!file_exists($path)){
    http_response_code(404);
    echo "File not found on server";
    exit;
}

header("Content-Type: $mime");
header('Content-Length: ' . filesize($path));

$embeddableTypes = ['image/', 'video/', 'audio/', 'text/plain'];
$isEmbeddable = false;

foreach ($embeddableTypes as $type) {
    if (strpos($mime, $type) === 0) {
        $isEmbeddable = true;
        break;
    }
}

if (!$isEmbeddable) {
    header('Content-Disposition: attachment; filename="' . basename($file['original_name']) . '"');
}

readfile($path);
exit;

?>