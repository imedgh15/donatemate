<?php
// Inclure le fichier de configuration de la base de données
require_once "../../php/config.php";

// Fonction pour ajouter un produit
function ajouter_produit($nompd, $categorie, $taille, $image, $id_donateur)
{
    global $conn;

    // Préparer la requête SQL d'insertion
    $sql = "INSERT INTO porduitd (nompd, categorie, taille, image, ID_DONATEUR, etatpd) VALUES ('$nompd', '$categorie', '$taille', '$image', '$id_donateur', 'En attente')";

    // Exécuter la requête SQL
    if (mysqli_query($conn, $sql)) {
        echo "Produit ajouté avec succès.";
    } else {
        echo "Erreur lors de l'ajout du produit : " . mysqli_error($conn);
    }
}

// Vérifier si le formulaire a été soumis
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Récupérer les données du formulaire
    $upload_image = uploadImage();
    if ($upload_image->success) {
        $nompd = $_POST['nom'];
        $categorie = $_POST['categorie'];
        $taille = $_POST['taille'];
        $image_link = $upload_image->file_name;

        // Vérifier si l'utilisateur est connecté
        if (isset($_SESSION['user_id'])) {
            $id_donateur = $_SESSION['user_id']; // Récupérer l'ID du donateur connecté

            // Vérifier si un lien d'image a été fourni
            if (!empty($image_link)) {
                // Assigner le lien de l'image à la variable
                $image = $image_link;

                // Appeler la fonction d'ajout du produit
                ajouter_produit($nompd, $categorie, $taille, $image, $id_donateur);
            } else {
                echo "Veuillez fournir un lien d'image.";
            }
        } else {
            echo "Vous devez vous connecter en tant que donateur pour ajouter un produit.";
        }
    } else {
        echo $upload_image->error_message;
    }
}
?>
<!DOCTYPE html>
<html>

<head>
    <title>Ajouter un produit</title>
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

    <div class="container">
        <h1>Ajouter un produit</h1>
        <form method="POST" action="" enctype="multipart/form-data">
            <div class="form-group">
                <label for="nom">Nom :</label>
                <input type="text" name="nom" id="nom" required>
            </div>
            <div class="form-group">
                <label for="categorie">Catégorie :</label>
                <textarea name="categorie" id="categorie" required></textarea>
            </div>
            <div class="form-group">
                <label for="taille">Taille :</label>
                <input type="text" name="taille" id="taille" step="0.01" required>
            </div>
            <div class="form-group">
                <label for="image_link">Image :</label>
                <input type="file" name="fileToUpload" id="fileToUpload" required>
            </div>
            <div class="form-group">
                <button type="submit">Ajouter</button>
            </div>
        </form>
    </div>
</body>

</html>