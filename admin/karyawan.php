<?php require "../config.php";
$result = mysqli_query($conn, "SELECT * FROM tb_karyawan tk JOIN tb_jabatan tj ON tk . id_jabatan = tj . id_jabatan"); ?>
<div class="row">
    <div class="col-md-6 my-auto">
        <h4 class="mb-4">Karyawan keseluruhan</h4>
    </div>
    <div class="col-md-6">
        <div class="text-md-right mb-4 mb-md-0">
            <button type="button" class="btn btn-dark" id="jadwal-absen-karyawan">
                Jadwal absen
            </button>
            <button type="button" class="btn btn-secondary mr-2" id="click-master-jabatan">
                Master Jabatan
            </button>
            <div class="btn-group">
                <button type="button" class="btn btn-success waves-effect waves-light" id="click-import-karyawan">
                    <i class="fa fa-file"></i>
                </button>
                <button type="button" class="btn btn-primary waves-effect waves-light" id="click-tambah-karyawan">
                    <i class="fa fa-plus"></i>
                </button>
            </div>
        </div>
    </div>
</div>
<?php if (mysqli_num_rows($result) == 0) { ?>
    <div class="row d-flex justify-content-center text-center">
        <div class="col-8 col-md-6 col-lg-4 my-5">
            <img src="<?= base_url() ?>/assets/img/undraw_secure_data_0rwp.svg" alt="gambar" class="img-fluid">
            <p class="f-size-22px mt-3 mb-0">Maaf, saat ini data tidak ditemukan!</p>
        </div>
    </div>
<?php } else {
    $j_karyawan = query("SELECT * FROM j_karyawan LIMIT 1"); ?>
    <div class="card">
        <div class="py-2">
            <div class="table-responsive overlay-scrollbars">
                <table class="table table-hover">
                    <thead>
                        <th width="5%" class="text-center">No</th>
                        <th width="10%" class="text-center">Profil</th>
                        <th width="13%">NIP</th>
                        <th width="13%">Nama</th>
                        <th width="15%">Jabatan</th>
                        <th width="15%">Password</th>
                        <th width="10%">Kelamin</th>
                        <th width="14%" class="text-center">Aksi</th>
                    </thead>
                    <tbody>
                        <?php
                        $no = 1;
                        foreach ($result as $tb_karyawan) { ?>
                            <tr>
                                <td class="text-center"><?= $no++ ?></td>
                                <td class="text-center">
                                    <img src="../img/karyawan/<?= $tb_karyawan['profil'] ?>" alt="gambar" class="img-fluid" width="50" height="50">
                                </td>
                                <td><?= $tb_karyawan['nip'] ?></td>
                                <td><?= $tb_karyawan['nama'] ?></td>
                                <td><?= $tb_karyawan['jabatan'] ?></td>
                                <td><?= $tb_karyawan['password'] ?></td>
                                <td><?= $tb_karyawan['jk'] ?></td>
                                <td class="text-center">
                                    <div class="btn-group">
                                        <button type="button" class="btn btn-light border-0 waves-effect lihat" data-id_karyawan="<?= $tb_karyawan['id_karyawan'] ?>">
                                            <i class="fa fa-eye"></i>
                                        </button>
                                        <button type="button" class="btn btn-light border-0 waves-effect edit" data-id_karyawan="<?= $tb_karyawan['id_karyawan'] ?>">
                                            <i class="fa fa-pen"></i>
                                        </button>
                                        <button type="button" class="btn btn-light border-0 waves-effect hapus" data-id_karyawan="<?= $tb_karyawan['id_karyawan'] ?>">
                                            <i class="fa fa-trash"></i>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        <?php }
                        if (mysqli_num_rows($result) == 0) { ?>
                            <tr>
                                <td class="text-center" colspan="7">tidak ada data yang ditampilkan</td>
                            </tr>
                        <?php } ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <script>
        $('.overlay-scrollbars').overlayScrollbars({
            className: "os-theme-dark",
            scrollbars: {
                autoHide: 'l',
                autoHideDelay: 0
            }
        });
    </script>

<?php } ?>

<form id="formImport" enctype="multipart/form-data">
    <div class="modal fade animated zoomIn" id="modalImport" tabindex="-1" role="dialog" aria-labelledby="modalImportLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-body overflow-x-hidden">
                    <div class="form-group text-center">
                        <input type="file" name="file_import" id="file_import" hidden="hidden">
                        <label for="file_import" class="btn-upload waves-effect waves-dark">
                            <img src="<?= base_url() ?>/assets/img/undraw_going_up_ttm5.svg" alt="gambar" class="img-fluid"> <br>
                            <p>Import data menggunakan format <b>csv, ods atau xlsx</b>. <i class="la la-question-circle" data-tooltip="tooltip" title="upload file maksimal 3 mb"></i></p>
                            <a href="#">Pelajari selengkapnya</a>
                        </label>
                    </div>
                    <div class="form-group">
                        <div class="d-none" id="preview-import">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th>Nama file</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td class="nama-file"></td>
                                        <td>
                                            <button type="button" class="btn btn-light btn-sm border-0 waves-effect hapus-preview-import" style="width: 33px; height: 33px;">
                                                <i class="fa fa-trash"></i>
                                            </button>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-modal-false waves-effect" data-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-modal-true waves-effect waves-ripple">Import</button>
                </div>
            </div>
        </div>
    </div>
</form>

