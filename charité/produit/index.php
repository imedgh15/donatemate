<?php
// Inclure le fichier de configuration de la base de données
require_once "../../php/config.php";
?>

<!DOCTYPE html>
<html>

<head>
    <title>Produits de Charité</title>
    <link rel="stylesheet" href="style.css">
</head>

<body>
    <header>
        <div class="logo">
            <h1>DONATEMATE</h1>
        </div>
        <?php
        include_once('../../php/nav_charité.php');
        ?>
    </header>
    <main>
        <h2>Produits de Charité</h2>
        <table>
            <thead>
                <tr>
                    <th>Nom</th>
                    <th>Catégorie</th>
                    <th>Taille</th>
                    <th>État</th>
                </tr>
            </thead>
            <tbody>
                <?php


                // Récupérer les produits de charité
                $query = "SELECT * FROM produitc";
                $result = mysqli_query($conn, $query);

                if (mysqli_num_rows($result) > 0) {
                    while ($row = mysqli_fetch_assoc($result)) {
                        echo '<tr>';
                        echo '<td>' . $row['nomPC'] . '</td>';
                        echo '<td>' . $row['categorie'] . '</td>';
                        echo '<td>' . $row['taille'] . '</td>';
                        echo '<td>' . $row['etatpc'] . '</td>';
                        echo '</tr>';
                    }
                } else {
                    echo '<tr><td colspan="4">Aucun produit de charité trouvé.</td></tr>';
                }

                // Fermer la connexion à la base de données
                mysqli_close($conn);
                ?>
            </tbody>
        </table>
    </main>
</body>

</html>