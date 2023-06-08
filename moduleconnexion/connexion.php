<?php
$servername = "localhost";
$username = "root";
$password = "Dyane198124//";
$dbname = "moduleconnexion";
 // Créer une connexion

session_start();

$errors = array();

try {
    // Connexion à la base de données
    // include "db.php";
    $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    // Si le formulaire est soumis
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $login = $_POST['login'];
        $password = $_POST['password'];

        // Vérifier si l'utilisateur existe dans la base de données
        $stmt = $conn->prepare("SELECT * FROM user WHERE login = :login");
        $stmt->bindParam(':login', $login);
        $stmt->execute();

        if ($stmt->rowCount() > 0) {
            $row = $stmt->fetch(PDO::FETCH_ASSOC);
            $hashed_password = $row['password'];
        
        //   var_dump($row);
            echo $password;
            echo "<br>";
            echo $hashed_password;
            // Vérifier le mot de passe
            if (password_verify($password, $hashed_password)) {
                // Authentification réussie, créer une session pour l'utilisateur
                $_SESSION['id'] = true;
                $_SESSION['login'] = $row['login'];
                $_SESSION['lastname'] = $row['lastname'];
                $_SESSION['firstname'] = $row['firstname'];

                // Rediriger vers la page de profil ou la page d'admin en fonction du login
                var_dump($_SESSION);
                if ($_SESSION['login'] === 'admin') {
                    header("Location: admin.php");
                } else {
                    header("Location: profil.php");
                }
                exit;
            } else {
                // $errors[] = "Mot de passe incorrect";
                echo  "Mot de passe incorrect";
            }
            } else {
            // $errors[] = "Login incorrect";
            echo "login incorrect";
            }
    }
} catch (PDOException $e) {
    // $errors[] = "Erreur: " . $e->getMessage();
    echo  "Erreur: " . $e->getMessage();
}

$conn = null;
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="connexion.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Gruppo&display=swap" rel="stylesheet">
</head>

<body>
    <div class="formulaire">
        <h1>Connexion</h1>
        <?php if (!empty($errors)) : ?>
            <div class="errors">
                <?php foreach ($errors as $error) : ?>
                    <p><?php echo $error; ?></p>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
        <form method="POST" action="connexion.php">
            <div class='connexion'>       
                <div class='champs'>
                    <label for="login">Login:</label><br>
                    <input type="text" id="login" name="login"><br>
                    <label for="password">Mot de passe:</label><br>
                    <input type="password" id="password" name="password">
                </div>
                <div class='submit'>    
                    <input type="submit" value="Se connecter" class="button"><br>
                </div> 
                <div class='button'>       
                <a href="index.php" class="button">Retour à l'accueil</a>
                </div>
            </div>        
        </form>
            
    </div>
</body>
</html>