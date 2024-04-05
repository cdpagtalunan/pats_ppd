
@php $layout = 'layouts.admin_layout'; @endphp

@auth
  @extends($layout)

@section('title', 'Casemark')

@section('content_page')

<style type="text/css">
	#iframe_d_label_printing{
		position: absolute;
		width: 100%;
		height: 900px;
/*		width: 100%!important;
		height: 100%!important;
*/		border: none;
	}
 </style>
 <!-- Content Wrapper. Contains page content -->
 <div class="content-wrapper">
 	<!-- Content Header (Page header) -->
 	<section class="content-header">
		<div class="container-fluid">
			<div class="row mb-2">
				<div class="col-sm-6">
					<h1>Casemark</h1>
				</div>
				<div class="col-sm-6">
					<ol class="breadcrumb float-sm-right">
						<li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a>
						</li>
						<li class="breadcrumb-item active">Casemark</li>
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
 				<div class="col-12">
 					<!-- general form elements -->
 					<div>
						{{-- <iframe src="http://rapid/" style="border: none;" no-border height="850" width="100%"></iframe> --}}
                        <iframe style="border: none;" src="http://rapid/pats_ppd_casemark/" no-border height="850" width="100%"></iframe>

 					</div>
				</div>
			</div>
			<!-- /.row -->
		</div><!-- /.container-fluid -->
	</section>
	<!-- /.content -->

</div>
<!-- /.content-wrapper -->
@endsection

@section('js_content')
<script type="text/javascript">
	$(document).ready(function(){
        setTimeout(function() {
            $('body').addClass('sidebar-collapse');
        }, 200);
    });
</script>
@endsection
@endauth