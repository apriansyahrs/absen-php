<?php
require "../config.php";
$id_guru = $_SESSION['guru'];
$month = $_POST['month'];
$result = mysqli_query($conn, "SELECT * FROM tb_kegiatan_guru WHERE id_guru = " . $id_guru . " && tanggal_kegiatan LIKE '" . $month . "%'");

$no = 1;
if (mysqli_num_rows($result) == 0) { ?>
   <div class="row d-flex justify-content-center text-center">
      <div class="col-9 col-md-7 col-lg-5 my-5">
         <img src="<?= base_url() ?>/assets/img/undraw_secure_data_0rwp.svg" alt="gambar" class="img-fluid">
         <p class="f-size-22px mt-3 mb-0">Tidak ada kegiatan! <?= $_POST["month"] ?></p>
      </div>
   </div>
<?php } else { ?>
  
  <div class="py-2">
      
      <a href="print-kegiatan-guru.php?month=<?= $month ?>" target="_BLANK" class="btn btn-linear-primary waves-effect waves-light mx-4">Print PDF</a>
      
     <div class="table-responsive">
        <table class="table table-hover">
            <thead>
              <th width="10%" class="text-center">No</th>
              <th width="10%" class="text-center">Tgl</th>
              <th width="30%">Judul kegiatan</th>
              <th width="15%" class="text-center">Mulai</th>
              <th width="15%" class="text-center">Selesai</th>
              <th width="20%" class="text-center">Bukti</th>
           </thead>
           <tbody
              <?php foreach ($result as $tb_kegiatan) { ?>
                 <tr>
                    <td class="text-center"><?= $no++ ?></td>
                    <td class="text-center"><?= $tb_kegiatan["tanggal_kegiatan"] ?></td>
                    <td>
                       <span class="f-size-16px">
                          <?= $tb_kegiatan['nama_kegiatan'] ?>
                       </span>
                    </td>
                    <td class="text-center"><?= $tb_kegiatan['jam_mulai'] ?></td>
                    <td class="text-center"><?= $tb_kegiatan['jam_selesai'] ?></td>
                    <td class="text-center">
                        <img src="../img/guru/kegiatan/<?= $tb_kegiatan['bukti_kegiatan'] ?>" class="img-thumbnail" style="width: 100px;" />
                    </td>
                 </tr>
              <?php } ?>
           </tbody>
        </table>
     </div>
   </div>
 </div>

<?php } ?>