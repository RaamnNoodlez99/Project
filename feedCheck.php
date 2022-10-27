<?php
    session_start();

    if(!isset($_SESSION['userEmail'])){
        header("location: index.php?error=loginFirst");
    }

    $feedTypeText = '';

    $feedTypeText = $_POST["feedTypeText"];

    $_SESSION["feedType"] = $feedTypeText;

    echo json_encode(array('success'=>'true'));
?>