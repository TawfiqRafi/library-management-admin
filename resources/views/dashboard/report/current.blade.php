@extends('layouts.dashboard')

@section('content')
    <div class="card shadow mt-4">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h3 class="mb-0">Currently Borrowed Books</h3>
        </div>
        <div class="card-body">
            <!-- Search Form -->
            <form class="mb-3" method="GET" action="{{ route('report.current') }}">
                <div class="input-group">
                    <input type="text" name="search" value="{{ $search }}" class="form-control" placeholder="Search by user or book title">
                    <div class="input-group-append">
                        <button type="submit" class="btn btn-primary">Search</button>
                    </div>
                </div>
            </form>

            <table class="table table-bordered table-hover">
                <thead>
                <tr>
                    <th>Sl</th>
                    <th>User</th>
                    <th>Book Title</th>
                    <th>Author</th>
                    <th>BarCode</th>
                    <th>Borrowed At</th>
                    <th>Actions</th>
                </tr>
                </thead>
                <tbody>
                @foreach ($borrowings as $key => $borrowing)
                    <tr>
                        <td>{{ $key + 1 }}</td>
                        <td>{{ $borrowing->user->name }}</td>
                        <td>{{ $borrowing->book->title }}</td>
                        <td>{{ $borrowing->book->author }}</td>
                        <td>
                            @php
                                $generator = new Picqer\Barcode\BarcodeGeneratorPNG();
                            @endphp
                            <img src="data:image/png;base64,{{ base64_encode($generator->getBarcode($borrowing->book->barcode, $generator::TYPE_CODE_128)) }}" alt="Barcode">
                            <br>{{ $borrowing->book->barcode }}
                        </td>
                        <td>{{ $borrowing->borrowed_at->format('Y-m-d H:i') }}</td>
                        <td>
                            <div class="form-group">
                                <form action="{{ route('report.return', $borrowing->id) }}" method="POST" class="return-book-form">
                                    @csrf
                                    @method('POST')
                                    <button type="submit" class="btn btn-success btn-sm" onclick="formSubmit(this, event)">Mark as Returned</button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
            @if ($borrowings->isEmpty())
                <div class="alert alert-warning text-center mt-3">
                    No borrow history found.
                </div>
            @endif
            <!-- Pagination Links -->
            <div class="d-flex justify-content-center">
                {{ $borrowings->appends(request()->query())->links() }}
            </div>
        </div>
    </div>
@endsection
