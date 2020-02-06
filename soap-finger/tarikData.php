<?php require_once('parse.php'); ?>
<html>
<head>
<title>Tarik Data</title>
 
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
    include '../helper/connection.php';
?>

<?php
error_reporting(E_ALL ^ E_NOTICE);
$IP = $_GET["ip"];
$Key = $_GET["key"];
if($IP=="") $IP="192.168.1.211";
if($Key=="") $Key="0";
?>

<div class="container-fluid">
	<H3>Download Log Data Finger</H3>

	<form action="tarikData.php">
	IP Address: <input type="Text" name="ip" value="<?php echo $IP; ?>" size=15><BR>
	Comm Key: <input type="Text" name="key" size="5" value="<?php echo $Key; ?>"><BR><BR>

	<input type="Submit" value="Download">
	</form>
	<BR>
</div>




<?php
if($_GET["ip"]!=""){ ?>
	<!-- <table cellspacing="2" cellpadding="2" border="1">
	<tr align="center">
		<td><B>No</B></td>
	    <td><B>UserID</B></td>
	    <td width="200"><B>Tanggal & Jam</B></td>
	    <td><B>Verifikasi</B></td>
	    <td><B>Status</B></td>
	</tr> -->
	<?php
	$Connect = fsockopen($IP, "80", $errno, $errstr, 1);
	if($Connect){
		$soap_request="<GetAttLog><ArgComKey xsi:type=\"xsd:integer\">".$Key."</ArgComKey><Arg><PIN xsi:type=\"xsd:integer\">All</PIN></Arg></GetAttLog>";
		$newLine="\r\n";
		fputs($Connect, "POST /iWsService HTTP/1.0".$newLine);
	    fputs($Connect, "Content-Type: text/xml".$newLine);
	    fputs($Connect, "Content-Length: ".strlen($soap_request).$newLine.$newLine);
	    fputs($Connect, $soap_request.$newLine);
		$buffer="";
		while($Response=fgets($Connect, 1024)){
			$buffer=$buffer.$Response;
		}
	}else echo "Koneksi Gagal";
	
	$buffer=Parse_Data($buffer,"<GetAttLogResponse>","</GetAttLogResponse>");
	$buffer=explode("\r\n",$buffer);
	for($a=1;$a<=count($buffer);$a++){
		$data=Parse_Data($buffer[$a],"<Row>","</Row>");

		$PIN=Parse_Data($data,"<PIN>","</PIN>");
		$DateTime=Parse_Data($data,"<DateTime>","</DateTime>");
		$Verified=Parse_Data($data,"<Verified>","</Verified>");
		$Status=Parse_Data($data,"<Status>","</Status>");

		$cekdulu= "select * from tb_finger where userid='$PIN' and tanggal_jam='$DateTime' ";
		$prosescek= mysqli_query($con, $cekdulu);
			if (mysqli_num_rows($prosescek) == 1) { //proses mengingatkan data sudah ada
			// echo "<script>alert('Data sudah ada');history.go(-1) </script>";
			} else { 
				$sql = "INSERT INTO tb_finger (userid, tanggal_jam, verifikasi, status) values ('$PIN','$DateTime','$Verified','$Status')";
				if (mysqli_query($con, $sql)) { //proses mengingatkan data sudah ada
					ini_set('max_execution_time', 300);
				// echo "<script>alert('Username Sudah Digunakan');history.go(-1) </script>";
				}
			}
	?>
		<!-- <tr align="center">
			<td><?php echo $a; ?></td>
			<td><?php echo $PIN; ?></td>
			<td><?php echo $DateTime; ?></td>
			<td><?php echo $Verified; ?></td>
			<td><?php echo $Status; ?></td>
		</tr> -->
	<?php 
	} 
		echo "<script>alert('Penarikan berhasil'); </script>";
	?>
	<!-- </table> -->
<?php } ?>

</body>
</html>