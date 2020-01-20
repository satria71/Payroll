<?php
// Include DB connection file
include '../helper/connection.php';


// Get the form value
if(isset($_POST['submit'])){
    $kode_jadwal = $_POST["kode_jadwal"];
    $departemen = $_POST["departemen"];
    $masuk = $_POST["masuk"];
    $keluar = $_POST["keluar"];

    // Insert query comman
    $query = "INSERT INTO tb_jadwal (kode_jadwal, kode_departemen, masuk, keluar) 
    VALUES ('$kode_jadwal', '$departemen', '$masuk', '$keluar')";

    // $result = mysqli_multi_query($con, $query);

    // Do insert query
    if (mysqli_query($con, $query)) {
        ?>
        <script language="javascript">
            alert("Data berhasil dimasukkan");
            document.location="../showJadwal.php";
        </script>
        <?php
    } else {
        ?>
        <script language="javascript">
            alert("Data gagal dimasukkan");
            document.location="../showJadwal.php";
        </script>
        <?php
    }
}

// close mysql connection
mysqli_close($con); 

?>