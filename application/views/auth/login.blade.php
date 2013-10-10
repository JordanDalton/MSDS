@layout( HTML::default_layout() )

{{-- Set the page title. --}}
@section('page_title')
	Log in - @parent
@endsection

@section('content')
	<div class="container">
		<div class="row-fluid">
			<div class="span6 offset3">
				{{ $form }}
			</div>
		</div>
	</div>
@endsection

{{--Embed JavaScript into the page.--}}
@section('embedded_js')

	// :: AutoComplete Disablement
	$( 'input' ).filter( ':text' ).attr( 'autocomplete', 'off' );

@endsection