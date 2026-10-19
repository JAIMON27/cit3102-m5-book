<?php

namespace App\Http\Controllers;

use App\Models\Book;
use Illuminate\Http\Request;

class BookController extends Controller
{
    // GET /api/books
    // Supports filtering by genre and author.
    public function index(Request $request)
    {
        $allowed = ['genre', 'author'];

        $query = Book::query();

        foreach ($allowed as $field) {
            if ($request->filled($field)) {
                $query->where($field, $request->input($field));
            }
        }

        return response()->json($query->get(), 200);
    }

    // POST /api/books
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'author' => 'required|string|max:255',
            'genre' => 'required|string|max:255',
            'pages' => 'required|integer|min:1',
        ]);

        $book = Book::create($validated);

        return response()->json($book, 201);
    }

    // GET /api/books/{book}
    public function show(Book $book)
    {
        return response()->json($book, 200);
    }

    // PUT /api/books/{book}
    public function update(Request $request, Book $book)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'author' => 'required|string|max:255',
            'genre' => 'required|string|max:255',
            'pages' => 'required|integer|min:1',
        ]);

        $book->update($validated);

        return response()->json($book, 200);
    }

    // DELETE /api/books/{book}
    public function destroy(Book $book)
    {
        $book->delete();

        return response()->json(null, 204);
    }
}
