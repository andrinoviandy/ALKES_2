<?php 
if (isset($_POST['button_urut'])) {
	echo "<script>window.location='cetak_stok_alkes.php?merk=$_POST[merk]'</script>";
	}
?>
<?php 
if (isset($_GET['id_hapus'])) {
	$del = mysqli_query($koneksi, "delete from coa_detail where coa_id=".$_GET['id_hapus']."");
	$del2 = mysqli_query($koneksi, "delete from coa where id=".$_GET['id_hapus']."");
	}
?>
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>Laporan Kas Harian</h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">Laporan Kas Harian</li>
      </ol>
    </section>


    <!-- Main content -->
    <section class="content">
      <!-- Small boxes (Stat box) --><!-- /.row -->
      <!-- Main row -->
      <div class="row">
        <!-- Left col -->
        <section class="col-lg-6 connectedSortable">
          <!-- Custom tabs (Charts with tabs)--><!-- /.nav-tabs-custom -->

          <!-- Chat box -->
          <div class="box box-success"><!-- /.chat -->
            <div class="box-footer">
              <div class="box-body table-responsive no-padding">
              <span class="pul pull-left">
              <form method="post">
              <table>
              <tr>
                <td>
                  <input type="date" name="lihat_tanggal" class="form-control" value=""/></td>
                  <td>
                  <select class="form-control" name="akun">
                  <option value="all">All</option>
                  <?php 
				  $q = mysqli_query($koneksi, "select * from buku_kas order by no_akun ASC");
				  while ($d = mysqli_fetch_array($q)) {
				  ?>
                  <option value="<?php echo $d['id']; ?>"><?php echo $d['no_akun']." | ".$d['nama_akun']; ?></option>
                  <?php } ?>
                  </select>
                  </td>
              <td><button name="lihat" type="submit" class="btn btn-success">Lihat</button></td>
              <td>
              <span class=""><button data-toggle="tooltip" title="Cetak Excel" class="btn btn-success"><span class="fa fa-file-excel-o"></span></button></span>
              </td>
              <td>
              <span class=""><button data-toggle="tooltip" title="Cetak PDF" class="btn btn-success"><span class="fa fa-file-pdf-o"></span></button></span>
              </td>
              </tr>
              </table>
              </form>
              </span>
              
              
              <br /><br /><br />
              <table width="100%" class="table no-border">
                <tr>
                  <td width="58%">Tanggal</td>
                  <td width="11%">&nbsp;</td>
                  <td width="6%">&nbsp;</td>
                  <td width="25%" align="right"><?php
				  if (isset($_POST['lihat'])) {
					  echo date("d M Y",strtotime($_POST['lihat_tanggal']));
					  }
				  else { 
				  echo date('d M Y');
				  } ?></td>
                </tr>
                <tr>
                  <td>Kas</td>
                  <td>&nbsp;</td>
                  <td>&nbsp;</td>
                  <td align="right"><?php
				  if (isset($_POST['lihat'])) {
					  $m=mysqli_fetch_array(mysqli_query($koneksi, "select * from buku_kas where id=".$_POST['akun'].""));
					  echo $m['no_akun']." | ".$m['nama_akun'];
					  }
				  else { 
				  echo "Semua Kas";;
				  } ?></td>
                </tr>
                <tr>
                  <td>&nbsp;</td>
                  <td>&nbsp;</td>
                  <td>&nbsp;</td>
                  <td align="right">&nbsp;</td>
                </tr>
                <tr>
                  <td>Semua Pemasukan</td>
                  <td>(+)</td>
                  <td>Rp</td>
                  <td align="right"><?php 
				  if (isset($_POST['lihat'])) {
					  $piutang = mysqli_fetch_array(mysqli_query($koneksi,"select sum(nominal) as jumlah from utang_piutang_bayar where tgl_bayar='".$_POST['lihat_tanggal']."' and u_p='Piutang' and buku_kas_id=".$_POST['akun'].""));
					  }
				  else {
					$piutang = mysqli_fetch_array(mysqli_query($koneksi,"select sum(nominal) as jumlah from utang_piutang_bayar where tgl_bayar='".date('Y-m-d')."' and u_p='Piutang'"));
				  }
					echo number_format($piutang['jumlah'],2,',','.');
					?></td>
                </tr>
                <tr>
                  <td>Semua Pengeluaran</td>
                  <td>(-)</td>
                  <td>Rp</td>
                  <td align="right"><?php
				  if (isset($_POST['lihat'])) {
				  $utang = mysqli_fetch_array(mysqli_query($koneksi,"select sum(nominal) as jumlah from utang_piutang_bayar where tgl_bayar='".$_POST['lihat_tanggal']."' and u_p='Hutang' and buku_kas_id=".$_POST['akun'].""));
				  }
				  else {
					$utang = mysqli_fetch_array(mysqli_query($koneksi,"select sum(nominal) as jumlah from utang_piutang_bayar where tgl_bayar='".date('Y-m-d')."' and u_p='Hutang'"));
				  }
					echo number_format($utang['jumlah'],2,',','.'); ?></td>
                </tr>
                <tr>
                  <td align="right"><strong>Akumulasi</strong></td>
                  <td>&nbsp;</td>
                  <td><strong>Rp</strong></td>
                  <td align="right"><?php
                  echo number_format(($piutang['jumlah']-$utang['jumlah']),2,',','.');
				  ?></td>
                </tr>
                <tr>
                  <td>&nbsp;</td>
                  <td>&nbsp;</td>
                  <td>&nbsp;</td>
                  <td align="right">&nbsp;</td>
                </tr>
                <tr>
                  <td>Saldo Saat Ini</td>
                  <td>&nbsp;</td>
                  <td>Rp</td>
                  <td align="right"><?php 
					$buku_kas = mysqli_fetch_array(mysqli_query($koneksi,"select sum(saldo) as jumlah from buku_kas"));
					echo number_format($buku_kas['jumlah'],2,',','.'); ?></td>
                </tr>
              </table>
              <br />

              </div>
            </div>
          </div>
          <!-- /.box (chat box) -->

          <!-- TO DO List --><!-- /.box -->

        <!-- quick email widget --></section>
        <section class="col-lg-6 connectedSortable">
          <div class="box box-success"><!-- /.chat -->
            <div class="box-header">
              Chart
              </div>
            <div class="box-footer">
              <div class="box-body no-padding">
              <div style="width: 550px;margin: 0px auto;">
		<canvas id="myChart"></canvas>
	</div>	
              </div>
            </div>
          </div>
          </section>
          
      </div>
      <div class="row">
          <section class="col-lg-6 connectedSortable">
          <div class="box box-success"><!-- /.chat -->
            <div class="box-header">
              Pemasukan
              </div>
            <div class="box-footer">
              <div class="box-body table-responsive no-padding">
              <table width="100%" id="example1" class="table table-bordered table-hover">
  <thead>
    <tr>
      <th width="10%" valign="top">ID</th>
        <th width="20%" valign="top">Kategori</th>
        <th width="10%" valign="top">Klien</th>
      <th width="15%" valign="top"><strong>Deskripsi</strong></th>
      <th width="10%" valign="top">Nominal</th>
      <th width="18%" valign="top"><strong>Pembayaran Terakhir</strong></th>
      <th width="7%" align="center" valign="top">Status</th>
      <!--<th valign="top">NIE</th>
      <th valign="top">No. Bath</th>
      <th valign="top">No. Lot</th>-->
      </tr>
  </thead>
  <?php
	  $query = mysqli_query($koneksi, "select *,utang_piutang.nominal as nominal_up,utang_piutang.id as id_up from utang_piutang_bayar,buku_kas,utang_piutang,kategori_buku_kas where utang_piutang.id=utang_piutang_bayar.utang_piutang_id and kategori_buku_kas.id=utang_piutang.kategori_buku_kas_id and buku_kas.id=utang_piutang_bayar.buku_kas_id and utang_piutang.u_p='Piutang' group by utang_piutang_id order by utang_piutang.tgl_input DESC");

  $no=0;
  while ($data = mysqli_fetch_array($query)) { 
  $no++;
  ?>
  <tr>
    <td><?php echo "PI".$data['id_up'];;  ?></td>
    
    <td><?php echo $data['nama_kategori']; ?></td>
    <td><?php echo $data['klien']; ?></td>
    
      <td><?php echo $data['deskripsi']; ?></td>
      <td><?php echo "Rp ".number_format($data['nominal_up'],2,',','.'); ?>
      <font style="font-size:12px">
	  <?php if ($data['jatuh_tempo']!=0000-00-00){
		  echo "<br>Jatuh Tempo : ".date("d M Y",strtotime($data['jatuh_tempo']));
		  } ?>
          </font>
      </td>
      <td>
      <?php
      $dd = mysqli_fetch_array(mysqli_query($koneksi, "select * from utang_piutang_bayar where utang_piutang_id=$data[id_up] order by tgl_bayar DESC LIMIT 1"));
	  echo date("d/m/y",strtotime($dd['tgl_bayar']))." : Rp".number_format($dd['nominal'],2,',','.');
	  ?>
      <br />
      <font style="font-size:11px"><?php 
	$ddd = mysqli_fetch_array(mysqli_query($koneksi, "select sum(nominal) as nominal_bayar from utang_piutang_bayar where utang_piutang_id=$data[id_up]"));
	echo "Total Pembayaran : Rp".number_format($ddd['nominal_bayar'],2,',','.'); ?></font></td>
      <td><?php if ($data['status_lunas']==0){echo "Belum Lunas";}else {echo "Sudah Lunas";} ?></td>
    <!--<td></td>
    <td><?php echo $data['no_bath']; ?></td>
    <td><?php echo $data['no_lot']; ?></td>-->
    <?php if ($data['stok_total']==0) { $color="red"; } else { $color=""; } ?>
    </tr>
  
  <?php } ?>
