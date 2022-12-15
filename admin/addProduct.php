<?php
    session_start();
    if(!isset($_SESSION['login']))
    {
        header("LOCATION:index.php");
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../bootstrap/css/bootstrap.min.css">
    <title>Administration de Stock</title>
    <script src="../bootstrap/js/bootstrap.bundle.min.js"></script>
</head>
<body>
    <?php
        include("partials/header.php");
    ?>
    <h1>Administration</h1>
    <div>
        <a href="products.php">Retour</a>
    </div>
    <h2>Ajouter un produit</h2>
    <form action="treatmentAddProduct.php" method="POST">
        <div class="form-group">
            <label for="title">Titre: </label>
            <input type="text" id="title" name="title">
        </div>
        <div class="form-group">
            <label for="date">Date: </label>
            <input type="date" id="date" name="date">
        </div>
        <div class="form-group">
            <label for="description">Description: </label>
            <textarea name="description" id="description" cols="30" rows="10"></textarea>
        </div>
        <div class="form-group">
            <input type="submit" value="Ajouter">
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