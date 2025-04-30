<?php 

require __DIR__ . '/../db.php';
require __DIR__ . '/../includes/header.php';

if(!($_SESSION['admin'])){
    header('Location: /filehost/');
    exit();
}

$query = $pdo->prepare("SELECT * FROM users");
$query->execute([]);
$allUsers = $query->fetchAll();

?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>view users</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <h1>list of all users</h1>
    
    <?php if (count($allUsers) === 0): ?>
    <p>there are no invite codes</p>
    <?php else: ?>
        <?php foreach ($allUsers as $user): ?>
            <div class="file-entry">
                <div class="file-container">
                    <?php echo htmlspecialchars($user['id']); ?>
                    <?php echo htmlspecialchars($user['username']); ?>
                    <?php echo htmlspecialchars($user['email']); ?>
                    <?php echo htmlspecialchars($user['created_at']); ?>
                    <?php echo htmlspecialchars($user['goat']); ?>
                    
                </div>
            </div>
        <?php endforeach; ?>
    <?php endif; ?>
</body>
</html>