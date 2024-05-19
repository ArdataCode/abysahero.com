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
<h1 class="m-0">{{$ujian->judul}}</h1>
@endsection

@section('contentheadermenu')
<ol class="breadcrumb float-sm-right">
<li class="breadcrumb-item"><a class="_kembali" href="{{url('nilaipeserta')}}/{{Crypt::encrypt($ujian->fk_paket_soal_mst)}}"><i class="fa fa-arrow-left" aria-hidden="true"></i> Kembali</a></li>
</ol>
@endsection

@section('content')
    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
        <div class="row">
          <div class="col-12">
            <div class="card">
              <!-- <div class="card-header">
              </div> -->
              <!-- /.card-header -->
              <div class="card-body">
            
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
            <br>
            <table class="table table-bordered">
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
                        <td style="text-align:center;width:1%">{{ $no++ }}</td>
                        <td style="text-align:center">{{ $datanilais->jawaban_user ? strtoupper($datanilais->jawaban_user) : "-" }}</td>
                        <td style="text-align:center">{{ $datanilais->benar_salah }}</td>
                        <td></td>
                        @php
                            if(stripos($datanilais->jawaban, 'a') !== FALSE){
                                $point = 1;
                            }else{
                                $point = 0;
                            }
                        @endphp
                        <td style="text-align:center">{{$ujian->jenis_penilaian==1 ? $point : $datanilais->point_a}}</td>
                        @php
                            if(stripos($datanilais->jawaban, 'b') !== FALSE){
                                $point = 1;
                            }else{
                                $point = 0;
                            }
                        @endphp
                        <td style="text-align:center">{{$ujian->jenis_penilaian==1 ? $point : $datanilais->point_b}}</td>
                        @php
                            if(stripos($datanilais->jawaban, 'c') !== FALSE){
                                $point = 1;
                            }else{
                                $point = 0;
                            }
                        @endphp
                        <td style="text-align:center">{{$ujian->jenis_penilaian==1 ? $point : $datanilais->point_c}}</td>
                        @php
                            if(stripos($datanilais->jawaban, 'd') !== FALSE){
                                $point = 1;
                            }else{
                                $point = 0;
                            }
                        @endphp
                        <td style="text-align:center">{{$ujian->jenis_penilaian==1 ? $point : $datanilais->point_d}}</td>
                        @php
                            if(stripos($datanilais->jawaban, 'e') !== FALSE){
                                $point = 1;
                            }else{
                                $point = 0;
                            }
                        @endphp
                        <td style="text-align:center">{{$ujian->jenis_penilaian==1 ? $point : $datanilais->point_e}}</td>
                    </tr>
                @endforeach
                </tbody>
            </table>

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

      tablerankingpeserta("tabledata");
      
      $(".int").on('input paste', function () {
        hanyaInteger(this);
      });

      $('.select-predikat').select2({
        placeholder: "Set Predikat"
      });

      $('.status').select2({
        placeholder: "Status"
      });

      // Fungsi Ubah Data
      $(document).on('click', '.btn-submit-data', function (e) {
          idform = $(this).attr('idform');
          $('#formData_'+idform).validate({
            rules: {
              'set_nilai[]': {
                required: true
              },
              'set_predikat[]': {
                required: true
              }
            },
            messages: {
              'set_nilai[]': {
                required: "Set point tidak boleh kosong"
              },
              'set_predikat[]': {
                required: "Set predikat tidak boleh kosong"
              }
            },
            errorElement: 'span',
              errorPlacement: function (error, element) {
              if (element.hasClass('_select2')) {     
                  element.parent().addClass('select2-error');
                  error.addClass('invalid-feedback');
                  element.closest('.form-group').append(error);
              } else {                                      
                  error.addClass('invalid-feedback');
                  element.closest('.form-group').append(error);
              }
            },
            highlight: function (element, errorClass, validClass) {
              $(element).addClass('is-invalid');
              if(element.tagName.toLowerCase()=='select'){
                var x = element.getAttribute('id');
                y = $('#'+x).parent().addClass('select2-error');
              }
            },
            unhighlight: function (element, errorClass, validClass) {
              $(element).removeClass('is-invalid');
              if(element.tagName.toLowerCase()=='select'){
                var x = element.getAttribute('id');
                y = $('#'+x).parent().removeClass('select2-error');
              }
            },
            submitHandler: function () {
            
              var formData = new FormData($('#formData_'+idform)[0]);

              var url = "{{ url('/updateranking') }}/"+idform;
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
                          reload(1000);
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
            }
          });
      });

  });
</script>

@endsection