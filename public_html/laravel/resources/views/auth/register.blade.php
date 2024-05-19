<!DOCTYPE html>
<html lang="en">

<head>
  <!-- Required meta tags -->
  <meta charset="utf-8">
  <meta name="csrf-token" content="{{ csrf_token() }}" />
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  @php
    $template = App\Models\Template::where('id','<>','~')->first();
  @endphp
  <title>{{$template->nama}}</title>
  <!-- plugins:css -->
  <link rel="stylesheet" href="{{ asset('layout/skydash/vendors/feather/feather.css') }}">
  <link rel="stylesheet" href="{{ asset('layout/skydash/vendors/ti-icons/css/themify-icons.css') }}">
  <link rel="stylesheet" href="{{ asset('layout/skydash/vendors/css/vendor.bundle.base.css') }}">
  <!-- endinject -->
  <!-- Plugin css for this page -->
  <!-- End plugin css for this page -->
  <!-- inject:css -->
  <link rel="stylesheet" href="{{ asset('layout/skydash/css/vertical-layout-light/style.css') }}">
  <!-- endinject -->
  <link rel="shortcut icon" href="{{ asset($template->logo_kecil) }}" />
  <script src="{{ asset('js/global.js') }}"></script>
  <link rel="stylesheet" href="{{ asset('css/skydash.css') }}">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jquery-nice-select/1.1.0/css/nice-select.css" integrity="sha512-uHuCigcmv3ByTqBQQEwngXWk7E/NaPYP+CFglpkXPnRQbSubJmEENgh+itRDYbWV0fUZmUz7fD/+JDdeQFD5+A==" crossorigin="anonymous" referrerpolicy="no-referrer" />
  <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />

</head>

<body>
  <div class="container-scroller">
    <div class="container-fluid page-body-wrapper full-page-wrapper">
      <div class="content-wrapper d-flex align-items-center auth px-0">
        <div class="row w-100 mx-0">
          <div class="col-lg-4 mx-auto">
            <div class="auth-form-light text-left py-5 px-4 px-sm-5">
              <div class="brand-logo">
                <img src="{{ asset($template->logo_besar) }}" alt="logo">
              </div>
              <h4>Pengguna baru?</h4>
              <h6 class="font-weight-light">Silahkan daftar terlebih dahulu</h6>
              <form class="pt-3" method="post" id="formRegister">
              @csrf
                <div class="form-group">
                  <input type="text" class="form-control form-control-lg" id="name" name="name" placeholder="Nama Lengkap">
                </div>
                <div class="form-group">
                    <textarea id="alamat" name="alamat" cols="30" rows="5" class="form-control form-control-lg" placeholder="Alamat Lengkap"></textarea>
                </div>
                <div class="form-group">
                    <select class="form-control form-control-lg _select2" id="provinsi" name="provinsi">
                      <option value=""></option>
                      @foreach($provinsi as $data)
                      <option value="{{$data->id_prov}}">{{$data->nama}}</option>
                      @endforeach
                    </select>
                </div>
                <div class="form-group">
                  <select class="form-control form-control-lg _select2" id="kabupaten" name="kabupaten">
                    <option value=""></option>
                  </select>
                </div>
                <div class="form-group">
                  <select class="form-control form-control-lg _select2" id="kecamatan" name="kecamatan">
                    <option value=""></option>
                  </select>
                </div>
                <div class="form-group">
                  <input type="email" class="form-control form-control-lg" id="email" name="email" placeholder="Email">
                </div>
                <div class="form-group">
                  <div class="input-group">
                    <div class="input-group-prepend">
                      <span class="input-group-text" style="border-radius:0px">+62</span>
                    </div>
                    <input type="text" class="form-control angka" id="no_wa" name="no_wa" placeholder="Nomor Whatsapp" aria-label="Nomor Whatsapp">
                  </div>
                </div>
                <div class="form-group">
                  <select class="form-control form-control-lg" id="jenis_kelamin" name="jenis_kelamin">
                  <option value=""></option>
                    <option value="l">Laki-laki</option>
                    <option value="p">Perempuan</option>
                  </select>
                </div>
                <div class="form-group">
                  <input type="password" class="form-control form-control-lg" id="password" name="password" placeholder="Password">
                </div>
                <div class="form-group">
                  <input type="password" class="form-control form-control-lg" id="password_" name="password_" placeholder="Konfirmasi Password">
                </div>
                <div class="mb-4">
                  <div class="form-check">
                    <!-- <label class="form-check-label text-muted">
                      <input type="checkbox" class="form-check-input">
                      I agree to all Terms & Conditions
                    </label> -->
                  </div>
                </div>
                <div class="mt-3">
                  <button type="submit" class="btn btn-block btn-primary btn-lg font-weight-medium auth-form-btn" href="">DAFTAR</button>
                </div>
                <div class="text-center mt-4 font-weight-light">
                  Sudah memiliki akun? <a href="{{url('login')}}" class="text-primary">Login</a>
                </div>
              </form>
            </div>
          </div>
        </div>
      </div>
      <!-- content-wrapper ends -->
    </div>
    <!-- page-body-wrapper ends -->
  </div>
  <!-- container-scroller -->
  <!-- plugins:js -->
  <script src="{{ asset('layout/skydash/vendors/js/vendor.bundle.base.js') }}"></script>
  <!-- endinject -->
  <!-- Plugin js for this page -->
  <!-- End plugin js for this page -->
  <!-- inject:js -->
  <script src="{{ asset('layout/skydash/js/off-canvas.js') }}"></script>
  <script src="{{ asset('layout/skydash/js/hoverable-collapse.js') }}"></script>
  <script src="{{ asset('layout/skydash/js/template.js') }}"></script>
  <script src="{{ asset('layout/skydash/js/settings.js') }}"></script>
  <script src="{{ asset('layout/skydash/js/todolist.js') }}"></script>
  <!-- endinject -->

    <!-- jQuery -->
