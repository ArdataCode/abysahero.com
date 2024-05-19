@extends('layouts.Adminlte3')

@section('header')
  <!-- Google Font: Source Sans Pro -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="{{ asset('layout/adminlte3/plugins/fontawesome-free/css/all.min.css') }}">
  <!-- DataTables -->
  <link rel="stylesheet" href="{{ asset('layout/adminlte3/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css') }}">
  <link rel="stylesheet" href="{{ asset('layout/adminlte3/plugins/datatables-responsive/css/responsive.bootstrap4.min.css') }}">
  <link rel="stylesheet" href="{{ asset('layout/adminlte3/plugins/datatables-buttons/css/buttons.bootstrap4.min.css') }}">
  <!-- Theme style -->
  <link rel="stylesheet" href="{{ asset('layout/adminlte3/dist/css/adminlte.min.css') }}">
  
@endsection

@section('contentheader')
<h1 class="m-0">List Soal</h1>
@endsection

@section('contentheadermenu')
<ol class="breadcrumb float-sm-right">
    <li class="breadcrumb-item"><a class="_kembali" href="{{url('paketsoalkecermatan')}}"><i class="fa fa-arrow-left" aria-hidden="true"></i> Kembali</a></li>
</ol>
@endsection

@section('content')
    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
        <div class="row">
          <div class="col-12">
            <div class="card">
              <div class="card-header">
                  <div class="row">
                      <div class="col-sm-2">Judul</div>
                      <div class="col-sm-10">: {{$data->judul}}</div>
                  </div>
                  <div class="row">
                      <div class="col-sm-2">KKM</div>
                      <div class="col-sm-10">: {{$data->kkm}}</div>
                  </div>
                  <div class="row">
                      <div class="col-sm-2">Total Soal</div>
                      <div class="col-sm-10">: {{$data->total_soal}} Butir</div>
                  </div>
              </div>
              <div class="card-body">
                  <span>
                    <button id="btn_simpan_data" type="button" class="btn btn-md btn-primary btn-add-absolute">
                      Simpan
                    </button>
                  </span>
                  <!-- <button data-toggle="modal" data-target="#modal-tambah" type="button" class="btn btn-md btn-primary btn-absolute">Tambah</button> -->
                  <form method="post" id="_formData" class="form-horizontal">
                  @csrf
                  <table id="tabledata" class="table  table-striped">
                    <thead>
                    <tr>
                      <th style="text-align:left"><input type="checkbox" class="checkAll"> Ceklis Semua</th>
                      <th>Kategori</th>
                      <th>Waktu</th>
                      <th>Soal</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($mastersoal as $key)
                      @php
                          $cekdata = App\Models\PaketSoalKecermatanDtl::where('fk_master_soal_kecermatan',$key->id)->first();
                          if($cekdata){
                            $valcek = 'checked';
                            $cekdatafix = 1;
                          }else{
                            $valcek = '';
                            $cekdatafix = 0;
                          }
                          $waktu = App\Models\DtlSoalKecermatan::where('fk_master_soal_kecermatan',$key->id)->first();
                      @endphp
                      <tr>
                          <td width="1%"><input type="checkbox" name="id_master_soal[]" class="checkbox" value="{{$key->id}}" {{$valcek}}></td>
                          <td width="1%">{{$key->kategori_soal_kecermatan_r->judul}}</td>
                          <td width="1%">{{$key->waktu}} Detik</td>
                          <td class="_align_center" width="40%">
                            <table class="table table-bordered" style="margin-bottom:0">
                              <thead>
                                @php
                                  $datajson = json_decode($key->karakter);
                                @endphp
                                <tr>
                                  @foreach($datajson as $dataloop)
                                  <th><h2><b>{{$dataloop}}</b></h2></th>
                                  @endforeach
                                </tr>
                                @php
                                    $datajson = json_decode($key->kiasan);
                                @endphp
                                <tr>
                                  @foreach($datajson as $dataloop)
                                  <th><h5><b>{{$dataloop}}</b></h5></th>
                                  @endforeach
                                </tr>
                              </thead>
                            </table>
                          </td>
                      </tr>
                    @endforeach
                    </tbody>
                  </table>
                  </form>
              </div>
              <!-- /.card-body -->
            </div>
            <!-- /.card -->
          </div>
          <!-- /.col -->
        </div>
        <!-- /.row -->
      </div>
      <!-- /.container-fluid -->
    </section>
    <!-- /.content -->

