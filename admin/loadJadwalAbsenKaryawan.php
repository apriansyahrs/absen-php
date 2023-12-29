<?php
require "../config.php";
$j_karyawan = query("SELECT * FROM j_karyawan WHERE id_karyawan = 0 LIMIT 1");
$senin = $j_karyawan['senin'];
$masuk_mulai_senin = $j_karyawan['masuk_mulai_senin'];
$masuk_akhir_senin = $j_karyawan['masuk_akhir_senin'];
$pulang_mulai_senin = $j_karyawan['pulang_mulai_senin'];
$pulang_akhir_senin = $j_karyawan['pulang_akhir_senin'];
$selasa = $j_karyawan['selasa'];
$masuk_mulai_selasa = $j_karyawan['masuk_mulai_selasa'];
$masuk_akhir_selasa = $j_karyawan['masuk_akhir_selasa'];
$pulang_mulai_selasa = $j_karyawan['pulang_mulai_selasa'];
$pulang_akhir_selasa = $j_karyawan['pulang_akhir_selasa'];
$rabu = $j_karyawan['rabu'];
$masuk_mulai_rabu = $j_karyawan['masuk_mulai_rabu'];
$masuk_akhir_rabu = $j_karyawan['masuk_akhir_rabu'];
$pulang_mulai_rabu = $j_karyawan['pulang_mulai_rabu'];
$pulang_akhir_rabu = $j_karyawan['pulang_akhir_rabu'];
$kamis = $j_karyawan['kamis'];
$masuk_mulai_kamis = $j_karyawan['masuk_mulai_kamis'];
$masuk_akhir_kamis = $j_karyawan['masuk_akhir_kamis'];
$pulang_mulai_kamis = $j_karyawan['pulang_mulai_kamis'];
$pulang_akhir_kamis = $j_karyawan['pulang_akhir_kamis'];
$jumat = $j_karyawan['jumat'];
$masuk_mulai_jumat = $j_karyawan['masuk_mulai_jumat'];
$masuk_akhir_jumat = $j_karyawan['masuk_akhir_jumat'];
$pulang_mulai_jumat = $j_karyawan['pulang_mulai_jumat'];
$pulang_akhir_jumat = $j_karyawan['pulang_akhir_jumat'];
$sabtu = $j_karyawan['sabtu'];
$masuk_mulai_sabtu = $j_karyawan['masuk_mulai_sabtu'];
$masuk_akhir_sabtu = $j_karyawan['masuk_akhir_sabtu'];
$pulang_mulai_sabtu = $j_karyawan['pulang_mulai_sabtu'];
$pulang_akhir_sabtu = $j_karyawan['pulang_akhir_sabtu'];
$minggu = $j_karyawan['minggu'];
$masuk_mulai_minggu = $j_karyawan['masuk_mulai_minggu'];
$masuk_akhir_minggu = $j_karyawan['masuk_akhir_minggu'];
$pulang_mulai_minggu = $j_karyawan['pulang_mulai_minggu'];
$pulang_akhir_minggu = $j_karyawan['pulang_akhir_minggu'];

?>

