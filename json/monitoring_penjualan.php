<?php
// error_reporting(0);
header("Access-Control-Allow-Origin: *");

// Izinkan metode HTTP yang diizinkan
header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE");

// Izinkan header yang diizinkan
header("Access-Control-Allow-Headers: Content-Type");

// Izinkan pengiriman cookie pada permintaan lintas domain
header("Access-Control-Allow-Credentials: true");


//koneksi ke database
require("../config/koneksi.php");
// $distinct = "COUNT(DISTINCT barang_dijual.no_po_jual)";
$distinct = "CASE WHEN SUM(barang_dijual_qty.qty_jual) IS NULL THEN 0 ELSE SUM(barang_dijual_qty.qty_jual) END";
$filter = "";
if ($_GET['alkes'] && $_GET['alkes'] !== 'all') {
    $filter = $filter . " and barang_gudang_id = $_GET[alkes] ";
    // $distinct = "CASE WHEN SUM(barang_dijual_qty.qty_jual) IS NULL THEN 0 ELSE SUM(barang_dijual_qty.qty_jual) END";
}
if ($_GET['filter'] == 1) {
    $filter = $filter . " and pembeli.id = $_GET[pembeli] ";
} else if ($_GET['filter'] == 2) {
    if ($_GET['provinsi'] && $_GET['provinsi'] !== 'all') {
        $filter = $filter . " and provinsi_id = $_GET[provinsi] ";
        if ($_GET['kabupaten'] && $_GET['kabupaten'] !== 'all') {
            $filter = $filter . " and kabupaten_id = $_GET[kabupaten] ";
            if ($_GET['kecamatan'] && $_GET['kecamatan'] !== 'all') {
                $filter = $filter . " and kecamatan_id = $_GET[kecamatan] ";
            }
        }
    }
}

$sql = "select DISTINCT 
(SELECT $distinct from barang_dijual, pembeli, barang_dijual_qty, barang_gudang where barang_dijual.id = barang_dijual_qty.barang_dijual_id and barang_gudang.id = barang_dijual_qty.barang_gudang_id and pembeli.id = barang_dijual.pembeli_id and month(tgl_jual) = '1' and year(tgl_jual) = '$_GET[tahun]' $filter) as jan,
(SELECT $distinct from barang_dijual, pembeli, barang_dijual_qty, barang_gudang where barang_dijual.id = barang_dijual_qty.barang_dijual_id and barang_gudang.id = barang_dijual_qty.barang_gudang_id and pembeli.id = barang_dijual.pembeli_id and month(tgl_jual) = '2' and year(tgl_jual) = '$_GET[tahun]' $filter) as feb,
(SELECT $distinct from barang_dijual, pembeli, barang_dijual_qty, barang_gudang where barang_dijual.id = barang_dijual_qty.barang_dijual_id and barang_gudang.id = barang_dijual_qty.barang_gudang_id and pembeli.id = barang_dijual.pembeli_id and month(tgl_jual) = '3' and year(tgl_jual) = '$_GET[tahun]' $filter) as mar,
(SELECT $distinct from barang_dijual, pembeli, barang_dijual_qty, barang_gudang where barang_dijual.id = barang_dijual_qty.barang_dijual_id and barang_gudang.id = barang_dijual_qty.barang_gudang_id and pembeli.id = barang_dijual.pembeli_id and month(tgl_jual) = '4' and year(tgl_jual) = '$_GET[tahun]' $filter) as apr,
(SELECT $distinct from barang_dijual, pembeli, barang_dijual_qty, barang_gudang where barang_dijual.id = barang_dijual_qty.barang_dijual_id and barang_gudang.id = barang_dijual_qty.barang_gudang_id and pembeli.id = barang_dijual.pembeli_id and month(tgl_jual) = '5' and year(tgl_jual) = '$_GET[tahun]' $filter) as mei,
(SELECT $distinct from barang_dijual, pembeli, barang_dijual_qty, barang_gudang where barang_dijual.id = barang_dijual_qty.barang_dijual_id and barang_gudang.id = barang_dijual_qty.barang_gudang_id and pembeli.id = barang_dijual.pembeli_id and month(tgl_jual) = '6' and year(tgl_jual) = '$_GET[tahun]' $filter) as jun,
(SELECT $distinct from barang_dijual, pembeli, barang_dijual_qty, barang_gudang where barang_dijual.id = barang_dijual_qty.barang_dijual_id and barang_gudang.id = barang_dijual_qty.barang_gudang_id and pembeli.id = barang_dijual.pembeli_id and month(tgl_jual) = '7' and year(tgl_jual) = '$_GET[tahun]' $filter) as jul,
(SELECT $distinct from barang_dijual, pembeli, barang_dijual_qty, barang_gudang where barang_dijual.id = barang_dijual_qty.barang_dijual_id and barang_gudang.id = barang_dijual_qty.barang_gudang_id and pembeli.id = barang_dijual.pembeli_id and month(tgl_jual) = '8' and year(tgl_jual) = '$_GET[tahun]' $filter) as agu,
(SELECT $distinct from barang_dijual, pembeli, barang_dijual_qty, barang_gudang where barang_dijual.id = barang_dijual_qty.barang_dijual_id and barang_gudang.id = barang_dijual_qty.barang_gudang_id and pembeli.id = barang_dijual.pembeli_id and month(tgl_jual) = '9' and year(tgl_jual) = '$_GET[tahun]' $filter) as sep,
(SELECT $distinct from barang_dijual, pembeli, barang_dijual_qty, barang_gudang where barang_dijual.id = barang_dijual_qty.barang_dijual_id and barang_gudang.id = barang_dijual_qty.barang_gudang_id and pembeli.id = barang_dijual.pembeli_id and month(tgl_jual) = '10' and year(tgl_jual) = '$_GET[tahun]' $filter) as okt,
(SELECT $distinct from barang_dijual, pembeli, barang_dijual_qty, barang_gudang where barang_dijual.id = barang_dijual_qty.barang_dijual_id and barang_gudang.id = barang_dijual_qty.barang_gudang_id and pembeli.id = barang_dijual.pembeli_id and month(tgl_jual) = '11' and year(tgl_jual) = '$_GET[tahun]' $filter) as nov,
(SELECT $distinct from barang_dijual, pembeli, barang_dijual_qty, barang_gudang where barang_dijual.id = barang_dijual_qty.barang_dijual_id and barang_gudang.id = barang_dijual_qty.barang_gudang_id and pembeli.id = barang_dijual.pembeli_id and month(tgl_jual) = '12' and year(tgl_jual) = '$_GET[tahun]' $filter) as des 
from barang_dijual, pembeli where pembeli.id = barang_dijual.pembeli_id and status_deal=1";

// echo $sql; die();

$result = mysqli_query($koneksi, $sql) or die("Error " . mysqli_error($koneksi));
$row = mysqli_fetch_array($result);
// $ArrAnggota = array();
for ($i = 0; $i <= 11; $i++) {
    $ArrAnggota[] = $row[$i];
}
echo str_replace('"', '', json_encode($ArrAnggota));

//tutup koneksi ke database
mysqli_close($koneksi);
