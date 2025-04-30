<?php 

require __DIR__ . '/../db.php';
require __DIR__ . '/../includes/header.php';


if(!($_SESSION['admin'])){
    header('Location: /filehost/');
    exit();
}


$allCodes = [''];
/** @var PDO $pdo */
$query = $pdo->prepare("SELECT * FROM invite_codes");
$query->execute([]);
$allCodes = $query->fetchAll();






?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>invite code management</title>
    <link rel="stylesheet" href="/filehost/css/style.css">
</head>
<script>
        function createCode() {
            var choice = prompt("Enter '1' for Text Entry or '2' for Random Generation");

            let text;

            if (choice === '1') {
                text = prompt("Enter your custom code:");
                if (!text) {
                    alert("No code entered!");
                    return;
                }
            } else if (choice === '2') {
                
            } else {
                alert("Invalid choice. Please enter '1' or '2'.");
                return;
            }

            // Now send the code to PHP via POST
            fetch("create_code.php", {
                method: "POST",
                headers: {
                    "Content-Type": "application/x-www-form-urlencoded"
                },
                body: new URLSearchParams({
                    choice: choice,
                    text: text
                })
            })
            .then(response => response.text())
            .then(data => {
                alert("Server Response: " + data);
                location.reload(); // this refreshes the page to show the new code
            })
            .catch(err => {
                console.error("Error:", err);
                alert("Failed to send code.");
            });
        }

    </script>
<body> 
<button onclick="createCode()" class="create-code-button">create a code</button>

<h1>codes:</h1>
<?php if (count($allCodes) === 0): ?>
    <p>there are no invite codes</p>
    <?php else: ?>
        <?php foreach ($allCodes as $code): ?>
            <div class="file-entry">
                <div class="file-container">
                    <strong><?php echo htmlspecialchars($code['id']); ?></strong>
                    <?php echo htmlspecialchars($code['code']); ?>
                    <?php echo htmlspecialchars($code['created_at']); ?>
                    <?php echo htmlspecialchars($code['used']); ?>
                    <form method="POST" action="delete_code.php" style="display:inline;" onsubmit="return confirm('Are you sure you want to delete this invite code?');">
                                <input type="hidden" name="id" value="<?php echo sanitizeInput($code['id']); ?>">
                                <button type="submit" class="link-button">Delete</button>
                            </form>
                </div>
            </div>
        <?php endforeach; ?>
    <?php endif; ?>
</body>
</html>