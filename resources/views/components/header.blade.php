<!-- header -->
<header>
    <div class="header">
        <div class="header-left">
            <div class="logo">
                <a href="{{ route('dashboard') }}">
                    <h2>6amTech Library</h2>
                </a>
            </div>
            <span id="nav-control"><i class="bx bx-arrow-from-right"></i></span>
        </div>
        <div class="header-right">
            <div class="header-nav">
                {{-- Dashboard --}}
            </div>
            <div class="header-user">
                <div class="dropdown">
                    <button class="btn btn-sm btn-light dropdown-toggle" type="button" id="dropdownMenuButton" data-bs-toggle="dropdown" aria-expanded="false">
                        <i class="bx bx-user"></i> {{ Auth::user()->name }}
                    </button>
                    <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton">
{{--                        <li>--}}
{{--                            <a class="dropdown-item" href="{{ route('profile') }}">--}}
{{--                                <i class="bx bx-user-circle"></i> Profile--}}
{{--                            </a>--}}
{{--                        </li>--}}
{{--                        <li>--}}
{{--                            <a class="dropdown-item" href="{{ route('settings') }}">--}}
{{--                                <i class="bx bx-cog"></i> Settings--}}
{{--                            </a>--}}
{{--                        </li>--}}
                        <li>
                            <form action="{{ route('logout') }}" method="POST">
                                @csrf
                                <button type="submit" class="dropdown-item text-danger">
                                    <i class="bx bx-log-out"></i> Logout
                                </button>
                            </form>
                        </li>
                    </ul>
                </div>
            </div>
        </div>

    </div>
</header>
