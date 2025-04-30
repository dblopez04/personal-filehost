<?php 

require __DIR__ . '/../db.php';


$success = '';
$error = '';

$id = $_POST['id'];

$query = $pdo->prepare("SELECT * FROM invite_codes WHERE (id = ?)");
$query->execute([$id]);
$code = $query->fetch();

if(!$code){
    http_response_code(404);
    echo "Could not delete code.";
    exit();
} else{
    $query = $pdo->prepare("DELETE FROM invite_codes WHERE (id = ?)");
    $query->execute([$id]);
    $success = 'Code deleted successfully';
}

header("Location: manage_codes.php");

?>