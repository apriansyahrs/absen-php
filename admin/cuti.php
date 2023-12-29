<?php require "../config.php";
$result = mysqli_query($conn, "SELECT g.nama as nama_guru,g.nip as nip_guru,k.nama as nama_karyawan,k.nip as nip_karyawan,c.keterangan,c.mulai_cuti,c.selesai_cuti,c.id,c.id_guru,c.id_karyawan FROM tb_cuti c LEFT JOIN tb_guru g ON c . id_guru = g . id_guru LEFT JOIN tb_karyawan k ON c . id_karyawan = k . id_karyawan"); ?>
<div class="row">
   <div class="col-md-6">
      <h4 class="mb-3">Cuti</h4>
   </div>
   <div class="col-md-6 text-right mb-3">
      <div class="btn-group">
         <button type="button" class="btn btn-primary waves-effect waves-light" id="click-tambah-cuti">
            <i class="fa fa-plus"></i>
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
   <form id="formHapusCeklis">
      <div class="card">
         <div class="py-2">
            <div class="row px-4 py-2">
               <div class="col-md-6 col-lg-4 text-right">
                  <input type="text" name="" id="search" class="form-control form-control2" placeholder="Pencarian...">
               </div>
            </div>
         </div>
         <div class="table-responsive overlay-scrollbars">
            <table class="table table-hover">
               <thead>
                  <th width="5%" class="text-center">No</th>
                  <th width="10%">Status</th>
                  <th width="15%">Nama</th>
                  <th width="10%" class="text-center">Mulai Cuti</th>
                  <th width="15%" class="text-center">Selesai Cuti</th>
                  <th width="15%" class="text-center">Keterangan</th>
                  <th width="10%" class="text-center">Aksi</th>
               </thead>
               <tbody>
                  <?php
                     $no = 1;
                     foreach ($result as $tb_cuti) { ?>
                     <tr class="contsearch">
                        <td class="text-center"><?= $no++ ?></td>
                        <?php if ($tb_cuti['id_guru']) { ?>
                        <td class="f-size-16px">Guru</td>
                        <?php } else { ?>
                        <td class="f-size-16px">Karyawan</td>
                        <?php } ?>
                        
                        
                        <?php if ($tb_cuti['id_guru']) { ?>
                        <td>
                           <p class="f-size-18px mb-0 gsearch"><?= $tb_cuti['nip_guru'] ?></p>
                           <span class="gsearch"><?= $tb_cuti['nama_guru']?></span>
                        </td>
                        <?php } else { ?>
                        <td>
                           <p class="f-size-18px mb-0 gsearch"><?= $tb_cuti['nip_karyawan'] ?></p>
                           <span class="gsearch"><?= $tb_cuti['nama_karyawan']?></span>
                        </td>
                        <?php } ?>
                        <td class="text-center gsearch"><?= $tb_cuti['mulai_cuti'] ?></td>
                        <td class="text-center gsearch"><?= $tb_cuti['selesai_cuti'] ?></td>
                        <td class="text-center gsearch"><?= $tb_cuti['keterangan'] ?></td>
                        <td class="text-center">
                           <div class="btn-group">
                              <button type="button" class="btn btn-light border-0 waves-effect edit" data-id="<?= $tb_cuti['id'] ?>">
                                 <i class="fa fa-pen"></i>
                              </button>
                              <button type="button" class="btn btn-light border-0 waves-effect hapus" data-id="<?= $tb_cuti['id'] ?>">
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
            <div id="localSearchSimple"></div>
         </div>
      </div>
      </div>
   </form>
   <div id="loadEditCuti"></div>

   <script>
      $('.edit').click(function() {
         var id = $(this).attr('data-id');
         $('#loadEditCuti').load('loadEditCuti?id=' + id);
      })

      $('.hapus').click(function() {
         var id = $(this).attr('data-id');
         Swal.fire({
            title: 'Konfirmasi?',
            text: 'Data yang dipilih akan dihapus, termasuk pengumuman, data siswa dan data absen keseluruhan!',
            showCancelButton: true,
            confirmButtonColor: '#4086EF',
            confirmButtonText: 'Hapus',
            cancelButtonText: 'Batal'
         }).then((result) => {
            if (result.value) {
               $.ajax({
                  type: 'post',
                  url: 'aksi?hapus_cuti',
                  data: {
                     id: id
                  },
                  success: function(data) {
                     if (data == 'berhasil') {
                        pesan('Data berhasil dihapus', 3000);
                        $('#content').load('cuti');
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

      $('#localSearchSimple').jsLocalSearch({
         'searchinput': '#search',
         'mark_text': 'mark_text'
      });
   </script>

<?php } ?>

<script>
   $('#click-tambah-cuti').click(function() {
      $('html, body').animate({
         scrollTop: '0'
      }, 200);
      history.pushState('Tambah cuti', 'Tambah cuti', '?menu=tambah-cuti');
      $('#content').load('tambah-cuti');
   });

   function select(id, placeholder) {
      $('#' + id).select2({
         theme: 'bootstrap4',
         placeholder: placeholder
      });
   }

   select('id_guru', 'Pilih Guru');
   select('token_kelas', 'Pilih Kelas');

   $('#id_guru').change(function() {
      var id_guru = $(this).val();
      $.ajax({
         type: 'post',
         url: '../guru/change-data?change_token_kelas_admin',
         data: 'id_guru=' + id_guru,
         dataType: 'html',
         success: function(data) {
            $('select#token_kelas').html(data);
         }
      });
   });

</script>