<table>
    <tbody>
        <tr>
            <td>HASIL UJI</td>
            <td style="text-align:left:font-weight:bold"> : {{$datapaket->judul}}</td>
        </tr>
    </tbody>
</table>
<table>
    <thead>
        <tr>
            <th colspan="4" style="text-align:center">HASIL KERJA</th>
        </tr>
    </thead>
    <tbody>
        <tr>
            <td style="text-align:center">NO</td>
            <td style="text-align:center">NO UJI</td>
            <td style="text-align:center">NAMA</td>
            <td style="text-align:center">NILAI AKHIR</td>
        </tr>
    @php $no = 1 @endphp
    @foreach($udatapaket as $udatapakets)
        <tr>
            <td style="text-align:center">{{ $no++ }}</td>
            <td style="text-align:center">PG-{{sprintf("%06d", $udatapakets->id)}}</td>
            <td>{{ $udatapakets->user_r->name }}</td>
            <td>{{$udatapakets->nilai ?: "-"}}</td>
        </tr>
    @endforeach
    </tbody>
</table>