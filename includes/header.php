<?php 

session_start(); 

function checkAdmin(){
    if (isset($_SESSION['admin']) && $_SESSION['admin']) {
        echo '<a href="/filehost/admin/administrator.php" class="right-nav-button rainbow-text">admin panel</a>';
    }
}

?>

<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <link rel="stylesheet" href="/filehost/css/style.css">
    </head>
<body>
    <header class="head">
        <nav>
            <a href="/filehost/index.php" class="title-button"><strong>xtal file hosting</strong></a>
            <div class="right-nav-div">
                <?php if (isset($_SESSION['user_id'])): ?>
                    <?php checkAdmin(); ?>
                    <a href="/filehost/dashboard.php" class="right-nav-button">dashboard</a>
                    <a href="/filehost/upload.php" class="right-nav-button">upload</a>
                    <a href="/filehost/logout.php" class="right-nav-button">logout</a>
                <?php else: ?>
                    <a href="/filehost/login.php" class="right-nav-button">login</a>
                    <a href="/filehost/registration.php" class="right-nav-button">register</a>
                <?php endif; ?>
            </div>
        </nav>
    </header>
</body>
</html>