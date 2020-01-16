<?php
    include('helper/connection.php');
    session_start();
    // @$nama = $_SESSION['nama'];
    if(!isset($_SESSION['username']))
	{
?>
<script language="javascript">
	alert("Anda Belum Login");
	document.location="index.php";
</script>
<?php
exit;
}
?>