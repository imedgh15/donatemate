<!DOCTYPE html>
<html>
<head>
    <title>Mes Produits</title>
    <link rel="stylesheet" href="stylepc.css">
</head>
<body>
    <header>
        <div class="logo">
            <h1>DONATEMATE</h1>
        </div>
        <nav>
            <ul>
                <li><a href="http://localhost/projet/acceuilDon/acceuilDon.php">Accueil</a></li>
                <li><a href="ahttp://localhost/projet/ajouteDon/ajouteDon.php">Ajouter un produit</a></li>
                <li><a href="#">Mes dons</a></li>
                <li><a href="#">Déconnexion</a></li>
            </ul>
        </nav>
    </header>
    <main>
        <h2>Mes Produits</h2>
        <table>
            <thead>
                <tr>
                    <th>Nom</th>
                    <th>Catégorie</th>
                    <th>Taille</th>
                    <th>État</th>
                    <th>Supprimer</th>
                </tr>
            </thead>
            <tbody>
            <?php
            // Inclure le fichier de configuration de la base de données
            require_once "C:\x\htdocs\projet\php\config.php";

            // Vérifier si l'utilisateur est connecté
            session_start();
            if (isset($_SESSION['user_id'])) {
                $donateur_id = $_SESSION['user_id'];

                // Récupérer les produits du donateur
                $query = "SELECT * FROM porduitd WHERE ID_DONATEUR = $donateur_id";
                $result = mysqli_query($conn, $query);

                if (mysqli_num_rows($result) > 0) {
                    while ($row = mysqli_fetch_assoc($result)) {
                        echo '<tr>';
                        echo '<td>' . $row['nomPD'] . '</td>';
                        echo '<td>' . $row['categorie'] . '</td>';
                        echo '<td>' . $row['taille'] . '</td>';
                        echo '<td>' . $row['etatpd'] . '</td>';
                        echo '<td>';
                        echo '<form method="POST" action="">';
                        echo '<input type="hidden" name="produit_id" value="' . $row['id_pd'] . '">';
                        echo '<button type="submit" name="supprimer">Supprimer</button>';
                        echo '</form>';
                        echo '</td>';
                        echo '</tr>';
                    }
                } else {
                    echo '<tr><td colspan="5">Aucun produit trouvé.</td></tr>';
                }

                // Vérifier si le bouton "Supprimer" a été cliqué
                if (isset($_POST['supprimer'])) {
                    $produit_id = $_POST['produit_id'];

                    // Supprimer le produit de la base de données
                    $delete_query = "DELETE FROM porduitd WHERE id_pd = $produit_id";
                    mysqli_query($conn, $delete_query);

                    // Rediriger vers la page actuelle pour actualiser la liste des produits
                    header("Location: ".$_SERVER['PHP_SELF']);
                    exit();
                }
            } else {
                echo '<tr><td colspan="5">Vous devez vous connecter en tant que donateur pour voir vos produits.</td></tr>';
            }

            // Fermer la connexion à la base de données
            mysqli_close($conn);
            ?>
            </tbody>
        </table>
    </main>
</body>
</html>
