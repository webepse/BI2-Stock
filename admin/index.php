<?php
    session_start();
    require "../connexion.php";

    if(isset($_SESSION['login']))
    {
        header("LOCATION:dashboard.php");
    }

    // formulaire déjà envoyé ou non
    if(isset($_POST['login']) && isset($_POST['password']))
    {
        // si vide ou non
       if(empty($_POST['login']) OR empty($_POST['password']))
       {
        $error = "Veuillez remplir le formulaire correctement";
       }else{
            // traitement du login et mot passe
            $login = htmlspecialchars($_POST['login']);
            $req = $bdd->prepare("SELECT * FROM members WHERE login=?");
            $req->execute([$login]);
            if($don = $req->fetch())
            {
                // login existe
                // vérifier mot de passe
                if(password_verify($_POST['password'],$don['password']))
                {
                    // ok connexion
                    $_SESSION['login'] = $don['login'];
                    $req->closeCursor();
                    header("LOCATION:dashboard.php");
                }else{
                    // mot de passe incorrecte
                    $error = "Votre mot de passe ne correspond à votre login";
                }
            }else{
                // login n'existe pas
                $error = "Votre login n'existe pas";
            }
            $req->closeCursor();
       }
    }

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <div class="container">
        <h1>Connexion à l'administration de Stock</h1>
        <?php
        if(isset($error))
        {
            echo "<div class='alert'>".$error."</div>";
        }
        ?>
        <form action="index.php" method="POST">
            <div class="form-group">
                <label for="login">Login: </label>
                <input type="text" id="login" name="login">
            </div>
            <div class="form-group">
                <label for="password">Mot de passe: </label>
                <input type="password" name="password" id="password">
            </div>
            <div class="form-group">
                <input type="submit" value="Connexion">
            </div>
        </form>
    </div>
</body>
</html>