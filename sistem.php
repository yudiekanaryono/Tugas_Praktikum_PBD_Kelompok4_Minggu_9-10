<?php
session_start();
require("koneksi.php");

$hub=open_connection();
$usr=$_POST['usr'];
$psw=$_POST['psw'];
$op=$_GET['op'];
if($op=="in"){
    $cek = mysqli_query($hub,"SELECT*FROM tbl_usr WHERE username='$usr' AND password='$psw'");
    
    if (mysqli_num_rows($cek)==1) {
        $c = mysqli_fetch_array($cek);
        $_SESSION['username'] = $c ['username'];
        $_SESSION['jenisuser'] = $c ['jenisuser'];
        $_SESSION['level']=$c['level'];
        if($_SESSION['jenisuser']=='1'and $_SESSION['level']=='10'){
    header("location:homeadmin.php");
}elseif($_SESSION['jenisuser']=='1'and $_SESSION['level']=='11'){ 
    header("location:homeadminmahasiswa.php");
        }else{ 
            header("location:homeclient.php");
    }}else{ 
    die("username/password salah <a href=\"javascript:history.back()\">kembali</a>");
}
    mysqli_close($hub);
    }elseif($op=="out"){
        unset($_SESSION['username']);
        unset($_SESSION['jenisuser']);
        header("location:homeadmin.php");
    }
?>