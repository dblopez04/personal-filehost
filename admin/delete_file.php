<?php 

require __DIR__ . '/../db.php';
require __DIR__ . '/../includes/header.php';


if(!($_SESSION['admin'])){
    header('Location: /filehost/');
    exit();
}


?>