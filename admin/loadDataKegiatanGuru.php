<?php
require "../config.php";
$month = $_POST['month'];
$result = mysqli_query($conn, "SELECT g.nama, Count(*) as total, g.id_guru FROM tb_kegiatan_guru kg JOIN tb_guru g ON
kg.id_guru = g.id_guru WHERE kg.tanggal_kegiatan LIKE '" . $month . "%' GROUP BY g.nama, g.id_guru");

$no = 1;
if (mysqli_num_rows($result) == 0) { ?>
   <div class="row d-flex justify-content-center text-center">
      <div class="col-9 col-md-7 col-lg-5 my-5">
         <img src="<?= base_url() ?>/assets/img/undraw_secure_data_0rwp.svg" alt="gambar" class="img-fluid">
         <p class="f-size-22px mt-3 mb-0">Tidak ada kegiatan! <?= $_POST["month"] ?></p>
      </div>
   </div>
<?php } else { ?>
  
  <a href="print-kegiatan-guru.php?month=<?= $month ?>" target="_BLANK" class="btn btn-linear-primary waves-effect waves-light mx-4">Print PDF</a>
  
  <div class="py-2">
     
      
     <div class="table-responsive">
        <table class="table">
           <thead>
              <th width="5%" class="text-center">No</th>
              <th width="50%">Nama Guru</th>
              <th width="35%">Total</th>
              <th width="10%">Aksi</th>
           </thead>
           <tbody <?php foreach ($result as $tb_kegiatan) { ?> <?php
                        $no_new = 1;
                        $q = mysqli_query($conn, "SELECT * FROM tb_kegiatan_guru kg JOIN tb_guru g ON kg.id_guru =
                        g.id_guru WHERE kg.tanggal_kegiatan LIKE '" . $month . "%' && kg.id_guru = " .
                        $tb_kegiatan['id_guru'] . "");
                        ?> <tr>
              <td class="text-center" style="background-color: #F3F4F6;"><?= $no++ ?></td>
              <td style="background-color: #F3F4F6;"><?= $tb_kegiatan["nama"] ?></td>
              <td style="background-color: #F3F4F6;"><?= $tb_kegiatan["total"] ?> kegiatan</td>
              <td style="background-color: #F3F4F6;">
                 <a href="print-kegiatan-guru-id?id_guru=<?= $tb_kegiatan['id_guru'] ?>&month=<?= date('Y-m') ?>"
                    target="_BLANK" class="btn btn-primary btn-sm">Print</a>
              </td>
              </tr>
              <td colspan="4">
                 <div class="table-responsive" style="margin: -3px;">
                    <table class="table table-sm">
                       <thead>
                          <th width="10%" class="text-center">No</th>
                          <th width="15%" class="text-center">Tanggal</th>
                          <th width="40%">Judul kegiatan</th>
                          <th width="15%" class="text-center">Lama kegiatan</th>
                          <th width="15%" class="text-center">Bukti</th>
                          <th width="5%" class="text-center">Aksi</th>
                       </thead>
                       <tbody <?php foreach ($q as $tb_kegiatan_new) { ?> <tr id="row-<?= $tb_kegiatan_new['id'] ?>">
                          <td class="text-center"><?= $no_new++ ?></td>
                          <td class="text-center"><?= $tb_kegiatan_new["tanggal_kegiatan"] ?></td>
                          <td><?= $tb_kegiatan_new['nama_kegiatan'] ?></td>
                          <td class="text-center"><?= $tb_kegiatan_new['lama_kegiatan_menit'] ?> menit</td>
                          <td class="text-center">
                             <img src="../img/guru/kegiatan/<?= $tb_kegiatan_new['bukti_kegiatan'] ?>"
                                class="img-thumbnail" style="width: 100px;" />
                          </td>
                          <td class="text-center">
                             <div class="btn-group">
                                <button type="button" class="btn btn-light border-0 waves-effect hapus"
                                   data-id="<?= $tb_kegiatan_new['id'] ?>"
                                   data-bukti="<?= $tb_kegiatan_new['bukti_kegiatan'] ?>">
                                   <i class="fa fa-trash"></i>
                                </button>
                             </div>
                          </td>
                          </tr>
                          <?php } ?>
                       </tbody>
                    </table>
                 </div>
              </td>
              <?php } ?>
           </tbody>
        </table>
     </div>
   </div>
 </div>
 
<?php } ?>

 <script>
    $('.hapus').click(function() {
     var id = $(this).attr('data-id');
     var bukti = $(this).attr('data-bukti');
     
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
              url: '../guru/aksi-hapus?hapus_kegiatan_guru',
              data: {
                 id: id,
                 bukti: bukti
              },
              success: function(data) {
                 if (data == 'berhasil') {
                    pesan('Data berhasil dihapus', 3000);
                    $("#row-" + id).remove();
                 } else {
                    pesan('Terdapat kesalahan pada sistem!', 3000);
                 }
              }
           });
        }
     });
  });
</script>