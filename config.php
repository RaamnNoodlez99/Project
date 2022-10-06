<?php
    $logged_in = 0;
    // $serverName = 'localhost';
    // $username = 'u20422475';
    // $pass = 'jrvnghln';
    // $dbName = 'u20422475';

    $serverName = 'localhost';
    $username = 'root';
    $pass = '';
    $dbName = 'u20422475';

    global $conn;
    $conn = mysqli_connect($serverName, $username, $pass, $dbName);

    if(!$conn){
        die("Connection failed: " . mysqli_connect_error());
    }else{
        //working
    }
?>