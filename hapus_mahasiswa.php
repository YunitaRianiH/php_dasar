<?php
  session_start();

    $mysqli = new mysqli('localhost', 'root', '', 'list_mahasiswa');

    $nim = $_GET['nim'];
    $delete = $mysqli->query("DELETE  FROM students WHERE nim='$nim'");

    if($delete) {
        $_SESSION['success'] = true;
        $_SESSION['message'] = 'Data Berhasil Dihapus';
        header("Location: mahasiswa.php");
        exit();
    }
?>