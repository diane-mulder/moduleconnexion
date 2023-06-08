<?php


session_start();
include "db.php";
if (!isset($_SESSION['id']) || $_SESSION['id'] !== true || $_SESSION['login'] !== 'admin') {
    header("Location: connexion.php");
    exit;
}

try {
   // Connexion à la base de données
   include "db.php";
    $stmt = $conn->query("SELECT * FROM user");
    $users = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch(PDOException $e) {
    echo "Erreur: " . $e->getMessage();
}

$conn = null;
?>




<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="admin.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Gruppo&display=swap" rel="stylesheet">
</head>

<body>
    <div class="container">
        <h1>Administration</h1>
        <table>
            <tr>
                <th>Login</th>
                <th>lastname</th>
                <th>firstname</th>
            </tr>
            <?php foreach ($users as $user) : ?>
            <tr>
                <td><?php echo $user['login']; ?></td>
                <td><?php echo $user['lastname']; ?></td>
                <td><?php echo $user['firstname']; ?></td>
            </tr>
            <?php endforeach; ?>
        </table>
        <div class='retour'>
        <a href="index.php" class="button">Retour à l'accueil</a>
        </div>
    </div>
</body>
</html>