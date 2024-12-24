<?php

namespace App\Http\Controllers\Admin;

use App\Helpers\Helpers;
use App\Http\Controllers\Controller;
use App\Models\Book;
use App\Models\Borrowing;
use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->input('search');

        $users = User::where('is_admin',0)->when($search, function ($query, $search) {
            $query->where('name', 'like', "%$search%")
                ->orWhere('email', 'like', "%$search%");
        })->paginate(25);

        $data = [
            'page_title' => 'Users List',
            'users' => $users,
            'search' => $search
        ];

        return view('dashboard.users.index')->with(array_merge($this->data, $data));
    }

    public function show(Request $request, $id)
    {
        $search = $request->input('search');
        $user = User::findOrFail($id);

        $currentSearch = $request->input('search_current');
        $historySearch = $request->input('search_history');

        $currentBorrowedBooks = Borrowing::with('book')
            ->where('user_id', $id)
            ->whereNull('returned_at')
            ->when($currentSearch, function ($query, $currentSearch) {
                $query->whereHas('book', function ($bookQuery) use ($currentSearch) {
                    $bookQuery->where('title', 'like', "%$currentSearch%")
                        ->orWhere('author', 'like', "%$currentSearch%");
                });
            })
            ->paginate(10);

        $allTimeBorrowHistory = Borrowing::with('book')
            ->where('user_id', $id)
            ->when($historySearch, function ($query, $historySearch) {
                $query->whereHas('book', function ($bookQuery) use ($historySearch) {
                    $bookQuery->where('title', 'like', "%$historySearch%")
                        ->orWhere('author', 'like', "%$historySearch%");
                });
            })
            ->paginate(10);

        $data = [
            'page_title' => 'User Details',
            'user' => $user,
            'currentBorrowedBooks' => $currentBorrowedBooks,
            'allTimeBorrowHistory' => $allTimeBorrowHistory,
        ];
        return view('dashboard.users.show')->with(array_merge($this->data, $data));
    }

}
