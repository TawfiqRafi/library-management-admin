<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Book;
use App\Models\Borrowing;
use App\Models\User;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        // Fetching the necessary data
        $totalBooks = Book::count();
        $availableBooks = Book::whereDoesntHave('borrowings', function($query) {
            $query->whereNull('returned_at');
        })->count();
        $assignedBooks = Borrowing::whereNull('returned_at')->count();
        $totalUsers = User::where('is_admin',0)->count();
        $assignedBookHistory = Borrowing::with('book', 'user')
            ->whereNull('returned_at')
            ->orderBy('borrowed_at', 'desc')
            ->take(5)
            ->get();

        // Merging the data to the existing $data array
        $data = [
            'page_title' => 'Dashboard',
            'totalBooks' => $totalBooks,
            'availableBooks' => $availableBooks,
            'assignedBooks' => $assignedBooks,
            'totalUsers' => $totalUsers,
            'assignedBookHistory' => $assignedBookHistory
        ];

        return view('dashboard.index')->with(array_merge($this->data, $data));
    }
}
