@extends('layouts.dashboard')

@section('content')
    <div class="box">
        <div class="box-header with-action">
            <h3 class="box-title">Book List</h3>
            <a href="{{ route('book.create') }}" class="btn btn-sm btn-secondary float-right">Create new</a>
        </div>
        <div class="box-body">
            <table class="table table-bordered table-hover table-responsive-lg">
                <thead>
                <tr>
                    <th>#</th>
                    <th>Title</th>
                    <th>Image</th>
                    <th>Short Description</th>
                    <th></th>
                </tr>
                </thead>
                <tbody>
                @if($books->isNotEmpty())
                    @foreach ($books as $key => $book)
                        <tr>
                            <td>{{ $key+1 }}</td>
                            <td>{{ $book->title }}</td>
                            <td>
                                @if($book->image)
                                <img src="{{ asset($book->image) }}" alt="" width="40px">
                                @endif
                            </td>
                            <td>{{ $book->short_description }}</td>
                            <td>
                                <div class="action-el">
                                    <a href="{{ route('book.edit', $book->slug) }}" class="btn btn-warning">
                                        <i class="bx bx-edit"></i>
                                    </a>
                                    {!! Form::open(['route' => ['book.destroy', $book->slug], 'method' => 'DELETE', 'class'=>'action-el']) !!}
                                    <button type="submit" class="btn btn-danger custom-btn-sm" onclick="deleteSubmit(this, event)" data-toggle="tooltip" title="Delete" data-placement="top">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                    {!! Form::close() !!}
                                </div>
                            </td>
                        </tr>
                    @endforeach
                @else
                    <tr>
                        <td colspan="5">No book found</td>
                    </tr>
                @endif
                </tbody>
            </table>
        </div>
        <div class="box-footer">
        </div>
    </div>

@endsection
