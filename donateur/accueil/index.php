<?php
include_once('../../php/config.php');
if (!isset($_SESSION["user_id"])) {
    header('location: /' . $BASEDIR . '/donateur/index.php');
}
?>
<!DOCTYPE html>
<html>

<head>
    <title>Page d'accueil des clients</title>
    <link rel="stylesheet" type="text/css" href="style.css">
</head>

<body>
    <header>
        <div class="logo">
            <h1>DONATEMATE</h1>
        </div>
        <?php
            include_once('../../php/nav_donateur.php');
        ?>
    </header>

    <main>
        <h2>Produits disponibles</h2>
        <?php
        // Connexion à la base de données

        // Récupération de l'ID du donateur à partir de la session
        $id_donateur = $_SESSION['user_id'];

        // Récupération des produits disponibles
        $query = "SELECT produitc.*
                      FROM produitc 
                      
                      WHERE produitc.etatpc = 'en attente' order by 'id' asc";
        $result = mysqli_query($conn, $query);

        // Affichage des produits
        if (mysqli_num_rows($result) > 0) {
            while ($row = mysqli_fetch_assoc($result)) {
                echo '<div class="produit">';
                echo '<h3>' . $row['nomPC'] . '</h3>';
                echo '<p>Catégorie : ' . $row['categorie'] . '</p>';
                echo '<p>Taille : ' . $row['taille'] . '</p>';

                // Afficher l'image du produit s'il y en a une
                if (!empty($row['image'])) {
                    echo '<img src="/'. $BASEDIR.'/images/' . $row['image'] . '" alt="Image du produit" width="200px">';
                }

                // Ajout du bouton "Accepter" avec la fonctionnalité correspondante
                echo '<form method="post" action="" >';
                echo '<input type="hidden" name="produit_id" value="' . $row['id'] . '">';
                echo '<input type="hidden" name="donateur_id" value="' . $id_donateur . '">';
                echo '<input type="hidden" name="nom_produit" value="' . $row['nomPC'] . '">';
                echo '<input type="hidden" name="categorie" value="' . $row['categorie'] . '">';
                echo '<input type="hidden" name="taille" value="' . $row['taille'] . '">';
                echo '<button class="btn-accepter" type="submit" name="accepter">Accepter</button>';
                echo '</form>';

                echo '</div>';
            }
        } else {
            echo '<p>Aucun produit disponible pour le moment.</p>';
        }

        // Vérification si le bouton "Accepter" a été cliqué
        if (isset($_POST['accepter'])) {
            $produit_id = $_POST['produit_id'];
            $donateur_id = $_POST['donateur_id'];
            $nom_produit = $_POST['nom_produit'];
            $categorie = $_POST['categorie'];
            $taille = $_POST['taille'];
            $etat_dons = 'en attente';

            // Insérer les informations du produit dans la table "dons"
            $insert_query = "INSERT INTO dons (nomdon, categoriedon, tailledon, ID_DONATEUR, etat) 
                                VALUES ('$nom_produit', '$categorie', '$taille', '$donateur_id', '$etat_dons')";
            mysqli_query($conn, $insert_query);

            // Mettre à jour l'état du produit en "valide"
            $update_query = "UPDATE produitc SET etatpc = 'valide' WHERE id = $produit_id";
            mysqli_query($conn, $update_query);

            // Redirection vers la page de succès
        }

        // Fermeture de la connexion à la base de données
        mysqli_close($conn);
        ?>
    </main>
    <footer>
        <p>Plateforme de dons - Tous droits réservés</p>
    </footer>
</body>

</html>