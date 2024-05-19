@extends('layouts.SkydashAdmin')
<!-- partial -->
@section('content')

<div class="content-wrapper">
  <div class="row">
    <div class="col-md-12">
      <div class="row">
        <div class="col-xl-9 col-md-9 col-sm-9 col-xs-9">
          <h3 class="font-weight-bold">{{$upaketsoalmst->judul}}</h3>
          <table class="table table-sm">
            <tbody>
              <tr style="border-style: hidden;">
                <td width="40%">Total Soal</td>
                <td>: {{$upaketsoalmst->total_soal}} Butir Master / {{count($hitungsoaldtl)}} Butir Detail (Benar {{count($cekbenar)}} / Salah {{count($ceksalah)}})</td>
              </tr>
              <tr style="border-style: hidden;">
                <td>Waktu</td>
                <td>: Per/Soal</td>
              </tr>
              <tr style="border-style: hidden;">
                <td><b>Total Nilai</b></td>
                <td>: <b>{{$upaketsoalmst->nilai ? $upaketsoalmst->nilai : 0}} (KKM {{$upaketsoalmst->kkm}})</b></td>
              </tr>
            </tbody>
          </table>
          <br>
        </div>
        <div class="col-xl-3 col-md-3 col-sm-3 col-xs-3">
            <button type="button" class="btn btn-success btn-sm _btn_benar_salah">
              <h6>Jawaban Benar : {{count($cekbenar)}}</h6>
            </button>
            <button type="button" class="btn btn-danger btn-sm _btn_benar_salah">
              <h6>Jawaban Salah : {{count($ceksalah)}}</h6>
            </button>
        </div>
      </div>
    </div>
  </div>
  <div class="row">
    <div class="col-xl-9 col-md-9 col-sm-9 col-xs-9">
    <div class="_soal_content tab-content" id="pills-tabContent">
      @foreach($soalmst as $key)
      <div class="tab-pane fade {{$loop->iteration==1 ? 'show active' : ''}}" id="pills-{{$key->id}}" role="tabpanel">
        <div class="soal_master">
            <div class="row">
                <div class="col-sm-4">
                </div>
                <div class="col-sm-8">
                  <div class="table-responsive">
                    <table class="table table-bordered" style="margin-bottom:0">
                        <tbody>
                          <tr>
                            @foreach(json_decode($key->karakter) as $loopdatamaster)
                            <td><h2><b>{{$loopdatamaster}}</b></h2></td>
                            @endforeach
                          </tr>
                          <tr>
                            @foreach(json_decode($key->kiasan) as $loopdatamaster)
                            <td><h5><b>{{$loopdatamaster}}</b></h5></td>
                            @endforeach
                          </tr>
                        </tbody>
                    </table>
                  </div>
                </div>
            </div>
            <br>
            <h3 style="padding-bottom:15px">Pembahasan :</h3>
            @foreach($key->u_paket_soal_kecermatan_soal_dtl_r as $key2)
            <div class="row">
              <div class="col-lg-4 col-md-4">
                <div class="_soal_content_kecermatan tab-content" id="pills-tabContent">
                  <div class="tab-pane fade show active">
                    <div class="parent">
                      @foreach(json_decode($key2->soal) as $loopdatadtl)
                        <div class="child"><h2>{{$loopdatadtl}}</h2></div>
                      @endforeach
                    </div>
                  </div>
                </div>
                <div class="soal_dtl_bawah">
                  <div class="parent">
                    @foreach(json_decode($key->kiasan) as $loopdatamaster)
                      <div class="child">
                        <h5>{{$loopdatamaster}}</h5>
                          <div class='form-check {{$key2->jawaban==$loopdatamaster? "_form-check-success" : "_form-check-danger"}} {{$key2->jawaban_user==$loopdatamaster ? "_form-check-user-kec" : "" }}'>
                            <label class="form-check-label">
                              <input type="radio" class="form-check-input" value="{{$loopdatamaster}}" disabled>
                              <i class="input-helper"></i></label>
                          </div>  
                      </div>
                    @endforeach
                  </div>
                </div>
              </div>
            </div>
            <br>
            @endforeach

        </div>
      </div>
      <!-- <div class="tab-pane fade show active" id="pills-profile" role="tabpanel" aria-labelledby="pills-profile-tab">2</div> -->
      @endforeach
      
    </div>
    </div>
    <div class="col-xl-3 col-md-3 col-sm-3 col-xs-3">
    <ul class="_soal nav nav-pills mb-3" id="pills-tab" role="tablist">
      @foreach($soalmst as $key)

      <!-- <li class="nav-item" role="presentation">
        <button class="nav-link active" id="pills-home-tab" data-bs-toggle="pill" data-bs-target="#pills-home" type="button" role="tab" aria-controls="pills-home" aria-selected="true">1</button>
      </li> -->
      <li class="nav-item" role="presentation">
        <button id="btn_no_soal_{{$key->id}}" class="nav-link {{$loop->iteration==1 ? 'active' : ''}}" data-bs-toggle="pill" data-bs-target="#pills-{{$key->id}}" type="button" role="tab" aria-selected="true">{{$loop->iteration}}</button>
      </li>
      @endforeach
    </ul>
    
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
  });
</script>
<!-- Loading Overlay -->
@endsection


