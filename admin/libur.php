<?php require "../config.php";
$result = mysqli_query($conn, "SELECT * FROM jadwal_libur ORDER BY tanggal ASC"); ?>
<div class="row">
    <div class="col-md-6 my-auto">
        <h4 class="mb-4">Jadwal Hari Libur</h4>
    </div>
    <div class="col-md-6">
        <div class="text-md-right mb-4 mb-md-0">
            <button type="button" class="btn btn-primary waves-effect waves-light" id="click-tambah-libur">
                <i class="fa fa-plus fa-fw"></i>
            </button>
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
<?php } else { ?>
    <div class="card">
        <div class="py-2">
            <div class="table-responsive overlay-scrollbars">
                <table class="table table-hover">
                    <thead>
                        <th width="5%" class="text-center">No</th>
                        <th width="20%">Tanggal</th>
                        <th width="60%">Keterangan</th>
                        <th width="15%" class="text-center">Aksi</th>
                    </thead>
                    <tbody>
                        <?php
                        $no = 1;
                        foreach ($result as $libur) {  ?>
                            <tr>
                                <td class="text-center"><?= $no++ ?></td>
                                <td>
                                    <?= $libur['tanggal'] ?>
                                </td>
                                <td><?= $libur['keterangan'] ?></td>
                                <td class="text-center">
                                    <div class="btn-group">
                                        <button type="button" class="btn btn-light border-0 waves-effect hapus" data-id="<?= $libur['id'] ?>">
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
        $('.hapus').click(function() {
            var id = $(this).attr('data-id');
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
                        url: 'aksi?hapus_libur',
                        data: {
                            id: id
                        },
                        success: function(data) {
                            if (data == 'berhasil') {
                                pesan('Data berhasil dihapus', 3000);
                                $('#content').load('libur');
                            } else {
                                pesan('Terdapat kesalahan pada sistem!', 3000);
                            }
                        }
                    });
                }
            });
        });

        $('.overlay-scrollbars').overlayScrollbars({
            className: "os-theme-dark",
            scrollbars: {
                autoHide: 'l',
                autoHideDelay: 0
            }
        });
    </script>

<?php } ?>

<script>
    $('#click-tambah-libur').click(function() {
        $('html, body').animate({
            scrollTop: '0'
        }, 200);
        history.pushState('Tambah hari libur', 'Tambah hari libur', '?menu=tambah-libur');
        $('#content').load('tambah-libur');
    });
</script>