<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Semua Karyawan</title>
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

<div class="container-fluid">
    <h3>Data Karyawan</h3>
<hr>
<button class="btn btn-primary btn-md" data-toggle="modal" data-target="#myModalInput"><i class="fas fa-plus" style="margin-right:10px;"></i>Tambah</button><br><br>


<table class="table table-stripped table-hover datatab" align="center">
    <thead>
        <tr>
            <th>No</th>
            <th>User Id</th>
            <th>Nama</th>
            <th>Bagian</th>
            <th>Departemen</th>
            <th>Status Kerja</th>
            <th>Action</th>                         
        </tr>
    </thead>  
<tbody>

<?php 
    $sql = "select userid, nama, bagian, departemen, status
            from tb_karyawan2, tb_bagian, tb_departemen
            where tb_karyawan2.kode_bagian = tb_bagian.kode_bagian and tb_departemen.kode_departemen = tb_bagian.kode_departemen
            and tb_karyawan2.flag = 1 ORDER BY userid ASC";
    $query = mysqli_query($con, $sql);
    $no = 1;
    while ($data = mysqli_fetch_assoc($query)){
?>

<tr>
    <td><?php echo $no++; ?></td>
    <td><?php echo $data['userid']; ?></td>
    <td><?php echo $data['nama']; ?></td>
    <td><?php echo $data['bagian']; ?></td>
    <td><?php echo $data['departemen']; ?></td>
    <td><?php echo $data['status']; ?></td>
    <td>
    <!-- Button untuk modal edit -->
    <a href="#" data-toggle="modal" data-target="#myModal<?php echo $data['userid']; ?>">
        <button class="btn btn-success"><i class="fas fa-edit" style="margin-right:10px;"></i>Edit</button>
    </a>
    <!-- Button untuk delete -->
    <?php
        $userid = $data["userid"];
        echo "<a href='proses/deleteKaryawanHL.php?id=$userid' class='btn btn-danger'><i class='fas fa-trash-alt' style='margin-right:10px;'></i>Delete</a>";
    ?>
    <!-- Button untuk modal info -->
    <a href="#" data-toggle="modal" data-target="#myModalInfo<?php echo $data['userid']; ?>">
        <button class="btn btn-info"><i class="fas fa-info-circle" style="margin-right:10px;"></i>info</button>
    </a>
    </td>
</tr>

<!-- Modal Edit -->
<div class="modal fade" id="myModal<?php echo $data['userid']; ?>" role="dialog">
    <div class="modal-dialog">

<!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Update Data Karyawan</h4>
            </div>
        <div class="modal-body">

        <form role="form" action="proses/prosesUpdateKaryawanHL.php" method="post">

        <?php
        $id = $data['userid'];
        $sql2 = "select userid, nama, bagian, departemen, status
        from tb_karyawan2, tb_bagian, tb_departemen
        where tb_karyawan2.kode_bagian = tb_bagian.kode_bagian and tb_departemen.kode_departemen = tb_bagian.kode_departemen 
        and userid='$id'";
        $query_edit = mysqli_query($con, $sql2);
        //$result = mysqli_query($conn, $query);
        while ($row = mysqli_fetch_array($query_edit)) {  
        ?>

            <div class="form-group">
                <label>User Id</label>
                <input type="text" name="userid" class="form-control" value="<?php echo $row['userid']; ?>" readonly="true">     
            </div>

            <div class="form-group">
                <label>Nama</label>
                <input type="text" name="nama" class="form-control" value="<?php echo $row['nama']; ?>">      
            </div>

            <div class="form-group">
                <label>Bagian</label><br>
                <select name="bagian">
                <?php
                    include "helper/connection.php";
                    $sql="select*from tb_bagian";
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
                <label>Status Kerja</label>
                <input type="text" name="status" class="form-control" value="<?php echo $row['status']; ?>">      
            </div>

            <div class="modal-footer">  
                <button type="submit" class="btn btn-success" name="submit">Edit</button>
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


<!-- Modal Info -->
<div class="modal fade" id="myModalInfo<?php echo $data['nik']; ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLongTitle">Info Karyawan</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        ...
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-primary">Ok</button>
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


<!-- Modal Input -->
<div class="modal fade" id="myModalInput" role="dialog">
    <div class="modal-dialog">

<!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Input Data Karyawan</h4>
            </div>
        <div class="modal-body">

        <form role="form" action="proses/prosesInsertKaryawan.php" method="post">
            <div class="form-group">
                <label>User Id</label>
                <input type="text" name="userid" class="form-control" placeholder="User Id">     
            </div>

            <div class="form-group">
                <label>Nama</label>
                <input type="text" name="nama" class="form-control" placeholder="Nama">     
            </div>

            <div class="form-group">
                <label>Bagian</label><br>
                <select name="bagian">
                <?php
                    include "helper/connection.php";
                    $sql="select*from tb_bagian";
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
                <label>Status Kerja</label>
                <input type="text" name="status" class="form-control" placeholder="Status">     
            </div>

            <div class="modal-footer">  
                <button type="submit" name="submit" class="btn btn-success">Tambah</button>
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>       
        </form>
            </div>
        </div>

    </div>
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