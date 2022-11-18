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
            $update = $bdd->prepare("UPDATE products SET title=:titre, date=:date, description=:description WHERE id=:myid");
            $update->execute([
                ":titre" => $title, 
                ":date" => $date, 
                ":description" => $description, 
                ":myid" => $id
            ]);
            $update->closeCursor();
            header("LOCATION:products.php");

        }else{
            header("LOCATION:updateProduct.php?id=".$id."&error=".$err);
        }

    }else{
        header("LOCATION:products.php");
    }

?>