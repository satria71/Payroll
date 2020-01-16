<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Absensi</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" type="text/css" media="screen" href="main.css">
    <script src="main.js"></script>

    <link rel="stylesheet" type="text/css" href="//cdn.datatables.net/1.10.11/css/jquery.dataTables.min.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
    <!-- Font Awesome JS -->
    <script defer src="https://use.fontawesome.com/releases/v5.0.13/js/solid.js" integrity="sha384-tzzSw1/Vo+0N5UhStP3bvwWPq+uvzCMfrN1fEFe+xBmv1C/AtVX5K0uZtmcHitFZ" crossorigin="anonymous"></script>
    <script defer src="https://use.fontawesome.com/releases/v5.0.13/js/fontawesome.js" integrity="sha384-6OIrr52G08NpOFSZdxxz1xdNSndlD4vdcf/q2myIUVO0VsqaGHJsB0RaBE01VTOY" crossorigin="anonymous"></script>

</head>
<body>
<?php
    include 'pager.php';
?>

<div class="container">
    <h3>Data Absensi</h3>
<hr>

<table class="table table-stripped table-hover datatab" align="center">
    <thead>
        <tr>
            <th>No</th>
            <th>Nama</th>
            <th>Departemen</th>
            <th>Tanggal</th>
            <th>Masuk</th>
            <th>Keluar</th>
            <th>Jumlah Jam</th>
            <th>Action</th>                         
        </tr>
    </thead>  
<tbody>

<?php 
    $sql = "select id, nama, departemen, tanggal, masuk, keluar, jumlah_jam
            from tb_karyawan, tb_departemen, tb_absensi 
            where tb_karyawan.nik = tb_absensi.nik and tb_departemen.kode_departemen = tb_absensi.kode_departemen";
    $query = mysqli_query($con, $sql);
    $no = 1;
    while ($data = mysqli_fetch_assoc($query)){
?>

<tr>
    <td><?php echo $no++; ?></td>
    <td><?php echo $data['nama']; ?></td>
    <td><?php echo $data['departemen']; ?></td>
    <td><?php echo $data['tanggal']; ?></td>
    <td><?php echo $data['masuk']; ?></td>
    <td><?php echo $data['keluar']; ?></td>
    <td><?php echo $data['jumlah_jam']; ?></td>
    <td>
    <!-- Button untuk modal -->
    <i class="fas fa-edit"></i>
    <a href="#" type="button" class="btn btn-success btn-md" data-toggle="modal" data-target="#myModal<?php echo $data['id']; ?>">Edit</a>
    
    <!-- Button untuk modal -->
    <?php
        $nip = $data["id"];
        echo "<a href='proses/deleteAbsensi.php?id=$nip' class='btn btn-danger'>Delete</a>";
    ?>
    </td>
</tr>

<!-- Modal Edit -->
<div class="modal fade" id="myModal<?php echo $data['id']; ?>" role="dialog">
    <div class="modal-dialog">

<!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Update Absensi</h4>
            </div>
        <div class="modal-body">

        <form role="form" action="proses/prosesUpdateKaryawan.php" method="get">

        <?php
        $id = $data['id'];
        $sql2 = "select nik, nama, jabatan, alamat, notelp
                from tb_karyawan, tb_jabatan 
                where tb_karyawan.kode_jabatan = tb_jabatan.kode_jabatan and status = 0 and nik='$id'";
        $query_edit = mysqli_query($con, $sql2);
        //$result = mysqli_query($conn, $query);
        while ($row = mysqli_fetch_array($query_edit)) {  
        ?>

            <div class="form-group">
                <label>NIK</label>
                <input type="text" name="nip" class="form-control" value="<?php echo $row['0']; ?>" readonly="true">     
            </div>

            <div class="form-group">
                <label>Nama</label>
                <input type="text" name="nama" class="form-control" value="<?php echo $row['1']; ?>">      
            </div>

            <div class="form-group">
                <label>Jabatan</label><br>
                <select name="jabatan">
                <?php
                    include "helper/connection.php";
                    $sql="select*from tb_jabatan";
                    $result = mysqli_query($con, $sql);
                    if(mysqli_num_rows($result)!=''){
                        while($tampil=mysqli_fetch_array($result, MYSQLI_NUM)){
                ?>
                    <option value="<?php echo $tampil[0] ?>"><?php echo $tampil[1] ?></option>;
                <?php
                        }
                    }else{
                ?>
                    <option> Tidak ada data </option>
                <?php
                    }
                ?>
                </select><br/>
            </div>

            <div class="form-group">
                <label>Alamat</label>
                <input type="text" name="alamat" class="form-control" value="<?php echo $row['3']; ?>">      
            </div>

            <div class="form-group">
                <label>No Telepon</label>
                <input type="text" name="no_tlp" class="form-control" value="<?php echo $row['4']; ?>">      
            </div>

            <div class="modal-footer">  
                <button type="submit" class="btn btn-success">Update</button>
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>

        <?php 
        }
        //mysql_close($host);
        ?>        
        </form>
            </div>
        </div>

    </div>
</div>
<?php               
    } 
?>
</tbody>
</table>          
</div>

</body>
<script src="http://code.jquery.com/jquery-1.12.0.min.js"></script>
<script src="//cdn.datatables.net/1.10.11/js/jquery.dataTables.min.js"></script>
<script>
$(document).ready(function() {
$('.datatab').DataTable();
} );
</script>
</html>