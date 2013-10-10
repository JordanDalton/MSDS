<form action="{{ URL::to_route('msds.create') }}" class="form-horizontal well" enctype="multipart/form-data" method="post">
    <fieldset>
        <legend><i class="icon-edit"></i> Create MSDS Record</legend>
        <p><i class="icon-asterisk"></i> All fields are required.</p>
        <!-- CSRF Token -->
        <input type="hidden" name="csrf_token" id="csrf_token" value="{{ Session::token() }}" />

        <!-- Name -->
        <div class="control-group {{ $errors->has('name') ? 'error' : '' }}">
            <label class="control-label" for="name">Chemical / Product Name</label>
            <div class="controls">
                <input type="text" name="name" id="name" value="{{ Input::old('name') }}" />
                {{ $errors->has('name') ? Form::block_help( $errors->first('name') ) : '' }}
            </div>
        </div>
        <!-- ./ Name -->

        <!-- Synonym -->
        <div class="control-group {{ $errors->has('synonym') ? 'error' : '' }}">
            <label class="control-label" for="synonym">Synonym</label>
            <div class="controls">
                <input type="text" name="synonym" id="synonym" value="{{ Input::old('synonym') }}" />
                {{ $errors->has('synonym') ? Form::block_help( $errors->first('synonym') ) : '' }}
            </div>
        </div>
        <!-- ./ Synonym -->

        <!-- Manufacturer -->
        <div class="control-group {{ $errors->has('manufacturer') ? 'error' : '' }}">
            <label class="control-label" for="manufacturer">Manufacturer</label>
            <div class="controls">
                <input type="text" name="manufacturer" id="manufacturer" value="{{ Input::old('manufacturer') }}" />
                {{ $errors->has('manufacturer') ? Form::block_help( $errors->first('manufacturer') ) : '' }}
            </div>
        </div>
        <!-- ./ Manufacturer -->
    </fieldset>
    <fieldset>
        <legend><i class="icon-file"></i> PDF</legend>
        <!-- PDF File -->
        <div class="control-group {{ $errors->has('pdf') ? 'error' : '' }}">
            <label class="control-label" for="pdf">Upload New PDF</label>
            <div class="controls">
                {{ Form::file('pdf') }}
                {{ $errors->has('pdf') ? Form::block_help( $errors->first('pdf') ) : '' }}
            </div>
        </div>
        <!-- ./ PDF File -->

        <!-- PDF Date Manual (Manually Modified Date) -->
        <div class="control-group {{ $errors->has('pdf_date_manual') ? 'error' : '' }}">
            <label class="control-label" for="pdf_date_manual">PDF Date</label>
            <div class="controls">
                <input type="text" name="pdf_date_manual" id="pdf_date_manual" value="{{ Input::old('pdf_date_manual', '') }}" />
                {{ $errors->has('pdf_date_manual') ? Form::block_help( $errors->first('pdf_date_manual') ) : '' }}
            </div>
        </div>
        <!-- ./ PDF Date Manual (Manually Modified Date) -->
    </fieldset>
    <fieldset>
        <legend><i class="icon-h-sign"></i> HMIS Ratings</legend>

        <!-- HMIS Research -->
        <div class="control-group {{ $errors->has('hmis_research_pending') ? 'error' : '' }}">
            <label class="control-label" for="hmis_research_pending">Research <i class="icon-question-sign" id="HMIS-Research-Pending" data-content="When this field is checked the HMIS values will not be displayed in the table." data-toggle="popover" data-original-title="A Title" style="color:#1473c5" title="Research Pending"></i></label>
            <div class="controls">
                {{ Form::checkbox('hmis_research_pending', 1, Input::old('hmis_research_pending', 0)) }}
                {{ $errors->has('hmis_research_pending') ? Form::block_help( $errors->first('hmis_research_pending') ) : '' }}
            </div>
        </div>
        <!-- ./ HMIS Research -->

        <!-- HMIS Health -->
        <div class="control-group {{ $errors->has('hmis_health') ? 'error' : '' }}">
            <label class="control-label" for="hmis_health">Health</label>
            <div class="controls">
                {{ Form::select('hmis_health', array(0,1,2,3,4), Input::old('hmis_health', '0')); }}
                {{ $errors->has('hmis_health') ? Form::block_help( $errors->first('hmis_health') ) : '' }}
            </div>
        </div>
        <!-- ./ HMIS Health -->

        <!-- HMIS Flammability -->
        <div class="control-group {{ $errors->has('hmis_flammability') ? 'error' : '' }}">
            <label class="control-label" for="hmis_flammability">Flammability</label>
            <div class="controls">
                {{ Form::select('hmis_flammability', array(0,1,2,3,4), Input::old('hmis_flammability', '0')); }}
                {{ $errors->has('hmis_flammability') ? Form::block_help( $errors->first('hmis_flammability') ) : '' }}
            </div>
        </div>
        <!-- ./ HMIS Flammability -->

        <!-- HMIS Physical Hazard -->
        <div class="control-group {{ $errors->has('hmis_physical_hazard') ? 'error' : '' }}">
            <label class="control-label" for="hmis_physical_hazard">Physical Hazard</label>
            <div class="controls">
                {{ Form::select('hmis_physical_hazard', array(0,1,2,3,4), Input::old('hmis_physical_hazard', '0')); }}
                {{ $errors->has('hmis_physical_hazard') ? Form::block_help( $errors->first('hmis_physical_hazard') ) : '' }}
            </div>
        </div>
        <!-- ./ HMIS Physical Hazard -->

        <!-- HMIS Personal Protection -->
        <div class="control-group {{ $errors->has('hmis_personal_protection') ? 'error' : '' }}">
            <label class="control-label" for="hmis_personal_protection">Personal Protection</label>
            <div class="controls">
                {{ Form::select('hmis_personal_protection', array(0,1,2,3,4), Input::old('hmis_personal_protection', '0')); }}
                {{ $errors->has('hmis_personal_protection') ? Form::block_help( $errors->first('hmis_personal_protection') ) : '' }}
            </div>
        </div>
        <!-- ./ HMIS Personal Protection -->
    </fieldset>
    <fieldset>
        <legend><i class="icon-eye-open"></i> Active Status</legend>
        <!-- Active Status -->
        <div class="control-group {{ $errors->has('active') ? 'error' : '' }}">
            <label class="control-label" for="active">Active (is visible)</label>
            <div class="controls">
                {{ Form::select('active', array(0 => 'No', 1 => 'Yes'), Input::old('active', '0')); }}
                {{ $errors->has('active') ? Form::block_help( $errors->first('active') ) : '' }}
            </div>
        </div>
        <!-- ./ Active Status -->
        <hr/>
        <!-- Login button -->
        <div class="control-group">
            <div class="controls">
                <button type="submit" class="btn btn-large btn-primary"><i class="icon-signin"></i> Create Record</button>
            </div>
        </div>
        <!-- ./ login button -->
    </fieldset>
</form>

@section('embedded_js')
$('#pdf_date_manual').datepicker({
    'format' : 'yyyy-mm-dd'
});
@endsection