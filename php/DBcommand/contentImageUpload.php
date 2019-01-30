<?php
require_once $_SERVER["DOCUMENT_ROOT"] . '/php/connectDB.php';
$imagePath = $_SERVER["DOCUMENT_ROOT"] .'/images';
if(isset($_FILES['file']['tmp_name'])){
    if(!$_FILES['file']['error']){
        $filename = $_FILES['file']['name'];
        $savePath = "$imagePath/$filename";
    
        //폴더 체크 후 생성
        if (!is_dir($imagePath)) {
            mkdir($imagePath);
        }
    
        move_uploaded_file($_FILES['file']['tmp_name'], $savePath);
    
        echo '/images/'.$filename;
    } else {
        echo 'error';
    }
    
} else {
    echo "not have tmp_name!!";
}