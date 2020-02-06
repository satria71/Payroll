<?php

include '../helper/connection.php';

$id = $_GET["id"];

$query = "UPDATE tb_karyawan2 set flag = 0 WHERE userid = '$id'";

if (mysqli_query($con, $query)) {
    header("Location:../showKaryawan2.php");
} else {
    $error = urldecode("<div class='alert alert-danger' role='alert'>Data tidak berhasil di delete</div>");
    header("Location:../showKaryawan2.php?error=$error");
}

mysqli_close($con); 

?>