<!DOCTYPE html>
<html lang="en">

<head>
    @include('admin.head')
</head>

<body class="hold-transition login-page">
    <div class="login-box">
        <div class="login-logo">
            <a href="#"><b>Forget Password</b></a>
        </div>
        <!-- /.login-logo -->
        <div class="card">
            <div class="card-body login-card-body">
                <p class="login-box-msg">Please enter your email address</p>
                @include('admin.alert')
                <form action="{{ route('postForgetPass') }}" method="post">
                    @csrf
                    <div class="input-group mb-3">
                        <input type="email" name="email" class="form-control" placeholder="Email">
                        <div class="input-group-append">
                            <div class="input-group-text">
                                <span class="fas fa-envelope"></span>
                            </div>
                            @if ($errors->has('name'))
                 <span class="text-danger">{!! $errors->first('name') !!}</span>
             @endif
                        </div>
                    </div>
                    <div class="col-4">
                        <button type="submit" class="btn btn-primary btn-block">Sign In</button>

                    </div>



                </form>


            </div>

        </div>
    </div>
    <!-- /.login-box -->
    @include('admin.footer')

</body>

</html>
