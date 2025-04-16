<?php
include 'includes/header.php';
require 'db.php';

$success = '';
$error = '';

$urlCode = $_POST['url_code'];
$currentUserID = $_SESSION['user_id'];

$query = $pdo->prepare("SELECT * FROM files WHERE (url_code = ?) AND (user_id = ?)");
$query->execute([$urlCode, $currentUserID]);
$file = $query->fetch();

if(!$file){
    http_response_code(404);
    echo "Could not delete file.";
    exit;
} else{
    $query = $pdo->prepare("DELETE FROM files WHERE (url_code = ?)");
    $query->execute([$urlCode]);
    $success = 'File deleted successfully';
}



?>


<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registration</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <div class="form">
        <?php if (!empty($error)): ?>
            <div class="error"><?php echo $error; ?></div>
        <?php endif; ?>
            
        <?php if (!empty($success)): ?>
            <div class="success"><?php echo $success; ?></div>
        <?php endif; ?>
        <br>
        <a href="<?php header('Location: dashboard.php');?>">Return to dashboard</a>
    </div>
</body>
</html>