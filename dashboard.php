<?php

include 'includes/header.php';
require 'db.php';

if(!isset($_SESSION['user_id'])){
    header('Location: login.php');
    exit();
}

$user_id = $_SESSION['user_id'];

$query = $pdo->prepare("SELECT * FROM files WHERE user_id = ? ORDER BY uploaded_at DESC");
$query->execute([$user_id]);
$userFiles = $query->fetchAll();


function formatFileSize($bytes, $precision = 2) {
    $units = ['B', 'KB', 'MB', 'GB', 'TB'];

    $bytes = max($bytes, 0);
    $pow = floor(($bytes ? log($bytes) : 0) / log(1024));
    $pow = min($pow, count($units) - 1);

    $bytes /= (1 << (10 * $pow));

    return round($bytes, $precision) . ' ' . $units[$pow];
}

?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>dashboard</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <h1>your files:</h1>

    <?php if (count($userFiles) === 0): ?>
            <p>you haven’t uploaded any files yet.</p>
        <?php else: ?>
                <?php foreach ($userFiles as $file): ?>
                    <div class="file-entry">
                        <div class="file-container">
                            <strong><?php echo htmlspecialchars($file['original_name']); ?></strong>
                            <span>(<?php echo htmlspecialchars($file['mime_type']); ?>)</span>
                        </div>
                        <div class="file-container">
                            <span>(<?php echo htmlspecialchars(formatFileSize($file['size'])); ?>)</span>
                            <a href="/filehost/<?php echo htmlspecialchars($file['url_code']); ?>" target="_blank">View</a>
                            <form method="POST" action="delete.php" style="display:inline;" onsubmit="return confirm('Are you sure you want to delete this file?');">
                                <input type="hidden" name="url_code" value="<?php echo sanitizeInput($file['url_code']); ?>">
                                <button type="submit" class="link-button">Delete</button>
                            </form>
                        </div>
                    </div>
                <?php endforeach; ?>
        <?php endif; ?>
        
        <!--
        <a href="/filehost/upload.php">Upload File</a><br>
        <a href="/filehost/logout.php">Logout</a>
        -->
</body>
</html>