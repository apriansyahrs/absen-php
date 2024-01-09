<h4 class="mb-3">Tambah guru</h4>
<div class="row">
    <div class="col-md-7 col-lg-5">
        <div class="card">
            <div class="card-header">
                <button type="button" class="btn btn-light btn-user waves-effect border-0 f-size-18px kembali">
                    <i class="la la-angle-left f-size-18px mr-2"></i>Kembali
                </button>
            </div>
            <form id="formTambahGuru">
                <div class="card-body">
                    <div class="form-group">
                        <input type="text" name="nip" id="nip" class="form-control form-control4" placeholder="NIP Guru" required>
                    </div>
                    <div class="form-group">
                        <input type="text" name="nama" id="nama" class="form-control form-control4" placeholder="Nama lengkap" required>
                    </div>
                    <div class="form-group">
                        <input type="number" name="telegram" id="telegram" class="form-control form-control4" placeholder="Telegram (628)">
                    </div>
                    <div class="form-group">
                        <select name="id_jabatan" id="id_jabatan" class="custom-select custom-select2" required="">
                            <option value="" disabled selected hidden>Pilih Jabatan</option>
                            <?php
                            require "../config.php";
                            $result = mysqli_query($conn, "SELECT * FROM tb_jabatan");
                            foreach ($result as $tb_jabatan) {
                                echo "<option value='$tb_jabatan[id_jabatan]'>$tb_jabatan[jabatan]</option>";
                            } ?>
                        </select>
                    </div>
                    <div class="row">
                        <div class="col-md-6 pr-md-2">
                            <div class="form-group">
                                <input type="password" name="password1" id="password1" class="form-control form-control4" placeholder="Password" required>
                            </div>
                        </div>
                        <div class="col-md-6 pl-md-2">
                            <div class="form-group">
                                <input type="password" name="password2" id="password2" class="form-control form-control4" placeholder="Konfirmasi password" required>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-footer mt-n4">
                    <button type="submit" class="btn btn-linear-primary waves-effect waves-light btn-block" id="btn-daftar">
                        Daftarkan
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    $('.kembali').click(function() {
        $('html, body').animate({
            scrollTop: '0'
        }, 200);
        history.pushState('Guru', 'Guru', '?menu=guru');
        $('#content').load('guru');
    });

    $('#formTambahGuru').submit(function(e) {
        if ($('#password1').val() !== $('#password2').val()) {
            pesan('Konfirmasi password salah', 3000);
            return false;
        }
        $('#btn-daftar').attr('disabled', 'disabled');
        $('#btn-daftar').html('<div class="spinner-border text-white" role="status"></div>');
        e.preventDefault();
        $.ajax({
            type: 'post',
            url: 'aksi?tambah_guru',
            data: new FormData(this),
            contentType: false,
            processData: false,
            cache: false,
            success: function(data) {
                if (data == 'berhasil') {
                    pesan('Akun guru berhasil didaftarkan', 3000);
                    $('#content').load('guru');
                } else if (data == 'tidak tersedia') {
                    pesan('NIP tidak tersedia', 3000);
                } else {
                    pesan(data, 30000);
                }
                $('#btn-daftar').removeAttr('disabled', 'disabled');
                $('#btn-daftar').html('Daftarkan');
            }
        })
    })
</script>
