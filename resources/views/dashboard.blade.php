@php $layout = 'layouts.admin_layout'; @endphp
    {{-- @auth
@php
    if(Auth::user()->user_level_id == 1){
      $layout = 'layouts.super_user_layout';
    }
    else if(Auth::user()->user_level_id == 2){
      $layout = 'layouts.admin_layout';
    }
    else if(Auth::user()->user_level_id == 3){
      $layout = 'layouts.user_layout';
    }
@endphp
@endauth--}}

@auth
@extends($layout)

@section('title', 'Dashboard')

@section('content_page')
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
      <!-- Content Header (Page header) -->
      <section class="content-header">
          <div class="container-fluid">
              <div class="row mb-2">
                  <div class="col-sm-6">
                      <h1>Dashboard</h1>
                  </div>
                  <div class="col-sm-6">
                      <ol class="breadcrumb float-sm-right">
                          <li class="breadcrumb-item active">Dashboard</li>
                      </ol>
                  </div>
              </div>
          </div><!-- /.container-fluid -->
      </section>

      <!-- Main content -->
      <section class="content">
          <div class="container-fluid">
              <div class="row">
                  <!-- left column -->
                  <div class="col-md-12">
                      <!-- general form elements -->
                      <div class="card card-primary">

                          <!-- Start Page Content -->
                          <div class="card-body">
                              <div class="row">

                                  <div class="col-12">
                                      <h1> Welcome to Product Automated Traceabilty System (PATS) <br> for PPD-CN171 </h1>
                                  </div>
                                  <div class="col-12">
                                      <h5><br> For concerns/issues, please contact ISS at local numbers 205, 206, or 208.
                                      </h5>
                                  </div>
                                  <div class="col-12">
                                      <h5> Or you may send us e-mail at servicerequest@pricon.ph. Thank you! </h5>
                                  </div>



                              </div>
                              <!-- /.row -->

                          </div>
                          <!-- !-- End Page Content -->
                      </div>
                      <!-- /.card -->
                  </div>
                  <!-- /.row -->
              </div><!-- /.container-fluid -->
          </div><!-- /.container-fluid -->
      </section>
      <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->
@endsection

@section('js_content')
@endsection
@endauth
