@layout( HTML::default_layout() )

{{-- Set the page title. --}}
@section('page_title')
	Create MSDS Record - @parent
@endsection

{{-- Set the content body. --}}
@section('content')
	<div class="container">
		<div class="row-fluid">
			<div class="span6 offset3">
			    <ul class="breadcrumb">
				    <li><a href="{{ URL::to_route('home') }}">MSDS</a> <span class="divider">/</span></li>
				    <li class="active">Create MSDS Record</li>
			    </ul>
			</div>
		</div>
		<div class="row-fluid">
			<div class="span6 offset3">
				{{ $form }}
			</div>
		</div>
	</div>
@endsection