<?php

include 'includes/header.php';
include 'mailer.php';
require 'db.php';


if(!isset($_SESSION['user_id'])){
    header('Location: dashboard.php');
    exit();
}

$user_id = ($_SESSION['user_id']);
$query = $pdo->prepare("SELECT * FROM users WHERE (id = ?)");
$query->execute([$user_id]);
$user = $query->fetch();

if($user['verified_email']){
    header('Location: dashboard.php');
    exit();
}
 
$userEmail = $user['email'];
$token = bin2hex(random_bytes(16));


$stmt = $pdo->prepare("UPDATE users SET verify_token = :token WHERE id = :id");
$stmt->execute([
    ':token' => $token,
    ':id' => $user_id
]);

$verificationLink = "https://xtal.gay/filehost/verify.php?token=$token";
$subject = "Verify your email";
$body = "<p>Thanks for registering. Click below to verify:</p>
         <a href='$verificationLink'>$verificationLink</a>";

sendEmail($userEmail, $subject, $body);

echo '<h1>verification email sent</h1><br><p>check your spam folder if you haven\'t gotten an email yet</p>';


?>