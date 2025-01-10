<?php 

$mysqli = new mysqli('localhost', 'root', '', 'list_mahasiswa');

$study_programs = $mysqli->query("SELECT * FROM study_programs");

// Jika ada parameter NIM di URL (untuk edit data mahasiswa)
if (isset($_GET['nim'])) {
    $nim = $_GET['nim'];
    // Ambil data mahasiswa berdasarkan NIM
    $result = $mysqli->query("SELECT * FROM students WHERE nim = '$nim'");
    $student = $result->fetch_assoc();
}

// Proses submit form untuk tambah atau update data mahasiswa
if (isset($_POST['nim']) && isset($_POST['nama'])) {
    $nim = $_POST['nim'];
    $nama = $_POST['nama'];
    $study_programs = $_POST['program_studi'];

    if (isset($student)) { // Jika student sudah ada, lakukan update
        $update = $mysqli->query("UPDATE students 
                                  SET nama = '$nama', study_programs_id = $study_programs 
                                  WHERE nim = '$nim'");
        if ($update) {
            header("Location: mahasiswa.php");
            exit();
        }
    } else { // Jika tidak ada student, maka lakukan insert (tambah data)
        $insert = $mysqli->query("INSERT INTO students (nim, nama, study_programs_id) 
                                  VALUES('$nim', '$nama', $study_programs)");
        if ($insert) {
            header("Location: mahasiswa.php");
            exit();
        }
    }
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah/Edit Data Mahasiswa</title>

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
</head>
<body>
    <div class="container">
        <h1 class="text-center"><?= isset($student) ? 'Edit' : 'Tambah' ?> Data Mahasiswa KA 2021</h1>
        <form method="POST">
            <div class="mb-3">
                <label for="nim" class="form-label">NIM</label>
                <input type="text" class="form-control" id="nim" name="nim" 
                       value="<?= isset($student) ? $student['nim'] : '' ?>" <?= isset($student) ? 'readonly' : '' ?>>
            </div>
            <div class="mb-3">
                <label for="nama" class="form-label">Nama Lengkap</label>
                <input type="text" class="form-control" id="nama" name="nama" 
                       value="<?= isset($student) ? $student['nama'] : '' ?>" required>
            </div>
            <div class="mb-3">
                <label for="study_programs" class="form-label">Program Studi</label>
                <select name="program_studi" id="study_programs" class="form-control">
                    <?php while ($row = $study_programs->fetch_assoc()) { ?>
                        <option value="<?= $row['id'] ?>" 
                            <?= (isset($student) && $row['id'] == $student['study_programs_id']) ? 'selected' : ''; ?>>
                            <?= $row['name'] ?>
                        </option>
                    <?php } ?>
                </select>
            </div>
            <button type="submit" class="btn btn-primary"><?= isset($student) ? 'Update' : 'Submit' ?></button>
            <a href="mahasiswa.php" class="btn btn-warning">Kembali</a>
        </form>
    </div>
</body>
</html>
