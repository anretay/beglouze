<?php
session_start();

include("config.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['nom'])) {
        $nom = $_POST['nom'];

        // Connexion à la base de données
        $conn = mysqli_connect($config['db_host'], $config['db_user'], $config['db_password'], $config['db_base']);

        if (!$conn) {
            echo "Erreur de connexion : " . mysqli_connect_error();
            http_response_code(500);
            exit();
        }

        // Vérification de la longueur du nom
        if (strlen($nom) > 255) {
            echo "Erreur : le nom est trop long.";
            http_response_code(400);
            exit();
        }

        // Récupération de l'ID le plus récent et incrémentation
        $sql_max_id = "SELECT MAX(id) AS max_id FROM vendeurs";
        $result_max_id = mysqli_query($conn, $sql_max_id);
        $row_max_id = mysqli_fetch_assoc($result_max_id);
        $new_id = $row_max_id['max_id'] + 1;

        // Préparation de la requête d'insertion
        $sql = "INSERT INTO vendeurs (id, nom, beglouzes) VALUES (?, ?, 0)";

        // Préparation de la requête
        $stmt = mysqli_prepare($conn, $sql);

        if ($stmt) {
            // Liage des paramètres
            mysqli_stmt_bind_param($stmt, "is", $new_id, $nom);

            // Exécution de la requête
            if (mysqli_stmt_execute($stmt)) {
                // Redirection vers la page d'accueil après l'insertion
                header("Location: index.php");
                exit();
            } else {
                echo "Erreur lors de l'exécution de la requête : " . mysqli_error($conn);
                http_response_code(500);
            }

            // Fermeture du statement
            mysqli_stmt_close($stmt);
        } else {
            echo "Erreur lors de la préparation de la requête : " . mysqli_error($conn);
            http_response_code(500);
        }

        // Fermeture de la connexion à la base de données
        mysqli_close($conn);
    } else {
        http_response_code(400);
        echo "Paramètre 'nom' manquant.";
    }
} else {
    http_response_code(400);
    echo "Méthode de requête incorrecte.";
}
?>
