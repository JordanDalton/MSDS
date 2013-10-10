<form action="{{ URL::to_route('login') }}" class="form-horizontal well" method="post">
    <fieldset>
        <legend><i class="icon-signin"></i> Log in</legend>
        <p>You must be logged in to continue.</p>

        {{--User entered invalid login credentials.--}}
        @if( Session::has('login_errors') )
            <div id="login-error" class="alert alert-error">
                <strong>Oops!</strong> The username or password was incorrect.
            </div>
        @endif

        <!-- CSRF Token -->
        <input type="hidden" name="csrf_token" id="csrf_token" value="{{ Session::token() }}" />

        <!-- Username -->
        <div class="control-group {{ $errors->has('username') ? 'error' : '' }}">
            <label class="control-label" for="username">Username</label>
            <div class="controls">
                <input type="text" name="username" id="username" value="{{ Input::old('username') }}" />
                {{ $errors->has('username') ? Form::block_help( $errors->first('username') ) : '' }}
            </div>
        </div>
        <!-- ./ Username -->

        <!-- Password -->
        <div class="control-group {{ $errors->has('password') ? 'error' : '' }}">
            <label class="control-label" for="password">Password</label>
            <div class="controls">
                <input type="password" name="password" id="password" value="" />
                {{ $errors->has('password') ? Form::block_help( $errors->first('password') ) : '' }}
            </div>
        </div>
        <!-- ./ password -->

        <!-- Login button -->
        <div class="control-group">
            <div class="controls">
                <button type="submit" class="btn btn-large btn-primary"><i class="icon-signin"></i> Login</button>
            </div>
        </div>
        <!-- ./ login button -->
    </fieldset>
</form>

@section('embedded_js')
$('#username').focus();
@endsection