<?php
include 'includes/header.php';
require 'db.php';

$_SESSION = array();
session_destroy();

header('Location: index.php');
exit();

?>