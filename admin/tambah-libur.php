<?php require "../config.php"; ?>
<h4 class="mb-3">Tambah Hari Libur</h4>
<div class="row d-flex justify-content-center">
    <div class="col-lg-6">
        <div class="card">
            <div class="card-header">
                <button type="button" class="btn btn-light btn-user waves-effect border-0 f-size-18px kembali">
                    <i class="la la-angle-left f-size-18px mr-2"></i>Kembali
                </button>
            </div>
            <form id="formTambahLibur">
                <div class="card-body">
                    <div class="form-group">
                        <label for="keterangan">Keterangan Libur <span></span></label>
                        <input type="text" name="keterangan" id="keterangan" class="form-control form-control4" placeholder="Contoh: Hari Ibu" required>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="tanggal_awal">Tanggal Awal</label>
                                <input type="date" name="tanggal_awal" id="tanggal_awal" class="form-control form-control4" required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="tanggal_akhir">Tanggal Akhir</label>
                                <input type="date" name="tanggal_akhir" id="tanggal_akhir" class="form-control form-control4" required>
                            </div>
                        </div>
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

<script>
    $('#formTambahLibur').submit(function(e) {
        e.preventDefault();
        $.ajax({
            type: 'post',
            url: 'aksi?tambah_libur',
            data: new FormData(this),
            contentType: false,
            processData: false,
            cache: false,
            success: function(data) {
                if (data == 'berhasil') {
                    history.pushState('Jadwal Libur', 'Jadwal Libur', '?menu=libur');
                    $('#content').load('libur');
                    $('html, body').animate({
                        scrollTop: '0'
                    }, 200);
                    pesan('Data berhasil disimpan', 3000);
                } else {
                    pesan(data, 3000);
                }
            }
        });
    });

    $('.kembali').click(function() {
        $('html, body').animate({
            scrollTop: '0'
        }, 200);
        history.pushState('Jadwal Libur', 'Jadwal Libur', '?menu=libur');
        $('#content').load('libur');
    });
</script>