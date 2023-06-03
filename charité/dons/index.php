<?php
require_once "../../php/config.php";
?>

<!DOCTYPE html>
<html>

<head>
    <title>Gestion des Dons</title>
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
        <h2>Gestion des Dons</h2>
        <table>
            <thead>
                <tr>
                    <th>Nom</th>
                    <th>Catégorie</th>
                    <th>Taille</th>
                    <th>État</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php
                // Inclure le fichier de configuration de la base de données

                // Fonction pour mettre à jour l'état d'un don
                function mettre_a_jour_etat($don_id, $new_etat)
                {
                    global $conn;

                    // Préparer la requête SQL de mise à jour
                    $sql = "UPDATE dons SET etat = '$new_etat' WHERE tracking_code = '$don_id'";

                    // Exécuter la requête SQL
                    if (mysqli_query($conn, $sql)) {
                        echo "État mis à jour avec succès.";
                    } else {
                        echo "Erreur lors de la mise à jour de l'état : " . mysqli_error($conn);
                    }
                }

                // Vérifier si le formulaire a été soumis
                if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['don_id']) && isset($_POST['new_etat'])) {
                    $don_id = $_POST['don_id'];
                    $new_etat = $_POST['new_etat'];

                    // Appeler la fonction pour mettre à jour l'état
                    mettre_a_jour_etat($don_id, $new_etat);
                }

                // Récupérer les dons
                $query = "SELECT * FROM dons";
                $result = mysqli_query($conn, $query);

                if (mysqli_num_rows($result) > 0) {
                    while ($row = mysqli_fetch_assoc($result)) {
                        echo '<tr>';
                        echo '<td>' . $row['nomdon'] . '</td>';
                        echo '<td>' . $row['categoriedon'] . '</td>';
                        echo '<td>' . $row['tailledon'] . '</td>';
                        echo '<td>' . $row['etat'] . '</td>';
                        echo '<td>';
                        echo '<form method="POST" action="">';
                        echo '<input type="hidden" name="don_id" value="' . $row['tracking_code'] . '">';
                        echo '<select name="new_etat">';
                        echo '<option value="En stock">En stock</option>';
                        echo '<option value="Arrivé">Arrivé</option>';
                        echo '</select>';
                        echo '<button type="submit" name="changer_etat">Changer État</button>';
                        echo '</form>';
                        echo '</td>';
                        echo '</tr>';
                    }
                } else {
                    echo '<tr><td colspan="5">Aucun don trouvé.</td></tr>';
                }

                // Fermer la connexion à la base de données
                mysqli_close($conn);
                ?>
            </tbody>
        </table>
    </main>
</body>

</html>