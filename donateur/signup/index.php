<?php
require_once "../../php/config.php";
?>

<!DOCTYPE html>
<html>

<head>
    <title>Inscription</title>
    <link rel="stylesheet" type="text/css" href="style.css">
</head>

<body>
    <h1>Inscription</h1>
    <form method="post" action="">
        <div class="form-group">
            <label for="name">Nom :</label>
            <input type="text" name="name" id="name" required>
        </div>
        <div class="form-group">
            <label for="prenom">Prénom :</label>
            <input type="text" name="prenom" id="prenom" required>
        </div>
        <div class="form-group">
            <label for="age">Âge :</label>
            <input type="number" name="age" id="age" required>
        </div>
        <div class="form-group">
            <label for="email">Adresse email :</label>
            <input type="email" name="email" id="email" required>
        </div>
        <div class="form-group">
            <label for="password">Mot de passe :</label>
            <input type="password" name="password" id="password" required>
        </div>
        <div class="form-group">
            <label for="adresse">Adresse :</label>
            <input type="text" name="adresse" id="adresse" required>
        </div>
        <button type="submit">S'inscrire</button>
    </form>
    <p>Vous avez déjà un compte? <a href="/<?php echo $BASEDIR; ?>/donateur/">Se connecter</a></p>

    <?php
    // Vérifier si le formulaire d'inscription a été soumis
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        // Récupérer les données du formulaire
        $name = $_POST['name'];
        $prenom = $_POST['prenom'];
        $age = $_POST['age'];
        $email = $_POST['email'];
        $password = $_POST['password'];
        $adresse = $_POST['adresse'];

        // Enregistrer l'utilisateur dans la base de données
        enregistrerUtilisateur($name, $prenom, $age, $email, $password, $adresse);
    }

    // Fonction pour enregistrer l'utilisateur dans la base de données
    function enregistrerUtilisateur($name, $prenom, $age, $email, $password, $adresse)
    {
        global $conn;
        global $BASEDIR;
        // Préparer la requête SQL d'insertion
        $sql = "INSERT INTO donateur (NAME, PRENOM, AGE, ADRESSE_EMAIL, MOT_DE_PASSE, Adresse) VALUES ('$name', '$prenom', '$age', '$email', '$password', '$adresse')";

        // Exécuter la requête SQL
        if (mysqli_query($conn, $sql)) {
            header('location: /' . $BASEDIR . '/donateur/index.php');
        } else {
            echo "Erreur lors de l'inscription : " . mysqli_error($conn);
        }

        // Fermer la connexion à la base de données
        mysqli_close($conn);
    }
    ?>
</body>
</html>