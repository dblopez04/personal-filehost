<?php

require 'db.php';

$error = '';            // Error messages
$success = '';          // Login success message!!!!!!!!!!! Yippee


if ($_SERVER['REQUEST_METHOD']  === 'POST'){
    // Inputs are sanitized to prevent clever individuals from doing things they shouldn't
    $username = sanitizeInput($_POST['username']);
    $email = sanitizeInput($_POST['email']);
    $password = sanitizeInput($_POST['password']);
    $confirm_password = sanitizeInput($_POST['confirm_password']);
    $invite_code = sanitizeInput($_POST['invite_code']);

    if (empty($username) || empty($email) || empty($password) || empty($confirm_password) || empty($invite_code)){
        $error = 'Please fill out all fields';
    } elseif($password !== $confirm_password){
        $error = 'Passwords do not match';
    } elseif(strlen($password) < 8){
        $error = 'Password must be at least 8 characters long';
    } elseif(strlen($password) > 64){
        $error = 'Password cannot be longer than 64 characters';
    } else{

        try{
            $query = $pdo->prepare("SELECT * FROM invite_codes WHERE code = ? AND used = FALSE");
            $query->execute([$invite_code]);
            $validInvite = $query->fetch();

            if(!$validInvite){
                $error = 'Invalid invite code, send me a message';
            } else {
                $query = $pdo->prepare("SELECT id FROM users WHERE username = ? OR email = ?");
                $query->execute([$username, $email]);

                if($query->rowCount() > 0){
                    $error = 'Email or username already exists';
                } else{
                    $hashedPW = password_hash($password, PASSWORD_DEFAULT);
                    $query = $pdo->prepare("INSERT INTO users (username, email, password) VALUES (?, ?, ?)");
                    $query->execute([$username, $email, $hashedPW]);

                    $query = $pdo->prepare("UPDATE invite_codes SET used = TRUE WHERE code = ?");
                    $query->execute([$invite_code]);

                    $success = 'Registration successful!';
                }
            }
        } catch (PDOException $e){
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
        <h1>register here!</h1>
    
        <?php if (!empty($error)): ?>
            <div class="error"><?php echo $error; ?></div>
        <?php endif; ?>
            
        <?php if (!empty($success)): ?>
            <div class="success"><?php echo $success; ?></div>
        <?php endif; ?>

        <form method="post" action="registration.php">
            <div class="form-item">
                <label for="username">username:</label>
                <input type="text" id="username" name="username" required>
            </div>

            <div class="form-item">
                <label for="email">email:</label>
                <input type="email" id="email" name="email" required>
            </div>

            <div class="form-item">
                <label for="password">password:</label>
                <input type="password" id="password" name="password" required>
            </div>

            <div class="form-item">
                <label for="confirm_password">confirm password:</label>
                <input type="password" id="confirm_password" name="confirm_password" required>
            </div>

            <div class="form-item">
                <label for="invite_code">invite code:</label>
                <input type="text" id="invite_code" name="invite_code" required>
            </div>

            <button type="submit">register</button>
        </form>
    </div>
</body>
</html>