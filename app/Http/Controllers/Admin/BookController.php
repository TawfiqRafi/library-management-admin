<?php

namespace App\Http\Controllers\Admin;

use App\Helpers\Helpers;
use App\Http\Controllers\Controller;
use App\Models\Book;
use Illuminate\Http\Request;

class BookController extends Controller
{
    public function index()
    {
        $data = [
            'page_title' => 'book List',
            'books' => Book::all()
        ];

        return view('dashboard.book.index')->with(array_merge($this->data, $data));
    }

    public function create()
    {
        $data = [
            'page_title' => 'Create new book',
        ];

        return view('dashboard.book.create')->with(array_merge($this->data, $data));
    }

    public function store(Request $request)
    {
        $rules = [
            'title' => 'required',
            'author' => 'required',
            'image' => 'required',
        ];
        //validation
        $this->validate($request, $rules);

        $barcodeValue = 'BOOK-' . time();

        $book = new Book();
        $book->title = $request->get('title');
        $book->author = $request->get('author');
        $book->barcode = $barcodeValue;
        if ($request->has('image')) {
            $path = Helpers::file_upload($request,'image','book');
        }
        $book->image = $path;


        if ($book->save()) {
            return response()->json([
                'type' => 'success',
                'title' => 'Success',
                'message' => 'book saved successfully',
                'redirect' => route('book.list')
            ]);
        }

        return response()->json([
            'type' => 'warning',
            'title' => 'Failed',
            'message' => 'book failed to save'
        ]);
    }

    public function edit($slug)
    {
        $data = [
            'page_title' => 'Update book',
            'book' => Book::where('slug',$slug)->first()
        ];

        return view('dashboard.book.edit')->with(array_merge($this->data, $data));
    }

    public function update(Request $request, $slug)
    {
        $rules = [
            'title' => 'required',
            'author' => 'required',
        ];
        //validation
        $this->validate($request, $rules);

        $book = Book::where('slug',$slug)->first();
        $book->title = $request->get('title');
        $book->author = $request->get('author');
        if ($request->has('image')) {
            if (isset($book) && $book->image) {
                unlink($book->image);
            }
            $path = Helpers::file_upload($request,'image','book');
            $book->image = $path;
        }


        if ($book->save()) {
            return response()->json([
                'type' => 'success',
                'title' => 'Success',
                'message' => 'book updated successfully',
                'redirect' => route('book.list')
            ]);
        }

        return response()->json([
            'type' => 'warning',
            'title' => 'Failed',
            'message' => 'book failed to update'
        ]);
    }

    public function destroy($slug)
    {
        $book = Book::where('slug',$slug)->first();
        if($book->delete()){
            return response()->json([
                'type' => 'success',
                'title' => 'Deleted',
                'message' => 'book has been deleted',
            ]);
        }

        return response()->json([
            'type' => 'error',
            'title' => 'Failed',
            'message' => 'Failed to delete book',
        ]);

    }
}
