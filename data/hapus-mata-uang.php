<?php
include("../config/koneksi.php");
include("../include/API.php");
session_start();
error_reporting(0);
$delete = mysqli_query($koneksi, "delete from mata_uang where id=".$_POST['id_hapus']."");
if ($delete) {
    echo "S";
} else {
    echo "F";
}
