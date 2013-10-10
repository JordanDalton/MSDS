@layout( HTML::default_layout() )

{{-- Set the page title. --}}
@section('page_title')
	View Msds PDF - @parent
@endsection

{{-- Set the content body. --}}
@section('content')
	<div id="pdfContainer">
		<a class="media" href="{{ URL::to_route('pdf.show', array($msds_record->pdf)) }}">{{ URL::to_route('pdf.show', array($msds_record->pdf)) }}</a> 
	</div>
@endsection

{{--Embed JavaScript into the page.--}}
@section('embedded_js')	
	$('a.media').media({ width : '100%', height : $(document).height() - 78 });
@endsection