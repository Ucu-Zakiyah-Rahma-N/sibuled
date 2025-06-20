<!doctype html>
<html lang="en">

@include('app.head')

<body>
@if(session('success'))
    <script>
        Swal.fire({
            icon: 'success',
            title: 'berhasil keluar',
            text: '{{ session('success') }}',
            showConfirmButton: false,
            timer: 2000
        });
    </script>
@endif
  <!--  Body Wrapper -->
  <div class="page-wrapper" id="main-wrapper" data-layout="vertical" data-navbarbg="skin6" data-sidebartype="full"
    data-sidebar-position="fixed" data-header-position="fixed">
    <div class="position-relative overflow-hidden radial-gradient min-vh-100 d-flex align-items-center justify-content-center">
      <div class="d-flex align-items-center justify-content-center w-100">
        <div class="row justify-content-center w-100">
          <div class="col-md-6 col-lg-4">
            <div class="card mb-0">
              <div class="card-body">
                <a href="{{ url('/') }}" class="text-nowrap logo-img text-center d-block py-3 w-100">
                  <img src="{{ asset('assets/images/karawang.svg') }}" width="350" alt="">
                </a>
                <form action="{{ url('auth') }}" method="POST">
                @csrf
                  <div class="mb-3">
                    <label for="username" class="form-label">Username</label>
                    <input type="text" class="form-control @error('username') is-invalid @enderror" id="username" name="username" value="{{ old('username') }}">
                    @error('username')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                  </div>
                  <div class="mb-4">
                    <label for="password" class="form-label">Password</label>
                    <input type="password" class="form-control @error('password') is-invalid @enderror" id="password" name="password">
                    @error('password')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                  </div>
                  <div class="d-flex align-items-center justify-content-between mb-4">
                    <div class="form-check">
                      <input class="form-check-input primary" type="checkbox" id="showPassword">
                      <label class="form-check-label text-dark" for="showPassword">
                        Lihat Password
                      </label>
                    </div>
                  </div>
                <button class="btn btn-primary w-100 fs-4 mb-4 rounded-2" id="loginButton">
                    <span class="button-text">Masuk</span>
                    <span class="button-text-masuk d-none">sedang masuk </span>
                    <span class="spinner-border spinner-border-sm d-none" role="status" aria-hidden="true"></span>
                </button>
                </form>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  @include('app.script')
    <script>
    $(document).ready(function() {
        
        $('form').on('submit', function() {
            const button = $(this).find('#loginButton');
            
            button.prop('disabled', true);
            
            button.find('.button-text').addClass('d-none');
            button.find('.button-text-masuk').removeClass('d-none');
            button.find('.spinner-border').removeClass('d-none');
            
        });
        
        $('#showPassword').on('click', function() {
            const passwordInput = $('#password');
            const currentType = passwordInput.attr('type');
            
            if (currentType === 'password') {
                passwordInput.attr('type', 'text');
            } else {
                passwordInput.attr('type', 'password');
            }
        });

    });
    </script>
</body>

</html>