<script src="{{ asset('layout/adminlte3/plugins/jquery/jquery.min.js') }}"></script>
<!-- Bootstrap 4 -->
<script src="{{ asset('layout/adminlte3/plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
<!-- jquery-validation -->
<script src="{{ asset('layout/adminlte3/plugins/jquery-validation/jquery.validate.min.js') }}"></script>
<script src="{{ asset('layout/adminlte3/plugins/jquery-validation/additional-methods.min.js') }}"></script>
<!-- AdminLTE App -->
<!-- <script src="{{ asset('layout/adminlte3/dist/js/adminlte.min.js') }}"></script> -->

<!-- Loading Overlay -->
<script src='https://cdn.jsdelivr.net/npm/gasparesganga-jquery-loading-overlay@2.1.6/dist/loadingoverlay.min.js'></script>
<!-- SweetAlert2 -->
<script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-nice-select/1.1.0/js/jquery.nice-select.min.js" integrity="sha512-NqYds8su6jivy1/WLoW8x1tZMRD7/1ZfhWG/jcRQLOzV1k1rIODCpMgoBnar5QXshKJGV7vi0LXLNXPoFsM5Zg==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-nice-select/1.1.0/js/jquery.nice-select.js" integrity="sha512-GkPcugMfi6qlxrYTRUH4EwK4aFTB35tnKLhUXGLBc3x4jcch2bcS7NHb9IxyM0HYykF6rJpGaIJh8yifTe1Ctw==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<!-- <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@sweetalert2/themes@5.0.11/minimal/minimal.css"> -->
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<!-- Global -->
<script src="{{ asset('js/global.js') }}"></script>
<script>
    $(document).ready(function(){
        $('#jenis_kelamin').select2({
            placeholder: "Jenis Kelamin"
        });

        // $('#kecamatan').select2({
        //     placeholder: "Pilih Kecamatan"
        // });

        getKabupaten('provinsi','kabupaten','kecamatan','{{ url("/getKabupaten") }}');
        getKecamatan('kabupaten','kecamatan','{{ url("/getKecamatan") }}');

        // Int
        $(".angka").on('input paste', function () {
          hanyaAngka(this);
        });
        $('._nice_select').niceSelect();
        $('#formRegister').validate({
            rules: {
            name: {
                required: true
            },
            alamat: {
                required: true
            },
            provinsi: {
                required: true
            },
            kabupaten: {
                required: true
            },
            kecamatan: {
                required: true
            },
            email: {
                required: true
            },
            no_wa: {
                required: true,
                minlength:10,
                maxlength:15
            },
            jenis_kelamin: {
                required: true
            },
            password: {
                required: true,
                minlength:4
            },
            password_: {
                equalTo : "#password"
            },
            },
            messages: {
            name: {
                required: "Nama lengkap tidak boleh kosong"
            },
            alamat: {
                required: "Alamat lengkap tidak boleh kosong"
            },
            provinsi: {
                required: "Provinsi tidak boleh kosong"
            },
            kabupaten: {
                required: "Kota/Kabupaten tidak boleh kosong"
            },
            kecamatan: {
                required: "Kecamatan tidak boleh kosong"
            },
            email: {
                required: "Email tidak boleh kosong"
            },
            no_wa: {
                required: "Nomor Whatsapp tidak boleh kosong",
                minlength: "Masukkan nomor yang benar",
                maxlength: "Masukkan nomor yang benar"
            },
            jenis_kelamin: {
                required: "Jenis kelamin tidak boleh kosong"
            },
            password: {
                required: "Password tidak boleh kosong",
                minlength: "Masukkan minimal 4 character"
            },
            password_: {
              equalTo: "Konfirmasi password harus sama"
            },
        
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
              var formData = new FormData($('#formRegister')[0]);

              var url = "{{ url('/storeregister') }}";
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
                      $.LoadingOverlay("show", {
                          image       : "{{asset('/image/global/loading.gif')}}"
                      });
                  },
                  success: function (response) {
                      if (response.status === true) {
                      Swal.fire({
                          title: response.message,
                          icon: 'success',
                          showConfirmButton: false
                          });
                              reload_url(3000,"{{url('/login')}}");
                      }else{
                      Swal.fire({
                          title: response.message,
                          icon: 'error',
                          confirmButtonText: 'Ok',
                          showCloseButton: true,
                      });
                      }
                  },
                  error: function (xhr, status) {
                      alert('Error! Please Try Again');
                  },
                  complete: function () {
                      $.LoadingOverlay("hide");
                  }
              });   
            }
        });
    });
</script>
</body>

</html>
