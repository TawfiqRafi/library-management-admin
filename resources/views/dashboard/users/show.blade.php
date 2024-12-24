@extends('layouts.dashboard')

@section('content')
    <div class="mt-4">
        <div class="card shadow">
            <div class="card-header">
                <h3 class="mb-0">User Details</h3>
            </div>
            <div class="card-body">
                <div class="row mb-4">
                    <div class="col-md-4">
                        <h5><strong>Name:</strong> {{ $user->name }}</h5>
                        <h5><strong>Email:</strong> {{ $user->email }}</h5>
                    </div>
                </div>

                <div class="row">
                    <!-- Currently Borrowed Books -->
                    <div class="col-md-6 mb-4">
                        <div class="card">
                            <div class="card-header d-flex justify-content-between align-items-center">
                                <h5 class="mb-0">Currently Borrowed Books</h5>
                                <form method="GET" action="{{ route('users.show', $user->id) }}" class="form-inline">
                                    <input type="hidden" name="table" value="current">
                                    <div class="input-group">
                                        <input type="text" name="search_current" class="form-control form-control-sm" placeholder="Search current books" value="{{ request('search_current') }}">
                                        <div class="input-group-append">
                                            <button type="submit" class="btn btn-primary btn-sm">
                                                <i class="fas fa-search"></i>
                                            </button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                            <div class="card-body">
                                @if ($currentBorrowedBooks->isNotEmpty())
                                    <div class="table-responsive">
                                        <table class="table table-bordered table-hover">
                                            <thead class="thead-light">
                                            <tr>
                                                <th>#</th>
                                                <th>Title</th>
                                                <th>Author</th>
                                                <th>BarCode</th>
                                                <th>Borrowed At</th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            @foreach ($currentBorrowedBooks as $key => $borrow)
                                                <tr>
                                                    <td>{{ $key + 1 + ($currentBorrowedBooks->currentPage() - 1) * $currentBorrowedBooks->perPage() }}</td>
                                                    <td>{{ $borrow->book->title }}</td>
                                                    <td>{{ $borrow->book->author }}</td>
                                                    <td>{{ $borrow->book->barcode }}</td>
                                                    <td>{{ $borrow->borrowed_at }}</td>
                                                </tr>
                                            @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                    <div class="d-flex justify-content-center mt-3">
                                        {{ $currentBorrowedBooks->appends(['search_current' => request('search_current'), 'table' => 'current'])->links() }}
                                    </div>
                                @else
                                    <div class="alert alert-warning text-center">
                                        No books currently borrowed.
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>

                    <!-- All-Time Borrow History -->
                    <div class="col-md-6">
                        <div class="card">
                            <div class="card-header d-flex justify-content-between align-items-center">
                                <h5 class="mb-0">All-Time Borrow History</h5>
                                <form method="GET" action="{{ route('users.show', $user->id) }}" class="form-inline">
                                    <input type="hidden" name="table" value="history">
                                    <div class="input-group">
                                        <input type="text" name="search_history" class="form-control form-control-sm" placeholder="Search borrow history" value="{{ request('search_history') }}">
                                        <div class="input-group-append">
                                            <button type="submit" class="btn btn-primary btn-sm">
                                                <i class="fas fa-search"></i>
                                            </button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                            <div class="card-body">
                                @if ($allTimeBorrowHistory->isNotEmpty())
                                    <div class="table-responsive">
                                        <table class="table table-bordered table-hover">
                                            <thead class="thead-light">
                                            <tr>
                                                <th>#</th>
                                                <th>Title</th>
                                                <th>Author</th>
                                                <th>BarCode</th>
                                                <th>Borrowed At</th>
                                                <th>Returned At</th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            @foreach ($allTimeBorrowHistory as $key => $borrow)
                                                <tr>
                                                    <td>{{ $key + 1 + ($allTimeBorrowHistory->currentPage() - 1) * $allTimeBorrowHistory->perPage() }}</td>
                                                    <td>{{ $borrow->book->title }}</td>
                                                    <td>{{ $borrow->book->author }}</td>
                                                    <td>{{ $borrow->book->barcode }}</td>
                                                    <td>{{ $borrow->borrowed_at }}</td>
                                                    <td>{{ $borrow->returned_at ?? 'Not returned yet' }}</td>
                                                </tr>
                                            @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                    <div class="d-flex justify-content-center mt-3">
                                        {{ $allTimeBorrowHistory->appends(['search_history' => request('search_history'), 'table' => 'history'])->links() }}
                                    </div>
                                @else
                                    <div class="alert alert-warning text-center">
                                        No borrow history found.
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
