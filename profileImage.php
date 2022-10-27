<?php
    if(!isset($_SESSION['userEmail'])){
        header("location: index.php?error=loginFirst");
    }
    
    $folderPath = 'images/profiles/';

    $image_parts = explode(";base64,", $_POST['cropImage']);
    $image_type_aux = explode("cropImage/", $image_parts[0]);
    $image_type = $image_type_aux[1];
    $image_base64 = base64_decode($image_parts[1]);
    $file = $folderPath . uniqid() . '.png';
    file_put_contents($file, $image_base64);
    echo json_encode([$file]);
?>