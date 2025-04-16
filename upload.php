<?php

include 'includes/header.php';
require 'db.php';

$error = '';
$success = '';


if(!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit;
}

if($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_FILES['file'])){
    $file = $_FILES['file'];

    if($file['error'] !== UPLOAD_ERR_OK){
        $error = 'Upload failed';
    } else{
        $originalName = $file['name'];
        $tempPath = $file['tmp_name'];
        $mimeType = mime_content_type($tempPath);
        $size = $file['size'];
        $extension = pathinfo($originalName, PATHINFO_EXTENSION);
        $uniqueName = uniqid() . '.' . $extension;
        $urlCode = bin2hex(random_bytes(3));

        $destination = 'files/' . $uniqueName;
        if(!move_uploaded_file($tempPath, $destination)){
            $error = 'Failed to move file to proper directory';
        } else{
            $query = $pdo->prepare("INSERT INTO files (user_id, filename, original_name, url_code, size, mime_type) VALUES (?, ?, ?, ?, ?, ?)");
            $query->execute([
                $_SESSION['user_id'],
                $uniqueName,
                $originalName,
                $urlCode,
                $size,
                $mimeType
            ]);

            $success = 'file uploaded successfully! link: <a href="/filehost/' . $urlCode . '">/' . $urlCode . '</a>';
        }
    }

} 

?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>upload file</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <div class="form">
        <h1>upload file</h1>

        <?php if (!empty($error)): ?>
            <div class="error"><?php echo $error; ?></div>
        <?php endif; ?>
            
        <?php if (!empty($success)): ?>
            <div class="success"><?php echo $success; ?></div>
        <?php endif; ?>

        <form method="post" action="upload.php" enctype="multipart/form-data">
            <label for="file">choose a file:</label>
            <input type="file" name="file" id="file" required>
            <br><br>
            <button type="submit">upload</button>
        </form>
    </div>
</body>
</html>