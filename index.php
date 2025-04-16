<?php

require 'db.php';

if(isset($_SESSION['user_id'])){
    header('Location: dashboard.php');
    exit();
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
    <h1>wip.....</h1>
    
</body>
</html>