<?php
include("../config/koneksi.php");
include("../include/API.php");
session_start();
error_reporting(0);
?>
<input type="hidden" id="id_ubah_ns" value="<?php echo $_GET['id_ubah']; ?>">
<input type="hidden" id="id_gudang_ns" value="<?php echo $_GET['id_gudang']; ?>">
<select name="no_seri_ubah" id="no_seri_ubah" class="form-control select2" data-placeholder="Cari No Seri" style="width:100%;">
    <?php
    $file = file_get_contents($API . "json/isi_no_seri.php?id=$_GET[id_gudang]");
    $json = json_decode($file, true);
    $jml = count($json);
    ?>
    <?php
    for ($i = 0; $i < $jml; $i++) {
    ?>
        <option <?php if ($json[$i]['selisih_hari'] < 0 && $json[$i]['tgl_expired'] != '0000-00-00') {
                    echo "disabled";
                } ?> value="<?php echo $json[$i]['idd']; ?>"><?php echo $json[$i]['no_seri_brg'];
                                                                if ($json[$i]['selisih_hari'] < 180 && $json[$i]['tgl_expired'] != '0000-00-00' && $json[$i]['selisih_hari'] >= 0) {
                                                                    echo " @ Expired < 6 Bulan (" . date('d/m/Y', strtotime($json[$i]['tgl_expired'])) . ")";
                                                                } else {
                                                                    if ($json[$i]['selisih_hari'] < 0) {
                                                                        echo " @ Sudah Expired (" . date('d/m/Y', strtotime($json[$i]['tgl_expired'])) . ")";
                                                                    }
                                                                }
                                                                ?>
        </option>
    <?php } ?>
</select>

<!-- Select2 -->
<script src="../bower_components/select2/dist/js/select2.full.min.js"></script>
<script>
    $(function() {
        //Initialize Select2 Elements
        $('.select2').select2()

        //Datemask dd/mm/yyyy
        $('#datemask').inputmask('dd/mm/yyyy', {
            'placeholder': 'dd/mm/yyyy'
        })
        //Datemask2 mm/dd/yyyy
        $('#datemask2').inputmask('mm/dd/yyyy', {
            'placeholder': 'mm/dd/yyyy'
        })
        //Money Euro
        $('[data-mask]').inputmask()

        //Date range picker
        $('#reservation').daterangepicker()
        //Date range picker with time picker
        $('#reservationtime').daterangepicker({
            timePicker: true,
            timePickerIncrement: 30,
            format: 'MM/DD/YYYY h:mm A'
        })
        //Date range as a button
        $('#daterange-btn').daterangepicker({
                ranges: {
                    'Today': [moment(), moment()],
                    'Yesterday': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
                    'Last 7 Days': [moment().subtract(6, 'days'), moment()],
                    'Last 30 Days': [moment().subtract(29, 'days'), moment()],
                    'This Month': [moment().startOf('month'), moment().endOf('month')],
                    'Last Month': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
                },
                startDate: moment().subtract(29, 'days'),
                endDate: moment()
            },
            function(start, end) {
                $('#daterange-btn span').html(start.format('MMMM D, YYYY') + ' - ' + end.format('MMMM D, YYYY'))
            }
        )

        //Date picker
        $('#datepicker').datepicker({
            autoclose: true
        })

        //iCheck for checkbox and radio inputs
        $('input[type="checkbox"].minimal, input[type="radio"].minimal').iCheck({
            checkboxClass: 'icheckbox_minimal-blue',
            radioClass: 'iradio_minimal-blue'
        })
        //Red color scheme for iCheck
        $('input[type="checkbox"].minimal-red, input[type="radio"].minimal-red').iCheck({
            checkboxClass: 'icheckbox_minimal-red',
            radioClass: 'iradio_minimal-red'
        })
        //Flat red color scheme for iCheck
        $('input[type="checkbox"].flat-red, input[type="radio"].flat-red').iCheck({
            checkboxClass: 'icheckbox_flat-green',
            radioClass: 'iradio_flat-green'
        })

        //Colorpicker
        $('.my-colorpicker1').colorpicker()
        //color picker with addon
        $('.my-colorpicker2').colorpicker()

        //Timepicker
        $('.timepicker').timepicker({
            showInputs: false
        })
    })
</script>