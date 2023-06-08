<?php
// Connexion à la base de données
$servername = "localhost";
$username = "root";
$password = "Dyane198124//";
$dbname = "moduleconnexion";

session_start();

// Vérifier si l'utilisateur est connecté
if (!isset($_SESSION['id']) || $_SESSION['id'] !== true) {
    // Rediriger vers la page de connexion
    header("Location: connexion.php");
    exit;
}

try {
    // Créer une connexion
    $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    // Configurer PDO pour lancer des exceptions en cas d'erreur
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Récupérer les informations de l'utilisateur connecté
    $login = $_SESSION['login'];
    $stmt = $conn->prepare("SELECT * FROM user WHERE login = :login");
    $stmt->bindParam(':login', $login);
    $stmt->execute();
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    // Si le formulaire est soumis
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $lastname = $_POST['lastname'];
        $firstname = $_POST['firstname'];

        // Mettre à jour les informations de l'utilisateur dans la base de données
        $stmt = $conn->prepare("UPDATE user SET lastname = :lastname, firstname = :firstname WHERE login = :login");
        $stmt->bindParam(':lastname', $lastname);
        $stmt->bindParam(':firstname', $firstname);
        $stmt->bindParam(':login', $login);
        $stmt->execute();

        // Mettre à jour les informations de l'utilisateur dans la session
        $_SESSION['lastname'] = $lastname;
        $_SESSION['firstname'] = $firstname;

        echo "Informations mises à jour avec succès";
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
    <link rel="stylesheet" href="profil.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Gruppo&display=swap" rel="stylesheet">
</head>

<body>
    <div class="container">
        <h1>Profil</h1>
        <form method="POST" action="profil.php">
            <div class='champs'>
                <label for="login">Login:</label><br>
                <input type="text" id="login" name="login" value="<?php echo $_SESSION['login']; ?>"><br>
                <label for="firstname">firstname:</label><br>
                <input type="text" id="firstname" name="firstname" value="<?php echo $_SESSION['firstname']; ?>"><br>
                <label for="lastname">lastname:</label><br>
                <input type="text" id="lastname" name="lastname" value="<?php echo $_SESSION['lastname']; ?>"><br>
            </div>  
            <div class='button'>
                <input type="submit" value="Mettre à jour">
            </div>    
        </form>
    </div>
</body>
</html>
