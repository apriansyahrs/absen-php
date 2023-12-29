<?php require "../config.php"; ?>
<h4 class="mb-3">Tambah cuti</h4>
<div class="card">
   <div class="card-header">
      <button type="button" class="btn btn-light btn-user waves-effect border-0 f-size-18px kembali">
         <i class="la la-angle-left f-size-18px mr-2"></i>Kembali
      </button>
   </div>
  <div class="card-body">
     <div class="row">
        <div class="col-md-6">
            <form id="formTambahCutiGuru">
               <h5>Guru</h5>
               <div class="form-group">
                  <select name="id_guru" id="id_guru" class="custom-select" required>
                     <option value=""></option>
                     <option value="all">Semua</option>
                     <?php
                     $result = mysqli_query($conn, "SELECT id_guru,nip,nama FROM tb_guru");
                     foreach ($result as $tb_guru) {
                        echo "<option value='$tb_guru[id_guru]'>$tb_guru[nip] - $tb_guru[nama]</option>";
                     } ?>
                  </select>
               </div>
               <div class="form-group">
                   <textarea name="keterangan_guru" id="keterangan_guru" class="form-control form-control4" placeholder="Keterangan (Opsional)" rows="3"></textarea>
               </div>
               <div class="form-group">
                   <label for="mulai_cuti_guru">Mulai cuti</label>
                  <input type="date" name="mulai_cuti_guru" id="mulai_cuti_guru" class="form-control form-control4" required>
               </div>
               <div class="form-group">
                   <label for="selesai_cuti_guru">Selesai cuti</label>
                  <input type="date" name="selesai_cuti_guru" id="selesai_cuti_guru" class="form-control form-control4" min="<?= date('Y-m-d') ?>" required>
               </div>
               <div class="form-group">
                   <button type="submit" class="btn btn-linear-primary waves-effect waves-light" id="btn-save-guru">
                    Simpan
                 </button>
               </div>
            </form>
        </div>
        <div class="col-md-6">
            <form id="formTambahCutiKaryawan">
               <h5>Karyawan</h5>
               <div class="form-group">
                  <select name="id_karyawan" id="id_karyawan" class="custom-select" required>
                     <option value=""></option>
                     <option value="all">Semua</option>
                     <?php
                     $result = mysqli_query($conn, "SELECT id_karyawan,nip,nama FROM tb_karyawan");
                     foreach ($result as $tb_karyawan) {
                        echo "<option value='$tb_karyawan[id_karyawan]'>$tb_karyawan[nip] - $tb_karyawan[nama]</option>";
                     } ?>
                  </select>
               </div>
               <div class="form-group">
                   <textarea name="keterangan_karyawan" id="keterangan_karyawan" class="form-control form-control4" placeholder="Keterangan (Opsional)" rows="3"></textarea>
               </div>
               <div class="form-group">
                   <label for="mulai_cuti_karyawan">Mulai cuti</label>
                  <input type="date" name="mulai_cuti_karyawan" id="mulai_cuti_karyawan" class="form-control form-control4" required>
               </div>
               <div class="form-group">
                   <label for="selesai_cuti_karyawan">Selesai cuti</label>
                  <input type="date" name="selesai_cuti_karyawan" id="selesai_cuti_karyawan" class="form-control form-control4" min="<?= date('Y-m-d') ?>" required>
               </div>
               <div class="form-group">
                   <button type="submit" class="btn btn-linear-primary waves-effect waves-light" id="btn-save-karyawan">
                    Simpan
                 </button>
               </div>
            </form>
        </div>
     </div>
  </div>
     
</div>

<script>
   $('.kembali').click(function() {
      $('html, body').animate({
         scrollTop: '0'
      }, 200);
      history.pushState('Cuti', 'Cuti', '?menu=cuti');
      $('#content').load('cuti');
   });

   $('#formTambahCutiGuru').submit(function(e) {
      e.preventDefault();
      
        $('#btn-save-guru').attr('disabled', 'disabled');
        $('#btn-save-guru').html('<div class="spinner-border text-white" role="status"></div>');

      $.ajax({
         type: 'post',
         url: 'aksi?tambah_cuti_guru',
         data: new FormData(this),
         contentType: false,
         processData: false,
         cache: false,
         success: function(data) {
            if (data == 'berhasil') {
               pesan('Data berhasil disimpan', 3000);
               document.getElementById('formTambahCutiGuru').reset();
            } else if (data == 'sudah terdaftar') {
                pesan('Tanggal cuti tidak tersedia!', 3000);
            } else {
               pesan('Terdapat kesalahan pada sistem!', 3000);
            }
            $('#btn-save-guru').removeAttr('disabled', 'disabled');
            $('#btn-save-guru').html('Simpan');
         }
      });
   });
   
   $('#formTambahCutiKaryawan').submit(function(e) {
      e.preventDefault();
      
        $('#btn-save-karyawan').attr('disabled', 'disabled');
        $('#btn-save-karyawan').html('<div class="spinner-border text-white" role="status"></div>');
        
      $.ajax({
         type: 'post',
         url: 'aksi?tambah_cuti_karyawan',
         data: new FormData(this),
         contentType: false,
         processData: false,
         cache: false,
         success: function(data) {
            if (data == 'berhasil') {
               pesan('Data berhasil disimpan', 3000);
               document.getElementById('formTambahCutiKaryawan').reset();
            } else if (data == 'sudah terdaftar') {
                pesan('Data sudah terdaftar di tanggal yang sama!', 3000);
            } else {
               pesan('Terdapat kesalahan pada sistem!', 3000);
            }
            $('#btn-save-karyawan').removeAttr('disabled', 'disabled');
            $('#btn-save-karyawan').html('Simpan');
         }
      });
   });


   function select(id, placeholder) {
      $('#' + id).select2({
         theme: 'bootstrap4',
         placeholder: placeholder
      });
   }

   select('id_guru', 'Pilih Guru');
   select('id_karyawan', 'Pilih Karyawan');
   
   $('#mulai_cuti_guru').change(function() {
       $('#selesai_cuti_guru').attr('min', $(this).val()); 
   });
   
   $('#mulai_cuti_karyawan').change(function() {
       $('#selesai_cuti_karyawan').attr('min', $(this).val()); 
   });
   
</script>