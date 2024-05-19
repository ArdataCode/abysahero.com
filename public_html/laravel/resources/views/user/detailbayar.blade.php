@extends('layouts.Skydash')

@section('content')
@php
    $template = App\Models\Template::where('id','<>','~')->first();
@endphp
<link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.5.9/slick.min.css"/>
<link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.5.9/slick-theme.min.css"/>
<div class="content-wrapper">
    <div class="main">
        <div class="row">
            <div class="col-md-2 align-items-stretch">
            </div>

            <div class="col-md-8 align-items-stretch">
              <div class="row">

              <div class="col-md-12 grid-margin stretch-card">
                  <div class="card">
                    <div class="card-body">
                      <br>
                      <h4>Order ID : {{$transaksi->merchant_order_id}}</h4>
                      <!-- <code style="padding:15px 0px">Bayar Sebelum : {{Carbon\Carbon::parse($transaksi->expired)->addSeconds(1)->translatedFormat('l, d F Y , H:i:s')}}</code> -->
                      <br>
                      <h5 class="card-title">Jumlah yang harus dibayar:</h5>
                      <h1 style="text-align:center;color:#FF4747;font-weight: bold;">{{formatRupiah($transaksi->harga)}}</h1>
                      <br>
                      <h4 class="card-title">Pembayaran dapat dilakukan ke salah satu nomor rekening / e-wallet dibawah ini:</h4>
                      <!-- <p class="card-description">
                        Add class <code>.icon-lg</code>, <code>.icon-md</code>, <code>.icon-sm</code>
                      </p> -->
                      <div class="table-responsive">
                        <div class="d-none d-md-block d-lg-block">
                          <table class="table table-borderless">
                            <tbody>
                            <tr>
                                <td colspan="2" style="text-align:center;background:antiquewhite;border-radius: 8px;"><h4>Transfer Bank</h4></td>
                            </tr>
                            @foreach($rek->where('kategori',0) as $datarek)
                            <tr>
                                <td class="_bankrek">{{$datarek->nama}} <code>({{$datarek->partner}})</code></td>
                                <td class="_rek">{{$datarek->no}}</td>
                            </tr>
                            @endforeach
                            <tr>
                                <td colspan="2" style="text-align:center;background:antiquewhite;border-radius: 8px;"><h4>E-Wallet</h4></td>
                            </tr>
                            @foreach($rek->where('kategori',1) as $datarek)
                            <tr>
                                <td class="_bankrek">{{$datarek->nama}} <code>({{$datarek->partner}})</code></td>
                                <td class="_rek">{{$datarek->no}}</td>
                            </tr>
                            @endforeach
                            
                            <!-- <tr>
                                <td class="_bankrek">BANK BRI</td>
                                <td class="_rek">12345678910</td>
                            </tr>
                            <tr>
                                <td class="_bankrek">BANK BNI</td>
                                <td class="_rek">12345678910</td>
                            </tr>
                            <tr>
                                <td class="_bankrek">PERMATA BANK</td>
                                <td class="_rek">12345678910</td>
                            </tr>
                            <tr>
                                <td class="_bankrek">BANK MANDIRI</td>
                                <td class="_rek">12345678910</td>
                            </tr> -->
                            </tbody>
                        </table>
                      </div>
                      <br>
                      <div class="d-block d-md-none d-lg-none">
                          <table class="table table-borderless">
                              <tbody>
                              <tr>
                                <td style="text-align:center;background:antiquewhite;border-radius: 8px;padding:0.1rem"><code><h4>Transfer Bank</h4></code></td>
                              </tr>
                              <tr>
                                <td></td>
                              </tr>
                              @foreach($rek->where('kategori',0) as $datarek)
                              <tr>
                                  <td class="_bankrek2">{{$datarek->nama}} <code>({{$datarek->partner}})</code></td>
                              </tr>
                              <tr>
                                  <td class="_rek2">{{$datarek->no}}</td>
                              </tr>
                              @endforeach
                              <tr>
                                <td style="text-align:center;background:antiquewhite;border-radius: 8px;padding:0.1rem"><code><h4>E-Wallet</h4></code></td>
                              </tr>
                              <tr>
                                <td></td>
                              </tr>
                              @foreach($rek->where('kategori',1) as $datarek)
                              <tr>
                                  <td class="_bankrek2">{{$datarek->nama}} <code>({{$datarek->partner}})</code></td>
                              </tr>
                              <tr>
                                  <td class="_rek2">{{$datarek->no}}</td>
                              </tr>
                              @endforeach
                              <!-- <tr>
                                  <td class="_bankrek2">BANK BRI</td>
                              </tr>
                              <tr>
                                  <td class="_rek2">12345678910</td>
                              </tr>
                              <tr>
                                  <td class="_bankrek2">BANK BNI</td>
                              </tr>
                              <tr>
                                  <td class="_rek2">12345678910</td>
                              </tr>
                              <tr>
                                  <td class="_bankrek2">PERMATA BANK</td>
                                </tr>
                              <tr>
                                  <td class="_rek2">12345678910</td>
                              </tr>
                              <tr>
                                  <td class="_bankrek2">BANK MANDIRI</td>
                              </tr>
                              <tr>
                                  <td class="_rek2">12345678910</td>
                              </tr> -->
                              </tbody>
                          </table>
                      </div>
                    </div>
                    <br>
                    <br>
                    @if($transaksi->status==0)
                    <div class="col-md-12 grid-margin" style="text-align:center">
                        <a href="https://api.whatsapp.com/send?phone={{$template->no_hp}}&text=Halo Admin Saya {{Auth::user()->name}} ({{Auth::user()->username}}) Mau Upload Bukti Pembayaran dengan Order ID {{$transaksi->merchant_order_id}}" target="_blank" class="btn btn-primary btn-icon-text">
                        <i class="ti-back-left btn-icon-prepend"></i>                                                    
                        UPLOAD BUKTI PEMBAYARAN
                        </a>   
                    </div>
                    @endif
                    </div>
                  </div>
                </div>

               

              </div>
            </div>
        </div>

    </div>
</div>

<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.8.1/slick.min.js"></script>
<script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
      $(document).ready(function(){

      });
</script>
@endsection