</table>	
              </div>
            </div>
          </div>
          </section>
		<section class="col-lg-6 connectedSortable">
          <div class="box box-success"><!-- /.chat -->
            <div class="box-header">
              Pemasukan
              </div>
            <div class="box-footer">
              <div class="box-body table-responsive no-padding">
              <table width="100%" id="example1" class="table table-bordered table-hover">
  <thead>
    <tr>
      <th width="10%" valign="top">ID</th>
        <th width="20%" valign="top">Kategori</th>
        <th width="10%" valign="top">Klien</th>
      <th width="15%" valign="top"><strong>Deskripsi</strong></th>
      <th width="10%" valign="top">Nominal</th>
      <th width="18%" valign="top"><strong>Pembayaran Terakhir</strong></th>
      <th width="7%" align="center" valign="top">Status</th>
      <!--<th valign="top">NIE</th>
      <th valign="top">No. Bath</th>
      <th valign="top">No. Lot</th>-->
      </tr>
  </thead>
  <?php
	  $query = mysqli_query($koneksi, "select *,utang_piutang.nominal as nominal_up,utang_piutang.id as id_up from utang_piutang_bayar,buku_kas,utang_piutang,kategori_buku_kas where utang_piutang.id=utang_piutang_bayar.utang_piutang_id and kategori_buku_kas.id=utang_piutang.kategori_buku_kas_id and buku_kas.id=utang_piutang_bayar.buku_kas_id and utang_piutang.u_p='Piutang' group by utang_piutang_id order by utang_piutang.tgl_input DESC");

  $no=0;
  while ($data = mysqli_fetch_array($query)) { 
  $no++;
  ?>
  <tr>
    <td><?php echo "PI".$data['id_up'];;  ?></td>
    
    <td><?php echo $data['nama_kategori']; ?></td>
    <td><?php echo $data['klien']; ?></td>
    
      <td><?php echo $data['deskripsi']; ?></td>
      <td><?php echo "Rp ".number_format($data['nominal_up'],2,',','.'); ?>
      <font style="font-size:12px">
	  <?php if ($data['jatuh_tempo']!=0000-00-00){
		  echo "<br>Jatuh Tempo : ".date("d M Y",strtotime($data['jatuh_tempo']));
		  } ?>
          </font>
      </td>
      <td>
      <?php
      $dd = mysqli_fetch_array(mysqli_query($koneksi, "select * from utang_piutang_bayar where utang_piutang_id=$data[id_up] order by tgl_bayar DESC LIMIT 1"));
	  echo date("d/m/y",strtotime($dd['tgl_bayar']))." : Rp".number_format($dd['nominal'],2,',','.');
	  ?>
      <br />
      <font style="font-size:11px"><?php 
	$ddd = mysqli_fetch_array(mysqli_query($koneksi, "select sum(nominal) as nominal_bayar from utang_piutang_bayar where utang_piutang_id=$data[id_up]"));
	echo "Total Pembayaran : Rp".number_format($ddd['nominal_bayar'],2,',','.'); ?></font></td>
      <td><?php if ($data['status_lunas']==0){echo "Belum Lunas";}else {echo "Sudah Lunas";} ?></td>
    <!--<td></td>
    <td><?php echo $data['no_bath']; ?></td>
    <td><?php echo $data['no_lot']; ?></td>-->
    <?php if ($data['stok_total']==0) { $color="red"; } else { $color=""; } ?>
    </tr>
  
  <?php } ?>
