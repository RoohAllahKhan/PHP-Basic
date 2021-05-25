<?php
    $hostname = "localhost";
    $username = "root";
    $password = "coeus123";
    $dbname = "bookDb";

    $conn = new mysqli($hostname, $username, $password, $dbname);

    if($conn->connect_error){
        die("Connection Failed:".$conn->connect_error);
    }
?>