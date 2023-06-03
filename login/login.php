<!DOCTYPE html>
<html>
<head>
    <title>Connexion</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <h1>Connexion</h1>
    <form method="post" action="login.php">
        <div class="form-group">
            <label for="email">Adresse email :</label>
            <input type="email" name="email" id="email" required>
        </div>
        <div class="form-group">
            <label for="password">Mot de passe :</label>
            <input type="password" name="password" id="password" required>
        </div>
        <button type="submit">Se connecter</button>
    </form>
    <p>Vous n'avez pas de compte? <a href="http://localhost/projet/signup/signup.php">S'inscrire</a></p>

    <?php
    // Vérifier si le formulaire de connexion a été soumis
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        // Récupérer les données du formulaire
        $email = $_POST['email'];
        $password = $_POST['password'];

        // Valider les informations de connexion
        if (validerConnexion($email, $password)) {
            // Rediriger vers la page d'accueil après la connexion réussie
            header("Location: http://localhost/projet/acceuilDon/acceuilDon.php");
            exit();
        } else {
            echo "Identifiants de connexion invalides.";
        }
    }

    // Fonction pour valider les informations de connexion
    function validerConnexion($email, $password) {
        // Connexion à la base de données
        require_once "C:\x\htdocs\projet\php\config.php";

        // Préparer la requête SQL
        $sql = "SELECT ID_DONATEUR FROM donateur WHERE ADRESSE_EMAIL = '$email' AND MOT_DE_PASSE = '$password'";

        // Exécuter la requête SQL
        $result = mysqli_query($conn, $sql);

        // Vérifier si l'utilisateur existe dans la base de données
        if (mysqli_num_rows($result) == 1) {
            // Récupérer l'ID de l'utilisateur
            $row = mysqli_fetch_assoc($result);
            $user_id = $row['ID_DONATEUR'];

            // Stocker l'ID de l'utilisateur dans une variable de session
            session_start();
            $_SESSION['user_id'] = $user_id;

            // Fermer la connexion à la base de données
            mysqli_close($conn);

            // Retourner true si la connexion est valide, sinon false
            return true;
        } else {
            // Fermer la connexion à la base de données
            mysqli_close($conn);

            // Retourner false si la connexion est invalide
            return false;
        }
    }
    ?>
</body>
</html>