<?php

namespace App\Http\Controllers;

use App\Http\Resources\CategoryResource;
use App\Models\Admin;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
     return CategoryResource::collection(Category::latest()->paginate());   
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        Gate::authorize('create', Category::class);

        $data = $request->validate([
            'name' => 'required|string|min:1|max:200'
        ]);

        $category = Category::create([
            ...$data,
            'user_id' => $request->user()->id
        ]);

        return new CategoryResource($category);
    }

    /**
     * Display the specified resource.
     */
    public function show(Category $category)
    {
        return new CategoryResource($category);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Category $category)
    {
        Gate::authorize('update', $category);

        $data = $request->validate([
            'name' => 'required|string|min:1|max:200'
        ]);

        $category->update([
            ...$data,
            'user_id' => $request->user()->id
        ]);


        return new CategoryResource($category);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Category $category)
    {
        Gate::authorize('delete', $category);

        $category->delete();

        return response()->json([
            'success' => 'Category is deleted successfully'
        ]);
    }
}
