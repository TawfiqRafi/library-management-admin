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
                <ul>
                    <li>
                        <form action="{{ route('logout') }}" method="POST">
                            @csrf
                            <button class="btn-light btn btn-sm" type="submit"><i class="bx bx-log-out"></i> Logout ({{ Auth::user()->name }})</button>
                        </form>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</header>