<div class="row">
    <div class="col-md-12 mb-3">
        <div class="form-check form-check-inline">
            <input class="form-check-input" type="checkbox" name="senin" value="1" <?php echo ($senin == 1) ? 'checked' : ''; ?>>
            <label class="form-check-label">Senin</label>
        </div>
        <div class="form-check form-check-inline">
            <input class="form-check-input" type="checkbox" name="selasa" value="1" <?php echo ($selasa == 1) ? 'checked' : ''; ?>>
            <label class="form-check-label">Selasa</label>
        </div>
        <div class="form-check form-check-inline">
            <input class="form-check-input" type="checkbox" name="rabu" value="1" <?php echo ($rabu == 1) ? 'checked' : ''; ?>>
            <label class="form-check-label">Rabu</label>
        </div>
        <div class="form-check form-check-inline">
            <input class="form-check-input" type="checkbox" name="kamis" value="1" <?php echo ($kamis == 1) ? 'checked' : ''; ?>>
            <label class="form-check-label">Kamis</label>
        </div>
        <div class="form-check form-check-inline">
            <input class="form-check-input" type="checkbox" name="jumat" value="1" <?php echo ($jumat == 1) ? 'checked' : ''; ?>>
            <label class="form-check-label">Jumat</label>
        </div>
        <div class="form-check form-check-inline">
            <input class="form-check-input" type="checkbox" name="sabtu" value="1" <?php echo ($sabtu == 1) ? 'checked' : ''; ?>>
            <label class="form-check-label">Sabtu</label>
        </div>
        <div class="form-check form-check-inline">
            <input class="form-check-input" type="checkbox" name="minggu" value="1" <?php echo ($minggu == 1) ? 'checked' : ''; ?>>
            <label class="form-check-label">Minggu</label>
        </div>
    </div>
    <div class="col-md-3 senin">
        <div class="form-group">
            <label for="masuk_mulai">Masuk mulai senin</label>
            <input type="time" name="masuk_mulai_senin" id="masuk_mulai" class="form-control form-control4" value="<?= $masuk_mulai_senin ?>" required>
        </div>
    </div>
    <div class="col-md-3 senin">
        <div class="form-group">
            <label for="masuk_akhir">Masuk akhir senin</label>
            <input type="time" name="masuk_akhir_senin" id="masuk_akhir" class="form-control form-control4" value="<?= $masuk_akhir_senin ?>">
        </div>
    </div>
    <div class="col-md-3 senin">
        <div class="form-group">
            <label for="pulang_mulai">Pulang mulai senin</label>
            <input type="time" name="pulang_mulai_senin" id="pulang_mulai" class="form-control form-control4" value="<?= $pulang_mulai_senin ?>">
        </div>
    </div>
    <div class="col-md-3 senin">
        <div class="form-group">
            <label for="pulang_akhir">Pulang akhir senin</label>
            <input type="time" name="pulang_akhir_senin" id="pulang_akhir" class="form-control form-control4" value="<?= $pulang_akhir_senin ?>">
        </div>
    </div>
    <div class="col-md-3 selasa">
        <div class="form-group">
            <label for="masuk_mulai">Masuk mulai selasa</label>
            <input type="time" name="masuk_mulai_selasa" id="masuk_mulai" class="form-control form-control4" value="<?= $masuk_mulai_selasa ?>">
        </div>
    </div>
    <div class="col-md-3 selasa">
        <div class="form-group">
            <label for="masuk_akhir">Masuk akhir selasa</label>
            <input type="time" name="masuk_akhir_selasa" id="masuk_akhir" class="form-control form-control4" value="<?= $masuk_akhir_selasa ?>">
        </div>
    </div>
    <div class="col-md-3 selasa">
        <div class="form-group">
            <label for="pulang_mulai">Pulang mulai selasa</label>
            <input type="time" name="pulang_mulai_selasa" id="pulang_mulai" class="form-control form-control4" value="<?= $pulang_mulai_selasa ?>">
        </div>
    </div>
    <div class="col-md-3 selasa">
        <div class="form-group">
            <label for="pulang_akhir">Pulang akhir selasa</label>
            <input type="time" name="pulang_akhir_selasa" id="pulang_akhir" class="form-control form-control4" value="<?= $pulang_akhir_selasa ?>">
        </div>
    </div>
    <div class="col-md-3 rabu">
        <div class="form-group">
            <label for="masuk_mulai">Masuk mulai rabu</label>
            <input type="time" name="masuk_mulai_rabu" id="masuk_mulai" class="form-control form-control4" value="<?= $masuk_mulai_rabu ?>">
        </div>
    </div>
    <div class="col-md-3 rabu">
        <div class="form-group">
            <label for="masuk_akhir">Masuk akhir rabu</label>
            <input type="time" name="masuk_akhir_rabu" id="masuk_akhir" class="form-control form-control4" value="<?= $masuk_akhir_rabu ?>">
        </div>
    </div>
    <div class="col-md-3 rabu">
        <div class="form-group">
            <label for="pulang_mulai">Pulang mulai rabu</label>
            <input type="time" name="pulang_mulai_rabu" id="pulang_mulai" class="form-control form-control4" value="<?= $pulang_mulai_rabu ?>">
        </div>
    </div>
    <div class="col-md-3 rabu">
        <div class="form-group">
            <label for="pulang_akhir">Pulang akhir rabu</label>
            <input type="time" name="pulang_akhir_rabu" id="pulang_akhir" class="form-control form-control4" value="<?= $pulang_akhir_rabu ?>">
        </div>
    </div>
    <div class="col-md-3 kamis">
        <div class="form-group">
            <label for="masuk_mulai">Masuk mulai kamis</label>
            <input type="time" name="masuk_mulai_kamis" id="masuk_mulai" class="form-control form-control4" value="<?= $masuk_mulai_kamis ?>">
        </div>
    </div>
    <div class="col-md-3 kamis">
        <div class="form-group">
            <label for="masuk_akhir">Masuk akhir kamis</label>
            <input type="time" name="masuk_akhir_kamis" id="masuk_akhir" class="form-control form-control4" value="<?= $masuk_akhir_kamis ?>">
        </div>
    </div>
    <div class="col-md-3 kamis">
        <div class="form-group">
            <label for="pulang_mulai">Pulang mulai kamis</label>
            <input type="time" name="pulang_mulai_kamis" id="pulang_mulai" class="form-control form-control4" value="<?= $pulang_mulai_kamis ?>">
        </div>
    </div>
    <div class="col-md-3 kamis">
        <div class="form-group">
            <label for="pulang_akhir">Pulang akhir kamis</label>
            <input type="time" name="pulang_akhir_kamis" id="pulang_akhir" class="form-control form-control4" value="<?= $pulang_akhir_kamis ?>">
        </div>
    </div>
    <div class="col-md-3 jumat">
        <div class="form-group">
            <label for="masuk_mulai">Masuk mulai jumat</label>
            <input type="time" name="masuk_mulai_jumat" id="masuk_mulai" class="form-control form-control4" value="<?= $masuk_mulai_jumat ?>">
        </div>
    </div>
    <div class="col-md-3 jumat">
        <div class="form-group">
            <label for="masuk_akhir">Masuk akhir jumat</label>
            <input type="time" name="masuk_akhir_jumat" id="masuk_akhir" class="form-control form-control4" value="<?= $masuk_akhir_jumat ?>">
        </div>
    </div>
    <div class="col-md-3 jumat">
        <div class="form-group">
            <label for="pulang_mulai">Pulang mulai jumat</label>
            <input type="time" name="pulang_mulai_jumat" id="pulang_mulai" class="form-control form-control4" value="<?= $pulang_mulai_jumat ?>">
        </div>
    </div>
    <div class="col-md-3 jumat">
        <div class="form-group">
            <label for="pulang_akhir">Pulang akhir jumat</label>
            <input type="time" name="pulang_akhir_jumat" id="pulang_akhir" class="form-control form-control4" value="<?= $pulang_akhir_jumat ?>">
        </div>
    </div>
    <div class="col-md-3 sabtu">
        <div class="form-group">
            <label for="masuk_mulai">Masuk mulai sabtu</label>
            <input type="time" name="masuk_mulai_sabtu" id="masuk_mulai" class="form-control form-control4" value="<?= $masuk_mulai_sabtu ?>">
        </div>
    </div>
    <div class="col-md-3 sabtu">
        <div class="form-group">
            <label for="masuk_akhir">Masuk akhir sabtu</label>
            <input type="time" name="masuk_akhir_sabtu" id="masuk_akhir" class="form-control form-control4" value="<?= $masuk_akhir_sabtu ?>">
        </div>
    </div>
    <div class="col-md-3 sabtu">
        <div class="form-group">
            <label for="pulang_mulai">Pulang mulai sabtu</label>
            <input type="time" name="pulang_mulai_sabtu" id="pulang_mulai" class="form-control form-control4" value="<?= $pulang_mulai_sabtu ?>">
        </div>
    </div>
    <div class="col-md-3 sabtu">
        <div class="form-group">
            <label for="pulang_akhir">Pulang akhir sabtu</label>
            <input type="time" name="pulang_akhir_sabtu" id="pulang_akhir" class="form-control form-control4" value="<?= $pulang_akhir_sabtu ?>">
        </div>
    </div>
    <div class="col-md-3 minggu">
        <div class="form-group">
            <label for="masuk_mulai">Masuk mulai minggu</label>
            <input type="time" name="masuk_mulai_minggu" id="masuk_mulai" class="form-control form-control4" value="<?= $masuk_mulai_minggu ?>">
        </div>
    </div>
    <div class="col-md-3 minggu">
        <div class="form-group">
            <label for="masuk_akhir">Masuk akhir minggu</label>
            <input type="time" name="masuk_akhir_minggu" id="masuk_akhir" class="form-control form-control4" value="<?= $masuk_akhir_minggu ?>">
        </div>
    </div>
    <div class="col-md-3 minggu">
        <div class="form-group">
            <label for="pulang_mulai">Pulang mulai minggu</label>
            <input type="time" name="pulang_mulai_minggu" id="pulang_mulai" class="form-control form-control4" value="<?= $pulang_mulai_minggu ?>">
        </div>
    </div>
    <div class="col-md-3 minggu">
        <div class="form-group">
            <label for="pulang_akhir">Pulang akhir minggu</label>
            <input type="time" name="pulang_akhir_minggu" id="pulang_akhir" class="form-control form-control4" value="<?= $pulang_akhir_minggu ?>">
        </div>
    </div>
