@extends('layouts.admin-base')

@section('base.content')
    @include('components.header')

    <main>
        @include('components.navigation')

        <div class="main-content">
            <div class="content">
                @yield('content')
            </div>
        </div>
    </main>

    @include('components.footer')

@endsection
