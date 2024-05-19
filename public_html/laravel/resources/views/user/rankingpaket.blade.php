@extends($extend)
<!-- partial -->
@section('content')
<style>
  tr th{
    text-align:center;
  }
</style>
<div class="content-wrapper">
  <div class="row">
    <!-- <div class="col-12">
      <div class="justify-content-end d-flex">
      <div class="dropdown flex-md-grow-1 flex-xl-grow-0">
        <a href="{{url('kerjakansoal')}}">
          <button type="button" class="btn btn-outline-secondary btn-sm btn-fw">
          <i class="mdi mdi-keyboard-backspace"></i>
          <span class="_font_icon_sm">Kembali</span>
          </button>
          <br>
          <br>
        </a>
      </div>
      </div>
    </div> -->
    <div class="col-md-12">
      <div class="row">
        <div class="col-12 col-xl-12 mb-3">
          <center><h3 class="font-weight-bold">Ranking Paket Soal {{$datapaket->judul}}</h3></center>
          <!-- <h6 class="font-weight-normal mb-0">Sudah siap belajar apa hari ini? Jangan lupa semangat karena banyak latihan dan tryout yang masih menunggu untuk diselesaikan.</h6> -->
        </div>
        <div class="col-12 col-xl-4">
          <div class="justify-content-end d-flex">
          <!-- <div class="dropdown flex-md-grow-1 flex-xl-grow-0">
            <button class="btn btn-sm btn-light bg-white dropdown-toggle" type="button" id="dropdownMenuDate2" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
              <i class="mdi mdi-calendar"></i> Today (10 Jan 2021)
            </button>
            <div class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdownMenuDate2">
              <a class="dropdown-item" href="#">January - March</a>
              <a class="dropdown-item" href="#">March - June</a>
              <a class="dropdown-item" href="#">June - August</a>
              <a class="dropdown-item" href="#">August - November</a>
            </div>
          </div> -->
          </div>
        </div>
      </div>
    </div>
  </div>
  <div class="row">
    <div class="col-lg-12 grid-margin stretch-card">
      <div class="card">
        <div class="card-body">
          <div class="table-responsive">
            <table class="table table-hover">
              <thead>
                <tr>
                  <th>Posisi</th>
                  <th>Nama</th>
                  <th>Asal</th>
                  <th>Jenis Kelamin</th>
                  <th>Nilai Rata-rata</th>
                </tr>
              </thead>
              <tbody>
                @if(count($udatapaket)>0)
                  @foreach($udatapaket as $key)
                  <tr>
                    <th style="text-align:center">{{$loop->iteration}}</th>
                    <td width="40%">{{$key->user_r->name}} @if($loop->iteration==1)<i style="color:gold" class="ti-medall btn-icon-prepend"></i>@endif</td>
                    <td style="text-align:center" width="40%"><span data-bs-toggle="tooltip" data-bs-placement="top" title="Kecamatan : {{$key->user_r->kecamatan_r ? $key->user_r->kecamatan_r->nama : ''}}, {{$key->user_r->kabupaten_r ? $key->user_r->kabupaten_r->nama : ''}}, Provinsi : {{$key->user_r->provinsi_r ? $key->user_r->provinsi_r->nama : ''}}">{{$key->user_r->kabupaten_r ? $key->user_r->kabupaten_r->nama : ''}}</span></td>
                    <td style="text-align:center">{{$key->user_r->nama_kelamin}}</td>                   
                    @php
                        $cek = App\Models\UPaketSoalMst::where('fk_user_id',$key->fk_user_id)->where('is_mengerjakan',0)->where('fk_paket_soal_mst',$key->fk_paket_soal_mst)->get();
                    @endphp
                    <td width="10%" style="text-align:center" class="font-weight-bold">Nilai : {{(int)$key->totalnilai}}<br><code>({{count($cek)}} Kali Mengerjakan)</code></td>
                  </tr>
                  @endforeach
                @else
                  <tr>
                    <td colspan="5" style="text-align:center" class="font-weight-bold">Belum Ada Data</td>
                  </tr>
                @endif
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection

@section('footer')
<!-- jQuery -->
<script>
var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
  return new bootstrap.Tooltip(tooltipTriggerEl)
})
  $(document).ready(function(){
  
  });
</script>
<!-- Loading Overlay -->
@endsection


