<?php

namespace App\Http\Controllers;

use App\Helpers\LogHelper;
use App\Models\Book;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class BookController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): JsonResponse
    {
        LogHelper::api('Books API: Getting all books', 'info', [
            'user_id' => auth()->id(),
            'ip' => request()->ip(),
        ]);

        // keyword search
        $keyword = $request->query('search');
        $status = $request->query('status');

        // Truy vấn
        $query = Book::query();

        if (!empty($keyword)) {
            $query->where(function ($q) use ($keyword) {
                    $q
                    ->where('title', 'like', "%$keyword%");
            });
        }

        if (!empty($status)) {
            $query->where('status', $status);
        }

        // Pagination parameters
        $perPage = $request->query('perPage', 10);
        $page = $request->query('page', 1);
        
        // Validate pagination parameters
        $perPage = min(max((int) $perPage, 1), 100); // Min 1, Max 100
        $page = max((int) $page, 1); // Min 1
        
        $books = $query->paginate($perPage, ['*'], 'page', $page);
        
        return response()->json([
            'data' => $books,
            'message' => 'Books fetched successfully',
            'status' => 200,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): JsonResponse
    {
        LogHelper::api('Books API: Creating new book', 'info', [
            'user_id' => auth()->id(),
            'data' => $request->all(),
        ]);

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'author' => 'required|string|max:255',
            'isbn' => 'nullable|string|max:20',
            'published_year' => 'nullable|integer|min:1900|max:' . (date('Y') + 1),
            'cover_image' => 'nullable|file|image|max:2048',
            'price' => 'nullable|numeric|min:0',
            'stock_quantity' => 'nullable|integer|min:0',
            'status' => 'nullable|in:available,out_of_stock,discontinued',
        ]);

        if ($request->hasFile('cover_image')) {
            $validated['cover_image'] = $request->file('cover_image')->store('images', 'public');
        }

        $book = Book::create($validated);

        LogHelper::api('Books API: Book created successfully', 'info', [
            'book_id' => $book->id,
            'user_id' => auth()->id(),
        ]);

        return response()->json([
            'data' => [
                ...$book->toArray(),
                'cover_image' => $book->cover_image ? asset('storage/' . $book->cover_image) : null,
            ],
            'message' => 'Book created successfully',
            'status' => 201,
        ], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show($id): JsonResponse
    {
        LogHelper::api('Books API: Getting book by ID', 'info', [
            'book_id' => $id,
            'user_id' => auth()->id(),
        ]);

        $book = Book::findOrFail($id);
        return response()->json($book);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id): JsonResponse
    {
        LogHelper::api('Books API: Updating book', 'info', [
            'book_id' => $id,
            'user_id' => auth()->id(),
            'data' => $request->all(),
        ]);

        $book = Book::findOrFail($id);

        $validated = $request->validate([
            'title' => 'sometimes|required|string|max:255',
            'description' => 'nullable|string',
            'author' => 'sometimes|required|string|max:255',
            'isbn' => 'nullable|string|max:20',
            'published_year' => 'nullable|integer|min:1900|max:' . (date('Y') + 1),
            'cover_image' => 'nullable|string|max:255',
            'price' => 'nullable|numeric|min:0',
            'stock_quantity' => 'nullable|integer|min:0',
            'status' => 'nullable|in:available,out_of_stock,discontinued',
        ]);

        $book->update($validated);

        LogHelper::api('Books API: Book updated successfully', 'info', [
            'book_id' => $book->id,
            'user_id' => auth()->id(),
        ]);

        return response()->json($book);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id): JsonResponse
    {
        LogHelper::api('Books API: Deleting book', 'info', [
            'book_id' => $id,
            'user_id' => auth()->id(),
        ]);

        $book = Book::findOrFail($id);
        $book->delete();

        LogHelper::api('Books API: Book deleted successfully', 'info', [
            'book_id' => $id,
            'user_id' => auth()->id(),
        ]);

        return response()->json(['message' => 'Book deleted successfully', 'status' => 200]);
    }
}
