<style>
    .tombol{
        background: #028618;
        padding: 5px 15px;
        text-decoration: none;
        color: white;
        border-radius: 4px;
    }
    .footer{
        text-align:center;padding:25px;background:lightgray;
    }
</style>
<h3>Hi, {{ $nama }} !</h3>
<p>Proses registrasi kamu berhasil, silahkan lanjutkan ke proses aktivasi dengan mengklik link dibawah ini</p>
<div style="text-align:center">
    <a class="tombol" href="{{url('aktivasi')}}/{{ $id }}">Link Aktivasi</a>
</div> 
<p>Terima Kasih</p>
<p>{{$namaweb}}</p>

<div class="footer">
    <p>Email ini adalah layanan yang disediakan oleh {{$namaweb}}</p>
    <p>©{{date("Y")}} {{$namaweb}} - {{$namaserver}}</p>
</div>