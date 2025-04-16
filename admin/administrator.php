<?php 

require __DIR__ . '/../db.php';
require __DIR__ . '/../includes/header.php';

if(!($_SESSION['admin'])){
    header('Location: /filehost/');
    exit();
}




?>


<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>admin panel</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <h1>admin tools</h1>
    <a href="manage_codes.php" class="admin-tool-button">manage invite keys</a><br>
    <a href="" class="admin-tool-button">create an invite key</a><br>
    <a href="" class="admin-tool-button">delete file</a><br>
</body>
</html>