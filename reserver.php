<?php
session_start();


if (!isset($_SESSION['client_id'])) {
    header("Location: login.php");
    exit();
}


include 'connexion.php';


if (isset($_POST['reserver'])) {
    $client_id = $_SESSION['client_id'];  
    $voiture_id = $_POST['reserver'];     
    $date_debut = $_POST['date_debut'];   
    $date_fin = $_POST['date_fin'];       

  
    $sql = "INSERT INTO Reservations (Client_ID, Voiture_ID, DateDebut, DateFin) 
            VALUES (:client_id, :voiture_id, :date_debut, :date_fin)";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([
        ':client_id' => $client_id,
        ':voiture_id' => $voiture_id,
        ':date_debut' => $date_debut,
        ':date_fin' => $date_fin
    ]);


    $sql_update = "UPDATE Voitures SET Disponibilite = 0 WHERE ID = :voiture_id";
    $stmt_update = $pdo->prepare($sql_update);
    $stmt_update->execute([':voiture_id' => $voiture_id]);

    echo "<p>Réservation effectuée avec succès !</p>";
    echo "<p>Merci de votre réservation.</p>";
    echo "<p><a href='acceuil.php'>Retour à l'accueil</a></p>";
}
?>
