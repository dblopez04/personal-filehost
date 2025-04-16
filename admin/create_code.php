<?php
require __DIR__ . '/../db.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(400);
    echo "Invalid request.";
    exit();
}

if ($_POST['choice'] === '2'){
    $code = bin2hex(random_bytes(8));
} else {
    $code = $_POST['text'] ?? '';
    if (trim($code) === '') {
        http_response_code(400);
        echo "Code cannot be empty.";
        exit();
    }
}

$query = $pdo->prepare("INSERT INTO invite_codes (code) VALUES (?)");
$query->execute([$code]);

echo "Code successfully added: " . htmlspecialchars($code);
?>

