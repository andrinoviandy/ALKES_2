<?php 
if (isset($_GET['id_hapus'])) {
	$q=mysqli_query($koneksi, "delete from pengeluaran where id=".$_GET['id_hapus']."");
	echo "<script>
	window.location='index.php?page=pengeluaran';
	</script>";
	}
?>
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>Pengeluaran</h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">Pengeluaran</li>
      </ol>
    </section>


    <!-- Main content -->
    <section class="content">
      <!-- Small boxes (Stat box) --><!-- /.row -->
      <!-- Main row -->
      <div class="row">
        <!-- Left col -->
        <section class="col-lg-12 connectedSortable">
          <!-- Custom tabs (Charts with tabs)--><!-- /.nav-tabs-custom -->

          <!-- Chat box -->
          <div class="box box-info"><!-- /.chat -->
            <div class="box-footer">
              <div class="box-body table-responsive no-padding">
              <div class="">
              <!--<a href="index.php?page=tambah_barang_jual">
              <button name="tambah_laporan" class="btn btn-info" type="submit"><span class="fa fa-plus"></span> Jual Alkes</button>
              </a>-->
              <?php if (isset($_SESSION['user_administrator']) or isset($_SESSION['user_admin_keuangan'])) { ?>
              <div class="input-group pull pull-left col-xs-1" style="padding-right:10px">
              <a href="index.php?page=tambah_pengeluaran">
              <button name="tambah_laporan" class="btn btn-success" type="submit"><span class="fa fa-plus"></span> Tambah</button></a>
              
              </div>
              <form method="post" target="_blank" action="cetak_pengeluaran.php">
              <div class="col-xs-3">
                  <div class="input-group">
                        <span class="input-group-addon">
                          Form <span class="fa fa-calendar"></span>
                        </span>
                    <input name="tgl1" required="required" type="date" class="form-control">
                  </div>
                  <!-- /input-group -->
                </div>
                <!-- /.col-lg-6 -->
                <div class="col-xs-3">
                  <div class="input-group">
                        <span class="input-group-addon">
                          To <span class="fa fa-calendar"></span>
                        </span>
                    <input name="tgl2" required="required" type="date" class="form-control">
                  </div>
                  <!-- /input-group -->
                </div>
                <button class="btn btn-success" type="submit"><span class="fa fa-print"></span> Cetak Biaya Pengeluaran</button>
              </form>
              <?php } ?>
              
              <br /><br />
              
              <!--
              <form method="post" class="">
              <div class="input-group input-group-md col-xs-4 pull pull-right">
                <input type="text" name="cari" placeholder="Keyword....." class="form-control">
                    <span class="input-group-btn">
                      <button type="submit" name="button_cari" class="btn btn-info btn-flat"><i class="fa fa-search"></i> Cari </button>
                    </span>
              </div>
              </form>
              -->
              
              
                <table width="100%" id="example1" class="table table-bordered table-hover">
  <thead>
    <tr>
      <th align="center">#</th>
      <th align="center"><strong>Tanggal</strong></th>
      <th align="center">Kebutuhan</th>
      <th align="center"><strong>Biaya Pengeluaran</strong><span class="pull pull-right"></span></th>
      
      <th align="center"><strong>Aksi</strong></th>
    </tr>
  </thead>
  <?php
 
