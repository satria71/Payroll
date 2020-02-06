<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Absensi</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" type="text/css" media="screen" href="main.css">
    <script src="main.js"></script>

    <link rel="stylesheet" href="css/style.css">
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

<div class="container-fluid">
    <h3>Data Absensi</h3>
<hr>

<a href="soap-finger/tarikData"><button class="btn btn-primary" style="margin-rigth:10px;"><i class="fas fa-download" style="margin-right:10px;"></i>Download Absensi</button></a>      
<button class="btn btn-info"><i class="fas fa-save" style="margin-right:10px;"></i>Simpan data</button>
<button class="btn btn-warning"><i class="fas fa-print" style="margin-right:10px;"></i>Print</button>

<!-- Collapse filter tanggal -->
<a class="btn btn-success" data-toggle="collapse" href="#collapseExample" role="button" aria-expanded="false" aria-controls="collapseExample">
    <i class="fas fa-filter" style="margin-right:10px;"></i>Filter Data
</a><br><br>
<div class="collapse" id="collapseExample">
    <div class="card card-body">
        <form class="form-inline" action="filterAbsensi.php" method="post">
            <p><i>Pilih tanggal untuk menampilkan data</i></p>
            <label for="tgl_awal" class="mb-2 mr-sm-2">Tanggal Awal :</label>
            <input type="date" class="form-control mb-2 mr-sm-2" id="tgl_awal" name="tgl_awal">
            <label for="tgl_akhir" class="mb-2 mr-sm-2">Tanggal Akhir:</label>
            <input type="date" class="form-control mb-2 mr-sm-2" id="tgl_akhir" name="tgl_akhir"> 
            <button type="submit" class="btn btn-primary mb-2" name="submit">Tampilkan</button><br><br>
        </form>
    </div>
</div>

<table class="table table-stripped table-hover datatab" align="center">
    <thead>
        <tr>
            <th>No</th>
            <th>Nama</th>
            <th>Bagian</th>
            <th>Departemen</th>
            <!-- <th>Tanggal & Jam</th> -->
            <th>Tanggal</th>
            <th>Jam</th>
            <th>Status Jam</th>
            <th>Action</th>                         
        </tr>
    </thead>  
<tbody>

<?php 
    $tgl_awal = $_POST["tgl_awal"];
    $tgl_akhir = $_POST["tgl_akhir"];
    $sql = "SELECT tb_finger.userid, nama, bagian, departemen, tanggal_jam, tb_finger.status
    FROM tb_finger, tb_bagian, tb_departemen, tb_karyawan2
    WHERE tb_finger.userid=tb_karyawan2.userid AND tb_bagian.kode_departemen=tb_departemen.kode_departemen 
    AND tb_bagian.kode_bagian=tb_karyawan2.kode_bagian and (tanggal_jam BETWEEN '$tgl_awal' AND '$tgl_akhir') ORDER BY tanggal_jam ASC";
    
    $query = mysqli_query($con, $sql);
    $no = 1;
    while ($data = mysqli_fetch_assoc($query)){
        $time = new DateTime($data['tanggal_jam']);
        $date = $time->format('d-m-Y');
        $times = $time->format('H:i:s');
?>

<tr>
    <td><?php echo $no++; ?></td>
    <td><?php echo $data['nama']; ?></td>
    <td><?php echo $data['bagian']; ?></td>
    <td><?php echo $data['departemen']; ?></td>
    <!-- <td><?php echo $data['tanggal_jam']; ?></td> -->
    <td><?php echo $date; ?></td>
    <td><?php echo $times; ?></td>
    <td>
        <?php
            if($data['status']==1){
                echo "Keluar";
            }else{
                echo "Masuk";
            }
        ?>
    </td>
    <!-- <td><?php echo $data['verifikasi']; ?></td> -->
    <td>
    <!-- Button untuk modal edit -->
    <!-- <a href="#" data-toggle="modal" data-target="#myModal<?php echo $data['userid']; ?>">
        <button class="btn btn-success"><i class="fas fa-edit" style="margin-right:10px;"></i>Edit</button>
    </a> -->
    
    <!-- Button untuk delete -->
    <?php
        $userid = $data["userid"];
        echo "<a href='proses/deleteAbsensi.php?id=$userid' class='btn btn-danger'><i class='fas fa-trash-alt' style='margin-right:10px;'></i>Delete</a>";
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

        <form role="form" action="proses/prosesUpdateAbsensi.php" method="post">

        <?php
        $id = $data['id'];
        $sql2 = "select id, nama, departemen, tanggal, masuk, keluar, jumlah_jam
            from tb_karyawan, tb_departemen, tb_absensi 
            where tb_karyawan.nik = tb_absensi.nik and tb_departemen.kode_departemen = tb_absensi.kode_departemen and id = '$id'";
        $query_edit = mysqli_query($con, $sql2);
        //$result = mysqli_query($conn, $query);
        while ($row = mysqli_fetch_array($query_edit)) {  
        ?>

            <div class="form-group">
                <label>Id</label>
                <input type="text" name="nip" class="form-control" value="<?php echo $row['0']; ?>" readonly="true">     
            </div>

            <div class="form-group">
                <label>Nama</label><br>
                <select name="nama" readonly="true">
                <?php
                    include "helper/connection.php";
                    $sql="select*from tb_karyawan";
                    $result = mysqli_query($con, $sql);
                    if(mysqli_num_rows($result)!=''){
                        while($tampil=mysqli_fetch_array($result, MYSQLI_NUM)){
                ?>
                    <option value="<?php echo $tampil['0'] ?>"><?php echo $tampil['1'] ?></option>;
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
                <label>Departemen</label><br>
                <select name="departemen" readonly="true">
                <?php
                    include "helper/connection.php";
                    $sql="select*from tb_departemen";
                    $result = mysqli_query($con, $sql);
                    if(mysqli_num_rows($result)!=''){
                        while($tampil=mysqli_fetch_array($result, MYSQLI_NUM)){
                ?>
                    <option value="<?php echo $tampil['0'] ?>"><?php echo $tampil['1'] ?></option>;
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
                <label>Tanggal</label>
                <input type="text" name="alamat" class="form-control" value="<?php echo $row['3']; ?>">      
            </div>

            <div class="form-group">
                <label>Masuk</label>
                <input type="text" name="no_tlp" class="form-control" value="<?php echo $row['4']; ?>">      
            </div>

            <div class="form-group">
                <label>Keluar</label>
                <input type="text" name="no_tlp" class="form-control" value="<?php echo $row['5']; ?>">      
            </div>

            <div class="form-group">
                <label>Jumlah Jam</label>
                <input type="text" name="no_tlp" class="form-control" value="<?php echo $row['6']; ?>">      
            </div>

            <div class="modal-footer">  
                <button type="submit" class="btn btn-success">Edit</button>
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