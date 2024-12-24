<?php

namespace App\Http\Controllers\Admin;

use App\Helpers\Helpers;
use App\Http\Controllers\Controller;
use App\Models\Book;
use App\Models\Borrowing;
use App\Models\User;
use Illuminate\Http\Request;

class ReportController extends Controller
{
    public function currentBorrowedBooks(Request $request)
    {
        $search = $request->input('search');

        $borrowings = Borrowing::with('user', 'book')
            ->whereNull('returned_at') // Books that are not returned
            ->when($search, function ($query, $search) {
                return $query->whereHas('user', function ($q) use ($search) {
                    $q->where('name', 'like', '%' . $search . '%');
                })
                    ->orWhereHas('book', function ($q) use ($search) {
                        $q->where('title', 'like', '%' . $search . '%')
                            ->orWhere('author', 'like', '%' . $search . '%');
                    });
            })
            ->paginate(25);

        $data = [
            'page_title' => 'Current borrowed book List',
            'borrowings' => $borrowings,
            'search' => $search,
        ];

        return view('dashboard.report.current')->with(array_merge($this->data, $data));
    }

    public function borrowHistory(Request $request)
    {
        $search = $request->input('search');

        $borrowings = Borrowing::with('user', 'book')
            ->when($search, function ($query, $search) {
                return $query->whereHas('user', function ($q) use ($search) {
                    $q->where('name', 'like', '%' . $search . '%');
                })
                    ->orWhereHas('book', function ($q) use ($search) {
                        $q->where('title', 'like', '%' . $search . '%')
                            ->orWhere('author', 'like', '%' . $search . '%');
                    });
            })
            ->paginate(25);

        $data = [
            'page_title' => 'Current borrowed book List',
            'borrowings' => $borrowings,
            'search' => $search,
        ];

        return view('dashboard.report.history')->with(array_merge($this->data, $data));
    }

    public function markAsReturned($id)
    {
        $borrowing = Borrowing::findOrFail($id);

        if ($borrowing->returned_at) {
            return response()->json([
                'type' => 'warning',
                'title' => 'Failed',
                'message' => 'This book has already been returned.'
            ]);
        }

        $borrowing->returned_at = now();

        if ($borrowing->save()) {
            return response()->json([
                'type' => 'success',
                'title' => 'Success',
                'message' => 'The book has been marked as returned.',
                'redirect' => route('report.current') // Redirect to the current report page
            ]);
        }

        return response()->json([
            'type' => 'warning',
            'title' => 'Failed',
            'message' => 'Failed to mark the book as returned.'
        ]);
    }

}
