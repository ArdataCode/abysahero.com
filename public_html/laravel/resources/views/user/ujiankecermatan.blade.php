@extends('layouts.Skydash')
<!-- partial -->
@section('content')
<div class="content-wrapper">
  <div class="row">
    <div class="col-md-12">
      <div class="row">
        <div class="col-xl-9 col-md-9 col-sm-9 col-xs-9">
          <h3 class="font-weight-bold text-primary" style="text-align:center;margin-bottom:15px">{{$upaketsoalmst->judul}}</h3>
          <table class="table table-sm">
            <tbody>
              <tr style="border-style: hidden;">
                <td width="20%">Total Soal</td>
                <td>: {{$upaketsoalmst->total_soal}} Butir Master / {{count($upaketsoaldtl)}} Butir Detail</td>
              </tr>
            </tbody>
          </table>
          <br>
        </div>
        <div class="col-xl-3 col-md-3 col-sm-3 col-xs-3">
            <button type="button" class="btn btn-danger btn-sm _btn-waktu">
              <h6 id="end">Waktu Tersisa<br><span id="hours"></span><span id="mins"></span><span id="secs"></span></h6>
            </button>
            <!-- <p id="days" style="display:hidden"></p> -->
              <!-- <p id="hours"></p>
              <p id="mins"></p>
              <p id="secs"></p> -->
              <!-- <h2 id="end"></h2> -->
        </div>
      </div>
    </div>
  </div>
  <div class="row">
    <div class="col-xl-9 col-md-9 col-sm-9 col-xs-9">
      <div class="soal_master">
          <div class="row">
              <div class="d-none d-lg-block d-md-block col-sm-4">
                  <h6 class="text-danger" style="text-align:center;padding-top:75px">Perhatikan kotak di bawah ini</h6>
                  <a class="arrow down">Down</a>
              </div>
              <div class="col-sm-8">
                <div class="table-responsive">
                  <table class="table table-bordered" style="margin-bottom:0">
                      <tbody>
                        <tr>
                          @foreach(json_decode($soalmst->karakter) as $loopdatamaster)
                          <td><h2><b>{{$loopdatamaster}}</b></h2></td>
                          @endforeach
                        </tr>
                        <tr>
                          @foreach(json_decode($soalmst->kiasan) as $loopdatamaster)
                          <td><h5><b>{{$loopdatamaster}}</b></h5></td>
                          @endforeach
                        </tr>
                      </tbody>
                  </table>
                </div>
              </div>
              <div class="d-block d-lg-none d-md-none col-sm-4">
                  <h6 class="text-danger" style="text-align:center;padding-top:75px">Perhatikan kotak di bawah ini</h6>
                  <a class="arrow down">Down</a>
              </div>
          </div>
      </div>
      <div class="row">
        <div class="col-lg-4 col-md-4">
          <div class="_soal_content_kecermatan tab-content" id="pills-tabContent">
            @foreach($soalmst->u_paket_soal_kecermatan_soal_dtl_r as $key)
            <div class="soaldtl tab-pane fade" idsoaldtl="{{$key->id}}" detik_mulai="{{$key->detik_mulai}}" detik_akhir="{{$key->detik_akhir}}" id="pills-{{$key->id}}" role="tabpanel">
              <div class="parent">
                @foreach(json_decode($key->soal) as $loopdatadtl)
                  <div class="child"><h2 style="margin-bottom:0rem">{{$loopdatadtl}}</h2></div>
                @endforeach
              </div>
            </div>
            @endforeach
          </div>
          <div class="soal_dtl_bawah">
            <div class="parent">
              @foreach(json_decode($soalmst->kiasan) as $loopdatamaster)
                <div class="child">
                  <h5>{{$loopdatamaster}}</h5>
                    <div class="form-check">
                      <label class="form-check-label">
                        <input type="radio" class="form-check-input _radio" name="radio_{{$key->id}}" value="{{$loopdatamaster}}">
                        <i class="input-helper"></i></label>
                    </div>  
                </div>
              @endforeach
            </div>
          </div>
        </div>
      </div>
    </div>
    <div class="col-xl-3 col-md-3 col-sm-3 col-xs-3">   
    <div>
      <button type="button" data-bs-toggle="modal" data-bs-target="#modalselesaiujian" class="btn btn-success btn-sm _btn_selesai_ujian _btn-waktu">
        <h6>Selesaikan Ujian</h6>
      </button>
    </div>
    </div>
  </div>
