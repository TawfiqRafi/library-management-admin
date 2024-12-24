@extends('layouts.dashboard')

@section('content')
    <div class="mt-4">
        <div class="card shadow">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h3 class="mb-0">Available Book List</h3>
                <a href="{{ route('book.create') }}" class="btn btn-sm btn-secondary">Create new</a>
            </div>
            <div class="card-body">
                <!-- Search Form -->
                <form method="GET" action="{{ route('book.list') }}" class="mb-3">
                    <div class="input-group">
                        <input
                            type="text"
                            name="search"
                            value="{{ request('search') }}"
                            class="form-control"
                            placeholder="Search books"
                            aria-label="Search books">
                        <div class="input-group-append">
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-search"></i> Search
                            </button>
                        </div>
                    </div>
                </form>

                <div class="table-responsive">
                    <table class="table table-bordered table-hover">
                        <thead class="thead-dark">
                        <tr>
                            <th>#</th>
                            <th>Title</th>
                            <th>Image</th>
                            <th>Author</th>
                            <th>Barcode</th>
                            <th class="text-center">Actions</th>
                        </tr>
                        </thead>
                        <tbody>
                        @if($books->isNotEmpty())
                            @foreach ($books as $key => $book)
                                <tr>
                                    <th scope="row">{{ $key + 1 + ($books->currentPage() - 1) * $books->perPage() }}</th>
                                    <td>{{ $book->title }}</td>
                                    <td>
                                        @if($book->image)
                                            <img src="{{ asset($book->image) }}" alt="" width="40px">
                                        @endif
                                    </td>
                                    <td>{{ $book->author }}</td>
                                    <td>
                                        @php
                                            $generator = new Picqer\Barcode\BarcodeGeneratorPNG();
                                        @endphp
                                        <img src="data:image/png;base64,{{ base64_encode($generator->getBarcode($book->barcode, $generator::TYPE_CODE_128)) }}" alt="Barcode">
                                        <br>{{ $book->barcode }}
                                    </td>
                                    <td class="text-center">
                                        <a href="{{ route('book.edit', $book->slug) }}" class="btn btn-sm btn-warning">
                                            <i class="fas fa-edit"></i> Edit
                                        </a>
                                        {!! Form::open(['route' => ['book.destroy', $book->slug], 'method' => 'DELETE', 'class'=>'d-inline']) !!}
                                        <button type="submit" class="btn btn-sm btn-danger" onclick="deleteSubmit(this, event)" data-toggle="tooltip" title="Delete" data-placement="top">
                                            <i class="fas fa-trash"></i> Delete
                                        </button>
                                        {!! Form::close() !!}
                                    </td>
                                </tr>
                            @endforeach
                        @else
                            <tr>
                                <td colspan="6" class="text-center">No book found</td>
                            </tr>
                        @endif
                        </tbody>
                    </table>
                </div>

                <div class="d-flex justify-content-center mt-3">
                    {{ $books->appends(request()->query())->links() }}
                </div>
            </div>
        </div>
    </div>
@endsection
