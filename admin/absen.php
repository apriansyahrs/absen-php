<?php require "../config.php"; ?>
<div class="row d-flex justify-content-center">
    <div class="col-lg-6">
        <div class="card">
            <div class="card-header">
                Absen Masuk Manual Karyawan
            </div>
            <form id="formAbsenManualKaryawan">
                <div class="card-body">
                    <div class="form-group">
                        <label for="id_guru">Pilih karyawan <span></span></label>
                        <select name="id_karyawan" id="id_karyawan" class="custom-select" required>
                            <option value="" disabled selected hidden>Pilih Karyawan</option>
                            <?php
                            $result = mysqli_query($conn, "SELECT id_karyawan,nip,nama FROM tb_karyawan");
                            foreach ($result as $tb_karyawan) {
                                echo '<option value="' . $tb_karyawan['id_karyawan'] . '">' . $tb_karyawan['nip'] . ' - ' . $tb_karyawan['nama'] . '</option>';
                            } ?>
                        </select>
                    </div>
                    <input type="hidden" name="latitude" id="latitude_k">
                    <input type="hidden" name="longitude" id="longitude_k">
                    <div class="form-group mb-0" style="color: #1e3056;">
                        <label>Pilih salah satu alasan dibawah.</label>
                    </div>
                    <div class="form-group">
                        <label class="btn btn-radio">Hadir
                            <input type="radio" class="d-none" name="m_alasan" id="btn-radio-hadir" value="hadir">
                        </label>
                        <label class="btn btn-radio">Izin
                            <input type="radio" class="d-none" name="m_alasan" id="btn-radio-izin" value="izin">
                        </label>
                        <label class="btn btn-radio">Sakit
                            <input type="radio" class="d-none" name="m_alasan" id="btn-radio-sakit" value="sakit">
                        </label>
                        <label class="btn btn-radio">Terlambat
                            <input type="radio" class="d-none" name="m_alasan" id="btn-radio-terlambat" value="terlambat">
                        </label>
                    </div>
                    <div class="form-group">
                        <label>Tulis keterangan</label>
                        <textarea name="m_ket" id="m_ket" rows="3" class="form-control form-control2" placeholder="Berikan keterangan..." required="">Hadir</textarea>
                    </div>
                </div>
                <div class="card-footer text-right">
                    <button type="submit" class="btn btn-linear-primary waves-effect waves-light">
                        Simpan
                    </button>
                </div>
            </form>
        </div>
    </div>
    <div class="col-lg-6">
        <div class="card">
            <div class="card-header">
                Absen Masuk Manual Guru
            </div>
            <form id="formAbsenManualGuru">
                <div class="card-body">
                    <div class="form-group">
                        <label for="id_guru">Pilih karyawan <span></span></label>
                        <select name="id_guru" id="id_guru_a" class="custom-select" required>
                            <option value="" disabled selected hidden>Pilih Guru</option>
                            <?php
                            $result = mysqli_query($conn, "SELECT id_guru,nip,nama FROM tb_guru");
                            foreach ($result as $tb_guru) {
                                echo '<option value="' . $tb_guru['id_guru'] . '">' . $tb_guru['nip'] . ' - ' . $tb_guru['nama'] . '</option>';
                            } ?>
                        </select>
                    </div>
                    <input type="hidden" name="latitude" id="latitude_g">
                    <input type="hidden" name="longitude" id="longitude_g">
                    <div class="form-group mb-0" style="color: #1e3056;">
                        <label>Pilih salah satu alasan dibawah.</label>
                    </div>
                    <div class="form-group">
                        <label class="btn btn-radio">Hadir
                            <input type="radio" class="d-none" name="m_alasan" id="btn-radio-hadir" value="hadir">
                        </label>
                        <label class="btn btn-radio">Izin
                            <input type="radio" class="d-none" name="m_alasan" id="btn-radio-izin" value="izin">
                        </label>
                        <label class="btn btn-radio">Sakit
                            <input type="radio" class="d-none" name="m_alasan" id="btn-radio-sakit" value="sakit">
                        </label>
                        <label class="btn btn-radio">Terlambat
                            <input type="radio" class="d-none" name="m_alasan" id="btn-radio-terlambat" value="terlambat">
                        </label>
                    </div>
                    <div class="form-group">
                        <label>Tulis keterangan</label>
                        <textarea name="m_ket" id="m_ket" rows="3" class="form-control form-control2" placeholder="Berikan keterangan..." required="">Hadir</textarea>
                    </div>
                </div>
                <div class="card-footer text-right">
                    <button type="submit" class="btn btn-linear-primary waves-effect waves-light">
                        Simpan
                    </button>
                </div>
            </form>
        </div>
    </div>
    <div class="col-lg-12">
        <div class="card">
            <div class="card-header">
                Absen Masuk Manual Siswa
            </div>
            <form id="formAbsenManualSiswa">
                <div class="card-body">
                    <div class="form-group">
                        <label>Pilih guru<span></span></label>
                        <select name="id_guru" id="id_guru" class="custom-select" required>
                            <option value=""></option>
                            <?php
                            $result = mysqli_query($conn, "SELECT id_guru,nip,nama FROM tb_guru");
                            foreach ($result as $tb_guru) {
                                echo "<option value='$tb_guru[id_guru]'>$tb_guru[nip] - $tb_guru[nama]</option>";
                            } ?>
                        </select>
                    </div>

                    <div class="form-group">
                        <label>Pilih Kelas<span></span></label>
                        <select name="token_kelas" id="token_kelas" class="custom-select" required></select>
                    </div>


                    <div class="form-group">
                        <label>Pilih Siswa<span></span></label>
                        <select name="id_siswa" id="id_siswa" class="custom-select" required>
                        </select>
                    </div>
                    <input type="hidden" name="latitude" id="latitude_m">
                    <input type="hidden" name="longitude" id="longitude_m">
                    <div class="form-group mb-0" style="color: #1e3056;">
                        <label>Pilih salah satu alasan dibawah.</label>
                    </div>
                    <div class="form-group">
                        <label class="btn btn-radio">Hadir
                            <input type="radio" class="d-none" name="m_alasan" id="btn-radio-hadir" value="hadir">
                        </label>
                        <label class="btn btn-radio">Izin
                            <input type="radio" class="d-none" name="m_alasan" id="btn-radio-izin" value="izin">
                        </label>
                        <label class="btn btn-radio">Sakit
                            <input type="radio" class="d-none" name="m_alasan" id="btn-radio-sakit" value="sakit">
                        </label>
                        <label class="btn btn-radio">Terlambat
                            <input type="radio" class="d-none" name="m_alasan" id="btn-radio-terlambat" value="terlambat">
                        </label>
                    </div>
                    <div class="form-group">
                        <label>Tulis keterangan</label>
                        <textarea name="m_ket" id="m_ket" rows="3" class="form-control form-control2" placeholder="Berikan keterangan..." required="">Hadir</textarea>
                    </div>
                </div>
                <div class="card-footer text-right">
                    <button type="submit" class="btn btn-linear-primary waves-effect waves-light">
                        Simpan
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script src="<?= base_url() ?>/assets/maps/geo-min.js"></script>

