<?php 
    session_start();
    if(!isset($_SESSION['login']))
    {
        header("LOCATION:index.php");
    }

    // s'il vient de mon form ou non
    if(isset($_POST['title']))
    {
        // vérif du contenu du formulaire et gestion error
        // init d'une variable $err à 0 
        $err = 0;
        if(empty($_POST['title']))
        {
            $err = 1;
        }else{
            $title = htmlspecialchars($_POST['title']);
        }

        if(empty($_POST['date']))
        {
            $err = 2;
        }else{
            $date = htmlspecialchars($_POST['date']);
        }

        if(empty($_POST['description']))
        {
            $err = 3;
        }else{
            $description = htmlspecialchars($_POST['description']);
        }

        //vérif si err sinon traitement
        if($err==0){
            require "../connexion.php";
            $insert = $bdd->prepare("INSERT INTO products(title,date,description) VALUES(?,?,?)");
            $insert->execute([$title,$date,$description]);
            $insert->closeCursor();
            header("LOCATION:products.php");

        }else{
            header("LOCATION:addProduct.php?error=".$err);
        }

    }else{
        header("LOCATION:products.php");
    }

?>