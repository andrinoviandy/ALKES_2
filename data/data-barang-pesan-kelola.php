<?php
include("../config/koneksi.php");
include("../include/API.php");
session_start();
error_reporting(0);
$query = mysqli_query($koneksi, "select *,principle.id as id_principle from barang_pesan,principle where principle.id=barang_pesan.principle_id and barang_pesan.id='" . $_GET['id'] . "'");
$data = mysqli_fetch_array($query);
?>
<div class="table-responsive no-padding">
    <table width="100%" id="example1" class="table table-bordered table-hover">
        <thead>
            <tr>
                <th valign="bottom">No</th>
                <th valign="bottom"><strong>Nama Alkes</strong></th>
                <td align="center" valign="bottom"><strong>Tipe
                    </strong>
                <td align="center" valign="bottom"><strong>Merk
                    </strong>
                <td align="center" valign="bottom"><strong>Qty</strong>
                <td align="center" valign="bottom"><strong>Mata Uang
                    </strong>
                <td align="center" valign="bottom"><strong>Harga Per Unit </strong>
                <td align="center" valign="bottom"><strong>Diskon (%)</strong>
                <td align="center" valign="bottom"><strong>Total Harga
                    </strong>
                <td align="center" valign="bottom"><strong>Catatan Spek</strong>
                <td align="center" valign="bottom"><strong>Aksi</strong>
            </tr>
        </thead>


        <?php

        $no = 0;
        $q_akse = mysqli_query($koneksi, "select *,barang_pesan_detail.id as idd,barang_gudang.id as id_gudang from barang_pesan_detail,barang_gudang,mata_uang where barang_gudang.id=barang_pesan_detail.barang_gudang_id and mata_uang.id=barang_pesan_detail.mata_uang_id and barang_pesan_detail.barang_pesan_id=$_GET[id]");
        $jm = mysqli_num_rows($q_akse);
        if ($jm != 0) {
            while ($data_akse = mysqli_fetch_array($q_akse)) {
                $no++;
        ?>
                <tr>
                    <td><?php echo $no; ?></td>
                    <td><?php echo $data_akse['nama_brg']; ?>
                    </td>
                    <td align="center"><?php echo $data_akse['tipe_brg']; ?></td>
                    <td align="center"><?php echo $data_akse['merk_brg']; ?></td>
                    <td align="center"><?php echo $data_akse['qty']; ?></td>
                    <td align="center"><?php echo $data_akse['jenis_mu']; ?></td>
                    <td align="right"><?php echo $data_akse['simbol'] . number_format($data_akse['harga_perunit'], 2, ',', '.'); ?></td>
                    <td align="center"><?php
                                        if ($data_akse['diskon'] != 0) {
                                            echo $data_akse['diskon'] . " %";
                                        } else {
                                            echo "0 %";
                                        } ?></td>
                    <td align="right"><?php echo $data_akse['simbol'] . number_format($data_akse['harga_total'], 2, ',', '.'); ?></td>
                    <td align="center"><?php echo $data_akse['catatan_spek']; ?></td>
                    <td align="center"><?php if (isset($_SESSION['user_administrator']) or isset($_SESSION['adminpodalam'])) { ?>
                            <table>
                                <tr>
                                    <td>
                                        <!-- <a href="#" data-toggle="modal" data-target="#modal-ubahbarang<?php echo $data_akse['idd']; ?>" class="btn btn-xs btn-info"> -->
                                        <a href="javascript:void()" onclick="modalUbah('<?php echo $data_akse['idd']; ?>','<?php echo $data_akse['qty']; ?>','<?php echo number_format($data_akse['harga_perunit'], 0, ',', '.'); ?>','<?php echo $data_akse['diskon']; ?>')" class="btn btn-xs btn-info">
                                            <span data-toggle="tooltip" title="Ubah" class="fa fa-edit"></span></a>
                                    </td>
                                    <td width="5%"></td>
                                    <td>
                                        <!-- <a href="index.php?page=tambah_po_alkes&id_hapus=<?php echo $data_akse['idd']; ?>&id=<?php echo $_GET['id']; ?>" onclick="return confirm('Yakin Akan Menghapus Item Ini ?')"> -->
                                        <a class="btn btn-xs btn-danger" onclick="hapusData('<?php echo $data_akse['idd']; ?>')">
                                            <span data-toggle="tooltip" title="Hapus" class="ion-android-delete"></span></a>
                                    </td>
                                </tr>
                                <!--&nbsp;&nbsp;&nbsp;<a href="index.php?page=simpan_tambah_aksesoris_pesan&id=<?php echo $data_akse['id_gudang']; ?>"><small data-toggle="tooltip" title="Kelola Aksesoris" class="label bg-green"><span class="fa fa-cogs"></span>&nbsp Akse</small></a>-->
                            </table>
                        <?php } ?>
                    </td>
                </tr>
        <?php }
        } else {
            echo "<tr><td colspan='11' align='center'>Tidak Ada Data</td></tr>";
        } ?>
        <!-- <form id="formSimpan" method="post" onsubmit="simpanData(); return false;"> -->
            <tr>
                <td colspan="8" align="right" valign="bottom">
                    <input type="hidden" name="id_simpan" id="id_simpan" value="<?php echo $_GET['id'] ?>">
                    <strong>Total Price =</strong>
                </td>
                <td colspan="2" align="left">
                    <?php
                    $total = mysqli_fetch_array(mysqli_query($koneksi, "select *,sum(harga_total) as total from barang_pesan_detail where barang_pesan_id=$_GET[id]"));
                    echo number_format($total['total'], 2, ',', '.');
                    //$total = mysqli_query($koneksi, "select * from barang_pesan_detail where barang_pesan_id=$id");
                    //echo " ".number_format($total_akse2+$total['total'],0,',',',').".00";
                    ?>
                    <input name="total_price" id="total_price"  class="form-control" type="hidden" required="required" placeholder="" size="20" value="<?php echo number_format($total['total'], 2, ',', ''); ?>" />
                </td>
                <td align="center"></td>
            </tr>
            <tr>
                <td colspan="8" align="right" valign="bottom"><strong>Total Price + PPN(<?php echo $data['ppn'] == '' ? 0 . "%" : $data['ppn'] . "%"; ?>) =</strong></td>
                <td colspan="2" align="left">
                    <?php echo number_format(($total['total']) + (($total['total']) * floatval($data['ppn']) / 100), 2, ',', '.'); ?>
                    <input name="total_price_ppn" id="total_price_ppn" class="form-control" type="hidden" required="required" placeholder="" size="20" value="<?php echo number_format(($total['total']) + (($total['total']) * floatval($data['ppn']) / 100), 2, ',', ''); ?>" />
                </td>
                <td align="center"></td>
            </tr>
            <tr>
                <td colspan="8" align="right" valign="bottom"><strong>Freight Cost by Air to JAKARTA =</strong></td>
                <td colspan="2" align="left" valign="top"><input name="cost_byair" id="cost_byair" class="form-control" type="text" required="required" value="<?php
                                                                                                                                                                // if ($data['cost_byair'] != 0) {
                                                                                                                                                                    echo $data['cost_byair'];
                                                                                                                                                                //} ?>" placeholder="Isi 0 Jika Tidak Ada Ongkir" size="20" onkeyup="sum_total_keseluruhan();" /></td>
                <td align="center"></td>
            </tr>
            <tr>
                <td height="24" colspan="8" align="right" valign="bottom"><strong>Total Keseluruhan =</strong></td>
                <td colspan="2" align="left" valign="top"><input name="cost_cf" id="cost_cf" class="form-control" type="text" readonly value="<?php echo $data['cost_cf']; ?>" placeholder="" size="20" onkeyup="sum_total_keseluruhan();" /></td>
                <td align="center"></td>
            </tr>
            <tr>
                <td height="24" colspan="8" align="right" valign="bottom">Nilai Tukar (satuan dalam rupiah) =</td>
                <td colspan="2" align="left" valign="top"><input id="nilai_tukar" name="nilai_tukar" class="form-control" type="text" readonly="readonly" value="1" placeholder="" size="20" onkeyup="sum_total_keseluruhan();" /></td>
                <td align="center"></td>
            </tr>
            <tr>
                <td height="24" colspan="8" align="right" valign="bottom"><strong>Total Keseluruhan</strong> (Rupiah) =</td>
                <td colspan="2" align="left" valign="top"><?php
                                                            $mu = mysqli_fetch_array(mysqli_query($koneksi, " select * from utang_piutang where no_faktur_no_po='" . $data['no_po_pesan'] . "'"));
                                                            if ($mu['nominal'] != 0) {
                                                                $total_rupiah = $mu['nominal'];
                                                            }
                                                            ?>
                    <input name="dalam_rupiah" id="dalam_rupiah" type="text" required class="form-control" value="<?php echo $total_rupiah; ?>" placeholder="Auto" size="20" readonly="readonly" />
                </td>
                <td align="center"></td>
            </tr>
        <!-- </form> -->
    </table>
</div>
<script>
    $(function() {
        $('#example1').DataTable()
        $('#example2').DataTable({
            'paging': false,
            'lengthChange': false,
            'searching': true,
            'ordering': false,
            'info': false,
            'autoWidth': true
        })
        $('#example3').DataTable({
            'paging': true,
            'lengthChange': false,
            'searching': false,
            'ordering': true,
            'info': false,
            'autoWidth': true
        })
        $('#example5').DataTable({
            'paging': false,
            'lengthChange': false,
            'searching': true,
            'ordering': true,
            'info': true,
            'autoWidth': true
        })
        $('#example4').DataTable()
    })
</script>