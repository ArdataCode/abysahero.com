@extends('layouts.Skydash')
<!-- partial -->
<style>
  .modal-footer{
    display: block !important;
    text-align: center;
  }
</style>
@section('content')
<div class="content-wrapper">
  <div class="row">
    <div class="col-md-12">
      <div class="row">
        <div class="col-12 col-xl-12 mb-4 mb-xl-0" style="text-align:center">
          <h3 class="font-weight-bold">Paket Soal Umum</h3>
          <h2 class="font-weight-bold"></h2>
          <!-- <h6 class="font-weight-normal mb-0">Sudah siap belajar apa hari ini? Jangan lupa semangat karena banyak latihan dan tryout yang masih menunggu untuk diselesaikan.</h6> -->
        </div>  
      </div>
    </div>
  </div>
  <div class="row pilihan_ganda">
  @if(count($paket)>0)
  @foreach($paket as $key)
    @php
      $cekdata = App\Models\Transaksi::where('fk_user_id','=',Auth::user()->id)->where('status',1)->pluck('fk_master_member_id')->all();
      $cekdata = App\Models\MasterMember::whereIn('id',$cekdata)->where('status',1)->get();
      if($cekdata){
        $arr = App\Models\MemberDtl::where('jenis',1)->whereIn('fk_master_member',$cekdata)->pluck('fk_paket_soal_mst')->all(); 
          if (in_array($key->id, $arr))
          {
            $val = 1;
          }
          else
          {
            $val = 0;
          }
      }else{
        $val = 0;
      }

      $cekdatafree = App\Models\MasterMember::where('harga','=',0)->where('status',1)->pluck('id')->all();
      $arrfree = App\Models\MemberDtl::where('jenis',1)->whereIn('fk_master_member',$cekdatafree)->pluck('fk_paket_soal_mst')->all(); 

      if (in_array($key->id, $arrfree))
      {
        $val = 1;
      }

      if($val==1){

        $cekmemberdtl = App\Models\MemberDtl::where('fk_paket_soal_mst',$key->id)->where('jenis',1)->pluck('fk_master_member')->all();

        $cekbatasbaru = App\Models\BatasMengerjakan::where('fk_user_id','=',Auth::user()->id)->where('jenis',1)->where('fk_paket_soal_mst',$key->id)->first();
        if($cekbatasbaru){
            $batas = $cekbatasbaru->batas_mengerjakan;
            $cekfree = App\Models\MasterMember::whereIn('id',$cekmemberdtl)->where('harga','<=',0)->get();
            if(count($cekfree)>0){
                $batas = $batas + $cekfree->max('batas_mengerjakan');
            }
        }else{
            $ceksudahada = App\Models\Transaksi::where('fk_user_id','=',Auth::user()->id)->whereIn('fk_master_member_id',$cekmemberdtl)->where('status',1)->first();
            if($ceksudahada){
              $databatas['batas_mengerjakan'] = $ceksudahada->max('batas_mengerjakan'); 
              $databatas['fk_user_id'] = Auth::user()->id; 
              $databatas['fk_paket_soal_mst'] = $key->id; 
              $databatas['jenis'] = 1; 
              $databatas['created_by'] = Auth::id();
              $databatas['created_at'] = Carbon\Carbon::now()->toDateTimeString();
              $databatas['updated_by'] = Auth::id();
              $databatas['updated_at'] = Carbon\Carbon::now()->toDateTimeString();
              App\Models\BatasMengerjakan::create($databatas);
              $batas = $ceksudahada->max('batas_mengerjakan');
              $cekfree = App\Models\MasterMember::whereIn('id',$cekmemberdtl)->where('harga','<=',0)->get();
              if(count($cekfree)>0){
                  $batas = $batas + $cekfree->max('batas_mengerjakan');
              }
            }else{
                $cekfree = App\Models\MasterMember::whereIn('id',$cekmemberdtl)->where('harga','<=',0)->get();
                if(count($cekfree)>0){
                    $batas = $cekfree->max('batas_mengerjakan');
                }else{
                    $batas=0;
                }
            }  
        }

        $cekberapakali = App\Models\UPaketSoalMst::where('fk_user_id',Auth::id())->where('fk_paket_soal_mst',$key->id)->get();
        $sisa = $batas - count($cekberapakali);
        if($sisa<=0){
          $sisa = 0;
        }
        if($batas>=99999){
          $sisa = "Aktif Selamanya";
        }else{
          $sisa = "Sisa ".$sisa;
        }

      }
    @endphp
    <div class="col-md-4 grid-margin-md-0 stretch-card" style="margin-bottom:15px">
      <div class="card">
        <div class="card-body {{$val==0 ? 'brg-50' : ''}}">
          <h4 class="card-title" style="background: #fd7e14;color: white;padding: 15px;border-radius: 8px;">{{$key->judul}}</h4>
          <!-- <p class="card-description">Add class <code>.list-star</code> to <code>&lt;ul&gt;</code></p> -->
          <div>
            {!!$key->ket!!}
          </div>
          <div>
              @if($val==0)
              <span data-toggle="tooltip" data-placement="bottom" title="Upgrade member terlebih dahulu untuk membuka soal">
                <button type="button" class="btn btn-outline-primary btn-icon-text disabled btn-block btn-lock btn-sm">
                  <i class="ti-lock btn-icon-prepend"></i>
                  Kerjakan Soal
                </button>
                <button type="button" class="btn btn-outline-primary disabled btn-icon-text btn-block btn-lock btn-sm">
                  <i class="ti-medall btn-icon-prepend"></i>
                  Ranking
                </button>
                <!-- <button type="button" class="btn btn-outline-primary disabled btn-icon-text btn-block btn-lock btn-sm">
                  <i class="ti-download btn-icon-prepend"></i>
                  Download Soal
                </button> -->
              </span>
              @else
              <button type="button" class="btn btn-primary btn-icon-text btn-block btn-sm" data-bs-toggle="modal" data-bs-target="#myModal_{{$key->id}}">
                <i class="ti-unlock btn-icon-prepend"></i>
                Kerjakan Soal ({{$sisa}})
              </button>
              <a href="{{url('rankingpaket')}}/{{Crypt::encrypt($key->id)}}" type="button" class="btn btn-success btn-icon-text btn-block btn-sm">
                <i class="ti-medall btn-icon-prepend"></i>
                Ranking
              </a>
              <!-- <a target="_blank" href="{{url('exportsoal/pilgan')}}/{{Crypt::encrypt($key->id)}}" type="button" class="btn btn-success btn-icon-text btn-block btn-sm">
                <i class="ti-download btn-icon-prepend"></i>
                Download Soal
              </a> -->
              @endif
          </div>
        </div>
      </div>
    </div>

    <!-- The Modal -->
    <div class="modal fade" id="myModal_{{$key->id}}">
      <div class="modal-dialog">
        <div class="modal-content">

          <!-- Modal Header -->
          <div class="modal-header">
            <h4 class="modal-title">Kerjakan Paket Soal {{$key->judul}}</h4>
            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
          </div>

          <!-- Modal body -->
          <div class="modal-body">
            <h5>Peraturan</h5>
            <ul>
              <li>
                Waktu akan berjalan ketika anda klik tombol <b>Mulai Ujian</b>
              </li>
              <li>
                Jawaban anda tersimpan otomatis
              </li>
              <li>
                Jika waktu habis maka halaman akan tertutup otomatis dan anda tidak dapat lagi mengerjakan soal
              </li>
              <li>
                Jika waktu masi tersisa dan soal sudah selesai dikerjakan, silahkan klik tombol selesai ujian maka nilai akan keluar otomatis
              </li>
              <li>
                Jika sudah siap silahkan klik tombol <b>Mulai Ujian</b> untuk memulai ujian.
              </li>
              <li>
                Jangan lupa berdoa sebelum mengerjakan ujian.
              </li>
            </ul>
            <div class="table-responsive">

            <table class="table table-hover">
            <tbody>
              <tr>
                <td>Waktu</td>
                <td>{{$key->waktu}} Menit</td>
              </tr>
              <tr>
                <td>Total Soal</td>
                <td>{{$key->total_soal}} Butir</td>
              </tr>
            </tbody>
          </table>
          </div>
          </div>

          <!-- Modal footer -->
          <div class="modal-footer">
            <form method="post" id="formKerjakan_{{$key->id}}" class="form-horizontal">
              @csrf
              <input type="hidden" name="id_paket_soal_mst[]" value="{{Crypt::encrypt($key->id)}}">
              <button type="button" class="btn btn-info btn-kerjakan" idform="{{$key->id}}">Mulai Ujian</button>
            </form>
          </div>

        </div>
      </div>
    </div>
    @endforeach
  @else
    <div style="text-align:center;padding-top:15px">
      <h5>Belum Ada Paket</h5>
    </div>
  @endif
  </div>
  <br>
  <br>
  <br>
  <div class="row">
    <div class="col-12 col-xl-12 mb-4 mb-xl-0" style="text-align:center">
      <h3 class="font-weight-bold">Paket Soal Kecermatan</h3>
      <h2 class="font-weight-bold"></h2>
      <!-- <h6 class="font-weight-normal mb-0">Sudah siap belajar apa hari ini? Jangan lupa semangat karena banyak latihan dan tryout yang masih menunggu untuk diselesaikan.</h6> -->
    </div>  
  </div>
  <div class="row kecermatan">
  @if(count($paketkecermatan)>0)
  @foreach($paketkecermatan as $key)
  @php
      $cekdata = App\Models\Transaksi::where('fk_user_id','=',Auth::user()->id)->where('status',1)->pluck('fk_master_member_id')->all();
      if($cekdata){
        $arr = App\Models\MemberDtl::where('jenis',2)->whereIn('fk_master_member',$cekdata)->pluck('fk_paket_soal_mst')->all(); 
          if (in_array($key->id, $arr))
          {
            $val = 1;
          }
          else
          {
            $val = 0;
          }
      }else{
        $val = 0;
      }

      $cekdatafree = App\Models\MasterMember::where('harga','=',0)->pluck('id')->all();
      $arrfree = App\Models\MemberDtl::where('jenis',2)->whereIn('fk_master_member',$cekdatafree)->pluck('fk_paket_soal_mst')->all(); 

      if (in_array($key->id, $arrfree))
      {
        $val = 1;
      }
      $idmastersoal = App\Models\PaketSoalKecermatanDtl::where('fk_paket_soal_kecermatan_mst',$key->id)->pluck('id')->all();
      $jumlahsoaldtl = App\Models\DtlSoalKecermatan::whereIn('fk_master_soal_kecermatan',$idmastersoal)->get();

      if($val==1){

      $cekmemberdtl = App\Models\MemberDtl::where('fk_paket_soal_mst',$key->id)->where('jenis',2)->pluck('fk_master_member')->all();

      $cekbatasbaru = App\Models\BatasMengerjakan::where('fk_user_id','=',Auth::user()->id)->where('jenis',2)->where('fk_paket_soal_mst',$key->id)->first();
      if($cekbatasbaru){
          $batas2 = $cekbatasbaru->batas_mengerjakan;
          $cekfree = App\Models\MasterMember::whereIn('id',$cekmemberdtl)->where('harga','<=',0)->get();
          if(count($cekfree)>0){
              $batas2 = $batas2 + $cekfree->max('batas_mengerjakan');
          }
      }else{
          $ceksudahada = App\Models\Transaksi::where('fk_user_id','=',Auth::user()->id)->whereIn('fk_master_member_id',$cekmemberdtl)->where('status',1)->first();
          if($ceksudahada){
            $databatas['batas_mengerjakan'] = $ceksudahada->max('batas_mengerjakan'); 
            $databatas['fk_user_id'] = Auth::user()->id; 
            $databatas['fk_paket_soal_mst'] = $key->id; 
            $databatas['jenis'] = 2; 
            $databatas['created_by'] = Auth::id();
            $databatas['created_at'] = Carbon\Carbon::now()->toDateTimeString();
            $databatas['updated_by'] = Auth::id();
            $databatas['updated_at'] = Carbon\Carbon::now()->toDateTimeString();
            App\Models\BatasMengerjakan::create($databatas);
            $batas2 = $ceksudahada->max('batas_mengerjakan');
            $cekfree = App\Models\MasterMember::whereIn('id',$cekmemberdtl)->where('harga','<=',0)->get();
            if(count($cekfree)>0){
                $batas2 = $batas2 + $cekfree->max('batas_mengerjakan');
            }
          }else{
              $cekfree = App\Models\MasterMember::whereIn('id',$cekmemberdtl)->where('harga','<=',0)->get();
              if(count($cekfree)>0){
                  $batas2 = $cekfree->max('batas_mengerjakan');
              }else{
                  $batas2=0;
              }
          }  
      }

      $cekberapakali = App\Models\UPaketSoalKecermatanMst::where('fk_user_id',Auth::id())->where('fk_paket_soal_kecermatan_mst',$key->id)->get();
      $sisa2 = $batas2 - count($cekberapakali);
      if($sisa2<=0){
        $sisa2 = 0;
      }
      if($batas2>=99999){
        $sisa2 = "Aktif Selamanya";
      }else{
        $sisa2 = "Sisa ".$sisa2;
      }

      }

    @endphp
  <div class="col-md-4 grid-margin-md-0 stretch-card" style="margin-bottom:15px">
      <div class="card">
        <div class="card-body {{$val==0 ? 'brg-50' : ''}}">
          <h4 class="card-title" style="background: #fd7e14;color: white;padding: 15px;border-radius: 8px;">{{$key->judul}}</h4>
          <!-- <p class="card-description">Add class <code>.list-star</code> to <code>&lt;ul&gt;</code></p> -->
          <div>
            {!!$key->ket!!}
          </div>
          <div>

              @if($val==0)
              <span data-toggle="tooltip" data-placement="bottom" title="Upgrade member terlebih dahulu untuk membuka soal">
                <button type="button" class="btn btn-outline-primary btn-icon-text disabled btn-block btn-lock btn-sm">
                  <i class="ti-lock btn-icon-prepend"></i>
                  Kerjakan Soal
                </button>
                <button type="button" class="btn btn-outline-primary disabled btn-icon-text btn-block btn-lock btn-sm">
                      <i class="ti-medall btn-icon-prepend"></i>
                      Ranking
                    </button>
                <!-- <button type="button" class="btn btn-outline-primary disabled btn-icon-text btn-block btn-lock btn-sm">
                  <i class="ti-download btn-icon-prepend"></i>
                  Download Soal
                </button> -->
              </span>
              @else
              <button type="button" class="btn btn-primary btn-icon-text btn-block btn-sm" data-bs-toggle="modal" data-bs-target="#myModalKecermatan_{{$key->id}}">
                <i class="ti-unlock btn-icon-prepend"></i>
                Kerjakan Soal ({{$sisa2}})
              </button>
              <a href="{{url('rankingpaketkec')}}/{{Crypt::encrypt($key->id)}}" type="button" class="btn btn-success btn-icon-text btn-block btn-sm">
                    <i class="ti-medall btn-icon-prepend"></i>
                    Ranking
                  </a>
              <!-- <a target="_blank" href="{{url('exportsoal/kec')}}/{{Crypt::encrypt($key->id)}}" type="button" class="btn btn-success btn-icon-text btn-block btn-sm">
                <i class="ti-download btn-icon-prepend"></i>
                Download Soal
              </a> -->
              @endif
          </div>
        </div>
      </div>
    </div>

    <!-- The Modal -->
    <div class="modal fade" id="myModalKecermatan_{{$key->id}}">
      <div class="modal-dialog">
        <div class="modal-content">

          <!-- Modal Header -->
          <div class="modal-header">
            <h4 class="modal-title">Kerjakan Paket Soal {{$key->judul}}</h4>
            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
          </div>

          <!-- Modal body -->
          <div class="modal-body">
            <h5>Peraturan</h5>
            <ul>
              <li>
                Waktu akan berjalan ketika anda klik tombol <b>Mulai Ujian</b>
              </li>
              <li>
                Jawaban anda tersimpan otomatis
              </li>
              <li>
                Jika waktu habis maka halaman akan tertutup otomatis dan anda tidak dapat lagi mengerjakan soal
              </li>
              <li>
                Jika waktu masi tersisa dan soal sudah selesai dikerjakan, silahkan klik tombol selesai ujian maka nilai akan keluar otomatis
              </li>
              <li>
                Jika sudah siap silahkan klik tombol <b>Mulai Ujian</b> untuk memulai ujian.
              </li>
              <li>
                Jangan lupa berdoa sebelum mengerjakan ujian.
              </li>
            </ul>
            <div class="table-responsive">
            <table class="table table-hover">
            <tbody>
              <tr>
                <td>Waktu</td>
                <td>Per/Soal</td>
              </tr>
              <tr>
                <td>Total Soal</td>
                <td>{{$key->total_soal}} Butir Master / {{count($jumlahsoaldtl)}} Butir Detail</td>
              </tr>
            </tbody>
          </table>
            </div>
            
          </div>

          <!-- Modal footer -->
          <div class="modal-footer">
            <form method="post" id="formKerjakanKecermatan_{{$key->id}}" class="form-horizontal">
              @csrf
              <input type="hidden" name="id_paket_soal_mst[]" value="{{Crypt::encrypt($key->id)}}">
              <button type="button" class="btn btn-info btn-kerjakan-kecermatan" idform="{{$key->id}}">Mulai Ujian</button>
            </form>
          </div>

        </div>
      </div>
    </div>
    @endforeach
    @else
    <div style="text-align:center;padding-top:15px">
      <h5>Belum Ada Paket</h5>
    </div>
    @endif
  </div>
