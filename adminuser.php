<?php 
require("koneksi.php");

$hub = open_connection();
$a = @$_GET["a"];
$id = @$_GET["id"];
$sql = @$_POST["sql"];
switch ($sql) {
	case "create":
		create_user();
		break;
	case "update":
		update_user();
		break;
	case "delete":
		delete_user();
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
	$query = "select * from tbl_usr";
	$result = mysqli_query($hub, $query); ?>

		  <div style="max-width: 600px; margin: 9em auto">

	<h2 class="text-center">Data User
	 <a class="nav-link" href="homeadmin.php">HOME<span class="sr-only">(current)</span></a></h2>
	<hr>
<table class="table table-bordered table-striped">
		<tr>
			<td colspan="7"><button type="button" class="btn btn-outline-success"> <a href="adminuser.php?a=input">INPUT</a></button></td>
		</tr>
		<tr>
			<td>ID</td>
			<td>Username</td>
			<td>Jenis User</td>
			<td>Level</td>
			<td>Status</td>
			<td>Id Prodi</td>
		</tr>
		<?php while($row = mysqli_fetch_array($result)) { ?>
		<tr>
			<td><?php echo $row['iduser']; ?></td>
			<td><?php echo $row['username']; ?></td>
			<td><?php echo $row['jenisuser']; ?></td>
			<td><?php echo $row['level']; ?></td>
			<td><?php echo $row['status']; ?></td>
			<td><?php echo $row['idprodi']; ?></td>
			<td>

				 <button type="button" class="btn btn-outline-success"> <a href="adminuser.php?a=edit&id=<?php echo $row ['iduser']; ?>">EDIT</a></button>
        <button type="button" class="btn btn-outline-warning"><a href="adminuser.php?a=hapus&id=<?php echo $row ['iduser']; ?>">HAPUS</a></button>
				
				
			</td>
		</tr>
		<?php } ?>
	</table>
</div>
<?php } ?>

<?php 
function input_data(){
	$row = array(
			"username" => "",
			"password" => "",
			"jenisuser" => "-",
			"level" => "-",
			"status" => "-",
			"idprodi" =>""
			); ?>

	<h2>Input Data User</h2>
	<table class="table table-bordered table-striped">
	<form action="adminuser.php?a=input" method="post"> 
		<input type="hidden" name="sql" value="create"> 
		<tr>
		<td>Username</td>
		<td><input type="text" name="username" maxlength="50" size="50" value="<?php echo trim($row["username"]) ?>" /></td>
		</tr>
		<tr>
		<td>
		Password</td>
		<td><input type="text" name="password" maxlength="70" size="70" value="<?php echo trim($row["password"]) ?>" />
		</td>
		</tr>
		<tr>
		<td>
		Jenis User
		</td>
		<td>
		<input type="radio" name="jenisuser" value="-" <?php if($row["jenisuser"]=='-' || $row["jenisuser"]=='') { echo "checked=\"checked\""; } else {echo "";} ?>> -
		<input type="radio" name="jenisuser" value="0" <?php if($row["jenisuser"]=='0') { echo "checked=\"checked\""; } else {echo "";} ?>> 0
		<input type="radio" name="jenisuser" value="1" <?php if($row["jenisuser"]=='1') { echo "checked=\"checked\""; } else {echo "";} ?>> 1
		</td>
	</tr>
	<tr>
		<td>
		Level
		</td>
		<td>
		<input type="radio" name="level" value="-" <?php if($row["level"]=='-' || $row["level"]=='') { echo "checked=\"checked\""; } else {echo "";} ?>> -
		<input type="radio" name="level" value="00" <?php if($row["level"]=='00') { echo "checked=\"checked\""; } else {echo "";} ?>> 00
		<input type="radio" name="level" value="10" <?php if($row["level"]=='10') { echo "checked=\"checked\""; } else {echo "";} ?>> 10
		<input type="radio" name="level" value="11" <?php if($row["level"]=='11') { echo "checked=\"checked\""; } else {echo "";} ?>> 11
		</td>
	</tr>
	<tr>
		<td>
		status
		</td>
		<td>
		<input type="radio" name="status" value="-" <?php if($row["status"]=='-' || $row["status"]=='') { echo "checked=\"checked\""; } else {echo "";} ?>> -
		<input type="radio" name="status" value="F" <?php if($row["status"]=='F') { echo "checked=\"checked\""; } else {echo "";} ?>> F
		<input type="radio" name="status" value="T" <?php if($row["status"]=='T') { echo "checked=\"checked\""; } else {echo "";} ?>> T
		</td>
	</tr>
	<tr>
		<td>Id Prodi</td>
		<td><input type="text" name="idprodi" maxlength="50" size="50" value="<?php echo trim($row["idprodi"]) ?>" /></td>
		</tr>
	<tr>
	<td colspan="2" align ="right"> <button type="submit" name = "action" class="btn btn-outline-success" value "Simpan">Simpan</button>
        <button type="button" class="btn btn-outline-warning"><a href="adminuser.php?a=list"</a>Batal</button></td>
		</tr>
	</form>
	</table>
<?php } ?>

