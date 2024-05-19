@extends('layouts.Skydash')
<!-- partial -->
@section('content')

<div class="content-wrapper">
  <div class="row">
    <div class="col-md-12">
      <div class="row">
        <div class="col-xl-9 col-md-9 col-sm-9 col-xs-9">
          <h3 class="font-weight-bold">{{$upaketsoalmst->judul}}</h3>
          <div class="table-responsive">
          <table class="table table-sm">
            <tbody>
              <tr style="border-style: hidden;">
                <td width="40%">Total Soal</td>
                <td>: {{$upaketsoalmst->total_soal}} Butir (Benar {{count($cekbenar)}} / Salah {{count($ceksalah)}})</td>
              </tr>
              <tr style="border-style: hidden;">
                <td>Waktu</td>
                <td>: {{$upaketsoalmst->waktu}} Menit</td>
              </tr>
              <tr style="border-style: hidden;">
                <td><b>Total Nilai</b></td>
                <td>: <b>{{$upaketsoalmst->nilai ? $upaketsoalmst->nilai : 0}}</b></td>
              </tr>
              @foreach($upaketsoalmst->u_paket_soal_ktg_r as $key)
              <!-- <tr style="border-style: hidden;">
                <td>Nilai {{$key->judul}}</td>
                <td>: <b>{{$key->nilai}}</b></td>
              </tr> -->
              @endforeach
            </tbody>
          </table>
          </div>
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
      @foreach($upaketsoalmst->u_paket_soal_dtl_r as $key)
      <div class="tab-pane fade {{$key->no_soal==1 ? 'show active' : ''}}" id="pills-{{$key->id}}" role="tabpanel">
          <div class="_nosoal">{{$key->no_soal}}.</div><div class="_soal">{!!$key->soal!!}</div>
          <div class="form-group">
            <div class="form-check {{stripos($key->jawaban, 'a') !== FALSE ? '_form-check-success' : '_form-check-danger'}} {{$key->jawaban_user=='a' ? '_form-check-user' : '' }}">
              <label class="form-check-label">
                <input type="radio" class="form-check-input _radio" disabled idpaketdtl="{{$key->id}}" name="radio_{{$key->id}}" value="a">
                <i class="input-helper"></i></label>
                <div class="_pilihan">
                  <span><b>a.</b> </span>
                  <div class="_pilihan_isi">
                    {!!$key->a!!}
                  </div>
                </div>
            </div>
            <div class="form-check {{stripos($key->jawaban, 'b') !== FALSE ? '_form-check-success' : '_form-check-danger'}} {{$key->jawaban_user=='b' ? '_form-check-user' : '' }}">
              <label class="form-check-label">
                <input type="radio" class="form-check-input _radio" disabled idpaketdtl="{{$key->id}}" name="radio_{{$key->id}}" value="b">
                <i class="input-helper"></i></label>
                <div class="_pilihan">
                  <span><b>b.</b> </span>
                  <div class="_pilihan_isi">
                    {!!$key->b!!}
                  </div>
                </div>
            </div>
            <div class="form-check {{stripos($key->jawaban, 'c') !== FALSE ? '_form-check-success' : '_form-check-danger'}} {{$key->jawaban_user=='c' ? '_form-check-user' : '' }}">
              <label class="form-check-label">
                <input type="radio" class="form-check-input _radio" disabled idpaketdtl="{{$key->id}}" name="radio_{{$key->id}}" value="c">
                <i class="input-helper"></i></label>
                <div class="_pilihan">
                  <span><b>c.</b> </span>
                  <div class="_pilihan_isi">
                    {!!$key->c!!}
                  </div>
                </div>
            </div>
            <div class="form-check {{stripos($key->jawaban, 'd') !== FALSE ? '_form-check-success' : '_form-check-danger'}} {{$key->jawaban_user=='d' ? '_form-check-user' : '' }}">
              <label class="form-check-label">
                <input type="radio" class="form-check-input _radio" disabled idpaketdtl="{{$key->id}}" name="radio_{{$key->id}}" value="d">
                <i class="input-helper"></i></label>
                <div class="_pilihan">
                  <span><b>d.</b> </span>
                  <div class="_pilihan_isi">
                    {!!$key->d!!}
                  </div>
                </div>
            </div>
            <div class="form-check {{stripos($key->jawaban, 'e') !== FALSE ? '_form-check-success' : '_form-check-danger'}} {{$key->jawaban_user=='e' ? '_form-check-user' : '' }}">
              <label class="form-check-label">
                <input type="radio" class="form-check-input _radio" disabled idpaketdtl="{{$key->id}}" name="radio_{{$key->id}}" value="e">
                <i class="input-helper"></i></label>
                <div class="_pilihan">
                  <span><b>e.</b> </span>
                  <div class="_pilihan_isi">
                    {!!$key->e!!}
                  </div>
                </div>
            </div>
          </div>
          <br>
          <h5><b>Kunci Jawaban</b> : {{$key->jawaban}}</h5>
          <h5><b>Jawaban Anda</b> : {{$key->jawaban_user ? $key->jawaban_user : '-'}} ({{$key->cek_benar==1 ? "Benar" : "Salah"}})</h5>
          <br>
          <h5><b>Pembahasan</b> : <br>{!!$key->pembahasan!!}</h5>
          <br>
          <br>
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
        <button id="btn_no_soal_{{$key->id}}" class="{{$key->cek_benar==1 ? '_benar' : '_salah'}} nav-link {{$key->no_soal==1 ? 'active' : ''}}" data-bs-toggle="pill" data-bs-target="#pills-{{$key->id}}" type="button" role="tab" aria-selected="true">{{$key->no_soal}}</button>
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


