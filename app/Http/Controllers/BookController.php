<?php

namespace App\Http\Controllers;

use App\Models\Book;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class BookController extends Controller
{
    public function index()
    {
        return view('pages.index');
    }

    public function topAuthorsView()
    {
        return view('pages.top-books');
    }

    public function bookList(Request $request)
    {
        $start = intval($request->input('start'));
        $length = intval($request->input('length'));
        $page = intval($start / $length) + 1;

        $orderColumnIndex = $request->input('order.0.column');
        $columns = $request->input('columns');
        $orderColumn = $columns[$orderColumnIndex]['data'] ?? 'avg_rating';
        $orderDir = $request->input('order.0.dir', 'desc');

        $search = $request->input('search.value');

        $query = Book::with(['author', 'category']);

        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('title', 'like', "%$search%")
                    ->orWhere('avg_rating', 'like', "%$search%")
                    ->orWhere('voter_count', 'like', "%$search%")
                    ->orWhereHas('author', function ($q2) use ($search) {
                        $q2->where('name', 'like', "%$search%");
                    })
                    ->orWhereHas('category', function ($q2) use ($search) {
                        $q2->where('name', 'like', "%$search%");
                    });
            });
        }

        if ($orderColumn === 'author.name') {
            $query->join('authors', 'authors.id', '=', 'books.author_id')
                ->orderBy('authors.name', $orderDir)
                ->select('books.*');
        } elseif ($orderColumn === 'category.name') {
            $query->join('categories', 'categories.id', '=', 'books.category_id')
                ->orderBy('categories.name', $orderDir)
                ->select('books.*');
        } else {
            $query->orderBy($orderColumn, $orderDir);
        }


        $data = $query->paginate($length, ['*'], 'page', $page);

        return response()->json([
            'recordsTotal' => $data->total(),
            'recordsFiltered' => $data->total(),
            'data' => $data->map(function ($book) {
                return [
                    'title' => $book->title,
                    'author' => [
                        'name' => $book->author->name ?? '-',
                    ],
                    'category' => [
                        'name' => $book->category->name ?? '-',
                    ],
                    'avg_rating' => number_format($book->avg_rating, 2, '.', ''),
                    'voter_count' => $book->voter_count,
                ];
            }),
        ]);
    }

    public function topAuthors(Request $request)
    {
        $search = $request->input('search.value');

        $query = DB::table('authors')
            ->join('books', 'books.author_id', '=', 'authors.id')
            ->join('ratings', 'ratings.book_id', '=', 'books.id')
            ->where('ratings.score', '>', 5)
            ->select('authors.id', 'authors.name', DB::raw('COUNT(ratings.id) as voter_count'))
            ->groupBy('authors.id', 'authors.name');

        if ($search) {
            $query->having('authors.name', 'like', '%' . $search . '%');
        }

        $authors = $query
            ->orderByDesc('voter_count')
            ->limit(10)
            ->get();

        return response()->json([
            'data' => $authors,
        ]);
    }

}
