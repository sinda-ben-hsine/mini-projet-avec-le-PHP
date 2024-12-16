<?php
session_start();


if (!isset($_SESSION['client_id'])) {
    header("Location: login.php");
    exit();
}

include 'connexion.php';

$client_id = $_SESSION['client_id'];
$sql = "SELECT r.ID, v.Marque, v.Modele, v.Annee, v.Immatriculation, r.DateDebut, r.DateFin
        FROM Reservations r
        JOIN Voitures v ON r.Voiture_ID = v.ID
        WHERE r.Client_ID = :client_id";
$stmt = $pdo->prepare($sql);
$stmt->execute([':client_id' => $client_id]);
$reservations = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Mes Réservations</title>
</head>
<body>
    <h2>Mes Réservations</h2>
    
    <?php if (count($reservations) > 0): ?>
        <table border="1">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Marque</th>
                    <th>Modèle</th>
                    <th>Année</th>
                    <th>Immatriculation</th>
                    <th>Date de Début</th>
                    <th>Date de Fin</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($reservations as $reservation): ?>
                    <tr>
                        <td><?php echo $reservation['ID']; ?></td>
                        <td><?php echo $reservation['Marque']; ?></td>
                        <td><?php echo $reservation['Modele']; ?></td>
                        <td><?php echo $reservation['Annee']; ?></td>
                        <td><?php echo $reservation['Immatriculation']; ?></td>
                        <td><?php echo $reservation['DateDebut']; ?></td>
                        <td><?php echo $reservation['DateFin']; ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    <?php else: ?>
        <p>Aucune réservation effectuée.</p>
    <?php endif; ?>
    
    <p><a href="acceuil.php">Retour à l'accueil</a></p>
    <a href="reservation.php"> aller au reserver</a>
</body>
</html>