// membuka file JSON
$file = file_get_contents("http://localhost/ALKES/json/pengeluaran.php");
$json = json_decode($file, true);
$jml=count($json); 
for ($i=0; $i<$jml; $i++) {
//echo "Nama Barang ke-".$i." : " . $json[$i]['nama_brg'] . "<br />";
//echo 'Nama Anggota ke-3 : ' . $json['2']['nama_brg'];
?>
  <tr>
    <td align="center"><?php echo $i+1; ?></td>
    <td>
    <?php if ($json[$i]['tgl_pengeluaran']!='0000-00-00') { echo date("d-m-Y",strtotime($json[$i]['tgl_pengeluaran']));}	
	?>
    </td>
    <td><?php echo $json[$i]['kebutuhan'];
	?></td>
    <td><?php echo "Rp ".number_format($json[$i]['biaya_pengeluaran'],2,',','.');
	?></td>
    
    <td align="left">
    <?php if (isset($_SESSION['user_administrator']) && isset($_SESSION['pass_administrator']) or isset($_SESSION['user_admin_keuangan']) && isset($_SESSION['pass_admin_keuangan'])) { ?>
    <a href="index.php?page=pengeluaran&id_hapus=<?php echo $json[$i]['idd']; ?>" onclick="return confirm('Anda Yakin Akan Menghapus Item Ini ?')"><span data-toggle="tooltip" title="Hapus" class="ion-android-delete"></span></a>&nbsp;
    <a href="index.php?page=ubah_pengeluaran&id=<?php echo $json[$i]['idd']; ?>"><span data-toggle="tooltip" title="Ubah" class="fa fa-edit"></span></a><br /><?php } ?>
	<?php /* 
	if (!isset($_SESSION['user_admin_keuangan'])) { ?><a href="index.php?page=kartu_garansi&id=<?php echo $json[$i]['idd']; ?>"><span data-toggle="tooltip" title="Cetak Kartu Garansi" class="fa fa-print"></span></a>&nbsp;&nbsp;<?php } ?><?php if (!isset($_SESSION['user_admin_gudang'])) { ?><a target="blank" href="cetak_faktur_penjualan.php?id=<?php echo $json[$i]['idd']; ?>"><span data-toggle="tooltip" title="Cetak Faktur Penjualan" class="glyphicon glyphicon-print"></span></a><?php } ?><br />
      <?php 
	if (!isset($_SESSION['user_admin_keuangan'])) { ?> 
      <a href="index.php?page=jual_barang&id=<?php echo $json[$i]['idd']; ?>#openKirim"><small data-toggle="tooltip" title="Kirim Alkes" class="label bg-blue">Kirim</small></a>
      <?php } */?>
    </td>
  </tr>
  <?php } ?>
</table>
</div>
              </div>
            </div>
          </div>
          <!-- /.box (chat box) -->

          <!-- TO DO List --><!-- /.box -->

        <!-- quick email widget --></section>
        <!-- /.Left col -->
        <!-- right col (We are only adding the ID to make the widgets sortable)-->
        <section class="col-lg-5 connectedSortable">

          <!-- Map box --><!-- /.box -->

          <!-- solid sales graph --><!-- /.box -->

          <!-- Calendar --><!-- /.box -->

        </section>
        <!-- right col -->
      </div>
      <!-- /.row (main row) -->

  </section>
    <!-- /.content -->
  </div>
<?php 
if (isset($_POST['kirim_barang'])) {
	if ($_POST['id_alkes']=='all') { 
	$update = mysqli_query($koneksi, "insert into barang_dikirim values('','".$_POST['nama_paket']."','".$_POST['no_peng']."','".$_POST['tgl_kirim']."','".$_POST['no_po']."','0000-00-00')");
	$max = mysqli_fetch_array(mysqli_query($koneksi, "select max(id) as id_kirim from barang_dikirim"));
	$sel = mysqli_query($koneksi, "select * from barang_dijual_detail where barang_dijual_id=".$_GET['id']."");
	$tot_sel = mysqli_num_rows($sel);
	while ($data_sel = mysqli_fetch_array($sel)) {
		$ins = mysqli_query($koneksi, "insert into barang_dikirim_detail values('','".$max['id_kirim']."','".$data_sel['id']."')");	
		}
	
	if ($update and $ins) {
		mysqli_query($koneksi, "update barang_dijual_detail set status_kirim=1 where barang_dijual_id=".$_GET['id']."");	
		
		echo "<script type='text/javascript'>
		alert('Data Berhasil Di Simpan !');
		window.location='index.php?page=kirim_barang&id_krm=".$_GET['id']."';
		</script>";
		}
	else {
		echo "<script type='text/javascript'>
		alert('Gagal Disimpan');
		</script>";
		}
	}
	else {
	$update = mysqli_query($koneksi, "insert into barang_dikirim values('','".$_POST['nama_paket']."','".$_POST['no_peng']."','".$_POST['tgl_kirim']."','".$_POST['no_po']."','0000-00-00')");
	$max = mysqli_fetch_array(mysqli_query($koneksi, "select max(id) as id_kirim from barang_dikirim"));
	$ins = mysqli_query($koneksi, "insert into barang_dikirim_detail values('','".$max['id_kirim']."','".$_POST['id_alkes']."')");
	if ($update and $ins) {
		mysqli_query($koneksi, "update barang_dijual_detail set status_kirim=1 where id=".$_POST['id_alkes']."");
		echo "<script type='text/javascript'>
		alert('Data Berhasil Di Simpan !');
		window.location='index.php?page=kirim_barang&id_krm=".$_GET['id']."';
		</script>";
		}
	else {
		echo "<script type='text/javascript'>
		alert('Gagal Disimpan');
		</script>";
		}
	}}
