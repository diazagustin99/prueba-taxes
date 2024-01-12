<?php

namespace App\Http\Controllers;

use App\Models\Review;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ReviewsController extends Controller
{
    public function index()
    {
        $reviews = Review::all();
        return response()->json($reviews);
    }

    public function show($id)
    {
        $review = Review::find($id);

        if (!$review) {
            return response()->json(['error' => 'Revisión no encontrada'], 404);
        }

        return response()->json($review);
    }

    public function store(Request $request)
    {
        $request->validate([
            'book_id' => 'required|exists:books,id',
            'review_text' => 'required|string',
            'rating' => 'required|integer',
        ]);
        $idLogin = Auth::id();
        $review = Review::create([
            'user_id' => $idLogin,
            'book_id' => $request->book_id,
            'review_text' => $request->review_text,
            'rating' => $request->rating,
        ]);

        return response()->json($review, 201);
    }

    public function update(Request $request)
    {
        $request->validate([
            'book_id' => 'required|exists:books,id',
            'review_text' => 'required|string',
            'rating' => 'required|integer',
            'id'=> 'required|exists:reviews,id'
        ]);
        $review = Review::find($request->id);

        if (!$review) {
            return response()->json(['error' => 'Revisión no encontrada'], 404);
        }

        // Verificar si el usuario actual es el creador de la revisión
        $idLogin = Auth::id();
        if (Auth::id() !== $review->user_id) {
            return response()->json(['error' => 'No tienes permiso para modificar esta revisión'], 403);
        }

        $review->update([
            'user_id' => $idLogin,
            'book_id' => $request->book_id,
            'review_text' => $request->review_text,
            'rating' => $request->rating,
        ]);

        return response()->json($review);
    }

    public function destroy(Request $request)
    {
        $this->validate($request, [
            'id'=> 'required|exists:reviews,id'
        ]);

        $review = Review::find($request->id);

        if (!$review) {
            return response()->json(['error' => 'Revisión no encontrada'], 404);
        }


        // Verificar si el usuario actual es el creador de la revisión
        if (Auth::id() !== $review->user_id) {
            return response()->json(['error' => 'No tienes permiso para eliminar esta revisión'], 403);
        }

        $review->delete();

        return response()->json(['message' => 'Revisión eliminada con éxito']);
    }
}
