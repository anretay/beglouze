<?php
// Inclure le fichier de configuration
include 'config.php';

// Connexion à la base de données
$conn = mysqli_connect($config['db_host'], $config['db_user'], $config['db_password'], $config['db_base']);

if (!$conn) {
    die("Erreur de connexion : " . mysqli_connect_error());
}

// Récupérer les vendeurs depuis la base de données
$sql = "SELECT nom, beglouzes FROM vendeurs ORDER BY beglouzes DESC";
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
    <title>Béglouze Bank</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f2f2f2;
        }
        h1 {
            text-align: center;
            color: #000000;
            margin-top: 50px;
            font-size: 36px;
            font-weight: bold;
            text-transform: uppercase;
        }
        table {
            width: 60%;
            margin: 0 auto;
            border-collapse: collapse;
            background-color: white;
            box-shadow: 0px 0px 20px rgba(0, 0, 0, 0.1);
        }
        th, td {
            padding: 15px;
            text-align: left;
            border-bottom: 1px solid #dddddd;
        }
        th {
            background-color: #ff0000;
            color: white;
            text-transform: uppercase;
            font-size: 14px;
        }
        td {
            font-size: 16px;
        }
        tr:nth-child(even) {
            background-color: #f2f2f2;
        }
        tr:hover {
            background-color: #e2e2e2;
        }
    </style>
</head>
<body>
    <h1>Podium Béglouze <?php echo ucfirst(strftime("%B %Y")); ?></h1>
    <table>
        <thead>
            <tr>
                <th>Vendeur</th>
                <th>Béglouzes</th>
            </tr>
        </thead>
        <tbody>
            <?php 
            if (mysqli_num_rows($result) > 0): 
                while ($row = mysqli_fetch_assoc($result)): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($row['nom']); ?></td>
                        <td><?php echo number_format($row['beglouzes'], 0, ',', ' '); ?></td>
                    </tr>
            <?php 
                endwhile; 
            else: ?>
                <tr>
                    <td colspan="2" style="text-align: center;">Aucun vendeur trouvé.</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>
</body>
</html>

<?php
// Fermer la connexion à la base de données
mysqli_close($conn);
?>
