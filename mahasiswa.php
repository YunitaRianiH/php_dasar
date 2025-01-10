<?php
 session_start();

$mysqli = new mysqli('localhost', 'root', '', 'list_mahasiswa');

$result = $mysqli->query("SELECT students.nim, students.nama, study_programs.name 
                          FROM students INNER JOIN study_programs ON students.study_programs_id = study_programs.id 
                          WHERE study_programs.id= 11;");

$mahasiswa = [];

while ($row = $result->fetch_assoc()) {
    array_push($mahasiswa, $row);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MAHASISWA</title>

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
</head>
<body>
    <div class="container">
    <h1 align="center"> Data Mahasiswa KA 2021 </h1>
    <?php if (isset($_SESSION['success']) && $_SESSION['success'] == true ) { ?>
       <div class="alert alert-success" role="alert">
            <?= $_SESSION['message'] ?>
       </div>
       <?php } ?>
    <a href="tambah_mahasiswa.php" class="btn btn-primary">Tambah Mahasiswa</a>
    <a href="logout.php" class="btn btn-warning">Logout</a> 
    <div class="mb-10">  
        <br>  
        <table class="table table-bordered table-hover">
            <tr>
                <th>NO</th>
                <th>NIM</th>
                <th>Nama</th>
                <th>Program Studi</th>
                <th>Aksi</th> <!-- Tambahkan kolom untuk tombol edit -->
            </tr>
            <?php 
            $no = 1;
            foreach ($mahasiswa as $row) { ?>
                <tr>
                    <td><?= $no++; ?></td>
                    <td><?= $row['nim']; ?></td>
                    <td><?= $row['nama']; ?></td>
                    <td><?= $row['name']; ?></td>
                    <td>
                        <!-- Tombol Edit -->
                        <a href="edit_mahasiswa.php?nim=<?= $row['nim']; ?>" class="btn btn-warning">Edit</a>
                        <!-- Tombol Hapus -->
                        <a href="hapus_mahasiswa.php?nim=<?= $row['nim']; ?>" class="btn btn-danger" onclick="return confirm('Are you sure you want to delete this student?')">Hapus</a>
                    </td>
                </tr>
            <?php } ?>
        </table>
    </div>
            </div>
</body>
</html>

<?php
session_unset();

?>
