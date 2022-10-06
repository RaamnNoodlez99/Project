<?php
    session_start();

    $feedTypeText = '';

    $feedTypeText = $_POST["feedTypeText"];

    $_SESSION["feedType"] = $feedTypeText;

    echo json_encode(array('success'=>'true'));
?>