<form id="formEditJadwalAbsenKaryawan" enctype="multipart/form-data">
    <div class="modal fade animated zoomIn" id="modalJadwalAbsenKaryawan" tabindex="-1" role="dialog" aria-labelledby="modalJadwalAbsenKaryawanLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="card-title">JADWAL ABSEN KARYAWAN</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <i class="la la-times"></i>
                    </button>
                </div>
                <div class="modal-body overflow-x-hidden" id="loadJadwalAbsenKaryawan">
                    <div class="text-center">Loading...</div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-modal-false waves-effect" data-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-modal-true waves-effect waves-ripple">Simpan</button>
                </div>
            </div>
        </div>
    </div>
</form>

<div class="modal fade animated zoomIn" id="modalInfoKaryawan" tabindex="-1" role="dialog" aria-labelledby="modalInfoKaryawanLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="card-title">INFO KARYAWAN</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <i class="la la-times"></i>
                </button>
            </div>
            <div class="modal-body overflow-x-hidden" id="loadInfoKaryawan"></div>
        </div>
    </div>
</div>

<script>
    $('#click-tambah-karyawan').click(function() {
        $('html, body').animate({
            scrollTop: '0'
        }, 200);
        history.pushState('Tambah karyawan', 'Tambah karyawan', '?menu=tambah-karyawan');
        $('#content').load('tambah-karyawan');
    });

    $('#click-master-jabatan').click(function() {
        $('html, body').animate({
            scrollTop: '0'
        }, 200);
        history.pushState('Master jabatan', 'Master jabatan', '?menu=master-jabatan');
        $('#content').load('master-jabatan');
    });

    $('#file_import').change(function() {
        var file = this.files[0];
        file_name = file.name;
        file_size = file.size;
        if (file_size > 3000000) {
            pesan('Upload file maksimal 3 MB!', 5000);
            $(this).val('');
            return false;
        } else {
            $('.btn-upload').addClass('d-none');
            $('#preview-import').addClass('d-block');
            $('.nama-file').html(file_name);
        }
    });

    $('.hapus-preview-import').click(function() {
        setTimeout(function() {
            $('#file_import').val('');
            $('.btn-upload').removeClass('d-none');
            $('#preview-import').removeClass('d-block');
        }, 300);
    });

    $('#formImport').submit(function(e) {
        $('#modalImport button[type="submit"]').attr('disabled', 'disabled');
        $('#modalImport button[type="submit"]').html('Mengimport...');
        e.preventDefault();
        $.ajax({
            type: 'post',
            url: 'aksi?import_karyawan',
            data: new FormData(this),
            contentType: false,
            processData: false,
            cache: false,
            success: function(data) {
                if (data == 'berhasil') {
                    pesan('Data berhasil di import', 3000);
                    $('[data-dismiss=modal]').trigger({
                        type: 'click'
                    });
                    setTimeout(function() {
                        $('#content').load('karyawan');
                    }, 300);
                } else if (data == 'ekstensi file') {
                    pesan('Ekstensi file harus csv, ods atau xlsx', 3000);
                } else {
                    pesan('Terdapat kesalahan pada sistem!', 3000);
                }
                $('#modalImport button[type="submit"]').removeAttr('disabled', 'disabled');
                $('#modalImport button[type="submit"]').html('Import');
            }
        });
    });

    $('.edit').click(function() {
        var id_karyawan = $(this).attr('data-id_karyawan');
        $('html, body').animate({
            scrollTop: '0'
        }, 200);
        $('#content').load('edit-karyawan?id_karyawan=' + id_karyawan);
    })

    $('.hapus').click(function() {
        var id_karyawan = $(this).attr('data-id_karyawan');
        Swal.fire({
            title: 'Konfirmasi?',
            text: 'Data yang dipilih akan dihapus!',
            showCancelButton: true,
            confirmButtonColor: '#4086EF',
            confirmButtonText: 'Hapus',
            cancelButtonText: 'Batal'
        }).then((result) => {
            if (result.value) {
                $.ajax({
                    type: 'post',
                    url: 'aksi?hapus_karyawan',
                    data: {
                        id_karyawan: id_karyawan
                    },
                    success: function(data) {
                        if (data == 'berhasil') {
                            pesan('Data berhasil dihapus', 3000);
                            $('#content').load('karyawan');
                        } else {
                            pesan(data, 3000);
                        }
                    }
                });
            }
        });
    });

    $('#click-import-karyawan').click(function() {
        $('#modalImport').modal('show');
    });

    $('.lihat').click(function() {
        var id_karyawan = $(this).attr('data-id_karyawan');
        $('#modalInfoKaryawan').modal('show');
        $('#loadInfoKaryawan').load('loadInfoKaryawan?id_karyawan=' + id_karyawan);
    });

    $('#jadwal-absen-karyawan').click(function() {
        $('#modalJadwalAbsenKaryawan').modal('show');
        $('#loadJadwalAbsenKaryawan').load('loadJadwalAbsenKaryawan');
    });


    $('#formEditJadwalAbsenKaryawan').submit(function(e) {
        e.preventDefault();
        $.ajax({
            type: 'post',
            url: 'aksi?edit_jadwal_absen_karyawan',
            data: new FormData(this),
            contentType: false,
            processData: false,
            cache: false,
            success: function(data) {
                if (data == 'berhasil') {
                    $('[data-dismiss=modal]').trigger({
                        type: 'click'
                    });
                    setTimeout(function() {
                        $('#content').load('karyawan');
                    }, 300);

                    pesan('Data berhasil disimpan', 3000);
                } else {
                    pesan(data, 3000);
                }
            }
        });
    });
</script>
