<?php

include 'connexion.php';


$id = "";
$marque =  "";
$modele =  "";
$annee =  "";
$immatriculation = "";
$disponibilite = 1; 


if (isset($_POST['add'])) {
    $marque = $_POST['marque'];
    $modele = $_POST['modele'];
    $annee = $_POST['annee'];
    $immatriculation = $_POST['immatriculation'];
    $disponibilite = $_POST['disponibilite'];

    $sql = "INSERT INTO Voitures (Marque, Modele, Annee, Immatriculation, Disponibilite) 
            VALUES (:marque, :modele, :annee, :immatriculation, :disponibilite)";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([
        ':marque' => $marque, 
        ':modele' => $modele, 
        ':annee' => $annee, 
        ':immatriculation' => $immatriculation,
        ':disponibilite' => $disponibilite
    ]);
    echo "<p>Voiture ajoutée avec succès.</p>";
}


if (isset($_POST['search'])) {
    $id = $_POST['id'];
    $sql = "SELECT * FROM Voitures WHERE ID = :id";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([':id' => $id]);
    $voiture = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($voiture) {
        $marque = $voiture['Marque'];
        $modele = $voiture['Modele'];
        $annee = $voiture['Annee'];
        $immatriculation = $voiture['Immatriculation'];
        $disponibilite = $voiture['Disponibilite'];
    } else {
        echo "<p>Voiture introuvable.</p>";
    }
}


if (isset($_POST['update'])) {
    $id = $_POST['id'];
    $marque = $_POST['marque'];
    $modele = $_POST['modele'];
    $annee = $_POST['annee'];
    $immatriculation = $_POST['immatriculation'];
    $disponibilite = $_POST['disponibilite'];

    $sql = "UPDATE Voitures SET Marque=:marque, Modele=:modele, Annee=:annee, 
            Immatriculation=:immatriculation, Disponibilite=:disponibilite WHERE ID=:id";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([
        ':id' => $id, 
        ':marque' => $marque, 
        ':modele' => $modele, 
        ':annee' => $annee, 
        ':immatriculation' => $immatriculation,
        ':disponibilite' => $disponibilite
    ]);
    echo "<p>Voiture modifiée avec succès.</p>";
}

if (isset($_POST['delete'])) {
    $id = $_POST['id'];
    $sql = "DELETE FROM Voitures WHERE ID=:id";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([':id' => $id]);
    echo "<p>Voiture supprimée avec succès.</p>";
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Gestion des Voitures</title>
</head>
<body>
    <h2>Gestion des Voitures</h2>
    <form action="" method="post">
        <label for="id">ID :</label>
        <input type="text" name="id" placeholder="ID de la voiture" value="<?php echo $id; ?>"><br>
        <label for="marque">Marque :</label>
        <input type="text" name="marque" placeholder="Marque" value="<?php echo $marque; ?>"><br>
        <label for="modele">Modèle :</label>
        <input type="text" name="modele" placeholder="Modèle" value="<?php echo $modele; ?>"><br>
        <label for="annee">Année :</label>
        <input type="number" name="annee" placeholder="Année" value="<?php echo $annee; ?>"><br>
        <label for="immatriculation">Immatriculation :</label>
        <input type="text" name="immatriculation" placeholder="Immatriculation" value="<?php echo $immatriculation; ?>"><br>
        <label>Disponibilité :</label>
        <input type="radio" name="disponibilite" value="1" <?php if ($disponibilite == 1) echo "checked"; ?>> Oui
        <input type="radio" name="disponibilite" value="0" <?php if ($disponibilite == 0) echo "checked"; ?>> Non<br>

        <button type="submit" name="add">Ajouter</button>
        <button type="submit" name="search">Rechercher</button>
        <button type="submit" name="update">Modifier</button>
        <button type="submit" name="delete">Supprimer</button>
    </form>

    <h3>Liste des Voitures</h3>
    <table border="1">
        <thead>
            <tr>
                <th>ID</th>
                <th>Marque</th>
                <th>Modèle</th>
                <th>Année</th>
                <th>Immatriculation</th>
                <th>Disponibilité</th>
            </tr>
        </thead>
        <tbody>
            <?php
            
            $stmt = $pdo->query("SELECT * FROM Voitures");
            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                $disponibilite = $row['Disponibilite'] ? 'Oui' : 'Non';
                echo "<tr>
                        <td>{$row['ID']}</td>
                        <td>{$row['Marque']}</td>
                        <td>{$row['Modele']}</td>
                        <td>{$row['Annee']}</td>
                        <td>{$row['Immatriculation']}</td>
                        <td>{$disponibilite}</td>
                    </tr>";
            }
            ?>
        </tbody>
    </table>
</body>
</html>
