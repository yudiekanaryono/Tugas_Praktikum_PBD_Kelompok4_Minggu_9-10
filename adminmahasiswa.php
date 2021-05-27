<?php 
require("koneksi.php");

$hub = open_connection();
$a = @$_GET["a"];
$id = @$_GET["id"];
$sql = @$_POST["sql"];
switch ($sql) {
	case "create":
		create_mahasiswa();
		break;
	case "update":
		update_mahasiswa();
		break;
	case "delete":
		delete_mahasiswa();
		break;
}
switch ($a) {
	case "list":
		read_data();
		break;
	case "input":
		input_data();
		break;
	case "edit":
		edit_data($id);
		break;
	case "hapus":
		hapus_data($id);
		break;
	default:
		read_data();
		break;
}
mysqli_close($hub);
?>







<!doctype html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">

    <title>Welcome !</title>
	<script type ="text/javascript" language="JavaScript">
	function konfirmasi()
	{
		tanya = confirm("Apakah Anda Yakin Ingin Menghapus");
		if (tanya==true) return true;
		else return false;
	}</script>
  </head>
  <body background="pipes.png">
  <?php
function read_data() {
	global $hub;
	$query = "select * from mahasiswa";
	$result = mysqli_query($hub, $query); ?>

	<div style="max-width: 600px; margin: 9em auto">

	<h2 class="text-center">Data Mahasiswa
	 <a class="nav-link" href="homeclient.php">HOME<span class="sr-only">(current)</span></a></h2>
	<hr>
<table class="table table-bordered table-striped">
<tr>
			<td colspan="5"><button type="button" class="btn btn-outline-success"> <a href="adminmahasiswa.php?a=input">INPUT</a></button></td>
		</tr>
        <tr>
			<td>Id Mahasiswa</td>
			<td>NPM</td>
			<td>Nama</td>
			<td>Id Prodi</td>
		</tr>
		<?php while($row = mysqli_fetch_array($result)) { ?>
		<tr>
			<td><?php echo $row['idmhs']; ?></td>
			<td><?php echo $row['npm']; ?></td>
			<td><?php echo $row['nama']; ?></td>
			<td><?php echo $row['idprodi']; ?></td>
<td>
		<button type="button" class="btn btn-outline-success"> <a href="adminmahasiswa.php?a=edit&id=<?php echo $row ['idmhs']; ?>">EDIT</a></button>
        <button type="button" class="btn btn-outline-warning"><a href="adminmahasiswa.php?a=hapus&id=<?php echo $row ['idmhs']; ?>">HAPUS</a></button>	
			</td>
		</tr>
		<?php } ?>
	</table>
</div>
<?php } ?>

<?php 
function input_data(){
	$row = array(
			"npm" => "",
			"nama" => "",
			"idprodi" => ""
			); ?>

	<h2>Input Data Mahasiswa</h2>
	<table class="table table-bordered table-striped">
	<form action="adminmahasiswa.php?a=input" method="post"> 
		<input type="hidden" name="sql" value="create"> 
        <tr>
		<td>NPM</td>
		<td><input type="text" name="npm" maxlength="50" size="50" value="<?php echo trim($row["npm"]) ?>" /></td>
		</tr>
        <tr>
		<td>Nama</td>
		<td><input type="text" name="nama" maxlength="50" size="50" value="<?php echo trim($row["nama"]) ?>" /></td>
		</tr>
        <tr>
		<td>Id Prodi</td>
		<td><input type="text" name="idprodi" maxlength="50" size="50" value="<?php echo trim($row["idprodi"]) ?>" /></td>
		</tr>
	
	<tr>
	<td colspan="2" align ="right"> <button type="submit" name = "action" class="btn btn-outline-success" value "Simpan">Simpan</button>
        <button type="button" class="btn btn-outline-warning"><a href="adminmahasiswa.php?a=list"</a>Batal</button></td>
		</tr>
	</form>
	</table>
<?php } ?>

<?php
function edit_data($id ){
	global $hub;
	$query = "select*from mahasiswa where idmhs = $id"; 
	$result = mysqli_query($hub, $query);
	$row = mysqli_fetch_array($result); ?>

<h2>Edit Data Mahasiswa</h2>
<table class="table table-bordered table-striped">
	<form action="adminmahasiswa.php?a=list" method="post">
		<input type="hidden" name="sql" value="update">
		<input type="hidden" name="idmhs" value="<?php echo trim ($id) ?>">
		<tr>
		<td>NPM</td>
		<td><input type="text" name="npm" maxlength="50" size="50" value="<?php echo trim($row["npm"]) ?>" /></td>
		</tr>
        <tr>
		<td>Nama</td>
		<td><input type="text" name="nama" maxlength="50" size="50" value="<?php echo trim($row["nama"]) ?>" /></td>
		</tr>
        <tr>
		<td>Id Prodi</td>
		<td><input type="text" name="idprodi" maxlength="50" size="50" value="<?php echo trim($row["idprodi"]) ?>" /></td>
		</tr>
		<tr>
		<td colspan="2" align ="right"> <button type="submit" name="action" class="btn btn-outline-success" value "Simpan">Simpan</button><button type="button" class="btn btn-outline-warning"><a href="adminmahasiswa.php?a=list"</a>Batal</button>
		</tr>
	</form>
	</table>
<?php }  ?>
<?php
function hapus_data($id) {
	global $hub;
	$query = "select * from mahasiswa where idmhs= $id";
	$result = mysqli_query($hub, $query);
	$row = mysqli_fetch_array($result);?>
<h2> Hapus Data Mahasiswa</h2>
<form action="adminmahasiswa.php?a=list"    method="post">
	<input type="hidden" name="sql" value="delete">
	<input type="hidden" name="idmhs" value="<?php echo trim($id)?>">
	<table class="table table-bordered table-striped">
    <tr>
			<td>Id Mahasiswa</td>
			<td><?php echo trim($row["idmhs"])?></td>
		</tr>
        <tr>
			<td>Nama</td>
			<td><?php echo trim($row["nama"])?></td>
		</tr>
		<tr>
		<td colspan="2" align ="right"> <button type="submit" onclick="return konfirmasi()" name="action"  class="btn btn-outline-success" value="Hapus">Hapus</button><button type="button" class="btn btn-outline-warning"><a href="adminmahasiswa.php?a=list"</a>Batal</button>
		</tr>
	</table>
	</form>
	<?php } ?>
<?php 
function create_mahasiswa() {
	global $hub;
	global $_POST;
	$query = "insert into mahasiswa (npm, nama, idprodi) 
	value";
	$query .= "('".$_POST["npm"]."', '".$_POST["nama"]."', '".$_POST["idprodi"]."')";
	mysqli_query($hub, $query) or die(mysql_error());
}

function update_mahasiswa() {
	global $hub;
	global $_POST;
	$query = "UPDATE mahasiswa";
	$query .= " SET npm='".$_POST["npm"]."', nama='". $_POST["nama"]."',idprodi='".$_POST["idprodi"]."'";
	$query .= " WHERE idmhs = ".$_POST["idmhs"];
	mysqli_query($hub, $query) or die(mysql_error());
}

function delete_mahasiswa() {    
	global $hub;
	global $_POST;
	$query = "DELETE FROM mahasiswa";
	$query .= " WHERE idmhs= ".$_POST["idmhs"];
	mysqli_query($hub, $query) or die(mysql_error());
}
?>

    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>
  </body>
</html>