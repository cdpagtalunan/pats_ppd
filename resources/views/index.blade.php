@if(isset(Auth::user()->id) && Auth::user()->status == 1)
  <script type="text/javascript">
    window.location = "{{ url('dashboard') }}";
  </script>
@elseif((isset(Auth::user()->id) && Auth::user()->status == 2) || !isset(Auth::user()->id))
<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>PATS - CN | Sign In</title>
  <!-- Tell the browser to be responsive to screen width -->
  <meta name="viewport" content="width=device-width, initial-scale=1">

  @include('shared.css_links.css_links')
</head>
<body class="hold-transition login-page" style="background: url('{{ asset('public/images/pats_bg.gif') }}'); background-repeat: no-repeat; background-size: cover; ">
<div class="login-box">
  <!-- /.login-logo -->
  <div class="card" style="box-shadow: 1px 1px 50px black;">
    <br>
    <div class="login-logo">
      <a href="{{ route('login') }}"><h2>Product Automated Traceability System - CN171</h2></a>
    </div>
    <div class="card-body login-card-body">
      <p class="login-box-msg">Sign in to start your session</p>

      <form action="{{ route('sign_in') }}" method="post" id="formSignIn">
        @csrf
        <div class="input-group mb-3">
          <input type="text" class="form-control" name="username" placeholder="Username" id="txtSignInUsername">
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-user"></span>
            </div>
          </div>
        </div>
        <div class="input-group mb-3">
          <input type="password" class="form-control" name="password" placeholder="Password" id="txtSignInPass">
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-lock"></span>
            </div>
          </div>
        </div>
        <div class="row">
          <!-- /.col -->
          <div class="col-12">
            <button type="submit" class="btn btn-primary btn-block" id="btnSignIn"><i class="fa fa-check" id="iBtnSignInIcon"></i> Sign In</button>
          </div>
          <!-- /.col -->
        </div>
      </form>
    </div>
    <!-- /.login-card-body -->
  </div>
</div>
<!-- /.login-box -->

@include('shared.js_links.js_links')

<script type="text/javascript">
  $(document).ready(function(){
    $("#formSignIn").submit(function(event){
      event.preventDefault();
      SignIn();
    });
  });
</script>
</body>
</html>
@endif