<?php
function edit_data($id ){
	global $hub;
	$query = "select*from tbl_usr where iduser = $id"; 
	$result = mysqli_query($hub, $query);
	$row = mysqli_fetch_array($result); ?>

<h2>Edit Data User</h2>
<table class="table table-bordered table-striped">
	<form action="adminuser.php?a=list" method="post">
		<input type="hidden" name="sql" value="update">
		<input type="hidden" name="iduser" value="<?php echo trim ($id) ?>">
		<tr>
		<td>Username</td>
		<td><input type="text" name="username" maxlength="50" size="50" value="<?php echo trim($row["username"]) ?>" /></td>
		</tr>
		<tr>
		<td>
		Password</td>
		<td><input type="text" name="password" maxlength="70" size="70" value="<?php echo trim($row["password"]) ?>" />
		</td>
		</tr>
		<tr>
		<td>
		Jenis User
		</td>
		<td>
		<input type="radio" name="jenisuser" value="-" <?php if($row["jenisuser"]=='-' || $row["jenisuser"]=='') { echo "checked=\"checked\""; } else {echo "";} ?>> -
		<input type="radio" name="jenisuser" value="0" <?php if($row["jenisuser"]=='0') { echo "checked=\"checked\""; } else {echo "";} ?>> 0
		<input type="radio" name="jenisuser" value="1" <?php if($row["jenisuser"]=='1') { echo "checked=\"checked\""; } else {echo "";} ?>> 1
		</td>
	</tr>
	<tr>
		<td>
		Level
		</td>
		<td>
		<input type="radio" name="level" value="-" <?php if($row["level"]=='-' || $row["level"]=='') { echo "checked=\"checked\""; } else {echo "";} ?>> -
		<input type="radio" name="level" value="00" <?php if($row["level"]=='00') { echo "checked=\"checked\""; } else {echo "";} ?>> 00
		<input type="radio" name="level" value="10" <?php if($row["level"]=='10') { echo "checked=\"checked\""; } else {echo "";} ?>> 10
		<input type="radio" name="level" value="11" <?php if($row["level"]=='11') { echo "checked=\"checked\""; } else {echo "";} ?>> 11
		</td>
	</tr>
	<tr>
		<td>
		status
		</td>
		<td>
		<input type="radio" name="status" value="-" <?php if($row["status"]=='-' || $row["status"]=='') { echo "checked=\"checked\""; } else {echo "";} ?>> -
		<input type="radio" name="status" value="F" <?php if($row["status"]=='F') { echo "checked=\"checked\""; } else {echo "";} ?>> F
		<input type="radio" name="status" value="T" <?php if($row["status"]=='T') { echo "checked=\"checked\""; } else {echo "";} ?>> T
		</td>
	</tr>
	<tr>
		<td>Id Prodi</td>
		<td><input type="text" name="idprodi" maxlength="50" size="50" value="<?php echo trim($row["idprodi"]) ?>" /></td>
		</tr>
		<tr>
		<td colspan="2" align ="right"> <button type="submit" name="action" class="btn btn-outline-success" value "Simpan">Simpan</button><button type="button" class="btn btn-outline-warning"><a href="adminuser.php?a=list"</a>Batal</button>
		</tr>
	</form>
	</table>
<?php }  ?>
<?php
function hapus_data($id) {
	global $hub;
	$query = "select * from tbl_usr where iduser= $id";
	$result = mysqli_query($hub, $query);
	$row = mysqli_fetch_array($result);?>
<h2> Hapus Data User</h2>
<form action="adminuser.php?a=list" method="post">
	<input type="hidden" name="sql" value="delete">
	<input type="hidden" name="iduser" value="<?php echo trim($id)?>">
	<table class="table table-bordered table-striped">
		<tr>
			<td width=100>Id User</td>
			<td><?php echo trim($row["iduser"])?></td>
		</tr>
		<tr>
			<td>Username</td>
			<td><?php echo trim($row["username"])?></td>
		</tr>
		<tr>
		<td colspan="2" align ="right"> <button type="submit" onclick="return konfirmasi()" name="action"  class="btn btn-outline-success" value="Hapus">Hapus</button><button type="button" class="btn btn-outline-warning"><a href="adminuser.php?a=list"</a>Batal</button>
		</tr>
	</table>
	</form>
	<?php } ?>
<?php 
function create_user() {
	global $hub;
	global $_POST;
	$query = "insert into tbl_usr (username, password, jenisuser, level, status, idprodi) 
	value";
	$query .= "('".$_POST["username"]."', '".$_POST["password"]."', '".$_POST["jenisuser"]."','".$_POST["level"]."','".$_POST["status"]."','".$_POST["idprodi"]."')";
	mysqli_query($hub, $query) or die(mysql_error());
}

function update_user() {
	global $hub;
	global $_POST;
	$query = "UPDATE tbl_usr";
	$query .= " SET username='".$_POST["username"]."', password='". $_POST["password"]."',jenisuser='".$_POST["jenisuser"]."',level='".$_POST["level"]."',status='".$_POST["status"]."',idprodi='".$_POST["idprodi"]."'";
	$query .= " WHERE iduser = ".$_POST["iduser"];
	mysqli_query($hub, $query) or die(mysql_error());
}

function delete_user() {
	global $hub;
	global $_POST;
	$query = "DELETE FROM tbl_usr";
	$query .= " WHERE iduser= ".$_POST["iduser"];
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