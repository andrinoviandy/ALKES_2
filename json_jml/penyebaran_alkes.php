<?php
error_reporting(0);
header("Content-type:application/json");

//koneksi ke database
require("../config/koneksi.php");

$query = mysqli_query($koneksi, "SELECT jumlah_limit FROM limiter");
list($surat_masuk) = mysqli_fetch_array($query);
//pagging
$limit = $surat_masuk;
$start = mysqli_real_escape_string($koneksi, $_GET['start']);


if (isset($_GET['start'])) {
    if (isset($_GET['tgl1']) && isset($_GET['tgl2'])) {
        if (isset($_GET['cari'])) {
            $sql = "select barang_dikirim.*,barang_dikirim.id as idd from barang_dijual,barang_dijual_qty,barang_gudang,pembeli,barang_dikirim,barang_gudang_detail,barang_dikirim_detail,alamat_provinsi,alamat_kabupaten,alamat_kecamatan where barang_dijual.id=barang_dikirim.barang_dijual_id and barang_dijual.id=barang_dijual_qty.barang_dijual_id and barang_gudang.id=barang_dijual_qty.barang_gudang_id and barang_dikirim.id=barang_dikirim_detail.barang_dikirim_id and barang_gudang_detail.id=barang_dikirim_detail.barang_gudang_detail_id and pembeli.id=barang_dijual.pembeli_id and alamat_provinsi.id=pembeli.provinsi_id and alamat_kabupaten.id=pembeli.kabupaten_id and alamat_kecamatan.id=pembeli.kecamatan_id and (no_pengiriman like '%$_GET[cari]%' or barang_dijual.no_po_jual like '%$_GET[cari]%' or nama_pembeli like '%$_GET[cari]%' or nama_brg like '%$_GET[cari]%' or tipe_brg like '%$_GET[cari]%' or no_seri_brg like '%$_GET[cari]%' or nama_provinsi like '%$_GET[cari]%' or nama_kabupaten like '%$_GET[cari]%' or nama_kecamatan like '%$_GET[cari]%') and tgl_kirim between '$_GET[tgl1]' and '$_GET[tgl2]' group by barang_dikirim.id order by tgl_kirim DESC, barang_dikirim.id DESC LIMIT $start, $limit";
        } else {
            $sql = "select barang_dikirim.*,barang_dikirim.id as idd from barang_dijual,barang_dijual_qty,barang_gudang,pembeli,barang_dikirim,barang_gudang_detail,barang_dikirim_detail where barang_dijual.id=barang_dikirim.barang_dijual_id and barang_dijual.id=barang_dijual_qty.barang_dijual_id and barang_gudang.id=barang_dijual_qty.barang_gudang_id and barang_dikirim.id=barang_dikirim_detail.barang_dikirim_id and barang_gudang_detail.id=barang_dikirim_detail.barang_gudang_detail_id and pembeli.id=barang_dijual.pembeli_id and tgl_kirim between '$_GET[tgl1]' and '$_GET[tgl2]' group by barang_dikirim.id order by tgl_kirim DESC, barang_dikirim.id DESC LIMIT $start, $limit";
        }
    } else {
        if (isset($_GET['cari'])) {
            $sql = "select barang_dikirim.*,barang_dikirim.id as idd from barang_dijual,barang_dijual_qty,barang_gudang,pembeli,barang_dikirim,barang_gudang_detail,barang_dikirim_detail,alamat_provinsi,alamat_kabupaten,alamat_kecamatan where barang_dijual.id=barang_dikirim.barang_dijual_id and barang_dijual.id=barang_dijual_qty.barang_dijual_id and barang_gudang.id=barang_dijual_qty.barang_gudang_id and barang_dikirim.id=barang_dikirim_detail.barang_dikirim_id and barang_gudang_detail.id=barang_dikirim_detail.barang_gudang_detail_id and pembeli.id=barang_dijual.pembeli_id and alamat_provinsi.id=pembeli.provinsi_id and alamat_kabupaten.id=pembeli.kabupaten_id and alamat_kecamatan.id=pembeli.kecamatan_id and (no_pengiriman like '%$_GET[cari]%' or barang_dijual.no_po_jual like '%$_GET[cari]%' or nama_pembeli like '%$_GET[cari]%' or nama_brg like '%$_GET[cari]%' or tipe_brg like '%$_GET[cari]%' or no_seri_brg like '%$_GET[cari]%' or nama_provinsi like '%$_GET[cari]%' or nama_kabupaten like '%$_GET[cari]%' or nama_kecamatan like '%$_GET[cari]%') group by barang_dikirim.id order by tgl_kirim DESC, barang_dikirim.id DESC LIMIT $start, $limit";
        } else {
            $sql = "select barang_dikirim.*,barang_dikirim.id as idd from barang_dijual,barang_dijual_qty,barang_gudang,pembeli,barang_dikirim,barang_gudang_detail,barang_dikirim_detail where barang_dijual.id=barang_dikirim.barang_dijual_id and barang_dijual.id=barang_dijual_qty.barang_dijual_id and barang_gudang.id=barang_dijual_qty.barang_gudang_id and barang_dikirim.id=barang_dikirim_detail.barang_dikirim_id and barang_gudang_detail.id=barang_dikirim_detail.barang_gudang_detail_id and pembeli.id=barang_dijual.pembeli_id group by barang_dikirim.id order by tgl_kirim DESC, barang_dikirim.id DESC LIMIT $start, $limit";
        }
    }
} else {
    //untuk jumlah
    if ($_GET['tgl1'] && $_GET['tgl2']) {
        if (isset($_GET['cari'])) {
            $sql = "select barang_dikirim.*,barang_dikirim.id as idd from barang_dijual,barang_dijual_qty,barang_gudang,pembeli,barang_dikirim,barang_gudang_detail,barang_dikirim_detail,alamat_provinsi,alamat_kabupaten,alamat_kecamatan where barang_dijual.id=barang_dikirim.barang_dijual_id and barang_dijual.id=barang_dijual_qty.barang_dijual_id and barang_gudang.id=barang_dijual_qty.barang_gudang_id and barang_dikirim.id=barang_dikirim_detail.barang_dikirim_id and barang_gudang_detail.id=barang_dikirim_detail.barang_gudang_detail_id and pembeli.id=barang_dijual.pembeli_id and alamat_provinsi.id=pembeli.provinsi_id and alamat_kabupaten.id=pembeli.kabupaten_id and alamat_kecamatan.id=pembeli.kecamatan_id and (no_pengiriman like '%$_GET[cari]%' or barang_dijual.no_po_jual like '%$_GET[cari]%' or nama_pembeli like '%$_GET[cari]%' or nama_brg like '%$_GET[cari]%' or tipe_brg like '%$_GET[cari]%' or no_seri_brg like '%$_GET[cari]%' or nama_provinsi like '%$_GET[cari]%' or nama_kabupaten like '%$_GET[cari]%' or nama_kecamatan like '%$_GET[cari]%') and tgl_kirim between '$_GET[tgl1]' and '$_GET[tgl2]' group by barang_dikirim.id order by tgl_kirim DESC, barang_dikirim.id DESC";
        } else {
            $sql = "select * from barang_dijual,barang_dijual_qty,barang_gudang,pembeli,barang_dikirim,barang_gudang_detail,barang_dikirim_detail where barang_dijual.id=barang_dikirim.barang_dijual_id and barang_dijual.id=barang_dijual_qty.barang_dijual_id and barang_gudang.id=barang_dijual_qty.barang_gudang_id and barang_dikirim.id=barang_dikirim_detail.barang_dikirim_id and barang_gudang_detail.id=barang_dikirim_detail.barang_gudang_detail_id and pembeli.id=barang_dijual.pembeli_id and tgl_kirim between '$_GET[tgl1]' and '$_GET[tgl2]' group by barang_dikirim.id";
        }
    } else {
        if (isset($_GET['cari'])) {
            $sql = "select barang_dikirim.*,barang_dikirim.id as idd from barang_dijual,barang_dijual_qty,barang_gudang,pembeli,barang_dikirim,barang_gudang_detail,barang_dikirim_detail,alamat_provinsi,alamat_kabupaten,alamat_kecamatan where barang_dijual.id=barang_dikirim.barang_dijual_id and barang_dijual.id=barang_dijual_qty.barang_dijual_id and barang_gudang.id=barang_dijual_qty.barang_gudang_id and barang_dikirim.id=barang_dikirim_detail.barang_dikirim_id and barang_gudang_detail.id=barang_dikirim_detail.barang_gudang_detail_id and pembeli.id=barang_dijual.pembeli_id and alamat_provinsi.id=pembeli.provinsi_id and alamat_kabupaten.id=pembeli.kabupaten_id and alamat_kecamatan.id=pembeli.kecamatan_id and (no_pengiriman like '%$_GET[cari]%' or barang_dijual.no_po_jual like '%$_GET[cari]%' or nama_pembeli like '%$_GET[cari]%' or nama_brg like '%$_GET[cari]%' or tipe_brg like '%$_GET[cari]%' or no_seri_brg like '%$_GET[cari]%' or nama_provinsi like '%$_GET[cari]%' or nama_kabupaten like '%$_GET[cari]%' or nama_kecamatan like '%$_GET[cari]%') group by barang_dikirim.id order by tgl_kirim DESC, barang_dikirim.id DESC";
        } else {
            $sql = "select barang_dikirim.* from barang_dijual,barang_dijual_qty,barang_gudang,pembeli,barang_dikirim,barang_gudang_detail,barang_dikirim_detail where barang_dijual.id=barang_dikirim.barang_dijual_id and barang_dijual.id=barang_dijual_qty.barang_dijual_id and barang_gudang.id=barang_dijual_qty.barang_gudang_id and barang_dikirim.id=barang_dikirim_detail.barang_dikirim_id and barang_gudang_detail.id=barang_dikirim_detail.barang_gudang_detail_id and pembeli.id=barang_dijual.pembeli_id group by barang_dikirim.id";
        }
    }
}


