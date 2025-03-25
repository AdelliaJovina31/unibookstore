<?php
    session_start();
    $conn = new mysqli('localhost', 'root', '', 'data');
        
    if ($conn->connect_error) {
        die("Koneksi gagal: " . $conn->connect_error);
    } // else {
    //     echo 'Terkoneksi';
    // }
?>