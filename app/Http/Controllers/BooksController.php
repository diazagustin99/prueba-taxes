<?php

namespace App\Http\Controllers;

use App\Models\Book;
use Illuminate\Http\Request;

class BooksController extends Controller
{
    public function index()
    {
        $books = Book::all();
        return response()->json($books);
    }

    public function show($id)
    {
        $book = Book::find($id);

        if (!$book) {
            return response()->json(['error' => 'Libro no encontrado'], 404);
        }

        return response()->json($book);
    }

    public function create(Request $request)
    {
        $request->validate([
            'title' => 'required|string|unique:books',
            'author' => 'required|string',
            'publication_date' => 'required|date',
        ]);

        $book = Book::create($request->all());

        return response()->json($book, 201);
    }

    public function update(Request $request, $id)
    {
        $book = Book::find($id);

        if (!$book) {
            return response()->json(['error' => 'Libro no encontrado'], 404);
        }

        $request->validate([
            'title' => 'required|string',
            'author' => 'required|string',
            'publication_date' => 'required|date',
        ]);

        $book->update($request->all());

        return response()->json($book);
    }

    public function destroy($id)
    {
        $book = Book::find($id);

        if (!$book) {
            return response()->json(['error' => 'Libro no encontrado'], 404);
        }

        $book->delete();
        return response()->json(['message' => 'Libro eliminado con éxito']);
    }

    public function search(Request $request)
    {
        $title = $request->input('title');
        $author = $request->input('author');
        $publicationDate = $request->input('publication_date');

        $books = Book::when($title, function ($query, $title) {
                return $query->where('title', 'LIKE', "%$title%");
            })
            ->when($author, function ($query, $author) {
                return $query->where('author', 'LIKE', "%$author%");
            })
            ->when($publicationDate, function ($query, $publicationDate) {
                return $query->where('publication_date', 'LIKE', "%$publicationDate%");
            })
            ->get();

        return response()->json($books);
    }
}
