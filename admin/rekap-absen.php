<?php require "../config.php";
$result_a_masuk_siswa = mysqli_query($conn, "SELECT * FROM a_masuk");
$result_a_masuk_guru = mysqli_query($conn, "SELECT * FROM a_masuk_guru");
$result_a_masuk_karyawan = mysqli_query($conn, "SELECT * FROM a_masuk_karyawan"); ?>

<ul class="nav nav-tabs" id="myTab" role="tablist">
   <li class="nav-item" role="presentation">
      <a class="nav-link active" id="home-tab" data-toggle="tab" href="#home" role="tab" aria-controls="home" aria-selected="true">Absensi</a>
   </li>
   <li class="nav-item" role="presentation">
      <a class="nav-link" id="profile-tab" data-toggle="tab" href="#profile" role="tab" aria-controls="profile" aria-selected="false">Kegiatan Guru</a>
   </li>
</ul>
<div class="tab-content bg-white" id="myTabContent">
   <div class="tab-pane fade show active" id="home" role="tabpanel" aria-labelledby="home-tab">
      <?php if (mysqli_num_rows($result_a_masuk_siswa) == 0 && mysqli_num_rows($result_a_masuk_guru) == 0 && mysqli_num_rows($result_a_masuk_karyawan) == 0) { ?>
         <div class="row d-flex justify-content-center text-center">
            <div class="col-9 col-md-7 col-lg-5 my-5">
               <img src="<?= base_url() ?>/assets/img/undraw_secure_data_0rwp.svg" alt="gambar" class="img-fluid">
               <p class="f-size-22px mt-3 mb-0">Maaf, saat ini data tidak ditemukan!</p>
            </div>
         </div>
      <?php } else { ?>
         <div class="">
            <div class="p-3">
               <form id="formFilterRekap">
                  <div class="row">
                     <div class="col-12 col-md-3 col-lg-3 my-2">
                        <select name="what_rekap" id="what_rekap" class="custom-select" required>
                           <option value=""></option>
                           <option>Siswa</option>
                           <option>Guru</option>
                           <option>Karyawan</option>
                        </select>
                     </div>
                     <div class="col-12 col-md-3 col-lg-3 my-2">
                        <select name="token_kelas" id="token_kelas" class="custom-select" required disabled="disabled">
                           <option value=""></option>
                        </select>
                     </div>
                     <div class="col-12 col-md-3 col-lg-3 my-2">
                        <select name="m_bulan_tahun" id="m_bulan_tahun" class="custom-select" required disabled="disabled">
                           <option value=""></option>
                        </select>
                     </div>
                     <div class="col-12 col-md-3 col-lg-3 my-2">
                        <button type="submit" class="btn btn-primary btn-lg btn-block">
                           <i class="fa fa-filter fa-fw"></i> Filter
                        </button>
                     </div>
                  </div>
               </form>
               <div id="cont-rekap-absen">
                  <div class="row d-flex justify-content-center text-center">
                     <div class="col-md-4 my-5">
                        <img src="<?= base_url() ?>/assets/img/undraw_filter_4kje.svg" alt="gambar" class="img-fluid">
                        <p class="my-3" style="color: #27385D;">Filter data yang akan ditampilkan!</p>
                     </div>
                  </div>
               </div>
            </div>
         </div>

         <script>
            $('#formFilterRekap').submit(function(e) {
               $('#cont-rekap-absen').html('<div class="text-center my-5"><div class="spinner-border spinner-border-lg text-primary" role="status"></div><p class="my-2" style="color: #27385D;">Tunggu sebentar</p></div>');
               e.preventDefault();
               $.ajax({
                  type: 'post',
                  url: 'loadDataRekapAbsen',
                  data: new FormData(this),
                  contentType: false,
                  processData: false,
                  cache: false,
                  success: function(data) {
                     $('#cont-rekap-absen').html(data);
                  }
               })
            })

            $('.overlay-scrollbars').overlayScrollbars({
               className: "os-theme-dark",
               scrollbars: {
                  autoHide: 'l',
                  autoHideDelay: 0
               }
            });

            $('#token_kelas').change(function() {
               token_kelas = $(this).val();
               $('#m_bulan_tahun').removeAttr('disabled', 'disabled');
               $.ajax({
                  type: 'post',
                  url: '../guru/change-data',
                  data: {
                     change_rekap: true,
                     token_kelas: token_kelas
                  },
                  success: function(data) {
                     if (data !== '') {
                        $('#m_bulan_tahun').removeAttr('disabled', 'disabled');
                        $('#m_bulan_tahun').html(data);
                     }
                  }
               })
            });

            $('#what_rekap').change(function() {
               var val = $(this).val();
               if (val == 'Siswa') {
                  $('#token_kelas').removeAttr('disabled', 'disabled');
                  $('#m_bulan_tahun').attr('disabled', 'disabled');

                  $.ajax({
                     type: 'post',
                     url: '../guru/change-data',
                     data: {
                        what_rekap: val,
                        show_kelompok: true,
                     },
                     success: function(data) {
                        if (data !== '') {
                           $('#token_kelas').removeAttr('disabled', 'disabled');
                           $('#token_kelas').html(data);
                        }
                     }
                  })
               } else {
                  $('#token_kelas').attr('disabled', 'disabled');
                  $('#token_kelas').html('<option val=""></option>');
                  $('#m_bulan_tahun').removeAttr('disabled', 'disabled');

                  $.ajax({
                     type: 'post',
                     url: '../guru/change-data',
                     data: {
                        what_rekap: val,
                     },
                     success: function(data) {
                        if (data !== '') {
                           $('#m_bulan_tahun').removeAttr('disabled', 'disabled');
                           $('#m_bulan_tahun').html(data);
                        }
                     }
                  })
               }
            })

            $('#what_rekap').select2({
               theme: 'bootstrap4',
               placeholder: '-- pilih --'
            });

            $('#token_kelas').select2({
               theme: 'bootstrap4',
               placeholder: '-- pilih --'
            });

            $('#m_bulan_tahun').select2({
               theme: 'bootstrap4',
               placeholder: '-- pilih --'
            });
         </script>

      <?php } ?>
   </div>
   <div class="tab-pane fade" id="profile" role="tabpanel" aria-labelledby="profile-tab">
      <form id="formFilter">
         <div class="pt-2">
            <div class="m-4">
               <div class="row">
                  <div class="col-12 col-md-4">
                     <input type="month" name="month" id="month" class="form-control form-control4" value="<?= date('Y-m') ?>" max="<?= date('Y-m') ?>" required>
                  </div>
               </div>
            </div>
         </div>
      </form>

      <div id="cont-kegiatan-guru">

         <a href="print-kegiatan-guru.php?month=<?= date('Y-m') ?>" target="_BLANK" class="btn btn-linear-primary waves-effect waves-light mx-4">Print PDF</a>

         <?php
         $no = 1;
         $result = mysqli_query($conn, "SELECT g.nama, Count(*) as total, g.id_guru FROM tb_kegiatan_guru kg JOIN tb_guru g ON
            kg.id_guru = g.id_guru WHERE kg.tanggal_kegiatan LIKE '" . date("Y-m") . "%' GROUP BY g.nama, g.id_guru");
         if ($result->num_rows == 0) { ?>
            <div class="row d-flex justify-content-center text-center">
               <div class="col-9 col-md-7 col-lg-5 my-5">
                  <img src="<?= base_url() ?>/assets/img/undraw_secure_data_0rwp.svg" alt="gambar" class="img-fluid">
                  <p class="f-size-22px mt-3 mb-0">Belum ada kegiatan bulan ini!</p>
               </div>
            </div>
         <?php } else { ?>

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
                        g.id_guru WHERE kg.tanggal_kegiatan LIKE '" . date("Y-m") . "%' && kg.id_guru = " .
                                                                              $tb_kegiatan['id_guru'] . "");
                                                                           ?> <tr>
                        <td class="text-center" style="background-color: #F3F4F6;"><?= $no++ ?></td>
                        <td style="background-color: #F3F4F6;"><?= $tb_kegiatan["nama"] ?></td>
                        <td style="background-color: #F3F4F6;"><?= $tb_kegiatan["total"] ?> kegiatan</td>
                        <td style="background-color: #F3F4F6;">
                           <a href="print-kegiatan-guru-id?id_guru=<?= $tb_kegiatan['id_guru'] ?>&month=<?= date('Y-m') ?>" target="_BLANK" class="btn btn-primary btn-sm">Print</a>
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
                                       <img src="../img/guru/kegiatan/<?= $tb_kegiatan_new['bukti_kegiatan'] ?>" class="img-thumbnail" style="width: 100px;" />
                                    </td>
                                    <td class="text-center">
                                       <div class="btn-group">
                                          <button type="button" class="btn btn-light border-0 waves-effect hapus" data-id="<?= $tb_kegiatan_new['id'] ?>" data-bukti="<?= $tb_kegiatan_new['bukti_kegiatan'] ?>">
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

   </div>
</div>


<script>
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