</div>

@endsection

@section('footer')
<!-- SweetAlert2 -->
<script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
  $(document).ready(function(){
    $('[data-toggle="tooltip"]').tooltip({
        trigger : 'hover'
    });
    //Fungsi Kerjakan Soal
    $(document).on('click', '.btn-kerjakan', function (e) {
        idform = $(this).attr('idform');
        var formData = new FormData($('#formKerjakan_' + idform)[0]);

        var url = "{{ url('/mulaiujian') }}/"+idform;
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $.ajax({
            url: url,
            type: 'POST',
            dataType: "JSON",
            data: formData,
            contentType: false,
            processData: false,
            beforeSend: function () {
                $.LoadingOverlay("show", {
                    image       : "{{asset('/image/global/loading.gif')}}"
                });
            },
            success: function (response) {
                    if (response.status == true) {
                      $('.modal').modal('hide');
                      Swal.fire({
                          html: response.message,
                          icon: 'success',
                          showConfirmButton: false
                        });
                        reload_url(2000,'{{url("ujian")}}/'+response.id);
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

    //Fungsi Kerjakan Soal
      $(document).on('click', '.btn-kerjakan-kecermatan', function (e) {
        idform = $(this).attr('idform');
        var formData = new FormData($('#formKerjakanKecermatan_' + idform)[0]);

        var url = "{{ url('/mulaiujiankecermatan') }}/"+idform;
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $.ajax({
            url: url,
            type: 'POST',
            dataType: "JSON",
            data: formData,
            contentType: false,
            processData: false,
            beforeSend: function () {
                $.LoadingOverlay("show", {
                    image       : "{{asset('/image/global/loading.gif')}}"
                });
            },
            success: function (response) {
                    if (response.status == true) {
                      $('.modal').modal('hide');
                      Swal.fire({
                          html: response.message,
                          icon: 'success',
                          showConfirmButton: false
                        });
                        reload(2000);
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

  });
</script>
<!-- Loading Overlay -->
@endsection


