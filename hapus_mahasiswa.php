<?php
  
    $mysqli = new mysqli('localhost', 'root', '', 'list_mahasiswa');

    $nim = $_GET['nim'];
    $delete = $mysqli->query("DELETE  FROM students WHERE nim='$nim'");

    if($delete) {
        header("Location: mahasiswa.php");
        exit();
    }
?>