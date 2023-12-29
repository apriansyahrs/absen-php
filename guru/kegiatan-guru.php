<?php require "../config.php";
?>

<div class="content-title">Kegiatan Guru</div>
<form id="formKegiatan">
   <div class="card">
      <div class="card-body">
         <div class="form-group">
            <label for="nama_kegiatan">Judul kegiatan <span></span></label>
            <input type="text" name="nama_kegiatan" id="nama_kegiatan" class="form-control form-control4" required>
         </div>
         <div class="form-group">
            <label for="bukti_kegiatan">Bukti kegiatan <span></span></label>
            <input type="file" name="bukti_kegiatan" id="bukti_kegiatan" class="form-control form-control4" required>
         </div>
         <div class="form-group">
             <img id="preview-bukti" class="img-fluid" style="width: 100px;" />
         </div>
         <div class="form-group">
            <label for="lama_kegiatan_menit">Lama kegiatan (menit) <span></span></label>
            <input type="number" name="lama_kegiatan_menit" id="lama_kegiatan_menit" class="form-control form-control4" required>
         </div>
         
      </div>
      <div class="card-footer text-right">
         <button type="submit" class="btn btn-linear-primary waves-effect waves-light" id="btn-submit" disabled="disabled">
            Simpan
         </button>
      </div>
   </div>
</form>
   

   <div class="content-title">Daftar kegiatan</div>
   <div class="card">
       <form id="formFilter">
         <div class="">
            <div class="m-4">
              <div class="row">
                  <div class="col-12 col-md-4">
                      <input type="month" name="month" id="month" class="form-control form-control4" value="<?= date('Y-m') ?>" max="<?= date('Y-m') ?>" required>
                  </div>
              </div>
            </div>
         </div>
      </form>
      
      <div  id="cont-kegiatan-guru">
          
          <a href="print-kegiatan-guru.php?month=<?= date('Y-m') ?>" target="_BLANK" class="btn btn-linear-primary waves-effect waves-light mx-4">Print PDF</a>
      
           <?php
            $no = 1;
            $result = mysqli_query($conn, "SELECT * FROM tb_kegiatan_guru WHERE id_guru = '$_SESSION[guru]' && tanggal_kegiatan LIKE '" . date("Y-m") . "%'");
            if (mysqli_num_rows($result) == 0) { ?>
               <div class="row d-flex justify-content-center text-center">
                  <div class="col-9 col-md-7 col-lg-5 my-5">
                     <img src="<?= base_url() ?>/assets/img/undraw_secure_data_0rwp.svg" alt="gambar" class="img-fluid">
                     <p class="f-size-22px mt-3 mb-0">Belum ada kegiatan bulan ini!</p>
                  </div>
               </div>
            <?php } else { ?>
          
          <div class="py-2">
             <div class="table-responsive">
                <table class="table table-hover">
                   <thead>
                      <th width="10%" class="text-center">No</th>
                      <th width="15%" class="text-center">Tgl</th>
                      <th width="40%">Judul kegiatan</th>
                      <th width="15%" class="text-center">Lama kegiatan</th>
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
                            <td class="text-center"><?= $tb_kegiatan['lama_kegiatan_menit'] ?> menit</td>
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
      
   </div>



<script>
   $('#formKegiatan').submit(function(e) {
      e.preventDefault();
      
        $('#btn-submit').attr('disabled', 'disabled');
        $('#btn-submit').html('<div class="spinner-border text-white" role="status"></div>');
      
      $.ajax({
         type: 'post',
         url: 'aksi-tambah?tambah_kegiatan',
         data: new FormData(this),
         contentType: false,
         processData: false,
         cache: false,
         success: function(data) {
            if (data == 'berhasil') {
               pesan('Data berhasil disimpan', 3000);
               document.getElementById('formKegiatan').reset();
               $("#preview-bukti").attr("src", "");
               $("#content").load('kegiatan-guru');
            } else {
               pesan('Terdapat kesalahan pada sistem!', 3000);
            }
            
            $('#btn-submit').removeAttr('disabled', 'disabled');
            $('#btn-submit').html('Simpan');
         }
      });
   });
   
   $('#bukti_kegiatan').change(function() {
      var file = this.files[0];
      file_name = file.name;
      file_type = file.type;
      file_size = file.size;
      match = ['image/jpg', 'image/jpeg', 'image/png'];

      if (!((file_type == match[0]) || (file_type == match[1]) || (file_type == match[2]))) {
         pesan('Ekstensi foto harus jpg, jpeg atau png!', 5000);
         $(this).val('');
         $("#preview-bukti").attr("src", "");
         $("#btn-submit").attr("disabled", "disabled")
         return false;
      }
      if (file_size > 3000000) {
         pesan('Upload foto maksimal 3 MB!', 5000);
         $(this).val('');
         $("#preview-bukti").attr("src", "");
         $("#btn-submit").attr("disabled", "disabled")
         return false;
      } else {
         function imageIsLoaded(e) {
            $('#preview-bukti').attr('src', e.target.result);
         }
         var reader = new FileReader();
         reader.onload = imageIsLoaded;
         reader.readAsDataURL(this.files[0]);
         $("#btn-submit").removeAttr("disabled", "disabled")
      }
   });
   
   $('#month').change(function() {
      month = $(this).val();
      $.ajax({
         type: 'post',
         url: 'loadDataKegiatanGuru.php',
         data: {
            month: month
         },
         success: function(data) {
            $("#cont-kegiatan-guru").html(data);
         }
      })
   });

</script>