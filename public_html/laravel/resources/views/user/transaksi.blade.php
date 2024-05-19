@extends('layouts.Skydash')
<!-- partial -->
@section('content')
<div class="content-wrapper">
  <div class="row">
    <div class="col-md-12">
      <div class="row">
        <div class="col-12 col-xl-12 mb-4 mb-xl-0">
          <h3 class="font-weight-bold">Transaksi</h3>
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
                  <th>Order Id</th>
                  <th>Member</th>
                  <th>Harga</th>
                  <th>Tanggal Transaksi</th>
                  <th>Status</th>
                </tr>
              </thead>
              <tbody>
                @if(count($data)>0)
                  @foreach($data as $key)
                  <tr>
                    <td width="40%">{{$key->merchant_order_id}}</td>
                    <td width="40%">{{$key->master_member_r->judul}}</td>
                    <td width="10%" style="text-align:right" class="font-weight-bold">{{formatRupiah($key->harga)}}</td>
                    <td>
                      {{Carbon\Carbon::parse($key->created_at)->translatedFormat('l, d F Y , H:i:s')}}
                      @if($key->status==0)
                      @endif
                    </td>
                    @php
                    $idstatus = $key->status;

                    if($key->expired < Carbon\Carbon::now()){
                    }
                    else{
                    }
                    @endphp
                    <td width="10%">
                      <label class="{{statuspayment($idstatus,2)}}">{{statuspayment($idstatus,1)}}</label>
                      @if($idstatus==0)
                      <a href="{{url('detailbayar')}}/{{Crypt::encrypt($key->id)}}">
                        <label class="_hover badge badge-info">Konfirmasi Pembayaran</label>
                      </a>
                      @endif
                    </td>
                   
                  </tr>
                  @endforeach
                @else
                  <tr>
                    <td colspan="5" style="text-align:center" class="font-weight-bold">Belum Ada Transaksi</td>
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
  $(document).ready(function(){
      // alert('x');
  });
</script>
<!-- Loading Overlay -->
@endsection


