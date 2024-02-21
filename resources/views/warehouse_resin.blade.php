@php $layout = 'layouts.admin_layout'; @endphp

@auth
  @extends($layout)

@section('title', 'Warehouse')

@section('content_page')
<!-- <link href="{{ URL::asset('public/template/plugins/jquery-ui/jquery-ui.min.css') }}" rel="stylesheet" media="all"> -->

<style type="text/css">
	#iframe_ppsmis{
		position: absolute;
		width: 100%;
		height: 900px;
		border: none;
	}
 </style>
 <div class="content-wrapper">
 	<section class="content-header">
 		<div class="container-fluid">
 			<div class="row mb-2">
 				<div class="col-sm-6">
 					<h1>PPSMIS - Warehouse Module</h1>
 				</div>
 				<div class="col-sm-6">
 					<ol class="breadcrumb float-sm-right">
 						<li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
 						<li class="breadcrumb-item active">PPSMIS</li>
 					</ol>
 				</div>
 			</div>
 		</div>
 	</section>

 	<section class="content">
 		<div class="container-fluid">
 			<div class="row">
 				<div class="col-12">
                    <iframe id="iframe_ppsmis" src="http://rapid/PPSMIS/Resin" no-border></iframe>
				</div>
			</div>
		</div>
	</section>

</div>
@endsection

@section('js_content')
<script type="text/javascript">

</script>
@endsection
@endauth