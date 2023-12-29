<?php require "../config.php";
$id_karyawan = $_GET['id_karyawan'];
$tb_karyawan = query("SELECT * FROM tb_karyawan tk JOIN tb_jabatan tj ON tk . id_jabatan = tj . id_jabatan WHERE tk . id_karyawan = '$id_karyawan'"); ?>
<h4 class="mb-3">Edit karyawan</h4>
<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                <button type="button" class="btn btn-light btn-user waves-effect border-0 f-size-18px kembali">
                    <i class="la la-angle-left f-size-18px mr-2"></i>Kembali
                </button>
            </div>
            <form id="formEditKaryawan">
                <input type="hidden" name="id_karyawan" value="<?= $tb_karyawan['id_karyawan'] ?>">
                <input type="hidden" name="nip_lama" value="<?= $tb_karyawan['nip'] ?>">
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="nip">NIP karyawan <span></span></label>
                                <input type="number" name="nip" id="nip" class="form-control form-control4" value="<?= $tb_karyawan['nip'] ?>" required="">
                            </div>
                            <div class="form-group">
                                <label for="nama">Nama karyawan <span></span></label>
                                <input type="text" name="nama" id="nama" class="form-control form-control4" value="<?= $tb_karyawan['nama'] ?>" required="">
                            </div>
                            <div class="form-group">
                                <label for="tempat_lahir">Tempat lahir <span></span></label>
                                <input type="text" name="tempat_lahir" id="tempat_lahir" class="form-control form-control4" value="<?= $tb_karyawan['tempat_lahir'] ?>" required="">
                            </div>
                            <div class="form-group">
                                <label for="tanggal_lahir">Tanggal lahir <span></span></label>
                                <input type="date" name="tanggal_lahir" id="tanggal_lahir" class="form-control form-control4" value="<?= $tb_karyawan['tanggal_lahir'] ?>" required="">
                            </div>
                            <div class="form-group">
                                <label for="">Jenis kelamin <span></span></label> <br>
                                <?php if ($tb_karyawan['jk'] == 'Laki-laki') { ?>
                                    <label class="btn btn-radio active">Laki-laki
                                        <input type="radio" class="d-none" name="jk" value="Laki-laki" checked="">
                                    </label>
                                    <label class="btn btn-radio">Perempuan
                                        <input type="radio" class="d-none" name="jk" value="Perempuan">
                                    </label>
                                <?php } else { ?>
                                    <label class="btn btn-radio">Laki-laki
                                        <input type="radio" class="d-none" name="jk" value="Laki-laki">
                                    </label>
                                    <label class="btn btn-radio active">Perempuan
                                        <input type="radio" class="d-none" name="jk" value="Perempuan" checked="">
                                    </label>
                                <?php } ?>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="alamat">Alamat lengkap <span></span></label>
                                <textarea name="alamat" id="alamat" rows="5" class="form-control form-control4" required=""><?= $tb_karyawan['alamat'] ?></textarea>
                            </div>
                            <div class="form-group">
                                <label for="jabatan">Jabatan karyawan <span></span></label>
                                <select name="id_jabatan" id="id_jabatan" class="custom-select custom-select2" required="">
                                    <?php
                                    $result = mysqli_query($conn, "SELECT * FROM tb_jabatan");
                                    foreach ($result as $tb_jabatan) {
                                        if ($tb_karyawan['id_jabatan'] == $tb_jabatan['id_jabatan']) {
                                            echo "<option selected='' value='$tb_jabatan[id_jabatan]'>$tb_jabatan[jabatan]</option>";
                                        } else {
                                            echo "<option value='$tb_jabatan[id_jabatan]'>$tb_jabatan[jabatan]</option>";
                                        }
                                    } ?>
                                </select>
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
    <div class="col-md-5">
        <div class="card">
            <div class="card-body">
                <h5 class="mb-4">Edit profil</h5>
                <form id="formEditProfil" enctype="multipart/form-data">
                    <input type="hidden" name="id_karyawan" value="<?= $tb_karyawan['id_karyawan'] ?>">
                    <div class="form-group d-flex justify-content-center pb-5">
                        <div class="position-relative w-25 h-25">
                            <img src="<?= base_url() ?>/img/karyawan/<?= $tb_karyawan['profil'] ?>" alt="profil" class="img-fluid b-radius-50deg" id="preview-profil" style="width: 125px; height: 125px;">
                            <input type="file" name="profil" id="profil" hidden>
                            <label for="profil" class="position-absolute cursor-pointer text-primary" style="right: 8px; bottom: 0;" data-tooltip="tooltip" title="Ukuran maksimum 3 MB dan Ekstensi harus jpg, jpeg atau png! disarankan 512x512">
                                <i class="fa fa-pen"></i>
                            </label>
                        </div>
                    </div>
                    <div class="modal fade animated zoomIn" id="modalKonfirmasiEditProfil" tabindex="-1" role="dialog" aria-labelledby="modalKonfirmasiEditProfilLabel" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
                            <div class="modal-content">
                                <div class="modal-header text-center">
                                    <h5 class="modal-title">Konfirmasi?</h5>
                                </div>
                                <div class="modal-body overflow-x-hidden">
                                    <h4>Foto profil akan disimpan!</h4>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-modal-false waves-effect" data-dismiss="modal" id="batal-simpan">Batal</button>
                                    <button type="submit" class="btn btn-modal-true waves-effect waves-ripple">Simpan</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <?php
    if (num_rows("SELECT * FROM j_karyawan WHERE id_karyawan = '$id_karyawan' LIMIT 1") == 0) {
        $j_karyawan = query("SELECT * FROM j_karyawan WHERE id_karyawan = 0 LIMIT 1");
        $senin = $j_karyawan['senin'];
        $masuk_mulai_senin = $j_karyawan['masuk_mulai_senin'];
        $masuk_akhir_senin = $j_karyawan['masuk_akhir_senin'];
        $pulang_mulai_senin = $j_karyawan['pulang_mulai_senin'];
        $pulang_akhir_senin = $j_karyawan['pulang_akhir_senin'];
        $selasa = $j_karyawan['selasa'];
        $masuk_mulai_selasa = $j_karyawan['masuk_mulai_selasa'];
        $masuk_akhir_selasa = $j_karyawan['masuk_akhir_selasa'];
        $pulang_mulai_selasa = $j_karyawan['pulang_mulai_selasa'];
        $pulang_akhir_selasa = $j_karyawan['pulang_akhir_selasa'];
        $rabu = $j_karyawan['rabu'];
        $masuk_mulai_rabu = $j_karyawan['masuk_mulai_rabu'];
        $masuk_akhir_rabu = $j_karyawan['masuk_akhir_rabu'];
        $pulang_mulai_rabu = $j_karyawan['pulang_mulai_rabu'];
        $pulang_akhir_rabu = $j_karyawan['pulang_akhir_rabu'];
        $kamis = $j_karyawan['kamis'];
        $masuk_mulai_kamis = $j_karyawan['masuk_mulai_kamis'];
        $masuk_akhir_kamis = $j_karyawan['masuk_akhir_kamis'];
        $pulang_mulai_kamis = $j_karyawan['pulang_mulai_kamis'];
        $pulang_akhir_kamis = $j_karyawan['pulang_akhir_kamis'];
        $jumat = $j_karyawan['jumat'];
        $masuk_mulai_jumat = $j_karyawan['masuk_mulai_jumat'];
        $masuk_akhir_jumat = $j_karyawan['masuk_akhir_jumat'];
        $pulang_mulai_jumat = $j_karyawan['pulang_mulai_jumat'];
        $pulang_akhir_jumat = $j_karyawan['pulang_akhir_jumat'];
        $sabtu = $j_karyawan['sabtu'];
        $masuk_mulai_sabtu = $j_karyawan['masuk_mulai_sabtu'];
        $masuk_akhir_sabtu = $j_karyawan['masuk_akhir_sabtu'];
        $pulang_mulai_sabtu = $j_karyawan['pulang_mulai_sabtu'];
        $pulang_akhir_sabtu = $j_karyawan['pulang_akhir_sabtu'];
        $minggu = $j_karyawan['minggu'];
        $masuk_mulai_minggu = $j_karyawan['masuk_mulai_minggu'];
        $masuk_akhir_minggu = $j_karyawan['masuk_akhir_minggu'];
        $pulang_mulai_minggu = $j_karyawan['pulang_mulai_minggu'];
        $pulang_akhir_minggu = $j_karyawan['pulang_akhir_minggu'];
    ?>
        <div class="col-md-7">
            <div class="card">
                <form id="formCustomJadwalAbsen" enctype="multipart/form-data">
                    <div class="card-body">
                        <div class="row mb-2">
                            <div class="col-md-6">
                                <h5 class="mb-4">Custom Jadwal Absen</h5>
                            </div>
                        </div>
                        <input type="hidden" name="id_karyawan" value="<?= $tb_karyawan['id_karyawan'] ?>">
                        <div class="row">
                            <div class="col-md-12 mb-3">
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="checkbox" name="senin" value="1" <?php echo ($senin == 1) ? 'checked' : ''; ?>>
                                    <label class="form-check-label">Senin</label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="checkbox" name="selasa" value="1" <?php echo ($selasa == 1) ? 'checked' : ''; ?>>
                                    <label class="form-check-label">Selasa</label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="checkbox" name="rabu" value="1" <?php echo ($rabu == 1) ? 'checked' : ''; ?>>
                                    <label class="form-check-label">Rabu</label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="checkbox" name="kamis" value="1" <?php echo ($kamis == 1) ? 'checked' : ''; ?>>
                                    <label class="form-check-label">Kamis</label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="checkbox" name="jumat" value="1" <?php echo ($jumat == 1) ? 'checked' : ''; ?>>
                                    <label class="form-check-label">Jumat</label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="checkbox" name="sabtu" value="1" <?php echo ($sabtu == 1) ? 'checked' : ''; ?>>
                                    <label class="form-check-label">Sabtu</label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="checkbox" name="minggu" value="1" <?php echo ($minggu == 1) ? 'checked' : ''; ?>>
                                    <label class="form-check-label">Minggu</label>
                                </div>
                            </div>
                            <div class="col-md-3 senin">
                                <div class="form-group">
                                    <label for="masuk_mulai">Masuk mulai senin</label>
                                    <input type="time" name="masuk_mulai_senin" id="masuk_mulai" class="form-control form-control4" value="<?= $masuk_mulai_senin ?>" required>
                                </div>
                            </div>
                            <div class="col-md-3 senin">
                                <div class="form-group">
                                    <label for="masuk_akhir">Masuk akhir senin</label>
                                    <input type="time" name="masuk_akhir_senin" id="masuk_akhir" class="form-control form-control4" value="<?= $masuk_akhir_senin ?>">
                                </div>
                            </div>
                            <div class="col-md-3 senin">
                                <div class="form-group">
                                    <label for="pulang_mulai">Pulang mulai senin</label>
                                    <input type="time" name="pulang_mulai_senin" id="pulang_mulai" class="form-control form-control4" value="<?= $pulang_mulai_senin ?>">
                                </div>
                            </div>
                            <div class="col-md-3 senin">
                                <div class="form-group">
                                    <label for="pulang_akhir">Pulang akhir senin</label>
                                    <input type="time" name="pulang_akhir_senin" id="pulang_akhir" class="form-control form-control4" value="<?= $pulang_akhir_senin ?>">
                                </div>
                            </div>
                            <div class="col-md-3 selasa">
                                <div class="form-group">
                                    <label for="masuk_mulai">Masuk mulai selasa</label>
                                    <input type="time" name="masuk_mulai_selasa" id="masuk_mulai" class="form-control form-control4" value="<?= $masuk_mulai_selasa ?>">
                                </div>
                            </div>
                            <div class="col-md-3 selasa">
                                <div class="form-group">
                                    <label for="masuk_akhir">Masuk akhir selasa</label>
                                    <input type="time" name="masuk_akhir_selasa" id="masuk_akhir" class="form-control form-control4" value="<?= $masuk_akhir_selasa ?>">
                                </div>
                            </div>
                            <div class="col-md-3 selasa">
                                <div class="form-group">
                                    <label for="pulang_mulai">Pulang mulai selasa</label>
                                    <input type="time" name="pulang_mulai_selasa" id="pulang_mulai" class="form-control form-control4" value="<?= $pulang_mulai_selasa ?>">
                                </div>
                            </div>
                            <div class="col-md-3 selasa">
                                <div class="form-group">
                                    <label for="pulang_akhir">Pulang akhir selasa</label>
                                    <input type="time" name="pulang_akhir_selasa" id="pulang_akhir" class="form-control form-control4" value="<?= $pulang_akhir_selasa ?>">
                                </div>
                            </div>
                            <div class="col-md-3 rabu">
                                <div class="form-group">
                                    <label for="masuk_mulai">Masuk mulai rabu</label>
                                    <input type="time" name="masuk_mulai_rabu" id="masuk_mulai" class="form-control form-control4" value="<?= $masuk_mulai_rabu ?>">
                                </div>
                            </div>
                            <div class="col-md-3 rabu">
                                <div class="form-group">
                                    <label for="masuk_akhir">Masuk akhir rabu</label>
                                    <input type="time" name="masuk_akhir_rabu" id="masuk_akhir" class="form-control form-control4" value="<?= $masuk_akhir_rabu ?>">
                                </div>
                            </div>
                            <div class="col-md-3 rabu">
                                <div class="form-group">
                                    <label for="pulang_mulai">Pulang mulai rabu</label>
                                    <input type="time" name="pulang_mulai_rabu" id="pulang_mulai" class="form-control form-control4" value="<?= $pulang_mulai_rabu ?>">
                                </div>
                            </div>
                            <div class="col-md-3 rabu">
                                <div class="form-group">
                                    <label for="pulang_akhir">Pulang akhir rabu</label>
                                    <input type="time" name="pulang_akhir_rabu" id="pulang_akhir" class="form-control form-control4" value="<?= $pulang_akhir_rabu ?>">
                                </div>
                            </div>
                            <div class="col-md-3 kamis">
                                <div class="form-group">
                                    <label for="masuk_mulai">Masuk mulai kamis</label>
                                    <input type="time" name="masuk_mulai_kamis" id="masuk_mulai" class="form-control form-control4" value="<?= $masuk_mulai_kamis ?>">
                                </div>
                            </div>
                            <div class="col-md-3 kamis">
                                <div class="form-group">
                                    <label for="masuk_akhir">Masuk akhir kamis</label>
                                    <input type="time" name="masuk_akhir_kamis" id="masuk_akhir" class="form-control form-control4" value="<?= $masuk_akhir_kamis ?>">
                                </div>
                            </div>
                            <div class="col-md-3 kamis">
                                <div class="form-group">
                                    <label for="pulang_mulai">Pulang mulai kamis</label>
                                    <input type="time" name="pulang_mulai_kamis" id="pulang_mulai" class="form-control form-control4" value="<?= $pulang_mulai_kamis ?>">
                                </div>
                            </div>
                            <div class="col-md-3 kamis">
                                <div class="form-group">
                                    <label for="pulang_akhir">Pulang akhir kamis</label>
                                    <input type="time" name="pulang_akhir_kamis" id="pulang_akhir" class="form-control form-control4" value="<?= $pulang_akhir_kamis ?>">
                                </div>
                            </div>
                            <div class="col-md-3 jumat">
                                <div class="form-group">
                                    <label for="masuk_mulai">Masuk mulai jumat</label>
                                    <input type="time" name="masuk_mulai_jumat" id="masuk_mulai" class="form-control form-control4" value="<?= $masuk_mulai_jumat ?>">
                                </div>
                            </div>
                            <div class="col-md-3 jumat">
                                <div class="form-group">
                                    <label for="masuk_akhir">Masuk akhir jumat</label>
                                    <input type="time" name="masuk_akhir_jumat" id="masuk_akhir" class="form-control form-control4" value="<?= $masuk_akhir_jumat ?>">
                                </div>
                            </div>
                            <div class="col-md-3 jumat">
                                <div class="form-group">
                                    <label for="pulang_mulai">Pulang mulai jumat</label>
                                    <input type="time" name="pulang_mulai_jumat" id="pulang_mulai" class="form-control form-control4" value="<?= $pulang_mulai_jumat ?>">
                                </div>
                            </div>
                            <div class="col-md-3 jumat">
                                <div class="form-group">
                                    <label for="pulang_akhir">Pulang akhir jumat</label>
                                    <input type="time" name="pulang_akhir_jumat" id="pulang_akhir" class="form-control form-control4" value="<?= $pulang_akhir_jumat ?>">
                                </div>
                            </div>
                            <div class="col-md-3 sabtu">
                                <div class="form-group">
                                    <label for="masuk_mulai">Masuk mulai sabtu</label>
                                    <input type="time" name="masuk_mulai_sabtu" id="masuk_mulai" class="form-control form-control4" value="<?= $masuk_mulai_sabtu ?>">
                                </div>
                            </div>
                            <div class="col-md-3 sabtu">
                                <div class="form-group">
                                    <label for="masuk_akhir">Masuk akhir sabtu</label>
                                    <input type="time" name="masuk_akhir_sabtu" id="masuk_akhir" class="form-control form-control4" value="<?= $masuk_akhir_sabtu ?>">
                                </div>
                            </div>
                            <div class="col-md-3 sabtu">
                                <div class="form-group">
                                    <label for="pulang_mulai">Pulang mulai sabtu</label>
                                    <input type="time" name="pulang_mulai_sabtu" id="pulang_mulai" class="form-control form-control4" value="<?= $pulang_mulai_sabtu ?>">
                                </div>
                            </div>
                            <div class="col-md-3 sabtu">
                                <div class="form-group">
                                    <label for="pulang_akhir">Pulang akhir sabtu</label>
                                    <input type="time" name="pulang_akhir_sabtu" id="pulang_akhir" class="form-control form-control4" value="<?= $pulang_akhir_sabtu ?>">
                                </div>
                            </div>
                            <div class="col-md-3 minggu">
                                <div class="form-group">
                                    <label for="masuk_mulai">Masuk mulai minggu</label>
                                    <input type="time" name="masuk_mulai_minggu" id="masuk_mulai" class="form-control form-control4" value="<?= $masuk_mulai_minggu ?>">
                                </div>
                            </div>
                            <div class="col-md-3 minggu">
                                <div class="form-group">
                                    <label for="masuk_akhir">Masuk akhir minggu</label>
                                    <input type="time" name="masuk_akhir_minggu" id="masuk_akhir" class="form-control form-control4" value="<?= $masuk_akhir_minggu ?>">
                                </div>
                            </div>
                            <div class="col-md-3 minggu">
                                <div class="form-group">
                                    <label for="pulang_mulai">Pulang mulai minggu</label>
                                    <input type="time" name="pulang_mulai_minggu" id="pulang_mulai" class="form-control form-control4" value="<?= $pulang_mulai_minggu ?>">
                                </div>
                            </div>
                            <div class="col-md-3 minggu">
                                <div class="form-group">
                                    <label for="pulang_akhir">Pulang akhir minggu</label>
                                    <input type="time" name="pulang_akhir_minggu" id="pulang_akhir" class="form-control form-control4" value="<?= $pulang_akhir_minggu ?>">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer">
                        <button type="submit" class="btn btn-linear-primary btn-block waves-effect waves-light">
                            Simpan perubahan
                        </button>
                    </div>
                </form>
            </div>
        </div>
    <?php } else {
        $j_karyawan = query("SELECT * FROM j_karyawan WHERE id_karyawan = '$id_karyawan' LIMIT 1");
        $id_j_karyawan = $j_karyawan['id_j_karyawan'];
        $senin = $j_karyawan['senin'];
        $masuk_mulai_senin = $j_karyawan['masuk_mulai_senin'];
        $masuk_akhir_senin = $j_karyawan['masuk_akhir_senin'];
        $pulang_mulai_senin = $j_karyawan['pulang_mulai_senin'];
        $pulang_akhir_senin = $j_karyawan['pulang_akhir_senin'];
        $selasa = $j_karyawan['selasa'];
        $masuk_mulai_selasa = $j_karyawan['masuk_mulai_selasa'];
        $masuk_akhir_selasa = $j_karyawan['masuk_akhir_selasa'];
        $pulang_mulai_selasa = $j_karyawan['pulang_mulai_selasa'];
        $pulang_akhir_selasa = $j_karyawan['pulang_akhir_selasa'];
        $rabu = $j_karyawan['rabu'];
        $masuk_mulai_rabu = $j_karyawan['masuk_mulai_rabu'];
        $masuk_akhir_rabu = $j_karyawan['masuk_akhir_rabu'];
        $pulang_mulai_rabu = $j_karyawan['pulang_mulai_rabu'];
        $pulang_akhir_rabu = $j_karyawan['pulang_akhir_rabu'];
        $kamis = $j_karyawan['kamis'];
        $masuk_mulai_kamis = $j_karyawan['masuk_mulai_kamis'];
        $masuk_akhir_kamis = $j_karyawan['masuk_akhir_kamis'];
        $pulang_mulai_kamis = $j_karyawan['pulang_mulai_kamis'];
        $pulang_akhir_kamis = $j_karyawan['pulang_akhir_kamis'];
        $jumat = $j_karyawan['jumat'];
        $masuk_mulai_jumat = $j_karyawan['masuk_mulai_jumat'];
        $masuk_akhir_jumat = $j_karyawan['masuk_akhir_jumat'];
        $pulang_mulai_jumat = $j_karyawan['pulang_mulai_jumat'];
        $pulang_akhir_jumat = $j_karyawan['pulang_akhir_jumat'];
        $sabtu = $j_karyawan['sabtu'];
        $masuk_mulai_sabtu = $j_karyawan['masuk_mulai_sabtu'];
        $masuk_akhir_sabtu = $j_karyawan['masuk_akhir_sabtu'];
        $pulang_mulai_sabtu = $j_karyawan['pulang_mulai_sabtu'];
        $pulang_akhir_sabtu = $j_karyawan['pulang_akhir_sabtu'];
        $minggu = $j_karyawan['minggu'];
        $masuk_mulai_minggu = $j_karyawan['masuk_mulai_minggu'];
        $masuk_akhir_minggu = $j_karyawan['masuk_akhir_minggu'];
        $pulang_mulai_minggu = $j_karyawan['pulang_mulai_minggu'];
        $pulang_akhir_minggu = $j_karyawan['pulang_akhir_minggu'];
    ?>
        <div class="col-md-7">
            <div class="card">
                <form id="formEditCustomJadwalAbsen" enctype="multipart/form-data">
                    <div class="card-body">
                        <div class="row mb-2">
                            <div class="col-md-6">
                                <h5 class="mb-4">Custom Jadwal Absen</h5>
                            </div>
                            <div class="col-md-6 text-right">
                                <button type="button" id="ResetCustomJadwal" class="btn btn-danger btn-sm">Reset Jadwal</button>
                            </div>
                        </div>
                        <input type="hidden" name="id_karyawan" value="<?= $tb_karyawan['id_karyawan'] ?>">
                        <input type="hidden" name="id_j_karyawan" value="<?= $id_j_karyawan ?>">
                        <div class="row">
                            <div class="col-md-12 mb-3">
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="checkbox" name="senin" value="1" <?php echo ($senin == 1) ? 'checked' : ''; ?>>
                                    <label class="form-check-label">Senin</label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="checkbox" name="selasa" value="1" <?php echo ($selasa == 1) ? 'checked' : ''; ?>>
                                    <label class="form-check-label">Selasa</label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="checkbox" name="rabu" value="1" <?php echo ($rabu == 1) ? 'checked' : ''; ?>>
                                    <label class="form-check-label">Rabu</label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="checkbox" name="kamis" value="1" <?php echo ($kamis == 1) ? 'checked' : ''; ?>>
                                    <label class="form-check-label">Kamis</label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="checkbox" name="jumat" value="1" <?php echo ($jumat == 1) ? 'checked' : ''; ?>>
                                    <label class="form-check-label">Jumat</label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="checkbox" name="sabtu" value="1" <?php echo ($sabtu == 1) ? 'checked' : ''; ?>>
                                    <label class="form-check-label">Sabtu</label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="checkbox" name="minggu" value="1" <?php echo ($minggu == 1) ? 'checked' : ''; ?>>
                                    <label class="form-check-label">Minggu</label>
                                </div>
                            </div>
                            <div class="col-md-3 senin">
                                <div class="form-group">
                                    <label for="masuk_mulai">Masuk mulai senin</label>
                                    <input type="time" name="masuk_mulai_senin" id="masuk_mulai" class="form-control form-control4" value="<?= $masuk_mulai_senin ?>" required>
                                </div>
                            </div>
                            <div class="col-md-3 senin">
                                <div class="form-group">
                                    <label for="masuk_akhir">Masuk akhir senin</label>
                                    <input type="time" name="masuk_akhir_senin" id="masuk_akhir" class="form-control form-control4" value="<?= $masuk_akhir_senin ?>">
                                </div>
                            </div>
                            <div class="col-md-3 senin">
                                <div class="form-group">
                                    <label for="pulang_mulai">Pulang mulai senin</label>
                                    <input type="time" name="pulang_mulai_senin" id="pulang_mulai" class="form-control form-control4" value="<?= $pulang_mulai_senin ?>">
                                </div>
                            </div>
                            <div class="col-md-3 senin">
                                <div class="form-group">
                                    <label for="pulang_akhir">Pulang akhir senin</label>
                                    <input type="time" name="pulang_akhir_senin" id="pulang_akhir" class="form-control form-control4" value="<?= $pulang_akhir_senin ?>">
                                </div>
                            </div>
                            <div class="col-md-3 selasa">
                                <div class="form-group">
                                    <label for="masuk_mulai">Masuk mulai selasa</label>
                                    <input type="time" name="masuk_mulai_selasa" id="masuk_mulai" class="form-control form-control4" value="<?= $masuk_mulai_selasa ?>">
                                </div>
                            </div>
                            <div class="col-md-3 selasa">
                                <div class="form-group">
                                    <label for="masuk_akhir">Masuk akhir selasa</label>
                                    <input type="time" name="masuk_akhir_selasa" id="masuk_akhir" class="form-control form-control4" value="<?= $masuk_akhir_selasa ?>">
                                </div>
                            </div>
                            <div class="col-md-3 selasa">
                                <div class="form-group">
                                    <label for="pulang_mulai">Pulang mulai selasa</label>
                                    <input type="time" name="pulang_mulai_selasa" id="pulang_mulai" class="form-control form-control4" value="<?= $pulang_mulai_selasa ?>">
                                </div>
                            </div>
                            <div class="col-md-3 selasa">
                                <div class="form-group">
                                    <label for="pulang_akhir">Pulang akhir selasa</label>
                                    <input type="time" name="pulang_akhir_selasa" id="pulang_akhir" class="form-control form-control4" value="<?= $pulang_akhir_selasa ?>">
                                </div>
                            </div>
                            <div class="col-md-3 rabu">
                                <div class="form-group">
                                    <label for="masuk_mulai">Masuk mulai rabu</label>
                                    <input type="time" name="masuk_mulai_rabu" id="masuk_mulai" class="form-control form-control4" value="<?= $masuk_mulai_rabu ?>">
                                </div>
                            </div>
                            <div class="col-md-3 rabu">
                                <div class="form-group">
                                    <label for="masuk_akhir">Masuk akhir rabu</label>
                                    <input type="time" name="masuk_akhir_rabu" id="masuk_akhir" class="form-control form-control4" value="<?= $masuk_akhir_rabu ?>">
                                </div>
                            </div>
                            <div class="col-md-3 rabu">
                                <div class="form-group">
                                    <label for="pulang_mulai">Pulang mulai rabu</label>
                                    <input type="time" name="pulang_mulai_rabu" id="pulang_mulai" class="form-control form-control4" value="<?= $pulang_mulai_rabu ?>">
                                </div>
                            </div>
                            <div class="col-md-3 rabu">
                                <div class="form-group">
                                    <label for="pulang_akhir">Pulang akhir rabu</label>
                                    <input type="time" name="pulang_akhir_rabu" id="pulang_akhir" class="form-control form-control4" value="<?= $pulang_akhir_rabu ?>">
                                </div>
                            </div>
                            <div class="col-md-3 kamis">
                                <div class="form-group">
                                    <label for="masuk_mulai">Masuk mulai kamis</label>
                                    <input type="time" name="masuk_mulai_kamis" id="masuk_mulai" class="form-control form-control4" value="<?= $masuk_mulai_kamis ?>">
                                </div>
                            </div>
                            <div class="col-md-3 kamis">
                                <div class="form-group">
                                    <label for="masuk_akhir">Masuk akhir kamis</label>
                                    <input type="time" name="masuk_akhir_kamis" id="masuk_akhir" class="form-control form-control4" value="<?= $masuk_akhir_kamis ?>">
                                </div>
                            </div>
                            <div class="col-md-3 kamis">
                                <div class="form-group">
                                    <label for="pulang_mulai">Pulang mulai kamis</label>
                                    <input type="time" name="pulang_mulai_kamis" id="pulang_mulai" class="form-control form-control4" value="<?= $pulang_mulai_kamis ?>">
                                </div>
                            </div>
                            <div class="col-md-3 kamis">
                                <div class="form-group">
                                    <label for="pulang_akhir">Pulang akhir kamis</label>
                                    <input type="time" name="pulang_akhir_kamis" id="pulang_akhir" class="form-control form-control4" value="<?= $pulang_akhir_kamis ?>">
                                </div>
                            </div>
                            <div class="col-md-3 jumat">
                                <div class="form-group">
                                    <label for="masuk_mulai">Masuk mulai jumat</label>
                                    <input type="time" name="masuk_mulai_jumat" id="masuk_mulai" class="form-control form-control4" value="<?= $masuk_mulai_jumat ?>">
                                </div>
                            </div>
                            <div class="col-md-3 jumat">
                                <div class="form-group">
                                    <label for="masuk_akhir">Masuk akhir jumat</label>
                                    <input type="time" name="masuk_akhir_jumat" id="masuk_akhir" class="form-control form-control4" value="<?= $masuk_akhir_jumat ?>">
                                </div>
                            </div>
                            <div class="col-md-3 jumat">
                                <div class="form-group">
                                    <label for="pulang_mulai">Pulang mulai jumat</label>
                                    <input type="time" name="pulang_mulai_jumat" id="pulang_mulai" class="form-control form-control4" value="<?= $pulang_mulai_jumat ?>">
                                </div>
                            </div>
                            <div class="col-md-3 jumat">
                                <div class="form-group">
                                    <label for="pulang_akhir">Pulang akhir jumat</label>
                                    <input type="time" name="pulang_akhir_jumat" id="pulang_akhir" class="form-control form-control4" value="<?= $pulang_akhir_jumat ?>">
                                </div>
                            </div>
                            <div class="col-md-3 sabtu">
                                <div class="form-group">
                                    <label for="masuk_mulai">Masuk mulai sabtu</label>
                                    <input type="time" name="masuk_mulai_sabtu" id="masuk_mulai" class="form-control form-control4" value="<?= $masuk_mulai_sabtu ?>">
                                </div>
                            </div>
                            <div class="col-md-3 sabtu">
                                <div class="form-group">
                                    <label for="masuk_akhir">Masuk akhir sabtu</label>
                                    <input type="time" name="masuk_akhir_sabtu" id="masuk_akhir" class="form-control form-control4" value="<?= $masuk_akhir_sabtu ?>">
                                </div>
                            </div>
                            <div class="col-md-3 sabtu">
                                <div class="form-group">
                                    <label for="pulang_mulai">Pulang mulai sabtu</label>
                                    <input type="time" name="pulang_mulai_sabtu" id="pulang_mulai" class="form-control form-control4" value="<?= $pulang_mulai_sabtu ?>">
                                </div>
                            </div>
                            <div class="col-md-3 sabtu">
                                <div class="form-group">
                                    <label for="pulang_akhir">Pulang akhir sabtu</label>
                                    <input type="time" name="pulang_akhir_sabtu" id="pulang_akhir" class="form-control form-control4" value="<?= $pulang_akhir_sabtu ?>">
                                </div>
                            </div>
                            <div class="col-md-3 minggu">
                                <div class="form-group">
                                    <label for="masuk_mulai">Masuk mulai minggu</label>
                                    <input type="time" name="masuk_mulai_minggu" id="masuk_mulai" class="form-control form-control4" value="<?= $masuk_mulai_minggu ?>">
                                </div>
                            </div>
                            <div class="col-md-3 minggu">
                                <div class="form-group">
                                    <label for="masuk_akhir">Masuk akhir minggu</label>
                                    <input type="time" name="masuk_akhir_minggu" id="masuk_akhir" class="form-control form-control4" value="<?= $masuk_akhir_minggu ?>">
                                </div>
                            </div>
                            <div class="col-md-3 minggu">
                                <div class="form-group">
                                    <label for="pulang_mulai">Pulang mulai minggu</label>
                                    <input type="time" name="pulang_mulai_minggu" id="pulang_mulai" class="form-control form-control4" value="<?= $pulang_mulai_minggu ?>">
                                </div>
                            </div>
                            <div class="col-md-3 minggu">
                                <div class="form-group">
                                    <label for="pulang_akhir">Pulang akhir minggu</label>
                                    <input type="time" name="pulang_akhir_minggu" id="pulang_akhir" class="form-control form-control4" value="<?= $pulang_akhir_minggu ?>">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer">
                        <button type="submit" class="btn btn-linear-primary btn-block waves-effect waves-light">
                            Simpan perubahan
                        </button>
                    </div>
                </form>
            </div>
        </div>
    <?php } ?>
