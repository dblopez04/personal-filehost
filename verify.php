<?php

include 'includes/header.php';
require 'db.php';

if(!isset($_GET['token'])){
    header('Location: dashboard.php');
    exit();
}

$user_id = ($_SESSION['user_id']);
$inputToken = $_GET['token'];
$query = $pdo->prepare("SELECT * FROM users WHERE (id = ?) AND (verify_token = ?)");
$query->execute([$user_id, $inputToken]);
$result = $query->fetchAll();

if(!$result){
    echo '<h1>incorrect token</h1>';
} else{
    echo '<h1>email verified!</h1><br><p>thank you for verifying your email!</p>';
    $stmt = $pdo->prepare("UPDATE users SET verified_email = 1 WHERE id = :id");
    $stmt->execute([
        ':id' => $user_id
    ]);
}


?>