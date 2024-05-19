<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Soal Pilihan Ganda</title>
    <style>
        .table{
            width:100%;
            margin-bottom:15px;
        }
        .table tr td{
            text-align:center;
            border:1px solid black; 
            width:20%;
        }
        .row{
            width:100%;
            display: flex;
            flex-wrap: wrap;
        }
        .col-3{
            width:3%;
            position: absolute;
        }
        .col-97{
            width:95%;
            position: relative;
            margin-left:40px;
        }
        .pilgan{
            list-style-type: none;
        }
        .pilgan li{
            margin-bottom:10px;
        }
        .radiopilgan{
            margin-left:-40px;
            margin-top:-4px;
            position: absolute;
        }
        .txtpilgan{
            margin-left:-15px;
        }
    </style>
</head>
<body>
    <!-- <h6 style="position:fixed;bottom:-30px;">Tanggal Cetak : {{Carbon\Carbon::now()->translatedFormat('l, d F Y , H:i:s')}}</h6> -->
    <div>
        <center>
            <h2>Paket Soal Pilihan Ganda<br>{{$paketsoalmst->judul}}</h2>
        </center>
        <div style="margin-bottom:15px">
            <b>Jumlah Soal : {{count($paketsoaldtl)}} Soal</b>
            <br>
            <b>Tanggal Cetak : {{Carbon\Carbon::now()->translatedFormat('l, d F Y , H:i:s')}}</b>
        </div>
    </div>
    @foreach($paketsoalktg as $key)
    <center><h4>Kategori : {{$key->kategori_soal_r->judul}}</h4></center>
    @php
        $cekdata = App\Models\PaketSoalDtl::where('fk_paket_soal_ktg','=',$key->id)->inRandomOrder()->get();
    @endphp
        @foreach($cekdata as $datadtl)
        <div class="row">
            <div class="col-97">
                <b>{{$loop->iteration}}.</b>
                <span>{!!$datadtl->master_soal_r->soal!!}</span>
                <ul class="pilgan">
                    <li><input class="radiopilgan" type="radio"><span class="txtpilgan">{!!$datadtl->master_soal_r->a!!}</span></li>
                    <li><input class="radiopilgan" type="radio"><span class="txtpilgan">{!!$datadtl->master_soal_r->b!!}</span></li>
                    <li><input class="radiopilgan" type="radio"><span class="txtpilgan">{!!$datadtl->master_soal_r->c!!}</span></li>
                    <li><input class="radiopilgan" type="radio"><span class="txtpilgan">{!!$datadtl->master_soal_r->d!!}</span></li>
                    <li><input class="radiopilgan" type="radio"><span class="txtpilgan">{!!$datadtl->master_soal_r->e!!}</span></li>
                </ul>
            </div>
        </div>
        <br>
        @endforeach
    @endforeach
</body>
</html>