</div>

<script>
    $('.kembali').click(function() {
        $('html, body').animate({
            scrollTop: '0'
        }, 200);
        history.pushState('karyawan', 'karyawan', '?menu=karyawan');
        $('#content').load('karyawan');
    });

    $('#formEditKaryawan').submit(function(e) {
        $('#btn-simpan').attr('disabled', 'disabled');
        $('#btn-simpan').html('<div class="spinner-border text-white" role="status"></div>');
        e.preventDefault();
        $.ajax({
            type: 'post',
            url: 'aksi?edit_karyawan',
            data: new FormData(this),
            contentType: false,
            processData: false,
            cache: false,
            success: function(data) {
                if (data == 'berhasil') {
                    $('html, body').animate({
                        scrollTop: '0'
                    }, 200);
                    pesan('Data karyawan berhasil disimpan', 3000);
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

    $('#profil').change(function() {
        var file = this.files[0];
        file_name = file.name;
        file_type = file.type;
        file_size = file.size;
        match = ['image/jpg', 'image/jpeg', 'image/png'];

        if (!((file_type == match[0]) || (file_type == match[1]) || (file_type == match[2]))) {
            pesan('Ekstensi foto harus jpg, jpeg atau png!', 5000);
            $(this).val('');
            return false;
        }
        if (file_size > 3000000) {
            pesan('Upload foto maksimal 3 MB!', 5000);
            $(this).val('');
            return false;
        } else {
            function imageIsLoaded(e) {
                $('#preview-profil').attr('src', e.target.result);
            }
            var reader = new FileReader();
            reader.onload = imageIsLoaded;
            reader.readAsDataURL(this.files[0]);
            $('#modalKonfirmasiEditProfil').modal('show');
        }
    });

    $('#batal-simpan').click(function() {
        $('#modalKonfirmasiEditProfil').modal('hide');
        pesan('Menyimpan foto profil dibatalkan', 3000);
        setTimeout(function() {
            $('#preview-profil').attr('src', '../img/karyawan/<?= $tb_karyawan['profil'] ?>');
        }, 300);
    });

    $('#formEditProfil').submit(function(e) {
        e.preventDefault();
        $.ajax({
            type: 'post',
            url: 'aksi?edit_profil_karyawan',
            data: new FormData(this),
            contentType: false,
            processData: false,
            cache: false,
            success: function(data) {
                if (data == 'berhasil') {
                    pesan('Foto profil berhasil disimpan', 3000);
                    $('#modalKonfirmasiEditProfil').modal('hide');
                } else {
                    pesan('Terdapat kesalahan pada sistem!', 3000);
                }
            }
        });
    });


    // New Dev
    $('#formCustomJadwalAbsen').submit(function(e) {
        e.preventDefault();
        $.ajax({
            type: 'post',
            url: 'aksi?custom_jadwal_absen_karyawan',
            data: new FormData(this),
            contentType: false,
            processData: false,
            cache: false,
            success: function(data) {
                if (data == 'berhasil') {
                    pesan('Custom jadwal absen karyawan berhasil', 3000);
                    history.pushState('karyawan', 'karyawan', '?menu=karyawan');
                    $('#content').load('karyawan');
                } else {
                    pesan('Terdapat kesalahan pada sistem!', 3000);
                }
            }
        });
    });
    $('#formEditCustomJadwalAbsen').submit(function(e) {
        e.preventDefault();
        $.ajax({
            type: 'post',
            url: 'aksi?edit_custom_jadwal_absen_karyawan',
            data: new FormData(this),
            contentType: false,
            processData: false,
            cache: false,
            success: function(data) {
                if (data == 'berhasil') {
                    pesan('Custom jadwal absen karyawan berhasil', 3000);
                    history.pushState('karyawan', 'karyawan', '?menu=karyawan');
                    $('#content').load('karyawan');
                } else {
                    pesan('Terdapat kesalahan pada sistem!', 3000);
                }
            }
        });
    });
    $('#ResetCustomJadwal').click(function() {
        var id_j_karyawan = $("input[name='id_j_karyawan']").val();
         Swal.fire({
            title: 'Konfirmasi?',
            text: 'Jadwal akan dikembalikan ke settingan sistem!',
            showCancelButton: true,
            confirmButtonColor: '#4086EF',
            confirmButtonText: 'Yakin',
            cancelButtonText: 'Batal'
         }).then((result) => {
            if (result.value) {
               $.ajax({
                  type: 'post',
                  url: 'aksi?hapus_custom_jadwal_absen_karyawan',
                  data: {
                     id_j_karyawan: id_j_karyawan
                  },
                  success: function(data) {
                     if (data == 'berhasil') {
                        pesan('Jadwal dikembalikan ke settingan sistem berhasil', 3000);
                        $('#content').load('karyawan');
                     } else {
                        pesan('Terdapat kesalahan pada sistem!', 3000);
                     }
                  }
               });
            }
         });
      });


    $(document).ready(function() {
        // Sembunyikan semua kolom ketika halaman dimuat
        $('input[type="checkbox"]').each(function() {
            var checkBoxName = $(this).attr('name');

            // Periksa status checkbox pada saat halaman dimuat
            if ($(this).is(':checked')) {
                $('.' + checkBoxName).show().find('input[type="time"]').prop('required', true);
            } else {
                $('.' + checkBoxName).hide().find('input[type="time"]').prop('required', false).val(null);
            }
        });

        // Deteksi perubahan pada checkbox
        $('input[type="checkbox"]').change(function() {
            var checkBoxName = $(this).attr('name');

            // Tampilkan atau sembunyikan kolom berdasarkan status centang pada checkbox
            if ($(this).is(':checked')) {
                $('.' + checkBoxName).show().find('input[type="time"]').prop('required', true);
            } else {
                $('.' + checkBoxName).hide().find('input[type="time"]').prop('required', false).val(null);;
            }
        });
    });
</script>
