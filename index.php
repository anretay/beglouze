<?php
// Inclure le fichier de configuration
include 'config.php';

// Connexion à la base de données
$conn = mysqli_connect($config['db_host'], $config['db_user'], $config['db_password'], $config['db_base']);

if (!$conn) {
    die("Erreur de connexion : " . mysqli_connect_error());
}

// Récupérer les vendeurs depuis la base de données, triés par ordre alphabétique du nom
$sql = "SELECT id, nom, beglouzes FROM vendeurs ORDER BY nom ASC";
$result = mysqli_query($conn, $sql);

if (!$result) {
    die("Erreur lors de la récupération des données : " . mysqli_error($conn));
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestion Béglouzes</title>
    <link rel="stylesheet" href="styles.css"> <!-- Lien vers votre fichier CSS -->
        
    <!-- JavaScript pour la confirmation de suppression -->
    <script>
        function confirmDelete(id) {
            return confirm("Êtes-vous sûr de vouloir supprimer ce vendeur ?");
        }

        function removeSpaces(element) {
            element.value = element.value.replace(/\s/g, ''); // Supprime tous les espaces
        }
    </script>
</head>
<body>
    <h1>Espace Chef des Ventes</h1> 
    <h2>Mois de <?php echo ucfirst(strftime("%B %Y")); ?></h2>
    
    <form method="post" action="display.php">
        <input type="submit" value="Voir le Podium" class="black-button">
    </form>

    <table>
        <thead>
            <tr>
                <th>Vendeur</th>
                <th>Béglouzes</th>
                <th>Ajouter Béglouzes</th>
                <th>Retirer Béglouzes</th>
                <th>Supprimer</th>
            </tr>
        </thead>
        <tbody>
            <?php if (mysqli_num_rows($result) > 0): ?>
                <?php while ($row = mysqli_fetch_assoc($result)): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($row['nom']); ?></td>
                        <td><?php echo number_format($row['beglouzes'], 0, ',', ' '); ?></td>
                        <td>
                            <form method="post" action="modify_beglouzes.php" onsubmit="removeSpaces(this.elements['ajouter_beglouzes']);">
                                <input type="hidden" name="id" value="<?php echo $row['id']; ?>">
                                <input type="text" name="ajouter_beglouzes" placeholder="Ajouter Béglouzes">
                                <input type="submit" value="Ajouter" class="green-button">
                            </form>
                        </td>
                        <td>
                            <form method="post" action="modify_beglouzes.php" onsubmit="removeSpaces(this.elements['retirer_beglouzes']);">
                                <input type="hidden" name="id" value="<?php echo $row['id']; ?>">
                                <input type="text" name="retirer_beglouzes" placeholder="Retirer Béglouzes">
                                <input type="submit" value="Retirer" class="green-button">
                            </form>
                        </td>
                        <td>
                            <form id="deleteForm<?php echo $row['id']; ?>" method="post" action="delete_vendeur.php">
                                <input type="hidden" name="id" value="<?php echo $row['id']; ?>">
                                <input type="submit" class="delete-button red-button" value="Supprimer" onclick="return confirmDelete(<?php echo $row['id']; ?>)">
                            </form>
                        </td>
                    </tr>
                <?php endwhile; ?>
            <?php else: ?>
                <tr>
                    <td colspan="5">Aucun vendeur trouvé, ajoutez un nouveau vendeur juste en bas!</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>

    <form method="post" action="add_vendeur.php">
        <input type="text" name="nom" placeholder="Nom du nouveau vendeur" required>
        <input type="submit" value="Ajouter" class="green-button">
    </form>

    <form method="post" action="reset_vendeurs.php" onsubmit="return confirm('Êtes-vous sûr de vouloir réinitialiser tous les vendeurs ? Cette action est irréversible.');">
        <input type="submit" value="Réinitialiser tous les vendeurs" class="reset-button red-button">
    </form>

    <br> <br>

</body>
</html>



<?php
// Fermer la connexion à la base de données
mysqli_close($conn);
?>
