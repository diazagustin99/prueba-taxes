<?php

namespace App\Http\Controllers;

use App\Models\Review;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ReviewsController extends Controller
{
    public function index(Request $request)
    {
        $this->validate($request, [
            'id_book'=>'required|exists:books,id'
        ]);

        $reviews = Review::where('book_id', $request->id_book)->get();
        return response()->json($reviews);
    }

    public function show(Request $request)
    {
        $this->validate($request, [
            'id'=> 'required|exists:reviews,id'
        ]);
        $review = Review::find($request->id);

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
            'rating' => 'required|integer|between:1,5',
        ]);

        $idLogin = Auth::id();

        $existingReview = Review::where('user_id', $idLogin)
            ->where('book_id', $request->book_id)
            ->first();

        if ($existingReview) {
            return response()->json(['error' => 'Ya has registrado una reseña para este libro'], 400);
        }

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
            'review_text' => 'sometimes|required|string',
            'rating' => 'sometimes|required|between:1,5',
            'id'=> 'required|exists:reviews,id'
        ]);
        $review = Review::find($request->id);

        if (!$review) {
            return response()->json(['error' => 'Revisión no encontrada'], 404);
        }

        if (Auth::id() !== $review->user_id) {
            return response()->json(['error' => 'No tienes permiso para modificar esta revisión'], 403);
        }

        $review->update($request->except('id'));
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

        if (Auth::id() !== $review->user_id) {
            return response()->json(['error' => 'No tienes permiso para eliminar esta revisión'], 403);
        }

        $review->delete();

        return response()->json(['message' => 'Revisión eliminada con éxito']);
    }
}
