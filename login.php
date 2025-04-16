<?php 

require 'db.php';

$error = '';

if(isset($_SESSION['user_id'])){
    header('Location: dashboard.php');
    exit();
}

if($_SERVER['REQUEST_METHOD'] === 'POST'){
    $username = sanitizeInput($_POST['username']);
    $password = sanitizeInput($_POST['password']);

    if(empty($username) || empty($password)) {
        $error = 'Enter both fields please';
    } else{

        try{
            $query = $pdo->prepare("SELECT * FROM users WHERE username = ?");
            $query->execute([$username]);
            $user = $query->fetch();

            if($user && password_verify($password, $user['password'])){
                $_SESSION['user_id'] = $user['id'];
                $_SESSION['username'] = $user['username'];
                
                header('Location: dashboard.php');
                exit();
            } else{
                $error = 'Invalid username or password.';
            }

        } catch (PDOException $e) {
            $error = 'DB error, yell at me: ' . $e->getMessage();
        }
    }
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
        <h1>login here!</h1>

        <?php if (!empty($error)): ?>
            <div class="error"><?php echo $error; ?></div>
        <?php endif; ?>
            
        <?php if (!empty($success)): ?>
            <div class="success"><?php echo $success; ?></div>
        <?php endif; ?>

        <form method="post" action="login.php">
            <div class="form-item">
                <label for="username">username:</label>
                <input type="text" id="username" name="username" required>
            </div>

            <div class="form-item">
                <label for="password">password:</label>
                <input type="password" id="password" name="password" required>
            </div>

            <button type="submit">login</button>
        </form>
    </div>
</body>
</html>