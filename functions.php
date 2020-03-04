<?php
if(session_status() == PHP_SESSION_NONE){
    session_start();
}

$uploadFolder = 'uploadedFiles';

// Création de l'object PDO (Singleton)
// Utilisation du même connecteur pour chaque requêtes
function ConnectDB(){
    static $db = null;

    if($db == null){
        try{
            $db = new PDO('mysql:host=localhost;dbname=M152Facebook;port=3306','root','Super');
            $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        }
        catch(PDOException $e) {
            die('Échec lors de la connexion : ' . $e->getMessage());
        }
    }
    return $db;
}

// Insert les données du post dans la base de données
function addPost($commentaire, $mediaType, $mediaName){
    $db = ConnectDB();

    // Table post
    try{
        // permet d'annuler les requêtes executé en cas d'erreur (empêche les données orphelin)
        $db->beginTransaction();
        $sql = "INSERT INTO post (`commentaire`, `creationDate`, `modificationDate`) VALUES(:commentaire, :dateCrea, :dateModif)";
        $req = $db->prepare($sql, array(PDO::ATTR_CURSOR, PDO::CURSOR_SCROLL));
        $req->execute(
        array(
            'commentaire' => $commentaire,
            'dateCrea' => date("Y-m-d H:i:s"),
            'dateModif' => date("Y-m-d H:i:s")
            )
        );
        $id = $db->lastInsertId();
        $_SESSION["lastInsertId"] = $id;

        // Table media
        $sql = "INSERT INTO media (`typeMedia`, `nomMedia`, `creationDate`, `modificationDate`, `post_idPost`) VALUES(:typeMedia, :nomMedia, :dateCrea, :dateModif, :post)";
        for ($i=0; $i < count($mediaName); $i++) {
            $req = $db->prepare($sql, array(PDO::ATTR_CURSOR, PDO::CURSOR_SCROLL));
            $req->execute(
                array(
                'typeMedia' => $mediaType[$i],
                'nomMedia' => $mediaName[$i],
                'dateCrea' => date("Y-m-d H:i:s"),
                'dateModif' => date("Y-m-d H:i:s"),
                'post' => $id
                )
            );   
        }
        // Confirme l'exécution des requêtes
        $db->commit(); 
    }
    catch (Exception $e){
        // Annule toute les requête situé entre "beginTransaction" et "commit"
        $db->rollback();
    }
    
        
}

function GetIdPost(){
    $db = ConnectDB();
    $sql = $db->prepare("SELECT idPost FROM post");
    $sql->execute();
    $result = $sql->fetchAll(PDO::FETCH_ASSOC);
    return $result;
}

function GetPost(){
    $db = ConnectDB();   
    $sql = $db->prepare("SELECT idPost, nomMedia, commentaire FROM media JOIN post ON media.post_idPost = post.idPost");
    $sql->execute();
    $result = $sql->fetchAll(PDO::FETCH_ASSOC);
    return $result;
}

function PostForm(){
    $post = GetPost();   
    $div = "<div class=\"col-sm-8\"><div class=\"well\"><div class=\"input-group text-center\" name=\"divImg\">";
    $currentPostId = 0;
    foreach ($post as $key => $value) {
      if($currentPostId != $value["idPost"]){
            $div .= "<h4>".$value["commentaire"]."</h4>"; 
            $currentPostId = $value["idPost"];                
        }
        $div .= "<img src=\"uploadedFiles/".$value["nomMedia"]."\" name=\"imgPost\">";                                   
    }
    $div .="</div></div></div>";
    
    return $div;
}

// Appelle la méthode qui envoie le post dans la base de données
if(filter_has_var(INPUT_POST, "btnPost")){
    $commentaire = filter_input(INPUT_POST, "txtaCommentaire", FILTER_SANITIZE_STRING);
    $typeMedia = $_FILES['userFiles']['type'];
    $nomMedia = $_FILES['userFiles']['name'];
    addPost($commentaire, $typeMedia, $nomMedia);
    
    // Déplace le ou les fichiers dans un dossier
    foreach ($_FILES["userFiles"]["error"] as $key => $error) {
        if ($error == UPLOAD_ERR_OK) {
            $tmp_name = $_FILES["userFiles"]["tmp_name"][$key];
            $name = basename($_FILES["userFiles"]["name"][$key]);
            move_uploaded_file($tmp_name, "$uploadFolder/$name");
        }
    }
    header("Location: index.php");
}