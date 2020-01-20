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
    $query = "UPDATE tb_jadwal set kode_departemen='$departemen', masuk='$masuk', keluar='$keluar' WHERE kode_jadwal='$kode_jadwal'";

    // $result = mysqli_multi_query($con, $query);

    // Do insert query
    if (mysqli_query($con, $query)) {
        ?>
        <script language="javascript">
            alert("Data berhasil diubah");
            document.location="../showJadwal.php";
        </script>
        <?php
    } else {
        ?>
        <script language="javascript">
            alert("Data gagal diubah");
            document.location="../showJadwal.php";
        </script>
        <?php
    }
}

// close mysql connection
mysqli_close($con); 

?>