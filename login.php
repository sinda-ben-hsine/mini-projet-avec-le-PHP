<?php

session_start();

include 'connexion.php';

if (isset($_POST['connexion'])) {
    $email = $_POST['email'];
    $mot_de_passe = $_POST['mot_de_passe'];

    $sql = "SELECT * FROM Clients WHERE Email = :email";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([':email' => $email]);
    $client = $stmt->fetch(PDO::FETCH_ASSOC);

   
    if ($client && password_verify($mot_de_passe, $client['MotDePasse'])) {
        
        $_SESSION['client_id'] = $client['ID'];
        $_SESSION['nom_client'] = $client['Nom'];
        
        header("Location: acceuil.php"); 
        exit();
    } else {
        echo "<p>Email ou mot de passe incorrect.</p>";
    }
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Connexion Client</title>
</head>
<body>
    <h2>Connexion Client</h2>
    <form action="login.php" method="post">
        <label for="email">Email :</label>
        <input type="email" name="email" required><br>
        
        <label for="mot_de_passe">Mot de passe :</label>
        <input type="password" name="mot_de_passe" required><br>
        
        <button type="submit" name="connexion">Se connecter</button>
    </form>
</body>
</html>
