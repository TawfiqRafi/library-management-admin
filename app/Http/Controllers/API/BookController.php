<?php
namespace App\Http\Controllers\API;

use App\Helpers\Helpers;
use App\Http\Controllers\Controller;
use App\Models\Book;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class BookController extends Controller
{
    public function index()
    {
        $books = Book::all();

        return response()->json([
            'success' => true,
            'data' => $books,
            'message' => 'Book list retrieved successfully.',
        ], 200);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'required',
            'author' => 'required',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => Helpers::error_processor($validator)], 403);
        }

        $barcodeValue = 'BOOK-' . time();

        $book = new Book();
        $book->title = $request->get('title');
        $book->author = $request->get('author');
        $book->barcode = $barcodeValue;

        if ($request->hasFile('image')) {
            $path = Helpers::file_upload($request, 'image', 'book');
            $book->image = $path;
        }

        if ($book->save()) {
            return response()->json([
                'success' => true,
                'data' => $book,
                'message' => 'Book saved successfully.',
            ], 201);
        }

        return response()->json([
            'success' => false,
            'message' => 'Failed to save book.',
        ], 500);
    }

    public function show($id)
    {
        $book = Book::find($id);

        if ($book) {
            return response()->json([
                'success' => true,
                'data' => $book,
                'message' => 'Book details retrieved successfully.',
            ], 200);
        }

        return response()->json([
            'success' => false,
            'message' => 'Book not found.',
        ], 404);
    }

    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'required',
            'author' => 'required',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $book = Book::find($id);

        if (!$book) {
            return response()->json([
                'success' => false,
                'message' => 'Book not found.',
            ], 404);
        }

        $book->title = $request->get('title');
        $book->author = $request->get('author');

        if ($request->hasFile('image')) {
            if ($book->image && file_exists($book->image)) {
                unlink($book->image); // Remove old image
            }
            $path = Helpers::file_upload($request, 'image', 'book');
            $book->image = $path;
        }

        if ($book->save()) {
            return response()->json([
                'success' => true,
                'data' => $book,
                'message' => 'Book updated successfully.',
            ], 200);
        }

        return response()->json([
            'success' => false,
            'message' => 'Failed to update book.',
        ], 500);
    }

    public function destroy($id)
    {
        $book = Book::find($id);

        if (!$book) {
            return response()->json([
                'success' => false,
                'message' => 'Book not found.',
            ], 404);
        }

        if ($book->image && file_exists($book->image)) {
            unlink($book->image); // Remove associated image
        }

        if ($book->delete()) {
            return response()->json([
                'success' => true,
                'message' => 'Book deleted successfully.',
            ], 200);
        }

        return response()->json([
            'success' => false,
            'message' => 'Failed to delete book.',
        ], 500);
    }
}