</table>	
              </div>
            </div>
          </div>
          </section>
          
      </div>
      <!-- /.row (main row) -->

  </section>
    <!-- /.content -->
  </div>
 

<div id="openPilihan" class="modalDialog">
     <div>
        <a href="#" title="Close" class="close">X</a>
        <br />
        <a href="index.php?page=jual_barang2&id=<?php echo $_GET['id']; ?>"><button id="buttonn">Data Dinas/RS/Puskesmas/Klinik Baru</button></a>
        <a href="index.php?page=jual_barang3&id=<?php echo $_GET['id']; ?>"><button id="buttonn">Dari Data Dinas/RS/Puskesmas/Klinik<br />Yang Sudah Terinput</button></a>
    </div>
</div>
<script type="text/javascript" src="chartjs/Chart.js"></script>
<script>
		var ctx = document.getElementById("myChart").getContext('2d');
		var myChart = new Chart(ctx, {
			type: 'bar',
			data: {
				labels: ["Pengeluaran", "Pemasukan"],
				datasets: [{
					label: '',
					data: [
					<?php 
					echo $utang['jumlah'];
					?>, 
					<?php 
					echo $piutang['jumlah'];
					?>
					],
					backgroundColor: [
					'rgba(255, 99, 132, 0.2)',
					'rgba(75, 192, 192, 0.2)'
					],
					borderColor: [
					'rgba(255,99,132,1)',
					'rgba(75, 192, 192, 1)'
					],
					borderWidth: 1
				}]
			},
			options: {
				scales: {
					yAxes: [{
						ticks: {
							beginAtZero:true
						}
					}]
				}
			}
		});
	</script>