</div>

<script>
    $(document).ready(function() {
        // Sembunyikan semua kolom ketika halaman dimuat
        $('input[type="checkbox"]').each(function() {
            var checkBoxName = $(this).attr('name');

            // Periksa status checkbox pada saat halaman dimuat
            if ($(this).is(':checked')) {
                $('.' + checkBoxName).show().find('input[type="time"]').prop('required', true);
            } else {
                $('.' + checkBoxName).hide().find('input[type="time"]').prop('required', false).val(null);
            }
        });

        // Deteksi perubahan pada checkbox
        $('input[type="checkbox"]').change(function() {
            var checkBoxName = $(this).attr('name');

            // Tampilkan atau sembunyikan kolom berdasarkan status centang pada checkbox
            if ($(this).is(':checked')) {
                $('.' + checkBoxName).show().find('input[type="time"]').prop('required', true);
            } else {
                $('.' + checkBoxName).hide().find('input[type="time"]').prop('required', false).val(null);;
            }
        });
    });

    $('.menit').html('<option value="">Menit</option>');
    for (i = 0; i <= 59; i++) {
        var i = i < 10 ? '0' + i : i;
        $('.menit').append('<option>' + i + '</option>');
    }


    $('#masuk_mulai_jam').change(function() {
        var data = $(this).val();
        $('#data_masuk_mulai_jam').html(data);

        $('#masuk_akhir_jam').html('<option value="">Jam</option>');
        for (i = 0; i <= 23; i++) {
            var i = i < 10 ? '0' + i : i;
            if (data <= i) {
                $('#masuk_akhir_jam').append('<option>' + i + '</option>');
            }
        }
        $('#data_masuk_akhir_jam').html('--');
        $('#data_pulang_mulai_jam').html('--');
        $('#data_pulang_akhir_jam').html('--');
        $('#pulang_mulai_jam').html('<option value="">Jam</option>');
        $('#pulang_akhir_jam').html('<option value="">Jam</option>');
    });

    $('#masuk_mulai_menit').change(function() {
        var data = $('#data_masuk_mulai_menit').html($(this).val());
    });

    $('#masuk_akhir_jam').change(function() {
        var data = $(this).val();
        $('#data_masuk_akhir_jam').html(data);

        $('#pulang_mulai_jam').html('<option value="">Jam</option>');
        for (i = 0; i <= 23; i++) {
            var i = i < 10 ? '0' + i : i;
            if (data <= i) {
                $('#pulang_mulai_jam').append('<option>' + i + '</option>');
            }
        }
        $('#data_pulang_akhir_jam').html('--');
        $('#pulang_akhir_jam').html('<option value="">Jam</option>');
    });

    $('#masuk_akhir_menit').change(function() {
        var data = $('#data_masuk_akhir_menit').html($(this).val());
    });


    $('#pulang_mulai_jam').change(function() {
        var data = $(this).val();
        $('#data_pulang_mulai_jam').html(data);

        $('#pulang_akhir_jam').html('<option value="">Jam</option>');
        for (i = 0; i <= 23; i++) {
            var i = i < 10 ? '0' + i : i;
            if (data <= i) {
                $('#pulang_akhir_jam').append('<option>' + i + '</option>');
            }
        }
        $('#data_pulang_akhir_jam').html('--');
    });

    $('#pulang_mulai_menit').change(function() {
        var data = $('#data_pulang_mulai_menit').html($(this).val());
    });

    $('#pulang_akhir_jam').change(function() {
        var data = $('#data_pulang_akhir_jam').html($(this).val());
    });

    $('#pulang_akhir_menit').change(function() {
        var data = $('#data_pulang_akhir_menit').html($(this).val());
    });
</script>
