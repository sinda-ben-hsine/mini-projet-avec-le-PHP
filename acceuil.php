<?php
session_start();


if (!isset($_SESSION['client_id'])) {
    header("Location: login.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Accueil Client</title>
</head>
<body>
    <h2>Bienvenue, <?php echo htmlspecialchars($_SESSION['nom_client']); ?> !</h2>
    <p>Vous êtes connecté.</p>
    <a href="logout.php">Se déconnecter</a>
    <a href="mes_reservations.php">voir mes reservations</a>
</body>
</html>
