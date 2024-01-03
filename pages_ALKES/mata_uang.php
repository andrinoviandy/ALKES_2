<?php
if (isset($_GET['id_hapus'])) {
	$delete = mysqli_query($koneksi, "delete from mata_uang where id=".$_GET['id_hapus']."");
	if ($delete) {
		echo "<script>window.location='index.php?page=mata_uang'</script>";
		}
	else {
		echo "<script type='text/javascript'>alert('Tidak Dapat Dihapus !');
		window.location='index.php?page=mata_uang';
		</script>";
		}
	}
?>
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Mata Uang
        
      </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">Pengaturan</li>
        <li class="active">Mata Uang</li>
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
          <div class="box box-success">
          <div class="box-footer">
            <div class="box-body">
              <div class="">
              <a href="index.php?page=tambah_mata_uang"><input type="submit" name="button" id="button" value="Tambah Mata Uang" class="btn btn-success"/></a><br /><br />
              <!--
              <form method="post">
              <div class="input-group pull pull-left col-xs-1">
                
                <select class="form-control" name="limiterr" style="margin-right:40px">
                <option <?php if ($limiter['limiter']==10) {echo "selected";} ?> value="10">10</option>
                <option <?php if ($limiter['limiter']==50) {echo "selected";} ?> value="50">50</option>
                <option <?php if ($limiter['limiter']==100) {echo "selected";} ?> value="100">100</option>
                <option <?php if ($limiter['limiter']==500) {echo "selected";} ?> value="500">500</option>
                <option <?php if ($limiter['limiter']==1000) {echo "selected";} ?> value="1000">1000</option>
                <?php 
				$total=mysqli_num_rows(mysqli_query($koneksi, "select * from barang_gudang"));
				?>
                <option <?php if ($limiter['limiter']==$total) {echo "selected";} ?> <?php if ($_POST['cari']!='') {echo "selected";} ?> value="<?php echo $total; ?>">All</option>
                </select>
                
                <span class="input-group-btn">
                      <button type="submit" name="button_limit" class="btn btn-default btn-flat"><i class="fa fa-check"></i></button>
                    </span>
                
              </div>
              </form>
              
              <form method="post">
              <div class="input-group pull pull-left col-xs-2">
                
                <select class="form-control" name="urutt" style="margin-right:40px">
                <option <?php if ($limiter['urut']=='ASC') {echo "selected";} ?> value="ASC">Ascending</option>
                <option <?php if ($limiter['urut']=='DESC') {echo "selected";} ?> value="DESC">Descending</option>
                
                </select>
                
                <span class="input-group-btn">
                      <button type="submit" name="button_urut" class="btn btn-default btn-flat"><i class="fa fa-check"></i></button>
                    </span>
                
              </div>
              </form>
              
              <form method="post" class="">
              <div class="input-group input-group-md col-xs-4 pull pull-right">
                <input type="text" name="cari" placeholder="Keyword....." class="form-control">
                    <span class="input-group-btn">
                      <button type="submit" name="button_cari" class="btn btn-info btn-flat"><i class="fa fa-search"></i> Cari </button>
                    </span>
              </div>
              </form>
              -->
              <br />
                <div class="table-responsive">
                <table width="100%" id="example1" class="table table-bordered table-hover">
  <thead>
    <tr>
      <td width="5%" align="center">&nbsp;</td>
      <td width="16%"><strong>Mata Uang<span class="active"></span></strong></td>
      <td width="12%"><strong>Simbol</strong></td>
      <td width="14%"><strong>Negara</strong></td>
      <td width="22%"><strong>Satuan Dalam Rupiah</strong></td>
      <td width="14%"><strong>Exp Time</strong></td>
      <td width="17%" align="center"><strong>Aksi</strong></td>
     
      </tr>
  </thead>
  <?php
	  $query = mysqli_query($koneksi, "select * from mata_uang");
  $no=0;
  while ($data = mysqli_fetch_assoc($query)) { 
  $no++;
  ?>
  <tr>
    <td align="center"><?php echo $no; ?></td>
    <td><?php echo $data['jenis_mu']; ?></td>
    <td><?php echo $data['simbol']; ?></td>
    <td><?php echo $data['negara_mu']; ?></td>
    <td><?php echo "Rp".number_format($data['dalam_rupiah'],2,',','.'); ?></td>
    <td><?php echo date("d F Y",strtotime($data['exp_time'])); ?></td>
    <td align="center">
      <a href="index.php?page=mata_uang&id_hapus=<?php echo $data['id']; ?>" onclick="return confirm('Anda Yakin Akan Menghapus Item Ini ?')"><span data-toggle="tooltip" title="Hapus" class="ion-android-delete"></span></a> &nbsp;&nbsp;
      <a href="index.php?page=ubah_mata_uang&id=<?php echo $data['id']; ?>"><span data-toggle="tooltip" title="Ubah" class="fa fa-edit"></span></a> &nbsp;&nbsp; 
    </td>
    
  </tr>
  <?php } ?>
</table>
                </div>
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