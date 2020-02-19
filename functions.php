<?php
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

function ImportImg(){

}

// TESTER
/*function addPost($titre, $description, $typeMedia, $nomFichier){
    $sql = "INSERT INTO Post(titrePost, descriptionPost, dateCreationPost, dateModificationPost) VALUES(:titre, :descr, :dateCrea, :dateModif)";
    $req = Db()->prepare($sql, array(PDO::ATTR_CURSOR, PDO::CURSOR_SCROLL));
    $req->execute(
      array(
         'titrePost' => $titre,
         'descriptionArticle' => $description,
         'dateCrea' => date("Y-m-d H:i:s"),
         'dateModif' => date("Y-m-d H:i:s")
         )
     );
    $id = Db()->lastInsertId();


    $sql = "INSERT INTO Media(typeMedia, nomFichierMedia, dateCreationMedia, dateModificationMedia, idPost) VALUES(:typeMedia, :nomFichier, :dateCrea, :dateModif, :post)";
    $req = Db()->prepare($sql, array(PDO::ATTR_CURSOR, PDO::CURSOR_SCROLL));
    $req->execute(
      array(
         'typeMedia' => $typeMedia,
         'nomFichier' => $nomFichier,
         'dateCrea' => date("Y-m-d H:i:s"),
         'dateModif' => date("Y-m-d H:i:s"),
         'post' => $id
         )
     );   
}*/


// PAS BON
function Post($mediaType, $mediaName, $createDate, $editMedia){
    $db = ConnectDB();
    $sql = $db->prepare("INSERT INTO post (`commentaire`, `creationDate`, `modificationDate`) VALUES (:idPost, :commentaire, :creationDate, :modificationDate)");
    $sql->execute(array(
        ':commentaire' => $mediaName,
        ':creationDate' => $createDate,
        ':modificationDate' => $editMedia,
    ));

    /*$sql = $db->prepare("INSERT INTO media (`typeMedia`, `nomMedia`, `creationDate`, `idPost`) VALUES (:typeMedia, :nomMedia, :creationDate)");
    $sql->execute(array(
        ':typeMedia' => $mediaType,
        ':nomMedia' => $mediaName,
        ':creationDate' => $createDate,
        ':creationDate' => $idPost,
    ));*/
}

if(filter_has_var(INPUT_POST, "btnPost")){
    $commentaire = filter_input(INPUT_POST, "txtaCommentaire", FILTER_SANITIZE_STRING);
    $date = new DateTime();
    echo $date->format('d-m-Y');
    Post($commentaire, $date, $date);
    header("Location: index.php");
}

if(filter_has_var(INPUT_POST, "btnImportImg")){
    ImportImg();
}