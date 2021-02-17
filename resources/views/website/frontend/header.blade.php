<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <!-- Meta, title, CSS, favicons, etc. -->
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="icon" href="images/favicon.ico" type="image/ico" />

    <title>{{ trans('message.home') }}</title>

    <!-- Bootstrap -->
    {{--
    <link href="{{ asset('adminbackend/vendors/bootstrap/dist/css/bootstrap.min.css') }}" rel="stylesheet">
    --}}
    <!-- Font Awesome -->
    <link href="{{ asset('adminbackend/vendors/font-awesome/css/font-awesome.min.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('bower_components/components-font-awesome/css/all.css') }}">
    <!-- NProgress -->
    <link href="{{ asset('adminbackend/vendors/nprogress/nprogress.css') }}" rel="stylesheet">
    <!-- iCheck -->
    <link href="{{ asset('adminbackend/vendors/iCheck/skins/flat/green.css') }}" rel="stylesheet">

    <!-- bootstrap-progressbar -->
    <link href="{{ asset('adminbackend/vendors/bootstrap-progressbar/css/bootstrap-progressbar-3.3.4.min.css') }}"
        rel="stylesheet">
    <!-- JQVMap -->
    <link href="{{ asset('adminbackend/vendors/jqvmap/dist/jqvmap.min.css') }}" rel="stylesheet" />
    <!-- bootstrap-daterangepicker -->
    <link href="{{ asset('adminbackend/vendors/bootstrap-daterangepicker/daterangepicker.css') }}" rel="stylesheet">

    <!-- Custom Theme Style -->
    <link rel="shortcut icon" type="image/x-icon" href="{{ asset('assets/imgs/favicon.svg') }}">
    <!-- UltraNews CSS  -->
    <link rel="stylesheet" href="{{ asset('assets/css/style.css') }}">
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/widgets.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/color.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/responsive.css') }}">
    <link rel="stylesheet" href="{{ asset('bower_components/components-font-awesome/css/all.css') }}">
    <script src="{{ asset('bower_components/components-font-awesome/jquery/dist/jquery.min.js') }}"></script>
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <script src="{{ asset('bower_components/ckeditor/ckeditor.js') }}"></script>
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <script src="js/app.js"></script>
    <script defer src="{{ asset('js/pusher.js') }}"></script>
    @toastr_css
<main class="py-4">
    @yield('content')
</main>
