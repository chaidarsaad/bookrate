<?php

namespace App\Http\Controllers;

use App\Models\Author;
use App\Models\Book;
use App\Models\Rating;
use Illuminate\Http\Request;

class RatingController extends Controller
{
    public function create()
    {
        $authors = Author::inRandomOrder()->limit(20)->get(['id', 'name']);
        return view('pages.create-rating', compact('authors'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'author_id' => 'required|exists:authors,id',
            'book_id' => 'required|exists:books,id',
            'score' => 'required|integer|min:1|max:10',
        ]);

        Rating::create([
            'book_id' => $request->book_id,
            'score' => $request->score,
        ]);

        return redirect()->route('home')->with('success', 'Rating berhasil ditambahkan');
    }

    public function searchAuthors(Request $request)
    {
        $search = $request->input('q');

        $query = Author::query();

        if ($search) {
            $query->where('name', 'like', "%$search%");
        }

        $authors = $query->orderBy('name')
            ->limit(20)
            ->get(['id', 'name as text']);

        return response()->json(['results' => $authors]);
    }


    public function searchBooks(Request $request, $authorId)
    {
        $search = $request->get('q', '');

        return Book::where('author_id', $authorId)
            ->where('title', 'like', '%' . $search . '%')
            ->orderBy('title')
            ->limit(20)
            ->get(['id', 'title']);
    }
}