@endsection

@section('footer')
<!-- Custom Input File -->
<script src="{{ asset('layout/adminlte3/plugins/bs-custom-file-input/bs-custom-file-input.min.js') }}"></script>
<!-- jQuery -->
<script src="{{ asset('layout/adminlte3/plugins/jquery/jquery.min.js') }}"></script>
<!-- Bootstrap 4 -->
<script src="{{ asset('layout/adminlte3/plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
<!-- jquery-validation -->
<script src="{{ asset('layout/adminlte3/plugins/jquery-validation/jquery.validate.min.js') }}"></script>
<script src="{{ asset('layout/adminlte3/plugins/jquery-validation/additional-methods.min.js') }}"></script>
<!-- DataTables  & Plugins -->
<script src="{{ asset('layout/adminlte3/plugins/datatables/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('layout/adminlte3/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js') }}"></script>
<script src="{{ asset('layout/adminlte3/plugins/datatables-responsive/js/dataTables.responsive.min.js') }}"></script>
<script src="{{ asset('layout/adminlte3/plugins/datatables-responsive/js/responsive.bootstrap4.min.js') }}"></script>
<script src="{{ asset('layout/adminlte3/plugins/datatables-buttons/js/dataTables.buttons.min.js') }}"></script>
<script src="{{ asset('layout/adminlte3/plugins/datatables-buttons/js/buttons.bootstrap4.min.js') }}"></script>
<script src="{{ asset('layout/adminlte3/plugins/jszip/jszip.min.js') }}"></script>
<script src="{{ asset('layout/adminlte3/plugins/pdfmake/pdfmake.min.js') }}"></script>
<script src="{{ asset('layout/adminlte3/plugins/pdfmake/vfs_fonts.js') }}"></script>
<script src="{{ asset('layout/adminlte3/plugins/datatables-buttons/js/buttons.html5.min.js') }}"></script>
<script src="{{ asset('layout/adminlte3/plugins/datatables-buttons/js/buttons.print.min.js') }}"></script>
<script src="{{ asset('layout/adminlte3/plugins/datatables-buttons/js/buttons.colVis.min.js') }}"></script>
<!-- AdminLTE App -->
<script src="{{ asset('layout/adminlte3/dist/js/adminlte.min.js') }}"></script>
<!-- AdminLTE for demo purposes -->
<script src="{{ asset('layout/adminlte3/dist/js/demo.js') }}"></script>
<!-- Page specific script -->
<!-- DatePicker -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/flatpickr/4.2.3/flatpickr.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/flatpickr/4.2.3/themes/dark.css">
<!--  Flatpickr  -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/flatpickr/4.2.3/flatpickr.js"></script>
<script>
  $(document).ready(function(){


    datatablekatesoal("tabledata");

    $(".checkAll").on('change',function(){
      $(".checkbox").prop('checked',$(this).is(":checked"));
    });

    // Fungsi Simpan Data
    $(document).on('click', '#btn_simpan_data', function (e) {
      var formData = new FormData($('#_formData')[0]);
      var url = "{{ url('storepaketsoalkecermatandtl') }}/{{$data->id}}";
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
              $.LoadingOverlay("show");
          },
          success: function (response) {
              if (response.status == true) {
                  Swal.fire({
                    html: response.message,
                    icon: 'success',
                    showConfirmButton: false
                  });
                  reload_url(1000,"{{url('paketsoalkecermatan')}}");
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

@endsection