<?php
session_start();


if (!isset($_SESSION['client_id'])) {
    header("Location: login.php");
    exit();
}

include 'connexion.php';


$voitures_disponibles = [];


if (isset($_POST['rechercher'])) {
    $date_debut = $_POST['date_debut'];
    $date_fin = $_POST['date_fin'];

    
    $sql = "SELECT * FROM Voitures WHERE Disponibilite = 1 AND ID NOT IN (
                SELECT Voiture_ID FROM Reservations 
                WHERE (DateDebut <= :date_fin AND DateFin >= :date_debut)
            )";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([':date_debut' => $date_debut, ':date_fin' => $date_fin]);
    $voitures_disponibles = $stmt->fetchAll(PDO::FETCH_ASSOC);
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Réservation de Voiture</title>
</head>
<body>
    <h2>Réserver une Voiture</h2>
    

    <form action="reservation.php" method="post">
        <label for="date_debut">Date de début :</label>
        <input type="date" name="date_debut" required><br>
        
        <label for="date_fin">Date de fin :</label>
        <input type="date" name="date_fin" required><br>
        
        <button type="submit" name="rechercher">Rechercher</button>
    </form>

    <?php if (!empty($voitures_disponibles)): ?>
        <h3>Voitures Disponibles :</h3>
        <form action="reserver.php" method="post">
            <input type="hidden" name="date_debut" value="<?php echo htmlspecialchars($date_debut); ?>">
            <input type="hidden" name="date_fin" value="<?php echo htmlspecialchars($date_fin); ?>">
            
            <table border="1">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Marque</th>
                        <th>Modèle</th>
                        <th>Année</th>
                        <th>Immatriculation</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($voitures_disponibles as $voiture): ?>
                        <tr>
                            <td><?php echo $voiture['ID']; ?></td>
                            <td><?php echo $voiture['Marque']; ?></td>
                            <td><?php echo $voiture['Modele']; ?></td>
                            <td><?php echo $voiture['Annee']; ?></td>
                            <td><?php echo $voiture['Immatriculation']; ?></td>
                            <td>
                                <button type="submit" name="reserver" value="<?php echo $voiture['ID']; ?>">Réserver</button>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </form>
    <?php elseif (isset($_POST['rechercher'])): ?>
        <p>Aucune voiture disponible pour cette période.</p>
    <?php endif; ?>
</body>
</html>