//menampilkan data dari database, table tb_anggota
// if (isset($_GET['id'])) {
// if (isset($_GET['cari']) and isset($_GET['pilihan'])) {
// $sql = "select *,barang_dikirim.id as idd from barang_dijual,barang_dijual_qty,barang_gudang,pembeli,barang_dikirim where barang_dijual.id=barang_dikirim.barang_dijual_id and barang_dijual.id=barang_dijual_qty.barang_dijual_id and barang_gudang.id=barang_dijual_qty.barang_gudang_id and pembeli.id=barang_dijual.pembeli_id and $_GET[pilihan] like '%$_GET[cari]%' and barang_dijual.id=".$_GET['id']." group by barang_dikirim.id order by tgl_kirim DESC, barang_dikirim.id DESC LIMIT $curr, $limit";
// } else {
// $sql = "select *,barang_dikirim.id as idd from barang_dikirim where barang_dijual_id=".$_GET['id']." order by tgl_kirim DESC, barang_dikirim.id DESC LIMIT $curr, $limit";
// }
// }
// else if (isset($_GET['id_riwayat'])) {
// if (isset($_GET['cari']) and isset($_GET['pilihan'])) {
// $sql = "select *,barang_dikirim.id as idd from barang_dijual,barang_dijual_qty,barang_gudang,pembeli,barang_dikirim where barang_dijual.id=barang_dikirim.barang_dijual_id and barang_dijual.id=barang_dijual_qty.barang_dijual_id and barang_gudang.id=barang_dijual_qty.barang_gudang_id and pembeli.id=barang_dijual.pembeli_id and $_GET[pilihan] like '%$_GET[cari]%' and barang_dikirim.id=".$_GET['id_riwayat']." group by barang_dikirim.id order by tgl_kirim DESC, barang_dikirim.id DESC LIMIT $curr, $limit";
// } else {
// $sql = "select *,barang_dikirim.id as idd from barang_dikirim where id=".$_GET['id_riwayat']." order by tgl_kirim DESC, barang_dikirim.id DESC LIMIT $curr, $limit";
// }
// }
// else {
// if (isset($_GET['tgl1']) and isset($_GET['tgl2'])) {
// $sql = "select *,barang_dikirim.id as idd from barang_dijual,barang_dijual_qty,barang_gudang,pembeli,barang_dikirim,barang_gudang_detail,barang_dikirim_detail where barang_dijual.id=barang_dikirim.barang_dijual_id and barang_dijual.id=barang_dijual_qty.barang_dijual_id and barang_gudang.id=barang_dijual_qty.barang_gudang_id and barang_dikirim.id=barang_dikirim_detail.barang_dikirim_id and barang_gudang_detail.id=barang_dikirim_detail.barang_gudang_detail_id and pembeli.id=barang_dijual.pembeli_id and tgl_kirim between '$_GET[tgl1]' and '$_GET[tgl2]' group by barang_dikirim.id order by tgl_kirim DESC, barang_dikirim.id DESC LIMIT $curr, $limit";
// }
// elseif (isset($_GET['cari']) and isset($_GET['pilihan'])) {
// $sql = "select *,barang_dikirim.id as idd from barang_dijual,barang_dijual_qty,barang_gudang,pembeli,barang_dikirim,barang_gudang_detail,barang_dikirim_detail where barang_dijual.id=barang_dikirim.barang_dijual_id and barang_dijual.id=barang_dijual_qty.barang_dijual_id and barang_gudang.id=barang_dijual_qty.barang_gudang_id and barang_dikirim.id=barang_dikirim_detail.barang_dikirim_id and barang_gudang_detail.id=barang_dikirim_detail.barang_gudang_detail_id and pembeli.id=barang_dijual.pembeli_id and $_GET[pilihan] like '%$_GET[cari]%' group by barang_dikirim.id order by tgl_kirim DESC, barang_dikirim.id DESC LIMIT $curr, $limit";
// } else {
// 	if (isset($_GET['thn'])) {
// 		if ($_GET['thn']=='all') {
// 		$sql = "select *,barang_dikirim.id as idd from barang_dikirim order by tgl_kirim DESC LIMIT $curr, $limit";
// 		} else {
// 			$sql = "select *,barang_dikirim.id as idd from barang_dikirim where year(tgl_kirim)='".$_GET['thn']."' order by tgl_kirim DESC, barang_dikirim.id DESC LIMIT $curr, $limit";
// 		}
// 	} else {
// 	$sql = "select *,barang_dikirim.id as idd from barang_dikirim where year(tgl_kirim)='".date('Y')."' order by tgl_kirim DESC, barang_dikirim.id DESC LIMIT $curr, $limit";
// 	}
// }
// }
$result = mysqli_query($koneksi, $sql) or die("Error " . mysqli_error($koneksi));

//membuat array
while ($row = mysqli_fetch_assoc($result)) {
    $ArrAnggota[] = $row;
}

echo json_encode($ArrAnggota, JSON_PRETTY_PRINT);

//tutup koneksi ke database
mysqli_close($koneksi);
