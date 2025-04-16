<?php

require 'db.php';

if(!isset($_SESSION['user_id'])){
    header('Location: login.php');
    exit();
}

$user_id = $_SESSION['user_id'];

$query = $pdo->prepare("SELECT * FROM files WHERE user_id = ? ORDER BY uploaded_at DESC");
$query->execute([$user_id]);
$userFiles = $query->fetchAll();

?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <h1>Your Files:</h1>

    <?php if (count($userFiles) === 0): ?>
            <p>You haven’t uploaded any files yet.</p>
        <?php else: ?>
            <ul class="file-list">
                <?php foreach ($userFiles as $file): ?>
                    <li>
                        <strong><?php echo htmlspecialchars($file['original_name']); ?></strong><br>
                        <a href="/filehost/<?php echo htmlspecialchars($file['url_code']); ?>" target="_blank">View</a>
                        <span style="font-size: 0.8em;">(<?php echo htmlspecialchars($file['mime_type']); ?>)</span>
                    </li>
                <?php endforeach; ?>
            </ul>
        <?php endif; ?>

        <a href="/filehost/logout.php">Logout</a>
</body>
</html>