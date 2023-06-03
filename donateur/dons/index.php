<?php
require_once "../../php/config.php";
?>

<!DOCTYPE html>
<html>

<head>
    <title>Mes Dons</title>
    <link rel="stylesheet" href="style.css">
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
        <h2>Mes Dons</h2>
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

                // Vérifier si l'utilisateur est connecté
                if (isset($_SESSION['user_id'])) {
                    $donateur_id = $_SESSION['user_id'];

                    // Récupérer les dons du donateur
                    $query = "SELECT * FROM dons WHERE ID_DONATEUR = $donateur_id";
                    $result = mysqli_query($conn, $query);

                    if (mysqli_num_rows($result) > 0) {
                        while ($row = mysqli_fetch_assoc($result)) {
                            echo '<tr>';
                            echo '<td>' . $row['nomdon'] . '</td>';
                            echo '<td>' . $row['categoriedon'] . '</td>';
                            echo '<td>' . $row['tailledon'] . '</td>';
                            echo '<td>' . $row['etat'] . '</td>';
                            echo '<td>';
                            if ($row['etat'] === 'Arrivé') {
                                echo '<a href="bienfaiteurs.php?tracking_code=' . $row['tracking_code'] . '" >Voir</a>';
                            }
                            echo '</td>';
                            echo '</tr>';
                        }
                    } else {
                        echo '<tr><td colspan="5">Aucun don trouvé.</td></tr>';
                    }
                } else {
                    echo '<tr><td colspan="5">Vous devez vous connecter en tant que donateur pour voir vos dons.</td></tr>';
                }

                // Fermer la connexion à la base de données
                mysqli_close($conn);
                ?>
            </tbody>
        </table>
    </main>
</body>

</html>