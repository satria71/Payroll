<?php
// Include DB connection file
include '../helper/connection.php';


// Get the form value
if(isset($_POST['submit'])){
    $kode_bagian = $_POST["kode_bagian"];
    $bagian = $_POST["bagian"];
    $departemen = $_POST["departemen"];

    // Insert query comman
    $query = "INSERT INTO tb_bagian (kode_bagian, bagian, kode_departemen) VALUES ('$kode_bagian', '$bagian', '$departemen')";

    // $result = mysqli_multi_query($con, $query);

    // Do insert query
    if (mysqli_query($con, $query)) {
        ?>
        <script language="javascript">
            alert("Data berhasil dimasukkan");
            document.location="../showBagian.php";
        </script>
        <?php
    } else {
        ?>
        <script language="javascript">
            alert("Data gagal dimasukkan");
            document.location="../showBagian.php";
        </script>
        <?php
    }
}

// close mysql connection
mysqli_close($con); 

?>