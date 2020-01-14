<?php
// Include DB connection file
include '../helper/connection.php';


// Get the form value
if(isset($_POST['submit'])){
    $kode_bagian = $_POST["kode_bagian"];
    $bagian = $_POST["bagian"];
    $departemen = $_POST["departemen"];

    // Insert query comman
    $query = "UPDATE tb_bagian set kode_bagian='$kode_bagian', bagian='$bagian', kode_departemen='$departemen' WHERE kode_bagian='$kode_bagian'";

    // $result = mysqli_multi_query($con, $query);

    // Do insert query
    if (mysqli_query($con, $query)) {
        ?>
        <script language="javascript">
            alert("Data berhasil diubah");
            document.location="../showBagian.php";
        </script>
        <?php
    } else {
        ?>
        <script language="javascript">
            alert("Data gagal diubah");
            document.location="../showBagian.php";
        </script>
        <?php
    }
}

// close mysql connection
mysqli_close($con); 

?>