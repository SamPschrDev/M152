<?php
// Création de l'object PDO (Singleton)
// Utilisation du même connecteur pour chaque requêtes
function ConnectDB(){
    static $db = null;

    if($db == null){
        try{
            $db = new PDO('mysql:host=localhost;dbname=M152;port=3306','root','');
            $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        }
        catch(PDOException $e) {
            die('Échec lors de la connexion : ' . $e->getMessage());
        }        
    }
    return $db;
}

function ImportImg(){
    header("Location: index.php");
}

function Post(){
    header("Location: index.php");
}

if(filter_has_var(INPUT_POST, "btnPost")){
    Post();
}

if(filter_has_var(INPUT_POST, "btnImportImg")){
    ImportImg();
}