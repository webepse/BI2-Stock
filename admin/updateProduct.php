<?php
    session_start();
    if(!isset($_SESSION['login']))
    {
        header("LOCATION:index.php");
    }


    //vérifier la prés de id
    if(isset($_GET['id']))
    {
        $id = htmlspecialchars($_GET['id']);
    }else{
        header("LOCATION:products.php");
    }

    // vérifier si l'id est dans la bdd
    require "../connexion.php";
    $req = $bdd->prepare("SELECT * FROM products WHERE id=?");
    $req->execute([$id]);
    if(!$don = $req->fetch())
    {
        $req->closeCursor();
        header("LOCATION:products.php");
    }
    $req->closeCursor();
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
    <h1>Administration</h1>
    <div>
        <a href="products.php">Retour</a>
    </div>
    <h2>Modifier un produit</h2>
    <form action="treatmentUpdateProduct.php?id=<?= $id ?>" method="POST">
        <div class="form-group">
            <label for="title">Titre: </label>
            <input type="text" id="title" name="title" value="<?= $don['title'] ?>">
        </div>
        <div class="form-group">
            <label for="date">Date: </label>
            <input type="date" id="date" name="date" value="<?= $don['date'] ?>">
        </div>
        <div class="form-group">
            <label for="description">Description: </label>
            <textarea name="description" id="description" cols="30" rows="10"><?= $don['description'] ?></textarea>
        </div>
        <div class="form-group">
            <input type="submit" value="Modifier">
        </div>
    </form>
    <?php
        if(isset($_GET['error']))
        {
            echo "<div class='alert'>Une erreur est survenue (code: ".$_GET['error'].")</div>";
        }
    ?>
</body>
</html>