<?php 

abstract class Tool{    

    public static function uploadImg(int $id){

        $infoIMG = '';

        if(!empty($_FILES['avatar']['name'])){
            $ext  = pathinfo($_FILES['avatar']['name'], PATHINFO_EXTENSION);
            if(in_array(strtolower($ext),EXTALLOWED)){
                $imgSize = getimagesize($_FILES['avatar']['tmp_name']);
                if($imgSize[2] >= 1 && $imgSize[2] <= 14){
                    if(filesize($_FILES['avatar']['tmp_name']) <= MAX_SIZE){
                        if(isset($_FILES['avatar']['error']) AND UPLOAD_ERR_OK === $_FILES['avatar']['error']){
                            $nomImage = $id.'.'. $ext;
                            if(move_uploaded_file($_FILES['avatar']['tmp_name'], TARGET.$nomImage)){
                                $infoIMG = 'Upload réussi !';
                            }
                            else{
                                $infoIMG = 'Problème lors de l\'upload !';
                            }
                        }
                        else{
                            $infoIMG = 'Une erreur interne a empêché l\'uplaod de l\'image. Code :'.$_FILES['avatar']['error'];
                        }
                    }
                    else{
                        $infoIMG = 'Image trop volumineuse';
                    }
                }
                else{
                    $infoIMG = 'Le fichier à uploader n\'est pas une image !';
                }
            }
            else{
                $infoIMG = 'Format d\'image incorrect';
            }
        }
        else{
            // si la recette est crée sans images
            // et si il n'existe pas déjà un fichier correspondant à cette id
            // copie de l'image placeholder en tant qu'avatar
            if(!file_exists('images/'.$id.'.jpg')){
                if(copy('images/placeholder.jpg', 'images/'.$id.'.jpg'))
                $infoIMG = "Une image placeholder a été mise en place.";
            }
        }
        return $infoIMG; 
    }

    //getRand permet de s'assurer d'obtenir deux rand différent lors d'un double jet de dé
    public static function getRand($arr,$index = -1){
        $random = rand(0, count($arr)-1);
        if($random != $index){
            $index = $random;
            return $index;
        }
        else{
            self::getRand($arr, $index);
        }
    }
}
?>