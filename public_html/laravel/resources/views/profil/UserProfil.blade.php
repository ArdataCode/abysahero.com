@extends('layouts.Adminlte3')

@section('header')
  <!-- Google Font: Source Sans Pro -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="{{ asset('layout/adminlte3/plugins/fontawesome-free/css/all.min.css') }}">
  <!-- Theme style -->
  <link rel="stylesheet" href="{{ asset('layout/adminlte3/dist/css/adminlte.min.css') }}">
@endsection

@section('contentheader')
<h1 class="m-0">Profil</h1>
@endsection

@section('contentheadermenu')
<ol class="breadcrumb float-sm-right">
    <!-- <li class="breadcrumb-item"><a href="#">Home</a></li> -->
    <li class="breadcrumb-item active">Profil</li>
</ol>
@endsection

@section('content')
    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
        <div class="row">
          <div class="col-md-4 col-sm-4">

            <!-- Profile Image -->
            <div class="card card-primary card-outline">
              <div class="card-body box-profile">
                <div class="text-center">
                  @if(Auth::user()->photo=='' || Auth::user()->photo==NULL)
                      <img class="profile-user-img img-fluid img-circle"
                       src="{{ asset('image/global/unknown_user.png') }}"
                       alt="User Profile Picture">
                  @else
                      <a href="#" onclick="modalImage('{{ucfirst(Auth::user()->name)}}','{{asset(Auth::user()->photo)}}')"><img class="profile-user-img img-fluid img-circle"
                       src="{{ asset(Auth::user()->photo) }}"
                       alt="User Profile Picture"></a>
                  @endif
                </div>

                <h3 class="profile-username text-center">{{ ucfirst(Auth::user()->name) }}</h3>

                <!-- <p class="text-muted text-center">{{ ucfirst(Auth::user()->nik) }}</p> -->

                <ul class="list-group list-group-unbordered mb-3">
                  <li class="list-group-item">
                    <b>Jenis Kelamin</b>
                    <a class="float-right">
                      @if(Auth::user()->jenis_kelamin=='l')
                          Laki-laki
                      @elseif(Auth::user()->jenis_kelamin=='p')
                          Perempuan
                      @else
                          -
                      @endif
                    </a>
                  </li>
                  <!-- <li class="list-group-item">
                    <b>Tanggal Lahir</b> <a class="float-right">{{ tglIndo(Auth::user()->ttl) }}</a>
                  </li> -->
                  <li class="list-group-item">
                    <b>Email</b> <a class="float-right">{{ Auth::user()->email }}</a>
                  </li>
                </ul>
              </div>
              <!-- /.card-body -->
            </div>
            <!-- /.card -->

            <!-- /.card -->
          </div>
          <!-- /.col -->
          <div class="col-md-8 col-sm-8">
            <div class="card card-primary card-outline">
              <div class="card-header p-2">
                <ul class="nav nav-pills">
                  <li class="nav-item"><a class="nav-link active" href="#tabsettings" data-toggle="tab">Profil</a></li>
                  <li class="nav-item"><a class="nav-link" href="#tabpassword" data-toggle="tab">Password</a></li>
                </ul>
              </div><!-- /.card-header -->
              <div class="card-body">
                <div class="tab-content">

                  <div class="active tab-pane" id="tabsettings">
                    <form id="formUserSetting" class="form-horizontal" method="post">
                    @csrf
                      <div class="form-group row"`>
                        <label for="username" class="col-sm-2 col-form-label">Username</label>
                        <div class="col-sm-10">
                          <input readonly type="text" name="username" class="form-control" id="username" placeholder="Username" value="{{ Auth::user()->username }}">
                        </div>
                      </div>
                      <div class="form-group row">
                        <label for="name" class="col-sm-2 col-form-label">Nama Lengkap</label>
                        <div class="col-sm-10">
                          <input name="name" type="text" class="form-control" id="name" placeholder="Name" value="{{ Auth::user()->name }}"> 
                        </div>
                      </div>
                      <div class="form-group row">
                        <label for="jenis_kelamin" class="col-sm-2 col-form-label">Jenis Kelamin</label>
                        <div class="col-sm-10">
                          <select class="form-control" id="jenis_kelamin" name="jenis_kelamin">
                            <option value="">-- Pilih Jenis Kelamin --</option>
                            <option {{ Auth::user()->jenis_kelamin=='l' ? 'selected' : '' }} value="l">Laki-laki</option>
                            <option {{ Auth::user()->jenis_kelamin=='p' ? 'selected' : '' }} value="p">Perempuan</option>
                          </select>
                        </div>
                      </div>
                      <!-- <div class="form-group row">
                        <label for="ttl" class="col-sm-2 col-form-label">Tanggal Lahir</label>
                        <div class="col-sm-10">
                          <input type="text" class="form-control" name="ttl" id="ttl" placeholder="Tanggal Lahir" value="{{tglEdit(Auth::user()->ttl)}}"> 
                        </div>
                      </div> -->
                      <div class="form-group row">
                        <label for="alamat" class="col-sm-2 col-form-label">Alamat</label>
                        <div class="col-sm-10">
                          <textarea name="alamat" id="alamat" rows="5" class="form-control" placeholder="Alamat">{{ Auth::user()->alamat }}</textarea>
                        </div>
                      </div>
                      <div class="form-group row">
                        <label for="email" class="col-sm-2 col-form-label">Email</label>
                        <div class="col-sm-10">
                          <input name="email" type="email" class="form-control" id="email" placeholder="Email" value="{{ Auth::user()->email }}"> 
                        </div>
                      </div>
                      <div class="form-group row">
                        <label class="col-sm-2 col-form-label">Photo<br><span class="input-keterangan">(jpg/jpeg/png)</span></label>
                        <div class="col-sm-10">
                          <div class="input-group">
                            <div class="custom-file">
                              <input type="file" class="input-foto" id="photo" name="photo" idlabel="label-photo">
                              <label id="label-photo" class="custom-file-label" style="border-radius: .25rem;" for="photo">Choose file</label>
                            </div>
                            @if(Auth::user()->photo=='' || Auth::user()->photo==NULL)

                            @else
                            <div class="input-group-append">
                              <button type="button" class="input-group-text" onclick="modalImage('{{ucfirst(Auth::user()->name)}}','{{asset(Auth::user()->photo)}}')">Lihat</button>
                            </div>
                            @endif
                          </div> 
                        </div>
                      </div>
                      <div class="form-group row">
                        <div class="offset-sm-2 col-sm-10 _align_right">
                          <button type="submit" class="btn btn-danger">Simpan</button>
                        </div>
                      </div>
                    </form>
                  </div>

                  <div class="tab-pane" id="tabpassword">
                    <form method="post" id="formPassword" class="form-horizontal">
                    @csrf
                    <div class="form-group row">
                        <label for="password" class="col-sm-2 col-form-label">Password Lama</label>
                        <div class="col-sm-10">
                          <div class="input-group">
                            <input type="password" class="form-control" id="password" name="password" placeholder="Password Lama">
                            <div class="input-group-append showpassword" idpassword="password">
                              <span class="input-group-text"><i id="iconpassword" class="fas fa-eye-slash"></i></span>
                            </div>
                          </div>
                        </div>
                      </div>
                      <div class="form-group row">
                        <label for="passwordbaru" class="col-sm-2 col-form-label">Password Baru</label>
                        <div class="col-sm-10">
                          <div class="input-group">
                            <input type="password" class="form-control" id="passwordbaru" name="passwordbaru" placeholder="Password Baru">
                            <div class="input-group-append showpassword" idpassword="passwordbaru">
                              <span class="input-group-text"><i id="iconpasswordbaru" class="fas fa-eye-slash"></i></span>
                            </div>
                          </div>
                        </div>
                      </div>
                      <div class="form-group row">
                        <label for="ulangipassword" class="col-sm-2 col-form-label">Ulangi Password</label>
                        <div class="col-sm-10">
                          <div class="input-group">
                            <input type="password" class="form-control" name="ulangipassword" id="ulangipassword" placeholder="Ulangi Password">
                            <div class="input-group-append showpassword" idpassword="ulangipassword">
                              <span class="input-group-text"><i id="iconulangipassword" class="fas fa-eye-slash"></i></span>
                            </div>
                          </div>
                        </div>
                      </div>
                      <div class="form-group row">
                        <div class="offset-sm-2 col-sm-10 _align_right">
                          <button type="submit" class="btn btn-danger">Simpan</button>
                        </div>
                      </div>
                    </form>
                  </div>

                  <!-- /.tab-pane -->
                </div>
                <!-- /.tab-content -->
              </div><!-- /.card-body -->
            </div>
            <!-- /.card -->
          </div>
          <!-- /.col -->
        </div>
        <!-- /.row -->
      </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->
@endsection

@section('footer')
<!-- jQuery -->
<script src="{{ asset('layout/adminlte3/plugins/jquery/jquery.min.js') }}"></script>
<!-- Bootstrap 4 -->
<script src="{{ asset('layout/adminlte3/plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
<!-- jquery-validation -->
<script src="{{ asset('layout/adminlte3/plugins/jquery-validation/jquery.validate.min.js') }}"></script>
<script src="{{ asset('layout/adminlte3/plugins/jquery-validation/additional-methods.min.js') }}"></script>
<!-- AdminLTE App -->
<script src="{{ asset('layout/adminlte3/dist/js/adminlte.min.js') }}"></script>
<!-- AdminLTE for demo purposes -->
<script src="{{ asset('layout/adminlte3/dist/js/demo.js') }}"></script>
<!-- Custom Input File -->
<script src="{{ asset('layout/adminlte3/plugins/bs-custom-file-input/bs-custom-file-input.min.js') }}"></script>
<!-- DatePicker -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/flatpickr/4.2.3/flatpickr.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/flatpickr/4.2.3/themes/dark.css">
<!--  Flatpickr  -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/flatpickr/4.2.3/flatpickr.js"></script>
<script>
$(document).ready(function(){
  
  bsCustomFileInput.init();

  $(".showpassword").click(function(){
    var idpassword = $(this).attr('idpassword');
    var typepassword = $("#"+idpassword).attr('type');
    if(typepassword=="password"){
      $("#"+idpassword).attr('type','text');
      $("#icon"+idpassword).attr('class','fas fa-eye');
    }else{
      $("#"+idpassword).attr('type','password');
      $("#icon"+idpassword).attr('class','fas fa-eye-slash');
    }
  });

  $("#ttl").flatpickr({
      dateFormat: "d-m-Y",
      disableMobile: "true"
  });

  $(document).on('change', '.input-foto', function (e) {
        var idphoto = $(this).attr('id');
        onlyPhoto(idphoto);
  });

  $('#formUserSetting').validate({
    rules: {
      email: {
        email: true,
      },
      ttl: {
        required: true
      },
      jenis_kelamin:{
        required:true
      },
      photo: {
          extension: "jpeg|jpg|png"
      },
    },
    messages: {
      email: {
        email: "Masukkan alamat email yang benar"
      },
      ttl: {
        required: "Tanggal Lahir tidak boleh kosong"
      },
      jenis_kelamin: {
        required: "Jenis Kelamin tidak boleh kosong"
      },
      photo: {
        extension: "Masukkan format file yang sesuai"
      },
   
    },
    errorElement: 'span',
    errorPlacement: function (error, element) {
      error.addClass('invalid-feedback');
      element.closest('.col-sm-10').append(error);
    },
    highlight: function (element, errorClass, validClass) {
      $(element).addClass('is-invalid');
    },
    unhighlight: function (element, errorClass, validClass) {
      $(element).removeClass('is-invalid');
    },

    submitHandler: function () {

      var formData = new FormData($('#formUserSetting')[0]);

      var url = "{{ url('/updateUserProfil') }}";
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
              // $.LoadingOverlay("show");
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
              // $.LoadingOverlay("hide");
          }
      });

      }

  });

  $('#formPassword').validate({
    rules: {
      password: {
        required: true
      },
      passwordbaru: {
        required: true,
        minlength: 4,
      },
      ulangipassword: {
        required: true,
        equalTo : "#passwordbaru"
      },
    },
    messages: {
      password: {
        required: "Password tidak boleh kosong"
      },
      passwordbaru: {
        required: "Password Baru tidak boleh kosong",
        minlength:"Minimal 4 character"
      },
      ulangipassword: {
        required: "Ulangi Password tidak boleh kosong",
        equalTo: "Harus sama dengan password baru"
      }
   
    },
    errorElement: 'span',
    errorPlacement: function (error, element) {
      error.addClass('invalid-feedback');
      element.closest('.col-sm-10').append(error);
    },
    highlight: function (element, errorClass, validClass) {
      $(element).addClass('is-invalid');
    },
    unhighlight: function (element, errorClass, validClass) {
      $(element).removeClass('is-invalid');
    },

    submitHandler: function () {

            var formData = new FormData($('#formPassword')[0]);

            var url = "{{ url('/updateUserPassword') }}";
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
                    // $.LoadingOverlay("show");
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
                    // $.LoadingOverlay("hide");
                }
            });   
    }
  });

});
</script>
@endsection