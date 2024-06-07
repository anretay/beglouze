<?php
include("config.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['id'])) {
        $vendeur_id = $_POST['id'];

        // Connexion à la base de données
        $conn = mysqli_connect($config['db_host'], $config['db_user'], $config['db_password'], $config['db_base']);

        if (!$conn) {
            echo "Erreur de connexion : " . mysqli_connect_error();
            http_response_code(500);
            exit();
        }

        // Vérifier si la colonne ajouter_beglouze est définie
        if (isset($_POST['ajouter_beglouzes'])) {
            $modifier_beglouzes = $_POST['ajouter_beglouzes'];
            $sql = "UPDATE vendeurs SET beglouzes = beglouzes + ? WHERE id = ?";
        } elseif (isset($_POST['retirer_beglouzes'])) {
            $modifier_beglouzes = $_POST['retirer_beglouzes'];
            $sql = "UPDATE vendeurs SET beglouzes = beglouzes - ? WHERE id = ?";
        } else {
            echo "Paramètre 'ajouter_beglouzes' ou 'retirer_beglouzes' manquant.";
            http_response_code(400);
            exit();
        }

        // Préparation de la requête
        $stmt = mysqli_prepare($conn, $sql);

        if ($stmt) {
            // Liage des paramètres
            mysqli_stmt_bind_param($stmt, "ii", $modifier_beglouzes, $vendeur_id);

            // Exécution de la requête
            if (mysqli_stmt_execute($stmt)) {
                // Redirection vers la page d'accueil après la modification
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
        echo "Paramètre 'id' manquant.";
    }
} else {
    http_response_code(400);
    echo "Méthode de requête incorrecte.";
}
?>