</div>

<div class="modal fade" id="modalselesaiujian">
  <div class="modal-dialog">
    <div class="modal-content">

      <!-- Modal Header -->
      <div class="modal-header">
        <h4 class="modal-title">Selesaikan Ujian?</h4>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
      </div>

      <!-- Modal body -->
      <div class="modal-body">
        <h4>Jika anda menyelesaikan ujian, anda tidak dapat lagi mengubah jawaban sebelumnya. Apakah anda yakin untuk menyelesaikan ujian ini?</h4>
      </div>

      <!-- Modal footer -->
      <div class="modal-footer" style="display:block;text-align: right;">
        <button type="button" class="btn btn-default" data-bs-dismiss="modal">Tidak</button>
        <button type="button" class="btn btn-danger" id="btn-selesai" soalmst="{{Crypt::encrypt($soalmst->id)}}">Ya</button>
      </div>

    </div>
  </div>
</div>
@endsection

@section('footer')
<!-- jQuery -->
<!-- SweetAlert2 -->
<script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
  
  $(document).ready(function(){
      $('[data-toggle="tooltip"]').tooltip({
          trigger : 'hover'
      });

      $(document).on('click', '#btn-selesai', function (e) {
          idpaketmst = "{{Crypt::encrypt($upaketsoalmst->id)}}";
          $.ajaxSetup({
              headers: {
                  'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
              }
          });
          $.ajax({
              type: "POST",
              dataType: "JSON",
              url: "{{url('selesaiujiankecermatanfix')}}",
              // async: false,
              data: {
                idpaketmst : idpaketmst
              },
              beforeSend: function () {
                  $.LoadingOverlay("show", {
                      image       : "{{asset('/image/global/loading.gif')}}"
                  });
              },
              success: function(response)
              {
                if (response.status) {
                    $('.modal').modal('hide');
                    Swal.fire({
                        html: 'Jawaban telah tersimpan. Ujian selesai!',
                        icon: 'success',
                        showConfirmButton: true
                    }).then((result) => {
                        $.LoadingOverlay("show", {
                          image       : "{{asset('/image/global/loading.gif')}}"
                        });
                        reload_url(1500,'{{url("hasilujian")}}');
                    });
                }else{
                    Swal.fire({
                        html: response.message,
                        icon: 'error',
                        confirmButtonText: 'Ok'
                    });
                }
              },
              error: function (xhr, status) {
                    alert('Error!!!');
                },
                complete: function () {
                    $.LoadingOverlay("hide");
                }
            });
        });

      $(document).on('change', '._radio', function (e) {
          jawaban = $(this).val();
          idpaketdl = $('.soaldtl.tab-pane.fade.show.active').attr('idsoaldtl');
          if(idpaketdl){
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.ajax({
                type: "POST",
                dataType: "JSON",
                url: "{{url('updatejawabankecermatan')}}",
                // async: false,
                data: {
                  jawaban : jawaban,
                  idpaketdl : idpaketdl
                },
                beforeSend: function () {
                    // $.LoadingOverlay("show", {
                    //     image       : "{{asset('/image/global/loading.gif')}}"
                    // });
                },
                success: function(response)
                {
                  
                },
                error: function (xhr, status) {
                      alert('Error!!!');
                  },
                  complete: function () {
                      // $.LoadingOverlay("hide");
                  }
              });
          }else{
            Swal.fire({
                html: "Tunggu soal muncul terlebih dahulu",
                icon: 'warning',
                confirmButtonText: 'Ok'
            });
            $('._radio').prop('checked', false);
          }

      });

      // COUNDOWN
      // The data/time we want to countdown to
      var countDownDate = new Date("{{$soalmst->selesai}}").getTime();

      i=0;
      // Run myfunc every second
      var myfunc = setInterval(function() {

      const now = new Date('{{$now}}');
      now.setSeconds(now.getSeconds() + i);
      i++;

      var timeleft = (countDownDate - now) + 5000;
      var strdetik = Math.floor(timeleft / 1000);

      $('.tab-pane').each(function(i, obj) {
          detik_mulai = $(this).attr('detik_mulai');
          detik_akhir = $(this).attr('detik_akhir');
          if(strdetik<=detik_mulai && strdetik>=detik_akhir){
            var str = $(this).attr('class'), st = "show active";
            if(str.indexOf(st) > -1)
            {

            }else{
              $('.tab-pane').removeClass('show active');
              $(this).addClass('show active');
              $('._radio').prop('checked', false);
            }
          }
      });
  
      // Calculating the days, hours, minutes and seconds left
      // var days = Math.floor(timeleft / (1000 * 60 * 60 * 24));
      var hours = Math.floor((timeleft % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
      var minutes = Math.floor((timeleft % (1000 * 60 * 60)) / (1000 * 60));
      var seconds = Math.floor((timeleft % (1000 * 60)) / 1000);
          
      // Result is output to the specific element
      // document.getElementById("days").innerHTML = days + ""
      document.getElementById("hours").innerHTML = hours + " Jam " 
      document.getElementById("mins").innerHTML = minutes + " Menit " 
      document.getElementById("secs").innerHTML = seconds + " Detik" 
          
      // console.log(timeleft);
      // Display the message when countdown is over
      if (timeleft < 0) {
          clearInterval(myfunc);
          // document.getElementById("days").innerHTML = ""
          // document.getElementById("hours").innerHTML = "" 
          // document.getElementById("mins").innerHTML = ""
          // document.getElementById("secs").innerHTML = ""
          document.getElementById("end").innerHTML = "Mohon Tunggu...";

          idsoalmst = $('#btn-selesai').attr('soalmst');
          $.ajaxSetup({
              headers: {
                  'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
              }
          });
          $.ajax({
              type: "POST",
              dataType: "JSON",
              url: "{{url('selesaiujiankecermatan')}}",
              // async: false,
              data: {
                idsoalmst : idsoalmst
              },
              beforeSend: function () {
                  $.LoadingOverlay("show", {
                      image       : "{{asset('/image/global/loading.gif')}}"
                  });
              },
              success: function(response)
              {
                if (response.status) {
                    if(response.isterakhir=='ya'){
                        $('.modal').modal('hide');
                        Swal.fire({
                            html: 'Jawaban telah tersimpan, Ujian selesai',
                            icon: 'success',
                            showConfirmButton: true
                        }).then((result) => {
                            $.LoadingOverlay("show", {
                              image       : "{{asset('/image/global/loading.gif')}}"
                            });
                            reload_url(1500,'{{url("hasilujian")}}');
                        })
                    }else{
                      $.LoadingOverlay("show", {
                        image       : "{{asset('/image/global/loading.gif')}}"
                      });
                      reload(500);
                    }
                }else{
                    Swal.fire({
                        html: response.message,
                        icon: 'error',
                        confirmButtonText: 'Ok'
                    });
                }
              },
              error: function (xhr, status) {
                    alert('Error!!!');
                },
                complete: function () {
                    $.LoadingOverlay("hide");
                }
            });
        }
      }, 1000);
      // END COUNDOWN
  });
</script>
<!-- Loading Overlay -->
@endsection


