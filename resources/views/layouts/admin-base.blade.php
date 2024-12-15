<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('page_title', $page_title?$page_title:'Dashboard')</title>
    <!-- favicon -->
    <link rel="icon" type="image/png" href="{{ asset('assets/images/favicon.jpg') }}" />
    <!-- vendor stylesheet -->
    <link rel="stylesheet" href="{{ asset('admin-assets/vendors/sweetalert/sweetalert2.min.css') }}">
    <link rel="stylesheet" href="{{ asset('admin-assets/vendors/summernote/summernote.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/vendors/bootstrap/css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/vendors/fontawesome/css/all.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/vendors/boxicons/css/boxicons.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/animate.min.css') }}">
    <!-- main styles-->
    <link rel="stylesheet" href="{{ asset('assets/css/default.css') }}">
    <!-- tailwindcss -->
    <link rel="stylesheet" href="{{ asset('css/styles.css') }}">
    <!-- main style -->
    <link rel="stylesheet" href="{{ asset('admin-assets/css/style.css') }}">
</head>

<body>

{{--base content--}}
@yield('base.content')

<!-- scripts -->
<script src="{{ asset('assets/vendors/jquery/jquery.min.js') }}"></script>
<script src="{{ asset('assets/vendors/bootstrap/js/popper.min.js') }}"></script>
<script src="{{ asset('assets/vendors/bootstrap/js/bootstrap.min.js') }}"></script>
<script src="{{ asset('assets/vendors/fontawesome/js/all.min.js') }}"></script>
<script src="{{ asset('admin-assets/vendors/sweetalert/sweetalert2.min.js') }}"></script>
<script src="{{ asset('admin-assets/vendors/summernote/summernote.min.js') }}"></script>
<script src="{{ asset('assets/js/submitter.js') }}"></script>
<script src="{{ asset('admin-assets/js/navigation.js') }}"></script>
<script src="{{ asset('admin-assets/js/main.js') }}"></script>
@stack('footer-scripts')
</body>
</html>
