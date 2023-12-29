<?php
require "../config.php";
$id = $_GET['id'];
$tb_cuti = query("SELECT g.nama as nama_guru,g.nip as nip_guru,k.nama as nama_karyawan,k.nip as nip_karyawan,c.keterangan,c.mulai_cuti,c.selesai_cuti,c.id,c.id_guru,c.id_karyawan FROM tb_cuti c LEFT JOIN tb_guru g ON c . id_guru = g . id_guru LEFT JOIN tb_karyawan k ON c . id_karyawan = k . id_karyawan WHERE c.id = '$id'"); ?>

<form id="formEditCuti">
   <div class="modal fade animated zoomIn" id="modalEditCuti" tabindex="-1" role="dialog" aria-labelledby="modalEditCutiLabel" aria-hidden="true">
      <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable">
         <div class="modal-content">
            <div class="modal-body overflow-x-hidden">
               <input type="hidden" name="id" value="<?= $tb_cuti['id'] ?>">
               
               <div class="form-group">
                  <?php if ($tb_cuti['nama_guru']) { ?>
                  <label for="">Nama guru</label>
                  <input type="text" name="" id="" class="form-control form-control4" value="<?= $tb_cuti['nama_guru'] ?>" readonly="" required>
                  <?php } else { ?>
                  <label for="">Nama karyawan</label>
                  <input type="text" name="" id="" class="form-control form-control4" value="<?= $tb_cuti['nama_karyawan'] ?>" readonly="" required>
                  <?php } ?>
               </div>
               <div class="form-group">
                   <textarea name="keterangan" id="keterangan" class="form-control form-control4" placeholder="Keterangan (Opsional)" rows="3"><?= $tb_cuti['keterangan'] ?></textarea>
               </div>
               <div class="form-group">
                   <label for="mulai_cuti">Mulai cuti</label>
                  <input type="date" name="mulai_cuti" id="mulai_cuti" class="form-control form-control4" value="<?= $tb_cuti['mulai_cuti'] ?>" required>
               </div>
               <div class="form-group">
                   <label for="selesai_cuti">Selesai cuti</label>
                  <input type="date" name="selesai_cuti" id="selesai_cuti" class="form-control form-control4" min="<?= $tb_cuti['mulai_cuti'] ?>" value="<?= $tb_cuti['selesai_cuti'] ?>" required>
               </div>
         </div>
         <div class="modal-footer">
               <button type="button" class="btn btn-modal-false waves-effect" data-dismiss="modal">Batal</button>
               <button type="submit" class="btn btn-modal-true waves-effect waves-ripple">Simpan</button>
            </div>
      </div>
   </div>
</form>

<script>
   $('#modalEditCuti').modal('show');

   $('#formEditCuti').submit(function(e) {
      e.preventDefault();
      $.ajax({
         type: 'post',
         url: 'aksi?edit_cuti',
         data: new FormData(this),
         contentType: false,
         processData: false,
         cache: false,
         success: function(data) {
            if (data == 'berhasil') {
               pesan('Data berhasil disimpan', 3000);
               $('[data-dismiss=modal]').trigger({
                  type: 'click'
               });
               setTimeout(function() {
                  $('#content').load('cuti');
               }, 300);
            } else if (data == 'tidak tersedia') {
               pesan('NIS kamu tidak tersedia', 3000);
            } else {
               pesan('Terdapat kesalahan pada sistem!', 3000);
            }
         }
      });
   });

   function select(id, placeholder) {
      $('#' + id).select2({
         theme: 'bootstrap4',
         placeholder: placeholder
      });
   }
   
   $('#mulai_cuti').change(function() {
       $('#selesai_cuti').attr('min', $(this).val()); 
   });
</script>