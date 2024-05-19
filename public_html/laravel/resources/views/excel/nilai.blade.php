<table>
    <tbody>
        <tr>
            <td>HASIL UJI</td>
            <td style="text-align:left:font-weight:bold"> : {{$ujian->judul}}</td>
        </tr>
        <tr>
            <td>NO UJIAN</td>
            <td style="text-align:left:font-weight:bold"> : PG-{{sprintf("%06d", $ujian->id)}}</td>
        </tr>
        <tr>
            <td>NAMA</td>
            <td style="text-align:left:font-weight:bold"> : {{$ujian->user_r->name}}</td>
        </tr>
        <tr>
            <td>NILAI</td>
            <td style="text-align:left:font-weight:bold"> : {{$ujian->nilai ?: 0  }}</td>
        </tr>
    </tbody>
</table>
<table>
    <thead>
        <tr>
            <th colspan="4" style="text-align:center">HASIL KERJA</th>
            <th colspan="5" style="text-align:center">KUNCI JAWABAN</th>
        </tr>
    </thead>
    <tbody>
        <tr>
            <td style="text-align:center">NO</td>
            <td style="text-align:center">JAWABAN</td>
            <td style="text-align:center">POINT</td>
            <td style="text-align:center"></td>
            <td style="text-align:center">A</td>
            <td style="text-align:center">B</td>
            <td style="text-align:center">C</td>
            <td style="text-align:center">D</td>
            <td style="text-align:center">E</td>
        </tr>
    @php $no = 1 @endphp
    @foreach($datanilai as $datanilais)
        <tr>
            <td style="text-align:center">{{ $no++ }}</td>
            <td>{{ $datanilais->jawaban_user ? strtoupper($datanilais->jawaban_user) : "-" }}</td>
            <td>{{ $datanilais->benar_salah }}</td>
            <td></td>
            @php
                if($datanilais->jawaban=="a"){
                    $point = 1;
                }else{
                    $point = 0;
                }
            @endphp
            <td>{{$ujian->jenis_penilaian==1 ? $point : $datanilais->point_a}}</td>
            @php
                if($datanilais->jawaban=="b"){
                    $point = 1;
                }else{
                    $point = 0;
                }
            @endphp
            <td>{{$ujian->jenis_penilaian==1 ? $point : $datanilais->point_b}}</td>
            @php
                if($datanilais->jawaban=="c"){
                    $point = 1;
                }else{
                    $point = 0;
                }
            @endphp
            <td>{{$ujian->jenis_penilaian==1 ? $point : $datanilais->point_c}}</td>
            @php
                if($datanilais->jawaban=="d"){
                    $point = 1;
                }else{
                    $point = 0;
                }
            @endphp
            <td>{{$ujian->jenis_penilaian==1 ? $point : $datanilais->point_d}}</td>
            @php
                if($datanilais->jawaban=="e"){
                    $point = 1;
                }else{
                    $point = 0;
                }
            @endphp
            <td>{{$ujian->jenis_penilaian==1 ? $point : $datanilais->point_e}}</td>
        </tr>
    @endforeach
    </tbody>
</table>