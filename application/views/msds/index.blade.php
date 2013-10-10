@layout( HTML::default_layout() )

{{-- Set the page title. --}}
@section('page_title')
	MSDS List - @parent
@endsection

{{-- Set the content body. --}}
@section('content')
	<div class="container">
		<div class="row-fluid">
				{{--Search Form--}}
				{{ $form }}
		</div>
		<div class="row-fluid">
				{{--Allow user to create a new MSDS record if they are a logged in administrator.--}}
				@if( My_Auth::checkIsAdmin() )
					<a href="{{ URL::to_route('msds.create') }}" class="btn btn-primary"><i class="icon-plus"></i> Add MSDS Record</a>
					<a href="{{ URL::to_route('msds.active') }}" class="btn btn-info"><i class="icon-download"></i> Master Chemical List - Active</a>
					<a href="{{ URL::to_route('msds.inactive') }}" class="btn btn-info"><i class="icon-download"></i> Master Chemical List - Inactive</a>
				@endif
		</div>
		<div class="row-fluid" style="margin-top:10px">
			<table class="table table-bordered table-striped" style="border-top:0">
				<thead>
					<tr style="">
						{{--Only make these visible if the user is a logged in administrator.--}}
						@if( My_Auth::checkIsAdmin() )
							<th colspan="6" style="border:0"></th>
						@else
							<th colspan="4" style="border:0"></th>
						@endif
						<th class="btn-inverse" colspan="4" style="border:0;border-radius:4px 4px 0 0;-moz-border-radius:4px 4px 0 0;-webkit-border-radius:4px 4px 0 0;text-align:center">HMIS Ratings</th>
					</tr>
					<tr class="btn-info">
						{{--Only make these visible if the user is a logged in administrator.--}}
						@if( My_Auth::checkIsAdmin() )
							<th style="text-align:center">Edit</th>
							<th style="text-align:center">Active</th>
						@endif
						<th style="text-align:center">PDF</th>
						<th>Chemical / Product Name</th>
						<th>Synonym</th>
						<th>Manufacturer</th>
						<th style="background:#2e3192;color:#fff;text-align:center" title="Health">H</th>
						<th style="background:#ed1c24;color:#fff;text-align:center" title="Flammability">F</th>
						<th style="background:#f7931d;color:#fff;text-align:center" title="Physical Hazard">PH</th>
						<th style="background:#eee;color:#000;text-align:center" title="Personal Protection">PP</th>
					</tr>
				</thead>
				<tbody style="background:#fff">
					{{--Records exists : Show records only if they exist.--}}
					@if( isSet( $msds_records->results ) && count( $msds_records->results ) )
						{{--Loop through the results set.--}}
						@foreach( $msds_records->results as $msds_record )
							<tr>
								{{--Only make these visible if the user is a logged in administrator.--}}
								@if( My_Auth::checkIsAdmin() )
									<td style="text-align:center"><a class="btn" href="{{ URL::to_route('msds.edit', array($msds_record->id)) }}"><i class="icon-edit"></i></a></td>
									<td style="text-align:center" title="{{ $msds_record->active ? 'Active' : 'Inactive' }}"><i class="icon-{{ $msds_record->active ? 'ok' : 'remove' }}"></i></td>
								@endif
								{{--Do not show pdf icon link if no pdf is found.--}}
								@if( ! My_File::pdfExists( $msds_record->pdf ) )
									<td style="background:#cc0000;color:#fff;text-align:center;" title="No pdf on file for this record.">N/A</td>
								@elseif( My_File::isOutdated( $msds_record->date_pdf_manual ) )
									<td style="text-align:center;" title="The pdf is outdated. Please upload new one.">Outdated</td>
								@else
									<td style="text-align:center;"><a class="btn" href="{{ URL::to_route('msds.show', array($msds_record->id)) }}" target="_blank"><i class="icon-file-alt"></i></a></td>
								@endif
								<td>{{ $msds_record->name }}</td>
								<td>{{ $msds_record->synonym }}</td>
								<td>{{ $msds_record->manufacturer }}</td>
								<td style="background:#2e3192;color:#fff;text-align:center">{{ $msds_record->hmis_research_pending ? '' : $msds_record->hmis_health }}</td>
								<td style="background:#ed1c24;color:#fff;text-align:center">{{ $msds_record->hmis_research_pending ? '' : $msds_record->hmis_flammability }}</td>
								<td style="background:#f7931d;color:#fff;text-align:center">{{ $msds_record->hmis_research_pending ? '' : $msds_record->hmis_physical_hazard }}</td>
								<td style="background:#eee;color:#000;text-align:center">{{ $msds_record->hmis_research_pending ? '' : $msds_record->hmis_personal_protection }}</td>
							</tr>
						@endforeach
					{{--No records to display : Show use message stating no records could be found to display.--}}
					@else 
						<tr>
							{{--Adjust how many colums will be spaned (determined by the login and administrator status of the user)--}}
							<td colspan="{{ ( My_Auth::checkIsAdmin() ) ? 10 : 8 }}">There are currently records to display.</td>
						</tr>
					@endif
				</tbody>
			</table>
			{{--Pagination Links (Will only show if 2 or more pages of data is to be displayed.)--}}
			{{ $msds_records->links() }}
		</div>
	</div>
@endsection