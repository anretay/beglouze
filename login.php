<?php
session_start();

// Vérifie si l'utilisateur est déjà connecté
if(isset($_SESSION['loggedin']) && $_SESSION['loggedin'] === true){
    header('Location: index.php');
    exit;
}

// Vérifie si le formulaire de connexion est soumis
if($_SERVER["REQUEST_METHOD"] == "POST"){
    // Vérifiez les identifiants
    $username = "id";
    $password = "dartybegles";

    if($_POST['username'] === $username && $_POST['password'] === $password){
        // Identifiants valides, démarrez une session
        $_SESSION['loggedin'] = true;
        header('Location: index.php');
        exit;
    } else{
        $error = "Identifiant ou mot de passe incorrect.";
    }
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Connexion</title>
    <link rel="stylesheet" href="styles.css"> <!-- Lien vers votre fichier CSS -->
</head>
<body>
    <div class="container">
        <h1>Connexion</h1>
        <form method="post">
            <div class="input-group">
                <label for="username">Identifiant :</label>
                <input type="text" id="username" name="username" required>
            </div>
            <div class="input-group">
                <label for="password">Mot de passe :</label>
                <input type="password" id="password" name="password" required>
            </div>
            <?php if(isset($error)): ?>
                <div class="error-message"><?php echo $error; ?></div>
            <?php endif; ?>
            <div class="input-group">
                <input type="submit" value="Se connecter" class="submit-button">
            </div>
        </form>
    </div>
</body>
</html>

