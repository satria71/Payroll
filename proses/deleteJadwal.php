<?php

include '../helper/connection.php';

$id = $_GET["id"];

$query = "DELETE FROM tb_jadwal WHERE kode_jadwal = '$id'";

if (mysqli_query($con, $query)) {
    header("Location:../showJadwal.php");
} else {
    $error = urldecode("<div class='alert alert-danger' role='alert'>Data tidak berhasil di delete</div>");
    header("Location:../showJadwal.php?error=$error");
}

mysqli_close($con); 

?>