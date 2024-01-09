@auth

@if(Auth::user()->is_password_changed == 1)
  <script type="text/javascript">
    window.location = "{{ url('dashboard') }}";
  </script>
@endif
<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>CNPTS | Change Password</title>
  <!-- Tell the browser to be responsive to screen width -->
  <meta name="viewport" content="width=device-width, initial-scale=1">

  @include('shared.css_links.css_links')
</head>
<body class="hold-transition login-page">
<div class="login-box">
  <div class="login-logo">
    <a href="{{ route('login') }}"><b>CNPTS</b></a>
  </div>
  <!-- /.login-logo -->
  <div class="card">
    <div class="card-body login-card-body">
      <p class="login-box-msg">Change your password to start your session.</p>

      <form action="{{ route('change_pass') }}" method="post" id="formChangePass">
        @csrf
        <div class="input-group mb-3">
          <input type="text" class="form-control" name="username" placeholder="Username" id="txtChangePassUsername" value="{{ Auth::user()->username }}" readonly="">
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-user"></span>
            </div>
          </div>
        </div>

        <div class="input-group mb-3">
          <input type="password" class="form-control" name="password" placeholder="Given Password" id="txtChangePassPass">
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-lock"></span>
            </div>
          </div>
        </div>

        <div class="input-group mb-3">
          <input type="password" class="form-control" name="new_password" placeholder="New Password" id="txtChangePassNewPass">
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-lock"></span>
            </div>
          </div>
        </div>

        <div class="input-group mb-3">
          <input type="password" class="form-control" name="confirm_password" placeholder="Confirm Password" id="txtChangePassConPass">
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-lock"></span>
            </div>
          </div>
        </div>
        <div class="row">
          <!-- <div class="col-8">
            <div class="icheck-primary">
              <input type="checkbox" id="remember">
              <label for="remember">
                Remember Me
              </label>
            </div>
          </div> -->
          <!-- /.col -->
          <div class="col-12">
            <button type="submit" class="btn btn-primary btn-block" id="btnChangePass"><i class="fa fa-check" id="iBtnChangePassIcon"></i> Change Password</button>
            <a id="btnLoginAnother" class="btn btn-default btn-block"><i class="fa fa-unlock" id="iBtnChangePassIcon"></i> Sign In</a>
          </div>
          <!-- /.col -->
        </div>
      </form>

      <!-- <div class="social-auth-links text-center mb-3">
        <p>- OR -</p>
        <a href="#" class="btn btn-block btn-primary">
          <i class="fab fa-facebook mr-2"></i> Sign in using Facebook
        </a>
        <a href="#" class="btn btn-block btn-danger">
          <i class="fab fa-google-plus mr-2"></i> Sign in using Google+
        </a>
      </div> -->
      <!-- /.social-auth-links -->

      <!-- <p class="mb-1">
        <a href="forgot-password.html">I forgot my password</a>
      </p>
      <p class="mb-0">
        <a href="register.html" class="text-center">Register a new membership</a>
      </p> -->
    </div>
    <!-- /.login-card-body -->
  </div>
</div>
<!-- /.login-box -->

<form id="formLoginAnother">
    @csrf
</form>

@include('shared.js_links.js_links')

<script type="text/javascript">
  $(document).ready(function(){
    $("#formChangePass").submit(function(event){
      event.preventDefault();
      ChangePassword();
    });

    $("#formLoginAnother").submit(function(event){
      event.preventDefault();
      LoginAnother();
    });

    $("#btnLoginAnother").click(function(){
      $("#formLoginAnother").submit();
    });
  });
</script>
</body>
</html>
@else
  <script type="text/javascript">
    window.location = "{{ url('dashboard') }}";
  </script>
@endauth
