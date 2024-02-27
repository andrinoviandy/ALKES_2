<?php
$query = mysqli_query($koneksi, "select *,principle.id as id_principle from barang_pesan,principle where principle.id=barang_pesan.principle_id and barang_pesan.id='" . $_GET['id'] . "'");
$data = mysqli_fetch_array($query);
?>
<script type="text/javascript">
  function sum_total_keseluruhan() {
    var txtFirstNumberValue = document.getElementById('total_price_ppn').value;
    var txtSecondNumberValue = document.getElementById('cost_byair').value;
    var txtFourNumberValue = document.getElementById('nilai_tukar').value;
    var result = parseFloat(txtFirstNumberValue) + parseFloat(txtSecondNumberValue);
    var total_rupiah = parseFloat(result) * parseFloat(txtFourNumberValue);
    if (!isNaN(result)) {
      document.getElementById('cost_cf').value = result;
      document.getElementById('dalam_rupiah').value = total_rupiah;
      document.getElementById('nominal').value = total_rupiah;
    }
  }

  function sum_total_rupiah() {
    var txtFirstNumberValue = document.getElementById('nilai_tukar').value;
    var txtSecondNumberValue = document.getElementById('cost_cf').value;
    var result = parseFloat(txtFirstNumberValue) * parseFloat(txtSecondNumberValue);
    if (!isNaN(result)) {
      document.getElementById('dalam_rupiah').value = result;
    }
  }
</script>
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <section class="content-header">
    <h1>Kelola Data Alkes</h1>
    <ol class="breadcrumb">
      <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
      <li class="active">Tambah Pesanan Alkes</li>
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
        <div class="box box-success"><!-- /.chat -->
          <div class="box-footer">
            <div class="box-body table-responsive no-padding">
              <div class="">
                <!--<a href="index.php?page=tambah_barang_masuk"><button name="tambah_laporan" class="btn btn-success" type="submit"><span class="fa fa-plus"></span> Tambah Barang</button></a>-->
                <div class="table-responsive no-padding">
                  <table width="100%" id="" class="table table-bordered text-nowrap">
                    <thead>
                      <tr>
                        <th valign="bottom"><strong>Tgl PO</strong></th>
                        <th valign="bottom">No. PO</th>
                        <th valign="bottom"><strong>Nama_Principle</strong></th>
                        <th valign="bottom">Alamat_Principle</th>
                        <th valign="bottom"><strong>PPN</strong></th>
                        <th valign="bottom"><strong>Cara_Pembayaran</strong></th>
                        <th valign="bottom">Alamat_Pengiriman</th>
                        <th valign="bottom">Jalur_Pengiriman</th>
                        <th valign="bottom">Estimasi_Pengiriman</th>
                        <th valign="bottom">Catatan</th>
                      </tr>
                    </thead>
                    <tr>
                      <td><?php echo date("d F Y", strtotime($data['tgl_po'])); ?>
                      </td>
                      <td><?php echo $data['no_po_pesan']; ?></td>
                      <td><?php echo $data['nama_principle']; ?></td>
                      <td><?php echo str_replace("\n", "<br>", $data['alamat_principle']); ?></td>
                      <td><?php echo $data['ppn'] . " %"; ?></td>
                      <td><?php echo $data['cara_pembayaran']; ?></td>
                      <td><?php echo str_replace("\n", "<br>", $data['alamat_pengiriman']); ?></td>
                      <td><?php echo $data['jalur_pengiriman']; ?></td>
                      <td><?php
                          if ($data['estimasi_pengiriman'] == 0000 - 00 - 00) {
                            echo "-";
                          } else {
                            echo date("d F Y", strtotime($data['estimasi_pengiriman']));
                          } ?></td>
                      <td><?php echo $data['catatan']; ?></td>
                    </tr>
                  </table>
                </div>
                <br />
                <button class="btn btn-success pull pull-right" data-toggle="modal" data-target="#modal-tambahbarang"><span class="fa fa-plus"></span> Tambah Barang</button>
                <br /><br />
                <div id="data-barang-pesan"></div>
                <center>
                  <?php if (isset($_SESSION['user_administrator']) or isset($_SESSION['adminpodalam'])) { ?>
                    <!-- <a href="index.php?page=tambah_po_alkes&simpan_barang=1&id=<?php echo $_GET['id']; ?>"> -->
                    <button name="simpan_barang" onclick="simpanData(); return false;" class="btn btn-success" type="button"><span class="fa fa-check"></span> Simpan</button>
                    <!-- </a> -->
                  <?php } ?>
                </center>
              </div>
            </div>
          </div>
        </div>
        <!-- /.box (chat box) -->

        <!-- TO DO List --><!-- /.box -->

        <!-- quick email widget -->
      </section>
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

