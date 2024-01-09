setInterval(function () {
   if (navigator.onLine == false) {
      $('.modal').modal('hide');
      $('#modalNavigatorOnline').modal('show');
   } else {
      $('#modalNavigatorOnline').modal('hide');
   }
}, 10000);

$(function () {
   $('.overlay-scrollbars').overlayScrollbars({
      className: "os-theme-dark",
      scrollbars: {
         autoHide: 'l',
         autoHideDelay: 0
      }
   });
});

$('[data-tooltip="tooltip"]').tooltip();

$('#click-tema-terang').hide();
$('#click-tema-gelap').click(function () {
   $('.topbar').addClass('tema-gelap');
   $('.menu-utama').addClass('tema-gelap');
   $('.copyright').addClass('tema-gelap');
   $(this).hide();
   $('#click-tema-terang').show();
});

$('#click-tema-terang').click(function () {
   $('.topbar').removeClass('tema-gelap');
   $('.menu-utama').removeClass('tema-gelap');
   $('.copyright').removeClass('tema-gelap');
   $('.info-waktu-warning').removeClass('tema-gelap');
   $('.info-waktu-danger').removeClass('tema-gelap');
   $(this).hide();
   $('#click-tema-gelap').show();
});

$('.click-logout').click(function () {
   loader(500);
   setTimeout(function () {
      window.location.href = '../logout';
   }, 500);
});

$('#click-absen-masuk, #click-absen-masuk-terlambat').click(function () {
   Webcam.set({
      width: 184,
      height: 230,
      image_format: 'jpeg',
      jpeg_quality: 90
   });
   Webcam.attach('#my_camera');

   if (geo_position_js.init()) {
      geo_position_js.getCurrentPosition(success_callback, error_callback, {
         enableHighAccuracy: true
      });
   } else {
      pesan('Tidak ada fungsi geolocation', 3000);
      return false;
   }

   function success_callback(p) {
      latitude = p.coords.latitude;
      longitude = p.coords.longitude;
      $('#latitude').val(latitude);
      $('#longitude').val(longitude);

      $('#modalAbsenMasuk').modal('show');
      $('#modalAbsenMasukTerlambat').modal('show');
   }

   function error_callback(p) {
      pesan('error = ' + p.message, 3000);
      return false;
   }
})

$('#formAbsenMasuk, #formAbsenMasukTerlambat').submit(function (e) {
    e.preventDefault();

    Webcam.snap(function (data_uri) {
        $('#m_foto').val(data_uri);
    });

    let dataa = new FormData(this);

    // get data settings
    let allText = "";

    var rawFile = new XMLHttpRequest();
    rawFile.open("GET", "../../../baseUrl.txt", false);
    rawFile.onreadystatechange = function ()
    {
        if(rawFile.readyState === 4)
        {
            if(rawFile.status === 200 || rawFile.status == 0)
            {
                allText = rawFile.responseText;
            }
        }
    }
    rawFile.send(null);

    const url = allText + "/api/settings";

    fetch(url)
    .then((resp) => resp.json())
    .then(function(data) {
        let databanget = data.data;

        Number.prototype.toRad = function () {
            return this * Math.PI / 180;
        }

        // default sistem
        var lat2 = parseFloat(databanget.latitude_instansi);
        var lon2 = parseFloat(databanget.longitude_instansi);

        // user location
        var lat1 = latitude;
        var lon1 = longitude;

        var R = 6371; // km
        //has a problem with the .toRad() method below.
        var x1 = lat2 - lat1;
        var dLat = x1.toRad();
        var x2 = lon2 - lon1;
        var dLon = x2.toRad();
        var a = Math.sin(dLat / 2) * Math.sin(dLat / 2) +
            Math.cos(lat1.toRad()) * Math.cos(lat2.toRad()) *
            Math.sin(dLon / 2) * Math.sin(dLon / 2);
        var c = 2 * Math.atan2(Math.sqrt(a), Math.sqrt(1 - a));
        var d = R * c;
        var e = d / 0.0010000;

        var meter = e.toString().split('.')[0];

        if ($("#m_alasan_text").val() == "hadir" && databanget.hadir_radius == 1) {
            if (meter > parseInt(databanget.radius_meter)) {
                pesan("Anda berada di " + meter + " meter dari jangkauan", 3000);
                return false;
            }
        }

        if ($("#m_alasan_text").val() == "izin" && databanget.izin_radius == 1) {
            if (meter > parseInt(databanget.radius_meter)) {
                pesan("Anda berada di " + meter + " meter dari jangkauan", 3000);
                return false;
            }
        }

        if ($("#m_alasan_text").val() == "sakit" && databanget.sakit_radius == 1) {
            if (meter > parseInt(databanget.radius_meter)) {
                pesan("Anda berada di " + meter + " meter dari jangkauan", 3000);
                return false;
            }
        }

        $('#btn-absen-masuk').attr('disabled', 'disabled');
        $('#btn-absen-masuk').html('<div class="spinner-border text-white" role="status"></div>');


        $.ajax({
            type: 'post',
            url: 'aksi-absen?absen_masuk',
            data: dataa,
            contentType: false,
            processData: false,
            cache: false,
            success: function (data) {
            if (data == 'berhasil') {
                window.location.href = 'terimakasih';
            }

            if (data == 'gagal') {
                pesan('Terdapat kesalahan pada sistem!', 3000);
                $('#btn-absen-masuk').removeAttr('disabled', 'disabled');
                $('#btn-absen-masuk').html('Masuk');
             }
          }
       });

    })
    .catch(function(error) {
        pesan(error, 3000);
    });


});

