<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Soal Kecermatan</title>
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
        .ml-0{
            margin-left:-10px;
        }
        .soaldtl{
            margin:0px 0px 45px 0px;
            padding-inline-start: 0px;
            display: list-item;
            margin-left : 1em; 
            /* list-style-type: lower-alpha; */
        }
        .soaldtl li
        {
            display: inline;
            list-style-type: none;
            padding: 5px 30px;
            float: left;
            border: 1px solid black;
            text-align: center;
        }
        .jawabandtl{
            margin:-15px 0px 45px 0px;
            padding-inline-start: 0px;
        }
        .jawabandtl li
        {
            display: inline;
            list-style-type: none;
            padding: 0px 15px;
            float: left;
            /* border: 1px solid black; */
            text-align: center;
        }
        .headdtl{
            margin-block-end: 0em;
            margin-left:55px;
        }
    </style>
</head>
<body>
    <!-- <h6 style="position:fixed;bottom:-30px;">Tanggal Cetak : {{Carbon\Carbon::now()->translatedFormat('l, d F Y , H:i:s')}}</h6> -->
    <div>
        <center>
            <h2>Paket Soal Kecermatan<br>{{$paketsoalmst->judul}}</h2>
        </center>
        <div style="margin-bottom:15px">
            <b>Jumlah Soal Master: {{count($paketsoaldtl)}} Master / {{count($dtlsoal)}} Detail</b>
            <br>
            <b>Tanggal Cetak : {{Carbon\Carbon::now()->translatedFormat('l, d F Y , H:i:s')}}</b>

        </div>
    </div>
    @foreach($paketsoaldtl as $key)
    <div class="row">
        <div class="col-3">
            <b>{{$loop->iteration}}.</b>
        </div>
        <div class="col-97">
            <table class="table">
                <tbody>
                    <tr>
                        @foreach(json_decode($key->master_soal_kecermatan_r->karakter) as $loopdatamaster)
                        <td><h2><b>{{$loopdatamaster}}</b></h2></td>
                        @endforeach
                    </tr>
                    <tr>
                        @foreach(json_decode($key->master_soal_kecermatan_r->kiasan) as $loopdatamaster)
                        <td><h4><b>{{$loopdatamaster}}</b></h4></td>
                        @endforeach
                    </tr>
                </tbody>
            </table>
            <br>
            @php
                $dtlsoal = App\Models\DtlSoalKecermatan::where('fk_master_soal_kecermatan',$key->fk_master_soal_kecermatan)->inRandomOrder()->get();
                $no = 'a';
            @endphp
            @foreach($dtlsoal as $dtlsoalx)
            <div class="row">
               <div>
                    <ul class="soaldtl">
                        @foreach(json_decode($dtlsoalx->soal) as $loopdatadtl)
                        <li>{{$loopdatadtl}}</li>
                        @endforeach
                    </ul>
                    <h4 class="headdtl">Jawaban :</h4>
                    <ul class="jawabandtl">
                        @foreach(json_decode($key->master_soal_kecermatan_r->kiasan) as $loopdatadtl)
                        <li><input type="radio"><br>{{$loopdatadtl}}</li>
                        @endforeach
                    </ul>
               </div> 
            </div>
            @php
                $no++;
            @endphp
            <br>
            @endforeach
        </div>
    </div>
    <br>
    @endforeach
</body>
</html>