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
<p>Password kamu berhasil direset, berikut detailnya :</p>
<p>Username : {{ $email }}</p>
<p>Password : {{ $password }}</p>

<div class="footer">
    <p>Email ini adalah layanan yang disediakan oleh {{$namaweb}}</p>
    <p>©{{date("Y")}} {{$namaweb}} - {{$namaserver}}</p>
</div>