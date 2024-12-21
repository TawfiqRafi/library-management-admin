<?php
namespace App\Http\Controllers\API;

use App\Helpers\Helpers;
use App\Http\Controllers\Controller;
use App\Models\Book;
use App\Models\Borrowing;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class LibraryController extends Controller
{
    // Borrow a Book
    public function borrowBook(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'barcode' => 'required|string',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => Helpers::error_processor($validator)], 403);
        }

        $user = auth()->user();
        $book = Book::where('barcode', $request->barcode)->first();

        if (!$book) {
            return response()->json(['message' => 'Book not found'], 404);
        }

        // Check if the book is already borrowed
        $isBorrowed = Borrowing::where('book_id', $book->id)
            ->whereNull('returned_at')
            ->exists();

        if ($isBorrowed) {
            return response()->json(['message' => 'Book is already borrowed'], 400);
        }

        // Create a new borrowing record
        Borrowing::create([
            'user_id' => $user->id,
            'book_id' => $book->id,
            'borrowed_at' => now(),
        ]);

        return response()->json(['message' => 'Book borrowed successfully'], 200);
    }

    // Return a Book
    public function returnBook(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'barcode' => 'required|string',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => Helpers::error_processor($validator)], 403);
        }

        $user = auth()->user();
        $book = Book::where('barcode', $request->barcode)->first();

        if (!$book) {
            return response()->json(['message' => 'Book not found'], 404);
        }

        $borrowing = Borrowing::where('book_id', $book->id)
            ->where('user_id', $user->id)
            ->whereNull('returned_at')
            ->first();

        if (!$borrowing) {
            return response()->json(['message' => 'No active borrowing found for this book'], 404);
        }

        // Mark the book as returned
        $borrowing->returned_at = now();
        $borrowing->save();

        return response()->json(['message' => 'Book returned successfully'], 200);
    }

    // Update Last Page
    public function updateLastPage(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'barcode' => 'required|string',
            'last_page' => 'required|integer',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => Helpers::error_processor($validator)], 403);
        }

        $user = auth()->user();
        $book = Book::where('barcode', $request->barcode)->first();

        if (!$book) {
            return response()->json(['message' => 'Book not found'], 404);
        }

        $borrowing = Borrowing::where('book_id', $book->id)
            ->where('user_id', $user->id)
            ->whereNull('returned_at')
            ->first();

        if (!$borrowing) {
            return response()->json(['message' => 'No active borrowing found for this book'], 404);
        }

        $borrowing->last_page = $request->last_page;
        $borrowing->save();

        return response()->json(['message' => 'Last page updated successfully'], 200);
    }

    // Available Books
    public function availableBooks()
    {
        $books = Book::whereDoesntHave('borrowings', function ($query) {
            $query->whereNull('returned_at');
        })->get();

        return response()->json(['available_books' => $books], 200);
    }

    // Current Borrowed Books
    public function currentBorrowedBooks()
    {
        $user = auth()->user();

        $currentBorrowedBooks = Borrowing::with('book')
            ->where('user_id', $user->id)
            ->whereNull('returned_at')
            ->get();

        return response()->json(['current_borrowed_books' => $currentBorrowedBooks], 200);
    }

    // Borrowing History
    public function borrowingHistory()
    {
        $user = auth()->user();

        $history = Borrowing::with('book')
            ->where('user_id', $user->id)
            ->orderBy('borrowed_at', 'desc')
            ->get();

        return response()->json(['history' => $history], 200);
    }
}
