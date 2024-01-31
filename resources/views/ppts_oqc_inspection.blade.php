
@php $layout = 'layouts.admin_layout'; @endphp

@auth
  @extends($layout)

@section('title', 'D Label Printing')

@section('content_page')
<!-- <link href="{{ URL::asset('public/template/plugins/jquery-ui/jquery-ui.min.css') }}" rel="stylesheet" media="all"> -->

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
 					<h1>WEB EDI Printing</h1>
 				</div>
 				<div class="col-sm-6">
 					<ol class="breadcrumb float-sm-right">
 						<li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
 						<li class="breadcrumb-item active">CN PPTS</li>
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
						<iframe id="iframe_d_label_printing" src="http://rapidx/cn_ppts/"></iframe>
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
</script>
@endsection
@endauth