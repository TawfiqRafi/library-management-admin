<nav class="main-navigation">
    <ul class="navigation" data-widget="tree">
        <li>
            <a href="{{ route('dashboard') }}" class="dashboard">
                <i class="bx bxs-dashboard text-blue-400"></i>
                <span>Dashboard</span>
            </a>
        </li>
        <li>
            <a href="{{ route('users.index') }}" class="dashboard">
                <i class="bx bxs-user text-blue-400"></i>
                <span>Users List</span>
            </a>
        </li>
        <li class="treeview">
            <a href="javascript:void(0)">
                <i class='bx bxs-videos text-green-400'></i>
                <span>Books</span>
            </a>
            <ul class="treeview-menu">
                <li>
                    <a href="{{ route('book.list') }}">
                        <i class="bx bx-check-circle"></i>
                        <span>All Books</span>
                    </a>
                </li>
                <li>
                    <a href="{{ route('book.available') }}">
                        <i class="bx bx-check-circle"></i>
                        <span>Available Books</span>
                    </a>
                </li>
                <li>
                    <a href="{{ route('book.create') }}">
                        <i class="bx bx-check-circle"></i>
                        <span>Add Book</span>
                    </a>
                </li>
            </ul>
        </li>
        <li class="treeview">
            <a href="javascript:void(0)">
                <i class='bx bxs-report text-green-400'></i>
                <span>Reports</span>
            </a>
            <ul class="treeview-menu">
                <li>
                    <a href="{{ route('report.current') }}">
                        <i class="bx bx-check-circle"></i>
                        <span>Current borrowed history</span>
                    </a>
                </li>
                <li>
                    <a href="{{ route('report.history') }}">
                        <i class="bx bx-check-circle"></i>
                        <span>All time history</span>
                    </a>
                </li>
            </ul>
        </li>
    </ul>
</nav>
