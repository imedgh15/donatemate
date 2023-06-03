<?php
require_once "../php/config.php";
?>
<!DOCTYPE html>
<html>

<head>
    <title>Accueil Charité</title>
    <link rel="stylesheet" href="style.css">
</head>

<body>
    <header>
        <div class="logo">
            <h1>DONORMATE</h1>
        </div>
        <?php
            include_once('../php/nav_charité.php');
        ?>
    </header>
    <main>
        <h2>Produits en attente</h2>

        <?php


        // Récupérer les produits en attente avec l'ID du donateur
        $query = "SELECT porduitd.id_pd,porduitd.nomPD,porduitd.categorie,porduitd.taille,
        porduitd.image,porduitd.etatpd,porduitd.ID_DONATEUR, donateur.NAME FROM porduitd JOIN donateur ON porduitd.ID_DONATEUR = donateur.ID_DONATEUR WHERE porduitd.etatpd = 'en attente'";
        $result = mysqli_query($conn, $query);

        // Vérifier si des produits sont disponibles
        if (mysqli_num_rows($result) > 0) {
            while ($row = mysqli_fetch_assoc($result)) {
                echo '<div class="produit-donateur">';
                echo '<h3>' . $row['nomPD'] . '</h3>';
                echo '<img src="/' . $BASEDIR . '/images/' . $row['image'] . '" alt="Image du produit" width="200px">';
                echo '<p>' . $row['categorie'] . '</p>';
                echo '<p>Taille : ' . $row['taille'] . '</p>';
                echo '<p>Donateur : ' . $row['NAME'] . '</p>';

                echo '<form method="post" action="">';
                echo '<input type="hidden" name="produit_id" value="' . $row['id_pd'] . '">';
                echo '<button class="btn-accepter" type="submit" name="accepter">Accepter</button>';
                echo '</form>';
                echo '</div>';
            }
        } else {
            echo '<p>Aucun produit en attente.</p>';
        }

        // Vérifier si le bouton "Accepter" a été cliqué
        if (isset($_POST['accepter'])) {
            $produit_id = $_POST['produit_id'];

            // Mettre à jour l'état du produit
            $update_query = "UPDATE porduitd SET etatpd = 'valide' WHERE id_pd = $produit_id";
            mysqli_query($conn, $update_query);

            // Récupérer les informations du produit
            $select_query = "SELECT nomPD, categorie, taille, ID_DONATEUR FROM porduitd WHERE id_pd = $produit_id";
            $result = mysqli_query($conn, $select_query);
            $row = mysqli_fetch_assoc($result);
            $nom = $row['nomPD'];
            $categorie = $row['categorie'];
            $taille = $row['taille'];
            $donateur_id = $row['ID_DONATEUR'];

            // Insérer les informations du produit dans la table "dons"
            $insert_query = "INSERT INTO dons (nomdon, categoriedon, tailledon, id_donateur, etat) VALUES ('$nom', '$categorie', '$taille', '$donateur_id', 'en attente')";
            mysqli_query($conn, $insert_query);

            // Rediriger vers la page actuelle pour rafraîchir la liste des produits
            header("Location: " . $_SERVER['PHP_SELF']);
            exit();
        }

        // Fermer la connexion à la base de données
        mysqli_close($conn);
        ?>
    </main>
</body>

</html>