<?php
function ajouter_produit($nompd, $categorie, $taille, $id_donateur, $image) {
    // Connexion à la base de données
    require_once "config.php";

    // Préparer la requête SQL d'insertion
    $sql = "INSERT INTO produitd (nompd, categorie, taille, image , ID_DONATEUR) VALUES (?, ?, ?, ?, ?)";

    // Préparer la déclaration
    $stmt = $conn->prepare($sql);

    // Lier les paramètres
    $stmt->bind_param("ssisi", $nompd, $categorie, $taille,$image , $id_donateur);

    // Exécuter la requête
    if ($stmt->execute()) {
        echo "Produit ajouté avec succès.";
        header("Location: http://localhost/projet/ajouteDon/ajouteDon.php");
    } else {
        echo "Erreur lors de l'ajout du produit : " . $stmt->error;
    }

    // Fermer la déclaration
    $stmt->close();

    // Fermer la connexion à la base de données
    $conn->close();
}
?>