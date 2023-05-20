<?php
    $servername = "localhost";
    $username = "motolife_surat1";
    $password = "motolife_surat1";
    $dbname = "motolife_surat1";
    $charset="utf8mb4";

    try {
        $db = new PDO("mysql:host=$servername;dbname=$dbname;charset=$charset", $username, $password);
        // set the PDO error mode to exception
        $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    } catch(PDOException $e) {
        echo "Connection failed: " . $e->getMessage();
    }
?>