<div class="modal fade" id="modal-tambahbarang">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" align="center">Tambah Barang</h4>
      </div>
      <form id="formTambah" method="post" onsubmit="tambahData(); return false;">
        <div class="modal-body">
          <input name="id" type="hidden" value="<?php echo $_GET['id'] ?>">
          <label>Alkes</label>
          <select name="id_akse" id="id_akse" class="form-control select2" autofocus="autofocus" required onchange="changeValue(this.value)" style="width:100%">
            <option value="">...</option>
            <?php
            $q = mysqli_query($koneksi, "select * from barang_gudang order by nama_brg ASC");
            $jsArray = "var dtBrg = new Array();
            ";
            while ($d = mysqli_fetch_array($q)) { ?>
              <option value="<?php echo $d['id']; ?>"><?php echo $d['nama_brg'] . " - " . $d['tipe_brg']; ?></option>
            <?php
              $jsArray .= "dtBrg['" . $d['id'] . "'] = {tipe_akse:'" . addslashes($d['tipe_brg']) . "',
                merk_akse:'" . addslashes($d['merk_brg']) . "'
              };";
            } ?>

          </select><br /><br />
          <label>Tipe</label>
          <input id="tipe_akse" name="tipe_akse" class="form-control" type="text" placeholder="Tipe" disabled="disabled" />
          <br />
          <label>Merk</label>
          <input id="merk_akse" name="merk_akse" class="form-control" type="text" placeholder="Merk" disabled="disabled" />
          <br />
          <label>Kuantitas</label>
          <input id="qty" required="required" name="qty" class="form-control" type="text" placeholder="Qty" size="2" />
          <br />
          <label>Mata Uang</label>
          <input type="hidden" name="mata_uang_id" value="<?php echo $data['mata_uang_id']; ?>">
          <input name="mata" class="form-control" type="text" placeholder="Mata Uang" disabled="disabled" value="<?php
                                                                                                                  $q_uang = mysqli_fetch_array(mysqli_query($koneksi, "select * from mata_uang where id=" . $data['mata_uang_id'] . ""));
                                                                                                                  echo $q_uang['jenis_mu'];
                                                                                                                  ?>" />
          <br />
          <label>Harga Satuan</label>
          <input id="harga_perunit" name="harga_perunit" class="form-control" type="text" required="required" size="10" placeholder="Harga Perunit" onkeydown="return numbersonly(this, event);" onkeyup="javascript:tandaPemisahTitik(this);" />
          <br />
          <label>Diskon (%)</label>
          <input id="diskon" name="diskon" class="form-control" type="text" placeholder="Diskon" required="required" size="5" />
          <br />
          <label>Catatan Spek</label>
          <textarea name="catatan_spek" class="form-control" placeholder="Catatan Spek"></textarea>
          <br />
          <script type="text/javascript">
            <?php
            echo $jsArray;
            ?>

            function changeValue(id_akse) {
              document.getElementById('tipe_akse').value = dtBrg[id_akse].tipe_akse;
              document.getElementById('merk_akse').value = dtBrg[id_akse].merk_akse;

            };
          </script>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Close</button>
          <?php if (isset($_SESSION['user_administrator']) or isset($_SESSION['adminpodalam'])) { ?>
            <button name="simpan_tambah_aksesoris" class="btn btn-success" type="submit">
              <span class="fa fa-plus"></span> Simpan</button>
          <?php } ?>
        </div>
      </form>
    </div>
    <!-- /.modal-content -->
  </div>
  <!-- /.modal-dialog -->
</div>

