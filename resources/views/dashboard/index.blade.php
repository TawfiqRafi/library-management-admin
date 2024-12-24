@extends('layouts.dashboard')

@section('content')
    <div class="container-fluid">
        <div class="row">
            <!-- Total Books -->
            <div class="col-md-3">
                <a href="{{ route('book.list') }}" class="card shadow-sm text-decoration-none hover-card">
                    <div class="card-header d-flex align-items-center">
                        <i class="bx bx-bookmark bx-sm mr-2"></i>
                        <span>Total Books</span>
                    </div>
                    <div class="card-body text-center">
                        <h5 class="card-title">{{ $totalBooks }}</h5>
                    </div>
                </a>
            </div>

            <!-- Available Books -->
            <div class="col-md-3">
                <a href="{{ route('book.available') }}" class="card shadow-sm text-decoration-none hover-card">
                    <div class="card-header d-flex align-items-center">
                        <i class="bx bx-check bx-sm mr-2"></i>
                        <span>Available Books</span>
                    </div>
                    <div class="card-body text-center">
                        <h5 class="card-title">{{ $availableBooks }}</h5>
                    </div>
                </a>
            </div>

            <!-- Assigned Books -->
            <div class="col-md-3">
                <a href="{{ route('report.current') }}" class="card shadow-sm text-decoration-none hover-card">
                    <div class="card-header d-flex align-items-center">
                        <i class="bx bx-book-reader bx-sm mr-2"></i>
                        <span>Assigned Books</span>
                    </div>
                    <div class="card-body text-center">
                        <h5 class="card-title">{{ $assignedBooks }}</h5>
                    </div>
                </a>
            </div>

            <!-- Total Users -->
            <div class="col-md-3">
                <a href="{{ route('users.index') }}" class="card shadow-sm text-decoration-none hover-card">
                    <div class="card-header d-flex align-items-center">
                        <i class="bx bx-user bx-sm mr-2"></i>
                        <span>Total Users</span>
                    </div>
                    <div class="card-body text-center">
                        <h5 class="card-title">{{ $totalUsers }}</h5>
                    </div>
                </a>
            </div>
        </div>



        <!-- Assigned Book History -->
        <div class="row mt-4">
            <div class="col-md-12">
                <div class="card shadow-sm">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <!-- Title Section -->
                        <div class="d-flex align-items-center">
                            <i class="bx bx-history bx-sm mr-2"></i>
                            <span>Currently Assigned Book History</span>
                        </div>

                        <!-- Link Section -->
                        <div>
                            <a href="{{ route('report.current') }}" class="btn btn-info btn-sm">View All</a>
                        </div>
                    </div>
                    <div class="card-body">
                        <table class="table table-bordered">
                            <thead>
                            <tr>
                                <th>Sl</th>
                                <th>Book Title</th>
                                <th>BarCode</th>
                                <th>Assigned To</th>
                                <th>Assigned Date</th>
                                <th>Last Page</th>
                                <th>Actions</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach ($assignedBookHistory as $key => $history)
                                <tr>
                                    <td>{{ $key+1 }}</td>
                                    <td>{{ $history->book->title }}</td>
                                    <td>
                                        @php
                                            $generator = new Picqer\Barcode\BarcodeGeneratorPNG();
                                        @endphp
                                        <img src="data:image/png;base64,{{ base64_encode($generator->getBarcode($history->book->barcode, $generator::TYPE_CODE_128)) }}" alt="Barcode">
                                        <br>{{ $history->book->barcode }}
                                    </td>
                                    <td>{{ $history->user->name }}</td>
                                    <td>{{ $history->borrowed_at->format('d M, Y') }}</td>
                                    <td>{{ $history->last_page }}</td>
                                    <td>
                                        <div class="form-group">
                                            <form action="{{ route('report.return', $history->id) }}" method="POST" class="return-book-form">
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
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
