@extends('layouts.Skydash')
<!-- partial -->
@section('content')
<div class="content-wrapper">
  <div class="row">
    <div class="col-md-12">
      <div class="row">
        <div class="col-12 col-xl-12 mb-4 mb-xl-0">
          <h3 class="font-weight-bold">Hasil Ujian</h3>
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

        <ul class="nav nav-pills btn-menu-hasil" role="tablist">
          <li class="nav-item">
            <a class="btn btn-primary nav-link btn-tab-hasil active" data-toggle="pill" href="#umum">Paket Soal Umum</a>
          </li>
          <li class="nav-item">
            <a class="btn btn-primary nav-link btn-tab-hasil" data-toggle="pill" href="#kecermatan">Paket Soal Kecermatan</a>
          </li>
        </ul>

  <!-- Tab panes -->
  <div class="tab-content tab-hasil-ujian">
    <div id="umum" class="tab-pane active"><br>
          <div class="table-responsive">
            <table class="table table-hover">
              <thead>
                <tr>
                  <th>No.Ujian</th>
                  <th>Paket</th>
                  <th>Tanggal Mengerjakan</th>
                  <!-- <th>KKM</th> -->
                  <th>Skor Akhir</th>
                  <th>Aksi</th>
                </tr>
              </thead>
              <tbody>
                @if(count($data)>0)
                  @foreach($data as $key)
                  <tr>
                    <td width="1%">PG-{{sprintf("%06d", $key->id)}}</td>
                    <td width="30%">{{$key->judul}}</td>
                    <td width="10%">
                      {{Carbon\Carbon::parse($key->mulai)->translatedFormat('l, d F Y , H:i:s')}}  
                    </td>
                    <!-- <td width="5%">{{$key->kkm}}</td> -->
                    <td width="10%" style="text-align:center">
                    {{$key->nilai ? $key->nilai : 0}}
                      @if($key->jenis_penilaian==2)

                        @php
                        if($key->point < $key->kkm){
                          $lulus = 0;
                        }
                        else{
                          $lulus = 1;
                        }
                        @endphp

                      @else  

                        @php
                        if($key->nilai < $key->kkm){
                          $lulus = 0;
                        }
                        else{
                          $lulus = 1;
                        }
                        @endphp

                      @endif
                    </td>
                    <td width="10%">
                      <!-- <label class="badge badge-{{statuslulus($lulus,2)}}">{{statuslulus($lulus,1)}}</label> -->
                      <a target="_blank" href="{{url('detailhasil')}}/{{Crypt::encrypt($key->id)}}">
                        <label class="_hover badge badge-info">Lihat Detail</label>
                      </a>
                    </td>
                  </tr>
                  @endforeach
                @else
                  <tr>
                    <td colspan="6" style="text-align:center" class="font-weight-bold">Belum Ada Data</td>
                  </tr>
                @endif
              </tbody>
            </table>
          </div>
    </div>
    <div id="kecermatan" class="tab-pane fade"><br>
          <div class="table-responsive">
            <table class="table table-hover">
              <thead>
                <tr>
                  <th>No</th>
                  <th>Paket</th>
                  <th>Tanggal Mengerjakan</th>
                  <th>KKM</th>
                  <th>Skor Akhir</th>
                  <th>Lulus</th>
                </tr>
              </thead>
              <tbody>
                @if(count($datakecermatan)>0)
                  @foreach($datakecermatan as $key)
                  <tr>
                    <td width="1%">{{$loop->iteration}}</td>
                    <td width="40%">{{$key->judul}}</td>
                    <td width="10%">
                      {{Carbon\Carbon::parse($key->mulai)->translatedFormat('l, d F Y , H:i:s')}}  
                    </td>
                    <td width="5%">{{$key->kkm}}</td>
                    <td width="10%" style="text-align:center">{{$key->nilai ? $key->nilai : 0}}</td>
                    @php
                    if($key->nilai < $key->kkm){
                      $lulus = 0;
                    }
                    else{
                      $lulus = 1;
                    }
                    @endphp
                    <td width="10%">
                      <label class="{{statuslulus($lulus,2)}}">{{statuslulus($lulus,1)}}</label>
                      <a target="_blank" href="{{url('detailhasilkecermatan')}}/{{Crypt::encrypt($key->id)}}">
                        <label class="_hover badge badge-info">Detail</label>
                      </a>
                    </td>
                  </tr>
                  @endforeach
                @else
                  <tr>
                    <td colspan="6" style="text-align:center" class="font-weight-bold">Belum Ada Data</td>
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
  </div>
</div>
@endsection

@section('footer')
<!-- jQuery -->
<script>
  $(document).ready(function(){
      // alert('x');
  });
</script>
<!-- Loading Overlay -->
@endsection