?>
  <div id="openKirim" class="modalDialog">
     <div>
        <a href="#" title="Close" class="close">X</a>
        <h3 align="center">Kirim Alkes</h3> 
     <form method="post">
     <label>Pilih Alkes</label>
     <select id="input" name="id_alkes" required>
     	<?php 
		$q3 = mysqli_query($koneksi, "select *,barang_dijual_detail.id as idd from barang_dijual_detail,barang_gudang,barang_gudang_detail where barang_gudang_detail.id=barang_dijual_detail.barang_gudang_detail_id and barang_gudang.id=barang_gudang_detail.barang_gudang_id and status_kirim=0 and barang_dijual_id=".$_GET['id']."");
		$q4 = mysqli_query($koneksi, "select *,barang_dijual_detail.id as idd from barang_dijual_detail,barang_gudang,barang_gudang_detail where barang_gudang_detail.id=barang_dijual_detail.barang_gudang_detail_id and barang_gudang.id=barang_gudang_detail.barang_gudang_id and status_kirim=1 and barang_dijual_id=".$_GET['id'].""); 
		$d4 = mysqli_num_rows($q4);
		if ($d4==0) {
		?>
        <option value="all">All</option>
        <?php } ?>
        <?php
		while ($d3 = mysqli_fetch_array($q3)) { ?>
		<option value="<?php echo $d3['idd']; ?>"><?php echo $d3['nama_brg']." - No Seri : ".$d3['no_seri_brg']; ?></option>
		<?php } ?>
     </select>
     <label>Nama Paket</label>
     <input id="input" type="text" placeholder="" name="nama_paket" required>
     <label>No. Pengiriman</label>
     <input id="input" type="text" placeholder="" name="no_peng" required>
     <label>Tanggal Pengiriman</label>
     <input id="input" type="date" placeholder="" name="tgl_kirim" required>
     <label>No. PO</label>
     <input id="input" type="text" placeholder="" name="no_po">
     
        <button id="buttonn" name="kirim_barang" type="submit">Kirim Alkes</button>
    </form>
    </div>
</div>

<?php 
$q = mysqli_fetch_array(mysqli_query($koneksi, "select * from pembeli,alamat_provinsi,alamat_kabupaten,alamat_kecamatan where alamat_provinsi.id=pembeli.provinsi_id and alamat_kabupaten.id=pembeli.kabupaten_id and alamat_kecamatan.id=pembeli.kecamatan_id and pembeli.id=".$_GET['id'].""))
?>
<div id="openDetailPembeli" class="modalDialog">
     <div>
        <a href="#" title="Close" class="close">X</a>
        <h3 align="center">Detail RS/Dinas/Klinik/Dll</h3> 
     <form method="post">
     <label>Nama RS/Dinas/Puskesmas/Klinik/Dll</label>
     <input id="input" type="text" placeholder="" name="no_peng" readonly="readonly" disabled value="<?php echo $q['nama_pembeli']; ?>">
     <label>Alamat</label>
     <textarea rows="4" id="input" placeholder="" name="no_peng" readonly="readonly" disabled><?php echo "Kelurahan ".$q['kelurahan_id']."\nKecamatan ".$q['nama_kecamatan']." \nKabupaten ".$q['nama_kabupaten']."\nProvinsi ".$q['nama_provinsi']; ?></textarea>
     <label>Kontak</label>
     <input id="input" type="text" placeholder="" name="no_po" readonly="readonly" disabled value="<?php echo $q['kontak_rs']; ?>">
     <br />
     <br />
    </form>
    </div>
</div>

<div id="openPilihan" class="modalDialog">
     <div>
        <a href="#" title="Close" class="close">X</a>
        <br />
        <a href="index.php?page=jual_alkes"><button id="buttonn">Data Dinas/RS/Puskesmas/Klinik Baru</button></a>
        <a href="index.php?page=jual_alkes2"><button id="buttonn">Dari Data Dinas/RS/Puskesmas/Klinik<br />Yang Sudah Terinput</button></a>
    </div>
</div>