<script>
    function select(id, placeholder) {
        $('#' + id).select2({
            theme: 'bootstrap4',
            placeholder: placeholder
        });
    }

    select('id_guru', 'Pilih Guru');
    select('token_kelas', 'Pilih Kelas');

    select('id_guru_a', 'Pilih Guru');
    select('id_karyawan', 'Pilih Karyawan');
    select('id_siswa', 'Pilih Siswa');

    $(document).ready(function() {
        if (geo_position_js.init()) {
            geo_position_js.getCurrentPosition(success_callback, error_callback, {
                enableHighAccuracy: true
            });
        } else {
            pesan('Tidak ada fungsi geolocation', 3000);
            return false;
        }

        function success_callback(p) {
            latitude = p.coords.latitude;
            longitude = p.coords.longitude;
            $('#latitude_k').val(latitude);
            $('#longitude_k').val(longitude);
            $('#latitude_g').val(latitude);
            $('#longitude_g').val(longitude);
            $('#latitude_m').val(latitude);
            $('#longitude_m').val(longitude);
        }

        function error_callback(p) {
            pesan('error = ' + p.message, 3000);
            return false;
        }

        $('input[type="radio"]').change(function() {
            // Hapus kelas 'active' dari semua label
            $('label').removeClass('active');

            // Periksa radio button mana yang sedang dicentang (checked)
            $('input[type="radio"]:checked').each(function() {
                // Tambahkan kelas 'active' pada label terkait
                $(this).closest('label').addClass('active');
            });
        });

        // Jika radio button sudah tercentang pada saat halaman dimuat, tambahkan kelas 'active' pada label yang sesuai
        $('input[type="radio"]:checked').each(function() {
            $(this).closest('label').addClass('active');
        });
    });

    $('#formAbsenManualKaryawan').submit(function(e) {
        e.preventDefault();
        $.ajax({
            type: 'post',
            url: 'aksi?absen_masuk_karyawan',
            data: new FormData(this),
            contentType: false,
            processData: false,
            cache: false,
            success: function(data) {
                if (data == 'berhasil') {
                    history.pushState('Absen', 'Absen', '?menu=absen');
                    $('#content').load('absen');
                    $('html, body').animate({
                        scrollTop: '0'
                    }, 200);
                    pesan('Absen masuk manual berhasil disimpan', 3000);
                } else {
                    pesan('Absen Gagal ada kesalahan pada sistem', 3000);
                }
            }
        });
    });

    $('#formAbsenManualGuru').submit(function(e) {
        e.preventDefault();
        $.ajax({
            type: 'post',
            url: 'aksi?absen_masuk_guru',
            data: new FormData(this),
            contentType: false,
            processData: false,
            cache: false,
            success: function(data) {
                if (data == 'berhasil') {
                    history.pushState('Absen', 'Absen', '?menu=absen');
                    $('#content').load('absen');
                    $('html, body').animate({
                        scrollTop: '0'
                    }, 200);
                    pesan('Absen masuk manual berhasil disimpan', 3000);
                } else {
                    pesan('Absen Gagal ada kesalahan pada sistem', 3000);
                }
            }
        });
    });

    $('#formAbsenManualSiswa').submit(function(e) {
        e.preventDefault();
        $.ajax({
            type: 'post',
            url: 'aksi?absen_masuk_siswa',
            data: new FormData(this),
            contentType: false,
            processData: false,
            cache: false,
            success: function(data) {
                if (data == 'berhasil') {
                    history.pushState('Absen', 'Absen', '?menu=absen');
                    $('#content').load('absen');
                    $('html, body').animate({
                        scrollTop: '0'
                    }, 200);
                    pesan('Absen masuk manual berhasil disimpan', 3000);
                } else {
                    pesan(data, 3000);
                }
            }
        });
    });

    $('#id_guru').change(function() {
        var id_guru = $(this).val();
        $.ajax({
            type: 'post',
            url: '../guru/change-data?change_token_kelas_admin',
            data: 'id_guru=' + id_guru,
            dataType: 'html',
            success: function(data) {
                $('select#token_kelas').html(data);
            }
        });
    });

    $('#token_kelas').change(function() {
        var id_guru = $('#id_guru').val();
        $.ajax({
            type: 'post',
            url: '../guru/change-data?change_siswa_admin',
            data: 'id_guru=' + id_guru,
            dataType: 'html',
            success: function(data) {
                $('select#id_siswa').html(data);
            }
        });
    });
</script>
