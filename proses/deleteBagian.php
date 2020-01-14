<?php

include '../helper/connection.php';

$id = $_GET["id"];

$query = "DELETE FROM tb_bagian WHERE kode_bagian = '$id'";

if (mysqli_query($con, $query)) {
    header("Location:../showBagian.php");
} else {
    $error = urldecode("<div class='alert alert-danger' role='alert'>Data tidak berhasil di delete</div>");
    header("Location:../showBagian.php?error=$error");
}

mysqli_close($con); 

?>