$('#click-absen-pulang').click(function () {
   Webcam.set({
      width: 184,
      height: 230,
      image_format: 'jpeg',
      jpeg_quality: 90
   });
   Webcam.attach('#my_camera_pulang');

   if (geo_position_js.init()) {
      geo_position_js.getCurrentPosition(success_callback, error_callback, {
         enableHighAccuracy: true
      });
   } else {
      pesan('Tidak ada fungsi geolocation', 3000);
      return false;
   }

   function success_callback(p) {
      latitude = p.coords.latitude;
      longitude = p.coords.longitude;
      $('#latitude_pulang').val(latitude);
      $('#longitude_pulang').val(longitude);

      // get data settings
        let allText = "";

        var rawFile = new XMLHttpRequest();
        rawFile.open("GET", "../../../baseUrl.txt", false);
        rawFile.onreadystatechange = function ()
        {
            if(rawFile.readyState === 4)
            {
                if(rawFile.status === 200 || rawFile.status == 0)
                {
                    allText = rawFile.responseText;
                }
            }
        }
        rawFile.send(null);

        const url = allText + "/api/settings";

        fetch(url)
        .then((resp) => resp.json())
        .then(function(data) {
          let databanget = data.data;

          Number.prototype.toRad = function () {
            return this * Math.PI / 180;
            }

            // default sistem
            var lat2 = parseFloat(databanget.latitude_instansi);
            var lon2 = parseFloat(databanget.longitude_instansi);

            // user location
            var lat1 = latitude;
            var lon1 = longitude;

            var R = 6371; // km
            //has a problem with the .toRad() method below.
            var x1 = lat2 - lat1;
            var dLat = x1.toRad();
            var x2 = lon2 - lon1;
            var dLon = x2.toRad();
            var a = Math.sin(dLat / 2) * Math.sin(dLat / 2) +
                Math.cos(lat1.toRad()) * Math.cos(lat2.toRad()) *
                Math.sin(dLon / 2) * Math.sin(dLon / 2);
            var c = 2 * Math.atan2(Math.sqrt(a), Math.sqrt(1 - a));
            var d = R * c;
            var e = d / 0.0010000;

            var meter = e.toString().split('.')[0];

            if (meter > parseInt(databanget.radius_meter)) {
                pesan("Anda berada di " + meter + " meter dari jangkauan", 3000);
            } else {
                $('#modalAbsenPulang').modal('show');
            }
        })
        .catch(function(error) {
          pesan(error, 3000);
        });
   }

   function error_callback(p) {
      pesan('error = ' + p.message, 3000);
      return false;
   }


});

$('#formAbsenPulang').submit(function (e) {
   Webcam.snap(function (data_uri) {
      $('#p_foto').val(data_uri);
   });


   $('#btn-absen-pulang').attr('disabled', 'disabled');
   $('#btn-absen-pulang').html('<div class="spinner-border text-white" role="status"></div>');

   e.preventDefault();
   $.ajax({
      type: 'post',
      url: 'aksi-absen?absen_pulang',
      data: new FormData(this),
      contentType: false,
      processData: false,
      cache: false,
      success: function (data) {
         if (data == 'berhasil') {
            window.location.href = 'terimakasih';
         } else {
            pesan('Terdapat kesalahan pada sistem!', 3000);
            $('#click-absen-pulang').removeAttr('disabled', 'disabled');
            $('#click-absen-pulang').html('Pulang');
         }
      }
   });
})

$('.click-profil').click(function () {
   window.location.href = 'profil';
})

$('#btn-radio-hadir').click(function() {
    $('#m_alasan_text').val('hadir');
    $('#m_ket').val('Hadir');
});

$('#btn-radio-izin').click(function() {
    $('#m_alasan_text').val('izin');
    $('#m_ket').val("");
});

$('#btn-radio-sakit').click(function() {
    $('#m_alasan_text').val('sakit');
    $('#m_ket').val("");
});
