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
    $query = "INSERT INTO tb_karyawan2 (userid, nama, kode_bagian, status) 
    VALUES ('$userid', '$nama', '$bagian', '$status')";

    // $result = mysqli_multi_query($con, $query);

    // Do insert query
    if (mysqli_query($con, $query)) {
        ?>
        <script language="javascript">
            alert("Data berhasil dimasukkan");
            document.location="../showKaryawan2.php";
        </script>
        <?php
    } else {
        ?>
        <script language="javascript">
            alert("Data gagal dimasukkan");
            document.location="../showKaryawan2.php";
        </script>
        <?php
    }
}

// close mysql connection
mysqli_close($con); 

?>