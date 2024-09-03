
@php $layout = 'layouts.admin_layout'; @endphp

@auth
  @extends($layout)

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

 	<!-- Main content -->
 	<section class="content">
 		<div class="container-fluid">
 			<div class="row">
 				<!-- left column -->
 				<div class="col-12">
 					<!-- general form elements -->
 					<div>
						<iframe  src="http://rapidx/mprs/machine_parameter?username={{ Auth::user()->username }}
							&emp_id={{ Auth::user()->employee_id }}
							&iframe=oqc
							&system_table=assembly_oqc_lot_apps
							&system_db=db_pats_ppd" style="border: none;" no-border height="850" width="100%">></iframe>
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
