<?php

include 'connexion.php';


if (isset($_POST['inscription'])) {
    $nom = $_POST['nom'];
    $adresse = $_POST['adresse'];
    $telephone = $_POST['telephone'];
    $email = $_POST['email'];
    $mot_de_passe = $_POST['mot_de_passe'];

    $mot_de_passe_hash = password_hash($mot_de_passe, PASSWORD_DEFAULT);


    $sql = "INSERT INTO Clients (Nom, Adresse, Telephone, Email, MotDePasse) 
            VALUES (:nom, :adresse, :telephone, :email, :mot_de_passe)";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([
        ':nom' => $nom,
        ':adresse' => $adresse,
        ':telephone' => $telephone,
        ':email' => $email,
        ':mot_de_passe' => $mot_de_passe_hash
    ]);

    echo "<p>Inscription réussie !</p>";
    header("Location: acceuil.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Inscription Client</title>
</head>
<body>
    <h2>Inscription Client</h2>
    <form action="inscription.php" method="post">
        <label for="nom">Nom :</label>
        <input type="text" name="nom" required><br>
        
        <label for="adresse">Adresse :</label>
        <input type="text" name="adresse" required><br>
        
        <label for="telephone">Téléphone :</label>
        <input type="text" name="telephone" required><br>
        
        <label for="email">Email :</label>
        <input type="email" name="email" required><br>
        
        <label for="mot_de_passe">Mot de passe :</label>
        <input type="password" name="mot_de_passe" required><br>
        
        <button type="submit" name="inscription">S'inscrire</button>
    </form>
</body>
</html>
