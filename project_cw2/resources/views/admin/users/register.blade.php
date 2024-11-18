
<!DOCTYPE html>
<html lang="en">
<head>
    @include('admin.head')
</head>
<body class="hold-transition register-page">
<div class="register-box">
  <div class="register-logo">
    <a href="../../index2.html"><b>Admin</b>Register</a>
  </div>

  <div class="card">
    <div class="card-body register-card-body">
      <p class="login-box-msg">Register a new membership</p>

      <form action="{{ route('register') }}" method="post"  enctype="multipart/form-data">
        @csrf
        {{-- Full name --}}
        <div class="input-group mb-3">
          <input type="text" name="name" class="form-control" placeholder="Full name">
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-user"></span>
            </div>
          </div>
        </div>
        <div class="">
            @if ($errors->has('name'))
                 <span class="text-danger">{!! $errors->first('name') !!}</span>
             @endif
        </div>
        {{-- Email --}}
        <div class="input-group mb-3">
          <input type="email" name="email" class="form-control" placeholder="Email">

          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-envelope"></span>
            </div>
          </div>

        </div>
        <div class="div">
            @if ($errors->has('email'))
            <span class="text-danger">{!! $errors->first('email') !!}</span>
              @endif
         </div>
         {{-- Password --}}
        <div class="input-group mb-3">
          <input type="password" name="password" class="form-control" placeholder="Password">

          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-lock"></span>
            </div>
          </div>
        </div>
        <div class="">
            @if ($errors->has('password'))
            <span class="text-danger">{!! $errors->first('password') !!}</span>
            @endif
        </div>
        {{-- Nhap lai passwprd --}}
        <div class="input-group mb-3">
          <input type="password" name="password1" class="form-control" placeholder="Retype password">
          @if ($errors->has('password1'))
          <span class="text-danger">{!! $errors->first('password1') !!}</span>
         @endif
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-lock"></span>
            </div>
          </div>
        </div>

        {{-- So dien thoai --}}
        <div class="input-group mb-3">
            <input type="text" name="phone" class="form-control" placeholder="Phone">
            @if ($errors->has('phone'))
            <span class="text-danger">{!! $errors->first('phone') !!}</span>
             @endif
            <div class="input-group-append">
              <div class="input-group-text">
                <span class="fas fa-phone"></span>
              </div>
            </div>
          </div>

                    <!-- Hinh anh -->
                    <div class="row mb-3">
                        <label for="avatar"  style=" padding-left: 50px;"class="col-md-4 col-form-label text-md-end">{{ __('Avatar') }}</label>

                        <div class="col-md-6">
                            <input id="avatar" type="file" class="form-control @error('avatar') is-invalid @enderror" name="avatar" value="{{ old('avatar') }}" required autocomplete="avatar">

                            @error('avatar')
                            <span class="invalid-feedback" role="alert">
                                <strong>{!! $message !!}</strong>
                            </span>
                            @enderror
                        </div>


                    </div>


        <div class="row">
          <div class="col-8">
            <a href="{{ route('login') }}" class="text-center">I already accout </a>
          </div>
          <!-- /.col -->
          <div class="col-4">
            <button type="submit" class="btn btn-primary btn-block">Register</button>
          </div>
          <!-- /.col -->
        </div>
      </form>




    </div>
    <!-- /.form-box -->
  </div><!-- /.card -->
</div>
<!-- /.register-box -->

@include('admin.footer')
</body>
</html>
