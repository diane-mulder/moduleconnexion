<?php


try {
    // Connexion à la base de données
    include "db.php";

    // Si le formulaire est soumis
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $login = $_POST['login'];
        $firstname = $_POST['firstname'];
        $lastname = $_POST['lastname'];
        $password = $_POST['password'];
        $confirm_password = $_POST['confirmation_password']; // Correction de la clé ici

        // Vérifier que les mots de passe correspondent
        if ($password != $confirm_password) {
            echo "Les mots de passe ne correspondent pas";
            exit;
        }

        // Vérifier les contraintes du mot de passe
        if (
            strlen($password) < 8 ||
            !preg_match('/[A-Z]/', $password) ||
            !preg_match('/[a-z]/', $password) ||
            !preg_match('/\d/', $password) ||
            !preg_match('/[^A-Za-z\d]/', $password)
        ) {
            echo "Le mot de passe ne respecte pas les contraintes";
            exit;
        }

        // Vérifier si le login existe déjà
        $stmt = $conn->prepare("SELECT * FROM user WHERE login = :login");
        $stmt->bindParam(':login', $login);
        $stmt->execute();

        if ($stmt->rowCount() > 0) {
            echo "Ce login est déjà utilisé";
            exit;
        }

        // Hacher le mot de passe
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);

        // Insérer l'utilisateur dans la base de données
        $stmt = $conn->prepare("INSERT INTO user (login, firstname, lastname, password) VALUES (:login, :firstname, :lastname, :password)");
        $stmt->bindParam(':login', $login);
        $stmt->bindParam(':firstname', $firstname);
        $stmt->bindParam(':lastname', $lastname);
        $stmt->bindParam(':password', $hashed_password);

        if ($stmt->execute()) {
            // Redirection vers la page de connexion
            header("Location: connexion.php");
            exit;
        } else {
            echo "Erreur lors de l'inscription";
        }
    }
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
    <link rel="stylesheet" href="inscription.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Gruppo&display=swap" rel="stylesheet">
</head>

<body>
    <div class='formulaire'>
        <h1>Inscription</h1>
        <form method="POST" action="inscription.php">
            <div class='inscription'>
                <div class='champs'>
                    <label for="login">Login :</label><br>
                    <input type="text" id="login" name="login" required><br>
                    <label for="firstname">NOM :</label><br>
                    <input type="text" id="firstname" name="firstname" required><br>
                    <label for="lastname">PRENOM :</label><br>
                    <input type="text" id="lastname" name="lastname" required><br>
                    <label for="password">Mot de passe :</label><br>
                    <input type="password" id="password" name="password" required><br>
                    <label for="confirmation_password">Confirmation du mot de passe :</label><br>
                    <input type="password" id="confirmation_password" name="confirmation_password" required>
                </div>
            </div>    
                <div class='valider'>
                <input type="submit" value="VALIDER" class="button"><br>
                </div>   
        </form>
    </div>
</body>
</html>
