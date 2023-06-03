<?php
// Inclure le fichier de configuration de la base de données
require_once "../../php/config.php";

// Fonction pour ajouter un produit
function ajouter_produit($nomPC, $categorie, $taille, $image)
{
    global $conn;

    // Préparer la requête SQL d'insertion
    $sql = "INSERT INTO produitc (nomPC, categorie, taille, image, etatpc) VALUES ('$nomPC', '$categorie', '$taille', '$image', 'En attente')";

    // Exécuter la requête SQL
    if (mysqli_query($conn, $sql)) {
        echo "Produit ajouté avec succès.";
    } else {
        echo "Erreur lors de l'ajout du produit : " . mysqli_error($conn);
    }
}

// Vérifier si le formulaire a été soumis
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $upload_image= uploadImage();
    if($upload_image->success){
        // Récupérer les données du formulaire
        $nomPC = $_POST['nom'];
        $categorie = $_POST['categorie'];
        $taille = $_POST['taille'];
        $image_link = $upload_image->file_name;

        // Vérifier si un lien d'image a été fourni
        if (!empty($image_link)) {
            // Assigner le lien de l'image à la variable
            $image = $image_link;

            // Appeler la fonction d'ajout du produit
            ajouter_produit($nomPC, $categorie, $taille, $image);
        } else {
            echo "Veuillez fournir un lien d'image.";
        }
    }else{
        echo $upload_image->error_message;
    }

}
?>
<!DOCTYPE html>
<html>

<head>
    <title>Ajouter un produit</title>
    <link rel="stylesheet" href="styleajoute.css">
</head>

<body>
    <header>
        <div class="logo">
            <h1><a href="/<?php echo $BASEDIR; ?>/charité">DONATEMATE</a>
                <h1>
        </div>
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
                <label for="image_link">Lien de l'image :</label>
                <input type="file" name="fileToUpload" id="fileToUpload" required>
            </div>
            <div class="form-group">
                <button type="submit">Ajouter</button>
            </div>
        </form>
    </div>
</body>

</html>