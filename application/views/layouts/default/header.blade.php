    <!-- Navbar -->
    <div class="navbar navbar-googlebar navbar-inverse navbar-fixed-top">
      <div class="navbar-inner">
        <div class="container">

          <!-- .btn-navbar is used as the toggle for collapsed navbar content -->
          <a class="btn btn-navbar" data-toggle="collapse" data-target=".nav-collapse">
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </a>

          <a class="brand" href="{{ URL::to_route('home') }}">MSDS Database</a>

          <!-- Everything you want hidden at 940px or less, place within here -->
          <div class="nav-collapse collapse">
            <ul class="nav pull-right">
              @if( Auth::check() )
                <li class="navbar-text" style="line-height:37px">Logged in as {{ Auth::user()->name }}</li>
                <li class="divider-vertical"></li>
                <li><a class="btn-success" href="{{ URL::to_route('logout') }}"><i class="icon-signout"></i> Logout</a></li>
              @else
                <li><a href="{{ URL::to_route('login') }}"><i class="icon-signin"></i> Login</a></li>
              @endif
            </ul>
          </div>
          <!-- ./ nav-collapse -->
        </div>
      </div>
    </div>
    <!-- ./ navbar -->