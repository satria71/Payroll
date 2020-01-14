<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Departemen dan Bagian</title>
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
    include 'helper/connection.php';
?>

<div class="container">
    <h3>Departemen dan Bagian</h3>
<hr>
<a href="#" type="button" class="btn btn-primary btn-md" style="margin-bottom:10px;" data-toggle="modal" data-target="#myModalInput">Tambah</a>

<table class="table table-stripped table-hover datatab" align="center">
    <thead>
        <tr>
            <th>No</th>
            <th>Bagian</th>
            <th>Departemen</th>
            <th>Action</th>                         
        </tr>
    </thead>  
<tbody>

<?php 
    $sql = "select kode_bagian, bagian, departemen
            from tb_bagian, tb_departemen 
            where tb_departemen.kode_departemen = tb_bagian.kode_departemen ORDER BY departemen";
    $query = mysqli_query($con, $sql);
    $no = 1;
    while ($data = mysqli_fetch_assoc($query)){
?>

<tr>
    <td><?php echo $no++; ?></td>
    <td><?php echo $data['bagian']; ?></td>
    <td><?php echo $data['departemen']; ?></td>
    <td>
    <!-- Button untuk modal -->
    <i class="fas fa-edit"></i>
    <a href="#" type="button" class="btn btn-success btn-md" data-toggle="modal" data-target="#myModal<?php echo $data['kode_bagian']; ?>">Edit</a>
    
    <!-- Button untuk modal -->
    <?php
       $id = $data["kode_bagian"];
       echo "<a href='proses/deleteBagian.php?id=$id' class='btn btn-danger'>Delete</a>";
    ?>
    </td>
</tr>

<!-- Modal Edit -->
<div class="modal fade" id="myModal<?php echo $data['kode_bagian']; ?>" role="dialog">
    <div class="modal-dialog">

<!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Update Data Bagian</h4>
            </div>
        <div class="modal-body">

        <form role="form" action="proses/prosesUpdateBagian.php" method="post">

        <?php
        $id = $data['kode_bagian'];
        $sql2 = "select kode_bagian, bagian, departemen
        from tb_bagian, tb_departemen 
        where tb_departemen.kode_departemen = tb_bagian.kode_departemen and kode_bagian='$id'";
        $query_edit = mysqli_query($con, $sql2);
        //$result = mysqli_query($conn, $query);
        while ($row = mysqli_fetch_array($query_edit)) {  
        ?>

            <div class="form-group">
                <label>Kode Bagian</label>
                <input type="text" name="kode_bagian" class="form-control" value="<?php echo $row['0']; ?>" readonly="true">     
            </div>

            <div class="form-group">
                <label>Bagian</label>
                <input type="text" name="bagian" class="form-control" value="<?php echo $row['1']; ?>">     
            </div>

            <div class="form-group">
                <label>Departemen</label><br>
                <select name="departemen">
                <?php
                    include "helper/connection.php";
                    $sql="select*from tb_departemen";
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
                <h4 class="modal-title">Input Data Departemen</h4>
            </div>
        <div class="modal-body">

        <form role="form" action="proses/prosesInsertDepartemen.php" method="post">
            <div class="form-group">
                <label>Kode Bagian</label>
                <input type="text" name="kode_bagian" class="form-control" placeholder="Kode Bagian">     
            </div>

            <div class="form-group">
                <label>Bagian</label>
                <input type="text" name="bagian" class="form-control" placeholder="Bagian">     
            </div>

            <div class="form-group">
                <label>Departemen</label><br>
                <select name="departemen">
                <?php
                    include "helper/connection.php";
                    $sql="select*from tb_departemen";
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