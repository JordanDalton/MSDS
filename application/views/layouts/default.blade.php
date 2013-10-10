<!DOCTYPE html>
<html lang="en">
  <head>
    <!-- Basic Page Needs
    ================================================== -->
    <meta charset="utf-8" />
    <title>
      @section('page_title')
      MSDS Database
      @yield_section
    </title>
    <meta name="keywords" content="" />
    <meta name="author" content="" />
    <meta name="description" content="" />

    <!-- Make IE Play Nice
    ================================================== -->
    <meta http-equiv="X-UA-Compatible" content="IE=edge">

    <!-- Mobile Specific Metas
    ================================================== -->
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- CSS
    ================================================== -->
    {{ HTML::style('assets/css/bootstrap.css') }}

    <style>
      body { padding-top: 60px; }
    </style>

    {{ HTML::style('assets/css/bootstrap-responsive.css') }}
    {{ HTML::style('assets/css/font-awesome.min.css') }}
    {{ HTML::style('assets/css/todc-bootstrap.css') }}
    {{ HTML::style('assets/css/datepicker.css') }}
    {{ HTML::style('assets/css/screen.css') }}

    <style>
      @section('styles')
      @yield_section
    </style>

    <!-- HTML5 shim, for IE6-8 support of HTML5 elements -->
    <!--[if lt IE 9]>
    <script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
    <![endif]-->

    <!-- Favicons
    ================================================== -->
    <link rel="apple-touch-icon-precomposed" sizes="144x144" href="{{ URL::to('assets/ico/apple-touch-icon-144-precomposed.png') }}">
    <link rel="apple-touch-icon-precomposed" sizes="114x114" href="{{ URL::to('assets/ico/apple-touch-icon-114-precomposed.png') }}">
    <link rel="apple-touch-icon-precomposed" sizes="72x72" href="{{ URL::to('assets/ico/apple-touch-icon-72-precomposed.png') }}">
    <link rel="apple-touch-icon-precomposed" href="{{ URL::to('assets/ico/apple-touch-icon-57-precomposed.png') }}">
    <link rel="shortcut icon" href="{{ URL::to('assets/ico/favicon.png') }}">
  </head>

  <body id="{{ Request::route()->controller }}" class="{{ Request::route()->controller_action }}">

    {{--Global Header : layouts.default.header --}}
    {{ $header }}
    {{--End Global Header --}}

    <!-- Container -->
    <div class="container">
      <!-- Notifications -->
      @include('notifications')
      <!-- ./ notifications -->
    </div>
    <!-- ./ container -->

    <!-- Content -->
    @yield('content')
    <!-- ./ content -->

    <!-- Javascripts
    ================================================== -->
    {{ HTML::script('assets/js/jquery.v1.8.3.min.js') }}
    {{ HTML::script('assets/js/jquery.media.js') }}
    {{ HTML::script('assets/js/jquery.autosize-min.js') }}
    {{ HTML::script('assets/js/bootstrap-2.2.2/bootstrap.min.js') }}
    {{ HTML::script('assets/js/bootstrap-datepicker.js') }}
    {{ HTML::script('assets/js/api.js') }}

    <!-- Embedded Javascript
    ================================================== -->
    <script type="text/javascript">
      @section('embedded_js')
      @yield_section
    </script>
  </body>
</html>