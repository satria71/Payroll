<?php
// Include DB connection file
include '../helper/connection.php';


// Get the form value
if(isset($_POST['submit'])){
    $userid = $_POST["userid"];
    $nama = $_POST["nama"];
    $bagian = $_POST["bagian"];
    $status = $_POST["status"];

    // Insert query comman
    $query = "UPDATE tb_karyawan2 set nama='$nama', kode_bagian='$bagian', status='$status' 
            WHERE userid='$userid'";

    // $result = mysqli_multi_query($con, $query);

    // Do insert query
    if (mysqli_query($con, $query)) {
        ?>
        <script language="javascript">
            alert("Data berhasil diubah");
            document.location="../showKaryawan2.php";
        </script>
        <?php
    } else {
        ?>
        <script language="javascript">
            alert("Data gagal diubah");
            document.location="../showKaryawan2.php";
        </script>
        <?php
    }
}

// close mysql connection
mysqli_close($con); 

?>