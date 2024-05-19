@extends('layouts.Skydash')
<!-- partial -->
@section('content')
<div class="content-wrapper">
  <div class="row">
    <div class="col-md-12">
      <div class="row">
        <div class="col-xl-9 col-md-9 col-sm-9 col-xs-9">
          <h2 class="font-weight-bold text-primary" style="text-align:center;margin-bottom:15px">{{$upaketsoalmst->judul}}</h2>
          <table class="table table-sm">
            <tbody>
              <tr style="border-style: hidden;">
                <td width="40%">Total Soal</td>
                <td>: {{$upaketsoalmst->total_soal}} Butir</td>
              </tr>
              @foreach($upaketsoalmst->u_paket_soal_ktg_r as $key)
              <!-- <tr style="border-style: hidden;">
                <td>{{$key->judul}}</td>
                <td>: {{$key->jumlah_soal}} Butir</td>
              </tr> -->
              @endforeach
              <tr style="border-style: hidden;">
                <td>Waktu</td>
                <td>: {{$upaketsoalmst->waktu}} Menit</td>
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
    <div class="_soal_content tab-content" id="pills-tabContent">
      @foreach($upaketsoalmst->u_paket_soal_dtl_r as $key)
      <div class="tab-pane fade {{$key->no_soal==1 ? 'show active' : ''}}" id="pills-{{$key->id}}" role="tabpanel">
          <h4 class="ktg-soal">Kategori {{$key->u_paket_soal_ktg_r->judul}}</h4>
          <div class="_nosoal">{{$key->no_soal}})</div><div class="_soal">{!!$key->soal!!}</div>
          <div class="form-group">
            <div class="form-check">
              <label class="form-check-label">
                <input type="radio" class="form-check-input _radio" idpaketdtl="{{$key->id}}" name="radio_{{$key->id}}" value="a" {{$key->jawaban_user=="a" ? "checked='checked'" : ""}}>
                <i class="input-helper"></i></label>
                <div class="_pilihan">
                  <span><b>a.</b> </span>
                  <div class="_pilihan_isi">
                    {!!$key->a!!}
                  </div>
                </div>
            </div>
            <div class="form-check">
              <label class="form-check-label">
                <input type="radio" class="form-check-input _radio" idpaketdtl="{{$key->id}}" name="radio_{{$key->id}}" value="b" {{$key->jawaban_user=="b" ? "checked" : ""}}>
                <i class="input-helper"></i></label>
                <div class="_pilihan">
                  <span><b>b.</b> </span>
                  <div class="_pilihan_isi">
                    {!!$key->b!!}
                  </div>
                </div>
            </div>
            <div class="form-check">
              <label class="form-check-label">
                <input type="radio" class="form-check-input _radio" idpaketdtl="{{$key->id}}" name="radio_{{$key->id}}" value="c" {{$key->jawaban_user=="c" ? "checked" : ""}}>
                <i class="input-helper"></i></label>
                <div class="_pilihan">
                  <span><b>c.</b> </span>
                  <div class="_pilihan_isi">
                    {!!$key->c!!}
                  </div>
                </div>
            </div>
            <div class="form-check">
              <label class="form-check-label">
                <input type="radio" class="form-check-input _radio" idpaketdtl="{{$key->id}}" name="radio_{{$key->id}}" value="d" {{$key->jawaban_user=="d" ? "checked" : ""}}>
                <i class="input-helper"></i></label>
                <div class="_pilihan">
                  <span><b>d.</b> </span>
                  <div class="_pilihan_isi">
                    {!!$key->d!!}
                  </div>
                </div>
            </div>
            <div class="form-check">
              <label class="form-check-label">
                <input type="radio" class="form-check-input _radio" idpaketdtl="{{$key->id}}" name="radio_{{$key->id}}" value="e" {{$key->jawaban_user=="e" ? "checked" : ""}}>
                <i class="input-helper"></i></label>
                <div class="_pilihan">
                  <span><b>e.</b> </span>
                  <div class="_pilihan_isi">
                    {!!$key->e!!}
                  </div>
                </div>
            </div>
          </div>
          <div style="padding-bottom:30px">
            <span>
              @if (!$loop->first)
              <button idsoal="{{$key->id - 1}}" type="button" class="btn-next-back btn btn-sm btn-primary btn-rounded btn-fw">
                <i class="ti-back-left btn-icon-prepend"></i>                                                    
                Sebelumnya
              </button>
              @endif
            </span>
            <span style="float:right;padding-bottom:30px">
              @if (!$loop->last)
              <button idsoal="{{$key->id + 1}}" type="button" class="btn-next-back btn btn-sm btn-primary btn-rounded btn-fw">
                <i class="ti-back-right btn-icon-prepend"></i>                                                    
                Selanjutnya
              </button>
              @endif
            </span>
          </div>
      </div>
      <!-- <div class="tab-pane fade show active" id="pills-profile" role="tabpanel" aria-labelledby="pills-profile-tab">2</div> -->
      @endforeach

    </div>
    </div>
    <div class="col-xl-3 col-md-3 col-sm-3 col-xs-3">
    <ul class="_soal nav nav-pills mb-3" id="pills-tab" role="tablist">
      @foreach($upaketsoalmst->u_paket_soal_dtl_r as $key)
      <!-- <li class="nav-item" role="presentation">
        <button class="nav-link active" id="pills-home-tab" data-bs-toggle="pill" data-bs-target="#pills-home" type="button" role="tab" aria-controls="pills-home" aria-selected="true">1</button>
      </li> -->
      <li class="nav-item" role="presentation">
        <button id="btn_no_soal_{{$key->id}}" class="{{$key->jawaban_user ? '_ada_isi' : ''}} nav-link {{$key->no_soal==1 ? 'active' : ''}}" data-bs-toggle="pill" data-bs-target="#pills-{{$key->id}}" type="button" role="tab" aria-selected="true">{{$key->no_soal}}</button>
      </li>
      @endforeach
    </ul>
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
        <button type="button" class="btn btn-danger" id="btn-selesai" upaketsoalmst="{{Crypt::encrypt($upaketsoalmst->id)}}">Ya</button>
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
  // window.onbeforeunload = function() {
  //     return "Yakin ingin keluar dari halaman ini!";
  // };
  $(document).ready(function(){
      $('[data-toggle="tooltip"]').tooltip({
          trigger : 'hover'
      });

      $(document).on('click', '.btn-next-back', function (e) {
          idsoal = $(this).attr('idsoal');
          $('.tab-pane').removeClass('show active');
          $('.nav-link').removeClass('active');

          $('#pills-'+idsoal).addClass('show active');
          $('#btn_no_soal_'+idsoal).addClass('active');
      });

      $(document).on('change', '._radio', function (e) {
          jawaban = $(this).val();
          idpaketdl = $(this).attr('idpaketdtl');
          $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.ajax({
                type: "POST",
                dataType: "JSON",
                url: "{{url('updatejawaban')}}",
                // async: false,
                data: {
                  jawaban : jawaban,
                  idpaketdl : idpaketdl
                },
                beforeSend: function () {
                    $.LoadingOverlay("show", {
                        image       : "{{asset('/image/global/loading.gif')}}"
                    });
                },
                success: function(response)
                {
                  if (response.status) {
                      $('#btn_no_soal_'+idpaketdl).addClass('_ada_isi');
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


      $(document).on('click', '#btn-selesai', function (e) {
          idpaketmst = $('#btn-selesai').attr('upaketsoalmst');
          $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.ajax({
                type: "POST",
                dataType: "JSON",
                url: "{{url('selesaiujian')}}",
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
                      document.getElementById("end").innerHTML = "UJIAN SELESAI!!";
                        Swal.fire({
                            html: response.message,
                            icon: 'success',
                            showConfirmButton: true
                        }).then((result) => {
                            $.LoadingOverlay("show", {
                              image       : "{{asset('/image/global/loading.gif')}}"
                            });
                            reload_url(1500,'{{url("hasilujian")}}');
                        })

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

      // COUNDOWN
      // The data/time we want to countdown to
      var countDownDate = new Date("{{$upaketsoalmst->selesai}}").getTime();

      // Run myfunc every second
      i = 0;
      var myfunc = setInterval(function() {

      const now = new Date('{{$now}}');
      now.setSeconds(now.getSeconds() + i);
      i++;
      // console.log(date.setSeconds(date.getSeconds() + 5));

      // var now = new Date().getTime();
      var timeleft = countDownDate - now;
          
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
          
      // Display the message when countdown is over
      if (timeleft < 0) {
          clearInterval(myfunc);
          // document.getElementById("days").innerHTML = ""
          // document.getElementById("hours").innerHTML = "" 
          // document.getElementById("mins").innerHTML = ""
          // document.getElementById("secs").innerHTML = ""
          document.getElementById("end").innerHTML = "UJIAN SELESAI!!";

          idpaketmst = $('#btn-selesai').attr('upaketsoalmst');
          $.ajaxSetup({
              headers: {
                  'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
              }
          });
          $.ajax({
              type: "POST",
              dataType: "JSON",
              url: "{{url('selesaiujian')}}",
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
                        html: response.message,
                        icon: 'success',
                        showConfirmButton: true
                    }).then((result) => {
                        $.LoadingOverlay("show", {
                          image       : "{{asset('/image/global/loading.gif')}}"
                        });
                        reload_url(1500,'{{url("hasilujian")}}');
                    })

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


