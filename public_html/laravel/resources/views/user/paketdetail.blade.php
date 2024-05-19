@extends('layouts.Skydash')
<!-- partial -->
@section('content')
<div class="content-wrapper">
  <div class="row">
    <div class="col-md-12">
      <div class="row">
        <div class="col-10 col-xl-10 mb-4 mb-xl-10">
          <h3 class="font-weight-bold">Member {{$member->judul}}</h3>
          <h2 class="font-weight-bold">{{formatRupiah($member->harga)}}</h2>
          <!-- <h6 class="font-weight-normal mb-0">Sudah siap belajar apa hari ini? Jangan lupa semangat karena banyak latihan dan tryout yang masih menunggu untuk diselesaikan.</h6> -->
        </div>
        <div class="col-2 col-xl-2">
          <div class="justify-content-end d-flex">
          <div class="dropdown flex-md-grow-1 flex-xl-grow-0">
            <a href="{{url('home')}}">
              <button type="button" class="btn btn-outline-danger btn-sm btn-fw">
              <i class="mdi mdi-keyboard-backspace"></i>
              <span class="_font_icon_sm">Kembali</span>
              </button>
              <br>
              <br>
            </a>
          </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  <div class="row">
  @foreach($paket as $key)
  <div class="col-md-4 grid-margin-md-0 stretch-card" style="margin-bottom:15px">
      <div class="card">
        <div class="card-body">
          <h4 class="card-title" style="background: #4b49ac;color: white;padding: 15px;border-radius: 8px;">
          @if($key->jenis==1)
          {{$key->paket_soal_mst_r->judul}}
          @elseif($key->jenis==2)
          {{$key->paket_soal_mst_kecermatan_r->judul}}
          @endif
          </h4>
          <!-- <p class="card-description">Add class <code>.list-star</code> to <code>&lt;ul&gt;</code></p> -->
          <div>
            @if($key->jenis==1)
            {!!$key->paket_soal_mst_r->ket!!}
            @elseif($key->jenis==2)
            {!!$key->paket_soal_mst_kecermatan_r->ket!!}
            @endif
          </div>
          <!-- <ul class="list-star">
            <li>Lorem ipsum dolor sit amet</li>
            <li>Consectetur adipiscing elit</li>
            <li>Integer molestie lorem at massa</li>
            <li>Facilisis in pretium nisl aliquet</li>
            <li>Nulla volutpat aliquam velit&gt;</li>
          </ul> -->
        </div>
      </div>
    </div>
    @endforeach
  </div>
  @if($member->harga>0 && count($paket)>0)
  <br>
  <div class="row">
    <div class="col-md-12 grid-margin grid-margin-md-0 stretch-card">
      <center><b>{{$member->batas_mengerjakan >= 99999 ? "Aktif Selamanya" : $member->batas_mengerjakan." Kali Pengerjaan"}}</b></center>
      <br>
      <br>
    </div>
    <div class="col-md-12 grid-margin grid-margin-md-0 stretch-card">
      <button data-bs-toggle="modal" data-bs-target="#modalkonfirmasi" type="button" class="btn btn-outline-primary btn-icon-text btn-block">
          <i style="font-size:1.5rem" class="mdi mdi-shopping _icon"></i>
          <span class="_font_icon">Beli Sekarang</span>
      </button>
        @php
            $cekdata = App\Models\Transaksi::where('fk_user_id','=',Auth::user()->id)->where('status',1)->where('fk_master_member_id',$member->id)->get();
        @endphp
        @if(count($cekdata)<=0)
        @else
        <!-- <button data-toggle="tooltip" data-placement="left" title="Anda sudah membeli paket ini" type="button" class="btn btn-outline-primary btn-icon-text btn-block disabled btn-lock">
            <i style="font-size:1.5rem" class="mdi mdi-shopping _icon"></i>
            <span class="_font_icon">Beli Sekarang</span>
        </button> -->
        @endif
    </div>
  </div>
  @endif
</div>

