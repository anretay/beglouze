<?php
// Inclure le fichier de configuration
include 'config.php';

// Connexion à la base de données
$conn = mysqli_connect($config['db_host'], $config['db_user'], $config['db_password'], $config['db_base']);

if (!$conn) {
    die("Erreur de connexion : " . mysqli_connect_error());
}

// Réinitialiser la table des vendeurs
$sql = "TRUNCATE TABLE vendeurs";

if (mysqli_query($conn, $sql)) {
    // Redirection vers index.php après la réinitialisation
    header("Location: index.php");
    exit();
} else {
    echo "Erreur lors de la réinitialisation des vendeurs : " . mysqli_error($conn);
}

// Fermer la connexion à la base de données
mysqli_close($conn);
?>
