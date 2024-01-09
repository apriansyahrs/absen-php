<h4 class="mb-3">Tambah karywaan</h4>
<div class="row">
   <div class="col-md-12">
      <div class="card">
         <div class="card-header">
            <button type="button" class="btn btn-light btn-user waves-effect border-0 f-size-18px kembali">
               <i class="la la-angle-left f-size-18px mr-2"></i>Kembali
            </button>
         </div>
         <form id="formTambahKaryawan">
            <div class="card-body">
               <div class="row">
                  <div class="col-md-6">
                     <div class="form-group">
                        <label for="nip">NIP karyawan <span></span></label>
                        <input type="text" name="nip" id="nip" class="form-control form-control4" required="">
                     </div>
                     <div class="form-group">
                        <label for="nama">Nama karyawan <span></span></label>
                        <input type="text" name="nama" id="nama" class="form-control form-control4" required="">
                     </div>
                     <div class="form-group">
                        <label for="tempat_lahir">Tempat lahir <span></span></label>
                        <input type="text" name="tempat_lahir" id="tempat_lahir" class="form-control form-control4" required="">
                     </div>
                     <div class="form-group">
                        <label for="tanggal_lahir">Tanggal lahir <span></span></label>
                        <input type="date" name="tanggal_lahir" id="tanggal_lahir" class="form-control form-control4" required="">
                     </div>
                     <div class="form-group">
                        <label for="">Jenis kelamin <span></span></label> <br>
                        <label class="btn btn-radio active">Laki-laki
                           <input type="radio" class="d-none" name="jk" value="Laki-laki" checked="checked">
                        </label>
                        <label class="btn btn-radio">Perempuan
                           <input type="radio" class="d-none" name="jk" value="Perempuan">
                        </label>
                     </div>
                  </div>
                  <div class="col-md-6">
                     <div class="form-group">
                        <label for="alamat">Alamat lengkap <span></span></label>
                        <textarea name="alamat" id="alamat" rows="5" class="form-control form-control4" required=""></textarea>
                     </div>
                     <div class="form-group">
                        <label for="id_jabatan">Jabatan karyawan <span></span></label>
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
                     <div class="form-group">
                        <label for="password1">Password <span></span></label>
                        <input type="password" name="password1" id="password1" class="form-control form-control4" required="">
                     </div>
                     <div class="form-group">
                        <label for="password2">Konfirmasi password <span></span></label>
                        <input type="password" name="password2" id="password2" class="form-control form-control4" required="">
                     </div>
                  </div>
               </div>
            </div>
            <div class="card-footer mt-n4 text-right">
               <button type="submit" class="btn btn-linear-primary waves-effect waves-light" id="btn-simpan">
                  Simpan
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
      history.pushState('karyawan', 'karyawan', '?menu=karyawan');
      $('#content').load('karyawan');
   });

   $('#formTambahKaryawan').submit(function(e) {
      if ($('#password1').val() !== $('#password2').val()) {
         pesan('Konfirmasi password salah', 3000);
         return false;
      }
      $('#btn-simpan').attr('disabled', 'disabled');
      $('#btn-simpan').html('<div class="spinner-border text-white" role="status"></div>');
      e.preventDefault();
      $.ajax({
         type: 'post',
         url: 'aksi?tambah_karyawan',
         data: new FormData(this),
         contentType: false,
         processData: false,
         cache: false,
         success: function(data) {
            if (data == 'berhasil') {
               $('html, body').animate({
                  scrollTop: '0'
               }, 200);
               pesan('Data karyawan berhasil ditambahkan', 3000);
               history.pushState('karyawan', 'karyawan', '?menu=karyawan');
               $('#content').load('karyawan');
            } else if (data == 'tidak tersedia') {
               pesan('NIP tidak tersedia', 3000);
            } else {
               pesan(data, 3000);
            }
            $('#btn-simpan').removeAttr('disabled', 'disabled');
            $('#btn-simpan').html('Simpan');
         }
      })
   });

   $('.btn-radio').click(function() {
      $('.btn-radio.active').removeClass('active');
      $(this).addClass('active');
   });
</script>