<div class="modal fade" id="modal-ubahbarang">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" align="center">Ubah Barang</h4>
      </div>
      <form id="formUbah" method="post" onsubmit="ubahData(); return false;">
        <div class="modal-body">
          <input id="id" name="id" type="hidden" value="<?php echo $_GET['id'] ?>">
          <input type="hidden" name="id_ubah" id="id_ubah" />
          <label>Qty</label>
          <input name="qty2" id="qty2" class="form-control" type="text" required placeholder="" value="<?php echo $data_akse['qty']; ?>" autofocus>
          <br />
          <label>Harga Per Unit</label>
          <input name="harga_perunit2" id="harga_perunit2" class="form-control" type="text" required onkeydown="return numbersonly(this, event);" onkeyup="javascript:tandaPemisahTitik(this);" placeholder="">
          <br />
          <label>Diskon (%)</label>
          <input name="diskon2" id="diskon2" class="form-control" type="text" required placeholder="">
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Close</button>
          <button name="tambah_laporan" class="btn btn-success" type="submit"><span class="fa fa-check"></span> Simpan</button>
          <!-- <script type="text/javascript">
                                        function sum<?php echo $data_akse['idd']; ?>() {
                                            var txtFirstNumberValue = document.getElementById('qty<?php echo $data_akse['idd']; ?>').value;
                                            var txtSecondNumberValue = document.getElementById('harga_perunit<?php echo $data_akse['idd']; ?>').value;
                                            var txtThirdNumberValue = document.getElementById('diskon<?php echo $data_akse['idd']; ?>').value;
                                            var result = parseFloat(txtFirstNumberValue) * parseFloat(txtSecondNumberValue) - (parseFloat(txtFirstNumberValue) * parseFloat(txtSecondNumberValue) * (parseFloat(txtThirdNumberValue) / 100));
                                            if (!isNaN(result)) {
                                                document.getElementById('total_harga<?php echo $data_akse['idd']; ?>').value = result;
                                            }
                                        }
                                    </script> -->
        </div>
      </form>
    </div>
    <!-- /.modal-content -->
  </div>
  <!-- /.modal-dialog -->
</div>

<script>
  function dataBarang() {
    $.get("data/data-barang-pesan-kelola.php", {
        id: <?php echo $_GET['id']; ?>
      },
      function(data) {
        $('#data-barang-pesan').html(data);
      }
    );
  }

  function modalUbah(id, qty, harga, diskon) {
    $('#id_ubah').val(id);
    $('#qty2').val(qty);
    $('#harga_perunit2').val(harga);
    $('#diskon2').val(diskon);
    $('#modal-ubahbarang').modal('show');
  }

  function simpanData() {
    showLoading(1);
    $.post("data/simpan-barang-kelola.php", {
        id: $('#id_simpan').val(),
        dalam_rupiah: $('#dalam_rupiah').val(),
        total_price: $('#total_price').val(),
        total_price_ppn: $('#total_price_ppn').val(),
        cost_byair: $('#cost_byair').val(),
        cost_cf: $('#cost_cf').val(),
        nilai_tukar: $('#nilai_tukar').val()
      },
      function(data) {
        showLoading(0);
        if (data == 'S') {
          Swal.fire({
            customClass: {
              confirmButton: 'bg-green',
              cancelButton: 'bg-white',
            },
            title: 'Berhasil Di Simpan !',
            text: 'Data Sukses Disimpan',
            icon: 'success',
            showCancelButton: false,
            confirmButtonText: 'Ok',
            allowOutsideClick: false,
          }).then((result) => {
            if (result.isConfirmed) {
              window.location.href = 'index.php?page=ubah_pembelian_alkes&id=<?php echo $_GET['id'] ?>';
            }
          })
        } else {
          alertSimpan('F')
        }
      }
    );
  }

  function tambahData() {
    var dataform = $('#formTambah')[0];
    var data = new FormData(dataform);
    $.ajax({
      type: "post",
      url: "data/tambah-barang-kelola.php",
      data: data,
      enctype: "multipart/form-data",
      contentType: false,
      processData: false,
      success: function(response) {
        if (response == 'S') {
          $('#modal-tambahbarang').modal('hide');
          dataform.reset();
          dataBarang();
          alertSimpan('S')
        } else {
          alertSimpan('F')
        }
      }
    });
  }

  function ubahData(id) {
    var dataform = $('#formUbah')[0];
    var data = new FormData(dataform);
    $.ajax({
      type: "post",
      url: "data/ubah-barang-kelola.php",
      data: data,
      enctype: "multipart/form-data",
      contentType: false,
      processData: false,
      success: function(response) {
        if (response == 'S') {
          $('#modal-ubahbarang').modal('hide');
          dataform.reset();
          dataBarang();
          alertSimpan('S')
        } else {
          alertSimpan('F')
        }
      }
    });
  }

  function hapusData(id) {
    Swal.fire({
      customClass: {
        confirmButton: 'bg-red',
        cancelButton: 'bg-white',
      },
      title: 'Yakin Akan Menghapus Item Ini ? ?',
      text: 'Data Akan Dihapus Secara Permanen',
      icon: 'question',
      showCancelButton: true,
      confirmButtonText: 'Ya , Hapus',
      cancelButtonText: 'Batal',
    }).then((result) => {
      if (result.isConfirmed) {
        $.post("data/hapus-barang-kelola.php", {
            id_hapus: id,
            id: <?php echo $_GET['id']; ?>
          },
          function(data) {
            if (data == 'S') {
              dataBarang();
              alertHapus('S');
            } else {
              alertHapus('F');
            }
          }
        );
      }
    })
  }

  $(document).ready(function() {
    dataBarang();
  });
</script>