<div class="modal fade" id="modalkonfirmasi">
  <div class="modal-dialog">
    <div class="modal-content">

      <!-- Modal Header -->
      <div class="modal-header">
        <h4 class="modal-title">Konfirmasi Pembelian</h4>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
      </div>
      <!-- Modal body -->
      <div class="modal-body">
        <h4>Detail Pembelian</h4>
        <br>
          <div class="table-responsive">
              <table class="table table-borderless">
                <tbody>
                  <tr>
                    <td class="pl-0">Member</td>
                  </tr>
                  <tr>
                    <td class="pl-0"><h5>{{$member->judul}}</h5></td>
                  </tr>
                  <tr>
                    <td class="pl-0">Harga</td>
                  </tr>
                  <tr>
                    <td class="pl-0"><h5>{{formatRupiah($member->harga)}}</h5></td>
                  </tr>
                </tbody>
              </table>
            </div>
        </div>
      <!-- Modal footer -->
      <div class="modal-footer" style="display:block">
        <span style="float:left">Total Pembayaran<h3>{{formatRupiah($member->harga)}}</h3></span>
        <button style="float:right" type="button" class="btn btn-danger" id="btn-beli">Bayar</button>
      </div>
    </div>
  </div>
</div>
<style>
    .table tr td {
      padding:0.5rem;
    }
</style>
@endsection

@section('footer')
<!-- jQuery -->
@if(request()->getHttpHost()=="tryoutku.com")
<script src="https://app-prod.duitku.com/lib/js/duitku.js"></script>
@else
<script src="https://app-sandbox.duitku.com/lib/js/duitku.js"></script>
@endif
<!-- SweetAlert2 -->
<script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
  $(document).ready(function(){
      $('[data-toggle="tooltip"]').tooltip({
          trigger : 'hover'
      });
      $( "#btn-beli" ).click(function() {
          mastermemberid = "{{Crypt::encrypt($member->id)}}";
          $.ajaxSetup({
              headers: {
                  'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
              }
          });
          $.ajax({
              type: "POST",
              data:{
              // paymentMethod: '',
              mastermemberid: mastermemberid
              },
              url: '{{url("createorder")}}',
              dataType: "json",
              cache: false,
              beforeSend: function () {
                      $.LoadingOverlay("show", {
                          image       : "{{asset('/image/global/loading.gif')}}"
                      });
                  },
              success: function (response) { 
                  if (response.status === true) {
                      $('.modal').modal('hide');
                      Swal.fire({
                          html: response.message,
                          icon: 'success',
                          showConfirmButton: false
                      });
                      reload_url(2000,'{{url("detailbayar")}}/'+response.id);
                  }else{
                      Swal.fire({
                          html: response.message,
                          icon: 'error',
                          confirmButtonText: 'Ok'
                      });
                  }                           
              },
              error: function (xhr, status) {
                  alert('Error! Please Try Again');
              },
              complete: function () {
                  $.LoadingOverlay("hide");
              }
          });
      });
      $( "#btn-beli-duitku" ).click(function() {
          mastermemberid = "{{Crypt::encrypt($member->id)}}";
          $.ajaxSetup({
              headers: {
                  'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
              }
          });
          $.ajax({
              type: "POST",
              data:{
              // paymentMethod: '',
              mastermemberid: mastermemberid
              },
              url: '{{url("createorder")}}',
              dataType: "json",
              cache: false,
              beforeSend: function () {
                      $.LoadingOverlay("show", {
                          image       : "{{asset('/image/global/loading.gif')}}"
                      });
                  },
              success: function (result) { 
                      // console.log(result.reference);
                      console.log(result);
                      checkout.process(result.reference, {
                          successEvent: function(result){
                          // Add Your Action
                              // console.log('success');
                              // console.log(result);
                              $.LoadingOverlay("show", {
                                  image       : "{{asset('/image/global/loading.gif')}}"
                              });

                              // alert('Payment Success');
                              reload_url(1000,"{{url('/transaksi')}}");

                          },
                          pendingEvent: function(result){
                          // Add Your Action
                              // console.log('pending');
                              // console.log(result);
                              $.LoadingOverlay("show", {
                                  image       : "{{asset('/image/global/loading.gif')}}"
                              });

                              // alert('Payment Pending');
                              reload_url(1000,"{{url('/transaksi')}}");
                          },
                          errorEvent: function(result){
                          // Add Your Action
                              // console.log('error');
                              console.log(result);
                              alert('Payment Error');
                          },
                          closeEvent: function(result){
                          // Add Your Action
                              // console.log('customer closed the popup without finishing the payment');
                              // console.log(result);
                              // reload_url(1000,"{{url('/topuphistory')}}");
                              // alert('customer closed the popup without finishing the payment');
                          }
                      });  
                      $.LoadingOverlay("hide");                               
              },
              error: function (xhr, status) {
                  alert('Error! Please Try Again');
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


